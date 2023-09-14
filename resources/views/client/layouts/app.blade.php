<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Easy Trademark</title>
    <meta property="og:title" content="easytrademarks Your trademark portal in the Middle East" />
    <meta property="og:description" content="We believe that Intellectual property protection is cornerstone to business success. We pledged to launch an accessible platform that provides; transparent, fair, and affordable tools that avoid unfair fees, and help you start your protection early and smoothly. Focus on your business, and let us join the journey and protect your IP!" />
    <meta property="og:image" content="https://easy-trademarks.com/public/img/web_logo.png" />
    <meta property="og:url" content="https://easy-trademarks.com" />
    <meta property="og:site_name" content="easy-trademarks.com" />
    <meta property="og:type" content="website" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="">
    <link rel="stylesheet" href="{{ asset('public/assets/css/bootstrap.min.css') }}">
    
    <link rel="stylesheet" href="{{ asset('public/assets/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/assets/css/slicknav.css') }}">
    <link rel="stylesheet" href="{{ asset('public/assets/css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/assets/css/fontawesome-all.min.css') }}">
	<link rel="stylesheet" href="{{ asset('public/assets/css/style.css') }}">
	@if(app()->getLocale() == "ar")
	<link rel="stylesheet" href="{{ asset('public/assets/css/bootstrap-rtl.css') }}">
    <link rel="stylesheet" href="{{ asset('public/assets/css/rtl-style.css') }}">
	@endif
	<link rel="stylesheet" href="{{ asset('public/assets/css/select2.min.css') }}">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-173106829-1"> </script> <script> window.dataLayer = window.dataLayer || []; function gtag(){dataLayer.push(arguments);} gtag('js', new Date()); gtag('config', 'UA-173106829-1'); </script>
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-5PFLB79');</script>
<!-- End Google Tag Manager -->
</head>
<body>
<!--Additionally, paste this code immediately after the opening <body> tag:-->
<!-- Google Tag Manager (noscript) -->
<noscript>
    <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5PFLB79"
            height="0" width="0" style="display:none;visibility:hidden"></iframe>
