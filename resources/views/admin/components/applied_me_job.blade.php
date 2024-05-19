<div class="card b-radius--10">
    <div class="card-body p-0">
        <div class="table-responsive--md table-responsive">
            <table class="table table--light style--two">
                <thead>
                    <tr>
                        <th><input type="checkbox"class="select-all"></th>
                        <th>@lang('Job Image')</th>
                        <th>@lang('User Name')</th>
                        <th>@lang('Title')</th>
                        <th>@lang('Total Budge')</th>
                        <th>@lang('Percent/Quantity')</th>
                        <th>@lang('Per Worker Earn')</th>
                        <th>@lang('Job Status')</th>
                        <th>@lang('Action')</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($jobApplications as $index => $item)
                        <tr>
                            <td class="text-center">
                                <input type="checkbox" name="td_select" id="" value="{{ $item->id }}">
                            </td>
                            <td class="text-center">
                                <img src="{{ getImage(getFilePath('job') . '/' . @$item?->job->image) }}"
                                    alt="post-ad">
                            </td>
                            <td data-label="User Name">
                                @if (@$item?->job_holder_type == 1)
                                    {{ __(@$item?->job?->ownerAdmin?->name) }}
                                @else
                                    {{ __(@$item?->job?->ownerUser?->firstname) }}
                                @endif
                            </td>

                            <td>
                                {{ __(@$item?->job?->title) }}
                            </td>

                            <td>
                                {{ $general->cur_sym }}{{ __($item?->job?->total_budge) }}
                            </td>

                            <td>
                                {{ showAmount(($item->done($item->job->id) * 100) / @$item?->job?->quantity) }}% / {{ @$item?->job?->quantity }}
                            </td>

                            <td>
                                {{ $general->cur_sym }}{{ __(@$item?->job?->per_worker_earn) }}
                            </td>

                            <td data-label="Job Status">
                                @if ($item?->status == 1)
                                 
                                    <button class="btn btn-sm btn--success aproveBtn"
                                        data-url="{{ route('admin.job.application.applied.approved', $item->id) }}">
                                        @lang('Approve')
                                    </button>

                                    <button class="btn btn-sm btn--danger canceledBtn"
                                        data-url="{{ route('admin.job.application.applied.canceled', $item->id) }}">
                                        @lang('Canceled')
                                    </button>

                                @else
                                    @if ($item?->status == 1)
                                        <span class="badge badge--warning">@lang('Pending')</span>
                                    @elseif ($item?->status == 2)
                                        <span class="badge badge--success">@lang('Approve')</span>
                                    @elseif($item?->status == 3)
                                        <span class="badge badge--danger">@lang('Canceled')</span>
                                    @endif
                                @endif

                            </td>
                            <td>
                                <button class=" detailsBtn btn btn-sm btn--primary"
                                    data-description= "{{ @$item?->description }}"
                                    data-attachments= "{{ json_encode(@$item?->attachments) }}">
                                    <i class="fas fa-eye"> </i>
                                </button>

                                <a title="@lang('Job Proof')"
                                    href="{{ route('admin.job.application.applied.download', $item?->id) }}"
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
