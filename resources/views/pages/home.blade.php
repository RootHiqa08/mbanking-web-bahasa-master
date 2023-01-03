@extends('layouts.app', ['class' => ' bg-gray-100'])

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-xl-12 col-sm-12 mb-xl-0 mb-12">
                <div class="card bg-gradient-success">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="h4 mb-0 text-uppercase font-weight-bold"><span class="bolder">Hi!</span> {{$users->name}}</p>
                                    <h6 class="text-muted">
                                        Your current balance
                                    </h6>
                                    <h1 class="text-white bolder ">
                                        @currency($saldo)
                                    </h1>
                                    <p class="mb-0">
                                        Multiply transfers and feel the best comfort from us.
                                    </p>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-white shadow-primary text-center rounded-circle">
                                    <i class="ni ni-money-coins text-lg text-success opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        <div class="row mt-4">
            <div class="col-lg-7 mb-lg-0 mb-4 col-sm-12">
                <div class="card z-index-2 h-100">
                    <div class="card-header pb-0 pt-3 bg-transparent">
                        <h6 class="text-capitalize">History</h6>
                        <p class="text-sm mb-0">
                            <i class="fa fa-history text-success"></i>
                            <span class="font-weight-bold">January</span>
                        </p>
                    </div>
                    <div class="card-body p-3">
                        <table class="table table-responsive table-stripped">
                            <thead>
                                <tr class=" font-weight-bolder table-dark">
                                    <td>Date</td>
                                    <td>Information</td>
                                    <td>Nominal</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                use Carbon\Carbon;
                                function pilih($debit,$credit){
                                    $pilihan = array('simbol' => '+', 'nominal' => 0);
                                    $nominal=0;
                                    if($debit>0){
                                        $nominal=1;
                                    }
                                    if($credit>0){
                                        $nominal=2;
                                    }
                                    switch ($nominal) {
                                        case 0:
                                            $pilihan['simbol']='';
                                            $pilihan['nominal']=0;
                                            break;
                                        case 1:
                                            $pilihan['simbol']='+';
                                            $pilihan['nominal']=$debit;
                                            break;
                                        case 2:
                                            $pilihan['simbol']='-';
                                            $pilihan['nominal']=$credit;
                                            break;
                                        default:
                                            $pilihan['simbol']='';
                                            $pilihan['nominal']=0;
                                            break;
                                    }
                                    return $pilihan;
                                }
                                ?>
                                @if ($count>0)
                                    @foreach ($lasts as $last)
                                    <?php 
                                    $pilih = pilih($last->debit,$last->credit);
                                    ?>
                                    <tr>
                                        <td>{{Carbon::parse($last->created_at)->format("d-M")}}</td>
                                        <td>{{$last->desc}} {{$last->dest}}</td>
                                        <td>{{$pilih['simbol']}} @currency($pilih['nominal'])</td>
                                    </tr>
                                    @endforeach
                                @else
                                <tr>
                                    <td colspan="3">No history this month</td>
                                </tr>
                                @endif
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-5" id="user">
                <div class="card h-100 p-0 bg-dark"  style="background-image: url('./img/carousel-1.jpg');
                background-size: cover;">
                    <div class="card-body">
                        <div class="d-flex  justify-content-center">
                            <div class="icon icon-shape icon-xl bg-white shadow-primary text-center rounded-circle">
                                <i class="fa fa-user text-xl text-dark opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    <form id="KaiForm" action="{{route('users_change')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="id" name="id" value="{{$users->id}}">
                        <input type="hidden" id="card" name="card" value="{{$users->card}}">
                        <div class="input_wrapper ">
                            <div class="row">
                              <div class="col">
                                <div class="mb-3">
                                  <label for="name" class="form-label text-white">Full Name :</label>
                                  <input type="text" id="name" name="name" class="dis form-control" required="" disabled value="{{$users->name}}">
                                </div>
                                <div class="mb-3">
                                    <label for="nik" class="form-label text-white">NIK :</label>
                                    <input type="text" id="nik" name="nik" class="dis form-control" required="" disabled value="{{$users->nik}}">
                                  </div>
                                  <div class="mb-3">
                                    <label for="tel" class="form-label text-white">HP / Tel :</label>
                                    <input type="text" id="tel" name="tel" class="form-control dis " required="" disabled value="{{$users->tel}}">
                                  </div>
                                  <div class="mb-3">
                                    <label for="email" class="form-label text-white">Email :</label>
                                    <input type="text" id="email" name="email" class="form-control dis " required="" disabled  value="{{$users->email}}">
                                  </div>
                                  <div class="mb-3">
                                    <label for="username" class="form-label text-white">Username :</label>
                                    <input type="text" id="username" name="username" class="form-control dis " required="" disabled  value="{{$users->username}}">
                                  </div>
                                  <div class="mb-3">
                                    <label for="password" class="form-label text-white" id="pw">New Password: </label>
                                    <input type="text" id="password" name="password" class="form-control ">
                                  </div>  
                                  <div>
                                    <input type="submit" class="dis btn btn-primary btn-block w-100" value="Save Changes" disabled/>
                                    <hr>
                                    <a  href="users_delete/{{$users->id}}" class="dis btn btn-danger btn-block w-100"> Delete Account</a>
                                  </div>
                              </div>
                              
                            </div>
                          </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.footers.auth.footer')
    </div>
@endsection

@push('js')
    <script src="./assets/js/plugins/chartjs.min.js"></script>
    <script>
        
    </script>
@endpush
