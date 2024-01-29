@extends('auth.auth')
@section('content')
<main class="main-content  mt-0">
    <section>
        <div class="page-header min-vh-100">
            <div class="container">
            <div class="row">
                <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column mx-lg-0 mx-auto">
                <div class="card card-plain">
                    <div class="card-header pb-0 text-start">
                        <h5>Selamat Datang di</h5><h2 class="font-weight-bolder">UNSYMA</h2>
                        <p style="font-size: 15px" class="mb-0">Enter your username and password to login</p>
                    </div>
                    <div class="card-body">
                        @if(Session::has('error'))
                        <div class="alert alert-danger" role="alert" style="text-align: center; color: white">
                            {{Session::get('error')}}
                        </div>
                        @endif
                        <form method="POST" action="{{route('login')}}" role="form">
                            @csrf
                            <div class="mb-3">
                                <input type="text" class="form-control form-control-lg" name="Username" placeholder="Username" aria-label="Username">
                            </div>
                            <div class="mb-3">
                                <input type="password" class="form-control form-control-lg" name="Password" placeholder="Password" aria-label="Password">
                            </div>
                            <div class="text-center">
                                <button vlas="button" class="btn btn-lg btn-primary btn-lg w-100 mt-4 mb-0">Sign in</button>
                            </div>
                        </form>
                    </div>
                </div>
                </div>
                <div class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 end-0 text-center justify-content-center flex-column">
                <div class="position-relative bg-gradient-primary h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center overflow-hidden" style="background-image: url('{{ asset('/img/UNISEC.png') }}'); background-size: cover;">
                    <span class="mask bg-gradient-primary opacity-6"></span>
                </div>
                </div>
            </div>
            </div>
        </div>
    </section>
</main>
@endsection