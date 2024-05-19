@extends($activeTemplate . 'layouts.frontend')
@section('content')
    @php
        $policyPages = getContent('policy_pages.element', false, null, true);
        $credentials = gs()->socialite_credentials;
    @endphp
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
                            <h4>@lang('Sign Up!')</h4>
                        </div>
                        <form action="{{ route('user.register') }}" class="verify-gcaptcha" method="POST">
                            @csrf
                            <div class="row gy-3">
                                <div class="col-lg-6 col-12">
                                    <div class="form-group">
                           
                                        <label for="username" class="form--label">@lang('User Name')</label>
                                        <input type="text" class="form--control checkUser" id="username"
                                            placeholder="@lang('User Name')" name="username" value="{{ old('username') }}">
                                        <small class="text-danger usernameExist"></small>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-12">
                                    <div class="form-group">
                                        <label for="email" class="form--label">@lang('Email')</label>
                                        <input type="text" class="form--control checkUser" id="email"
                                            placeholder="@lang('Enter Email')" name="email" value="{{ old('email') }}">
                                        <small class="text-danger emailExist"></small>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-12">
                                    <label for="your-password" class="form--label">@lang('Password')</label>
                                    <div class="input-group">
                                        <input id="your-password" type="password" class="form-control form--control"
                                            name="password" required>
                                        <div class="password-show-hide toggle-password-change fas fa-eye-slash"
                                            data-target="your-password"> </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-12">
                                    <label for="confirm-password" class="form--label">@lang('Confirm Password')</label>
                                    <div class="input-group">
                                        <input id="confirm-password" type="password" class="form-control form--control"
                                            name="password_confirmation" required>
                                        <div class="password-show-hide toggle-password-change fas fa-eye-slash"
                                            data-target="confirm-password"> </div>
                                    </div>
                                </div>
                                <x-captcha></x-captcha>
                                @if ($general->agree)
                                    <div class="col-sm-12">
                                        <div class="form--check">
                                            <input class="form-check-input" type="checkbox" id="agree"
                                                @checked(old('agree')) name="agree" required>
                                            <div class="form-check-label">
                                                <label>
                                                    @lang('I agree with') @foreach ($policyPages as $policy)
                                                        <a href="{{ route('policy.pages', [slug($policy->data_values->title), $policy->id]) }}"
                                                            class="text--base">{{ __($policy->data_values->title) }}</a>
                                                        @if (!$loop->last)
                                                            ,
                                                        @endif
                                                    @endforeach
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <div class="col-12">
                                    <button type="submit" class="btn--base w-100">@lang('Sign Up')</button>
                                </div>

                                @if (@$credentials->google->status == 1 || @$credentials->facebook->status == 1 || @$credentials->linkedin->status == 1)
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
                                    <div class="have-account text-center">
                                        <p>@lang('Already have an account?') <a href="{{ route('user.login') }}"
                                                class="text--base">@lang('Sign In')</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="existModalCenter" tabindex="-1" role="dialog" aria-labelledby="existModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="existModalLongTitle">@lang('You are with us')</h5>
                    <span type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </span>
                </div>
                <div class="modal-body">
                    <h6 class="text-center">@lang('You already have an account please Login ')</h6>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn--base btn-sm"
                        data-bs-dismiss="modal">@lang('Close')</button>
                    <a href="{{ route('user.login') }}" class="btn btn--base btn-sm">@lang('Login')</a>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('style')
    <style>
        .country-code .input-group-text {
            background: #fff !important;
        }

        .country-code select {
            border: none;
        }

        .country-code select:focus {
            border: none;
            outline: none;
        }
    </style>
@endpush

@push('script')
    <script>
        "use strict";
        (function($) {
            @if ($mobileCode)
                $(`option[data-code={{ $mobileCode }}]`).attr('selected', '');
            @endif

            $('select[name=country]').on('change',function() {
                $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
                $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
                $('.mobile-code').text('+' + $('select[name=country] :selected').data('mobile_code'));
            });
            $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
            $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
            $('.mobile-code').text('+' + $('select[name=country] :selected').data('mobile_code'));
         

            $('.checkUser').on('focusout', function(e) {
                var url = '{{ route('user.checkUser') }}';
                var value = $(this).val();
                var token = '{{ csrf_token() }}';
                if ($(this).attr('name') == 'mobile') {
                    var mobile = `${$('.mobile-code').text().substr(1)}${value}`;
                    var data = {
                        mobile: mobile,
                        _token: token
                    }
                }
                if ($(this).attr('name') == 'email') {
                    var data = {
                        email: value,
                        _token: token
                    }
                }
                if ($(this).attr('name') == 'username') {
                    var data = {
                        username: value,
                        _token: token
                    }
                }
                $.post(url, data, function(response) {
                    if (response.data != false && response.type == 'email') {
                        $('#existModalCenter').modal('show');
                    } else if (response.data != false) {
                        $(`.${response.type}Exist`).text(`${response.type} already exist`);
                    } else {
                        $(`.${response.type}Exist`).text('');
                    }
                });
            });
        })(jQuery);
    </script>
@endpush
