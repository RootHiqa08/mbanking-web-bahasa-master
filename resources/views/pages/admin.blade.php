@extends('layouts.app', ['class' => ' bg-gray-100'])

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-xl-12 col-sm-12 mb-xl-0 mb-12">
                <div class="card bg-gradient-danger">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <h1 class="text-white bolder ">
                                        ADMIN PAGE
                                    </h1>
                                    <p class="mb-0">
                                        Please verify the new Account
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
        <div class="row mt-4 justify-content-center">
            <div class="col-lg-10 mb-lg-0 mb-8 col-sm-12">
                <div class="card z-index-2 h-100">
                    <div class="card-header pb-0 pt-3 bg-transparent">
                        <h6 class="text-capitalize">List of Registrants</h6>
                        <p class="text-sm mb-0">
                            <i class="fa fa-history text-success"></i>
                            <span class="font-weight-bold">Set Bank Registrar</span>
                        </p>
                    </div>
                    <div class="card-body p-3">
                       <table class="table table-responsive table-bordered table-striped">
                            <thead class="bg-warning font-weight-bold text-white text-center">
                                <tr>
                                    <td>No</td>
                                    <td>Name</td>
                                    <td>Email</td>
                                    <td>Status</td>
                                    <td>Action</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no=1;?>
                                @foreach ($users as $user)
                                <tr>
                                    <td>{{$no}}</td>
                                    <td>{{$user->name}}</td>
                                    <td>{{$user->email}}</td>
                                    <td>{{$user->status}}</td>
                                    @if ($user->status=='verif')
                                    <td class="text-center"><a href="#" class="btn btn-secondary" disabled>Verified</a></td>
                                    @else
                                    <td class="text-center"><a href="verif/{{$user->id}}" class="btn btn-success">Verifikasi</a></td>
                                    @endif
                                </tr>
                                <?php $no++;?>
                                @endforeach
                            </tbody>
                       </table>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.footers.auth.footer')
    </div>
@endsection

@push('js')

@endpush
