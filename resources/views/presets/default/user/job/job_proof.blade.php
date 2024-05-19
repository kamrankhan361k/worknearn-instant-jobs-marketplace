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
                                    <th>@lang('Image')</th>
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
                                        <td data-label="Image" class="td-img">
                                            <img src="{{ getImage(getFilePath('job') . '/' . @$item?->job->image) }}"
                                                alt="post-ad">
                                        </td>

                                        <td data-label="Title">
                                            {{ __(@$item?->job?->title) }}
                                        </td>

                                        <td data-label="Price" class="budget">
                                            {{ $general->cur_sym }}{{ __($item?->job?->total_budge) }}
                                        </td>

                                        <td data-label="quantity">
                                            {{ @$item?->job?->quantity }} /
                                            {{ showAmount(($item->done($item->job->id) * 100) / @$item?->job?->quantity) }}%
                                        </td>

                                        <td data-label="Per Worker Earn">
                                            {{ __(@$item?->job?->per_worker_earn) }}
                                        </td>

                                        <td data-label="Job Status">
                                            @if ($item?->status == 0)
                                                <span class="badge badge--primary">@lang('Initial')</span>
                                            @elseif ($item?->status == 1)
                                                <span class="badge badge--warning">@lang('Pending')</span>
                                            @elseif ($item?->status == 2)
                                                <span class="badge badge--success">@lang('Done')</span>
                                            @elseif($item?->status == 3)
                                                <span class="badge badge--danger">@lang('Canceled')</span>
                                            @endif
                                        </td>

                                        <td data-label="Action">
                                            <button class="text-black detailsBtn" title="View"
                                                data-description= "{{ @$item?->description }}"
                                                data-attachments= "{{ json_encode(@$item?->attachments) }}">
                                                <i class="fas fa-eye"> </i>
                                            </button>

                                            <a title="Download"
                                                href="{{ route('user.job.application.download', $item->id) }}"
                                                class="text-black">
                                                <i class="fas fa-file-download"></i>
                                            </a>
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

    <div id="detailsModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Proof Details')</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>

                <div class="modal-body">
                    <h6>@lang('Description:-')</h6>
                    <div class="description"></div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn--danger" data-bs-dismiss="modal">@lang('Close')</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        (function($) {
            "use strict";
            $(document).on('click', '.detailsBtn', function() {
                var description = $(this).data('description');
                var modal = $('#detailsModal');
                modal.find('.description').text(description);
                modal.modal('show');
            });
        })(jQuery);
    </script>

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
