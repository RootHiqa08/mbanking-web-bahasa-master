<?php

namespace App\Http\Controllers;

use App\Models\Transactions;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
        /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        //ambil data session
        $user = auth()->user();
        //ambil data transaksi terakhir
        $trans=Transactions::where('users_id','=',$user->id)->orderBy('id','desc')->first();
        //cek saldo
        if($trans){
            $saldo=$trans->saldo;
        }else{
            $saldo=0;
        }
        //bulan sekarang
        $now = Carbon::now()->format("m");
        //cek filter bulan keberapa
        if($request->type){
            //convert dari dan ke tanggal ke format date
            $from = Carbon::parse($request->from)->format("m");
            $to = Carbon::parse($request->to)->format("m");
            //cek transaksi terakhir
            $last=Transactions::where('users_id','=',$user->id)->whereBetween('created_at',$from,$to)->get();
        }else{
            //cek transaksi terakhir
            $last=Transactions::where('users_id','=',$user->id)->whereMonth('created_at',$now)->get();
        }
        //kembalikan data
        return view('pages.home',['users'=>$user,'saldo'=>$saldo,'lasts'=>$last,'count'=>$last->count()]);
    }
}
