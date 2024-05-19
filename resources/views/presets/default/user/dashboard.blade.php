@extends($activeTemplate . 'layouts.master')
@section('content')
    <!-- body-wrapper-start -->
    <div class="body-wrapper">
        <div class="table-content">
            <div class="row gy-4 mb-4">
                <div class="col-xl-3 col-lg-4 col-md-4 col-12">
                    <div class="dash-card">
                        <a href="#" class="d-flex justify-content-between">
                            <div>
                                <div>
                                    <p>@lang('Total Job')</p>
                                </div>
                                <div class="content">
                                    <span class="text-uppercase">{{$totalJob}}</span>
                                </div>
                            </div>
                            <div class="icon my-auto">
                                <i class="fas fa-toolbox"></i>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-4 col-12">
                    <div class="dash-card">
                        <a href="#" class="d-flex justify-content-between">
                            <div>
                                <div>
                                
                                    <p>@lang('Approve Job')</p>
                                </div>
                                <div class="content">
                                    <span class="text-uppercase">{{$totalJobApprove}}</span>
                                </div>
                            </div>
                            <div class="icon my-auto">
                                <i class="fas fa-check-circle"></i>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-4 col-12">
                    <div class="dash-card">
                        <a href="#" class="d-flex justify-content-between">
                            <div>
                                <div>
                                    <p>@lang('Pending Job')</p>
                                </div>
                                <div class="content">
                                    <span class="text-uppercase">{{$totalJobPending}}</span>
                                </div>
                            </div>
                            <div class="icon my-auto">
                                <i class="fas fa-pause-circle"></i>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-4 col-12">
                    <div class="dash-card">
                        <a href="#" class="d-flex justify-content-between">
                            <div>
                                <div>
                                    <p>@lang('Finished Job')</p>
                                </div>
                                <div class="content">
                                    <span class="text-uppercase">{{$totalJobFinished}}</span>
                                </div>
                            </div>
                            <div class="icon my-auto">
                                <i class="fas fa-check-double"></i>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-12">
                    <div class="chart">
                        <div class="chart-bg">
                            <div id="chart"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="m-0">
                <div class="list-card">
                    <div class="header-title-list">
                        <h4 class="pb-0">@lang('Recent Activities')</h4>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-xl-12">
                            <table class="custom-table">
                                <thead>
                                    <tr>
                                        <th>@lang('Trx')</th>
                                        <th>@lang('Transacted')</th>
                                        <th>@lang('Amount')</th>
                                        <th>@lang('Remark')</th>
                                        <th>@lang('Post Balance')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($transactions as $trx)
                                        <tr>
                                            <td data-label="Trx">
                                                <strong>{{ $trx->trx }}</strong>
                                            </td>
                                            <td data-label="Transacted">
                                                {{ showDateTime($trx->created_at) }}<br>{{ diffForHumans($trx->created_at) }}
                                            </td>

                                            <td data-label="Amount" class="budget">
                                                <span
                                                    class="fw-bold @if ($trx->trx_type == '+') text-success @else text-danger @endif">
                                                    {{ $trx->trx_type }} {{ showAmount($trx->amount) }}
                                                    {{ $general->cur_text }}
                                                </span>
                                            </td>
                                            <td data-label="Detail">
                                                {{ __($trx->remark) }}
                                            </td>
                                            <td data-label="Post Balance" class="budget">
                                                <span class="badge badge--primary">{{ showAmount($trx->post_balance) }}
                                                    {{ __($general->cur_text) }}</span>
                                            </td>

                                        @empty
                                        <tr>
                                            <td data-label="Trx" class="text-muted text-center" colspan="100%">
                                                @lang('No Transaction found')
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-5">
                            <nav class="d-flex justify-content-end">
                                {{ $transactions->links() }}
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        var options = {
            series: [{
                name: 'Deposit',
                color: "#8358ff",
                data: @json($depositsChart['values'])
            }, {
                name: 'Withdrawls',
                data: @json($withdrawalsChart['values'])
            }],
            chart: {
                height: 350,
                type: 'area',
                toolbar: {
                    show: false
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth'
            },
            xaxis: {
                type: 'datetime',
                categories: ["2018-09-19", "2018-09-19", "2018-09-19",
                    "2018-09-19", "2018-09-19", "2018-09-19",
                    "2018-09-19"
                ]
            },
            tooltip: {
                x: {
                    format: 'dd/MM/yy HH:mm'
                },
            },
        };

        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();
    </script>
@endpush
