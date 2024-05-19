@php
    $pages = App\Models\Page::where('tempname', $activeTemplate)->get();
@endphp
<div class="header" id="header">
    <div class="container">
        <nav class="navbar navbar-expand-lg">
            <a class="navbar-brand logo" href="{{ route('home') }}"><img
                    src="{{ getImage(getFilePath('logoIcon') . '/logo.png') }}" alt="logo"></a>
            <button class="navbar-toggler header-button" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span id="hiddenNav"><i class="las la-bars"></i></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav nav-menu mx-auto ps-lg-4 ps-0">
                    @foreach ($pages as $page)
                        @if ($page->name != 'Blog')
                            <li class="nav-item"><a
                                    class="nav-link {{ Request::url() == url('/') . '/' . $page->slug ? 'active' : '' }}"
                                    aria-current="page" href="{{ route('pages', [$page->slug]) }}">{{ $page->name }}</a>
                            </li>
                        @endif
                    @endforeach
                </ul>
                <div class="nav-end d-lg-flex d-block align-items-center py-lg-0 py-1">
                    <div class="d-flex mx-2">
                        <div class="icon">
                            <i class="fas fa-globe"></i>
                        </div>
                        <select class="select-dir langSel ">
                            @foreach ($languages as $language)
                                <option value="{{ $language->code }}" @if (Session::get('lang') === $language->code) selected @endif>
                                    {{ __(ucfirst($language->name)) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @guest
                        <a class="btn--base mt-2 mt-lg-0" href="{{ route('user.login') }}">@lang('Sign In')</a>
                    @endguest
                    @auth
                        <a href="{{ route('user.home') }}" class="button btn mt-2 mt-lg-0">@lang('Dashboard')</a>
                    @endauth
                </div>
            </div>
        </nav>
    </div>
</div>

