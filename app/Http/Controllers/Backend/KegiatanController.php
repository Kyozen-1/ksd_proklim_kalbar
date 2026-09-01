<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Mews\Purifier\Facades\Purifier;
use RealRashid\SweetAlert\Facades\Alert;
use Intervention\Image\Laravel\Facades\Image;
use App\Contracts\FileStorageInterface;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Auth;
use DataTables;
use App\Models\Kegiatan;
use App\Models\PivotGambarKegiatan;
use App\Models\PivotAnggotaKegiatan;
use App\Models\AnggotaPelaksana;
use App\Models\Regency;

class KegiatanController extends Controller
{
    public function index()
    {
        return view('backend.kegiatan.index');
    }

    public function datatable()
    {
        $getData = new Kegiatan;
        $getData = $getData->statusAktif();
        $getData = $getData->get();

        $data = [];
        foreach ($getData as $d) {
            $data[] = [
                'id' => Crypt::encryptString($d->id),
                'judul' => $d->judul,
                'tanggal' => $d->tanggal
            ];
        }

        $data = collect($data);

        return DataTables::collection($data)
            ->addIndexColumn()
            ->addColumn('aksi', function($data){
                $id = $data['id'];
                $button_edit = '<a href="'.route('cms.kegiatan.edit', ['id' => $id]).'" class="edit btn btn-icon waves-effect btn-warning" title="Edit Data"><i class="fas fa-edit"></i></a>';
                $button_delete = '<button type="button" name="delete" id="'.$id.'" class="delete btn btn-icon waves-effect btn-danger" title="Delete Data"><i class="fas fa-trash"></i></button>';
                $button = $button_edit . ' ' . $button_delete;
                return $button;
            })
            ->addColumn('tanggal', function($data){
                return Carbon::parse($data['tanggal'])->format('d-m-Y');
            })
            ->rawColumns(['aksi'])
        ->make(true);
    }

    public function create()
    {
        return view('backend.kegiatan.create', [
            'anggotaPelaksanas' => $this->getAnggotaPelaksana(),
            'kabupatenKotas' => $this->getKabupatenKota()
        ]);
    }

    public function getAnggotaPelaksana()
    {
        $getData = AnggotaPelaksana::statusAktif()
                    ->get()
                    ->map(function($d){
                        return [
                            'id' => Crypt::encryptString($d->id),
                            'nama' => $d->nama,
                            'foto' => $d->foto_path
                        ];
                    });
        return $getData;
    }

    public function getKabupatenKota()
    {
        $getData = Regency::get()
                    ->map(function($d){
                        return [
                            'id' => Crypt::encryptString($d->id),
                            'nama' => $d->name
                        ];
                    });
        return $getData;
    }

