<!-- 404 section -->
<!-- header -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title> {{ $general->siteName(__('404')) }}</title>
    <!-- Bootstrap CSS -->
    <link href="{{ asset('assets/common/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Main css -->
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/main.css') }}">

    <style>
        .erro-body {
            height: 100vh;
        }
    </style>
</head>

<body>

    <!--==================== Preloader End ====================-->
    <!--========================== Sidebar mobile menu wrap End ==========================-->
    <section class="error bg-img" data-background="{{asset('assets/images/frontend/error/errorbg.png')}}">
        <div class="container">
            <div class="row ">
                <div class="col-12">
                    <h3>@lang('404')</h3>
                    <h4>@lang("So sorry ! We cannot find the page")</h4>
                    <a href="{{route('home')}}" class="btn--base">@lang('Back to home')</a>
                </div>
            </div>
        </div>
    </section>
    <!--  404 section /> -->


    <!-- footer -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="{{ asset('assets/common/js/jquery-3.7.1.min.js') }}"></script>
    <!-- Slick js -->
    <script src="{{ asset($activeTemplateTrue . 'js/slick.min.js') }}"></script>
    <!-- wow js -->
    <script src="{{ asset($activeTemplateTrue . 'js/wow.min.js') }}"></script>
    <!-- main js -->
    <script src="{{ asset($activeTemplateTrue . 'js/main.js') }}"></script>

</body>

</html>
