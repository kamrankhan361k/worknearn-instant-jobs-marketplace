@php
    $marketplaceSection = getContent('marketplace.content', true);
@endphp

<!-- ==================== action Start ==================== -->
<section class="action py-80">
    <div class="shape">
        <img src="{{ getImage(getFilePath('marketplace') . '/' . @$marketplaceSection->data_values?->background_image) }}" alt="image">
    </div>
    <div class="shape2">
        <img src="{{ getImage(getFilePath('marketplace') . '/' . @$marketplaceSection->data_values?->shape_image_one) }}" alt="image_one">
    </div>
    <div class="shape3">
        <img src="{{ getImage(getFilePath('marketplace') . '/' . @$marketplaceSection->data_values?->shape_image_two) }}" alt="image_two">
    </div>
    <div class="container">
        <div class="row gy-4 justify-content-center">
            <div class="col-lg-6 col-12">
                <div class="title">
                    <h4>{{__(@$marketplaceSection->data_values?->title)}}</h4>
                    <div class="decs">
                        @php
                            echo (__(@$marketplaceSection->data_values?->title));
                        @endphp
                    </div>
                </div>
                <div class="mt-5 text-center">
                    <a href="{{route('jobs')}}" class="btn--base mb-4 mb-lg-0 mb-md-0">{{__(@$marketplaceSection->data_values?->button_one)}}</a>
                    <a href="{{route('user.job.create')}}" class="btn--base">{{__(@$marketplaceSection->data_values?->button_two)}}</a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ==================== action End ==================== -->