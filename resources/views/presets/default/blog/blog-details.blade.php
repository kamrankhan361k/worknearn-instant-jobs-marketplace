@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <!-- ==================== Blog Details Start ==================== -->
    <section class="blog-detials pb-100 pt-150">
        <div class="container">
            <div class="row gy-5 justify-content-center">
                <div class="col-lg-8">
                    <div class="blog-details">
                        <div class="thumb">
                            <img src="{{ getImage(getFilePath('blog') . '/' . @$blog->data_values?->blog_image) }}"
                                alt="image">
                        </div>
                        <div class="content">
                            <h3>{{ __(@$blog->data_values?->title) }}</h3>
                            @php echo (__(strWords(@$blog->data_values?->description,150)) )@endphp
                            <blockquote>
                                <div class="blog-details__desc">@php echo (__(@$blog->data_values?->blockquote))@endphp</div>
                            </blockquote>
                            @php echo ('<p>' . __(strSub(@$blog->data_values?->description,150)))@endphp

                            <div class="mt-4 d-flex align-items-center">
                                <h5>@lang('Share This')</h5>
                                <ul class="social">
                                    <li class="#"><a
                                            href="https://www.facebook.com/share.php?u={{ Request::url() }}&title={{ slug(@$blog->data_values?->title) }}"><i
                                                class="fab fa-facebook-f"></i></a> </li>
                                    <li class="#"><a
                                            href="https://twitter.com/intent/tweet?status={{ slug(@$blog->data_values?->title) }}+{{ Request::url() }}">
                                            <i class="fab fa-twitter"></i></a></li>
                                    <li class="#"><a
                                            href="https://www.linkedin.com/shareArticle?mini=true&url={{ Request::url() }}&title={{ slug(@$blog->data_values?->title) }}&source=behands"
                                            class="social-list__link"> <i class="fab fa-linkedin-in"></i></a></li>
                                    <li class="#"><a
                                            href="https://www.pinterest.com/pin/create/button/?url={{ Request::url() }}&description={{ slug(@$blog->data_values->title) }}">
                                            <i class="fab fa-pinterest"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <!-- ============================= Blog Details Sidebar Start ======================== -->
                    <div class="blog-sidebar-wrapper">
                        <div class="blog-sidebar">
                            <h5 class="blog-sidebar__title">@lang('Search')</h5>

                            <div class="search-box w-100">
                                <input type="text" class="form--control searchTerm" name="search"
                                    value="{{ request()->search }}" placeholder="Search...">
                                <button type="submit" class="search-box__button">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                            <div class="search-result-box">
                                <div class="search-wrap2" id="search-results"></div>
                            </div>

                        </div>
                     
                        <div class="blog-sidebar">
                            <h5 class="blog-sidebar__title">@lang('Recent Blogs')</h5>
                            <span class="hr-line"></span>
                            <span class="border"></span>
                            @foreach ($blogElementSection as $item)
                                <div class="latest-blog">
                                    <div class="latest-blog__thumb">
                                        <a
                                            href="{{ route('blog.details', [slug($item->data_values->title), $item->id]) }}">
                                            <img src="{{ getImage(getFilePath('blog') . '/thumb_' . @$item->data_values?->blog_image) }}"
                                                alt="blog-image">
                                        </a>

                                    </div>
                                    <div class="latest-blog__content">
                                        <h6 class="latest-blog__title text-hover">
                                            <a
                                                href="{{ route('blog.details', [slug($item->data_values->title), $item->id]) }}">
                                                {{ __(@$item->data_values?->title) }}
                                            </a>
                                        </h6>
                                        <span
                                            class="latest-blog__date">{{ showDateTime($item->created_at, 'M d Y') }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <!-- ============================= Blog Details Sidebar End ======================== -->
                </div>
            </div>
        </div>
    </section>
    <!-- ==================== Blog Details End ==================== -->
@endsection


@push('script')
    <script>
        $(document).ready(function() {
            "use strict";
            let searchTimeout;
            $('.searchTerm').on('keyup', function() {
                clearTimeout(searchTimeout);
                $('.search-result-box').addClass('show');
                var searchTerm = $(this).val();
                if (searchTerm.length >= 1) {
                    $('#search-results').html(
                        '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'
                    );
                    searchTimeout = setTimeout(function() {
                        $.ajax({
                            url: "{{ route('blog.search') }}",
                            type: "GET",
                            data: {
                                searchTerm: searchTerm
                            },
                            success: function(response) {

                                var results = '';
                                var websiteUrl = "{{ url('/') }}/";
                                const slugify = str => str
                                    .toLowerCase()
                                    .trim()
                                    .replace(/[^\w\s-]/g, '')
                                    .replace(/[\s_-]+/g, '-')
                                    .replace(/^-+|-+$/g, '');
                                if (response.blogs.length > 0) {
                                    $.each(response.blogs, function(index, value) {
                                        let slug = slugify(value.data_values
                                            .title);
                                        var date = new Date(value.created_at);
                                        var monthNames = ["Jan", "Feb", "Mar",
                                            "Apr", "May", "Jun", "Jul",
                                            "Aug", "Sep", "Oct", "Nov",
                                            "Dec"
                                        ];
                                        var month = monthNames[date.getMonth()];
                                        var day = date.getDate();
                                        var year = date.getFullYear();
                                        var formattedDate = month + ' ' + day +
                                            ', ' + year;
                                        results += '<div class="new">';
                                        results += '<a href="' + websiteUrl +
                                            'blog/' + slug + '/' + value.id +
                                            '">';
                                        results += '<p class="title">' + value
                                            .data_values.title + '</p>';
                                        results +=
                                            '<ul class="text-list inline">';
                                        results +=
                                            '<li class="text-list__item text-dark"><span class="text-list__item-icon"><i class="fas fa-calendar-alt"></i> </span>' +
                                            formattedDate + '</li>';
                                        results += '</ul>';
                                        results += '</a>';
                                        results += '</div>';
                                    });
                                } else {
                                    results += '<div class="new">';
                                    results += '<p>' + "@lang('No blog found')" + '</p>';
                                    results += '</div>';
                                }
                                $('#search-results').html(results);
                            }
                        });
                    }, 2000);
                } else {
                    $('.search-result-box').removeClass('show');
                    $('#search-results').empty();
                }
            });
        });
    </script>
@endpush
