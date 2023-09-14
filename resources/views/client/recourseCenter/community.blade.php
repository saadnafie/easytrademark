@extends('client.layouts.app')
@section('content')
    <style>
        .see-more-container {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        .see-more-content {
            height: 55px;
            overflow: hidden;
            order: -1;
        }

        p {
            margin: 0;
        }

        input:checked ~ .see-more-content {
            overflow: visible;
            height: auto;
        }

        .see-more-btn {
            width: 0;
            height: 0;
            border: none;
            outline: none;
            -webkit-appearance: initial;
        }

        .see-more-label {

            cursor: pointer;
            color: blue;
        }

        #see-more-button:focus + .see-more-label {
            outline: 4px auto #007791;
        }

        .see-more-btn:checked + .see-more-label > .see-more {
            display: none;
        }

        .see-more-btn:not(:checked) + .see-more-label > .see-less {
            display: none;
        }

        .page-container {
            width: 400px;
        }
    </style>
    <div class="faq">
        <div class="container">
            <br><br><br><br>
            <h3 class="text-center"> {{ trans('home/app.our-community') }}
                <hr>
            </h3>
            <br>
            <div class="container">
                <div class="row">
                    @foreach ($community as $data)
                        <div class="col-md-6">
                            <div class="box-data">
                                <div class="img-top" style="">
                                    <img src="{{ asset('public/resource_center/community').'/'.$data->logo}}" alt=""
                                         class="img-fluid"/>
                                </div>
								<br>
                                <h3>{{ $data->title}}</h3>
                                <span>{{$data->country}}</span>
                                <div class="container">
                                    <div class="see-more-container">
                                        <input class="see-more-btn" id="see-more-button{{$data->title}}"
                                               type="checkbox">
                                        <label class="see-more-label text-right" for="see-more-button{{$data->title}}">
                                            <span class="see-more text-right"> .... {{ trans('resourcecenter/resourcecenter.see-more') }}</span>
                                            <span class="see-less text-right"> {{ trans('resourcecenter/resourcecenter.see-less') }}</span>
                                        </label><br>
                                        <div class="see-more-content">
                                            <p>
											{{$data->description}} 
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <a href="https://{{$data->website_url}}" target="_blank"> {{ trans('resourcecenter/resourcecenter.official-website') }} </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
