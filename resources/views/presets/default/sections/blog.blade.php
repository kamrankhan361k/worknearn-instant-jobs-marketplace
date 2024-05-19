@php
    $blogSection = getContent('blog.content', true);
    $blogElementSection = getContent('blog.element', false, 3);
@endphp

@if (!Route::is('blog'))
    <section class="blog py-80">
@endif
<div class="container">
    <div class="title">
        <h4>{{ __(@$blogSection->data_values?->title) }}</h4>
        <div class="hr1"></div>
        <div class="hr2"></div>
    </div>
    <div class="row gy-4 justify-content-center mt-3">
        @foreach (@$blogElementSection ?? [] as $item)
            <div class="col-xl-4 col-lg-4 col-md-6 col-12">
                <div class="card">
                    <div class="thumb">
                        <img src="{{ getImage(getFilePath('blog') . '/thumb_' . @$item->data_values?->blog_image) }}"
                            alt="blog-image">
                        <div class="tag">
                            <h4>{{ showDateTime($item->created_at, 'd') }}</h4>
                            <p>{{ showDateTime($item->created_at, 'M') }}</p>
                        </div>
                    </div>
                    <div class="content">
                        {{-- <h5><i class="fas fa-tag"></i> Busines, Job, Lavel </h5> --}}
                        <a href="{{ route('blog.details', [slug($item->data_values->title), $item->id]) }}">
                            <h4>{{ __(@$item->data_values?->title) }}</h4>
                        </a>
                        <p>@php echo (__(strLimit($item->data_values->description,80)));@endphp</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@if (!Route::is('blog'))
    </section>
@endif

