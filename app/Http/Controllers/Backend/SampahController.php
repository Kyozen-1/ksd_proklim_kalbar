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
use App\Models\MdKategoriSampah;
use App\Models\DataSampah;

class SampahController extends Controller
{
    public function index()
    {
        return view('backend.sampah.index', [
            'kabupatenKotas' => $this->getKabupatenKota(),
            'kategoriSampahs' => $this->getKategoriSampah(),
            'countDataSampah' => $this->countDataSampah()
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

    public function getKategoriSampah()
    {
        $getData = MdKategoriSampah::get()
                    ->map(function($d){
                        return [
                            'id' => Crypt::encryptString($d->id),
                            'nama' => $d->nama
                        ];
                    });
        return $getData;
    }

    public function countDataSampah()
    {
        return DataSampah::count();
    }

    public function datatable(Request $request)
    {
        $getDatas = DataSampah::when($request->kabupaten_kota_id != null, function($q) use ($request){
                    $kabupatenKotaId = Crypt::decryptString($request->kabupaten_kota_id);
                    $q->where('kabupaten_kota_id', $kabupatenKotaId);
                })->when($request->kategori_sampah_id != null, function($q) use ($request){
                    $kategoriSampahId = Crypt::decryptString($request->kategori_sampah_id);
                    $q->where('kategori_sampah_id', $kategoriSampahId);
                })->when($request->tahun != null, function($q) use ($request){
                    $q->where('tahun', $request->tahun);
                })->get();
        $data = [];
        foreach ($getDatas as $getData) {
            $data[] = [
                'id' => Crypt::encryptString($getData->id),
                'kabupaten_kota_id' => $getData->kabupaten_kota->name,
                'kategori_sampah_id' => $getData->kategori_sampah->nama,
                'tahun' => $getData->tahun,
                'nilai' => $getData->nilai,
                'sampah_terkelola' => $getData->sampah_terkelola,
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
            ->editColumn('nilai', function($data){
                return number_format($data['nilai'], 2, ',', '.');
            })
            ->editColumn('sampah_terkelola', function($data){
                return number_format($data['sampah_terkelola'], 2, ',', '.');
            })
            ->addColumn('sampah_tidak_terkelola', function($data){
                $sampahTidakTerkelola = $data['nilai'] - $data['sampah_terkelola'];
                return number_format($sampahTidakTerkelola, 2, ',', '.');
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
            'kategori_sampah_id' => [
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
            'sampah_terkelola' => [
                'required',
                'array',
                'min:1',
            ],
            'sampah_terkelola.*' => [
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
        $jumlahSampahTerkelola = count($request->sampah_terkelola);
        $jumlahTanggal = count(
            $request->tanggal_pendataan
        );

        if (
            $jumlahTahun !== $jumlahNilai ||
            $jumlahTahun !== $jumlahTanggal ||
            $jumlahTahun !== $jumlahSampahTerkelola
        ) {
            return response()->json([
                'errors' => [
                    'Jumlah data tahun, nilai, sampah terkelola, dan tanggal pendataan tidak sama.'
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
            $kategoriSampahId = Crypt::decryptString(
                $request->kategori_sampah_id
            );
        } catch (DecryptException $e) {
            return response()->json([
                'errors' => [
                    'Kategori sampah tidak valid.'
                ]
            ]);
        }

        try {
            DB::beginTransaction();

            foreach ($request->tahun as $index => $tahun) {
                $sampah = DataSampah::where('kabupaten_kota_id',$kabupatenKotaId)
                                ->where('kategori_sampah_id',$kategoriSampahId)
                                ->where('tahun',$tahun)
                                ->first();

                if (!$sampah) {
                    $sampah = new DataSampah;
                    $sampah->kabupaten_kota_id =$kabupatenKotaId;
                    $sampah->kategori_sampah_id =$kategoriSampahId;
                    $sampah->tahun = $tahun;
                }

                $sampah->nilai = $request->nilai[$index];
                $sampah->sampah_terkelola = $request->sampah_terkelola[$index];
                $sampah->tanggal_pendataan = $request->tanggal_pendataan[$index];
                $sampah->save();
            }
            DB::commit();
            return response()->json([
                'success' => 'Berhasil menyimpan data sampah.'
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
            'sampah_terkelola' => [
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
            $sampah = DataSampah::find($id);
            if (!$sampah) {
                return response()->json([
                    'errors' => 'Data sampah tidak ditemukan.'
                ]);
            }
            $sampah->nilai = $request->nilai;
            $sampah->sampah_terkelola = $request->sampah_terkelola;
            $sampah->save();

            return response()->json([
                'success' => 'Berhasil mengubah nilai sampah.'
            ]);
        } catch (\Throwable $th) {

            return response()->json([
                'errors' => $th->getMessage()
            ]);
        }
    }
}
