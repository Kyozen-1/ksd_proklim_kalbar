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
use App\Models\MdKategoriKualitasLingkungan;
use App\Models\DataKualitasLingkungan;

class KualitasLingkunganController extends Controller
{
    public function index()
    {
        return view('backend.kualitas-lingkungan.index', [
            'kabupatenKotas' => $this->getKabupatenKota(),
            'kategoriKualitasLingkungans' => $this->getKategoriKualitasLingkungan(),
            'countDataKualitasLingkungan' => $this->countDataKualitasLingkungan()
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

    public function getKategoriKualitasLingkungan()
    {
        $getData = MdKategoriKualitasLingkungan::get()
                    ->map(function($d){
                        return [
                            'id' => Crypt::encryptString($d->id),
                            'nama' => $d->nama
                        ];
                    });
        return $getData;
    }

    public function countDataKualitasLingkungan()
    {
        return DataKualitasLingkungan::count();
    }

    public function datatable(Request $request)
    {
        $getDatas = DataKualitasLingkungan::when($request->kabupaten_kota_id != null, function($q) use ($request){
                    $kabupatenKotaId = Crypt::decryptString($request->kabupaten_kota_id);
                    $q->where('kabupaten_kota_id', $kabupatenKotaId);
                })->when($request->kategori_kualitas_lingkungan_id != null, function($q) use ($request){
                    $kategoriKualitasLingkunganId = Crypt::decryptString($request->kategori_kualitas_lingkungan_id);
                    $q->where('kategori_kualitas_lingkungan_id', $kategoriKualitasLingkunganId);
                })->when($request->tahun != null, function($q) use ($request){
                    $q->where('tahun', $request->tahun);
                })->get();
        $data = [];
        foreach ($getDatas as $getData) {
            $data[] = [
                'id' => Crypt::encryptString($getData->id),
                'kabupaten_kota_id' => $getData->kabupaten_kota->name,
                'kategori_kualitas_lingkungan_id' => $getData->kategori_kualitas_lingkungan->nama,
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
            'kategori_kualitas_lingkungan_id' => [
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
                    'Jumlah data tahun, nilai indeks, dan tanggal pendataan tidak sama.'
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
            $kategoriKualitasLingkunganId = Crypt::decryptString(
                $request->kategori_kualitas_lingkungan_id
            );
        } catch (DecryptException $e) {
            return response()->json([
                'errors' => [
                    'Kategori Kualitas Lingkungan tidak valid.'
                ]
            ]);
        }

        try {
            DB::beginTransaction();

            foreach ($request->tahun as $index => $tahun) {
                $kualitasLingkungan = DataKualitasLingkungan::where('kabupaten_kota_id',$kabupatenKotaId)
                                ->where('kategori_kualitas_lingkungan_id',$kategoriKualitasLingkunganId)
                                ->where('tahun',$tahun)
                                ->first();

                if (!$kualitasLingkungan) {
                    $kualitasLingkungan = new DataKualitasLingkungan;
                    $kualitasLingkungan->kabupaten_kota_id =$kabupatenKotaId;
                    $kualitasLingkungan->kategori_kualitas_lingkungan_id =$kategoriKualitasLingkunganId;
                    $kualitasLingkungan->tahun = $tahun;
                }

                $kualitasLingkungan->nilai = $request->nilai[$index];
                $kualitasLingkungan->tanggal_pendataan = $request->tanggal_pendataan[$index];
                $kualitasLingkungan->save();
            }
            DB::commit();
            return response()->json([
                'success' => 'Berhasil menyimpan data kualitas lingkungan.'
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
            $kualitasLingkungan = DataKualitasLingkungan::find($id);
            if (!$kualitasLingkungan) {
                return response()->json([
                    'errors' => 'Data kualitas lingkungan tidak ditemukan.'
                ]);
            }
            $kualitasLingkungan->nilai = $request->nilai;
            $kualitasLingkungan->save();

            return response()->json([
                'success' => 'Berhasil mengubah nilai indeks.'
            ]);
        } catch (\Throwable $th) {

            return response()->json([
                'errors' => $th->getMessage()
            ]);
        }
    }
}
