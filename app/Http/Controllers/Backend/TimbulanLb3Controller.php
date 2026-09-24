<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Carbon\Carbon;
use Validator;
use DB;
use DataTables;
use App\Models\Regency;
use App\Models\MdSektorLb3;
use App\Models\DataTimbulanLb3;

class TimbulanLb3Controller extends Controller
{
    public function index()
    {
        return view('backend.timbulan-lb3.index', [
            'kabupatenKotas' => $this->getKabupatenKota(),
            'sektorLb3s' => $this->getSektorLb3(),
            'countDataTimbulanLb3' => $this->countDataTimbulanLb3()
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

    public function getSektorLb3()
    {
        $getData = MdSektorLb3::get()
                    ->map(function($d){
                        return [
                            'id' => Crypt::encryptString($d->id),
                            'nama' => $d->nama
                        ];
                    });
        return $getData;
    }

    public function countDataTimbulanLb3()
    {
        return DataTimbulanLb3::count();
    }

    public function datatable(Request $request)
    {
        $getDatas = DataTimbulanLb3::when($request->kabupaten_kota_id != null, function($q) use ($request){
                    $kabupatenKotaId = Crypt::decryptString($request->kabupaten_kota_id);
                    $q->where('kabupaten_kota_id', $kabupatenKotaId);
                })->when($request->sektor_lb3_id != null, function($q) use ($request){
                    $sektorLb3Id = Crypt::decryptString($request->sektor_lb3_id);
                    $q->where('sektor_lb3_id', $sektorLb3Id);
                })->when($request->tahun != null, function($q) use ($request){
                    $q->where('tahun', $request->tahun);
                })->get();
        $data = [];
        foreach ($getDatas as $getData) {
            $data[] = [
                'id' => Crypt::encryptString($getData->id),
                'kabupaten_kota_id' => $getData->kabupaten_kota->name,
                'sektor_lb3_id' => $getData->sektor_lb3->nama,
                'tahun' => $getData->tahun,
                'nilai' => number_format($getData->nilai, 2, ',', '.'),
                'tanggal_pendataan' => Carbon::parse($getData->tanggal_pendataan)->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('j F Y')
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
            ->rawColumns(['aksi'])
        ->make(true);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kabupaten_kota_id' => [
                'required',
                'string',
            ],
            'sektor_lb3_id' => [
                'required',
                'string',
            ],
            'tahun' => [
                'required',
                'array',
                'min:1',
            ],
            'tahun.*' => [
                'required',
                'integer',
                'digits:4',
                'min:2000',
                'max:2100',
                'distinct',
            ],
            'nilai' => [
                'required',
                'array',
                'min:1',
            ],
            'nilai.*' => [
                'required',
                'numeric',
                'min:0',
            ],
            'tanggal_pendataan' => [
                'required',
                'array',
                'min:1',
            ],
            'tanggal_pendataan.*' => [
                'required',
                'date',
            ],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()->all()
            ]);
        }

        $jumlahTahun = count($request->tahun);
        $jumlahNilai = count($request->nilai);
        $jumlahTanggal = count(
            $request->tanggal_pendataan
        );

        if (
            $jumlahTahun !== $jumlahNilai ||
            $jumlahTahun !== $jumlahTanggal
        ) {
            return response()->json([
                'errors' => [
                    'Jumlah data tahun, nilai timbulan, dan tanggal pendataan tidak sama.'
                ]
            ]);
        }

        try {
            $kabupatenKotaId = Crypt::decryptString(
                $request->kabupaten_kota_id
            );
        } catch (DecryptException $e) {
            return response()->json([
                'errors' => [
                    'Kabupaten/Kota tidak valid.'
                ]
            ]);
        }

        try {
            $sektorLb3Id = Crypt::decryptString(
                $request->sektor_lb3_id
            );
        } catch (DecryptException $e) {
            return response()->json([
                'errors' => [
                    'Sektor LB3 tidak valid.'
                ]
            ]);
        }

        try {
            DB::beginTransaction();

            foreach ($request->tahun as $index => $tahun) {
                $timbulanLb3 = DataTimbulanLb3::where('kabupaten_kota_id',$kabupatenKotaId)
                                ->where('sektor_lb3_id',$sektorLb3Id)
                                ->where('tahun',$tahun)
                                ->first();

                if (!$timbulanLb3) {
                    $timbulanLb3 = new DataTimbulanLb3;
                    $timbulanLb3->kabupaten_kota_id =$kabupatenKotaId;
                    $timbulanLb3->sektor_lb3_id =$sektorLb3Id;
                    $timbulanLb3->tahun = $tahun;
                }

                $timbulanLb3->nilai = $request->nilai[$index];
                $timbulanLb3->tanggal_pendataan = $request->tanggal_pendataan[$index];
                $timbulanLb3->save();
            }
            DB::commit();
            return response()->json([
                'success' => 'Berhasil menyimpan data timbulan LB3.'
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'errors' => [
                    $th->getMessage()
                ]
            ]);
        }
    }


    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => [
                'required',
                'string'
            ],
            'nilai' => [
                'required',
                'numeric',
                'min:0'
            ],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()->all()
            ]);
        }

        try {
            $id = Crypt::decryptString($request->id);
        } catch (\Throwable $th) {
            return response()->json([
                'errors' => 'ID data tidak valid.'
            ]);
        }

        try {
            $timbulanLb3 = DataTimbulanLb3::find($id);
            if (!$timbulanLb3) {
                return response()->json([
                    'errors' => 'Data timbulan LB3 tidak ditemukan.'
                ]);
            }
            $timbulanLb3->nilai = $request->nilai;
            $timbulanLb3->save();

            return response()->json([
                'success' => 'Berhasil mengubah nilai timbulan LB3.'
            ]);
        } catch (\Throwable $th) {

            return response()->json([
                'errors' => $th->getMessage()
            ]);
        }
    }
}
