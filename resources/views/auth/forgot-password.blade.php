@extends('layouts.guest')
@section('title', __('Reset password'))
@section('content')

    <x-auth-session-status class="mb-4" :status="session('status')" />

    @include('layouts.partials.guestheader')
    
    <main class="main-content  mt-0">
        <section>
            <div class="page-header min-vh-100">
                <div class="container">
                    <div class="row">


                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf
                            <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column mx-lg-0 mx-auto">
                                <div class="card card-plain">
                                    <div class="card-header pb-0 text-start">
                                        <h4 class="font-weight-bolder">Reset your password</h4>
                                        <p class="mb-0">Enter your email and please wait a few seconds</p>
                                    </div>
                                    <div class="card-body">
                                        <form role="form">
                                            <div class="mb-3">
                                                <input type="email" class="form-control form-control-lg" placeholder="Email"
                                                    aria-label="Email" id="email" required name="email" :value="old('email')">
                                                    @if ($errors->has('email'))
                                                        @foreach ($errors->get('email') as $message)
                                                            <p class="text-danger text-xs pt-1">{{ $message }}</p>
                                                        @endforeach
                                                    @endif
                                            </div>
                                            
                                            <div class="text-center">
                                                <button type="submit" class="btn btn-lg btn-primary btn-lg w-100 mt-4 mb-0">Send Reset Link</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </form>



                        <div
                            class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 end-0 text-center justify-content-center flex-column">
                            <div class="position-relative bg-gradient-primary h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center overflow-hidden"
                                style="background-image: url('{{ asset('assets/images/signin-ill.jpg') }}');background-size: cover;">
                                <span class="mask bg-gradient-primary opacity-6"></span>
                                <h4 class="mt-5 text-white font-weight-bolder position-relative">{{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
                                </h4>
                                <p class="text-white position-relative"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
