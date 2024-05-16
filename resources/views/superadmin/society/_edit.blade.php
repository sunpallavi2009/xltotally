<x-app-layout>
    <div>

        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        {{ __('Edit Society') }}
                    </h2>

                    <h2 class="font-semibold text-xl text-gray-800 leading-tight text-right">
                       
                    </h2>
                </div>
            </div>
        </header>

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

                        <form method="POST" action="{{ route('society.update', $society->id) }}">
                            @method('PUT')
                            @csrf
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-6">
                                <div class="p-4">
                                    <x-input-label for="name" :value="__('Socity Name')" />
                                    <x-text-input id="name" class="form-control mt-1" type="text" name="name" value="{{ old('name', $society->name) }}" required autofocus autocomplete="name" />
                                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                </div>
                                <div class="p-4">
                                    <x-input-label for="state" :value="__('State')" />
                                    <x-text-input id="state" class="form-control mt-1" type="text" name="state" value="{{ old('name', $society->state) }}" required autofocus autocomplete="state" />
                                    <x-input-error :messages="$errors->get('state')" class="mt-2" />
                                </div>
                                <div class="p-4">
                                    <x-input-label for="city" :value="__('City')" />
                                    <x-text-input id="city" class="form-control mt-1" type="text" name="city" value="{{ old('name', $society->city) }}" required autofocus autocomplete="city" />
                                    <x-input-error :messages="$errors->get('city')" class="mt-2" />
                                </div>
                                <div class="p-4">
                                    <x-input-label for="pincode" :value="__('Pincode')" />
                                    <x-text-input id="pincode" class="form-control mt-1" type="number" name="pincode" value="{{ old('name', $society->pincode) }}" required autofocus autocomplete="pincode" />
                                    <x-input-error :messages="$errors->get('pincode')" class="mt-2" />
                                </div>
                                <div class="p-4">
                                    <x-input-label for="phone" :value="__('Phone')" />
                                    <x-text-input id="phone" class="form-control mt-1" type="number" name="phone" value="{{ old('name', $society->phone) }}" required autofocus autocomplete="phone" />
                                    <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <x-input-label for="address" :value="__('Address')" />
                                <textarea id="address" name="address" class="form-control mt-1 block w-full" rows="4" required>{{ old('name', $society->address) }}</textarea>
                                <x-input-error :messages="$errors->get('address')" class="mt-2" />
                            </div>

                            <div class="flex justify-end pt-6">
                                <a href="{{ route('society.index') }}" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-white dark:hover:bg-gray-800 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600 ">Cancel</a>
                                <button type="submit" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600 btn btn-warning btn-lg ms-2">Save</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
