@extends('layouts.app')

@section('content')
    @include('layouts.partials.topnav', ['title' => 'Society Management'])
    <div class="row mt-4 mx-4">
        <div x-data="society" class="col-12">
            {{-- <div class="text-end alert alert-light" role="alert">
                    <a href="{{ route('roles.create') }}" class="btn btn-sm mb-0 me-1 btn-primary">Add Role</a>
            </div> --}}
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <div class="alert alert-light" role="alert">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-6 text-start text-white">
                                    <h6 class="text-black">Add Society</h6>
                                </div>
                                <div class="col-lg-6 text-end">
                                    <a href="{{ route('society.index') }}" class="btn btn-sm mb-0 me-1 btn-primary">Cancel</a>
                                </div>
                            </div>  
                        </div>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="container-fluid py-4">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
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
                                    <form role="form" method="POST" action="{{ route('society.store') }}" enctype="multipart/form-data">
                                        @csrf
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="name" class="form-control-label">Socity Name</label>
                                                        <input id="name" name="name" type="text" class="form-control form-control-lg" placeholder="Name" :value="" required autofocus autocomplete="name" />
                                                        @if ($errors->has('name'))
                                                            @foreach ($errors->get('name') as $message)
                                                                <p class="text-danger text-xs pt-1">{{ $message }}</p>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="state" class="form-control-label">State</label>
                                                        <input id="state" name="state" type="text" class="form-control form-control-lg" placeholder="State" :value="" required autofocus autocomplete="state" />
                                                        @if ($errors->has('state'))
                                                            @foreach ($errors->get('state') as $message)
                                                                <p class="text-danger text-xs pt-1">{{ $message }}</p>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="city" class="form-control-label">City</label>
                                                        <input id="city" name="city" type="text" class="form-control form-control-lg" placeholder="City" :value="" required autofocus autocomplete="city" />
                                                        @if ($errors->has('city'))
                                                            @foreach ($errors->get('city') as $message)
                                                                <p class="text-danger text-xs pt-1">{{ $message }}</p>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="pincode" class="form-control-label">Pincode</label>
                                                        <input id="pincode" name="pincode" type="number" class="form-control form-control-lg" placeholder="Pincode" :value="" required autofocus autocomplete="pincode" />
                                                        @if ($errors->has('pincode'))
                                                            @foreach ($errors->get('pincode') as $message)
                                                                <p class="text-danger text-xs pt-1">{{ $message }}</p>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="phone" class="form-control-label">Phone</label>
                                                        <input id="phone" name="phone" type="number" class="form-control form-control-lg" placeholder="Phone" :value="" required autofocus autocomplete="phone" />
                                                        @if ($errors->has('phone'))
                                                            @foreach ($errors->get('phone') as $message)
                                                                <p class="text-danger text-xs pt-1">{{ $message }}</p>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="address" class="form-control-label">Address</label>
                                                        <textarea id="address" name="address" class="form-control form-control-lg" placeholder="Address" :value="" required autofocus autocomplete="address" /></textarea>
                                                        @if ($errors->has('address'))
                                                            @foreach ($errors->get('address') as $message)
                                                                <p class="text-danger text-xs pt-1">{{ $message }}</p>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 text-end mt-5">
                                                <button type="submit" class="btn btn-primary btn-sm ms-auto">Save</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection