@extends('client.layouts.app')
@section('content')
    <div class="aboutUs">
        <div class="head">
            <div class="container">
                <h3>{{ trans('home/app.about-us') }}</h3>
                <ul class="d-flex flex-wrap">
                    <li><a class="active" href="#story">{{ trans('about/about.our_story') }}</a></li>
                    <li><a href="#who">{{ trans('about/about.who_we_are') }}</a></li>
                    <li><a href="#why">{{ trans('home/home.why-us') }}</a></li>
                    <li><a href="#team">{{ trans('home/home.our-amazing-team') }}</a></li>
                </ul>
            </div>
        </div>
        <div class="overview text-center  p-40">
            <div class="container">
                <h2>{{ trans('about/about.overview') }}</h2>
                <hr>
                <br>
                <p>
                    {{ trans('about/about.overview_detail') }}
                </p>
            </div>
        </div>
        <div class="our-story" id="story">
            <div class="container">
                <h2>{{ trans('about/about.our_story') }}
                    <hr>
                </h2>
                <p>
                   {{ trans('about/about.our_story_detail') }}
                </p>
            </div>
        </div>
        <div class="our-values">
            <div class="container text-center">
                <h2>{{ trans('about/about.our_values') }}
                    <hr>
                </h2>
                <div class="row">
                    <div class="col-md-6">
                        <img src="{{ asset('public/assets/img/hero/honesty.png')}}"/> <br>
                        {{ trans('about/about.honesty') }}
                    </div>
                    <div class="col-md-6">
                        <img src="{{ asset('public/assets/img/hero/professional.png')}}"/><br>
                        {{ trans('home/home.professionalism') }}
                    </div>
                </div>
                <br><br>
                <div class="row">
                    <div class="col-md-4">
                        <img src="{{ asset('public/assets/img/hero/seat.png')}}"/><br>
                        {{ trans('about/about.accessibility') }}
                    </div>
                    <div class="col-md-4">
                        <img src="{{ asset('public/assets/img/hero/creativity.png')}}"/><br>
                        {{ trans('about/about.creativity') }}
                    </div>
                    <div class="col-md-4">
                        <img src="{{ asset('public/assets/img/hero/transparency.png')}}"/><br>
                        {{ trans('home/home.transparency') }}
                    </div>
                </div>
                <br><br>
                <div class="row">
                    <div class="col-md-6">
                        <img src="{{ asset('public/assets/img/hero/reliability.png')}}"/><br>
                        {{ trans('about/about.integrity') }}
                    </div>
                    <div class="col-md-6">
                        <img src="{{ asset('public/assets/img/hero/affordable.png')}}"/><br>
                        {{ trans('about/about.affordability') }}
                    </div>
                </div>
                <br>
            </div>
        </div>
        <div class="overview text-center  p-40" id="who">
            <div class="container">
                <h2>{{ trans('about/about.who_we_are') }}</h2>
                <hr>
                <br>
                <p>
                    {{ trans('about/about.who_we_are_detail') }}
                </p>
            </div>
        </div>
        <div class="why-us" id="why">
            <div class="container">
                <h2>{{ trans('home/home.why-us') }}
                    <hr>
                </h2>

                <div class="row">
                    <div class="col col-2 ">
                        <img class="" src="{{ asset('public/assets/img/hero/one.png')}}"/>
                    </div>
                    <div class="col col-10 description">
                       {{ trans('about/about.why_us_section_one') }}
                    </div>
                </div>
                <div class="row">
                    <div class="col col-2 ">
                        <img src="{{ asset('public/assets/img/hero/two.png')}}"/>
                    </div>
                    <div class="col col-10 description">
                        {{ trans('about/about.why_us_section_two') }}
                    </div>
                </div>
                <div class="row">
                    <div class="col col-2 ">
                        <img src="{{ asset('public/assets/img/hero/three.png')}}"/>
                    </div>
                    <div class="col col-10 description">
                        {{ trans('about/about.why_us_section_three') }}
                    </div>
                </div>
                <div class="row">
                    <div class="col col-2 ">
                        <img src="{{ asset('public/assets/img/hero/four.png')}}"/>
                    </div>
                    <div class="col col-10 description">
                       {{ trans('about/about.why_us_section_four') }}
                    </div>
                </div>
                <div class="row">
                    <div class="col col-2 ">
                        <img src="{{ asset('public/assets/img/hero/five.png')}}"/>
                    </div>
                    <div class="col col-10 description">
                        {{ trans('about/about.why_us_section_five') }}
                    </div>
                </div>
            </div>
        </div>
        <div class="our-suppliers">
            <div class="container">
                <h2>{{ trans('about/about.our_suppliers') }}
                    <hr>
                </h2>
                <br>
                <span>{{ trans('about/about.our_suppliers_subtitle') }}</span><br><br>
                <p>
                    {{ trans('about/about.our_suppliers_detail') }}
                </p>
            </div>
        </div>
        <div class="container" id="team">
            <section class="team-section text-center my-5">
                <div class="container">
                    <h2 class="h1-responsive font-weight-bold my-5">{{ trans('home/home.our-amazing-team') }}</h2>
                    <b class="grey-text w-responsive mx-auto mb-5">
					{{ trans('home/home.our-amazing-team-desc') }}
					</b><br><br>
                    <div class="row">
                        <div class="col-lg-3 col-md-6 mb-lg-0 mb-5">
                            <div class="avatar mx-auto">
                                <img src="{{ asset('public/assets/img/hero/Ahmed.jpg')}}"
                                     class="img-fluid rounded-circle z-depth-1"
                                     alt="Sample avatar" height="250" width="250">
                            </div>
                            <h5 class="font-weight-bold mt-4 mb-3">{{ trans('home/home.ahmed') }} </h5>
                            <h6 class="text-uppercase blue-text"><strong>{{ trans('home/home.financial_officer') }} </strong></h6><br>
                            <ul class="list-unstyled mb-0">
                                <a class="linkedin-team p-2 fa-lg ins-ic"
                                   href="https://www.linkedin.com/in/ahmed-karim-4183361a3" target="_blank">
                                    <i class="fab fa-linkedin blue-text"></i>
                                </a>
                            </ul>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-lg-0 mb-5">
                            <div class="avatar mx-auto">
                                <img src="{{ asset('public/assets/img/hero/fatim.png')}}"
                                     class="img-fluid rounded-circle z-depth-1"
                                     alt="Sample avatar" height="250" width="250">
                            </div>
                            <h5 class="font-weight-bold mt-4 mb-3">{{ trans('home/home.fatima') }} </h5>
                            <h6 class="text-uppercase blue-text"><strong>{{ trans('home/home.legal_expert') }} </strong></h6><br>
                            <ul class="list-unstyled mb-0">
                                <a class="linkedin-team p-2 fa-lg ins-ic"
                                   href="https://www.linkedin.com/in/fatima-samir-5523351a3" target="_blank">
                                    <i class="fab fa-linkedin blue-text"> </i>
                                </a>
                            </ul>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-md-0 mb-5">
                            <div class="avatar mx-auto">
                                <img src="{{ asset('public/assets/img/hero/Joseph.png')}}"
                                     class="img-fluid rounded-circle z-depth-1"
                                     alt="Sample avatar" height="250" width="250">
                            </div>
                            <h5 class="font-weight-bold mt-4 mb-3"> {{ trans('home/home.joseph') }} </h5>
                            <h6 class="text-uppercase blue-text"><strong>{{ trans('home/home.prosecution_expert') }}</strong></h6><br>
                            <ul class="list-unstyled mb-0">
                                <a class="linkedin-team p-2 fa-lg ins-ic"
                                   href="https://www.linkedin.com/in/joseph-sabaa-8811901a7" target="_blank">
                                    <i class="fab fa-linkedin blue-text"> </i>
                                </a>
                            </ul>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="avatar mx-auto">
                                <img src="{{ asset('public/assets/img/hero/Thuraya.png')}}"
                                     class="img-fluid rounded-circle z-depth-1"
                                     alt="Sample avatar" height="250" width="250">
                            </div>
                            <h5 class="font-weight-bold mt-4 mb-3"> {{ trans('home/home.thuraya') }} </h5>
                            <h6 class="text-uppercase blue-text"><strong>{{ trans('home/home.technology_officer') }}</strong></h6><br>
                            <ul class="list-unstyled mb-0">
                                <a class="linkedin-team p-2 fa-lg ins-ic"
                                   href="https://www.linkedin.com/in/thuraya-awad-8351981a7" target="_blank">
                                    <i class="fab fa-linkedin blue-text"> </i>
                                </a>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
