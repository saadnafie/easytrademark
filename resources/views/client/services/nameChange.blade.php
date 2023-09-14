@extends('client.layouts.app')
@section('content')
    <main>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="steper">
                        <div class="card">
                            <form id="msform" role="form" method="post" action="{{route('store_nameChange_service')}}"
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
                                    <h2 id="heading">{{ trans('servicelable/servicelable.change-name') }}
                                    </h2>
                                    <hr>
                                    <div class="form-card">
                                        <div class="contactForm row">
                                            <div class="col-md-6 ">
                                                <h3 class="text-center"></h3>
                                                <div class="continer">
                                                    <div class="form-group">{{ trans('servicelable/servicelable.old-name') }}
                                                        <span data-toggle="tooltip" title="Old Name: is the name
                                            of the original holder of
                                            the registered
                                            trademark (the
                                            applicant), as per the
                                            certificate of
                                            registration."><i class="fa fa-exclamation-circle"
                                                              aria-hidden="true"></i></span>
                                                        <input type="text" name="oldName"
                                                               class="my_form-control center-block"
                                                               onkeyup="validateNextStepOne()" placeholder="Type"
                                                               id="oldName"
                                                               value="{{ old('oldName') }}"/>
                                                        <small class="my_place">
                                                        </small>
                                                    </div>
                                                    @if ($errors->has('oldName'))
                                                        <p class="alert alert-danger">{{ $errors->first('oldName') }}</p>
                                                    @endif
                                                </div>
                                                <br>
                                                <div class="continer">
                                                    <div class="form-group">{{ trans('servicelable/servicelable.new-name') }}
                                                        <span data-toggle="tooltip" title="New Name: New name
                                            refers to the name of the
                                            current owner of the
                                            trademark or (applicant)
                                            What is the name of the
                                            current owner of the
                                            trademark?"><i class="fa fa-exclamation-circle"
                                                           aria-hidden="true"></i></span>
                                                        <input type="text" name="newName"
                                                               onkeyup="validateNextStepOne()"
                                                               class="my_form-control center-block" placeholder="Type"
                                                               id="newName" value="{{ old('newName') }}"/>
                                                        <small class="my_place">
                                                        </small>
                                                    </div>
                                                    @if ($errors->has('newName'))
                                                        <p class="alert alert-danger">{{ $errors->first('newName') }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                            <br><br>
                                            <div class="col-md-6"><br><br>
                                                <div class="continer">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="button" name="next" class="next action-button" value="{{ trans('servicelable/servicelable.next') }}"
                                           id="nextStepOne" style="pointer-events:none;background:#eee"/>
                                    <h2 class="steps text-left">{{ trans('servicelable/servicelable.step') }} 1 - 3</h2>
                                </fieldset>
                                <fieldset>
                                    <h2 id="heading"> {{ trans('servicelable/servicelable.trademark-details') }}
                                    </h2>
                                    <hr>
                                    <div class="form-card">
                                        <div class="contactForm row">
                                            <div class="col-md-6 ">
                                                <br>
                                                <div class="form-group">{{ trans('servicelable/servicelable.image') }}
                                                    <span data-toggle="tooltip"
                                                          title="Whether the trademark is a wordmark or a logo, please upload the trademark in JPG format."><i
                                                            class="fa fa-exclamation-circle"
                                                            aria-hidden="true"></i></span>
                                                    <input type="file" name="trademarkImg"
                                                           class="my_form-control center-block" placeholder="Type"
                                                           id="imgFile"
                                                           onchange="validateNextStepTwo()"
                                                           accept="image/x-png,image/gif,image/jpeg"/><br>
                                                    <br> - MAX Size ( 30 MB )<br>
                                                    - PNG , JPEG , GIF
                                                    <small class="my_place"></small>
                                                </div>
                                                @if ($errors->has('trademarkImg'))
                                                    <p class="alert alert-danger">{{ $errors->first('trademarkImg') }}</p>
                                                @endif
                                            </div>
                                            <br><br>
                                            <div class="col-md-6">
                                                <div class="form-group"> {{ trans('servicelable/servicelable.filling-date') }}
                                                    <input type="date" name="fillingDate" id="fillingDate"
                                                           class="my_form-control  center-block"
                                                           onchange="validateNextStepTwo()" placeholder="Type"
                                                           value="{{ old('fillingDate') }}"/>
                                                    <small class="my_place"></small>
                                                </div>
                                                @if ($errors->has('fillingDate'))
                                                    <p class="alert alert-danger">{{ $errors->first('fillingDate') }}</p>
                                                @endif
                                                <br>
                                                <div class="form-group">{{ trans('servicelable/servicelable.filling-number') }}
                                                    <input type="text" name="fillingNumber" id="fillingNumber"
                                                           class="my_form-control center-block"
                                                           onkeyup="validateNextStepTwo()"
                                                           placeholder="Type" value="{{ old('fillingNumber') }}"/>
                                                    <small class="my_place"></small>
                                                </div>
                                                @if ($errors->has('fillingNumber'))
                                                    <p class="alert alert-danger">{{ $errors->first('fillingNumber') }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <input type="button" name="next" class="next action-button" value="{{ trans('servicelable/servicelable.next') }}"
                                           id="nextStepTwo" style="pointer-events:none;background:#eee"/>
                                    <input type="button" name="previous" class="previous action-button-previous"
                                           value="{{ trans('servicelable/servicelable.previous') }}"/>
                                    <h2 class="steps text-left">{{ trans('servicelable/servicelable.step') }} 2 - 3</h2>
                                </fieldset>
                                <fieldset>
                                    <h2 id="heading">{{ trans('servicelable/servicelable.package-check') }}
                                    </h2>
                                    <hr>
                                    <div class="form-card checkout-page">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h5> {{ trans('servicelable/servicelable.package-type') }}</h5>
                                                <div>
                                                    <span class="checkout-btn">{{ trans('servicelable/servicelable.package-type') }} </span>
                                                    <span
                                                        class="checkout-data">{{  $package->package .' - '. $package->package_type}} </span>
                                                </div>
                                                <br>
                                                <h5>{{ trans('servicelable/servicelable.country') }}</h5>
                                                <div>
                                                    <span class="checkout-btn">{{ trans('servicelable/servicelable.country') }} </span>
                                                    <span
                                                        class="checkout-data">{{  $selectedCountry->country_name}}</span>
                                                </div>
                                            </div>
                                            <div class="col-md-6"><br>
                                                <h5 style="display:none;">{{ trans('servicelable/servicelable.quick-turnaround') }}</h5>
                                                <div style="display:none;">
                                                    <div class="form-group">
                                                        <label>
                                                            <input type="checkbox" name="fastSreach"
                                                                   class="my_form-control center-block"/>
                                                           {{ trans('servicelable/servicelable.results-h24') }} (+{{ $quickTurnaround. '' .$currencySymbol }}
                                                            )
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
                                        <!--<p>{{ trans('servicelable/servicelable.upgrade-original-packages') }}</p>-->
                                    </div>
                                    <input type="submit" name="next" class="action-button" value="Review Order"/>
                                    <input type="button" name="previous" class="previous action-button-previous"
                                           value="{{ trans('servicelable/servicelable.previous') }}"/>
                                    <br>
                                    <h2 class="steps text-left">{{ trans('servicelable/servicelable.step') }} 3 - 3</h2>
                                </fieldset>

                                <div class="progress">
                                    <div class="progress-bar " role="progressbar" aria-valuemin="0" aria-valuemax="100">
                                    </div>
                                </div>
                            </form>
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
        var oldName = document.getElementById('oldName').value;
        var NewName = document.getElementById('newName').value;
        var fillingNumber = document.getElementById('fillingNumber').value;
        var fillingDate = document.getElementById('fillingDate').value;
        var imgFile = document.getElementById('imgFile');
        if (oldName.length > 0 && NewName.length > 0) {
            document.getElementById("nextStepOne").style.pointerEvents = 'auto';
            document.getElementById("nextStepOne").style.background = '#4B57FF';
        } else {
            document.getElementById("nextStepOne").style.pointerEvents = 'none';
            document.getElementById("nextStepOne").style.background = '#eee';
        }
        if (fillingNumber.length > 0 && fillingDate.length > 0 && imgFile.files.length > 0) {
            document.getElementById("nextStepTwo").style.pointerEvents = 'auto';
            document.getElementById("nextStepTwo").style.background = '#4B57FF';
        } else {
            document.getElementById("nextStepTwo").style.pointerEvents = 'none';
            document.getElementById("nextStepTwo").style.background = '#eee';
        }

        function validateNextStepOne() {
            var oldName = document.getElementById('oldName').value;
            var NewName = document.getElementById('newName').value;
            if (oldName.length > 0 && NewName.length > 0) {
                document.getElementById("nextStepOne").style.pointerEvents = 'auto';
                document.getElementById("nextStepOne").style.background = '#4B57FF';
            } else {
                document.getElementById("nextStepOne").style.pointerEvents = 'none';
                document.getElementById("nextStepOne").style.background = '#eee';
            }
        }

        function validateNextStepTwo() {
            var imgFile = document.getElementById('imgFile');
            var fillingNumber = document.getElementById('fillingNumber').value;
            var fillingDate = document.getElementById('fillingDate').value;
            if (fillingNumber.length > 0 && fillingDate.length > 0 && imgFile.files.length > 0) {
                document.getElementById("nextStepTwo").style.pointerEvents = 'auto';
                document.getElementById("nextStepTwo").style.background = '#4B57FF';
            } else {
                document.getElementById("nextStepTwo").style.pointerEvents = 'none';
                document.getElementById("nextStepTwo").style.background = '#eee';
            }
        }
		
		var oldValue = "";
		// listen for "input" event, since that handles all keypresses as well as cut/paste
		document.getElementById("fillingNumber").addEventListener('input', function (event) {
		  var input = event.target;
		  if (validateInput(input.value)) {
			// update old value with new value
			oldValue = input.value;
		  }
		  else {
			// set value to last known valid value
			input.value = oldValue;
		  }
		});

		function validateInput(str) {
		  // check length, if is a number, if is whole number, if no periods
		  return /^[0-9]{0,15}$/.test(str);
		}
    </script>
@endsection
