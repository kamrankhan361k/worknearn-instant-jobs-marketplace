@extends($activeTemplate.'layouts.frontend')
@section('content')
        <!--=======-** Cookies start **-=======-->
        <section class="policy pt-150 py-120">
            <div class="shape1">
                <img src="{{ asset('assets/images/frontend/shape/shape-2.png') }}" alt="image">
            </div>
            <div class="container">
               <div class="terms">
                <div class="row ">
                    <div class="col--12">
                        <div class="privacy-wrapper">
                            <div class="desc">
                                <div class="wyg">
                                    @php
                                        echo $cookie->data_values->description;
                                    @endphp
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
               </div>
            </div>
        </section>
        <!--=======-** Cookies End **-=======-->
@endsection

