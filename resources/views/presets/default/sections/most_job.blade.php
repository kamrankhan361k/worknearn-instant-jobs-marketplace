@php
    $mostJobSection = getContent('most_job.content', true);
    $popularUser = App\Models\Job::with('ownerUser', 'ownerAdmin')->select('owner_id', 'owner_type', DB::raw('COUNT(*) as finished_job'))->groupBy('owner_id', 'owner_type')->where('job_status', '=', 2)->orderByDesc('finished_job')->limit(7)->get();
@endphp

<!-- ==================== Freelancers Start ==================== -->
<section class="freelancer py-80">
    <div class="shape">
        <img src="{{ getImage(getFilePath('mostJob') . '/' . @$mostJobSection->data_values?->shape_image_one) }}"
            alt="image">
    </div>
    <div class="shape2">
        <img src="{{ getImage(getFilePath('mostJob') . '/' . @$mostJobSection->data_values?->shape_image_two) }}"
            alt="image">
    </div>
    <div class="container">
        <div class="title">
            <h4>{{ __(@$mostJobSection->data_values?->title) }}</h4>
            <div class="hr1"></div>
            <div class="hr2"></div>
        </div>
        <div class="mt-5">
            <div class="freelancer-slider">
                @foreach ($popularUser as $item)
                    @if ($item->owner_type == 1)
                        <div class="card">
                            <div class="profile">
                                <div class="thumb">
                                    <img src="{{ getImage(getFilePath('adminProfile') . '/' . @$item?->ownerAdmin->image) }}"
                                        alt="image">
                                </div>
                                <h5>{{ @$item?->ownerAdmin->name }}</h5>
                                <a href="mailto:{{ @$item?->ownerAdmin->email }}">{{ @$item?->ownerAdmin->email }}</a>
                            </div>
                            <div class="info">
                                <p>@lang('Name')</p>
                                <h6>{{ @$item?->ownerAdmin->name }}</h6>
                            </div>
                            <div class="info">
                                <p>@lang('Job Completed')</p>
                                <h6>{{ @$item->finished_job }}</h6>
                            </div>
                        </div>
                    @else
                        <div class="card">
                            <div class="profile">
                                <div class="thumb">
                                    <img src="{{ getImage(getFilePath('userProfile') . '/' . @$item?->ownerUser->image) }}"
                                        alt="image">
                                </div>
                                <h5>{{ @$item?->ownerUser->fullname }}</h5>
                                <a href="mailto:{{ @$item?->ownerUser->email }}">{{ @$item?->ownerUser->email }}</a>
          
                            </div>
                            <div class="info">
                                <p>@lang('Name')</p>
                                <h6>{{ @$item?->ownerUser->fullname }}</h6>
                            </div>
                            <div class="info">
                                <p>@lang('Job Completed')</p>
                                <h6>{{ @$item->finished_job }}</h6>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</section>
<!-- ==================== Freelancers End ==================== -->
