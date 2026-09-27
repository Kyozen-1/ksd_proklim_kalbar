<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;
use Validator;
use DataTables;
use App\Models\TargetPenurunanEmisi;
use App\Models\Regency;

class TargetPenurunanEmisiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('backend.target-penurunan-emisi.index',[
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
        $getData = new TargetPenurunanEmisi;
        $getData = $getData->get();
        $data = [];
        foreach ($getData as $d) {
            $data[] = [
                'id' => Crypt::encryptString($d->id),
                'kabupaten_kota_id' => $d->kabupaten_kota->name,
                'tahun' => $d->tahun,
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
            'tahun' => 'required',
            'nilai' => 'required',
        ]);

        if($errors -> fails())
        {
            return response()->json(['errors' => $errors->errors()->all()]);
        }
        try {
            $cekTargetPenurunanEmisi = TargetPenurunanEmisi::where('tahun', $request->tahun)->first();
            if($cekTargetPenurunanEmisi)
            {
                $targetPenurunanEmisi = TargetPenurunanEmisi::find($cekTargetPenurunanEmisi->id);
            } else {
                $targetPenurunanEmisi = new TargetPenurunanEmisi;
            }
            $targetPenurunanEmisi->kabupaten_kota_id = Crypt::decryptString($request->kabupaten_kota_id);
            $targetPenurunanEmisi->nilai = $request->nilai;
            $targetPenurunanEmisi->save();

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
        $getData = TargetPenurunanEmisi::find($id);
        $dataSend = [
            'nilai' => (float)$getData->nilai,
            'tahun' => $getData->tahun,
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
            'tahun' => 'required',
            'kabupaten_kota_id' => 'required',
            'hidden_id' => 'required'
        ]);

        if ($errors->fails()) {
            return response()->json([
                'errors' => $errors->errors()->all()
            ]);
        }

        try {
            $id = Crypt::decryptString($request->hidden_id);
            $kabupatenKotaId = Crypt::decryptString($request->kabupaten_kota_id);

            $targetPenurunanEmisi = TargetPenurunanEmisi::find($id);

            if (!$targetPenurunanEmisi) {
                return response()->json([
                    'errors' => ['Data target penurunan emisi tidak ditemukan']
                ]);
            }
            if ($targetPenurunanEmisi->tahun != null &&
                ($targetPenurunanEmisi->kabupaten_kota_id != $kabupatenKotaId ||
                $targetPenurunanEmisi->tahun != $request->tahun)
            ) {
                return response()->json([
                    'errors' => [
                        'Kabupaten/Kota dan tahun tidak dapat diubah. Data harus sesuai dengan data yang tersimpan.'
                    ]
                ]);
            } else {
                $targetPenurunanEmisi->tahun = $request->tahun;
            }
            $targetPenurunanEmisi->nilai = $request->nilai;
            $targetPenurunanEmisi->save();

            return response()->json([
                'success' => 'Berhasil merubah target penurunan emisi'
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'errors' => $th->getMessage()
            ]);
        }
    }
}
