@php
    $contactSection = getContent('contact.content', true);
@endphp
@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <!-- ==================== Contact Form & Map Start ==================== -->
    <section class="contact pt-150 pb-80">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 my-auto">
                   <div class="contact-card">
                    <h4 class="contact__title">{{@$contactSection->data_values?->title}}</h4>
                    <form method="post" autocomplete="off" class="verify-gcaptcha">
                        @csrf
                        <div class="row gy-md-4 gy-3">
                            <div class="col-sm-12">
                                <h6 class="mb-1">@lang('Name')</h6>
                                <input type="text" class="form--control" name="name" placeholder="Your Name*"
                                        value="@if(auth()->user()){{auth()->user()->fullname}}@else{{ old('name') }}@endif"
                                        @if (auth()->user()) readonly @endif required>
                            </div>

                            <div class="col-sm-12">
                                <h6 class="mb-1">@lang('Email')</h6>
                                <input type="email" name="email" class="form--control" placeholder="Email Address*"
                                value="@if (auth()->user()) {{ auth()->user()->email }}@else{{ old('email') }} @endif"
                                @if (auth()->user()) readonly @endif required>
                            </div>

                            <div class="col-sm-12">
                                <h6 class="mb-1">@lang('Subject')</h6>
                                <input type="text" class="form--control" name="subject" placeholder="Subject"
                                value="{{ old('subject') }}" required>
                            </div>

                            <div class="col-sm-12">
                                <h6 class="mb-1">@lang('Message')</h6>
                                <textarea class="form--control" placeholder="Write Your Message" required name="message"> {{ old('message') }}</textarea>
                            </div>
                            <x-captcha></x-captcha>
                            <div class="col-sm-12">
                                <button class="btn--base"> {{__(@$contactSection->data_values?->button_name)}}</button>
                            </div>
                        </div>
                    </form>
                   </div>
                </div>
                <div class="col-lg-6 my-auto thumb">
                    <div>
                        <img src="{{getImage(getFilePath('contact').'/'. @$contactSection->data_values?->contact_image)}}" class="img-fiuld d-flex ms-auto" alt="image">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ==================== Contact Form & Map End ==================== -->
@endsection
