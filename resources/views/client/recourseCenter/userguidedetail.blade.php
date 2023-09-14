@extends('client.layouts.app')
@section('content')
    <div class="faq">
        <div class="container">
            <br><br>
            <h3 class="text-center"> {{ trans('home/app.user-guide') }}
                <hr>
            </h3>
            <br>
            <div class="container">
                <div class="row">
                  <div class="col-md-12">
                    @if($userguidedetail->images->isEmpty())
                      <center><img src="{{asset('public/img/userguide_pic.png')}}"></center>
                     @else
                    <div id="carouselExampleIndicators{{$userguidedetail->id}}" class="carousel slide"
                         data-ride="carousel">
                        <div class="carousel-inner">
                            @foreach($userguidedetail->images as $img)
                                <div class="carousel-item slider-image-news {{ $loop->first ? 'active' : '' }}"
                                     style="width: 100%;overflow: hidden">
                                    <img class="d-block w-100" style="height:100%"
                                         src="{{asset('public/resource_center/user_guides').'/'. $img->image_path}}"
                                         alt="First slide">
                                </div>
                                <a class="carousel-control-prev"
                                   href="#carouselExampleIndicators{{$userguidedetail->id}}" role="button"
                                   data-slide="prev">
                                                            <span class="carousel-control-prev-icon"
                                                                  aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="carousel-control-next"
                                   href="#carouselExampleIndicators{{$userguidedetail->id}}" role="button"
                                   data-slide="next">
                                                            <span class="carousel-control-next-icon"
                                                                  aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    </div>
                    <div class="col-md-12"><br>
                      <h4>{{$userguidedetail->title}}</h4>
                        <span><i>{{$userguidedetail->created_at}}</i></span>
                        <div class="text-center"><br>
                            {!! $userguidedetail->description !!}
                        </div>
                        <br>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
