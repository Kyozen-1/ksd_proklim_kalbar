<?php

namespace App\Http\Controllers\Backend\Pengaturan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Validator;
use DataTables;
use App\Models\User;

class ManajemenAkunController extends Controller
{
    public function index()
    {
        return view('backend.pengaturan.manajemen-akun.index');
    }

    public function datatable()
    {
        $getData = new User;
        $getData = $getData->where('name', '!=', 'superadmin');
        $getData = $getData->statusAktif();
        $getData = $getData->get();
        $data = [];
        foreach ($getData as $d) {
            $data[] = [
                'id' => Crypt::encryptString($d->id),
                'name' => $d->name,
                'email' => $d->email,
                'role' => $d->role
            ];
        }
        $data = collect($data);
        return DataTables::collection($data)
            ->addIndexColumn()
            ->addColumn('aksi', function($data){
                $id = $data['id'];
                $button_change_password = '<button type="button" name="change-password" id="'.$id.'"
                class="change-password btn btn-icon waves-effect btn-warning" title="Change Password"><i class="fas fa-lock"></i></button>';
                $button_edit = '<button type="button" name="edit" id="'.$id.'"
                class="edit btn btn-icon waves-effect btn-warning" title="Edit Data"><i class="fas fa-edit"></i></button>';
                $button_delete = '<button type="button" name="delete" id="'.$id.'" class="delete btn btn-icon waves-effect btn-danger" title="Delete Data"><i class="fas fa-trash"></i></button>';
                $button = $button_edit. ' ' .$button_change_password . ' ' . $button_delete;
                return $button;
            })
            ->rawColumns(['aksi'])
        ->make(true);
    }

    public function store(Request $request)
    {
        $errors = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:users',
            'role' => 'required'
        ]);

        if($errors -> fails())
        {
            return response()->json(['errors' => $errors->errors()->all()]);
        }

        try {
            $password = Str::random(8);

            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($password);
            $user->role = $request->role;
            $user->ubah_password = '1';
            $user->save();

            return response()->json([
                'success' => 'Berhasil membuat akun',
                'password' => $password
            ]);
        } catch (\Throwable $th) {
            return response()->json(['errors' => $th->getMessage()]);
        }
    }

    public function ubahPassword(Request $request)
    {
        $errors = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if($errors -> fails())
        {
            return response()->json(['errors' => $errors->errors()->all()]);
        }

        try {
            $password = Str::random(8);
            $id = Crypt::decryptString($request->id);

            $user = User::find($id);
            $user->password = Hash::make($password);
            $user->ubah_password = '1';
            $user->save();

            return response()->json([
                'success' => 'Berhasil mengubah password akun',
                'password' => $password
            ]);
        } catch (\Throwable $th) {
            return response()->json(['errors' => $th->getMessage()]);
        }
    }

    public function edit($id)
    {
        $id = Crypt::decryptString($id);
        $getData = User::find($id);
        $dataSend = [
            'name' => $getData->name,
            'email' => $getData->email,
            'role' => $getData->role,
        ];

        return response()->json(['result' => $dataSend]);
    }

    public function update(Request $request)
    {
        try {
            $id = Crypt::decryptString($request->hidden_id);

            $errors = Validator::make($request->all(), [
                'hidden_id' => 'required',
                'name' => 'required',
                'email' => 'required|unique:users,email,' . $id,
                'role' => 'required'
            ]);

            if ($errors->fails()) {
                return response()->json([
                    'errors' => $errors->errors()->all()
                ]);
            }

            $user = User::find($id);

            if (!$user) {
                return response()->json([
                    'errors' => ['Data akun tidak ditemukan']
                ]);
            }

            $user->name = $request->name;
            $user->email = $request->email;
            $user->role = $request->role;
            $user->save();

            return response()->json([
                'success' => 'Berhasil merubah data akun'
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'errors' => [$th->getMessage()]
            ]);
        }
    }

    public function destroy(string $id)
    {
        try {
            $id = Crypt::decryptString($id);
            $user = User::find($id);
            $user->status_aktif = '0';
            $user->save();

            return response()->json(['success' => 'Berhasil menghapus akun']);
        } catch (\Throwable $th) {
            return response()->json(['errors' => $th->getMessage()]);
        }
    }
}
