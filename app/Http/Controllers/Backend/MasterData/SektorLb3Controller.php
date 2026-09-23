<?php

namespace App\Http\Controllers\Backend\MasterData;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;
use Validator;
use DataTables;
use Auth;
use App\Models\MdSektorLb3;

class SektorLb3Controller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('backend.master-data.sektor-lb3.index');
    }

    public function datatable()
    {
        $getData = new MdSektorLb3;
        $getData = $getData->statusAktif();
        $getData = $getData->get();
        $data = [];
        foreach ($getData as $d) {
            $data[] = [
                'id' => Crypt::encryptString($d->id),
                'nama' => $d->nama
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
    public function store(Request $request)
    {
        $errors = Validator::make($request->all(), [
            'nama' => 'required',
        ]);

        if($errors -> fails())
        {
            return response()->json(['errors' => $errors->errors()->all()]);
        }
        try {
            $sektorLb3 = new MdSektorLb3;
            $sektorLb3->user_id = Auth::user()->id;
            $sektorLb3->nama = $request->nama;
            $sektorLb3->status_aktif = '1';
            $sektorLb3->save();

            return response()->json(['success' => 'Berhasil menambahkan Kategori Proklim']);
        } catch (\Throwable $th) {
            return response()->json(['errors' => $th->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $id = Crypt::decryptString($id);
        $getData = MdSektorLb3::find($id);
        $dataSend = [
            'nama' => $getData->nama
        ];

        return response()->json(['result' => $dataSend]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $id = Crypt::decryptString($id);
        $getData = MdSektorLb3::find($id);
        $dataSend = [
            'nama' => $getData->nama
        ];

        return response()->json(['result' => $dataSend]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $errors = Validator::make($request->all(), [
            'nama' => 'required',
            'hidden_id' => 'required'
        ]);

        if($errors -> fails())
        {
            return response()->json(['errors' => $errors->errors()->all()]);
        }

        try {
            $id = Crypt::decryptString($request->hidden_id);

            $sektorLb3 = MdSektorLb3::find($id);
            $sektorLb3->nama = $request->nama;
            $sektorLb3->save();

            return response()->json(['success' => 'Berhasil merubah Kategori Proklim']);
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
            $sektorLb3 = MdSektorLb3::find($id);
            $sektorLb3->status_aktif = '0';
            $sektorLb3->save();

            return response()->json(['success' => 'Berhasil menghapus Kategori Proklim']);
        } catch (\Throwable $th) {
            return response()->json(['errors' => $th->getMessage()]);
        }
    }
}
