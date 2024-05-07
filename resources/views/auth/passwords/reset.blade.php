<x-app-layout>
    @slot('contentHeader')
        Reset Password
    @endslot

    @slot('breadcrumbs')
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
            <li class="breadcrumb-item active">Reset Password</li>
        </ol>
    @endslot

        <div class="reset-password-wrapper">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            @if ($message = Session::get('info'))
                                <div class="alert alert-info d-flex justify-content-center align-items-center py-1" role="alert">
                                    <strong><i data-feather="info"></i> {{ $message }}</strong>
                                </div>
                            @endif
                            <!-- Form -->
                            <form method="POST" action="{{ route('store-reset-password') }}">
                                @csrf

                                <div class="mb-1">
                                    <div class="d-flex justify-content-between">
                                        <label class="form-label" for="password">{{ __('Password') }}</label>
                                    </div>
                                    <div class="input-group input-group-merge form-password-toggle">
                                        <input type="password" class="form-control form-control-merge @error('password') is-invalid @enderror" id="password" name="password" />
                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-2">
                                    <div class="d-flex justify-content-between">
                                        <label class="form-label" for="password-confirm">{{ __('Confirmation Password') }}</label>
                                    </div>
                                    <div class="input-group input-group-merge form-password-toggle">
                                        <input type="password" class="form-control form-control-merge" id="password-confirm" name="password_confirmation"
                                        />
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end col-12">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Reset Password') }}
                                    </button>
                                </div>
                            </form>
                            <!--/ Form -->
                        </div>
                    </div>
                </div>
            </div>
        </div>


</x-app-layout>
