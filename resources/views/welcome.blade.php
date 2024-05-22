@extends('layouts.guest')

@section('content')
    @include('layouts.partials.guestheader')
    <main class="main-content  mt-0">
        <section>
            <div class="page-header min-vh-100">
                <div class="container">
                    <div class="row">
                        <div
                            class="col-12 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 end-0 text-center justify-content-center flex-column">
                            <div class="position-relative bg-gradient-primary h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center overflow-hidden"
                                style="background-image: url('{{ asset('assets/images/signin-ill.jpg') }}');
              background-size: cover;">
                                <span class="mask bg-gradient-primary opacity-6"></span>
                                <h4 class="mt-5 text-white font-weight-bolder position-relative">Xltotally</h4>
                                <p class="text-white position-relative">Dashboard</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
