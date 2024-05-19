@php
    $footerSection = getContent('footer.content', true);
    $footerSectionElements = getContent('footer.element', false);
    $pages = App\Models\Page::where('tempname', $activeTemplate)->get();
    $policyElements = getContent('policy_pages.element', false);
@endphp


<footer class="footer-area pt-120">
    <div class="container">
        <div class="row justify-content-center g-5">
            <div class="col-xl-3 col-sm-6">
                <div class="footer-item">
                    <div class="footer-item__logo">
                        <a href="{{ route('home') }}"> <img
                                src="{{ getImage(getFilePath('logoIcon') . '/logo_white.png') }}" alt="logo"></a>
                    </div>
                    <p class="footer-item__desc">
                        @php
                            echo @$footerSection->data_values?->short_description;
                        @endphp
                    </p>
                    <ul class="social-list mt-3">
                        @foreach ($footerSectionElements as $item)
                            <li class="social-list__item">
                                <a href="{{ @$item->data_values?->url }}" class="social-list__link">
                                    @php
                                        echo @$item->data_values?->icon;
                                    @endphp
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-xl-2 col-sm-6">
                <div class="footer-item">
                    <h5 class="footer-item__title">@lang('Information')</h5>
                    <ul class="footer-menu">
                        @foreach ($pages as $page)
                            @if ($page->name != 'Explore' && $page->name != 'About')
                                <li
                                    class="footer-menu__item {{ Request::url() == url('/') . '/' . $page->slug ? 'active' : '' }}">
                                    <a href="{{ route('pages', [$page->slug]) }}"
                                        class="footer-menu__link">{{ __(ucfirst($page->name)) }}
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-xl-2 col-sm-6">
                <div class="footer-item">
                    <h5 class="footer-item__title">@lang('Company')</h5>
                    <ul class="footer-menu">
                        <li class="footer-menu__item"><a href="{{ url('/cookie-policy') }}"
                                class="footer-menu__link">@lang('Cookie Policy')</a>
                        </li>
                        @if (@$general->agree == 1)
                            @foreach (@$policyElements as $element)
                                <li class="footer-menu__item">
                                    <a href="{{ route('policy.pages', [slug($element->data_values->title), $element->id]) }}"
                                        class="footer-menu__link">
                                        @php
                                            echo $element->data_values?->title;
                                        @endphp
                                    </a>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>
            <div class="col-xl-2 col-sm-6">
                <div class="footer-item">
                    <h5 class="footer-item__title">@lang('Support')</h5>
                    <ul class="footer-menu">
                        @foreach ($pages as $page)
                            @if ($page->name != 'Vehicles' && $page->name != 'About')
                                <li
                                    class="footer-menu__item {{ Request::url() == url('/') . '/' . $page->slug ? 'active' : '' }}">
                                    <a href="{{ route('pages', [$page->slug]) }}"
                                        class="footer-menu__link">{{ __($page->name) }}
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6">
                <div class="footer-item">
                    <h5 class="footer-item__title">@lang('Newsletter')</h5>
                    <p class="footer-item__desc mb-2">@lang('Subscribe our latest update')</p>
                    <form action="{{route('subscribe')}}" method="POST">
                        @csrf
                        <div class="form-group">
                            <input type="text" class="form--control" name="email" placeholder="@lang('Enter email')">
                            <button><i class="fas fa-paper-plane"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="copyright">
        <p>&copy; @lang('Copyright') {{ now()->year }}
            @lang('. All rights reserved.')</p>
    </div>
</footer>

