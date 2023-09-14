@extends('client.layouts.app')
@section('content')
    <main>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="steper">
                        <div class="card">
                            @if (Session::has('success'))
                                <div class="alert alert-success text-center">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                                    <p>{{ Session::get('success') }}</p>
                                </div>
                            @endif
                            @if($errors->any())
							<div class="alert alert-danger text-center">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                                    <h4>{{$errors->first()}}</h4>
                                </div>
							@endif
                            @if($Documents->count() !== 0)
                                <form id="msform" method="post" action="{{route('storeDocuments')}}"
                                      enctype="multipart/form-data" autocomplete="off">
                                    @csrf
                                    @php $countryId = array(); $trademarkCountryId = array(); @endphp
                                    <span style="display: none">
                                    @foreach($orderCountries->trademark_country_order as $index => $data)
                                            {{ $trademarkCountryId[$index] = $data->trademark_country->id }}
                                            {{ $countryId[$index] = $data->trademark_country->country->id }}
                                        @endforeach
                               </span>
                                    <input name="countryIdList" type="hidden"
                                           value="{{ json_encode($countryId,TRUE)}}">

                                    <input name="trademarkCountryId" type="hidden"
                                           value="{{ json_encode($trademarkCountryId,TRUE)}}">
                                    <fieldset>
                                        <h2 id="heading">Required Documents
                                        </h2>
                                        <hr>
                                        <br><br>
                                        <div class="form-card">
                                            <div class="contactForm row">
                                                <br><br>
                                                @foreach($Documents as $index => $data)
                                                    <input name="doc_id[]" type="hidden"
                                                           value="{{$data->document->id}}">
                                                    <input name="countryId[]" type="hidden"
                                                           value="{{$data->country->id}}">
                                                    <div class="col-md-4">
                                                        <div class="continer">
                                                            <div class="form-group">
                                                            <span
                                                                style="color:#ff0b00">{{$data->country->country_name}}</span><br>
                                                                {{$data->document->document_title}}
                                                                <br><br><input type="file" name="document[]"
                                                                               accept="application/pdf"
                                                                               class="my_form-control center-block"
                                                                />
                                                                <small class="my_place"> </small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <br><br>
                                            @if (\Session::has('error'))
                                                <div class="alert alert-danger">
                                                    <ul>
                                                        <li>{!! \Session::get('error') !!}</li>
                                                    </ul>
                                                </div>
                                            @endif
                                            @if($templateDocumentsCount > 0)
                                                <div class="row">
                                                    <p class="required-p float-left"> The suggested templates for
                                                        particular
                                                        country
                                                        can be downloaded <a id="download-country-document"
                                                                             class="required-a"
                                                                             href="{{ route('download-country-document', $id) }}">here.</a>
                                                    </p>
                                                </div>
                                            @endif
                                        </div>
                                        <hr>
                                        <input type="submit" class=" action-button text-center" value="Upload"/>
                                        <a href="{{ url('translationDocuments').'/'. $id}}"
                                           class="translate-service-button float-left" target="_blank"><i class="fa fa-plus"></i> Translation to cart</a>
									   <br><br><br>
									   <a href="{{ url('trademarks')}}"
                                           class="btn btn-primary float-left">Proceed and submit later</a>
                                    </fieldset>
                                </form>
                            @else
                                <h3>All Required Documents Already Uploaded Successfully</h3>
                            @endif
                        </div>
                    </div>
                </div>
                <div>
                </div>
            </div>
        </div>
    </main>
@endsection
