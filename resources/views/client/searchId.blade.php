@extends('client.layouts.app')
@section('content')
    @if(isset($searchService) || isset($selectedService))
    @endif
    <!-- search Area Start-->
    <div class="search-area">
        <h3>Choose</h3><br>
        <div class="search-box text-center" dir="ltr">
            <div class="d-md-flex justify-content-center">
                    <div class="form-search">
                        <label>I would like to  </label>
                        <select class="seach-select" id="services" onchange="showServiceData()">
                            <option>Services</option>
                            @foreach ($allActiveServices as $service)
                                <option
                                    value="{{ $service->id }}" @if(isset($searchService)) {{ $searchService == $service->id? 'selected' : '' }} @endif  @if(isset($selectedService->id)) {{ $selectedService->id == $service->id? 'selected' : '' }} @endif >{{ $service->service_name }} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-search">
                        <label>in</label>
                        <select class="seach-select" id="countries" onchange="showServiceData()">
                            <option>Country</option>
                            @foreach ($allCountries as $country)
                                <option
                                    value="{{ $country->id }}" @if(isset($searchCountry)) {{ $searchCountry == $country->id? 'selected' : '' }} @endif >{{ $country->country_name }}</option>
                            @endforeach
                        </select>
                    </div>
            </div>
        </div>
    </div>
    <!-- search Area End-->

    <!-- Packages available Start-->
    <div id="search-section-display" style="display: none">
        <section class="search-packges">
            <div class="container">
                <br><br>
                <h2 class="text-center">Packages available</h2>
                <div class="row package ">

                </div>
            </div>
        </section>
        <!-- Packages available end-->

        <!-- Explanation Area Start -->
        <section class="accordion fix ">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-5 col-lg-6 col-md-6">
                        <div class="section-tittle text-center mb-80">
                            <h2>Explanation</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-md-12">
                        <div class=" icon-boxes">
                            <div class=" d-flex align-items-stretch mb-5 mb-lg-0" data-aos="zoom-in"
                                 data-aos-delay="200">
                                <div class=" icon-box text-center">
                                    <h4 class="title text-center">What
                                        <hr>
                                    </h4>
                                    <div class="what"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12">
                        <div class="icon-boxes">
                            <div class=" d-flex align-items-stretch mb-5 mb-lg-0" data-aos="zoom-in"
                                 data-aos-delay="200">
                                <div class=" icon-box text-center">
                                    <h4 class="title text-center">Why
                                        <hr>
                                    </h4>
                                    <div class="why"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12">
                        <div class=" icon-boxes">
                            <div class=" d-flex align-items-stretch mb-5 mb-lg-0" data-aos="zoom-in"
                                 data-aos-delay="200">
                                <div class=" icon-box text-center">
                                    <h4 class="title text-center">When
                                        <hr>
                                    </h4>
                                    <div class="when"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Explanation Area end -->

        <!-- How Area Start -->
        <section class="team-area  section-bg">
            <div class="container">
                <div class="container">
                    <br><br>
                    <h2 class="text-center">How?</h2>
                    <p class="text-center">We have simplified the trademark search process to 4 simple steps, and we
                        are here each step of the way</p>
                    <br><br>
                    <div class="timeline">
                    </div>
                </div>
            </div>
        </section>
        <!-- How Area End -->
    </div>

    <!-- Need more information Area start -->
    <section class="clerify-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-5 col-lg-6 col-md-6">
                    <div class="section-tittle text-center mb-80">
                        <h2>Need more information?</h2>
                        <h5>Feel free to contact us, and we will respond in a reasonable time, or you can
                            go back to packages. </h5><br><br>
                        <div class="hero__caption"></div>
                        <div class="slider-btns ">
                            <a href="{{ url('contact-us') }}" class="btn info-button hero-btn text-center">Contact
                                Us </a>
                            <a href="{{ url('/service') }}"
                               class="btn info-button hero-btn text-center">Packages </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Need more information Area End -->
    <script>
        window.onload = function () {
            showServiceData();
        };
        // Get service id
        var serviceid = document.getElementById("services").value;

            // GET every services details by id to display ( What - Why - When ) Section on search page
            function showServiceData() {
                var serviceid = document.getElementById("services").value;
                var countryid = document.getElementById("countries").value;
                if (serviceid > 0) {
                    // GET every service Explanation section Details by serviceId
                    $.ajax({
                        url: '{{ url('getServiceDetails') }}' + '/' + serviceid,
                        dataType: 'json',
                        type: 'GET',
                        cache: false,
                        async: true,
                        success: function (data) {
                            $('.what').html('<p>' + data['service_what_' + locale] + '</p>');
                            $('.why').html('<p>' + data['service_why_' + locale] + '</p>');
                            $('.when').html('<p>' + data['service_when_' + locale] + '</p>');
                        },
                        error: function (jqXhr, textStatus, errorThrown) {
                            console.log(errorThrown);
                            alert(errorThrown);
                        }
                    })

                // GET every service How section Details by serviceId
                $.ajax({
                    url: '{{ url('getServiceShowDetails') }}' + '/' + serviceid,
                    dataType: 'json',
                    type: 'GET',
                    cache: false,
                    async: true,
                    success: function (data) {
                        $('.timeline').html("");
                        for (var i = 0; i < data.length; i++) {
                            $('.timeline').html($('.timeline').html() + `<div class="row no-gutters justify-content-end justify-content-md-around align-items-start timeline-nodes">
                            <div class="col-10 col-md-5 order-3 order-md-1 timeline-content">
                                <h3 class=" text-light">${data[i]['title_' + locale]} </h3>
                                <p>${data[i]['content_' + locale]} <a href="${data[i].detail_url}" style="color: #007bff; text-align:center" > Here </a></p>

                            </div>
                            <div class="col-2 col-sm-1 px-md-3 order-2 timeline-image text-md-center">
                                 <p class="text-center">${i + 1}</p>
                            </div>
                            <div class="col-10 col-md-5 order-1 order-md-3 py-3 timeline-date">

                            </div>
                        </div>`);
                        }
                    },
                    error: function (jqXhr, textStatus, errorThrown) {
                        console.log(errorThrown);
                        alert(errorThrown);
                    }
                })

                if (countryid > 0 && serviceid > 0) {
                    // GET packages depends on (serivesID and countryID)
                    $.ajax({
                        url: '{{ url('getPackages') }}' + '/' + serviceid + '/' + countryid,
                        dataType: 'json',
                        type: 'GET',
                        cache: false,
                        async: true,
                        success: function (data) {
                            $('.package').html("");
                            for (var i = 0; i < data.length; i++) {
                                $('.package').html($('.package').html() + ` <div class="col-lg-3 col-md-12"  col-sm-12" >
                        <div class="icon-boxes ">
                             <a href="{{url('validate-trademark')}}/${data[i].service_package.package_id}/${data[i].service_package.service_id}/${data[i].country_id}/${data[i].id}">
                                <div class=" d-flex align-items-stretch " data-aos="zoom-in" data-aos-delay="200">
                                    <div class="icon-box text-center">
                                    <span>${data[i].service_package.package['package_type_' + locale]}</span>
                                        <h3 class="text-center">${data[i].service_package.package['package_' + locale]}  </h3>

                                        <h4 class="fixed-price text-center">${data[i].service_package.fee} $</h4><br>
                                        <p class="gov-fees">plus government fees</p>
                                        <h4 class="var-price text-center">${data[i].fees} $</h4>
                                        <div class="features">
                                            <p>Features:</p>
                                            <p>${data[i].service_package.package['package_details_' + locale]}</P>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>`);
                                }
                            },
                            error: function (jqXhr, textStatus, errorThrown) {
                                console.log(errorThrown);
                                alert(errorThrown);
                            }
                        })
                    } else if (serviceid > 0) {
                        // GET packages depends on (serivesID )
                        $.ajax({
                            url: '{{ url('getPackageServiceId') }}' + '/' + serviceid,
                            dataType: 'json',
                            type: 'GET',
                            cache: false,
                            async: true,
                            success: function (data) {
                                $('.package').html("");
                                for (var i = 0; i < data.length; i++) {
                                    $('.package').html($('.package').html() + ` <div class="col-lg-3 col-md-12"  col-sm-12" >
                        <div class="icon-boxes ">
                                <div class=" d-flex align-items-stretch " data-aos="zoom-in" data-aos-delay="200">
                                    <div class="icon-box text-center">
                                    <span>${data[i].package['package_type_' + locale]}</span>
                                        <h3 class="text-center">${data[i].package['package_'+ locale]} </h3>

                                        <h4 class="fixed-price text-center">${data[i].fee} $</h4><br>
                                        <p class="gov-fees">plus government fees</p>
                                        <h4 class="var-price text-center">0 $</h4>
                                        <div class="features">
                                            <p>Features:</p>
                                            <p>${data[i].package['package_details_' + locale]}</P>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>`);
                            }
                        },
                        error: function (jqXhr, textStatus, errorThrown) {
                            console.log(errorThrown);
                            alert(errorThrown);
                        }
                    })
                }
                // show all content depends on select search ( service and Country)
                document.getElementById("search-section-display").style.display = "contents";
            }
        }
    </script>
@endsection
