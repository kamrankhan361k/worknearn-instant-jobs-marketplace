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
                                    <th>@lang('Image')</th>
                                    <th>@lang('Title')</th>
                                    <th>@lang('Total Budge')</th>
                                    <th>@lang('Percent/Quantity')</th>
                                    <th>@lang('Per Worker Earn')</th>
                                    <th>@lang('Job Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($jobs as $item)
                                    <tr>

                                        <td class="text-center td-img">
                                            @if (0 < $item->read_status())
                                                <div class="blob white">
                                                </div>
                                            @endif
                                            <img src="{{ getImage(getFilePath('job') . '/' . @$item->image) }}"
                                                class='img-thumbnail owner' title="@lang('Image')">
                                        </td>
                                        <td>
                                            {{ __(@$item->title) }}
                                        </td>

                                        <td>
                                            {{ gs()->cur_sym }}{{ __(@$item->total_budge) }}
                                        </td>
                                        <td>
                                            {{ showAmount(($item->done() * 100) / $item->quantity, 2) }}%
                                            /{{ @$item->quantity }}
                                        </td>

                                        <td>
                                            {{ gs()->cur_sym }}{{ __(@$item->per_worker_earn) }}
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


                                        <td>
                                            <a title="@lang('View Job')"
                                                href="{{ route('job.details', [$item->id, slug($item->title)]) }}"
                                                class="btn btn-sm btn--primary">
                                                <i class="las la-eye text--shadow"></i>
                                            </a>

                                            <a title="@lang('Submission')"
                                                href="{{ route('admin.job.application.applied.me.proof', $item->id) }}"
                                                class="btn btn-sm btn--primary">
                                                <i class="las la-copy text--shadow"></i>
                                            </a>

                                            @if ($item->job_status == 0 || $item->job_status == 1)
                                                <a title="@lang('Job Status')" class="btn btn-sm btn--info jobStatusBtn"
                                                    href="javascript:void(0)" data-id="{{ $item->id }}">
                                                    <i class="las la-info-circle text--shadow"></i>
                                                </a>
                                            @endif

                                            <a title="@lang('Delete')" href="javascript:void(0)" data-url="{{ route('admin.job.delete', $item->id) }}"
                                                class="btn btn-sm btn--danger deleteJob">
                                                <i class="las la-trash text--shadow"></i>
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
                @if ($jobs->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($jobs) }}
                    </div>
                @endif
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
                <form action="{{ route('admin.job.status') }}" method="post">
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
                        <button type="button" class="btn btn--danger" data-bs-dismiss="modal">@lang('No')</button>
                        <button type="submit" class="btn btn--primary text--white">@lang('Yes')</button>
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
                        <button type="button" class="btn btn--danger"
                            data-bs-dismiss="modal">@lang('No')</button>
                        <button type="submit" class="btn btn--primary text--white">@lang('Yes')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <div class="d-flex flex-wrap justify-content-end">
        <a class="btn btn-sm btn--primary me-2 d-flex align-items-center" href="{{ route('admin.job.create') }}"><i
                class="las la-plus"></i>@lang('Add New')</a>
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
                modal.find('form').attr('action', url);
                modal.modal('show');
            });
        })(jQuery);
    </script>


    <script>
        $(".jobStatus").on('click', function() {
            var url = "{{ route('admin.job.status') }}";
            var token = '{{ csrf_token() }}';
            var thisTag = $(this);
            var data = {
                job_id: $(this).data("id"),
                status_data: $(this).val(),
                _token: token
            }
            $.post(url, data, function(data, status) {
                if (data) {
                    Toast.fire({
                        icon: data.status,
                        title: data.message
                    })
                } else {
                    Toast.fire({
                        icon: 'error',
                        title: data.message
                    })
                }
            });
        });
    </script>

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
