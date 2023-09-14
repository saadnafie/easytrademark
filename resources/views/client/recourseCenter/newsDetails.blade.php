@extends('client.layouts.app')
@section('content')
    <div class="faq">
        <div class="container">
            <br><br>
            <h3 class="text-center"> {{$details->title}}
                <hr>
            </h3>
            <br>
            <div class="container">
                <div class="row">
                    <div id="carouselExampleIndicators{{$details->id}}" class="carousel slide"
                         data-ride="carousel">
                        <div class="carousel-inner">
                            @foreach($details->images as $img)
                                <div class="carousel-item slider-image-news {{ $loop->first ? 'active' : '' }}" style="width: 100%;overflow: hidden">
                                    <img class="d-block w-100" style="height:100%"
                                         src="{{asset('public/resource_center/news').'/'. $img->image_path}}"
                                         alt="First slide">
                                </div>
                                <a class="carousel-control-prev"
                                   href="#carouselExampleIndicators{{$details->id}}" role="button"
                                   data-slide="prev">
                                                            <span class="carousel-control-prev-icon"
                                                                  aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="carousel-control-next"
                                   href="#carouselExampleIndicators{{$details->id}}" role="button"
                                   data-slide="next">
                                                            <span class="carousel-control-next-icon"
                                                                  aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                            @endforeach
                        </div>
                    </div>

                        <div class="col-md-12"><br>
                            <span><i>{{$details->created_at}}</i></span>
                            <div class="text-center"><br>
                                {!! $details->description !!}
                            </div>
                            <br>
                        </div>
                </div>
            </div>
        </div>
    </div>
@endsection
