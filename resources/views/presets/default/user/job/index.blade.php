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
                                    <th>@lang('Percent/Quantity')</th>
                                    <th>@lang('Per Worker Earn')</th>
                                    <th>@lang('Approve Status')</th>
                                    <th>@lang('Job Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($jobs as $item)
                                    <tr>
                                        <td data-label="Image" class="td-img">
                                            @if (0 < $item->read_status())
                                                <div class="blob white">
                                                </div>
                                            @endif
                                            <img src="{{ getImage(getFilePath('job') . '/' . @$item->image) }}"
                                                alt="post-ad">
                                        </td>

                                        <td data-label="Title">
                                            {{ __(@$item->title) }}
                                        </td>

                                        <td data-label="Price" class="budget">
                                            {{ $general->cur_sym }}{{ __($item->total_budge) }}
                                        </td>

                                        <td data-label="quantity">
                                            {{ showAmount(($item->done() * 100) / $item->quantity, 2) }}% /
                                            {{ @$item->quantity }}
                                        </td>

                                        <td data-label="Per Worker Earn">
                                            {{ $general->cur_sym }}{{ __(@$item->per_worker_earn) }}
                                        </td>

                                        <td data-label="Approve">
                                            @if ($item->status == 0)
                                                <span class="badge badge--warning">@lang('Initial')</span>
                                            @elseif ($item->status == 1)
                                                <span class="badge badge--success">@lang('Success')</span>
                                            @elseif($item->status == 2)
                                                <span class="badge badge--danger">@lang('Pending')</span>
                                            @endif
                                        </td>

                                        <td data-label="Job Status">
                                            @if ($item->job_status == 0)
                                                <span class="badge badge--warning">@lang('Pending')</span>
                                            @elseif($item->job_status == 1)
                                                <span class="badge badge--success">@lang('Active')</span>
                                            @else
                                                <span class="badge badge--danger">@lang('Finished')</span>
                                            @endif

                                        </td>


                                        <td data-label="Action" class="table-dropdown">
                                            <i class="fas fa-ellipsis-v" data-bs-toggle="dropdown"></i>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="{{ route('job.details', [$item->id, slug($item->title)]) }}">@lang('View')
                                                    </a>
                                                </li>

                                                <li>
                                                    <a class="dropdown-item"
                                                        href="{{ route('user.job.application.applied.me.proof', $item->id) }}">@lang('Submissions')</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item deleteJob" href="javascript:void(0)" data-url="{{ route('user.job.delete', $item->id) }}">@lang('Delete')</a>
                                                </li>

                                                @if ($item->job_status == 0 || $item->job_status == 1)
                                                    <li>
                                                        <a class="dropdown-item jobStatusBtn" href="javascript:void(0)"
                                                            data-id="{{ $item->id }}">@lang('Change Status')</a>
                                                    </li>
                                                @endif
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
                            {{ $jobs->links() }}
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="jobStatusModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Job Status')</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="{{ route('user.job.status') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="job_id">
                        <select class="form-select" aria-label="Default select example" name="status_data">
                            <option selected>@lang('Select Status')</option>
                            <option value="0">@lang('Pending')</option>
                            <option value="1">@lang('Active')</option>
                            <option value="2">@lang('Finished')</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--danger text-white" data-bs-dismiss="modal">@lang('No')</button>
                        <button type="submit" class="btn btn--primary text-white">@lang('Yes')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="deleteModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Confirmation Alert!')</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form method="GET">
                    @csrf
                    <div class="modal-body">
                        <p class="question">@lang('Are you sure you delete this job?')</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--danger text-white"
                            data-bs-dismiss="modal">@lang('No')</button>
                        <button type="submit" class="btn btn--primary text-white">@lang('Yes')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        (function($) {
            "use strict";
            $(document).on('click', '.jobStatusBtn', function() {
                var modal = $('#jobStatusModal');
                var id = $(this).data("id");
                modal.find('input[name=job_id]').val(id);
                modal.modal('show');
            });
        })(jQuery);
    </script>


    <script>
        (function($) {
            "use strict";
            $(document).on('click', '.deleteJob', function() {
                var modal = $('#deleteModal');
                var url = $(this).data("url");
                modal.find('form').attr('action',url);
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
