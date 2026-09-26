<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;
use Validator;
use DataTables;
use Auth;
use App\Models\DataProklim;
use App\Models\Regency;
use App\Models\District;
use App\Models\Village;
use App\Models\MdKategoriProklim;

class ProklimController extends Controller
{
    public function index()
    {
        return view('backend.proklim.index',[
            'kategoriProklims' => $this->getKategoriProklim(),
            'kabupatenKotas' => $this->getKabupatenKota()
        ]);
    }

    public function getKategoriProklim()
    {
        $getData = MdKategoriProklim::get()
                    ->map(function($d){
                        return [
                            'id' => Crypt::encryptString($d->id),
                            'nama' => $d->nama
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

    public function getKecamatan(Request $request)
    {
        $kabupatenKotaId = Crypt::decryptString($request->id);
        $getDatas = District::where('regency_id', $kabupatenKotaId)->get();
        $data = [];
        foreach ($getDatas as $getData) {
            $data[] = [
                'id' => Crypt::encryptString($getData->id),
                'nama' => $getData->name
            ];
        }

        return $data;
    }

    public function getKelurahan(Request $request)
    {
        $kecamatanId = Crypt::decryptString($request->id);
        $getDatas = Village::where('district_id', $kecamatanId)->get();
        $data = [];
        foreach ($getDatas as $getData) {
            $data[] = [
                'id' => Crypt::encryptString($getData->id),
                'nama' => $getData->name
            ];
        }

        return $data;
    }

    public function datatable(Request $request)
    {
        $getDatas = DataProklim::statusAktif()
                    ->when($request->kabupaten_kota_id != null, function($q) use ($request){
                        $kabupatenKotaId = Crypt::decryptString($request->kabupaten_kota_id);
                        $q->where('kabupaten_kota_id', $kabupatenKotaId);
                    })
                    ->when($request->kecamatan_id != null, function($q) use ($request){
                        $kecamatanId = Crypt::decryptString($request->kecamatan_id);
                        $q->where('kecamatan_id', $kecamatanId);
                    })
                    ->when($request->kelurahan_id != null, function($q) use ($request){
                        $kelurahanId = Crypt::decryptString($request->kelurahan_id);
                        $q->where('kelurahan_id', $kelurahanId);
                    })
                    ->when($request->kategori_proklim_id != null, function($q) use ($request){
                        $kategoriProklimId = Crypt::decryptString($request->kategori_proklim_id);
                        $q->where('kategori_proklim_id', $kategoriProklimId);
                    })
                    ->when($request->tahun != null, function($q) use ($request){
                        $q->whereYear('tanggal_aktif', $request->tahun);
                    })
                    ->get();
        $data = [];
        foreach ($getDatas as $getData) {
            $data[] = [
                'id' => Crypt::encryptString($getData->id),
                'kabupaten_kota_id' => $getData->kabupaten_kota->name,
                'kecamatan_id' => $getData->kecamatan->name,
                'kelurahan_id' => $getData->kelurahan->name,
                'kategori_proklim_id' => $getData->kategori_proklim->nama,
                'nama' => $getData->nama,
                'tanggal_aktif' => Carbon::parse($getData->tanggal_aktif)->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('j F Y')
            ];
        }

        $data = collect($data);

        return DataTables::collection($data)
            ->addIndexColumn()
            ->addColumn('aksi', function($data){
                $id = $data['id'];
                $button_show = '<button type="button" name="detail" id="'.$id.'" class="detail btn btn-icon waves-effect btn-success" title="Detail Data"><i class="fas fa-eye"></i></button>';
                $button_edit = '<button type="button" name="edit" id="'.$id.'" class="edit btn btn-icon waves-effect btn-warning" title="Edit Data"><i class="fas fa-edit"></i></button>';
                $button_delete = '<button type="button" name="delete" id="'.$id.'" class="delete btn btn-icon waves-effect btn-danger" title="Delete Data"><i class="fas fa-trash"></i></button>';
                $button = $button_show . ' ' . $button_edit . ' ' . $button_delete;
                return $button;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'kabupaten_kota_id' => 'required',
                'kecamatan_id' => 'required',
                'kelurahan_id' => 'required',
                'kategori_proklim_id' => 'required',
                'nama' => 'required|string',
                'deskripsi' => 'required|string',
                'alamat' => 'required|string',
                'lng' => 'required|string',
                'lat' => 'required|string',
                'tanggal_aktif' => 'required|date',
            ], [
                'kabupaten_kota_id.required' => 'Kabupaten / Kota wajib dipilih.',
                'kecamatan_id.required' => 'Kecamatan wajib dipilih.',
                'kelurahan_id.required' => 'Kelurahan wajib dipilih.',
                'kategori_proklim_id.required' => 'Kategori Proklim wajib dipilih.',
                'nama.required' => 'Nama Proklim wajib diisi.',
                'deskripsi.required' => 'Deskripsi wajib diisi.',
                'alamat.required' => 'Alamat wajib diisi.',
                'lng.required' => 'Longitude wajib ditentukan melalui peta.',
                'lat.required' => 'Latitude wajib ditentukan melalui peta.',
                'tanggal_aktif.required' => 'Tanggal aktif wajib diisi.',
                'tanggal_aktif.date' => 'Format tanggal aktif tidak valid.',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'errors' => implode('<br>', $validator->errors()->all())
                ], 422);
            }

            $kabupatenKotaId = Crypt::decryptString($request->kabupaten_kota_id);
            $kecamatanId = Crypt::decryptString($request->kecamatan_id);
            $kelurahanId = Crypt::decryptString($request->kelurahan_id);
            $kategoriProklimId = Crypt::decryptString($request->kategori_proklim_id);

            $dataProklim = new DataProklim();
            $dataProklim->user_id = Auth::user()->id;
            $dataProklim->kabupaten_kota_id = $kabupatenKotaId;
            $dataProklim->kecamatan_id = $kecamatanId;
            $dataProklim->kelurahan_id = $kelurahanId;
            $dataProklim->kategori_proklim_id = $kategoriProklimId;
            $dataProklim->nama = $request->nama;
            $dataProklim->deskripsi = $request->deskripsi;
            $dataProklim->alamat = $request->alamat;
            $dataProklim->lng = $request->lng;
            $dataProklim->lat = $request->lat;
            $dataProklim->tanggal_aktif = $request->tanggal_aktif;
            $dataProklim->status_aktif = '1';
            $dataProklim->save();

            return response()->json([
                'success' => 'Data Proklim berhasil disimpan.'
            ]);

        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            return response()->json([
                'errors' => 'Data wilayah atau kategori tidak valid.'
            ], 422);
        } catch (\Throwable $e) {
            return response()->json([
                'errors' => 'Data Proklim gagal disimpan.'
            ], 500);
        }
    }

    public function detail($id)
    {
        try {
            $proklimId = Crypt::decryptString($id);
            $dataProklim = DataProklim::with(['kabupaten_kota', 'kecamatan', 'kelurahan', 'kategori_proklim'])->findOrFail($proklimId);
            return response()->json([
                'success' => true,
                'result' => [
                    'id' => Crypt::encryptString($dataProklim->id),
                    'kabupaten_kota' => $dataProklim->kabupaten_kota->name,
                    'kecamatan' => $dataProklim->kecamatan->name,
                    'kelurahan' => $dataProklim->kelurahan->name,
                    'kategori_proklim' => $dataProklim->kategori_proklim->nama,
                    'nama' => $dataProklim->nama,
                    'deskripsi' => $dataProklim->deskripsi,
                    'alamat' => $dataProklim->alamat,
                    'lng' => $dataProklim->lng,
                    'lat' => $dataProklim->lat,
                    'tanggal_aktif' => $dataProklim->tanggal_aktif ? Carbon::parse($dataProklim->tanggal_aktif)->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('j F Y') : null,
                ]
            ]);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            return response()->json([
                'success' => false,
                'errors' => 'ID data Proklim tidak valid.'
            ], 422);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'errors' => 'Data Proklim tidak ditemukan.'
            ], 404);

        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'errors' => 'Data Proklim gagal dimuat.'
            ], 500);
        }
    }

    public function edit($id)
    {
        try {
            $id = Crypt::decryptString($id);
            $dataProklim = DataProklim::with(['kabupaten_kota', 'kecamatan','kelurahan','kategori_proklim'])->findOrFail($id);
            return response()->json([
                'result' => [
                    'id' => Crypt::encryptString($dataProklim->id),
                    'kabupaten_kota' => $dataProklim->kabupaten_kota->name,
                    'kecamatan' => $dataProklim->kecamatan->name,
                    'kelurahan' => $dataProklim->kelurahan->name,
                    'kategori_proklim' => $dataProklim->kategori_proklim->nama,
                    'nama' => $dataProklim->nama,
                    'deskripsi' => $dataProklim->deskripsi,
                    'alamat' => $dataProklim->alamat,
                    'lng' => $dataProklim->lng,
                    'lat' => $dataProklim->lat,
                    'tanggal_aktif' => $dataProklim->tanggal_aktif ? Carbon::parse($dataProklim->tanggal_aktif)->format('Y-m-d') : null,
                ]
            ]);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            return response()->json([
                'errors' => 'ID data Proklim tidak valid.'
            ], 422);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'errors' => 'Data Proklim tidak ditemukan.'
            ], 404);
        } catch (\Throwable $e) {
            return response()->json([
                'errors' => 'Data Proklim gagal dimuat.'
            ], 500);
        }
    }

    public function update(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required',
                'kabupaten_kota_id' => 'required',
                'kecamatan_id' => 'required',
                'kelurahan_id' => 'required',
                'kategori_proklim_id' => 'required',
                'nama' => 'required|string',
                'deskripsi' => 'required|string',
                'alamat' => 'required|string',
                'lng' => 'required|string',
                'lat' => 'required|string',
                'tanggal_aktif' => 'required|date',
            ], [
                'id.required' => 'ID data Proklim tidak ditemukan.',
                'kabupaten_kota_id.required' => 'Kabupaten / Kota wajib dipilih.',
                'kecamatan_id.required' => 'Kecamatan wajib dipilih.',
                'kelurahan_id.required' => 'Kelurahan wajib dipilih.',
                'kategori_proklim_id.required' => 'Kategori Proklim wajib dipilih.',
                'nama.required' => 'Nama Proklim wajib diisi.',
                'deskripsi.required' => 'Deskripsi wajib diisi.',
                'alamat.required' => 'Alamat wajib diisi.',
                'lng.required' => 'Longitude wajib ditentukan melalui peta.',
                'lat.required' => 'Latitude wajib ditentukan melalui peta.',
                'tanggal_aktif.required' => 'Tanggal aktif wajib diisi.',
                'tanggal_aktif.date' => 'Format tanggal aktif tidak valid.',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'errors' => implode(
                        '<br>',
                        $validator->errors()->all()
                    )
                ], 422);
            }

            $id = Crypt::decryptString($request->id);
            $dataProklim = DataProklim::findOrFail($id);

            $kabupatenKotaId = Crypt::decryptString($request->kabupaten_kota_id);
            $kecamatanId = Crypt::decryptString($request->kecamatan_id);
            $kelurahanId = Crypt::decryptString($request->kelurahan_id);
            $kategoriProklimId = Crypt::decryptString($request->kategori_proklim_id);

            $dataProklim->kabupaten_kota_id = $kabupatenKotaId;
            $dataProklim->kecamatan_id = $kecamatanId;
            $dataProklim->kelurahan_id = $kelurahanId;
            $dataProklim->kategori_proklim_id = $kategoriProklimId;
            $dataProklim->nama = $request->nama;
            $dataProklim->deskripsi = $request->deskripsi;
            $dataProklim->alamat = $request->alamat;
            $dataProklim->lng = $request->lng;
            $dataProklim->lat = $request->lat;
            $dataProklim->tanggal_aktif = $request->tanggal_aktif;
            $dataProklim->save();

            return response()->json([
                'success' => 'Data Proklim berhasil diperbarui.'
            ]);

        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            return response()->json([
                'errors' =>
                    'Data Proklim atau data wilayah tidak valid.'
            ], 422);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'errors' =>
                    'Data Proklim tidak ditemukan.'
            ], 404);
        } catch (\Throwable $e) {
            return response()->json([
                'errors' =>
                    'Data Proklim gagal diperbarui.'
            ], 500);
        }
    }

    public function destroy(string $id)
    {
        try {
            $id = Crypt::decryptString($id);
            $proklim = DataProklim::find($id);
            $proklim->status_aktif = '0';
            $proklim->save();

            return response()->json(['success' => 'Berhasil menghapus proklim']);
        } catch (\Throwable $th) {
            return response()->json(['errors' => $th->getMessage()]);
        }
    }
}
