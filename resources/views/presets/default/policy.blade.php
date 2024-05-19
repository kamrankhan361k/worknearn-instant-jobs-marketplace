@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <section class="policy py-120">
        <div class="shape1">
            <img src="{{ asset('assets/images/frontend/shape/shape-2.png') }}" alt="image">
        </div>
        <div class="container">
            <div class="terms">
                <div class="row ">
                    <div class="col--12">
                        <div class="wyg">
                            @php
                                echo $policy->data_values->details;
                            @endphp
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
