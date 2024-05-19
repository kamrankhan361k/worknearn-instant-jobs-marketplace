@extends('admin.layouts.app')
@section('panel')
<button class="btn btn-success btn--sm all-approve d-none">@lang('Approve all')</button>
    @include('admin.components.tabs.job')
    <div class="row">
        <div class="col-lg-12 applied_me_job">
            @include('admin.components.applied_me_job')
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

    <div id="canceledModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Reason')</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="" method="post">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="id">
                        <textarea type="text" class="form--control" placeholder="Canceled Reason"name="reason"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--danger" data-bs-dismiss="modal">@lang('No')</button>
                        <button type="submit" class="btn btn--primary text--white">@lang('Yes')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="approveModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Approve')</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="" method="post">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="id">

                        <p>@lang('Are you sure you approved this job document?')</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--danger" data-bs-dismiss="modal">@lang('No')</button>
                        <button type="submit" class="btn btn--primary text--white">@lang('Yes')</button>
                    </div>
                </form>
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
            $(document).on('click', '.canceledBtn', function() {
                var modal = $('#canceledModal');
                var id = $(this).data("id");
                modal.find('input[name=id]').val(id);
                modal.find('form').attr('action', $(this).data('url'));
                modal.modal('show');
            });
        })(jQuery);
    </script>

    <script>
        (function($) {
            "use strict";
            $(document).on('click', '.aproveBtn', function() {
                var modal = $('#approveModal');
                var id = $(this).data("id");
                modal.find('input[name=id]').val(id);
                modal.find('form').attr('action', $(this).data('url'));
                modal.modal('show');
            });
        })(jQuery);
    </script>

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

    <script>
        $('.select-all').on('click', function() {
            var existCheckd = $('input[name^="td_select"]:checked');
            
            if (existCheckd.length > 0) {
                $(this).prop('checked', false);
                $('input[name="td_select"]').prop('checked', false);
                $('.all-approve').addClass('d-none');
            } else {
                $('input[name="td_select"]').prop('checked', true);
                $('.all-approve').removeClass('d-none');
            }
   
        });

        $('.all-approve').on('click', function() {
            var ids = [];
            var thisTag = $(this);
            var allInput = $('input[type="checkbox"][name^="td_select"]:checked');
            allInput.each(function() {
                ids.push($(this).val());
            });
            var url = "{{ route('admin.job.application.applied.all.approved') }}";
            var token = '{{ csrf_token() }}';
            var data = {
                ids: ids,
                job_id: {{ request()->id }},
                _token: token
            }
            $.post(url, data, function(data, status) {
                if (data) {
                    $('.applied_me_job').html(data.data);
                    Toast.fire({
                        icon: data.status,
                        title: data.message
                    });

                } else {
                    Toast.fire({
                        icon: 'error',
                        title: data.message
                    })
                }
            });
        })
    </script>
@endpush
