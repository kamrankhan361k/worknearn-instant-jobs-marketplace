@extends($activeTemplate . 'layouts.frontend')
@section('content')
<section class="account bg-img" data-background="{{ getImage(getFilePath('login') . '/banner_bg.png') }}">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-5 col-lg-7 col-md-10 col-12">
                    <div class="account-form">
                        <div>
                            <h4>@lang('Forgot Your Password')</h4>
                        </div>
                        <div class="mb-4">
                            <p>@lang('To recover your account please provide your email or username to find your account.')
                            </p>
                        </div>
                        <form method="POST" action="{{ route('user.password.email') }}">
                            @csrf
                            <div class="row gy-3">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="email" class="form--label">@lang('Email or Username')</label>
                                        <input type="text" class="form--control" id="email" name="value"
                                            value="{{ old('value') }}" required autofocus="off"
                                            placeholder="Email Address">
                                    </div>
                                </div>
                                <div class="col-sm-12 mt-4">
                                    <button type="submit" class="btn--base w-100">@lang('Submit')</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
