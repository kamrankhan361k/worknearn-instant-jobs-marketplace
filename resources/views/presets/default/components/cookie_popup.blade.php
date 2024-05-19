@php
    $cookie = App\Models\Frontend::where('data_keys', 'cookie.data')->first();
@endphp
@if ($cookie->data_values->status == 1 && !\Cookie::get('gdpr_cookie'))
    <!-- cookies dark version start -->
    <div class="cookies-card text-center hide">
       <div>
        <p class="cookies-card__content">{{ $cookie->data_values->short_desc }} <a class="text--base"
            href="{{ route('cookie.policy') }}" target="_blank">@lang('learn more')</a></p>
       </div>
        <div class="cookies-card__btn">
            <a href="javascript:void(0)" class="btn btn--base text-nowrap policy">@lang('Accept')</a>
        </div>
    </div>
    <!-- cookies dark version end -->
@endif