    public function store(Request $request, FileStorageInterface $storage)
    {
        $request->validate([
            'judul' => 'required',
            'tanggal' => 'required',
            'anggota_pelaksana' => 'required',
            'kabupaten_kota_id' => 'required',
            'tempat' => 'required',
            'alamat' => 'required',
            'deskripsi' => 'required',
            'gambar.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        try {
            $kegiatan = new Kegiatan;
            $kegiatan->user_id = Auth::user()->id;
            $kegiatan->kabupaten_kota_id = Crypt::decryptString($request->kabupaten_kota_id);
            $kegiatan->judul = $request->judul;
            $kegiatan->deskripsi = Purifier::clean($request->deskripsi,'news');
            if($request->link_yt)
            {
                $kegiatan->link_yt = $this->parseLinkYt($request->link_yt);
            }
            $kegiatan->tanggal = $request->tanggal;
            $kegiatan->tempat = $request->tempat;
            $kegiatan->alamat = $request->alamat;
            $kegiatan->save();

            if ($request->hasFile('gambar')) {

                $destinationPath = 'kegiatan';

                foreach ($request->file('gambar') as $file) {

                    $path = $storage->upload(
                        $file,
                        $destinationPath
                    );

                    $pivot = new PivotGambarKegiatan;
                    $pivot->kegiatan_id = $kegiatan->id;
                    $pivot->nama = basename($file);
                    $pivot->image_path = $path;
                    $pivot->save();
                }
            }

            $anggotaKegiatan = $request->anggota_pelaksana;
            for ($i=0; $i < count($anggotaKegiatan); $i++) {
                $anggota = new PivotAnggotaKegiatan;
                $anggota->kegiatan_id = $kegiatan->id;
                $anggota->anggota_pelaksana_id = Crypt::decryptString($anggotaKegiatan[$i]);
                $anggota->save();
            }

            Alert::success('Berhasil', 'Kegiatan berhasil disimpan');
            return redirect()->route('cms.kegiatan.index');
        } catch (\Throwable $th) {
            return back()->with('failed', $th->getMessage());
        }
    }

    public function parseLinkYt($urlYt)
    {
        $youtubeId = null;

        $url = trim($urlYt);

        // youtube.com/watch?v=...
        $parsedUrl = parse_url($url);

        if (isset($parsedUrl['query'])) {
            parse_str($parsedUrl['query'], $query);

            if (!empty($query['v'])) {
                $youtubeId = $query['v'];
            }
        }

        // youtu.be/...
        if (!$youtubeId && isset($parsedUrl['host'])) {
            $host = strtolower($parsedUrl['host']);

            if ($host === 'youtu.be') {
                $youtubeId = trim($parsedUrl['path'], '/');
            }
        }

        // youtube.com/embed/...
        if (!$youtubeId && isset($parsedUrl['path'])) {
            if (preg_match(
                '#^/embed/([a-zA-Z0-9_-]{11})#',
                $parsedUrl['path'],
                $matches
            )) {
                $youtubeId = $matches[1];
            }
        }

        if (!$youtubeId) {
            throw new \InvalidArgumentException('Invalid YouTube URL');
        }

        return 'https://www.youtube.com/embed/' . $youtubeId;
    }

    public function edit($id)
    {
        $id = Crypt::decryptString($id);

        $getData = Kegiatan::find($id);
        $gambar = $getData->pivot_gambar_kegiatan
                    ->map(function ($item) {
                        return [
                            'id' => $item->id,
                            'source' => $item->gambar_url,
                            'path'   => $item->image_path
                        ];
                    });
        $anggotaPelaksana = [];
        foreach ($getData->pivot_anggota_kegiatan as $anggota) {
            $anggotaPelaksana[] = $anggota->anggota_pelaksana->nama;
        }

        $data = [
            'judul' => $getData->judul,
            'deskripsi' => $getData->deskripsi,
            'link_yt' => $getData->link_yt,
            'tanggal' => $getData->tanggal,
            'tempat' => $getData->tempat,
            'alamat' => $getData->alamat,
            'kabupaten_kota' => $getData->kabupaten_kota->name,
            'gambar' => $gambar,
            'anggota_pelaksana' => $anggotaPelaksana
        ];
        return view('backend.kegiatan.edit',[
            'id' => Crypt::encryptString($id),
            'kegiatan' => $data,
            'anggotaPelaksanas' => $this->getAnggotaPelaksana(),
            'kabupatenKotas' => $this->getKabupatenKota()
        ]);
    }

    public function update(Request $request, $id, FileStorageInterface $storage)
    {
        $request->validate([
            'judul' => 'required',
            'tanggal' => 'required',
            'anggota_pelaksana' => 'required',
            'kabupaten_kota_id' => 'required',
            'tempat' => 'required',
            'alamat' => 'required',
            'deskripsi' => 'required',
            'gambar.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        try {
            $id = Crypt::decryptString($id);
            $kegiatan = Kegiatan::find($id);
            $kegiatan->kabupaten_kota_id = Crypt::decryptString($request->kabupaten_kota_id);
            $kegiatan->judul = $request->judul;
            $kegiatan->deskripsi = Purifier::clean($request->deskripsi,'news');
            $kegiatan->link_yt = $this->parseLinkYt($request->link_yt);
            $kegiatan->tanggal = $request->tanggal;
            $kegiatan->tempat = $request->tempat;
            $kegiatan->alamat = $request->alamat;
            $kegiatan->save();

            $existingImages = $request->input(
                                    'existing_images',
                                    []
                                );

            $newImages = [];

            if ($request->hasFile('gambar')) {

                foreach ($request->file('gambar') as $file) {
                    $path = $storage->upload(
                        $file,
                        'kegiatan'
                    );

                    $newImages[] = $path;
                }
            }

            $finalImages = array_merge(
                $existingImages,
                $newImages
            );

            $oldImages = $kegiatan
                        ->pivot_gambar_kegiatan
                        ->pluck('image_path')
                        ->toArray();

            $deletedImages = array_diff(
                                $oldImages,
                                $finalImages
                            );

            PivotGambarKegiatan::where(
                'kegiatan_id',
                $id
            )->delete();

            foreach ($finalImages as $image) {
                $pivot = new PivotGambarKegiatan;
                $pivot->kegiatan_id = $kegiatan->id;
                $pivot->nama = basename($image);
                $pivot->image_path = $image;
                $pivot->save();
            }

            foreach ($deletedImages as $image) {
                $storage->delete(
                    $image
                );
            }

            foreach ($kegiatan->pivot_anggota_kegiatan as $anggota) {
                PivotAnggotaKegiatan::find($anggota->id)->delete();
            }

            $anggotaKegiatan = $request->anggota_pelaksana;
            for ($i=0; $i < count($anggotaKegiatan); $i++) {
                $anggota = new PivotAnggotaKegiatan;
                $anggota->kegiatan_id = $kegiatan->id;
                $anggota->anggota_pelaksana_id = Crypt::decryptString($anggotaKegiatan[$i]);
                $anggota->save();
            }

            Alert::success('Berhasil', 'kegiatan berhasil diubah');
            return redirect()->route('cms.kegiatan.index');
        } catch (\Throwable $th) {
            return back()->with('failed', $th->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $id = Crypt::decryptString($id);
            $kegiatan = Kegiatan::find($id);
            $kegiatan->status_aktif = '0';
            $kegiatan->save();

            return response()->json(['success' => 'Berhasil menghapus data']);
        } catch (\Throwable $th) {
            return response()->json(['errors' => $th->getMessage()]);
        }
    }

    public function gambar($id)
    {
        $id = Crypt::decryptString($id);
        $gambar = PivotGambarKegiatan::findOrFail($id);

        if (!$gambar->image_path) {
            abort(404);
        }

        if (!Storage::disk('minio')->exists($gambar->image_path)) {
            abort(404);
        }

        return Storage::disk('minio')->response($gambar->image_path);
    }
}
