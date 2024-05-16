@extends('layouts.society')
    
        @section('header')
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Member') }}
                </h2>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight text-right">
                    <a href="{{ route('member.index') }}">{{ __('Add Member') }}</a>
                </h2>
            </div>
        </div>  
        @endsection
    
        @section('content')
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                    
                    <div class="p-6 text-gray-900">
                       
                    </div>
                    
                    
                </div>
            </div>
        </div>
        @endsection

