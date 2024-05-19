@extends($activeTemplate . 'layouts.master')
@section('content')
    <!-- body-wrapper-start -->
    <div class="body-wrapper">
        <div class="body-area">
            <form action="{{ route('user.job.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-body">
                    <div class="row">
                        <div class="col-xl-9 col-lg-8 col-12">
                            <div class="row g-3">
                                <div class="col-12 mb-4">
                                    <div class="form-group">
                                        <label for="title" class="form--label">@lang('Title')</label>
                                        <input type="text" class="form--control" id="title" name="title"
                                            placeholder="@lang('Title')" required value="{{ old('title') }}">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-12 mb-4">
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
                                <div class="col-lg-6 col-12 mb-4">
                                    <div class="form-group">
                                        <label class="form--label">@lang('Sub Category')</label>
                                        <select class="form-select select subCategory" name="sub_category_id" required>
                                            <option selected value="">@lang('Category Select First')</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-12 mb-4">
                                    <div class="form-group">
                                        <label for="avg_time" class="form--label">@lang('Average Time')</label>
                                        <input type="number" class="form--control" id="avg_time" name="avg_time"
                                            placeholder="@lang('Average Time')" required value="{{ old('avg_time') }}">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-12 mb-4">
                                    <div class="form-group">
                                        <label for="quantity" class="form--label">@lang('Work Quantity')</label>
                                        <input type="number" class="form--control total_amount" id="quantity"
                                            name="quantity" step="any" placeholder="@lang('Work Quantity')" required
                                            value="{{ old('quantity') }}">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-12 mb-4">
                                    <div class="form-group">
                                        <label for="per_worker_earn" class="form--label">@lang('Per Worker Earn')</label>
                                        <input type="number" class="form--control total_amount" id="per_worker_earn"
                                            name="per_worker_earn" step="any" placeholder="@lang('Per Worker Earn')"
                                            value="{{ old('per_worker_earn') }}">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-12 mb-4">
                                    <div class="form-group">
                                        <label for="total_budge" class="form--label">@lang('Total Amount')</label>
                                        <input type="number" class="form--control" id="total_budge" name="total_budge"
                                            placeholder="@lang('Total Amount')" required value="{{ old('total_budge') }}"
                                            readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-4 col-12">
                            <div class="form-group">
                                <div class="image-upload">
                                    <div class="thumb">
                                        <div class="avatar-preview">
                                            <div class="profilePicPreview"
                                            style="background-image: url({{getImage(getFilePath('default'))}});">
                                                <button type="button" class="remove-image"><i class="fa fa-times"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="avatar-edit">
                                            <input type="file" class="profilePicUpload" name="image"
                                                id="profilePicUpload1" accept=".png, .jpg, .jpeg">
                                                <small class="mt-2 text-danger">@lang('image size 30x30px.')</small>
                                            <label for="profilePicUpload1" class="btn btn--base">@lang('Upload')</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 mb-4">
                            <div class="form-group">
                                <label for="description" class="form--label">@lang('Description')</label>
                                <textarea class="form--control trumEdit1" id="description" rows="5" name="description"
                                    placeholder="@lang('Description')">{{ old('description') }}</textarea>
                            </div>
                        </div>

                    </div>
                    <div class="d-flex justify-content-end my-4">
                        <button class="btn--base" type="submit">@lang('Save')</button>
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
        .image-upload .thumb .profilePicPreview {ö
            width: 100%;
            height: 210px;
            display: block;
            border-radius: 10px;
            background-size: cover !important;
            background-position: top;
            background-repeat: no-repeat;
            position: relative;
            overflow: hidden;
        }

        @media (max-width:1500px) {
            .image-upload .thumb .profilePicPreview {
                height: 152px;
            }
        }

        .image-upload .thumb .profilePicPreview.logoPicPrev {
            background-size: contain !important;
            background-position: center;
        }

        .image-upload .thumb .profilePicUpload {
            font-size: 0;
            display: none;
        }

        .image-upload .thumb .avatar-edit label {
            text-align: center;
            line-height: 32px;
            font-size: 18px;
            cursor: pointer;
            padding: 2px 25px;
            width: 100%;
            border-radius: 5px;
            box-shadow: 0 5px 10px 0 rgb(0 0 0 / 16%);
            transition: all 0.3s;
            margin-top: 6px;
        }

        .image-upload .thumb .profilePicPreview .remove-image {
            position: absolute;
            top: 5px;
            right: 5px;
            text-align: center;
            width: 34px;
            height: 34px;
            font-size: 23px;
            border-radius: 50%;
            background-color: hsl(var(--base));
            color: #ffffff;
            display: none;
            opacity: .8;
        }

        .image-upload .thumb .profilePicPreview .remove-image:hover {
            opacity: 1;
        }

        .image-upload .thumb .profilePicPreview.has-image .remove-image {
            display: block;
        }
    </style>
@endpush


@push('script')
    <script>
        $('.total_amount').on('keyup', function() {
            var quantity = $('input[name=quantity]').val();
            var per_worker_earn = $('input[name=per_worker_earn]').val();
            var total_budge = (quantity * per_worker_earn).toFixed(2);
            $('input[name=total_budge]').val(total_budge);
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
    <script>
        // image preview
        function proPicURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var preview = $(input).parents('.thumb').find('.profilePicPreview');
                    $(preview).css('background-image', 'url(' + e.target.result + ')');
                    $(preview).addClass('has-image');
                    $(preview).hide();
                    $(preview).fadeIn(650);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        $(".profilePicUpload").on('change', function() {
            proPicURL(this);
        });

        $(".remove-image").on('click', function() {
            $(this).parents(".profilePicPreview").css('background-image', 'none');
            $(this).parents(".profilePicPreview").removeClass('has-image');
            $(this).parents(".thumb").find('input[type=file]').val('');
        });
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