</noscript>
<!-- End Google Tag Manager (noscript) -->
<script type="text/javascript"> var $zoho=$zoho || {};$zoho.salesiq = $zoho.salesiq || {widgetcode:"d5e335506d0fe4bdb159c771f94f63c14aa140b3ecf918d3932203b67acb94eb2308342c7991acb4a11f8b4836b4a779", values:{},ready:function(){}}; var d=document;s=d.createElement("script");s.type="text/javascript";s.id="zsiqscript";s.defer=true; s.src="https://salesiq.zoho.com/widget";t=d.getElementsByTagName("script")[0];t.parentNode.insertBefore(s,t);d.write("<div id='zsiqwidget'></div>"); </script>
<header>
    <div class="header-area">
        <div class="main-header header-sticky">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-xl-2 col-lg-2 col-md-1">
                        <div class="logo">
                            <a href="{{url('/')}}">
                                <img src="{{url('public/img/web_logo.png')}}">
                            </a>
                        </div>
                    </div>
                    <div class="col-xl-10 col-lg-10 col-md-10">
                        <div class="menu-main d-flex align-items-center justify-content-end">
                            <div class="main-menu f-right d-none d-lg-block">
                                <nav>
                                    <ul id="navigation">
                                        <li><a href="{{url('/')}}">{{ trans('home/app.home') }}</a></li>
                                        <li><a href="{{url('/service')}}">{{ trans('home/app.services') }}</a></li>
                                        <li><a href="{{url('/about-us')}}">{{ trans('home/app.about-us') }}</a></li>
                                        <li><a href="{{url('/resource-center')}}">{{ trans('home/app.resource-center') }}</a>
                                        <ul class="submenu" style="width: 200px;">
												<li><a href="{{ url('/our-community') }}">{{ trans('home/app.our-community') }}</a></li>
												<li><a href="{{ url('/templates-and-forms') }}">{{ trans('home/app.templates-and-forms') }}</a></li>
												<li><a href="{{ url('/news') }}">{{ trans('home/app.blogs') }}</a></li>
												<li><a href="{{ url('/rsslist/1') }}">{{ trans('home/app.whats-new') }}</a></li>
												<li><a href="{{ url('/userguide') }}">{{ trans('home/app.user-guide') }}</a></li>
												<li><a href="{{ url('/FAQs') }}">{{ trans('home/app.faq') }}</a></li>
											</ul>
										</li>
                                        @auth
                                            @if(auth()->user()->user_type_id == 4)
                                                <li><a style="cursor: pointer">{{Auth::user()['user_name']}} <i
                                                            class="fa fa-cart-plus"
                                                            aria-hidden="true"></i></a>
                                                    <ul class="submenu">
                                                        <li><a href="{{ url('/trademarks') }}">{{ trans('home/app.orders') }}</a></li>
                                                        <li><a href="{{ route('logout') }}"
                                                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                                {{ trans('home/app.logout') }}
                                                            </a>
                                                        </li>
                                                        <form id="logout-form" action="{{ route('logout') }}"
                                                              method="POST"
                                                              style="display: none;">
                                                            {{ csrf_field() }}
                                                        </form>
                                                    </ul>
                                                </li>
                                                <!----///////////////////////ET Member///////////////////-->
                                            @elseif(auth()->user()->user_type_id == 3)
                                                <li><a href="">{{Auth::user()['user_name']}} <i class="fa fa-cart-plus"
                                                                                                aria-hidden="true"></i></a>
                                                    <ul class="submenu">
                                                        <li><a href="{{ url('/member/trademarkscms') }}">{{ trans('home/app.dashboard') }}</a>
                                                        </li>
                                                        <li><a href="{{ route('logout') }}"
                                                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                                {{ trans('home/app.logout') }}
                                                            </a>
                                                        </li>
                                                        <form id="logout-form" action="{{ route('logout') }}"
                                                              method="POST"
                                                              style="display: none;">
                                                            {{ csrf_field() }}
                                                        </form>
                                                    </ul>
                                                </li>
                                                <!----///////////////////////Admin Panel///////////////////-->
                                            @elseif(auth()->user()->user_type_id == 1 || auth()->user()->user_type_id == 2)
                                                <li>{{Auth::user()['user_name']}} <i class="fa fa-cart-plus"
                                                                                     aria-hidden="true"></i>
                                                    <ul class="submenu">
                                                        <li><a href="{{ url('/adminpanel/dashboard') }}">{{ trans('home/app.dashboard') }}</a>
                                                        </li>
                                                        <li><a href="{{ route('logout') }}"
                                                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                                {{ trans('home/app.logout') }}
                                                            </a>
                                                        </li>
                                                        <form id="logout-form" action="{{ route('logout') }}"
                                                              method="POST"
                                                              style="display: none;">
                                                            {{ csrf_field() }}
                                                        </form>
                                                    </ul>
                                                </li>
                                            @else
                                            @endauth
                                        @endif
                                        @guest
                                            <li><a href="{{ route('login') }}">{{ trans('home/app.login') }}</a></li>
                                        @endguest
                                        <li>
										<div class="dropdown" >
                                          <a  href="#" class="dropdown-toggle" data-toggle="dropdown">
                                            {{ trans('home/app.language-currency') }}
                                          </a>
                                          <div class="dropdown-menu">
										  <b style="font-size:14px;">&nbsp;<i class="fa fa-flag-checkered" aria-hidden="true"></i>&nbsp;{{ trans('home/app.change-lang') }}</b><br>
                                            @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
											@if(app()->getLocale() == $localeCode)
                                             <a style="padding: 2px 20px;background:rgb(206, 206, 206);" class="dropdown-item" rel="alternate" hreflang="{{ $localeCode }}"
                                                   href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}" >
                                                       {{ $properties['native'] }}
                                                </a>
											@else
											<a style="padding: 2px 20px;" class="dropdown-item" rel="alternate" hreflang="{{ $localeCode }}"
                                                   href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}"  >
                                                       {{ $properties['native'] }}
                                                </a>
											@endif 	
                                             @endforeach
											 <div class="dropdown-divider"></div>
											 <b style="font-size:14px;">&nbsp;<i class="fa fa-money" aria-hidden="true"></i>&nbsp;{{ trans('home/app.change-curr') }}</b><br>
										 <select multiple class="form-control" id="currency" style="width:85%;margin-left:10px;">
											@foreach($allowCurrencies as $currencyCode)
												<option value="{{ $currencyCode }}"
														@if(session('userCountryCurrencyCode') == $currencyCode) selected @endif>
													{{ $currencyCode }}</option>
											@endforeach
										</select>
										</div>
										</div>
                                       </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="mobile_menu d-block d-lg-none"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<main>
    @include('cookieConsent::index')
    @yield('content')
