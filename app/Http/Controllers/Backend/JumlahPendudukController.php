<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;
use Validator;
use DataTables;
use App\Models\JumlahPenduduk;
use App\Models\Regency;

class JumlahPendudukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('backend.jumlah-penduduk.index',[
            'kabupatenKotas' => $this->getKabupatenKota()
        ]);
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

    public function datatable()
    {
        $getData = new JumlahPenduduk;
        $getData = $getData->get();
        $data = [];
        foreach ($getData as $d) {
            $data[] = [
                'id' => Crypt::encryptString($d->id),
                'kabupaten_kota_id' => $d->kabupaten_kota->name,
                'nilai' => $d->nilai
            ];
        }
        $data = collect($data);
        return DataTables::collection($data)
            ->addIndexColumn()
            ->addColumn('aksi', function($data){
                $id = $data['id'];
                $button_edit = '<button type="button" name="edit" id="'.$id.'" class="edit btn btn-icon waves-effect btn-warning" title="Edit Data"><i class="fas fa-edit"></i></button>';
                return $button_edit;
            })
            ->editColumn('nilai', function($data){
                return number_format($data['nilai'], 2, ',', '.');
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
            'kabupaten_kota_id' => 'required',
            'nilai' => 'required',
        ]);

        if($errors -> fails())
        {
            return response()->json(['errors' => $errors->errors()->all()]);
        }
        try {
            $jumlahPenduduk = new JumlahPenduduk;
            $jumlahPenduduk->kabupaten_kota_id = Crypt::decryptString($request->kabupaten_kota_id);
            $jumlahPenduduk->nilai = $request->nilai;
            $jumlahPenduduk->save();

            return response()->json(['success' => 'Berhasil menambahkan jumlah penduduk']);
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
        $getData = JumlahPenduduk::find($id);
        $dataSend = [
            'nilai' => (float)$getData->nilai,
            'kabupaten_kota' => $getData->kabupaten_kota->name
        ];

        return response()->json(['result' => $dataSend]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $errors = Validator::make($request->all(), [
            'nilai' => 'required',
            'kabupaten_kota_id' => 'required',
            'hidden_id' => 'required'
        ]);

        if($errors -> fails())
        {
            return response()->json(['errors' => $errors->errors()->all()]);
        }

        try {
            $id = Crypt::decryptString($request->hidden_id);
            $kabupatenKotaId = Crypt::decryptString($request->kabupaten_kota_id);

            $jumlahPenduduk = JumlahPenduduk::find($id);
            $jumlahPenduduk->kabupaten_kota_id = $kabupatenKotaId;
            $jumlahPenduduk->nilai = $request->nilai;
            $jumlahPenduduk->save();

            return response()->json(['success' => 'Berhasil merubah jumlah penduduk']);
        } catch (\Throwable $th) {
            return response()->json(['errors' => $th->getMessage()]);
        }
    }
}
