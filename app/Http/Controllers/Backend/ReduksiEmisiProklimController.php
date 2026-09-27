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
use App\Models\DataProklim;
use App\Models\ReduksiEmisiProklim;

class ReduksiEmisiProklimController extends Controller
{
    public function index()
    {
        return view('backend.reduksi-emisi-proklim.index', [
            'proklims' => $this->getProklim(),
            'countReduksiEmisiProklim' => $this->countReduksiEmisiProklim()
        ]);
    }

    public function getProklim()
    {
        $getData = DataProklim::get()
                    ->map(function($d){
                        return [
                            'id' => Crypt::encryptString($d->id),
                            'nama' => $d->nama
                        ];
                    });
        return $getData;
    }

    public function countReduksiEmisiProklim()
    {
        return ReduksiEmisiProklim::count();
    }

    public function datatable(Request $request)
    {
        $getDatas = ReduksiEmisiProklim::when($request->data_proklim_id != null, function($q) use ($request){
                    $dataProklimId = Crypt::decryptString($request->data_proklim_id);
                    $q->where('data_proklim_id', $dataProklimId);
                })->when($request->tahun != null, function($q) use ($request){
                    $q->where('tahun', $request->tahun);
                })->get();
        $data = [];
        foreach ($getDatas as $getData) {
            $data[] = [
                'id' => Crypt::encryptString($getData->id),
                'data_proklim_id' => $getData->data_proklim->nama,
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
            'data_proklim_id' => [
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
                    'Jumlah data tahun, nilai, dan tanggal pendataan tidak sama.'
                ]
            ]);
        }

        try {
            $dataProklimId = Crypt::decryptString(
                $request->data_proklim_id
            );
        } catch (DecryptException $e) {
            return response()->json([
                'errors' => [
                    'Proklim tidak valid.'
                ]
            ]);
        }

        try {
            DB::beginTransaction();

            foreach ($request->tahun as $index => $tahun) {
                $reduksiEmisiProklim = ReduksiEmisiProklim::where('data_proklim_id',$dataProklimId)
                                ->where('tahun',$tahun)
                                ->first();

                if (!$reduksiEmisiProklim) {
                    $reduksiEmisiProklim = new ReduksiEmisiProklim;
                    $reduksiEmisiProklim->data_proklim_id =$dataProklimId;
                    $reduksiEmisiProklim->tahun = $tahun;
                }

                $reduksiEmisiProklim->nilai = $request->nilai[$index];
                $reduksiEmisiProklim->tanggal_pendataan = $request->tanggal_pendataan[$index];
                $reduksiEmisiProklim->save();
            }
            DB::commit();
            return response()->json([
                'success' => 'Berhasil menyimpan data reduksi emisi proklim.'
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
            $reduksiEmisiProklim = ReduksiEmisiProklim::find($id);
            if (!$reduksiEmisiProklim) {
                return response()->json([
                    'errors' => 'Data reduksi emisi proklim tidak ditemukan.'
                ]);
            }
            $reduksiEmisiProklim->nilai = $request->nilai;
            $reduksiEmisiProklim->save();

            return response()->json([
                'success' => 'Berhasil mengubah nilai reduksi emisi proklim.'
            ]);
        } catch (\Throwable $th) {

            return response()->json([
                'errors' => $th->getMessage()
            ]);
        }
    }
}
