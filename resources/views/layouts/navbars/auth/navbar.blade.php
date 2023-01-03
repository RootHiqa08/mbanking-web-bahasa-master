<div class="container position-sticky z-index-sticky top-0">
    <div class="row">
        <div class="col-12">
            <!-- Navbar -->
            <nav
                class="navbar navbar-expand-lg blur border-radius-lg top-0 z-index-3 shadow position-absolute mt-4 py-2 start-0 end-0 mx-4">
                <div class="container-fluid">
                    <a class="navbar-brand font-weight-bolder ms-lg-0 ms-3 " href="{{ route('home') }}">
                        Welcome to BMII ! Enjoy for Transfer
                    </a>
                    <button class="navbar-toggler shadow-none ms-2" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navigation" aria-controls="navigation" aria-expanded="false"
                        aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon mt-2">
                            <span class="navbar-toggler-bar bar1"></span>
                            <span class="navbar-toggler-bar bar2"></span>
                            <span class="navbar-toggler-bar bar3"></span>
                        </span>
                    </button>
                    <div class="collapse navbar-collapse" id="navigation">
                        <ul class="navbar-nav mx-auto">
                            @if (Auth::user()->email=="admin@gmail.com")
                            <li class="nav-item">
                                <a class="nav-link me-2 {{ Route::currentRouteName() == 'admin' ? 'text-success font-weight-bolder' : '' }}" href="{{ route('admin') }}">
                                    <i class="fas fa-home opacity-6 me-1"></i>
                                    Dashboard
                                </a>
                            </li>
                            @else
                            <li class="nav-item">
                                <a class="nav-link me-2 {{ Route::currentRouteName() == 'home' ? 'text-success font-weight-bolder' : '' }}" href="{{ route('home') }}">
                                    <i class="fas fa-home opacity-6 me-1"></i>
                                    Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link me-2" href="{{ route('saldo') }}">
                                    <i class="fas fa-plus opacity-6 text-dark me-1"></i>
                                    Top Up
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link me-2" href="{{ route('transaction') }}">
                                    <i class="fas fa-exchange-alt opacity-6 text-dark me-1"></i>
                                    Transfer
                                </a>
                            </li>
                            @endif
                            <li class="nav-item">
                                <a class="nav-link me-2" href="#" onclick="logout()"><i class="fas fa-power-off opacity-6 text-dark me-1"></i>
                                    Log Out</a>
                                <form action="{{route('logout')}}" method="POST" >
                                    @csrf
                                    <input type="submit" style="display: none" id="btn-logout" value="klik"/>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <!-- End Navbar -->
        </div>
    </div>
</div>
