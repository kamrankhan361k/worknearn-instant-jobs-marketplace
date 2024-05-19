@php
    $recentJobSection = getContent('recent_job.content', true);
    $jobs = App\Models\Job::where('status', 1)->where('job_status', '=', 1)->orderBy('id', 'desc')->paginate(getPaginate())->onEachSide(10);
@endphp

<!-- ==================== JobList start ==================== -->
<section class="joblist py-80">
    <div class="container">
        <div class="title">
            <h4>{{ __(@$recentJobSection->data_values?->title) }}</h4>
            <div class="hr1"></div>
            <div class="hr2"></div>
        </div>
        <div class="row mt-5">
            <div class="col-12">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>@lang('Job Name')</th>
                            <th>@lang('Payment')</th>
                            <th>@lang('Success')</th>
                            <th>@lang('Done')</th>
                            <th>@lang('Avg. Time')</th>
                            <th>@lang('Action')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($jobs as $item)
                            <tr>
                                <td data-label="JobName">
                                    <div class="job-td">
                                        <img src="{{ getImage(getFilePath('job') . '/' . $item->image) }}"
                                            alt="image">
                                        <p>{{ __($item->title) }}</p>
                                    </div>
                                </td>
                                <td data-label="Payment">{{ __($item->per_worker_earn) }}</td>
                                <td data-label="Success">{{ __(showAmount(($item->done() * 100) / $item->quantity)) }}%
                                </td>
                                <td data-label="done">{{ __($item->done()) }}/{{ $item->quantity }}</td>
                                <td data-label="avg-time">{{ getDurationForHumans($item->avg_time) }} @lang('min')
                                </td>
                                <td data-label="Action"><a
                                        href="{{ route('job.details', [$item->id, slug($item->title)]) }}"
                                        class="btn--base btn--sm">@lang('More info')</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-5">
                    @if ($jobs->hasPages())
                        {{ $jobs->links() }}
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ==================== JobList end ==================== -->
