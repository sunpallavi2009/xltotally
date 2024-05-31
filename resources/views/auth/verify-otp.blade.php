@extends('layouts.guest')
@section('title', __('Verify Society'))
@section('content')

    <x-auth-session-status class="mb-4" :status="session('status')" />
    
    @include('layouts.partials.guestheader')
    
    <main class="main-content  mt-0">
        <section>
            <div class="page-header min-vh-100">
                <div class="container">
                    <div class="row">
                        @if ($errors->any())
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
                                <strong class="font-bold">Whoops!</strong>
                                <span class="block sm:inline">There were some problems with your input.</span>
                                <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('otp.verify.submit', ['societyId' => $societyId]) }}">
                            @csrf
                            <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column mx-lg-0 mx-auto">
                                <div class="card card-plain">
                                    <div class="card-header pb-0 text-start">
                                        <h4 class="font-weight-bolder">Verify OTP</h4>
                                        <p class="mb-0">Enter your OTP to Verify the phone number</p>
                                    </div>
                                    <div class="card-body">
                                        <form role="form">

                                            <div class="mb-3">
                                                <input type="text" class="form-control form-control-lg" placeholder="Verify OTP"
                                                    aria-label="Verify OTP" id="otp" required name="otp" >
                                                    @if ($errors->has('otp'))
                                                        @foreach ($errors->get('otp') as $message)
                                                            <p class="text-danger text-xs pt-1">{{ $message }}</p>
                                                        @endforeach
                                                    @endif
                                            </div>
               
                                            <div class="text-center">
                                                <button type="submit" class="btn btn-lg btn-primary btn-lg w-100 mt-4 mb-0">Verify OTP</button>
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
                                <h4 class="mt-5 text-white font-weight-bolder position-relative">Society Login Verify</h4>
                                <p class="text-white position-relative"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

@endsection