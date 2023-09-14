@extends('client.layouts.app')

@section('content')
    <style>
        #overlay {
            width: 500px;
            height: 220px;
            background: #fff;
            color: #000;
            text-align: center;
            padding: 45px 0 66px 0;
            opacity: 1;
            -webkit-transition: opacity 0.25s ease;
            -moz-transition: opacity 0.25s ease;
            z-index: 10;
            display: block
        }

        #overlay2 {
            width: 500px;
            height: 220px;
            background: #fff;
            color: #000;
            text-align: center;
            padding: 45px 0 66px 0;
            opacity: 1;
            -webkit-transition: opacity 0.25s ease;
            -moz-transition: opacity 0.25s ease;
            z-index: 10;
            display: block
        }

        #plus {
            font-family: Helvetica;
            font-weight: 900;
            color: #000;
            font-size: 50px;
            background: #fff;
            padding: 50px;
        }
    </style>
    <main>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="steper">
                        <div class="card">
                            <form id="msform" role="form" method="post" action="{{route('store-search-service')}}"
                                  enctype="multipart/form-data" autocomplete="off">
                                @csrf
                                <input name="countryPackageFeesID" type="hidden" value="{{ $countryPackageFees }}">
                                <input name="packageID" type="hidden" value="{{ $package->id }}">
                                <input name="serviceId" type="hidden" value="{{ $serviceId }}">
                                <input name="countryId" type="hidden" value="{{ $selectedCountry->id }}">
                                @if( $newTrademarkLabel != null)
                                    <input name="trademarkLabel" type="hidden" value="{{ $newTrademarkLabel }}">
                                @else
                                    <input name="trademarkId" type="hidden" value="{{ $existingTrademarkId }}">
                                @endif
                                <fieldset>
                                    <h2 id="heading">{{ trans('servicelable/servicelable.mark-type') }}
                                    </h2>
                                    <hr>
                                    <div class="form-card">
                                        <div class="row">
                                            <div class="col-md-6 text-center top-layer"
                                                 style="border-right: 2px solid #eee;position: relative;">
                                                <div id="overlay" onclick="clickHere()" style="position: absolute;">
                                                <span id="plus">{{ trans('servicelable/servicelable.image') }}
                                                    <span data-toggle="tooltip"
                                                          title="Image: A graphic mark, a logo, a stylized word, an emblem, or symbol used in promoting a product or a service. It may be abstract, figurative, can include text, or not. Registering a logo as a trademark will protect the exact shape, orientation, stylization and color. Black and white logos protect all variations of colors."><i
                                                            class="fa fa-exclamation-circle"
                                                            aria-hidden="true"></i></span>
                                                        </span><br>
                                                </div>
                                                <h2>{{ trans('servicelable/servicelable.image') }} </h2>
                                                <input type="file" id="trademarkInputImg" name="trademarkImg"
                                                       class="my_form-control"
                                                       accept="image/x-png,image/gif,image/jpeg"/><br>
                                                <br> - MAX Size ( 30 MB )<br>
                                                - PNG , JPEG , GIF
                                            </div>
                                            <div class="col-md-6 top-layer text-center" style="position: relative;">

                                                <div id="overlay2" onclick="clickHere2()" style="position: absolute;">
                                                <span id="plus">{{ trans('servicelable/servicelable.word') }}
                                                    <span style="min-width:500px" data-toggle="tooltip"
                                                          title="Wordmark: A wordmark, is a distinct text-only typographic that you would like to search for. Registering a wordmark as a trademark will protect its use in any format, color and style. Slogan: A slogan is a memorable phrase or motto, or combination of generic words that identify the goods and services of a specific slogan owner. Registering a slogan does not provide the applicant with a monopoly right to each word in the slogan independently. It only provides protection over the exact phrase and sequence of words, in any format, color and style."><i
                                                            class="fa fa-exclamation-circle"
                                                            aria-hidden="true"></i></span>
                                                </span>
                                                </div>
                                                <h2>{{ trans('servicelable/servicelable.word') }}</h2>

                                                <div class="form-group">
                                                    <label>
                                                        <textarea
                                                            id="ArabicWordInput"
                                                            maxlength="100"
                                                            name="trademarkArabicWord"
                                                            class="form-control"
                                                            dir="rtl"
                                                            rows="2"
                                                            cols="50"
                                                            onclick="clickArabicWord()"
                                                            placeholder="الكلمه باللغه العربيه"></textarea>
                                                        OR <br>
                                                        <textarea
                                                            id="EnglishWordInput"
                                                            maxlength="100"
                                                            name="trademarkEnglishWord"
                                                            class="form-control"
                                                            rows="2"
                                                            cols="50"
                                                            onclick="clickEnglishWord()"
                                                            placeholder="word in English"></textarea>
                                                        <br>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        @if ($errors->has('trademarkImg'))
                                            <p class="alert alert-danger">{{ $errors->first('trademarkImg') }}</p>
                                        @endif
                                    </div>
                                    <input type="button" name="next" class="next action-button" value="{{ trans('servicelable/servicelable.next') }}"/>
                                    <h2 class="steps mt-4">{{ trans('servicelable/servicelable.step') }} 1 - 3</h2>
                                </fieldset>
                                <fieldset>
                                    <h2 id="heading">{{ trans('servicelable/servicelable.class') }}
                                        <span data-toggle="tooltip" title="Trademark classes are categories of products and services defined by the Nice classification, an International classification system which helps with standardizing trademark registrations.
