@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="dashboard-card-wrap mt-0" id="dropzone">
                    <form action="{{ route('admin.job.store') }}" method="POST" enctype ='multipart/form-data'>
                        @csrf
                        <div class="card-body">
                            <div class="row gy-4">
                                <div class="col-lg-6 col-12 ">
                                    <div class="avatar-upload">
                                        <div class="avatar-edit">
                                            <input type='file' id="imageUpload" class="form--control"
                                                accept=".png, .jpg, .jpeg" name="image" />
                                            <label for="imageUpload" class="form--label"></label>
                                        </div>
                                        <div class="avatar-preview">
                                            <div id="imagePreview"
                                                style="background-image: url({{ getImage(getFilePath('default')) }});">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-12 ">
                                    <div class="form-group">
                                        <label for="title" class="form--label">@lang('Title')</label>
                                        <input type="text" class="form-control" id="title" name="title"
                                            placeholder="@lang('Title')" required value="{{ old('title') }}">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-12 ">
                                    <div class="form-group">
                                        <label class="form--label">@lang('Category')</label>
                                        <select class="form-select select" required name="category_id"
                                            onchange="category(this);">
                                            <option selected value="">@lang('Select Category')</option>
                                            @foreach ($categories as $item)
                                                <option value="{{ @$item->id }}">{{ @$item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-12 ">
                                    <div class="form-group">
                                        <label class="form--label">@lang('Sub Category')</label>
                                        <select class="form-select select subCategory" name="sub_category_id" required>
                                            <option selected value="">@lang('Category Select First')</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-12">
                                    <div class="form-group">
                                        <label for="avg_time" class="form--label">@lang('Average Time')</label>
                                        <input type="number" class="form-control" id="avg_time" name="avg_time"
                                            placeholder="@lang('Average Time')" required value="{{ old('avg_time') }}">
                                    </div>
                                </div>

                                <div class="col-lg-6 col-12">
                                    <div class="form-group">
                                        <label for="quantity" class="form--label">@lang('Work Quantity')</label>
                                        <input type="number" class="form-control total_amount" id="quantity"
                                            name="quantity" step="any" placeholder="@lang('Work Quantity')" required
                                            value="{{ old('quantity') }}">
                                    </div>
                                </div>


                                <div class="col-lg-6 col-12">
                                    <div class="form-group">
                                        <label for="per_worker_earn" class="form--label">@lang('Per Worker Earn')</label>
                                        <input type="number" class="form-control total_amount" id="per_worker_earn"
                                            name="per_worker_earn" step="any" placeholder="@lang('Per Worker Earn')"
                                            value="{{ old('per_worker_earn') }}">
                                    </div>
                                </div>


                                <div class="col-lg-6 col-12">
                                    <div class="form-group">
                                        <label for="total_budge" class="form--label">@lang('Total Amount')</label>
                                        <input type="number" class="form-control" id="total_budge" name="total_budge"
                                            placeholder="@lang('Total Amount')" required value="{{ old('total_budge') }}"
                                            readonly>
                                    </div>
                                </div>

                                <div class="col-lg-12 mb-4">
                                    <div class="form-group">
                                        <label for="description" class="form--label">@lang('Description')</label>
                                        <textarea class="form--control trumEdit1" id="description" rows="5" name="description"
                                            placeholder="@lang('Description')">{{ old('description') }}</textarea>
                                    </div>
                                </div>

                            </div>
                            <div class="d-flex justify-content-end my-4">
                                <button class="btn btn-success btn--sm button" type="submit">@lang('Save')</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

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

        .ck-rounded-corners .ck.ck-editor__main>.ck-editor__editable,
        .ck.ck-editor__main>.ck-editor__editable.ck-rounded-corners {
            height: 210px;
        }
    </style>
@endpush

@push('script')
    <script>
        $('.total_amount').on('keyup', function() {
            var quantity = $('input[name=quantity]').val();
            var per_worker_earn = $('input[name=per_worker_earn]').val();
            $('input[name=total_budge]').val((quantity * per_worker_earn).toFixed(2));
        })
    </script>

    
    {{-- --------------------------single image preview------------------------------- --}}
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#imagePreview').css('background-image', 'url(' + e.target.result + ')');
                    $('#imagePreview').hide();
                    $('#imagePreview').fadeIn(650);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#imageUpload").on('change',function() {
            readURL(this);
        });
    </script>
    {{-- --------------------------End Single image preview------------------------------- --}}


    {{-- --------------------------Category add------------------------------ --}}
    <script>
        function category(object) {
            var selectedId = $(object).find(':selected').val();
            var url = "{{ route('admin.job.sub.category.search') }}";
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
