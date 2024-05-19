@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two custom-data-table">
                            <thead>
                                <tr>
                                    <th>@lang('SI')</th>
                                    <th>@lang('Name')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Actions')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($subCategories as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td><strong>{{ __($item->name) }}</strong></td>
                                        <td>
                                            @if ($item->status == 1)
                                                <span
                                                    class="text--small badge font-weight-normal badge--success">@lang('Active')</span>
                                            @else
                                                <span
                                                    class="text--small badge font-weight-normal badge--danger">@lang('Inactive')</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="button--group">
                                                <a title="@lang('Edit')" href="javascript:void(0)"
                                                    class="btn btn-sm btn--primary ms-1 editBtn"
                                                    data-url="{{ route('admin.sub.category.update', $item->id) }}"
                                                    data-sub-category="{{ json_encode($item->only('name', 'category_id', 'status')) }}">
                                                    <i class="la la-pen"></i>
                                                </a>
                                            </div>
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
                @if ($subCategories->hasPages())
                <div class="card-footer py-4">
                    @php echo paginateLinks($subCategories) @endphp
                </div>
                @endif
            </div><!-- card end -->
        </div>
    </div>


    {{-- New Sub-Category Modal --}}
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="createModalLabel"> @lang('Add Sub-Category')</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><i
                            class="las la-times"></i></button>
                </div>
                <form class="form-horizontal" method="post" action="{{ route('admin.sub.category.store') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="row form-group">
                            <label>@lang('Name')</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" value="{{ old('name') }}" name="name"
                                    required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>@lang('Category')</label>
                            <div class="col-sm-12">
                                <select name="category_id" id="setDefault" class="form-control">
                                    @foreach ($categories as $item)
                                        <option value="{{ $item->id }}">{{ __($item->name) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>@lang('Status')</label>
                            <div class="col-sm-12">
                                <select name="status" id="setDefault" class="form-control">
                                    <option value="1">@lang('Active')</option>
                                    <option value="0">@lang('Disable')</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--primary btn-global" id="btn-save"
                            value="add">@lang('Save')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Edit Sub-Category Modal --}}
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="editModalLabel">@lang('Edit Sub-Category')</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><i
                            class="las la-times"></i></button>
                </div>
                <form method="post">
                    @csrf
                    @method('put')
                    <div class="modal-body">
                        <div class="form-group">
                            <label>@lang('Category Name')</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" value="{{ old('name') }}" name="name"
                                    required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>@lang('Category')</label>
                            <div class="col-sm-12">
                                <select name="category_id" id="setDefault" class="form-control">
                                    @foreach ($categories as $item)
                                        <option value="{{ $item->id }}">{{ __($item->name) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>@lang('Category Status')</label>
                            <div class="col-sm-12">
                                <select name="status" id="setDefault" class="form-control">
                                    <option @if (1) selected @endif value="1">
                                        @lang('Active')</option>
                                    <option @if (0) selected @endif value="0">
                                        @lang('Inactive')</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--primary btn-global" id="btn-save"
                            value="add">@lang('Save')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <x-confirmation-modal></x-confirmation-modal>
@endsection


@push('breadcrumb-plugins')
    <a class="btn btn-sm btn--primary addBtn" data-bs-toggle="modal" data-bs-target="#createModal"><i
            class="las la-plus"></i>@lang('Add New')</a>
@endpush


@push('script')
    <script>
        (function($) {
            "use strict";
            $('.addBtn').on('click', function() {
                var modal = $('#createModal');
                modal.modal('show');
            });

            $('.editBtn').on('click', function() {
                var modal = $('#editModal');
                var url = $(this).data('url');
                var subCategory = $(this).data('sub-category');
                modal.find('form').attr('action', url);
                modal.find('input[name=name]').val(subCategory.name);
                modal.find('select[name=category_id]');
                var options = modal.find('select[name=category_id]').find('option');
                options.each(function() {
                    if (subCategory.category_id == parseInt($(this).val())) {
                        $(this).attr("selected", true);
                    }
                });
                modal.find('select[name=status]').val(subCategory.status);
                modal.modal('show');
            });
        })(jQuery);
    </script>
@endpush
