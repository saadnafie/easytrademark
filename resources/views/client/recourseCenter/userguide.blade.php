@extends('client.layouts.app')
@section('content')
    <div class="faq">
        <div class="container">
            <br><br><br><br>
            <h3 class="text-center"> {{ trans('home/app.user-guide') }}
                <hr>
            </h3>

            @if(count($userguide) > 0)
                <div class="row">
                    @foreach ($userguide as $data)
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            @if($data->images->isEmpty())
                                            <img src="{{asset('public/img/userguide_pic.png')}}">
                                           @else
                                            <div id="carouselExampleIndicators{{$data->id}}" class="carousel slide"
                                                 data-ride="carousel">
                                                <div class="carousel-inner">
                                                    @foreach($data->images as $img)
                                                        <div
                                                            class="carousel-item news-img-container {{ $loop->first ? 'active' : '' }}"
                                                            style="width: 100%;overflow: hidden">
                                                            <img class="d-block w-100" style="height:100%"
                                                                 src="{{asset('public/resource_center/user_guides').'/'. $img->image_path}}"
                                                                 alt="First slide">
                                                        </div>
                                                        <a class="carousel-control-prev"
                                                           href="#carouselExampleIndicators{{$data->id}}" role="button"
                                                           data-slide="prev">
                                                            <span class="carousel-control-prev-icon"
                                                                  aria-hidden="true"></span>
                                                            <span class="sr-only">Previous</span>
                                                        </a>
                                                        <a class="carousel-control-next"
                                                           href="#carouselExampleIndicators{{$data->id}}" role="button"
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
                                        <div class="col-md-8">
                                            <h4><strong>{{ $data->title}}</strong></h4><br>
                                            {!! substr($data->description,0,400) !!} ...<br>
                                            <a class="btn btn-info float-right"
                                               href="{{url('userguidedetail')}}/{{$data->guide_slug}}" target="_blank">Read
                                                more</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                        </div>
                    @endforeach
                </div>
            @else
                <br><br>
                <p style="font-size:80px;color:gray;text-align:center;">
                    <i class="fa fa-info-circle" aria-hidden="true"></i>
                    <br><br>
                    No Data!
                </p>
                <br><br><br><br>
            @endif
        </div>
    </div>
@endsection

