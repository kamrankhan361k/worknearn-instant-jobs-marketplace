@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <section class="jobs-details pt-150 pb-80">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-12">
                    <div class="left-side">
                        <div class="profile">
                            <div class="thumb">
                                <img src="{{ getImage(getFilePath('job') . '/' . $job->image) }}" alt="image">
                            </div>
                            <h4>{{ __(@$job->title) }}</h4>
                        </div>
                        <div class="desc">
                            <h5>@lang('Job Description')</h5>
                            <div>
                                @php
                                    echo __(@$job->description);
                                @endphp
                            </div>
                        </div>
                    </div>
                    @if (@$job->job_status != 2)
                        <div class="upload">
                            <h5>@lang('Enter The Required Proof Of Job Finished:')</h5>
                            <form action="{{ route('job.application.proof', $job->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <textarea class="form--control mb-2" cols="30" rows="10" name="description"></textarea>

                                <div class="col-sm-12 text-end">
                                    <button type="button" class="btn--base btn--sm ms-2 addFile">
                                        <i class="fa fa-plus"></i> @lang('Add New')
                                    </button>
                                </div>
                                <div class="col-lg-12">
                                    <div class="attachment_wrapper">
                                        <div class="form-group profile">
                                            <div class="single-input form-group mt-3">
                                                <input class="form--control" type="file" name="attachments[]" id="inputAttachments" accept=".png, .jpg, .jpeg, .webp, .pdf, .doc, .docx, .xlsx, .xls, .csv, .xml, .pptx, .html, .css">

                                            </div>
                                            <div id="fileUploadsContainer"></div>

                                        </div>
                                    </div>
                                </div>
                                <p class="ticket-attachments-message text-muted"> @lang('Allowed File Extensions'): <span
                                        class="text-danger">.@lang('jpg'), .@lang('jpeg'),
                                        .@lang('png'), .@lang('webp'), .@lang('pdf'), .@lang('doc'),
                                        .@lang('docx'), .@lang('xlsx'), .@lang('xls'), .@lang('csv'),
                                        .@lang('xml'), .@lang('html'), .@lang('css')</span> </p>
                                <button class="btn--base w-100" type="submit">@lang('Request For Complete')</button>
                            </form>
                        </div>
                    @endif
                </div>
                <div class="col-lg-4 col-12">
                    <div class="right-side">
                        <div class="top-title">
                            <h4>@lang('Job information')</h4>
                            <div class="hr1"></div>
                        </div>
                        <div class="info">
                            <div class="icon">
                                <i class="fas fa-briefcase"></i>
                            </div>
                            <div class="content">
                                <p>@lang('Job id') {{ @$job->unique_id }}</p>
                                @if ($job->owner_type == 1)
                                    <h6>@lang('Job posted by') {{ @$job->ownerAdmin->name }}</h6>
                                @else
                                    <h6>@lang('Job posted by') {{ @$job->owneruser->fullname }}</h6>
                                @endif
                            </div>
                        </div>
                        <div class="info">
                            <div class="icon">
                                <i class="far fa-credit-card"></i>
                            </div>
                            <div class="content">
                                <p>@lang('Payment')</p>
                                <h6>{{ $general->cur_sym . @$job->per_worker_earn }} </h6>
                            </div>
                        </div>
                        <div class="info">
                            <div class="icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="content">
                                <p>@lang('Success Rate')</p>
                                <h6>{{ __(showAmount(($job->done() * 100) / $job->quantity)) }}</h6>
                            </div>
                        </div>
                        <div class="info">
                            <div class="icon">
                                <i class="fas fa-thumbs-up"></i>
                            </div>
                            <div class="content">
                                <p>@lang('Job Done')</p>
                                <h6>{{ __($job->done()) }}/{{ $job->quantity }}</h6>
                            </div>
                        </div>

                        @if (@$job->job_status != 2)
                            <div class="info">
                                <div class="content">
                                    <button class="btn--base confirmationBtn" data-question="@lang('Are you sure you want this job?')">
                                        @lang('Start Now')</button>
                                </div>
                            </div>
                        @endif

                    </div>
                    <div class="social">
                        <div class="top-title">
                            <h4>@lang('Share This Post')</h4>
                            <div class="hr1"></div>
                        </div>
                        <div class="d-flex">
                            <a href="https://www.facebook.com/share.php?u={{ Request::url() }}&title={{ slug(@$job->title) }}"
                                class="icon">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="https://twitter.com/intent/tweet?status={{ slug(@$job->title) }}+{{ Request::url() }}"
                                class="icon">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ Request::url() }}&title={{ slug(@$job->title) }}&source=behands"
                                class="icon">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            <a href="https://www.pinterest.com/pin/create/button/?url={{ Request::url() }}&description={{ slug(@$job->title) }}"
                                class="icon">
                                <i class="fab fa-pinterest-p"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div id="confirmationModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Confirmation Alert!')</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="{{ route('job.application.store', $job->id) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <p class="question">@lang('Are you sure you want this job?')</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--danger text-white" data-bs-dismiss="modal">@lang('No')</button>
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
            $(document).on('click', '.confirmationBtn', function() {
                var modal = $('#confirmationModal');
                modal.modal('show');
            });
        })(jQuery);
    </script>
    <script>
        (function($) {
            "use strict";
            var fileAdded = 0;
            $('.addFile').on('click', function() {
                if (fileAdded >= 4) {
                    notify('error', 'You\'ve added maximum number of file');
                    return false;
                }
                fileAdded++;
                $("#fileUploadsContainer").append(`
                        <div class="input-group my-3">
                            <input type="file" name="attachments[]" class="form-control form--control" required />
                            <button class="input-group-text btn-danger remove-btn"><i class="las la-times"></i></button>
                        </div>
                    `)
            });
            $(document).on('click', '.remove-btn', function() {
                fileAdded--;
                $(this).closest('.input-group').remove();
            });
        })(jQuery);
    </script>
@endpush
