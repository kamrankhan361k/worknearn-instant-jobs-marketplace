@php
    $aboutSection = getContent('about.content', true);

@endphp

<!--========================== About Start ==========================-->
<section class="about pt-150 pb-80">
    <div class="shape1 d-lg-block d-none">
        <img src="{{asset('assets/images/frontend/shape/about_shape_1.png')}}" alt="image">
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-12 thumb">
                <img src="{{ getImage(getFilePath('about') . '/' . @$aboutSection->data_values?->about_image) }}"
                    alt="image">
            </div>
            <div class="col-lg-6 col-12 my-auto">
                <div class="title">
                    <h6>{{ __(@$aboutSection->data_values?->title) }}</h6>
                    <h4>{{ __(@$aboutSection->data_values?->heading) }}</h4>
                    <div>
                        @php
                            echo (__(@$aboutSection->data_values?->description));
                        @endphp
                    </div>
                </div>
                <div class="mt-4">
                    <a href="{{route('jobs')}}" class="btn--base">{{ __(@$aboutSection->data_values?->button_name) }}</a>
                </div>
            </div>
        </div>
    </div>
</section>
<!--========================== About End ==========================-->
