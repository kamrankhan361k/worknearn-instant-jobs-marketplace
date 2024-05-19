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
                                @forelse ($categories as $category)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td><strong>{{ __($category->name) }}</strong></td>
                                        <td>
                                            @if ($category->status == 1)
                                                <span
                                                    class="text--small badge font-weight-normal badge--success">@lang('Active')</span>
                                            @else
                                                <span
                                                    class="text--small badge font-weight-normal badge--danger">@lang('Pending')</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="button--group">
                                                <button title="@lang('Edit')" href="javascript:void(0)"
                                                    class="btn btn-sm btn--primary ms-1 editButtons"
                                                    data-category="{{ json_encode($category->only('name', 'status')) }}"
                                                    data-bs-toggle="modal" data-bs-target="#editModal"
                                                    data-url="{{ route('admin.category.update', $category->id) }}"
                                                    onclick="editButton(this)">
                                                    <i class="la la-pen"></i>
                                                </button>
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
            </div><!-- card end -->
        </div>
    </div>


    {{-- NEW MODAL --}}
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="createModalLabel"> @lang('Add New Category')</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><i
                            class="las la-times"></i></button>
                </div>
                <form class="form-horizontal" method="post" action="{{ route('admin.category.store') }}"
                    enctype="multipart/form-data">
                    @csrf

                    <div class="modal-body">
                        <div class="row form-group">
                            <label>@lang('Category Name')</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" value="{{ old('name') }}" name="name"
                                    required>
                            </div>
                        </div>


                        <div class="form-group">
                            <label>@lang(' Status')</label>
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

    {{-- EDIT MODAL --}}
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="editModalLabel">@lang('Edit Category')</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><i
                            class="las la-times"></i></button>
                </div>
                <form class="form-horizontal" method="post" enctype="multipart/form-data">
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
                            <label>@lang('Status')</label>
                            <div class="col-sm-12">
                                <select name="status" id="setDefault" class="form-control">
                                    <option value="0">@lang('Pending')</option>
                                    <option value="1">@lang('Active')</option>
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
    <a class="btn btn-sm btn--primary" data-bs-toggle="modal" data-bs-target="#createModal"><i
            class="las la-plus"></i>@lang('Add New')</a>
@endpush

@push('script')
    <script>
        function editButton(object) {
            var modal = $('#editModal');
            var form = $(modal).find('form');

            var category = $(object).data('category');
            var url = $(object).data('url');

            $(modal).find('input[name=name]').val(category.name);
            var status = $(object).data('url');
            form.attr('action', url);
        }

    </script>
@endpush
