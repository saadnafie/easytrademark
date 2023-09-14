@extends('client.layouts.app')
@section('content')
    @if (Session::has('success'))
        <div class="alert alert-success text-center" style="margin-bottom: 0px" id="alert">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
            <p>{{ Session::get('success') }}</p>
        </div>
    @endif
    <script type="text/javascript">
        setTimeout(function () {
            $('#alert').alert('close');
        }, 2000);
    </script>
    <!-- header Area Start-->
    <div class="slider-area">
        <div class="slider-active">
            <div class="single-slider slider-height d-flex align-items-center">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                            <div class="hero__caption" style="">
                                <img class="" src="{{ asset('public/assets/img/hero/circle.png')}}"/>
                                <h2 class="centered">
								@if(app()->getLocale() == "ar")
								<span>trademarks</span> <span>easy</span>  
								@else
								<span>easy</span> <span>trademarks</span> 
								@endif
								<br><i>{{ trans('home/home.your-trademark-portal') }}<br> {{ trans('home/home.in-the-middle-east') }}</i>  </h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="searchbox-home text-center">
	<div class="container">
			<form class="form-inline" action="{{ route('home-search') }}" method="GET">
					<div class="d-md-flex">
					<label for="email">{{ trans('home/home.would-like') }}:&nbsp;&nbsp;</label>
						<select class="form-control" name="service"  id="servicesId" onchange="getLowestPackageFees()" 
								style="margin-right:30px;border: unset;background: transparent;color:blue;" required>
							 <option value="0" selected="true" disabled>{{ trans('home/app.services') }}</option>
								@foreach ($allActiveServices as $service)
									<option value="{{ $service->id }}">{{ $service->service_name }}</option>
								@endforeach
						</select>
					</div>
					<div class="d-md-flex">
					<label for="pwd">{{ trans('home/home.my-trademark') }}:&nbsp;&nbsp;</label>
						<select class="form-control" name="country" id="countriesId" onchange="getLowestPackageFees()"
                                style="margin-right:30px;border: unset;background: transparent;color:blue;" required>
								<option value="0" selected="true" disabled>{{ trans('servicelable/servicelable.country') }}</option>
                            @foreach ($allCountries as $country)
                                <option value="{{ $country->id }}">{{ $country->country_name }}</option>
                            @endforeach
                        </select>
					</div>	

						<div class="slider-btns startNowBtn"  id="startBtn" ></div>
			</form>
	</div>
	</div>
    <!-- header Area End-->

    <!--?  Our Services Start-->
    <section class="about-low-area">
        <div class="container">
            <br><br>
            <h2 class="text-center">{{ trans('home/home.our-services') }}</h2>
            <br><br>
            <div class="row">
                @foreach ($allActiveServices as $service)
                    <div class="col-lg-4 col-md-12">
                        <a href="{{ url('/service-search') . '/' . $service->id}}">
                            <div class=" icon-boxes">
                                <div class=" d-flex align-items-stretch mb-5 mb-lg-0" data-aos="zoom-in"
                                     data-aos-delay="200">
                                    <div class="icon-box text-center">
                                        <div class="icon text-center">{!! $service->service_icon !!} <br> <br></div>
                                        <h4 class="title text-center">{{$service->service_name}}
                                            <hr>
                                        </h4>
                                        <p class="description">{{$service->service_description}}</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- Our Services End-->

    <!-- Need help Area Start -->
    <section class="team-area  section-bg">
        <div class="container">
            <div class="container">
                <br><br>
                <h2 class="text-center">{{ trans('home/home.need-help-to-start') }}</h2>
                <p class="text-center"> {{ trans('home/home.follow-steps') }}</p>
                <div class="timeline">
                    <div
                        class="row no-gutters justify-content-end justify-content-md-around align-items-start  timeline-nodes">
                        <div class="col-10 col-md-5 order-3 order-md-1 timeline-content">
                            <h3 class=" text-light">{{ trans('home/home.identify-the-type-of-ip') }} </h3>
                            <p>{{ trans('home/home.survey-intellectual-property') }}
                                <a class="colored-identity"
                                   href="{{ route('survey.create', ['is_master' => true, 'survey_id' => 1]) }}"><u>{{ trans('home/home.start-now') }}</u></a></p>
                        </div>
                        <div class="col-2 col-sm-1 px-md-3 order-2 timeline-image text-md-center">
                            <a href="{{ route('survey.create', ['is_master' => true, 'survey_id' => 1]) }}"><p
                                    class="text-center">1</p></a>
                        </div>
                        <div class="col-10 col-md-5 order-1 order-md-3 py-3 timeline-date">
                        </div>
                    </div>
                    <div
                        class="row no-gutters justify-content-end justify-content-md-around align-items-start  timeline-nodes">
                        <div class="col-10 col-md-5 order-3 order-md-1 timeline-content">
                            <h3 class=" text-light ">{{ trans('home/home.strength') }} </h3>
                            <p class="">{{ trans('home/home.survey-know-how-strong-your-ip') }}
                                <a class="colored-identity"
                                   href="{{ route('survey.create', ['is_master' => true, 'survey_id' => 2]) }}"><u>{{ trans('home/home.start-now') }}</u></a></p>
                        </div>
                        <div class="col-2 col-sm-1 px-md-3 order-2 timeline-image text-md-center">
                            <a href="{{ route('survey.create', ['is_master' => true, 'survey_id' => 2]) }}"><p
                                    class="text-center">2</p></a>
                        </div>
                        <div class="col-10 col-md-5 order-1 order-md-3 py-3 timeline-date">
                        </div>
                    </div>
                    <div
                        class="row no-gutters justify-content-end justify-content-md-around align-items-start  timeline-nodes">
                        <div class="col-10 col-md-5 order-3 order-md-1 timeline-content">
                            <h3 class=" text-light">{{ trans('home/home.follow-the-guided-steps') }} </h3>
                            <p>{{ trans('home/home.survey-answer-simple-questions') }}
                                <a class="colored-identity" href="{{url('/service')}}"><u>{{ trans('home/home.start-now') }}</u></a></p>
                        </div>
                        <div class="col-2 col-sm-1 px-md-3 order-2 timeline-image text-md-center">
                            <p class="text-center">3</p>
                        </div>
                        <div class="col-10 col-md-5 order-1 order-md-3 py-3 timeline-date">
                        </div>
                    </div>
                    <div
                        class="row no-gutters justify-content-end justify-content-md-around align-items-start  timeline-nodes">
                        <div class="col-10 col-md-5 order-3 order-md-1 timeline-content">
                            <h3 class=" text-light ">{{ trans('home/home.ensure-protection') }} </h3>
                            <p class="">{{ trans('home/home.survey-complete-the-process') }}</p>
                        </div>
                        <div class="col-2 col-sm-1 px-md-3 order-2 timeline-image text-md-center">
                            <p class="text-center"> 4</p>
                        </div>
                        <div class="col-10 col-md-5 order-1 order-md-3 py-3 timeline-date">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Need help Area End -->

    <!-- Why Us start -->
    <section class="accordion fix ">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-5 col-lg-6 col-md-6">
                    <div class="section-tittle text-center mb-80">
                        <h2>{{ trans('home/home.why-us') }}</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-12">
                    <div class=" icon-boxes">
                        <div class=" d-flex align-items-stretch mb-5 mb-lg-0" data-aos="zoom-in" data-aos-delay="200">
                            <div class="icon-box text-center">
                                <h4 class="title text-center">{{ trans('home/home.transparency') }}
                                    <hr>
                                </h4>
                                <p class="description">{{ trans('home/home.transparency-desc') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12">
                    <div class=" icon-boxes">
                        <div class=" d-flex align-items-stretch mb-5 mb-lg-0" data-aos="zoom-in" data-aos-delay="200">
                            <div class="icon-box text-center">
                                <h4 class="title text-center">{{ trans('home/home.professionalism') }}
                                    <hr>
                                </h4>
                                <p class="description"> {{ trans('home/home.professionalism-desc') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12">
                    <div class=" icon-boxes">
                        <div class=" d-flex align-items-stretch mb-5 mb-lg-0" data-aos="zoom-in" data-aos-delay="200">
                            <div class="icon-box text-center">
                                <h4 class="title text-center">{{ trans('home/home.value-for-money') }}
                                    <hr>
                                </h4>
                                <p class="description">{{ trans('home/home.value-for-money-desc') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Why Us start end -->

    <!-- Our amazing team start -->
    <section class="team-section text-center my-5">
        <div class="container">
            <h2 class="h1-responsive font-weight-bold my-5">{{ trans('home/home.our-amazing-team') }}</h2>
            <b class="grey-text w-responsive mx-auto mb-5">{{ trans('home/home.our-amazing-team-desc') }}</b><br><br>
            <div class="row">
                <div class="col-lg-3 col-md-6 mb-lg-0 mb-5">
                    <div class="avatar mx-auto">
                        <img src="{{ asset('public/assets/img/hero/Ahmed.jpg')}}" class="rounded-circle img-fluid z-depth-1"
                             alt="Sample avatar" height="250" width="250">
                    </div>
                    <h5 class="font-weight-bold mt-4 mb-3">{{ trans('home/home.ahmed') }} </h5>
                    <h6 class="text-uppercase blue-text"><strong>{{ trans('home/home.financial_officer') }} </strong></h6><br>

                    <ul class="list-unstyled mb-0">
                        <a class="linkedin-team p-2 fa-lg ins-ic"
                           href="https://www.linkedin.com/in/ahmed-karim-4183361a3"
                           target="_blank">
                            <i class="fab fa-linkedin blue-text"></i>
                        </a>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6 mb-lg-0 mb-5">
                    <div class="avatar mx-auto">
                        <img src="{{ asset('public/assets/img/hero/fatim.png')}}" class="rounded-circle img-fluid z-depth-1"
                             alt="Sample avatar" height="250" width="250">
                    </div>
                    <h5 class="font-weight-bold mt-4 mb-3">{{ trans('home/home.fatima') }} </h5>
                    <h6 class="text-uppercase blue-text"><strong>{{ trans('home/home.legal_expert') }} </strong></h6><br>

                    <ul class="list-unstyled mb-0">
                        <a class="linkedin-team p-2 fa-lg ins-ic"
                           href="https://www.linkedin.com/in/fatima-samir-5523351a3"
                           target="_blank">
                            <i class="fab fa-linkedin blue-text"> </i>
                        </a>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6 mb-md-0 mb-5">
                    <div class="avatar mx-auto">
                        <img src="{{ asset('public/assets/img/hero/Joseph.png')}}" class="rounded-circle img-fluid z-depth-1"
                             alt="Sample avatar" height="250" width="250">
                    </div>
                    <h5 class="font-weight-bold mt-4 mb-3"> {{ trans('home/home.joseph') }} </h5>
                    <h6 class="text-uppercase blue-text"><strong>{{ trans('home/home.prosecution_expert') }}</strong></h6><br>

                    <ul class="list-unstyled mb-0">
                        <a class="linkedin-team p-2 fa-lg ins-ic"
                           href="https://www.linkedin.com/in/joseph-sabaa-8811901a7"
                           target="_blank">
                            <i class="fab fa-linkedin blue-text"> </i>
                        </a>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="avatar mx-auto">
                        <img src="{{ asset('public/assets/img/hero/Thuraya.png')}}" class="rounded-circle img-fluid z-depth-1"
                             alt="Sample avatar" height="250" width="250">
                    </div>
                    <h5 class="font-weight-bold mt-4 mb-3"> {{ trans('home/home.thuraya') }} </h5>
                    <h6 class="text-uppercase blue-text"><strong>{{ trans('home/home.technology_officer') }}</strong></h6><br>
                    <ul class="list-unstyled mb-0">
                        <a class="linkedin-team p-2 fa-lg ins-ic"
                           href="https://www.linkedin.com/in/thuraya-awad-8351981a7"
                           target="_blank">
                            <i class="fab fa-linkedin blue-text"> </i>
                        </a>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!-- Our amazing team end -->

    <!-- What Our Clients say About Us start -->
    <section class="about-low-area">
        <div class="container">
            <br><br>
            <h2 class="text-center">{{ trans('home/home.what-our-clients-say-about-us') }}</h2>
            <br><br>
            <div class="row">
                <div class="container">
                    <div id="demo" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <div class="carousel-caption">
                                    <img src="{{ asset('public/assets/img/hero/mayayousef.jpg')}}">
                                    <p>“The process is straight forward easy to use and I got charged exactly what the
                                        website says.” </p>
                                    <div id="image-caption">Maya Youssef</div>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <div class="carousel-caption">
                                    <img src="{{ asset('public/assets/img/hero/Leechen.jpg')}}" class="img-fluid">
                                    <p>“Customer service is very helpful and available they got back to me with valid
                                        answers”</p>
                                    <div id="image-caption">Lee Chen</div>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <div class="carousel-caption">
                                    <img src="{{ asset('public/assets/img/hero/MaryHaddad.jpg')}}" class="img-fluid">
                                    <p>“The process is very complicated but they make it seem like a piece of cake”</p>
                                    <div id="image-caption">Mary Haddad</div>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <div class="carousel-caption">
                                    <img src="{{ asset('public/assets/img/hero/DavidMarch.jpg')}}" class="img-fluid">
                                    <p>“The easy trademarks team have gone
                                        above and beyond to direct us into the right direction. They hit their
                                        deadlines,
                                        and
                                        charge very reasonable rates.”</p>
                                    <div id="image-caption">David Marsh</div>
                                </div>
                            </div>
                        </div>
                        <a class="carousel-control-prev" href="#demo" data-slide="prev"> <i
                                class='fas fa-arrow-left'></i>
                        </a>
                        <a class="carousel-control-next" href="#demo" data-slide="next"> <i
                                class='fas fa-arrow-right'></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- What Our Clients say About Us start -->
    <br><br><br>

    <!-- Need more information start -->
    <section class="about-low-area2 pt-100 ">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-5 col-lg-6 col-md-6">
                    <div class="section-tittle text-center mb-80">
                        <h2>{{ trans('home/home.need-more-information') }}</h2>
                        <h5>{{ trans('home/home.contact-us-desc') }}</h5><br><br>
                        <div class="hero__caption"></div>
                        <div class="slider-btns ">
                            <a href="{{ url('contact-us') }}" class="btn hero-btn text-center">{{ trans('home/app.contact-us') }} </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Need more information end -->

<script>
    window.onload = function() {
        getLowestPackageFees();
    };
    let serviceid = document.getElementById("servicesId").value;
    let countryid = document.getElementById("countriesId").value;
    function getLowestPackageFees() {
        let serviceid = document.getElementById("servicesId").value;
        let countryid = document.getElementById("countriesId").value;
		if(serviceid !=0 && countryid!=0){
        $.ajax({
            url: '{{ \LaravelLocalization::localizeURL('getLowestPackageFees') }}' + '/' + serviceid + '/' + countryid,
            dataType: 'json',
            type: 'GET',
            cache: false,
            async: true,
            success: function (data) {
                $('#startBtn').html('<input type="submit" class="btn hero-btn text-center" style="padding: 20px;font-size:18px;" value="{{ trans("home/home.start-now") }} ( {{ trans("home/home.from") }} ' + data  + '$ )">');
            },
            error: function (jqXhr, textStatus, errorThrown) {
                console.log(errorThrown);
                alert(errorThrown);
            }
        })
		}
    }
</script>
@endsection
