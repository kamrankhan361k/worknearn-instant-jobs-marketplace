@php
    $faqSection = getContent('faq.content', true);
    $faqSectionElements = getContent('faq.element', false, 5);
@endphp

<!-- ==================== FAQ Start ==================== -->
<section class="faq py-80">
    <div class="container">
        <div class="title">
            <h4>{{ __(@$faqSection->data_values?->title) }}</h4>
            <div class="hr1"></div>
            <div class="hr2"></div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-12 my-auto mt-4 mt-lg-0">
                <div class="accordion custom--accordion" id="accordionExample">
                    @foreach (@$faqSectionElements ?? [] as $item)
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne{{$loop->iteration}}">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse-{{$loop->iteration}}" aria-expanded="{{$loop->iteration == 1 ? 'true': 'false'}}">
                                    {{__(@$item->data_values?->question)}}
                                </button>
                            </h2>
                            <div id="collapse-{{@$loop->iteration}}" class="accordion-collapse collapse {{$loop->iteration === 1 ? 'show': ''}}" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    @php
                                        echo (__(@$item->data_values?->answer))
                                    @endphp
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-lg-6 col-12 thumb d-none d-lg-block">
                <img src="{{ getImage(getFilePath('faq') . '/' . @$faqSection->data_values?->image) }}" alt="image">
            </div>
        </div>
    </div>
</section>
<!-- ==================== FAQ End ==================== -->
