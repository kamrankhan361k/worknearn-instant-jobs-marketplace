@extends($activeTemplate . 'layouts.master')
@section('content')
    <!-- body-wrapper-start -->
    <div class="body-wrapper">
        <div class="table-content">
            <div class="m-0">
                <div class="list-card">
                    <div class="d-flex justify-content-end mb-3">
                        <a href="{{ route('ticket.open') }}" class="btn--base">@lang('Create Ticket')</a>
                    </div>
                    <div class="table-area m-0">
                        <table class="custom-table">
                            <thead>
                                <tr>
                                    <th>@lang('Subject')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Priority')</th>
                                    <th>@lang('Last Reply')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($supports as $support)
                                    <tr>
                                        <td data-label="Subject">
                                            <a href="{{ route('ticket.view', $support->ticket) }}" class="fw-bold text-black">
                                                [@lang('Ticket')#{{ $support->ticket }}] {{ __($support->subject) }}
                                            </a>
                                        </td>
                                        <td data-label="Status">
                                            <span> @php echo $support->statusBadge; @endphp </span>
                                        </td>
                                        <td data-label="Priority">
                                            @if ($support->priority == 1)
                                                <span class="badge badge--danger">@lang('Low')</span>
                                            @elseif($support->priority == 2)
                                                <span class="badge badge--success">@lang('Medium')</span>
                                            @elseif($support->priority == 3)
                                                <span class="badge badge--primary">@lang('High')</span>
                                            @endif
                                        </td>
                                        <td data-label="Last Reply">
                                            {{ \Carbon\Carbon::parse($support->last_reply)->diffForHumans() }}
                                        </td>

                                        <td data-label="Action" class="table-dropdown">
                                            <i class="fas fa-ellipsis-v" data-bs-toggle="dropdown"
                                                aria-expanded="false"></i>

                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="{{ route('ticket.view', $support->ticket) }}">@lang('View')
                                                    </a>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td data-label="Subject" colspan="100%" class="text-center">@lang('No Ticket Found')</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{ $supports->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
