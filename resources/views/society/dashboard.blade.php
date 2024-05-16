@extends('layouts.society')
    
        @section('header')
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Society Dashboard') }}
                </h2>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight text-right">
                    <a href="{{ route('member.index') }}">{{ __('Member') }}</a>
                </h2>
            </div>
        </div>  
        @endsection
    
        @section('content')
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        {{ __("Societies with OTP Logins:") }}
                    </div>
                    {{-- @if($society !== null && $society !== '')
                        <div class="p-6 text-gray-900">
                            {{ $society->name }}
                        </div>
                        <form action="{{ route('society.logout') }}" method="POST">
                            @csrf
                            <button type="submit">Logout</button>
                        </form>
                    @endif --}}
                    
                    
                </div>
            </div>
        </div>
        @endsection

