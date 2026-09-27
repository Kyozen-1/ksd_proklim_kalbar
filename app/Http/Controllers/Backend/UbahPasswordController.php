<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Hash;
use Auth;

class UbahPasswordController extends Controller
{
    public function index()
    {
        return view('backend.ubah-password.index');
    }

    public function store(Request $request)
    {
        if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
            Alert::error("error","Kata sandi Anda saat ini tidak cocok dengan kata sandi yang Anda gunakan. Silakan coba lagi.");
            return back();
        }

        if(strcmp($request->get('current-password'), $request->get('new-password')) == 0){
            Alert::error("error","Kata Sandi Baru tidak boleh sama dengan kata sandi Anda saat ini. Silakan pilih kata sandi yang berbeda.");
            return back();
        }
        if(!(strcmp($request->get('new-password'), $request->get('new-password-confirm'))) == 0){
            Alert::error("error","Kata Sandi Baru harus sama dengan kata sandi Anda yang telah dikonfirmasi. Silakan ketik ulang kata sandi baru.");
            return back();
        }

        $user = Auth::user();
        $user->password = bcrypt($request->get('new-password'));
        $user->ubah_password = '0';
        $user->save();

        Alert::success("success","Password Sukses Berubah!");
        return redirect()->route('cms.dashboard.index');
    }
}
