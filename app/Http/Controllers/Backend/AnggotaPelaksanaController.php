<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Intervention\Image\Laravel\Facades\Image;
use App\Contracts\FileStorageInterface;
use Carbon\Carbon;
use Validator;
use DataTables;
use App\Models\MasterJabatan;
use App\Models\AnggotaPelaksana;

class AnggotaPelaksanaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('backend.anggota-pelaksana.index', [
            'jabatans' => $this->getJabatan()
        ]);
    }

    public function getJabatan()
    {
        $getData = MasterJabatan::statusAktif()
                    ->get()
                    ->map(function($d){
                        return [
                            'id' => Crypt::encryptString($d->id),
                            'nama' => $d->nama
                        ];
                    });
        return $getData;
    }

    public function datatable()
    {
        $getData = new AnggotaPelaksana;
        $getData = $getData->statusAktif();
        $getData = $getData->get();

        $data = [];

        foreach ($getData as $d) {
            $data[] = [
                'id' => Crypt::encryptString($d->id),
                'nama' => $d->nama,
                'foto' => $d->foto_path,
                'jabatan_id' => $d->jabatan->nama
            ];
        }

        $data = collect($data);

        return DataTables::collection($data)
            ->addIndexColumn()
            ->addColumn('aksi', function($data){
                $id = $data['id'];
                $button_edit = '<button type="button" name="edit" id="'.$id.'"
                class="edit btn btn-icon waves-effect btn-warning" title="Edit Data"><i class="fas fa-edit"></i></button>';
                $button_delete = '<button type="button" name="delete" id="'.$id.'" class="delete btn btn-icon waves-effect btn-danger" title="Delete Data"><i class="fas fa-trash"></i></button>';
                $button = $button_edit . ' ' . $button_delete;
                return $button;
            })
            ->editColumn('foto', function($data){
                return '<img src="'.$data['foto'].'" alt="" style="width: 5rem;">';
            })
            ->rawColumns(['aksi', 'foto'])
        ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, FileStorageInterface $storage)
    {
        $errors = Validator::make($request->all(), [
            'nama' => 'required',
            'jabatan_id' => 'required',
            'foto' => 'required | mimes:jpg,jpeg,png,webp'
        ]);

        if($errors -> fails())
        {
            return response()->json(['errors' => $errors->errors()->all()]);
        }

        try {
            $anggotaPelaksana = new AnggotaPelaksana;
            $anggotaPelaksana->jabatan_id = Crypt::decryptString($request->jabatan_id);
            $anggotaPelaksana->nama = $request->nama;
            $anggotaPelaksana->save();

            if (!in_array(
                strtolower($request->file('foto')->getClientOriginalExtension()),
                ['jpg', 'jpeg', 'png', 'webp']
            )) {
                return response()->json(['errors' => 'Jenis file tidak sama dengan file yang diupload']);
            }

            $destinationPath = 'anggota-pelaksana';

            $path = $storage->upload(
                $request->file('foto'),
                $destinationPath
            );

            $anggotaPelaksana->foto = $path;

            $anggotaPelaksana->save();

            return response()->json(['success' => 'Berhasil menambahkan file di anggota pelaksana']);
        } catch (\Throwable $th) {
            return response()->json(['errors' => $th->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $id = Crypt::decryptString($id);
        $getData = AnggotaPelaksana::find($id);
        $data = [
            'nama' => $getData->nama,
            'jabatan' => $getData->jabatan->nama,
            'foto_path' => $getData->foto_path
        ];

        return response()->json(['result' => $data]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FileStorageInterface $storage)
    {
        $errors = Validator::make($request->all(), [
            'nama' => 'required',
            'jabatan_id' => 'required',
            'hidden_id' => 'required'
        ]);

        if($errors -> fails())
        {
            return response()->json(['errors' => $errors->errors()->all()]);
        }

        if($request->foto)
        {
            $errors = Validator::make($request->all(), [
                'foto' => 'mimes:jpg,jpeg,png,webp'
            ]);

            if($errors -> fails())
            {
                return response()->json(['errors' => $errors->errors()->all()]);
            }
        }

        try {
            $hiddenId = Crypt::decryptString($request->hidden_id);

            $anggotaPelaksana = AnggotaPelaksana::find($hiddenId);
            $anggotaPelaksana->jabatan_id = Crypt::decryptString($request->jabatan_id);
            $anggotaPelaksana->nama = $request->nama;
            $anggotaPelaksana->save();

            if($request->foto)
            {
                if (!in_array(
                    strtolower($request->file('foto')->getClientOriginalExtension()),
                    ['jpg', 'jpeg', 'png', 'webp']
                )) {
                    return response()->json(['errors' => 'Jenis file tidak sama dengan file yang diupload']);
                }

                $storage->delete(
                    $anggotaPelaksana->foto
                );

                $destinationPath = 'anggota-pelaksana';

                $anggotaPelaksana->foto = $storage->upload(
                                        $request->file('foto'),
                                        $destinationPath
                                    );

                $anggotaPelaksana->save();
            }

            return response()->json(['success' => 'Berhasil merubah data']);
        } catch (\Throwable $th) {
            return response()->json(['errors' => $th->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $id = Crypt::decryptString($id);
            $anggotaPelaksana = AnggotaPelaksana::find($id);
            $anggotaPelaksana->status_aktif = '0';
            $anggotaPelaksana->save();
            return response()->json(['success' => 'Berhasil menghapus data']);
        } catch (\Throwable $th) {
            return response()->json(['result' => $th->getMessage()]);
        }
    }
}
