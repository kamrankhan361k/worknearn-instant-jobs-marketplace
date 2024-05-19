<div class="row">
    <div class="col">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link {{ Request::routeIs('admin.job.index') ? 'active' : '' }}"
                    href="{{ route('admin.job.index') }}">@lang('My Jobs')</a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ Request::routeIs('admin.job.application.applied') ? 'active' : '' }}"
                    href="{{ route('admin.job.application.applied') }}">@lang('My Submissions')</a>

            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::routeIs('admin.job.user') ? 'active' : '' }}"
                    href="{{ route('admin.job.user') }}">@lang('User Jobs')</a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ Request::routeIs('admin.job.pending') ? 'active' : '' }}"
                    href="{{ route('admin.job.pending') }}">@lang('Pending Jobs')
                    @if ($pendingJobCount)
                        <span class="badge rounded-pill bg--white text-muted">{{ $pendingJobCount }}</span>
                    @endif
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ Request::routeIs('admin.job.approved') ? 'active' : '' }}"
                    href="{{ route('admin.job.approved') }}">@lang('Approved Jobs')</a>
            </li>
           
            <li class="nav-item">
                <a class="nav-link {{ Request::routeIs('admin.job.holding') ? 'active' : '' }}"
                    href="{{ route('admin.job.holding') }}">@lang('Holding Jobs')
                    @if ($holdingJobCount)
                        <span class="badge rounded-pill bg--white text-muted">{{ $holdingJobCount }}</span>
                    @endif
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::routeIs('admin.job.active') ? 'active' : '' }}"
                    href="{{ route('admin.job.active') }}">@lang('Available Jobs')</a>
            </li>
         
            <li class="nav-item">
                <a class="nav-link {{ Request::routeIs('admin.job.finished') ? 'active' : '' }}"
                    href="{{ route('admin.job.finished') }}">@lang('Finished Jobs')</a>

            </li>
        </ul>
    </div>
</div>
