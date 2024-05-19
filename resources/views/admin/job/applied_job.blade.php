@extends('admin.layouts.app')
@section('panel')
    @include('admin.components.tabs.job')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--md table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th>@lang('Job Image')</th>
                                    <th>@lang('Author Name')</th>
                                    <th>@lang('Title')</th>
                                    <th>@lang('Total Budge')</th>
                                    <th>@lang('Quantity/Done')</th>
                                    <th>@lang('Per Worker Earn')</th>
                                    <th>@lang('Job Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($jobApplications as $item)
                                    <tr>
                                        <td class="text-center">
                                            <img src="{{ getImage(getFilePath('job') . '/' . @$item?->job->image) }}"
                                                alt="post-ad">
                                        </td>

                                        <td data-label="Author Name">
                                            @if (@$item?->job?->owner_type == 1)
                                                {{ __(@$item?->job?->ownerAdmin?->name) }}
                                            @else
                                                {{ __(@$item?->job?->ownerUser?->firstname) }}
                                            @endif
                                        </td>

                                        <td>
                                            {{ __(@$item?->job?->title) }}
                                        </td>

                                        <td>
                                            {{ $general->cur_sym }}{{ __($item?->job?->total_budge) }}
                                        </td>

                                        <td>
                                            {{ @$item?->job?->quantity }}/
                                            {{ showAmount(($item->done($item->job->id) * 100) / @$item?->job?->quantity) }}%
                                        </td>

                                        <td>
                                            {{ __(@$item?->job?->per_worker_earn) }}
                                        </td>

                                        <td>
                                            @if ($item?->job?->job_status == 0)
                                                <span class="badge badge--warning">@lang('Holding')</span>
                                            @elseif ($item?->job?->job_status == 1)
                                                <span class="badge badge--success">@lang('Running')</span>
                                            @elseif($item?->job?->job_status == 2)
                                                <span class="badge badge--danger">@lang('Finished')</span>
                                            @endif
                                        </td>

                                        <td>
                                            <a title="@lang('View Job')"
                                                href="{{ route('job.details', [$item?->job?->id, slug($item?->job?->title)]) }}"
                                                class="btn btn-sm btn--primary">
                                                <i class="las la-eye text--shadow"></i>
                                            </a>
                                            <a title="@lang('Job Proof')"
                                                href="{{ route('admin.job.application.proof', $item?->job?->id) }}"
                                                class="btn btn-sm btn--primary">
                                                <i class="las la-file-download"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>
                @if ($jobApplications->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($jobApplications) }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <div class="d-flex flex-wrap justify-content-end">
        <form method="GET" class="form-inline">
            <div class="input-group justify-content-end">
                <input type="text" name="search_table" class="form-control bg--white" placeholder="@lang('Search by Username')"
                    value="{{ request()->search }}">
                <button class="btn btn--primary input-group-text" type="submit"><i class="fa fa-search"></i></button>
            </div>
        </form>
    </div>
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";
            $('.table').css('padding-top', '0px');
            var tr_elements = $('.table tbody tr');
            $(document).on('input', 'input[name=search_table]', function() {
                "use strict";
                var search = $(this).val().toUpperCase();
                var match = tr_elements.filter(function(idx, elem) {
                    return $(elem).text().trim().toUpperCase().indexOf(search) >= 0 ? elem : null;
                }).sort();
                var table_content = $('.table tbody');
                if (match.length == 0) {
                    table_content.html('<tr><td colspan="100%" class="text-center">Data Not Found</td></tr>');
                } else {
                    table_content.html(match);
                }
            });
        })(jQuery);
    </script>
@endpush
