@php
    $bannerSection = getContent('banner.content', true);
    $categories = App\Models\Category::where('status', 1)->get();
@endphp

<!--========================== Banner Section Start ==========================-->
<section class="banner-section">
    <div class="shape">
        <img src="{{ getImage(getFilePath('banner') . '/' . @$bannerSection->data_values?->shape_image_one) }}"
            alt="image">
    </div>
    <div class="shape2 d-lg-block d-md-block d-none">
        <img src="{{ getImage(getFilePath('banner') . '/' . @$bannerSection->data_values?->shape_image_two) }}"
            alt="image">
    </div>
    <div class="shape3 d-lg-block d-md-block d-none">
        <img src="{{ getImage(getFilePath('banner') . '/' . @$bannerSection->data_values?->shape_image_three) }}"
            alt="image">
    </div>
    <div class="banner-thumb bg-img"
        data-background="{{ getImage(getFilePath('banner') . '/' . @$bannerSection->data_values?->background_image) }}">
        <div class="container">
            <div class="row gy-4">
                <div class="col-xl-6 col-lg-7 col-12 my-auto">
                    <div class="content">
                        <h5>{{ __(@$bannerSection->data_values?->heading) }}</h5>
                        <h1>{{ __(@$bannerSection->data_values?->subheading) }}</h1>
                        <p>{{ __(@$bannerSection->data_values?->short_description) }}</p>
                    </div>
                    <div class="search-box">
                        <form action="{{ route('jobs') }}" method="GET">
                            <div class="row">
                                <div class="col-lg-5 my-auto">
                                    <div class="search-input">
                                        <i class="fas fa-search"></i>
                                        <input type="text" class="form--control" placeholder="@lang('Search Your Job')"
                                            name="search">
                                    </div>
                                </div>
                                <div class="col-lg-4 my-auto">
                                    <select class="form-select my-lg-0 my-3" name="categories">
                                        <option value="0">@lang('Categories')</option>
                                        @foreach ($categories ?? [] as $item)
                                            <option value="{{$item->id}}">{{ __(@$item->name) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-3 my-auto d-flex justify-content-end">
                                    <button class="btn--base"
                                        type="submit">{{ __(@$bannerSection->data_values?->button_name) }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-5 col-12 thumb">
                    <img src="{{ getImage(getFilePath('banner') . '/' . @$bannerSection->data_values?->image) }}"
                        class="img-fluid" alt="image">
                    <div class="info">
                        <i class="fas fa-briefcase"></i>
                        <h5>{{ __(@$bannerSection->data_values?->icon_text) }}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--========================== Banner Section End ==========================-->

