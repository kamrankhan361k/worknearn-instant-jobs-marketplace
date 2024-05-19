@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <!-- ==================== Jobs Start ==================== -->
    <section class="explore-job pt-150 pb-80">
        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-4 col-12">
                    <div class="left-side">
                        <div>
                            <div class="search mb-3">
                                <input type="text" class="form--control" placeholder="@lang('Search Keyword')" id="searchValue"
                                    name="searchValue">
                                <i class="fas fa-search"></i>
                            </div>
                            <div class="mb-3">
                                <p class="mb-1">@lang('Avg Time')</p>
                                <div class="row gy-4">
                                    <div class="col-lg-6 col-12">
                                        <input type="number" class="form--control" id="minTime" name="minTime"
                                            placeholder="Min Time">
                                    </div>
                                    <div class="col-lg-6 col-12">
                                        <input type="number" class="form--control" id="maxTime" name="maxTime"
                                            placeholder="Max Time">
                                    </div>
                                </div>
                            </div>

                            <div>
                                <p class="mb-1">@lang('Payment')</p>
                                <div class="row gy-4">
                                    <div class="col-lg-6 col-12">
                                        <input type="number" class="form--control" id="paymentMin" name="paymentMin"
                                            placeholder="Min Price">
                                    </div>
                                    <div class="col-lg-6 col-12">
                                        <input type="number" class="form--control" id="paymentMax" name="paymentMax"
                                            placeholder="Max Price">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="list">
                            <div class="title">
                                <h5>@lang("Job Category's")</h5>
                                <div class="hr1"></div>
                            </div>
                            @php
                                $itemCount = 0;
                            @endphp
                            @forelse($categories ?? [] as $item)
                                @php
                                    $itemCount += 1;
                                @endphp
                                <div class="mb-3 {{ $itemCount > 4 ? 'd-none' : '' }} categoryShow">
                                    <div class="category-list row ps-3">
                                        <h6 onclick="moreBtn(this)">
                                            {{ __(@$item->name) }}<span>({{ @$item->subCategories->count() }})</span></h6>
                                        @if (!empty($item->subCategories) && (is_array($item->subCategories) || is_object($item->subCategories)))
                                            @forelse (@$item?->subCategories ?? [] as $subItem)
                                                <div class="check-item col-12 mb-3 {{ $itemCount > 1 ? 'd-none' : '' }}">
                                                    <div class="form--check categories-search">
                                                        <input class="form-check-input filter-by-category"
                                                            name="sub_categories_{{ @$subItem->id }}" type="checkbox"
                                                            value="{{ @$subItem->id }}"
                                                            id="sub_categories_{{ @$subItem->id }}">
                                                        <label for="sub_categories_{{ @$subItem->id }}"
                                                            class="form-check-label">{{ __(@$subItem->name) }}
                                                        </label>
                                                    </div>
                                                </div>
                                            @empty
                                            @endforelse
                                        @endif
                                    </div>
                                </div>

                            @empty
                                <div class="text-center">
                                    {{ __($emptyMessage) }}
                                </div>
                            @endforelse
                            <div class="px-3">
                                <button class="btn btn--base btn--sm"
                                    onclick="categoryMore(this)">@lang('More')</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-12 jobList">
                    @include($activeTemplate . 'components.jobs_list')
                </div>
            </div>
        </div>
    </section>
    <!-- ==================== Jobs End ==================== -->
@endsection


@push('script')
    <script>
        function moreBtn(object) {
            var allCheckList = $(object).siblings('.check-item');
            if (allCheckList.hasClass('d-none')) {
                allCheckList.removeClass('d-none').hide().slideDown();
            } else {
                allCheckList.fadeOut(function() {
                    $(this).addClass('d-none');
                });
            }
        }
    </script>
    <script>
        function categoryMore(object) {
            $('.categoryShow').removeClass('d-none');
            $(object).addClass('d-none');
        }
    </script>
@endpush
