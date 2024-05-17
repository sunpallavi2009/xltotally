@extends('layouts.guest')

@section('content')

    <x-auth-session-status class="mb-4" :status="session('status')" />

    @include('layouts.partials.guestheader')
    
    <main class="main-content  mt-0">
        <section>
            <div class="page-header min-vh-100">
                <div class="container">
                    <div class="row">


                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column mx-lg-0 mx-auto">
                                <div class="card card-plain">
                                    <div class="card-header pb-0 text-start">
                                        <h4 class="font-weight-bolder">Register</h4>
                                        <p class="mb-0">Enter your details to create an account</p>
                                    </div>
                                    <div class="card-body">
                                        <form role="form">
                                            <div class="mb-3">
                                                <input type="text" class="form-control form-control-lg" placeholder="Name"
                                                    aria-label="Name" id="name" required name="name" :value="old('name')">
                                                    @if ($errors->has('name'))
                                                        @foreach ($errors->get('name') as $message)
                                                            <p class="text-danger text-xs pt-1">{{ $message }}</p>
                                                        @endforeach
                                                    @endif
                                            </div>
                                            <div class="mb-3">
                                                <input type="email" class="form-control form-control-lg" placeholder="Email"
                                                    aria-label="Email" id="email" required name="email" :value="old('email')">
                                                    @if ($errors->has('email'))
                                                        @foreach ($errors->get('email') as $message)
                                                            <p class="text-danger text-xs pt-1">{{ $message }}</p>
                                                        @endforeach
                                                    @endif
                                            </div>
                                            <div class="mb-3">
                                                <input type="password" name="password" required class="form-control form-control-lg" placeholder="Password"
                                                    aria-label="Password">
                                                    @if ($errors->has('password'))
                                                        @foreach ($errors->get('password') as $message)
                                                            <p class="text-danger text-xs pt-1">{{ $message }}</p>
                                                        @endforeach
                                                    @endif
                                            </div>
                                            <div class="mb-3">
                                                <input type="password" name="password_confirmation" required class="form-control form-control-lg" placeholder="Confirm Password"
                                                    aria-label="Confirm Password">
                                                    @if ($errors->has('password_confirmation'))
                                                        @foreach ($errors->get('password_confirmation') as $message)
                                                            <p class="text-danger text-xs pt-1">{{ $message }}</p>
                                                        @endforeach
                                                    @endif
                                            </div>
                                            <div class="mb-3">
                                                <input type="number" class="form-control form-control-lg" placeholder="Phone Number"
                                                    aria-label="Phone Number" id="phone" required name="phone" :value="old('phone')">
                                                    @if ($errors->has('phone'))
                                                        @foreach ($errors->get('phone') as $message)
                                                            <p class="text-danger text-xs pt-1">{{ $message }}</p>
                                                        @endforeach
                                                    @endif
                                            </div>

                                            <div class="mb-3">
                                                <select id="role" name="role" class="form-control form-control-lg" >
                                                    <option value="">Select Role</option>
                                                    @foreach($roles as $role)
                                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('role'))
                                                    @foreach ($errors->get('role') as $message)
                                                        <p class="text-danger text-xs pt-1">{{ $message }}</p>
                                                    @endforeach
                                                @endif
                                            </div>

                                            <div class="text-center">
                                                <button type="submit" class="btn btn-lg btn-primary btn-lg w-100 mt-4 mb-0">Sign
                                                    up</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-center pt-0 px-lg-2 px-1">
                                        <p class="mb-4 text-sm mx-auto">
                                            Already have an account ?
                                            <a href="{{ route('login') }}" class="text-primary text-gradient font-weight-bold">Sign
                                                in</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </form>



                        <div
                            class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 end-0 text-center justify-content-center flex-column">
                            <div class="position-relative bg-gradient-primary h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center overflow-hidden"
                                style="background-image: url('{{ asset('assets/images/signin-ill.jpg') }}');background-size: cover;">
                                <span class="mask bg-gradient-primary opacity-6"></span>
                                <h4 class="mt-5 text-white font-weight-bolder position-relative">Register Page</h4>
                                <p class="text-white position-relative"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
