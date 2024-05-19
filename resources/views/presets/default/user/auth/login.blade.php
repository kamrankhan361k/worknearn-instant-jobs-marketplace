@extends($activeTemplate . 'layouts.frontend')
@section('content')
    @php
        $credentials = gs()->socialite_credentials;
    @endphp
    <!--=======-** Sign In start **-=======-->
    <section class="account bg-img" data-background="{{ getImage(getFilePath('login') . '/banner_bg.png') }}">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-6 col-lg-8 col-md-10 col-12">
                    <div class="account-form">
                        <div class="logo">
                            <a href="{{ route('home') }}"><img src="{{ getImage(getFilePath('logoIcon') . '/logo.png') }}"
                                    alt="logo"></a>
                        </div>
                        <div>
                            <h4>@lang('Welcome Back!')</h4>
                        </div>
                        <form method="POST" action="{{ route('user.login') }}" class="verify-gcaptcha">
                            @csrf
                            <div class="row gy-3">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="username" class="form--label">@lang('Email or Username')</label>
                                        <input type="text" class="form--control" id="username"
                                            placeholder="@lang('Email or Username')" name="username">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label for="your-password" class="form--label">@lang('Password')</label>
                                    <div class="input-group">
                                        <input id="your-password" type="password" class="form--control" value="Password"
                                            name="password" required>
                                        <div class="password-show-hide fas fa-eye toggle-password fa-eye-slash"
                                            id="#your-password"></div>
                                    </div>
                                </div>
                                <x-captcha></x-captcha>
                                <div class="col-12">
                                    <div class="d-flex flex-wrap justify-content-between">
                                        <div class="form--check">
                                            <input class="form-check-input" type="checkbox" value="" id="remember"
                                                name="remember" {{ old('remember') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="remember">
                                                @lang('Remember Me')
                                            </label>
                                        </div>
                                        <a href="{{ route('user.password.request') }}" class="text">@lang('Forgot Password?')</a>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn--base w-100">@lang('Sign In')</button>
                                </div>

                                @if (
                                    @$credentials->google?->status == 1 ||
                                        @$credentials->facebook?->status == 1 ||
                                        @$credentials->linkedin?->status == 1)
                                    <div class="col-12">
                                        <hr class="hr" data-content="OR">
                                    </div>
                                    <div class="col-12">
                                        <div class="social">
                                            @if ($credentials->google->status == 1)
                                                <a href="{{ route('user.social.login', 'facebook') }}" class="icon">
                                                    <i class="fab fa-facebook-f"></i>
                                                </a>
                                            @endif
                                            @if ($credentials->facebook->status == 1)
                                                <a href="{{ route('user.social.login', 'google') }}" class="icon">
                                                    <i class="fab fa-google"></i>
                                                </a>
                                            @endif
                                            @if ($credentials->linkedin->status == 1)
                                                <a href="{{ route('user.social.login', 'Linkedin') }}" class="icon">
                                                    <i class="fab fa-linkedin-in"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                                <div class="col-12">
                                    <div class="text-center">
                                        <p class="text">@lang("Don't Have An Account?") <a href="{{ route('user.register') }}"
                                                class="text--base">@lang('Sign up')</a></p>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--=======-** Sign In End **-=======-->
@endsection
