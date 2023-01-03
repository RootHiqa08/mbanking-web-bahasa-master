@extends('layouts.app', ['class' => ' bg-gray-100'])

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-xl-12 col-sm-12 mb-xl-0 mb-12">
                <div class="card bg-gradient-dark">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <h1 class="text-white bolder ">
                                        Add Balance
                                    </h1>
                                    <p class="mb-0">
                                        Continue to make more transfers and feel the best comfort from us.
                                    </p>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-white shadow-primary text-center rounded-circle">
                                    <i class="ni ni-money-coins text-lg text-warning opacity-10" aria-hidden="true"></i>
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
                        <h6 class="text-capitalize">Top Up Instructions</h6>
                        <p class="text-sm mb-0">
                            <i class="fa fa-history text-success"></i>
                            <span class="font-weight-bold">Please follow the steps to top up below</span>
                        </p>
                    </div>
                    <div class="card-body p-3">
                        <form id="form-debit">
                            <input type="hidden" name="users_id" id="users_id" value="{{$user->id}}"/>
                            <input type="hidden" name="from" id="from" value="{{$user->card}}"/>
                            <div class="form-group">
                                <label for="card">Number Card / Rekening</label>
                                <div class="input-group">
                                    <input type="text" value="{{$user->card}}" id="card" name="card" class="form-lg form-control" disabled/>
                                </div>
                            </div>
                            <div class="alert alert-warning" role="alert">
                                <p class="text-white h5 font-weight-bolder text-center" id="name"> {{$user->name}}</p>
                            </div>
                            <div class="form-group">
                                <label for="debit">Nominal </label>
                                <input type="debit" value= "50000" class="dis form-control form-lg" id="debit" name="debit" disabled/>
                            </div>
                            <div class="form-group">
                                <label for="nominal">Information</label> 
                                <input type="text" value="Add Balance" class="dis form-control form-lg" id="desc" name="desc" disabled/>
                            </div>
                            <div class="form-group">
                                <input id="btn_trans" class="dis form-control btn btn-dark" value="Add Balance" type = "button" disabled/>
                            </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5" >
                <div class="card h-100 p-0 bg-gradient-light" style="background-image: url('./img/mbanking.jpg');background-size: cover;">
                    <div class="card-body">
                        <div class="d-flex  justify-content-center">
                            <div class="icon icon-shape icon-xl bg-white shadow-primary text-center">
                                <img src="{{url('img/logos/logo_remove.png')}}" class="img-responsive w-100"/>
                            </div>
                        </div>
                        <div class="card mt-4 opacity-7">
                            <div class="card-body" id="result">
                                <hr>
                                <p class="text-center h4 font-weight-bolder text-primary">by HINADADE BANK</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.footers.auth.footer')
    </div>
    <?php $kartu=""; $no=0;?>
@endsection

@push('js')
    <script src="./assets/js/plugins/chartjs.min.js"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $("#btn_trans").click(function(e){
            e.preventDefault();
            var dest = $("#card").val();
            var debit = $("#debit").val();
            var desc = $("#desc").val();
            var users_id = $("#users_id").val();
            var from = $("#from").val();
            //$('#btn_trans').attr('disabled',true);
            $("#result").html('Process Transfers ...');
            $.ajax({
                type:'POST',
                url:"{{route('topup')}}",
                data: {dest:dest,debit:debit,desc:desc,users_id:users_id,from:from},
                    success:function(data){
                    console.log(data);
                    $("#result").html(data.data);
                },
                error: function(data){
                    console.log(data);
                }
            });
        });
    </script>
@endpush
