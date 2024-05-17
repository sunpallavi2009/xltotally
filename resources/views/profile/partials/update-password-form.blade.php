<form method="post" action="{{ route('password.update') }}" class="space-y-6">
    @csrf
    @method('put')
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="update_password_current_password" class="form-control-label">Current Password</label>
                <input id="update_password_current_password" name="current_password" type="password" class="form-control form-control-lg"  required autofocus autocomplete="current_password" />
                @if ($errors->has('current_password'))
                    @foreach ($errors->get('current_password') as $message)
                        <p class="text-danger text-xs pt-1">{{ $message }}</p>
                    @endforeach
                @endif
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="update_password_password" class="form-control-label">New Password</label>
                <input id="update_password_password" name="password" type="password" class="form-control form-control-lg" required autocomplete="password" />
                @if ($errors->has('password'))
                    @foreach ($errors->get('password') as $message)
                        <p class="text-danger text-xs pt-1">{{ $message }}</p>
                    @endforeach
                @endif
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="update_password_password_confirmation" class="form-control-label">Confirm Password</label>
                <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="form-control form-control-lg" required autocomplete="password_confirmation" />
                @if ($errors->has('password_confirmation'))
                    @foreach ($errors->get('password_confirmation') as $message)
                        <p class="text-danger text-xs pt-1">{{ $message }}</p>
                    @endforeach
                @endif
            </div>
        </div>
        <div class="col-md-6 text-end mt-5">
            <button type="submit" class="btn btn-primary btn-sm ms-auto">Save</button>
            @if (session('status') === 'password-updated')
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