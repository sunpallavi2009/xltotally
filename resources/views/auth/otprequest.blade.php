@extends('layouts.guest')

@section('content')

    <x-auth-session-status class="mb-4" :status="session('status')" />
    
    @include('layouts.partials.guestheader')
    
    <main class="main-content  mt-0">
        <section>
            <div class="page-header min-vh-100">
                <div class="container">
                    <div class="row">


                        <form id="otpForm" method="POST" action="{{ route('sendOtp') }}">
                            @csrf
                            <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column mx-lg-0 mx-auto">
                                <div class="card card-plain">
                                    <div class="card-header pb-0 text-start">
                                        <h4 class="font-weight-bolder">Sign In</h4>
                                        <p class="mb-0">Enter your phone number and select society to sign in</p>
                                    </div>
                                    <div class="card-body">
                                        <form role="form">

                                            <div class="mb-3">
                                                <input type="number" class="form-control form-control-lg" placeholder="Phone Number"
                                                    aria-label="Phone Number" id="phone" required name="phone" :value="old('phone')">
                                                    @if ($errors->has('phone'))
                                                        @foreach ($errors->get('phone') as $message)
                                                            <p class="text-danger text-xs pt-1">{{ $message }}</p>
                                                        @endforeach
                                                    @endif
                                            </div>

                                            <div class="mb-3" id="society-container">
                                                <input type="text" class="form-control form-control-lg" placeholder="Society Name"
                                                    aria-label="Society" id="society" required name="society" :value="old('society')" disabled>
                                                    @if ($errors->has('society'))
                                                        @foreach ($errors->get('society') as $message)
                                                            <p class="text-danger text-xs pt-1">{{ $message }}</p>
                                                        @endforeach
                                                    @endif
                                            </div>
                                            
               
                                            <div class="text-center">
                                                <button type="submit" class="btn btn-lg btn-primary btn-lg w-100 mt-4 mb-0">Send OTP</button>
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
                                <h4 class="mt-5 text-white font-weight-bolder position-relative">Society Login Page</h4>
                                <p class="text-white position-relative"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

@endsection
@push('javascript')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const phoneInput = document.getElementById('phone');
            const societyInput = document.getElementById('society');
            const society = @json($society);
    
            phoneInput.addEventListener('input', function () {
                const typedPhone = phoneInput.value;
                const matchedSociety = society.find(society => society.phone.startsWith(typedPhone));
                if (matchedSociety) {
                    societyInput.value = matchedSociety.name;
                    societyInput.closest('.mb-3').style.display = 'block'; // Show the user container
                } else {
                    societyInput.value = '';
                    societyInput.closest('.mb-3').style.display = 'none'; // Hide the user container
                }
            });
    
            // Hide the user container initially
            societyInput.closest('.mb-3').style.display = 'none';
    
            document.getElementById('otpForm').addEventListener('submit', function() {
                document.getElementById('submitBtn').innerHTML = 'Sending...';
            });
        });
    </script>
@endpush
