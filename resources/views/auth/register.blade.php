@extends('layouts.app')

@section('content')
    @include('layouts.navbars.guest.navbar')
    <main class="main-content  mt-0">
        <div class="page-header align-items-start min-vh-90 pt-5 pb-11 m-3 border-radius-lg"
            style="background-image: url('img/mbanking.jpg'); background-position: top;">
            <span class="mask bg-gradient-dark opacity-6"></span>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-5 text-center mx-auto">
                        <h1 class="text-white mb-2 mt-5">Welcome!</h1>
                        <p class="text-lead text-white">Please complete your registration.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row mt-lg-n15 mt-md-n11 mt-n10 justify-content-center">
                <div class="col-xl-6 col-lg-5 col-md-7 mx-auto">
                    <div class="card z-index-0">
                        <div class="card-body">
                            <form method="POST" action="{{ route('register.perform') }}">
                                @csrf
                                <div class="flex flex-col mb-3">
                                    <label for="name">Name in ID card</label>
                                    <input type="text" required name="name" class="form-control" placeholder="Full Name" aria-label="Name" value="{{ old('name') }}">
                                    @error('name') <p class='text-danger text-xs pt-1'> {{ $message }} </p> @enderror
                                </div>
                                <div class="flex flex-col mb-3">
                                    <label for="nik">NIK</label>
                                    <input type="number" required name="nik" class="form-control" placeholder="NIK" aria-label="Nik" value="{{ old('nik') }}" >
                                    @error('number') <p class='text-danger text-xs pt-1'> {{ $message }} </p> @enderror
                                </div>
                                <div class="flex flex-col mb-3">
                                    <label for="nik">Number Phone</label>
                                    <input type="tel" name="tel" class="form-control"  required placeholder="Tel/HP" aria-label="Tel" value="{{ old('tel') }}" >
                                    @error('tel') <p class='text-danger text-xs pt-1'> {{ $message }} </p> @enderror
                                </div>
                                <div class="flex flex-col mb-3">
                                    <label for="card">No Kartu</label>
                                    <input type="card" name="card" class="form-control" required placeholder="Number Card" aria-label="Card" value="{{ old('card') }}" >
                                    @error('card') <p class='text-danger text-xs pt-1'> {{ $message }} </p> @enderror
                                </div>
                                <hr>
                                <div class="flex flex-col mb-3">
                                    <input type="email" name="email" class="form-control" placeholder="Email" required aria-label="Email" value="{{ old('email') }}" >
                                    @error('email') <p class='text-danger text-xs pt-1'> {{ $message }} </p> @enderror
                                </div>
                                <div class="flex flex-col mb-3">
                                    <input type="text" name="username" class="form-control" placeholder="Username" required aria-label="username" value="{{ old('username') }}" >
                                    @error('username') <p class='text-danger text-xs pt-1'> {{ $message }} </p> @enderror
                                </div>
                                <div class="flex flex-col mb-3">
                                    <input type="password" name="password" class="form-control" placeholder="Password" aria-label="Password" required>
                                    @error('password') <p class='text-danger text-xs pt-1'> {{ $message }} </p> @enderror
                                </div>
                                <div class="form-check form-check-info text-start">
                                    <input class="form-check-input" type="checkbox" name="terms" id="flexCheckDefault" >
                                    <label class="form-check-label" for="flexCheckDefault">
                                        I agree the <a href="javascript:;" class="text-dark font-weight-bolder">Terms and
                                            Conditions</a>
                                    </label>
                                    @error('terms') <p class='text-danger text-xs'> {{ $message }} </p> @enderror
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn bg-gradient-dark w-100 my-4 mb-2">Sign up</button>
                                </div>
                                <p class="text-sm mt-3 mb-0">Already have an account? <a href="{{ route('login') }}"
                                        class="text-dark font-weight-bolder">Sign in</a></p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    @include('layouts.footers.guest.footer')
@endsection
