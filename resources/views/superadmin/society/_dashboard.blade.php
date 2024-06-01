@extends('layouts.app')
@section('title', __('Society Management'))
@section('content')
    @include('layouts.partials.topnav', ['title' => 'Society Management'])
    <div class="row mt-4 mx-4">
        <div class="col-12">
            <div class="mb-4">
                <div class="card-header pb-0">
                    <div class="alert alert-light" role="alert">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="text-center text-white">
                                    <h6 class="text-black">
                                        <h3><b>{{ $society->name }}</b></h3>
                                        <h6>{{ $society->address1 }}</h6>
                                    </h6>
                                </div>
                            </div>  
                        </div>
                    </div>
                </div>
                <div class="card-body px-4 pt-6 pb-2">
                   <!-- Adding more cards -->
                   <div class="row mt-4 mx-4">


                        <div class="col-md-4">
                            <div class="card mb-4 shadow text-center">
                                <div class="card-header quick-link">
                                    <a href="{{ route('members.index', ['group' => 'Sundry Debtors', 'guid' => $societyGuid]) }}" style="color: #337ab7;">
                                        <i class="fa fa-file-text-o" aria-hidden="true"></i>
                                        <p>Member Ledgers</p>
                                    </a>
                                </div>
                            </div>
                        </div>
    
    
                        <div class="col-md-4">
                            <div class="card mb-4 shadow text-center">
                                <div class="card-header quick-link">
                                    <a href="{{ route('members.index', ['group' => '!Sundry Debtors', 'guid' => $societyGuid]) }}" style="color: #337ab7;">
                                        <i class="fa fa-file-text" aria-hidden="true"></i>
                                        <p>Other Ledgers</p>
                                    </a>
                                </div>
                            </div>
                        </div>
                   
                        <div class="col-md-4">
                            <div class="card mb-4 shadow text-center">
                                <div class="card-header quick-link">
                                    {{-- <a href="{{ route('members.index') }}?guid={{ $societyGuid }}" style="color: #337ab7;"> --}}
                                        <i class="fa fa-line-chart"></i>
                                        <p>Bills</p>
                                    {{-- </a> --}}
                                </div>
                            </div>
                        </div>
                   
                        <div class="col-md-4">
                            <div class="card mb-4 shadow text-center">
                                <div class="card-header quick-link">
                                    {{-- <a href="{{ route('members.index') }}?guid={{ $societyGuid }}" style="color: #337ab7;"> --}}
                                        <i class="fa fa-inr"></i>
                                        <p>Outstanding</p>
                                    {{-- </a> --}}
                                </div>
                            </div>
                        </div>
                    
                        <div class="col-md-4">
                            <div class="card mb-4 shadow text-center">
                                <div class="card-header quick-link">
                                    {{-- <a href="{{ route('members.index') }}?guid={{ $societyGuid }}" style="color: #337ab7;"> --}}
                                        <i class="fa fa-plus"></i>
                                        <p>Add Voucher</p>
                                    {{-- </a> --}}
                                </div>
                            </div>
                        </div>
                    
                        <div class="col-md-4">
                            <div class="card mb-4 shadow text-center">
                                <div class="card-header quick-link">
                                    {{-- <a href="{{ route('members.index') }}?guid={{ $societyGuid }}" style="color: #337ab7;"> --}}
                                        <i class="fa fa-file-text-o"></i>
                                        <p>Day Book</p>
                                    {{-- </a> --}}
                                </div>
                            </div>
                        </div>

                    </div>
                
                
                </div>
            </div>
        </div>
    </div>
@endsection
