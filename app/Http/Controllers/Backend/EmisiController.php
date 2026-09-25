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
use App\Models\MdSektorUtamaEmisi;
use App\Models\MdJenisEmisi;
use App\Models\DataEmisi;

class EmisiController extends Controller
{
    public function index()
    {
        return view('backend.emisi.index', [
            'kabupatenKotas' => $this->getKabupatenKota(),
            'sektorUtamaEmisis' => $this->getSektorUtamaEmisi(),
            'jenisEmisis' => $this->getJenisEmisi(),
            'countDataEmisi' => $this->countDataEmisi()
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

    public function getSektorUtamaEmisi()
    {
        $getData = MdSektorUtamaEmisi::where('status_aktif', 1)
                    ->get()
                    ->map(function($d){
                        return [
                            'id' => Crypt::encryptString($d->id),
                            'nama' => $d->nama
                        ];
                    });

        return $getData;
    }

    public function getJenisEmisi()
    {
        $getData = MdJenisEmisi::where('status_aktif', 1)
                    ->get()
                    ->map(function($d){
                        return [
                            'id' => Crypt::encryptString($d->id),
                            'nama' => $d->nama,
                            'sektor_utama_emisi_id' => Crypt::encryptString($d->sektor_utama_emisi_id),
                            'sektor_utama_emisi' => $d->sektor_utama_emisi->nama,
                            'satuan' => $d->satuan,
                            'jenis_perhitungan' => $d->jenis_perhitungan
                        ];
                    });

        return $getData;
    }

    public function countDataEmisi()
    {
        return DataEmisi::count();
    }

    public function datatable(Request $request)
    {
        $getDatas = DataEmisi::with([
                            'kabupaten_kota',
                            'jenis_emisi',
                            'jenis_emisi.sektor_utama_emisi'
                        ])
                        ->when($request->kabupaten_kota_id != null, function($q) use ($request){
                            $kabupatenKotaId = Crypt::decryptString($request->kabupaten_kota_id);
                            $q->where('kabupaten_kota_id', $kabupatenKotaId);
                        })
                        ->when($request->jenis_emisi_id != null, function($q) use ($request){
                            $jenisEmisiId = Crypt::decryptString($request->jenis_emisi_id);
                            $q->where('jenis_emisi_id', $jenisEmisiId);
                        })
                        ->when($request->tahun != null, function($q) use ($request){
                            $q->where('tahun', $request->tahun);
                        })
                        ->get();
        $data = [];
        foreach ($getDatas as $getData) {
            $data[] = [
                'id' => Crypt::encryptString($getData->id),
                'kabupaten_kota_id' => $getData->kabupaten_kota ? $getData->kabupaten_kota->name : '-',
                'sektor_utama_emisi_id' => $getData->jenis_emisi && $getData->jenis_emisi->sektor_utama_emisi ? $getData->jenis_emisi->sektor_utama_emisi->nama : '-',
                'jenis_emisi_id' => $getData->jenis_emisi ? $getData->jenis_emisi->nama : '-',
                'satuan' => $getData->jenis_emisi ? $getData->jenis_emisi->satuan : '-',
                'jenis_perhitungan' => $getData->jenis_emisi ? $getData->jenis_emisi->jenis_perhitungan : '-',
                'tahun' => $getData->tahun,
                'nilai' => $getData->nilai,
                'tanggal_pendataan' => $getData->tanggal_pendataan ? Carbon::parse($getData->tanggal_pendataan)->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('j F Y') : '-'
            ];
        }

        $data = collect($data);

        return DataTables::collection($data)
            ->addIndexColumn()
            ->addColumn('aksi', function($data){
                $id = $data['id'];
                $button_edit = '<button type="button" name="edit" id="'.$id.'" class="edit btn btn-icon waves-effect btn-warning" title="Edit Data"> <i class="fas fa-edit"></i> </button>';
                return $button_edit;
            })
            ->editColumn('nilai', function($data){
                return number_format($data['nilai'], 2, ',', '.');
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'kabupaten_kota_id' => [
                'required',
                'string'
            ],

            'jenis_emisi_id' => [
                'required',
                'string'
            ],

            'tahun' => [
                'required',
                'array',
                'min:1'
            ],

            'tahun.*' => [
                'required',
                'integer',
                'digits:4',
                'min:2000',
                'max:2100',
                'distinct'
            ],

            'nilai' => [
                'required',
                'array',
                'min:1'
            ],

            'nilai.*' => [
                'required',
                'numeric',
                'min:0'
            ],

            'tanggal_pendataan' => [
                'required',
                'array',
                'min:1'
            ],

            'tanggal_pendataan.*' => [
                'required',
                'date'
            ]

        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()->all()
            ]);
        }

        $jumlahTahun = count($request->tahun);
        $jumlahNilai = count($request->nilai);
        $jumlahTanggal = count($request->tanggal_pendataan);

        if (
            $jumlahTahun !== $jumlahNilai ||
            $jumlahTahun !== $jumlahTanggal
        ) {
            return response()->json([
                'errors' => [
                    'Jumlah data tahun, nilai, dan tanggal pendataan tidak sama.'
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
            $jenisEmisiId = Crypt::decryptString(
                $request->jenis_emisi_id
            );
        } catch (DecryptException $e) {
            return response()->json([
                'errors' => [
                    'Jenis emisi tidak valid.'
                ]
            ]);
        }

        try {
            DB::beginTransaction();

            foreach ($request->tahun as $index => $tahun) {
                $emisi = DataEmisi::where('kabupaten_kota_id', $kabupatenKotaId)
                    ->where('jenis_emisi_id', $jenisEmisiId)
                    ->where('tahun', $tahun)
                    ->first();

                if (!$emisi) {
                    $emisi = new DataEmisi;
                    $emisi->kabupaten_kota_id = $kabupatenKotaId;
                    $emisi->jenis_emisi_id = $jenisEmisiId;
                    $emisi->tahun = $tahun;
                    $emisi->status_aktif = 1;
                }
                $emisi->nilai = $request->nilai[$index];
                $emisi->tanggal_pendataan = $request->tanggal_pendataan[$index];
                $emisi->save();
            }

            DB::commit();

            return response()->json([
                'success' => 'Berhasil menyimpan data emisi.'
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
            ]
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()->all()
            ]);
        }

        try {
            $id = Crypt::decryptString(
                $request->id
            );

        } catch (\Throwable $th) {
            return response()->json([
                'errors' => 'ID data tidak valid.'
            ]);
        }

        try {
            $emisi = DataEmisi::find($id);
            if (!$emisi) {
                return response()->json([
                    'errors' => 'Data emisi tidak ditemukan.'
                ]);
            }

            $emisi->nilai = $request->nilai;
            $emisi->save();
            return response()->json([
                'success' => 'Berhasil mengubah nilai emisi.'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'errors' => $th->getMessage()
            ]);
        }
    }
}
