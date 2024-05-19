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

                                        <td>
                                            {{ __(@$item?->job?->title) }}
                                        </td>

                                        <td>
                                            {{ $general->cur_sym }}{{ __($item?->job?->total_budge) }}
                                        </td>

                                        <td>
                                            {{@$item?->job?->quantity}}/ {{ showAmount(($item->done($item->job->id) * 100) / @$item?->job?->quantity) }}%
                                        </td>

                                        <td>
                                            {{ __(@$item?->job?->per_worker_earn) }}
                                        </td>

                                        <td>
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

                                        <td>
                                            <button class=" detailsBtn btn btn-sm btn--primary"
                                                data-description= "{{ @$item?->description }}"
                                                data-attachments= "{{ json_encode(@$item?->attachments) }}">
                                                <i class="fas fa-eye"> </i>
                                            </button>
                                            <a title="@lang('Download')"
                                                href="{{route('admin.job.application.download',$item->id)}}"
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
