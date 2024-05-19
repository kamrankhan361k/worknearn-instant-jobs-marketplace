
<div class="sidebar">
    <div class="sidebar__inner">
        <div class="sidebar-top-inner">
            <div class="sidebar__logo">
                <a href="{{ route('home') }}" class="sidebar__main-logo">
                    <img src="{{ getImage(getFilePath('logoIcon') . '/logo.png') }}" alt="logo">
                </a>
                <div class="navbar__left">
                    <button class="navbar__expand">
                        <i class="fas fa-bars"></i>
                    </button>
                    <button class="sidebar-mobile-menu">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
            </div>
            <div class="sidebar__menu-wrapper">
                <ul class="sidebar__menu p-0">
                    <li class="sidebar-menu-item {{ Route::is('user.home') ? 'active' : '' }}">
                        <a href="{{ route('user.home') }}">
                            <i class="menu-icon fas fa-user"></i>
                            <span class="menu-title">@lang('Dashboard')</span>
                        </a>
                    </li>
                    <li class="sidebar-menu-item sidebar-dropdown {{(isActiveRoute('user.job.') ? 'active' : '')}}">
                        <a href="javascript:void(0)">
                            <i class="menu-icon las la-briefcase"></i>
                            <span class="menu-title">@lang('Jobs')</span>
                        </a>
                        <ul class="sidebar-submenu {{(isActiveRoute('user.job.') ? 'd-block' : '')}}">
                            <li class="sidebar-menu-item">
                                <a href="{{ route('user.job.create') }}" class="nav-link">
                                    <i class="menu-icon las la-ellipsis-h"></i>
                                    <span class="menu-title">@lang('Create Job')</span>
                                </a>
                            </li>

                            <li class="sidebar-menu-item">
                                <a href="{{ route('user.job.index') }}" class="nav-link">
                                    <i class="menu-icon las la-ellipsis-h"></i>
                                    <span class="menu-title">@lang('Posted Jobs')</span>
                                </a>
                            </li>
   
                            <li class="sidebar-menu-item">
                                <a href="{{ route('user.job.application.applied') }}" class="nav-link">
                                    <i class="menu-icon las la-ellipsis-h"></i>
                                    <span class="menu-title">@lang('Submissions')</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="sidebar-menu-item sidebar-dropdown {{(isActiveRoute('user.withdraw') ? 'active' : '')}}">
                        <a href="javascript:void(0)">
                            <i class="menu-icon las la-hand-holding-usd"></i>
                            <span class="menu-title">@lang('Withdraw')</span>
                        </a>
                        <ul class="sidebar-submenu {{(isActiveRoute('user.withdraw') ? 'd-block' : '')}}">
                            <li class="sidebar-menu-item">
                                <a href="{{ route('user.withdraw') }}" class="nav-link">
                                    <i class="menu-icon las la-ellipsis-h"></i>
                                    <span class="menu-title">@lang('Withdraw')</span>
                                </a>
                            </li>

                            <li class="sidebar-menu-item">
                                <a href="{{ route('user.withdraw.history') }}" class="nav-link">
                                    <i class="menu-icon las la-ellipsis-h"></i>
                                    <span class="menu-title">@lang('History')</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="sidebar-menu-item sidebar-dropdown {{(isActiveRoute('user.deposit') ? 'active' : '')}}">
                        <a href="javascript:void(0)">
                            <i class="menu-icon las la-coins"></i>
                            <span class="menu-title">@lang('Payment Log')</span>
                        </a>

                        <ul class="sidebar-submenu {{(isActiveRoute('user.deposit') ? 'd-block' : '')}}">
                            <li class="sidebar-menu-item">
                                <a href="{{ route('user.deposit.history') }}" class="nav-link">
                                    <i class="menu-icon las la-ellipsis-h"></i>
                                    <span class="menu-title">@lang('Payment Log')</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="sidebar-menu-item">
                        <a href="{{ route('user.transactions') }}">
                            <i class="menu-icon las la-exchange-alt"></i>
                            <span class="menu-title">@lang('Transactions')</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="sidebar-support-box d-grid align-items-center bg-img"
            data-background="{{ asset('assets/images/frontend/sidebar/sidebar-bg.png') }}">
            <div class="sidebar-support-icon">
                <i class="fas fa-question-circle"></i>
            </div>
            <div class="sidebar-support-content">
                <h4 class="title">@lang('Need Help?')</h4>
                <p>@lang('Please contact our support.')</p>
                <div class="sidebar-support-btn">
                    <a href="{{ route('ticket') }}" class="btn--base w-100 mt-2">@lang('Get Support')</a>
                </div>
            </div>
        </div>
    </div>
</div>
