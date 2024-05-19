@extends($activeTemplate . 'layouts.master')
@section('content')
    <!-- body-wrapper-start -->
    <div class="body-wrapper">
        <div class="table-content">
            <div class="m-0">
                <div class="list-card">
                    <div class="row justify-content-end">
                        <div class="col-md-4 mb-3">
                            <form method="GET" autocomplete="off">
                                <div class="search-box w-100">
                                    <input type="text" class="form--control" name="search_table" placeholder="Search..."
                                        value="{{ request()->search }}">
                                    <button type="submit" class="search-box__button"><i class="fas fa-search"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="table-area m-0">
                        <table class="custom-table">
                            <thead>
                                <tr>
                                    <th>@lang('Job Image')</th>
                                    <th>@lang('Author Name')</th>
                                    <th>@lang('Title')</th>
                                    <th>@lang('Total Budge')</th>
                                    <th>@lang('Percent/Quantity')</th>
                                    <th>@lang('Per Worker Earn')</th>
                                    <th>@lang('Job Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($jobApplications as $item)
                                
                                    <tr>
                                        <td data-label="Job Image" class="td-img">
                                            <img src="{{ getImage(getFilePath('job') . '/' . @$item?->job->image) }}"
                                                alt="post-ad">
                                        </td>

                                        <td data-label="Author Name">
                                            @if (@$item?->job?->owner_type == 1)
                                                {{ __(@$item?->job?->ownerAdmin?->name) }}
                                            @else
                                                {{ __(@$item?->job?->ownerUser?->fullname) }}
                                            @endif
                                        </td>

                                        <td data-label="Title">
                                            {{ __(@$item?->job?->title) }}
                                        </td>

                                        <td data-label="Price" class="budget">
                                            {{ $general->cur_sym }}{{ __($item?->job?->total_budge) }}
                                        </td>

                                        <td data-label="quantity">
                                            {{ showAmount(($item->done($item->job->id) * 100) / @$item?->job?->quantity) }}% / {{ @$item?->job?->quantity }} 
                                        </td>

                                        <td data-label="Per Worker Earn">
                                            {{ __(@$item?->job?->per_worker_earn) }}
                                        </td>

                                        <td data-label="Job Status">
                                            @if ($item?->job?->job_status == 0)
                                                <span class="badge badge--warning">@lang('Holding')</span>
                                            @elseif ($item?->job?->job_status == 1)
                                                <span class="badge badge--success">@lang('Running')</span>
                                            @elseif($item?->job?->job_status == 2)
                                                <span class="badge badge--danger">@lang('Finished')</span>
                                            @endif
                                        </td>

                                        <td data-label="Action" class="table-dropdown">
                                            <i class="fas fa-ellipsis-v" data-bs-toggle="dropdown"></i>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="{{ route('job.details', [$item?->job?->id, slug($item?->job?->title)]) }}">
                                                        @lang('View')
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="{{ route('user.job.application.proof', $item?->job?->id) }}">
                                                        @lang('Proof Attachment')
                                                    </a>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td data-label="Image" class="text-muted text-center" colspan="100%">
                                            @lang('No data found')
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-5">
                        <nav class="d-flex justify-content-end">
                            {{ $jobApplications->links() }}
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        (function($) {
            "use strict";
            $('.custom-table').css('padding-top', '0px');
            var tr_elements = $('.custom-table tbody tr');
            $(document).on('input', 'input[name=search_table]', function() {
                "use strict";
                var search = $(this).val().toUpperCase();
                var match = tr_elements.filter(function(idx, elem) {
                    return $(elem).text().trim().toUpperCase().indexOf(search) >= 0 ? elem : null;
                }).sort();
                var table_content = $('.custom-table tbody');
                if (match.length == 0) {
                    table_content.html('<tr><td colspan="100%" class="text-center">Data Not Found</td></tr>');
                } else {
                    table_content.html(match);
                }
            });
        })(jQuery);
    </script>
@endpush
