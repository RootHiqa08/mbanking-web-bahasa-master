<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /**
     * Display login page.
     *
     * @return Renderable
     */
    public function show()
    {
        //return page
        return view('auth.login');
    }

    public function login(Request $request)
    {
        //cek inputan dari form
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        //cek data apakah sesuai
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            //generate session
            $request->session()->regenerate();
            //kembali ke home
            if(Auth::user()->nik==1){
                return redirect()->intended('admin');
            }
            return redirect()->intended('dashboard');
        }
        //kembali ke home dengan pesan error
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(Request $request)
    {
        //perintah logout
        Auth::logout();
        //hapus sesi
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        //kembali ke login
        return redirect('/login');
    }
    public function edit_users(Request $request){
        //validasi form
        $validator = Validator::make($request->all(), [
            'users_id' => 'required',
            'name' => 'required',
            'nik' => 'required',
            'tel' => 'required',
            'email' => 'required',
            'username' => 'required'
        ]);
        //jika pasword terisi
        if($request->password){
            //update database
            $users=User::updateOrCreate([
                'id' => $request->id
               ],[
                'name' => $request->name,
                'nik' => $request->nik,
                'tel' => $request->tel,
                'email' => $request->email,
                'username' => $request->username,
                'password' => $request->password,
                'card' => $request->card,
            ]);
        }else{
            //update database
            $users=User::updateOrCreate([
                'id' => $request->id
               ],[
                'name' => $request->name,
                'nik' => $request->nik,
                'tel' => $request->tel,
                'email' => $request->email,
                'username' => $request->username,
                'card' => $request->card,
            ]);
        }
        //kirim pesan sukses
        Session::flash('success', 'Data berhasil di ubah.' );
        //kembali ke home
        return redirect()->route('home');
    }
    public function delete_users(Request $request){
        //validasi form
        $validator = Validator::make($request->all(), [
            'users_id' => 'required'
        ]);
        //ubah database
        $users=User::updateOrCreate([
            'id' => $request->users_id
           ],[
            'status' => 'nonaktif',
        ]);
        //clear sesi
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        //Kirim pesan sekaligus ke halaman login
        Session::flash('success', 'Akun berhasil di hapus.' );
        return redirect()->route('login');
    }
}
