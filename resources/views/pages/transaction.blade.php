@extends('layouts.app', ['class' => ' bg-gray-100'])

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-xl-12 col-sm-12 mb-xl-0 mb-12">
                <div class="card bg-gradient-warning">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <h1 class="text-white bolder ">
                                        FORM TRANSFER
                                    </h1>
                                    <p class="mb-0">
                                        Continue to multiply transactions and feel the best comfort from us.
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
                        
                        <p class="text-sm mb-0">
                            <i class="fa fa-history text-success"></i>
                            <span class="font-weight-bold">Please complete before making the transfer</span>
                        </p>
                    </div>
                    <div class="card-body p-3">
                        <form id="form-debit">
                            <input type="hidden" name="users_id" id="users_id" value="{{$user->id}}"/>
                            <input type="hidden" name="from" id="from" value="{{$user->card}}"/>
                            <div class="form-group">
                                <label for="card">Number Card / Rekening</label>
                                <div class="input-group">
                                    <select class="form-lg form-controll" id="kode" name="kode">
                                        <option value="Bank BCA">014 - Bank BCA</option>
                                        <option value="Bank BRI">002 - Bank BRI</option>
                                        <option value="Bank BNI">009 - Bank BNI</option>
                                        <option value="Bank BTN">200 - Bank BTN</option>
                                        <option value="Bank MANDIRI">008 - BANK MANDIRI</option>
                                        <option value="Bank BSI (Bank Syariah Indonesia)">451 - Bank BSI </option>
                                        <option value="Bank CIMB NIAGA">022 - Bank CIMB NIAGA</option>
                                        <option value="Bank CIMB NIAGA Syariah">023 - CIMB NIAGA Syariah</option>
                                        <option value="Bank HINADADE">087 - Bank HINADADE</option>
                                    </select>
                                    <input type="text" id="card" name="card" class="form-lg form-control"/>
                                      <a href="#" id="btn_check" onclick="card_check()" class="btn mb-0 btn-lg btn-block btn-warning" >Cek</a>
                                </div>
                            </div>
                            <div class="alert alert-warning" role="alert">
                                <p class="text-white h5 font-weight-bolder text-center" id="name"> Klik cek</p>
                            </div>
                            <div class="form-group">
                                <label for="credit">Nominal </label>
                                <input type="credit" class="dis form-control form-lg" id="credit" name="credit" disabled/>
                            </div>
                            <div class="form-group">
                                <label for="nominal">Description</label> 
                                <input type="text" class="dis form-control form-lg" id="desc" name="desc" disabled/>
                            </div>
                            <div class="form-group">
                                <input id="btn_trans" class="dis form-control btn btn-dark" value="Transfer" disabled type = "button"/>
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
        var availableTags = [{{$kartu}}];
        $( "#card" ).autocomplete({
            source: [@foreach ($recents as $recent)
                        <?php $tujuan= $recent->dest; if($no<1){echo '{label:"'.$recent->name.' - '.$tujuan.'", value:"'.$tujuan.'"}';}else{echo ', {label:"'.$recent->name.' - '.$tujuan.'",value:"'.$tujuan.'"}';}$no++;?>
                    @endforeach],
            classes: {
                "ui-autocomplete": "highlight"
            },
            response: function (event, ui) {
                if (ui.content.length < 1) {
                    ui.content.push({
                        'label': 'Tidak ada riwayat transfer',
                        'value': ''
                    });
                }
                ui.content.push({
                        'label': 'Transfer terakhir',
                        'value': ''
                    });
            }

        }).data("ui-autocomplete")._renderItem = function (ul, item) {
        //Add the .ui-state-disabled class and don't wrap in <a> if value is empty
            if(item.value ==''){
                return $('<li class="ui-state-disabled">'+item.label+'</li>').appendTo(ul);
            }else{
                return $("<li>")
                .append("<a>" + item.label + "</a>")
                .appendTo(ul);
            }
        };
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        function card_check(){
            var card = $("#card").val();
            var kode = $("#kode").val();
            $("#name").html('Memuat data ...');
            $.ajax({
                type:'POST',
                url:"{{route('card_check')}}",
                data: {card:card,kode:kode},
                    success:function(data){
                    $("#name").html(kode+" - "+data.data.name);
                    $('.dis').attr('disabled',false);
                },
                error: function(data){
                    console.log(data);
                }
            });
        };
        function edit(){
            $('.dis').attr('disabled',false);
        };
        $("#btn_trans").click(function(e){
            e.preventDefault();
            var dest = $("#card").val();
            var credit = $("#credit").val();
            var desc = $("#desc").val();
            var users_id = $("#users_id").val();
            var kode = $("#kode").val();
            var from = $("#from").val();
            //$('#btn_trans').attr('disabled',true);
            $("#result").html('Memproses Transaksi ...');
            $.ajax({
                type:'POST',
                url:"{{route('transfer')}}",
                data: {dest:dest,credit:credit,desc:desc,users_id:users_id,from:from,kode:kode},
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
