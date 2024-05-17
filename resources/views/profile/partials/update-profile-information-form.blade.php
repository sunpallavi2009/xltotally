<form id="send-verification" method="post" action="{{ route('verification.send') }}">
    @csrf
</form>

<form method="post" action="{{ route('profile.update') }}" class=" space-y-6">
    @csrf
    @method('patch')
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="example-text-input" class="form-control-label">Username</label>
                <x-text-input id="name" name="name" type="text" class="form-control form-control-lg" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                @if ($errors->has('name'))
                    @foreach ($errors->get('name') as $message)
                        <p class="text-danger text-xs pt-1">{{ $message }}</p>
                    @endforeach
                @endif
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="example-text-input" class="form-control-label">Email address</label>
                <x-text-input id="email" name="email" type="email" class="form-control form-control-lg" :value="old('email', $user->email)" required autocomplete="username" />
                @if ($errors->has('email'))
                    @foreach ($errors->get('email') as $message)
                        <p class="text-danger text-xs pt-1">{{ $message }}</p>
                    @endforeach
                @endif

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <div>
                        <p class="text-sm mt-2 text-gray-800">
                            {{ __('Your email address is unverified.') }}

                            <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                {{ __('Click here to re-send the verification email.') }}
                            </button>
                        </p>

                        @if (session('status') === 'verification-link-sent')
                            <p class="mt-2 font-medium text-sm text-green-600">
                                {{ __('A new verification link has been sent to your email address.') }}
                            </p>
                        @endif
                    </div>
                @endif
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="example-text-input" class="form-control-label">Role name</label>
                <select id="role" name="role" class="form-control form-control-lg" >
                    <option value="">Select Role</option>
                    @foreach($roles as $role)
                    <option value="{{ $role->id }}" {{ $user->role == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                    @endforeach
                </select>
                @if ($errors->has('role'))
                    @foreach ($errors->get('role') as $message)
                        <p class="text-danger text-xs pt-1">{{ $message }}</p>
                    @endforeach
                @endif
            </div>
        </div>
        <div class="col-md-6 text-end mt-5">
            <button type="submit" class="btn btn-primary btn-sm ms-auto">Save</button>
            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                ></p>
            @endif
        </div>
    </div>
</form>