@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <section class="account py-100 bg-img" data-background="{{ getImage(getFilePath('login') . '/banner_bg.png') }}">
        <div class="container">
            <div class="row">
                <div class="col-12 d-flex justify-content-center">
                    <div class="account-form">
                    <div class="verification-code-wrapper">
                        <div class="verification-area">
                            <h5 class="pb-3 text-center border-bottom">@lang('Verify Email Address')</h5>
                            <form action="{{ route('user.verify.email') }}" method="POST" class="submit-form">
                                @csrf
                                <p class="verification-text">@lang('A 6 digit verification code sent to your email address'):
                                    {{ showEmailAddress(auth()->user()->email) }}</p>
                                @include($activeTemplate . 'components.verification_code')
                                <div class="mb-3">
                                    <button type="submit" class="btn--base w-100">@lang('Save')</button>
                                </div>

                                <div class="mb-3">
                                    <p>
                                        @lang('If you don\'t get any code'), <a class="text--base"
                                            href="{{ route('user.send.verify.code', 'email') }}">
                                            @lang('Try again')</a>
                                    </p>
                                    @if ($errors->has('resend'))
                                        <small class="text-danger d-block">{{ $errors->first('resend') }}</small>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection