<div class="job_list">
    <div class="joblist">
        <table class="custom-table">
            <thead>
                <tr>
                    <th>@lang('Job Name')</th>
                    <th>@lang('Payment')</th>
                    <th>@lang('Success')</th>
                    <th>@lang('Done')</th>
                    <th>@lang('Avg. Time')</th>
                    <th>@lang('Action')</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($jobs as $item)
                    <tr>
                        <td data-label="JobName">
                            <div class="job-td">
                                <img src="{{ getImage(getFilePath('job') . '/' . $item->image) }}" alt="image">
                                <p>{{ @$item?->title }}</p>
                            </div>
                        </td>
                        <td data-label="Payment">{{ @$general->cur_sym . @$item?->per_worker_earn }}</td>
                        <td data-label="Success">
                            {{ showAmount(($item->done($item->id) * 100) / @$item?->quantity) }}%</td>
                        <td data-label="done">{{ $item->done() . '/' . $item?->quantity }}</td>
                        <td data-label="avg-time">{{ getDurationForHumans($item->avg_time) }}
                            @lang('min')</td>
                        <td data-label="Action"><a href="{{ route('job.details', [$item->id, slug($item->title)]) }}"
                                class="btn--base btn--sm">@lang('More Info')</a></td>
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
        @if ($jobs->hasPages())
            {{ $jobs->links() }}
        @endif
    </div>
</div>
@push('script')
    <script>
        (function($) {
            var subCategories = [];
            var searchValue = '';
            var minTime =0;
            var maxTime =0; 
            var paymentMin =0;
            var paymentMax=0;
            "use strict";
            $("input[type='checkbox'][name^='sub_categories_']").on('click', function() {
                subCategories = [];
                $('.filter-by-category:checked').each(function() {
                    if (!subCategories.includes(parseInt($(this).val()))) {
                        subCategories.push(parseInt($(this).val()));
                    }
                });
                getFilteredData(subCategories, searchValue, minTime, maxTime, paymentMin ,paymentMax)
            });

            $("#searchValue").on('keyup', function() {
                searchValue = $(this).val();
                getFilteredData(subCategories, searchValue, minTime, maxTime, paymentMin ,paymentMax)
            });

            $("#minTime").on('keyup', function() {
                minTime = $(this).val();
                getFilteredData(subCategories, searchValue, minTime, maxTime, paymentMin ,paymentMax)
            });

            $("#maxTime").on('keyup', function() {
                maxTime = $(this).val();
                getFilteredData(subCategories, searchValue, minTime, maxTime, paymentMin ,paymentMax)
            });

            $("#paymentMin").on('keyup', function() {
                paymentValue = $(this).val();
                getFilteredData(subCategories, searchValue, minTime, maxTime, paymentMin ,paymentMax)
            });

            $("#paymentMax").on('keyup', function() {
                paymentValue = $(this).val();
                getFilteredData(subCategories, searchValue, minTime, maxTime, paymentMin ,paymentMax)
            });

            function getFilteredData(subCategories, searchValue, minTime, maxTime, paymentMin ,paymentMax) {
                let searchTimeout;
                clearTimeout(searchTimeout);
                $('.jobList').html(
                    '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'
                );
                searchTimeout = setTimeout(function() {
                    $.ajax({
                        type: "get",
                        url: "{{ route('job.filtered') }}",
                        data: {
                            "subCategories": subCategories,
                            "search": searchValue,
                            "minTime": minTime,
                            "maxTime": maxTime,
                            "paymentMin": paymentMin,
                            "paymentMax": paymentMax,
                        },
                        dataType: "json",
                        success: function(response) {
                            if (response.html) {
                                $('.jobList').html(response.html);
                            }
                            if (response.error) {
                                notify('error', response.error);
                            }
                        }
                    });
                }, 1000);
            }
        })(jQuery);
    </script>
   
@endpush