</main>
<footer>
    <div class="footer-area footer-padding">
        <div class="container">
            <div class="row">  
              <div class="col-xl-3 col-lg-3 col-md-6 col-sm-5">
                    <div class="single-footer-caption mb-50">
                        <div class="footer-tittle">
                            <h4>{{ trans('home/app.useful-links') }}</h4>
                            <ul style="list-style: none">
                                <a href="{{url('/')}}">
                                    <li> {{ trans('home/app.home') }}</li>
                                </a>
                                <a href="{{url('/service')}}">
                                    <li> {{ trans('home/app.services') }}</li>
                                </a>
                                <a href="{{url('/about-us')}}">
                                    <li>{{ trans('home/app.about-us') }}</li>
                                </a>
                                <a href="{{url('/contact-us')}}">
                                    <li>{{ trans('home/app.contact-us') }}</li>
                                </a>
                                <a href="{{url('/resource-center')}}">
                                    <li>{{ trans('home/app.resource-center') }}</li>
                                </a>
                            </ul>
                        </div>
                    </div>
                </div> 
                 
                <div class="col-xl-3 col-lg-3 col-md-4 col-sm-5">
                    <div class="single-footer-caption mb-50">
                        <div class="footer-tittle">
                            <h4>{{ trans('home/app.resource-center') }}</h4>
                            <ul style="list-style: none">
                                <a href="{{ url('/our-community') }}">
                                    <li>{{ trans('home/app.our-community') }}</li>
                                </a>
                                <a href="{{ url('/templates-and-forms') }}">
                                    <li> {{ trans('home/app.templates-and-forms') }}</li>
                                </a>
                                <a href="{{ url('/news') }}">
                                    <li>{{ trans('home/app.blogs') }}</li>
                                </a>
								<a href="{{ url('/rsslist/1') }}">
                                    <li>{{ trans('home/app.whats-new') }}</li>
                                </a>
                                <a href="{{ url('/userguide') }}">
                                    <li>{{ trans('home/app.user-guide') }}</li>
                                </a>
                                <a href="{{ url('/FAQs') }}">
                                    <li>{{ trans('home/app.faq') }}</li>
                                </a>
                            </ul>
                        </div>
                    </div>
                </div> 
                <div class="col-xl-3 col-lg-3 col-md-4 col-sm-5">
                    <div class="single-footer-caption mb-50">
                        <div class="footer-tittle">
                            <h4> {{ trans('home/app.services') }}</h4>
                            <ul style="list-style: none;">
                                @foreach ($allActiveServices as $service_active)
                                    <a href="{{ url('/service-search') . '/' . $service_active->id}}">
                                        <li>{{$service_active->service_name}}</li>
                                    </a>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
          
                <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6">
                    <div class="single-footer-caption mb-50">
                        <div class="single-footer-caption mb-30">
                            <div class="footer-tittle">
                                <div class="logo">
                                    <span class="logo-part">easy</span>trademarks
                                </div>
                                <div style="margin-top: 25px">
                                    <a href="https://www.linkedin.com/company/easytrademarks/" target="_blank">
                                        <img src="{{ asset('public/assets/img/hero/linkedin.png')}}" alt="linkedin icon"
                                             width="40" height="40">
                                    </a>
                                    <a href="https://twitter.com/easytrademarks" target="_blank">
                                        <img src="{{ asset('public/assets/img/hero/twitter.png')}}" alt="facebook icon"
                                             width="40" height="40">
                                    </a>
                                </div>
                                <img src="{{ asset('public/img/propay_cards.png')}}" alt="payment" width="220" height="60">
                                <img src="{{ asset('public/img/Alipay_logo.png')}}" alt="visamaster" width="100" height="40">
                                <img src="{{ asset('public/img/wechat.png')}}" alt="visamaster" width="130" height="90">
                            </div>
                        </div>
                    </div>
                </div>
            
            
            </div>
        </div>
    </div>
    <div class="footer-bottom-area footer-bg text-center">
        <div class="container">
            <div class="footer-border">
                <div class="row d-flex justify-content-between align-items-center">
                    <div class="col-xl-12 col-lg-12 ">
                        <div class="footer-copy-right">
                            <p class="float-left">
                                &copy; {{ trans('home/app.all-rights-reserved') }} – <a href="{{url('/privacy')}}">{{ trans('home/app.privacy-policy') }}</a> - <a href="{{url('/terms-of-use')}}">{{ trans('home/app.terms-of-use') }}</a>
                            </p>
                            <p class="float-right"> {{ trans('home/app.mrip-is-service-company') }} </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<script src="{{ asset('public/assets/js/vendor/modernizr-3.5.0.min.js') }}"></script>
<script src="{{ asset('public/assets/js/vendor/jquery-1.12.4.min.js') }}"></script>
<script src="{{ asset('public/assets/js/popper.min.js') }}"></script>
<script src="{{ asset('public/assets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('public/assets/js/jquery.slicknav.min.js') }}"></script>
<script src="{{ asset('public/assets/js/plugins.js') }}"></script>
<script src="{{ asset('public/assets/js/main.js') }}"></script>
<script src="{{ asset('public/assets/js/myfontawesome.js') }}"></script>
<script src="{{ asset('public/assets/js/select2.min.js') }}"></script>
<script type="text/javascript">
    let base_url = '{!! url('/'. App::getLocale()) !!}'
    let auth_user = '{{ (Auth::user()) ? Auth::user() : 'false' }}'
    let locale = '{{ config('app.locale') }}';
</script>
</body>
</html>
