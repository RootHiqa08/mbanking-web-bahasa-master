<?php

namespace App\Http\Controllers;

// use App\Http\Requests\RegisterRequest;

use App\Models\Transactions;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'nik' => 'required',
            'tel' => 'required',
            'card' => 'required',
            'email' => 'required',
            'username' => 'required',
            'password' => 'required',
            'status' => 'required',
            'terms'=> 'required',
        ]);
        if($request->terms){
            $users=User::updateOrCreate([
                'id' => $request->id
               ],[
                'name' => $request->name,
                'nik' => $request->nik,
                'tel' => $request->tel,
                'card' => $request->card,
                'email' => $request->email,
                'username' => $request->username,
                'password' => $request->password,
                'status' => $request->status,
            ]);
            auth()->login($users);
            if($users){
                $verifications=Transactions::updateOrCreate([
                    'id' => $request->id
                   ],[
                    'users_id' => $users->id,
                        'debit' => 0,
                        'credit' => 0,
                        'saldo' => 0,
                        'from' => $users->card,
                        'dest' => $users->card,
                        'desc' => "New Card",
                ]);
            }
            return redirect('/dashboard');
        }
        
        return back()->with("terms",'Pliss fill all');
    }
}
