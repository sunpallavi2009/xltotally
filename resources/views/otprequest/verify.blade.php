<!-- otp/verify.blade.php -->

<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />
    {{-- <x-auth-validation-errors class="mb-4" :errors="$errors" /> --}}

    <form method="POST" action="{{ route('otp.verify.submit', ['societyId' => $societyId]) }}">
        @csrf

        <div class="mt-4">
            <x-input-label for="otp" :value="__('Verify OTP')" />
            <x-text-input id="otp"
                class="block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                type="text" name="otp" required autocomplete="phone" />
            <x-input-error :messages="$errors->get('otp')" class="mt-2" />
        </div>


        <div class="flex items-center justify-end mt-4">
            <x-primary-button  class="ms-3">
                {{ __('Verify OTP') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