Guidance on how to choose classes:

    -Check the actual products you are selling and compare them with the overall class description or the detail class list.

    -Promotional or corporate items that are not sold to the public should not be included

In case you are seeking protection for services, make sure that you only list the services you are providing to others. For example,
'advertising' applies if you provide advertising services for others - not if you are only advertising your own business."><i
                                                class="fa fa-exclamation-circle" aria-hidden="true"></i></span>
                                    </h2>
                                    <hr>
                                    <div class="form-card">
                                        <p>
                                            {{ trans('servicelable/servicelable.choose-the-class') }}
                                        </p>
                                        @foreach ($allClasses as $class)
                                            <label class="checkbox-inline" style="display: inline-block">
                                                <input type="radio" value="{{ $class->class_id }}"
                                                       {{ old('trademarkClasse') == $class->id ? 'checked' : ''  }}   name="trademarkClasse"
                                                       value="{{ old('trademarkClasse') }}" id="classes"
                                                       onchange="validateNext()">
                                                <span style="width: 27px;display: inline-block;">
                                            {{ $class->class_id }}
                                            </span>
                                            </label>
                                        @endforeach
                                    </div>
                                    @if ($errors->has('trademarkClasse'))
                                        <p class="alert alert-danger">{{ $errors->first('trademarkClasse') }}</p>
                                    @endif
                                    <p class="text-left">{{ trans('servicelable/servicelable.classification-goods') }}
                                        <a href="https://www.wipo.int/classifications/nice/nclpub/en/fr/"
                                           target="_blank" style="color: #4B57FF"> {{ trans('servicelable/servicelable.nice-classification') }} </a>
                                    </p>
                                    <input type="button" name="next" class="next action-button" value="{{ trans('servicelable/servicelable.next') }}"
                                           id="nextStep" style="pointer-events:none;background:#eee"/>
                                    <input type="button" name="previous" class="previous action-button-previous"
                                           value="{{ trans('servicelable/servicelable.previous') }}"/>
                                    <br>
                                    <h2 class="steps">{{ trans('servicelable/servicelable.step') }} 2 - 3</h2>
                                </fieldset>
                                <fieldset>
                                    <h2 id="heading">{{ trans('servicelable/servicelable.package-check') }}
                                    </h2>
                                    <hr>
                                    <div class="form-card checkout-page">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h5>{{ trans('servicelable/servicelable.package-type') }}</h5>
                                                <div><br>
                                                    <span class="checkout-btn">{{ trans('servicelable/servicelable.package-type') }} </span>
                                                    <span
                                                        class="checkout-data">{{  $package->package .' - '. $package->package_type}} </span>
                                                </div>
                                                <br>
                                                <h5>{{ trans('servicelable/servicelable.country') }}</h5>
                                                <div><br>
                                                    <span class="checkout-btn">{{ trans('servicelable/servicelable.country') }} </span>
                                                    <span
                                                        class="checkout-data">{{  $selectedCountry->country_name }} </span>
                                                </div>
                                            </div>
                                            <div class="col-md-6"><br>
                                                <h5>{{ trans('servicelable/servicelable.fast-search') }}</h5>
                                                <div>
                                                    <div class="form-group">
                                                        <label>
                                                            <input type="checkbox" name="fastSreach"
                                                                   class="my_form-control center-block"/>
                                                            {{ trans('servicelable/servicelable.results-h24') }} (+{{$fastSearch . $currencySymbol}})
                                                        </label>
                                                    </div>
                                                </div>
                                                @if(isset($nextPackageUpgradeFees) && $nextPackageUpgradeFees !== null)
                                                    <h5>{{ trans('servicelable/servicelable.upgrade-package') }}</h5>
                                                    <div>
                                                        <label>
                                                            <input type="checkbox" name="upgradePackage"
                                                                   value="{{$nextPackage->id}}"
                                                                   class="my_form-control center-block"/>
                                                            {{$nextPackage->package}} - {{$nextPackage->package_type}}
                                                            (+{{ $nextPackageUpgradeFees . $currencySymbol}})
                                                        </label>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <br><br>
                                        <p>{{ trans('servicelable/servicelable.upgrade-original-packages') }}</p>
                                    </div>
                                    <input type="submit" name="next" class="action-button" value="Review Order"/>
                                    <input type="button" name="previous" class="previous action-button-previous"
                                           value="{{ trans('servicelable/servicelable.previous') }}"/>
                                    <h2 class="steps mt-5">{{ trans('servicelable/servicelable.step') }} 3 - 3</h2>
                                </fieldset>
                            
                            </form>
                        </div>
                        <div class="progress mb-5">
                            <div class="progress-bar " role="progressbar" aria-valuemin="0" aria-valuemax="100">
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                </div>
            </div>
        </div>
    </main>
    <script>
        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
    <script>
        function validateNext() {
            var classes = document.getElementById('classes').value;
            if (classes.length > 0) {
                document.getElementById("nextStep").style.pointerEvents = 'auto';
                document.getElementById("nextStep").style.background = '#4B57FF';
            } else {
                document.getElementById("nextStep").style.pointerEvents = 'none';
                document.getElementById("nextStep").style.background = '#eee';
            }
        }

        $("#EnglishWordInput").on("keypress", function (event) {
            var englishAlphabetDigits = /^[A-Za-z0-9]*$/;
            var key = String.fromCharCode(event.which);
            if (event.keyCode == 32 || event.keyCode == 8 || event.keyCode == 37 || event.keyCode == 39 || englishAlphabetDigits.test(key)) {
                return true;    
            }
            return false;
        });

        $('#EnglishWordInput').on("paste", function (e) {
            e.preventDefault();
        });

        $("#ArabicWordInput").on("keypress", function (event) {
            var arabicAlphabetDigits = /[\u0600-\u06FF\u0750-\u077F]/;
            var key = String.fromCharCode(event.which);
            if (event.keyCode == 32 || event.keyCode == 8 || event.keyCode == 37 || event.keyCode == 39 || arabicAlphabetDigits.test(key)) {
                return true;
            }
            return false;
        });

        $('#ArabicWordInput').on("paste", function (e) {
            e.preventDefault();
        });

        function clickHere() {
            document.getElementById('overlay').style.display = 'none';
            document.getElementById('overlay2').style.display = 'block';
            document.getElementById('EnglishWordInput').value = '';
            document.getElementById('ArabicWordInput').value = '';
        }

        function clickHere2() {
            document.getElementById('overlay2').style.display = 'none';
            document.getElementById('overlay').style.display = 'block';
            document.getElementById('trademarkInputImg').value = '';
        }

        function clickArabicWord() {
            document.getElementById('ArabicWordInput').disabled = false;
            document.getElementById('EnglishWordInput').value = '';
        }

        function clickEnglishWord() {
            document.getElementById('EnglishWordInput').disabled = false;
            document.getElementById('ArabicWordInput').value = '';
        }
    </script>
@endsection
