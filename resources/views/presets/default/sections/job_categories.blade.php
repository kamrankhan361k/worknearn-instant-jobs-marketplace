@php
    $jobCategoriesSection = getContent('job_categories.content', true);
    $categories = App\Models\Category::with('subCategories')->where('status', 1)->get();

@endphp
<!-- ==================== Categories start ==================== -->
<section class="categories py-80">
    <div class="container">
        <div class="title">
            <h4>{{ __(@$jobCategoriesSection->data_values?->title) }}</h4>
            <div class="hr1"></div>
            <div class="hr2"></div>
        </div>
        <div class="row gy-4 mt-3 mx-lg-0 mx-md-0 mx-4 mx justify-content-center">
            @forelse ($categories as $item)
                <div class="col-md-5ths col-md-4 col-12">
                    <div class="content">
                        <h6>{{ __($item->name) }}</h6>
                        <div>
                            @foreach ($item?->subCategories ?? [] as $subItem)
                                <a href="{{ route('jobs', ['sub_category' => $subItem->id]) }}">{{__(strLimit($subItem->name,20)) }}</a>
                            @endforeach
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center">
                    {{ __($emptyMessage) }}
                </div>
            @endforelse
        </div>
    </div>
</section>
<!-- ==================== Categories end ==================== -->
