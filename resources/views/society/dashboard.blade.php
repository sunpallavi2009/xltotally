@php
    $societyCount = App\Models\Society::count();
    $memberCount = App\Models\Member::count();
@endphp
@extends('layouts.society', ['class' => 'g-sidenav-show bg-gray-100'])
@section('title', __('Society Dashboard'))
@section('content')
    @include('layouts.partials.societyTopnav', ['title' => 'Society Dashboard'])
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Society</p>
                                    <h5 class="font-weight-bolder">
                                        {{ $societyCount }}
                                    </h5>
                                    <p class="mb-0">
                                        {{-- <span class="text-success text-sm font-weight-bolder">+55%</span>
                                        since yesterday --}}
                                    </p>
                                </div> 
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                                    <i class="fa fa-user text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Member</p>
                                    <h5 class="font-weight-bolder">
                                        {{ $memberCount }}
                                    </h5>
                                    <p class="mb-0">
                                        {{-- <span class="text-success text-sm font-weight-bolder">+3%</span>
                                        since last week --}}
                                    </p>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-danger shadow-danger text-center rounded-circle">
                                    <i class="fa fa-list text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-lg-12 mb-lg-0 mb-4">
                <div class="card z-index-2 h-100">
                    <div class="card-header pb-0 pt-3 bg-transparent">
                        <h6 class="text-capitalize">overview</h6>
                        <p class="text-sm mb-0">
                            <i class="fa fa-arrow-up text-success"></i>
                            {{-- <span class="font-weight-bold">4% more</span> in 2021 --}}
                        </p>
                    </div>
                    <div class="card-body p-3">
                        
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.partials.footer')
    </div>

@endsection

