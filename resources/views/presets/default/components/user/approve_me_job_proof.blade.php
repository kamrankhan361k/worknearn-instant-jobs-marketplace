<div class="applied_job">
    <div class="table-area m-0">
        <table class="custom-table">
            <thead>
                <tr>
                    <th><input type="checkbox"class="select-all"></th>
                    <th>@lang('Job Image')</th>
                    <th>@lang('User Name')</th>
                    <th>@lang('Total Budge')</th>
                    <th>@lang('Percent/Quantity')</th>
                    <th>@lang('Per Worker Earn')</th>
                    <th>@lang('Job Status')</th>
                    <th>@lang('Action')</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jobApplications as $item)
                    <tr>
                        <td data-label="Job Image" class="td-img">
                            <input type="checkbox" name="td_select" id="" value="{{ $item->id }}">
                        </td>
                        <td data-label="Job Image" class="td-img">
                            <img src="{{ getImage(getFilePath('job') . '/' . @$item?->job->image) }}" alt="post-ad">
                        </td>

                        <td data-label="User Name">
                            @if (@$item?->job?->owner_type == 1)
                                {{ __(@$item?->job?->ownerAdmin?->name) }}
                            @else
                                {{ __(@$item?->job?->ownerUser?->fullname) }}
                            @endif
                        </td>

                        <td data-label="Price" class="budget">
                            {{ $general->cur_sym }}{{ __($item?->job?->total_budge) }}
                        </td>

                        <td data-label="quantity">
                           
                            {{ showAmount(($item->done($item->job->id) * 100) / @$item?->job?->quantity) }}% / {{ @$item?->job?->quantity }}
                        </td>

                        <td data-label="Per Worker Earn">
                            {{ $general->cur_sym }}{{ __(@$item?->job?->per_worker_earn) }}
                        </td>
                        @if ($item?->status == 1)
                            <td data-label="Job Status">
                        
                                <button class="btn btn--sm btn--success text-white aproveBtn"
                                    data-url="{{ route('user.job.application.applied.approved', $item->id) }}">
                                    @lang('Approve')
                                </button>

                                <button class="btn btn--sm btn--danger text-white canceledBtn"
                                    data-url="{{ route('user.job.application.applied.canceled', $item->id) }}">
                                    @lang('Canceled')
                                </button>
                            </td>
                        @elseif($item?->status == 0)
                        <td data-label="Job Status">
                            <span class="badge badge--info">@lang('Initial')</span>
                        </td>
                        @else
                            <td data-label="Job Status">
                                @if ($item?->status == 1)
                                    <span class="badge badge--warning">@lang('Pending')</span>
                                @elseif ($item?->status == 2)
                                    <span class="badge badge--success">@lang('Approve')</span>
                                @elseif($item?->status == 3)
                                    <span class="badge badge--danger">@lang('Canceled')</span>
                                @endif
                            </td>
                        @endif
                        <td data-label="Action">
                            <a title="View" class="detailsBtn btn btn--sm btn--base" data-description= "{{ @$item?->description }}"
                                data-attachments= "{{ json_encode(@$item?->attachments) }}">
                                <i class="fas fa-eye"> </i>
                            </a>
                            <a title="Download" href="{{ route('user.job.application.applied.download', $item->id) }}"
                                class="btn btn--sm btn--base">
                                <i class="fas fa-file-download"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td data-label="Image" class="text-muted text-center" colspan="100%">
                            @lang('No data found')
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-5">
        <nav class="d-flex justify-content-end">
            {{ $jobApplications->links() }}
        </nav>
    </div>
</div>
