@extends('layouts.society')
   

        @section('header')
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        {{ __('Add Society') }}
                    </h2>

                    <h2 class="font-semibold text-xl text-gray-800 leading-tight text-right">
                       
                    </h2>
                </div>
            </div>
        @endsection

        @section('content')
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">

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

                            <div class="card">
                                    <form method="POST" action="{{ route('member.import') }}" class="space-y-6" enctype="multipart/form-data">
                                        @csrf
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <x-input-label for="file" :value="__('Upload here')" />
                                                            <x-text-input id="file" class="form-control mt-1" type="file" name="file" required autofocus autocomplete="name" />
                                                            <x-input-error :messages="$errors->get('file')" class="mt-2" />
                                                        </div>
        
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer">
                                                <div class="text-end">
                                                    <a href="{{ route('member.index') }}" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-white dark:hover:bg-gray-800 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600 ">Cancel</a>
                                                    <button type="submit" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600 btn btn-warning btn-lg ms-2">Upload</button>
                                                </div>
                                            </div>
                                        </form>
                            </div>
    
                        </div>
                    </div>
                </div>
            </div>
        @endsection


