@extends('layouts.society')

@section('content')
    @include('layouts.partials.societyTopnav', ['title' => 'Member Management'])
    <div class="row mt-4 mx-4">
        <div x-data="roles" class="col-12">
            {{-- <div class="text-end alert alert-light" role="alert">
                    <a href="{{ route('roles.create') }}" class="btn btn-sm mb-0 me-1 btn-primary">Add Role</a>
            </div> --}}
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <div class="alert alert-light" role="alert">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-6 text-start text-white">
                                    <h6 class="text-black">Add Member</h6>
                                </div>
                                <div class="col-lg-6 text-end">
                                    <a href="{{ route('member.index') }}" class="btn btn-sm mb-0 me-1 btn-primary">Cancel</a>
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
                                    <form role="form" method="POST" action="{{ route('member.import') }}" enctype="multipart/form-data">
                                        @csrf
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="file" class="form-control-label">File</label>
                                                        <input id="file" name="file" type="file" class="form-control form-control-lg" required/>
                                                        @if ($errors->has('file'))
                                                            @foreach ($errors->get('file') as $message)
                                                                <p class="text-danger text-xs pt-1">{{ $message }}</p>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 text-end mt-5">
                                                <button type="submit" class="btn btn-primary btn-sm ms-auto">Upload</button>
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