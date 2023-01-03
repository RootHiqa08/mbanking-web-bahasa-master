<?php

namespace App\Http\Controllers;

use App\Models\Transactions;
use App\Http\Requests\StoreTransactionsRequest;
use App\Http\Requests\UpdateTransactionsRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TransactionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function admin(){
        $user = User::where('nik','!=',1)->orderBy('status', 'asc')->get();
        return view('pages.admin',['users'=>$user]);
    }
    public function verif(Request $request){
        $user=User::updateOrCreate([
            'id' => $request->users_id
           ],[
            'status'=>'verif'
        ]);
        return back()->with('success','Successfully verified customer');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTransactionsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTransactionsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transactions  $transactions
     * @return \Illuminate\Http\Response
     */
    public function show(Transactions $transactions)
    {
        //recent transaksi
        $recent = Transactions::where('users_id','=',auth()->user()->id)->join('users', 'transactions.dest', '=', 'users.card')->groupBy('dest')->orderBy('transactions.id','desc')->get();
        //get sesi dari user
        $user = auth()->user();
        //ke halaman transaksi
        return view('pages.transaction',['user'=>$user,'recents'=>$recent]);
    }
    public function show_saldo(Transactions $transactions)
    {
        //get sesi dari user
        $user = auth()->user();
        //ke halaman transaksi
        return view('pages.saldo',['user'=>$user]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Transactions  $transactions
     * @return \Illuminate\Http\Response
     */
    public function edit(Transactions $transactions)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTransactionsRequest  $request
     * @param  \App\Models\Transactions  $transactions
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTransactionsRequest $request, Transactions $transactions)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transactions  $transactions
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transactions $transactions)
    {
        //
    }
    public function card(Request $request){
        $status="failed";
        $message="Data not found.";
        //cek user database
        $users=User::where('card','=',$request->card)->first();
        //array data dummy
        $kosong=array(
            'id' => 1,
            'name' => 'Data not found.',
            'nik' => 43,
            'tel' => 257,
            'card' => 5602242014592959,
            'email' => '',
            'username' => '',
            'status' => '',
            'created_at' => '-000001-11-30T00:00:00.000000Z',
            'updated_at' => '-000001-11-30T00:00:00.000000Z',
        );
        //jika ada data
        if($users){
            $status='success';
            $message='Successfully got the data';
            //response
            return response()->json(['status'=> $status, 'messages'=>$message, 'data'=> $users]);
        }else{
            return response()->json(['status'=> $status, 'messages'=>$message, 'data'=> $kosong]);
        }
    }

    public function transfer(Request $request){
        //validasi form
        $validator = Validator::make($request->all(), [
            'users_id' => 'required',
            'credit' => 'required',
            'from' => 'required',
            'dest' => 'required',
            'desc' => 'required',
        ]);
        //jika gagal
        if ($validator->fails()) {
            return response()->json(['status'=> "Error", 'messages'=>"", 'data'=> "Unable to validate data"]);
        }
        //cek transaksi terakhir
        $last=Transactions::where('users_id','=',$request->users_id)->orderBy('id','desc')->first();

        //variabel saldo
        if($last){
            $sal=$last->saldo;
        }else{
            $sal=0;
        }
        //estimasi saldo setelah transaksi
        $saldo = $sal+$request->debit-$request->credit;
        //mengambil data tujuan
        $dest = User::where('card','=',$request->dest)->first();
        //ambil transaksi terakhir tujuan
        $last2=Transactions::where('users_id','=',$dest->id)->orderBy('id','desc')->first();
        $nominal = 0;
        $no_trans = "ERROR";
        //saldo tujuan
                if($last){
                    $sal2=$last2->saldo;
                }else{
                    $sal2=0;
                }
                //cek saldo masih cukup
                if($request->credit < $sal2){
                    //input database pengirim
                    $verifications=Transactions::updateOrCreate([
                        'id' => $request->id
                       ],[
                        'users_id' => $request->users_id,
                            'debit' => 0,
                            'credit' => $request->credit,
                            'saldo' => $saldo,
                            'from' => $request->from,
                            'dest' => $request->dest,
                            'desc' => $request->desc,
                    ]);
                    $status='success';
                    $message='Data saved successfully';
                    //update saldo;
                    $saldo2 = $sal2-$request->credit;
                    //input data penerima
                    $verifications=Transactions::create([
                        'users_id' => $dest->id,
                        'debit' => $request->credit,
                        'credit' =>0,
                        'saldo' => $saldo2,
                        'from' => $request->from,
                        'dest' => $request->dest,
                        'desc' => $request->desc,
                    ]);
                    if($verifications->debit>0){
                        $nominal = $verifications->debit;
                    }else{
                        $nominal =$verifications->credit;
                    }
                    //ubah format untuk bukti transfer
                    $date = Carbon::parse($verifications->created_at)->format("Y-mm-dd");
                    $date_trans = Carbon::parse($verifications->created_at)->format("dd-M-Y");
                    $no_trans="HANBDB".$date.$verifications->id;
                    $ret = '<table>
                        <tbody>
                            <tr class="text-sm">
                                <td>No Trans </td>
                                <td>: '.$no_trans.'</td>
                            </tr>
                            <tr class="text-sm">
                                <td>Date </td>
                                <td>: '.$date_trans.'</td>
                            </tr>
                            <tr class="text-sm">
                                <td>Bank Tujuan </td>
                                <td>: '.$request->kode.'</td>
                            </tr>
                        </tbody>
                    </table>
                    <hr>
                    <p class="h5 text-success text-center">Successful Transfer</p>
                    <p class="text-sm">The transfer has been successfully carried out with the following details.</p>
                    <table>
                        <tbody>
                            <tr class="text-sm">
                                <td>Recipient Name </td>
                                <td>: '.$dest->name.'</td>
                            </tr>
                            <tr class="text-sm">
                                <td>No Rek </td>
                                <td>: '.$dest->card.'</td>
                            </tr>
                            <tr class="text-sm">
                                <td>Nominal </td>
                                <td class="text-success font-weight-bolder">: Rp. '.number_format($nominal,0,',','.').'</td>
                            </tr>
                            <tr class="text-sm">
                                <td>Massage </td>
                                <td>: '.$verifications->desc.'</td>
                            </tr>
                        </tbody>
                    </table>
                    <small>Continue to multiply transactions and feel the best comfort from us.</small>
                    <hr>
                    <p class="text-center h4 font-weight-bolder text-primary">HINADADE BANK</p>';
                }else{
                    $ret = '
                    <hr>
                    <p class="h5 text-success text-center">Failed Transfer</p>
                    <p class="text-sm">The transfer failed carried out with the following details.</p>
                    <p class="text-center h3">Saldo Tidak Cukup</p>
                    <small>Continue to multiply transactions and feel the best comfort from us.</small>
                    <hr>
                    <p class="text-center h4 font-weight-bolder text-primary">HINADADE BANK</p>';
                }

        
        //data akan di return
    //return response
    return response()->json(['status'=> 'success', 'messages'=>'Succeed', 'data'=> $ret]);
    }
    public function topup(Request $request){
        //validasi form
        $validator = Validator::make($request->all(), [
            'users_id' => 'required',
            'debit' => 'required',
            'from' => 'required',
            'dest' => 'required',
            'desc' => 'required',
        ]);
        //jika gagal
        if ($validator->fails()) {
            return response()->json(['status'=> "Error", 'messages'=>"", 'data'=> "Unable to validate data"]);
        }
        //cek transaksi terakhir
        $last=Transactions::where('users_id','=',$request->users_id)->orderBy('id','desc')->first();

        //variabel saldo
        if($last){
            $sal=$last->saldo;
        }else{
            $sal=0;
        }
        //estimasi saldo setelah transaksi
        $saldo = $sal+$request->debit;
        //mengambil data tujuan
        $dest = User::where('card','=',$request->dest)->first();
        //ambil transaksi terakhir tujuan
        $last2=Transactions::where('users_id','=',$dest->id)->orderBy('id','desc')->first();
        //saldo tujuan
                if($last){
                    $sal2=$last2->saldo;
                }else{
                    $sal2=0;
                }
                //cek saldo masih cukup
                if($request->debit){
                    //input database pengirim
                    $verifications=Transactions::updateOrCreate([
                        'id' => $request->id
                       ],[
                        'users_id' => $request->users_id,
                            'debit' => $request->debit,
                            'credit' => 0,
                            'saldo' => $saldo,
                            'from' => $request->from,
                            'dest' => $request->dest,
                            'desc' => $request->desc,
                    ]);
                    $status='success';
                    $message='Data saved successfully';
                }
                //ubah format untuk bukti transfer
        $date = Carbon::parse($verifications->created_at)->format("Y-mm-dd");
        $date_trans = Carbon::parse($verifications->created_at)->format("dd-M-Y");
        $no_trans="HANBDB".$date.$verifications->id;
        $nominal = 0;

        if($verifications->debit>0){
            $nominal = $verifications->debit;
        }else{
            $nominal =$verifications->credit;
        }
        //data akan di return
        $ret = '<table>
        <tbody>
            <tr class="text-sm">
                <td>No Trans </td>
                <td>: '.$no_trans.'</td>
            </tr>
            <tr class="text-sm">
                <td>Date </td>
                <td>: '.$date_trans.'</td>
            </tr>
        </tbody>
    </table>
    <hr>
    <p class="h5 text-success text-center">Transaksi Berhasil</p>
    <p class="text-sm">The transfer has been successfully carried out with the following details.</p>
    <table>
        <tbody>
            <tr class="text-sm">
                <td>Recipient Name </td>
                <td>: '.$dest->name.'</td>
            </tr>
            <tr class="text-sm">
                <td>No Rek </td>
                <td>: '.$dest->card.'</td>
            </tr>
            <tr class="text-sm">
                <td>Nominal </td>
                <td class="text-success font-weight-bolder">: Rp. '.number_format($nominal,0,',','.').'</td>
            </tr>
            <tr class="text-sm">
                <td>Massage </td>
                <td>: '.$verifications->desc.'</td>
            </tr>
        </tbody>
    </table>
    <small>Continue to multiply transactions and feel the best comfort from us.</small>
    <hr>
    <p class="text-center h4 font-weight-bolder text-primary">HINADADE BANK</p>';
    //return response
    return response()->json(['status'=> 'success', 'messages'=>'successfully', 'data'=> $ret]);
    }
}
