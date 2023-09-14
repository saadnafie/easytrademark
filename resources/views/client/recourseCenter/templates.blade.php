@extends('client.layouts.app')
@section('content')
    <div class="faq">
        <div class="container">
            <br><br><br><br>
            <h3 class="text-center"> {{ trans('home/app.templates-and-forms') }}
                <hr>
            </h3>
            <form action="{{route('templatesSearch')}}" method="GET">
                <div class="text-center center-block">
                    <select id="country" class="my_form-control" name="country">
                        <option>{{ trans('resourcecenter/resourcecenter.select-country') }}</option>
                        @foreach($countries as $country)
                            <option value="{{$country->id}}">
                                {{$country->country_name}}
                            </option>
                        @endforeach
                    </select>
                    <input type="submit" value="{{ trans('resourcecenter/resourcecenter.search') }}" class="">
                </div>
            </form>
            <br><br>
            <div class="documents">
                @if(isset($selectedCountry))
                    <h4>- {{$selectedCountry->country_name}}</h4>
                @endif
                @if(isset($Documents))
                    @if( count($Documents) > 0)
                        @foreach($Documents as $data)
                            <ol>
                                <p style="margin-bottom: 10px">{{$data[0]->service->service_name}}</p>
                                @foreach($data as $doc)
                                    <li style="margin-left: 50px"> - {{$doc->document->doc_title}}
                                        <?php
                                        $info = pathinfo(asset('public/resource_center/document_template').'/'.$doc->document->doc_file);
                                        $ext = $info['extension'];
                                        
                                        ?>
                                        <a href="{{ asset('public/resource_center/document_template').'/'.$doc->document->doc_file}}"
                                           download="{{$doc->document->doc_title}}.{{$ext}}">
                                            <i class="i-icon-template fa fa-download" aria-hidden="true"></i>
                                        </a>
                                    </li>
                                @endforeach
                            </ol>
                        @endforeach
                    @else
                        <div class="container">
                            <p class="alert alert-danger">No templates available for this country</p>
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
@endsection

