@extends('client.layouts.app')
@section('content')
    <div class="recourseCenter">
        <div class="container">
            <br><br><br><br>
            <h3 class="text-center"> {{ trans('home/app.resource-center') }}
                <hr>
            </h3>
            <div class="row">
                <div class="col-lg-4 col-md-12">
                    <a href="{{ url('/templates-and-forms') }}">
                        <div class="icon-boxes">
                            <div class=" align-items-stretch mb-5 mb-lg-0" data-aos="zoom-in" data-aos-delay="200">
                                <div class="icon-box text-center">
                                    <div class="icon text-center"><i class="fa  fa-2x fa-puzzle-piece"
                                                                     aria-hidden="true"></i><br>
                                    </div>
                                    <h4 class="title text-center">{{ trans('home/app.templates-and-forms') }}</h4>
                                    <p class="description">
                                    {{ trans('resourcecenter/resourcecenter.templates_forms_detail') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-md-12">
                    <a href="{{ url('/FAQs') }}">
                        <div class="icon-boxes">
                            <div class="  align-items-stretch mb-5 mb-lg-0" data-aos="zoom-in" data-aos-delay="200">
                                <div class="icon-box text-center">
                                    <div class="icon text-center"><i class="fa  fa-2x  fa-question-circle"
                                                                     aria-hidden="true"></i><br>
                                    </div>
                                    <h4 class="title text-center">{{ trans('home/app.faq') }}</h4>
                                    <p class="description">
                                       {{ trans('resourcecenter/resourcecenter.faqs_detail') }}

                                    </p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-md-12">
                    <a href="{{ url('/our-community') }}">
                        <div class="icon-boxes">
                            <div class=" align-items-stretch mb-5 mb-lg-0" data-aos="zoom-in" data-aos-delay="200">
                                <div class="icon-box text-center">
                                    <div class="icon text-center"><i class="fa fa-2x  fa-users" aria-hidden="true"></i>
                                        <br>
                                    </div>
                                    <h4 class="title text-center">{{ trans('home/app.our-community') }} </h4>
                                    <p class="description">
                                    {{ trans('resourcecenter/resourcecenter.our_community_detail') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-md-12 "
                     style="display: block;margin-left: auto;margin-right: auto;width: 100%">
                    <a href="{{url('userguide')}}">
                        <div class="icon-boxes">
                            <div class="icon-box text-center">
                                <div class="icon text-center"><i class="fa fa-2x  fa-book"
                                                                 aria-hidden="true"></i><br>
                                </div>
                                <h4 class="title text-center">{{ trans('home/app.user-guide') }} </h4>
                                <p class="description">{{ trans('resourcecenter/resourcecenter.userguide_detail') }}  </p>
                            </div>
                        </div>
                    </a>
                </div>
				 <div class="col-lg-4 col-md-12 "
                     style="display: block;margin-left: auto;margin-right: auto;width: 100%">
                    <a href="{{ url('/news') }}">
                        <div class="icon-boxes">
                            <div class="icon-box text-center">
                                <div class="icon text-center"><i class="fa fa-2x  fa-newspaper-o"
                                                                 aria-hidden="true"></i><br>
                                </div>
                                <h4 class="title text-center">{{ trans('home/app.blogs') }} </h4>
                                <p class="description">{{ trans('resourcecenter/resourcecenter.whats_new_detail') }}</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-md-12 "
                     style="display: block;margin-left: auto;margin-right: auto;width: 100%">
                    <a href="{{ url('/rsslist') }}/1">
                        <div class="icon-boxes">
                            <div class="icon-box text-center">
                                <div class="icon text-center"><i class="fa fa-2x  fa-rss"
                                                                 aria-hidden="true"></i><br>
                                </div>
                                <h4 class="title text-center">{{ trans('home/app.whats-new') }} </h4>
                                <p class="description">{{ trans('resourcecenter/resourcecenter.whats_new_detail') }}</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <br><br><br>
@endsection
