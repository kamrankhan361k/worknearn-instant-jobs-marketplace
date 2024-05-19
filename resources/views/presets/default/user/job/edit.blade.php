@extends($activeTemplate . 'layouts.master')
@section('content')
    <!-- body-wrapper-start -->
    <div class="body-wrapper">
        <div class="body-area">
            <form action="{{ route('user.job.update',$job->id) }}" method="POST" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="form-body">
                    <div class="row g-3">
                        <div class="col-lg-6 col-12 mb-4">
                            <div class="avatar-upload">
                                <div class="avatar-edit">
                                    <input type='file' id="imageUpload" class="form--control" accept=".png, .jpg, .jpeg"
                                        name="image"/>
                                    <label for="imageUpload" class="form--label"></label>
                                </div>
                                <div class="avatar-preview">
                                    <input type="hidden" name="old_image" value="{{ $job->image }}">
                                    <div id="imagePreview" style="background-image: url({{getImage(getFilePath('job'). '/'. $job->image)}});">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 col-12 mb-4">
                            <div class="form-group">
                                <label for="title" class="form--label">@lang('Title')</label>
                                <input type="text" class="form--control" id="title" name="title" step="any"
                                    placeholder="@lang('Title')" required value="{{ @$job->title ?? old('title') }}">
                            </div>
                        </div>

                        <div class="col-lg-6 col-12 mb-4">
                            <div class="form-group">
                                <label class="form--label">@lang('Category')</label>
                                <select class="form-select select" required name="category_id" onchange="category(this);">
                                    <option value="">@lang('Select Category')</option>
                                    @foreach ($categories as $item)
                                        <option value="{{ @$item->id }}" {{@$job->category_id == @$item->id ? 'selected':''}}>{{ @$item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-6 col-12 mb-4">
                            <div class="form-group">
                                <label class="form--label">@lang('Sub Category')</label>
                                <select class="form-select select subCategory" name="sub_category_id" required>
                                    <option selected value="">@lang('Category Select First')</option>
                                    @foreach ($subCategories as $item)
                                        <option value="{{$item->id}}" {{($item->id == $job->sub_category_id) ? "selected":"" }}>{{__($item->name)}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        <div class="col-lg-6 col-12 mb-4">
                            <div class="form-group">
                                <label for="avg_time" class="form--label">@lang('Average Time')</label>
                                <input type="number" class="form--control" id="avg_time" name="avg_time"
                                    placeholder="@lang('Average Time')" required value="{{ @$job->avg_time ?? old('avg_time') }}">
                            </div>
                        </div>


                        <div class="col-lg-6 col-12 mb-4">
                            <div class="form-group">
                                <label for="quantity" class="form--label">@lang('Work Quantity')</label>
                                <input type="number" class="form--control total_amount" id="quantity" name="quantity"
                                    step="any" placeholder="@lang('Work Quantity')" required value="{{ @$job->quantity ?? old('quantity') }}">
                            </div>
                        </div>


                        <div class="col-lg-6 col-12 mb-4">
                            <div class="form-group">
                                <label for="per_worker_earn" class="form--label">@lang('Per Worker Earn')</label>
                                <input type="number" class="form--control total_amount" id="per_worker_earn"
                                    name="per_worker_earn" step="any" placeholder="@lang('Per Worker Earn')"
                                    value="{{ @$job->per_worker_earn ?? old('per_worker_earn') }}">
                            </div>
                        </div>


                        <div class="col-lg-6 col-12 mb-4">
                            <div class="form-group">
                                <label for="total_budge" class="form--label">@lang('Total Amount')</label>
                                <input type="number" class="form--control" id="total_budge" name="total_budge"
                                    placeholder="@lang('Total Amount')" required value="{{ @$job->total_budge ?? old('total_budge') }}" readonly>
                            </div>
                        </div>

                        @php
                            $jobProof = collect($job->job_proof);
                            $firstItem = $jobProof->take(1)->all();
                            $firstItem = collect($firstItem);
                            $remainingItems = $jobProof->slice(1)->all();
                        @endphp


                        <div class="col-sm-12">
                            <div class="form-group">
                                <div class="text-end">
                                    <button type="button" class="btn--base btn--sm addFile">
                                        <i class="fa fa-plus"></i> @lang('Add New')
                                    </button>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 my-3">
                                        <div class="file-upload">
                                            <label class="form-label">@lang('Job Proof')</label>
                                            <p class="ticket-attachments-message text-muted my-3">
                                                @lang('How many file input you need for this job proof?')</p>
                                            <input type="text" name="job_proof[]" id="inputFeatures"
                                                class="form-control form--control mb-2" required
                                                placeholder="@lang('Please enter your file input label')" value ="{{ $firstItem->values()[0] }}">
                                        </div>
                                    </div>
                                </div>
                                <div id="fileUploadsContainer">
                                    @foreach (@$remainingItems ?? [] as $index => $item)
                                        <div class="row elements">
                                            <div class="col-sm-12 my-3">
                                                <div class="file-upload input-group">
                                                    <input type="text" name="job_proof[]" id="inputFacilities{{$index}}"
                                                        class="form-control form--control"
                                                        placeholder="Vehicle Facilaties" value="{{ $item }}"
                                                        required>
                                                        <button class="input-group-text bg--danger remove-btn"><i class="las la-times"></i></button> 
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12 mb-4">
                            <div class="form-group">
                                <label for="description" class="form--label">@lang('Description')</label>
                                <textarea class="form--control trumEdit1" id="description" rows="5" name="description"
                                    placeholder="@lang('Description')">{{ $job->description ?? old('description') }}</textarea>
                            </div>
                        </div>

                    </div>
                    <div class="d-flex justify-content-end my-4">
                        <button class="btn--base" type="submit">@lang('update')</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('style-lib')
    <script src="{{ asset('assets/common/js/ckeditor.js') }}"></script>
@endpush

@push('style')
    <style>
        .avatar-upload {
            position: relative;
            max-width: 205px;
            margin: 50px auto;
        }

        .avatar-upload .avatar-edit {
            position: absolute;
            right: 12px;
            z-index: 1;
            top: 10px;
        }

        .avatar-upload .avatar-edit input {
            display: none;
        }

        .avatar-upload .avatar-edit input+label {
            display: inline-block;
            width: 34px;
            height: 34px;
            margin-bottom: 0;
            border-radius: 100%;
            background: #ffffff;
            border: 1px solid transparent;
            box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.12);
            cursor: pointer;
            font-weight: normal;
            transition: all 0.2s ease-in-out;
        }

        .avatar-upload .avatar-edit input+label:hover {
            background: #f1f1f1;
            border-color: #d6d6d6;
        }

        .avatar-upload .avatar-edit input+label:after {
            content: "\f303";
            font-family: "Font Awesome 5 Free";
            color: #757575;
            position: absolute;
            top: 10px;
            left: 0;
            right: 0;
            text-align: center;
            margin: auto;
        }

        .avatar-upload .avatar-preview {
            width: 192px;
            height: 192px;
            position: relative;
            border-radius: 100%;
            border: 6px solid #f8f8f8;
            box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.1);
        }

        .avatar-upload .avatar-preview>div {
            width: 100%;
            height: 100%;
            border-radius: 100%;
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
        }
    </style>
@endpush


@push('script')
    <script>
        $('.total_amount').on('keyup', function() {
            var quantity = $('input[name=quantity]').val();
            var per_worker_earn = $('input[name=per_worker_earn]').val();
            $('input[name=total_budge]').val(quantity * per_worker_earn);
        })
    </script>

    <script>
        // {{-- --------------------------Category add------------------------------ --}}
        function category(object) {
            var selectedId = $(object).find(':selected').val();
            var url = "{{ route('user.job.sub.category.search') }}";
            var token = '{{ csrf_token() }}';
            var id = selectedId;
            var data = {
                id: id,
                _token: token
            }
            $.ajax({
                type: "POST",
                url: url,
                data: data,
                success: function(data) {
                    var html = "";
                    var subCatrgory = $('.subCategory');
                    if (data.status == "success") {
                        html = "<option>@lang('Select Sub Category')</option>";
                        $.each(data.data, function(key, item) {
                            html += `<option value="${item.id}">${item.name}</option>`
                        });
                        $(subCatrgory).empty().append(html);
                    }
                },
                error: function(data, status, error) {
                    $.each(data.responseJSON.errors, function(key, item) {
                        Toast.fire({
                            icon: 'error',
                            title: item
                        })
                    });
                }
            });
        }
    </script>

    {{-- --------------------------multipul features Add------------------------------ --}}
    <script>
        (function($) {
            "use strict";
            var fileAdded = 0;
            $('.addFile').on('click', function() {
                if (fileAdded >= 20) {
                    notify('error', 'You\'ve added maximum number of file');
                    return false;
                }
                fileAdded++;
                $("#fileUploadsContainer").append(`
                <div class="row elements">
                    <div class="col-sm-12 my-3">
                        <div class="file-upload input-group">
                            <input type="text" name="job_proof[]" id="inputFeatures" class="form-control form--control"
                                 placeholder="Please enter your file input label">
                                 <button class="input-group-text bg--danger remove-btn"><i class="las la-times"></i></button>                                           
                        </div>
                    </div>
                </div>
            `)

                $('.iconPicker').iconpicker().on('iconpickerSelected', function(e) {
                    $(this).closest('.file-upload').find('.iconpicker-input').val(
                        `<i class="${e.iconpickerValue}"></i>`);
                });

            });
            $(document).on('click', '.remove-btn', function() {
                fileAdded--;
                $(this).closest('.elements').remove();
            });
        })(jQuery);
    </script>
    {{-- --------------------------End multipul features Add------------------------------ --}}

    <script>
        (function($) {
            "use strict";
            $(document).ready(function() {
                "use strict";
                if ($(".trumEdit1")[0]) {
                    ClassicEditor
                        .create(document.querySelector('.trumEdit1'))
                        .then(editor => {
                            window.editor = editor;
                        });
                }
            });
        })(jQuery);
    </script>
@endpush
