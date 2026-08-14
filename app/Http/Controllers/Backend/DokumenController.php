<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Contracts\FileStorageInterface;
use Carbon\Carbon;
use Auth;
use Validator;
use DataTables;
use App\Models\Dokumen;

class DokumenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('backend.dokumen.index');
    }

    public function datatable()
    {
        $getData = new Dokumen;
        $getData = $getData->statusAktif();
        $getData = $getData->get();

        $data = [];
        foreach ($getData as $d) {
            $data[] = [
                'id' => Crypt::encryptString($d->id),
                'nama' => $d->nama,
                'kategori' => $d->kategori,
                'document_url' => $d->document_url
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
            ->addColumn('dokumen', function($data){
                return '<iframe src="'.$data['document_url'].'" width="100%" height="300px" style="border:1px solid #ccc;">
                                Browser Anda tidak mendukung iframe.
                            </iframe>';
            })
            ->editColumn('kategori', function($data){
                return str_replace("_", " - ", $data['kategori']);
            })
            ->rawColumns(['aksi', 'dokumen'])
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
            'kategori' => 'required'
        ]);

        if($errors -> fails())
        {
            return response()->json(['errors' => $errors->errors()->all()]);
        }

        if($request->document)
        {
            $errors = Validator::make($request->all(), [
                'document' => 'required|mimes:pdf',
            ]);

            if($errors -> fails())
            {
                return response()->json(['errors' => $errors->errors()->all()]);
            }
        }

        try {
            $dokumen = new Dokumen;
            $dokumen->user_id = Auth::user()->id;
            $dokumen->nama = $request->nama;
            $dokumen->kategori = $request->kategori;
            $dokumen->save();

            $destinationPath = 'dokumen';

            $file = $request->file('document');
            $path = $storage->upload(
                        $file,
                        $destinationPath
                    );

            $dokumen->path = $path;
            $dokumen->save();

            return response()->json(['success' => 'Berhasil menambahkan dokumen']);
        } catch (\Throwable $th) {
            return response()->json(['errors' => $th->getMessage()]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $id = Crypt::decryptString($id);

        $getData = Dokumen::find($id);

        $data = [
            'nama' => $getData->nama,
            'kategori' => $getData->kategori,
            'document' => $getData->path ? $getData->document_url : null,
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
            'kategori' => 'required',
            'hidden_id' => 'required'
        ]);

        if($errors -> fails())
        {
            return response()->json(['errors' => $errors->errors()->all()]);
        }

        if($request->document)
        {
            $errors = Validator::make($request->all(), [
                'document' => 'required|mimes:pdf',
            ]);

            if($errors -> fails())
            {
                return response()->json(['errors' => $errors->errors()->all()]);
            }
        }

        try {
            $hiddenId = Crypt::decryptString($request->hidden_id);

            $dokumen = Dokumen::find($hiddenId);
            $dokumen->nama = $request->nama;
            $dokumen->kategori = $request->kategori;
            $dokumen->save();

            if($request->document)
            {
                $storage->delete(
                    $dokumen->path
                );
                $file = $request->file('document');
                $destinationPath = 'dokumen';

                $path = $storage->upload(
                            $file,
                            $destinationPath
                        );

                $dokumen->path = $path;
            }

            $dokumen->save();

            return response()->json(['success' => 'Berhasil mengupdate data']);

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
            $dokumen = Dokumen::find($id);
            $dokumen->status_aktif = '0';
            $dokumen->save();

            return response()->json(['success' => 'Berhasil menghapus data']);
        } catch (\Throwable $th) {
            return response()->json(['errors' => $th->getMessage()]);
        }
    }
}
