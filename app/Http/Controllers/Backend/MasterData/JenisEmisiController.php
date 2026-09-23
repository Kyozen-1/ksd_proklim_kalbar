<?php

namespace App\Http\Controllers\Backend\MasterData;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Validator;
use DataTables;
use App\Models\MdSektorUtamaEmisi;
use App\Models\MdJenisEmisi;

class JenisEmisiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('backend.master-data.jenis-emisi.index', [
            'sektorUtamaEmisis' => $this->getSektorUtamaEmisi()
        ]);
    }

    public function getSektorUtamaEmisi()
    {
        $getData = MdSektorUtamaEmisi::statusAktif()
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
        $getData = new MdJenisEmisi;
        $getData = $getData->statusAktif();
        $getData = $getData->get();

        $data = [];

        foreach ($getData as $d) {
            $data[] = [
                'id' => Crypt::encryptString($d->id),
                'nama' => $d->nama,
                'sektor_utama_emisi' => $d->sektor_utama_emisi->nama,
                'jenis_perhitungan' => $d->jenis_perhitungan
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
            'sektor_utama_emisi_id' => 'required',
            'jenis_perhitungan' => 'required',
        ]);

        if($errors -> fails())
        {
            return response()->json(['errors' => $errors->errors()->all()]);
        }

        try {
            $jenisEmisi = new MdJenisEmisi;
            $jenisEmisi->sektor_utama_emisi_id = Crypt::decryptString($request->sektor_utama_emisi_id);
            $jenisEmisi->nama = $request->nama;
            $jenisEmisi->jenis_perhitungan = $request->jenis_perhitungan;
            $jenisEmisi->status_aktif = '1';
            $jenisEmisi->save();

            return response()->json(['success' => 'Berhasil menambahkan jenis emisi']);
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
        $getData = MdJenisEmisi::find($id);
        $data = [
            'sektor_utama_emisi' => $getData->sektor_utama_emisi->nama,
            'nama' => $getData->nama,
            'jenis_perhitungan' => $getData->jenis_perhitungan
        ];

        return response()->json(['result' => $data]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $id = Crypt::decryptString($id);
        $getData = MdJenisEmisi::find($id);
        $data = [
            'sektor_utama_emisi' => $getData->sektor_utama_emisi->nama,
            'nama' => $getData->nama,
            'jenis_perhitungan' => $getData->jenis_perhitungan
        ];

        return response()->json(['result' => $data]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $errors = Validator::make($request->all(), [
            'nama' => 'required',
            'sektor_utama_emisi_id' => 'required',
            'jenis_perhitungan' => 'required',
        ]);

        if($errors -> fails())
        {
            return response()->json(['errors' => $errors->errors()->all()]);
        }

        try {
            $hiddenId = Crypt::decryptString($request->hidden_id);

            $jenisEmisi = MdJenisEmisi::find($hiddenId);
            $jenisEmisi->sektor_utama_emisi_id = Crypt::decryptString($request->sektor_utama_emisi_id);
            $jenisEmisi->nama = $request->nama;
            $jenisEmisi->jenis_perhitungan = $request->jenis_perhitungan;
            $jenisEmisi->save();

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
            $jenisEmisi = MdJenisEmisi::find($id);
            $jenisEmisi->status_aktif = '0';
            $jenisEmisi->save();
            return response()->json(['success' => 'Berhasil menghapus data']);
        } catch (\Throwable $th) {
            return response()->json(['result' => $th->getMessage()]);
        }
    }
}
