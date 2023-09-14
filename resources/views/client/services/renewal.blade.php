@extends('client.layouts.app')
@section('content')
    <main>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="steper">
                        <div class="card">
                            <form id="msform" role="form" method="post" action="{{route('store_renewal_service')}}"
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
                                    <h2 id="heading">{{ trans('servicelable/servicelable.trademark-renewal') }}
                                    </h2>
                                    <hr>
                                    <div class="form-card">
                                        <div class="contactForm row">
                                            <div class="col-md-6 ">
                                                <br>
                                                <div class="form-group">{{ trans('servicelable/servicelable.upload-trademark-renew') }}

                                                    <span data-toggle="tooltip"
                                                          title="Whether the trademark is a wordmark or a logo, please upload the trademark in JPG format."><i
                                                            class="fa fa-exclamation-circle"
                                                            aria-hidden="true"></i></span>
                                                    <input type="file" name="trademarkImg"
                                                           class="my_form-control center-block" placeholder="Type"
                                                           id="imgFile"
                                                           onchange="validateNext()"
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
                                                <div class="form-group">  {{ trans('servicelable/servicelable.filling-date') }}
                                                    <span data-toggle="tooltip" title="Filing date: the date the
                                                trademark was first
                                                filed. Some countries
                                                also use protection
                                                period start date
                                                interchangeably for
                                                filing date. This is
                                                usually shown on the
                                                top of the certificate of
                                                registration."><i class="fa fa-exclamation-circle"
                                                                  aria-hidden="true"></i></span>
                                                    <input type="date" name="fillingDate"
                                                           class="my_form-control  center-block" id="fillingDate"
                                                           onchange="validateNext();TDate();" value="{{ old('fillingDate') }}"/>
														   <!--<i style="font-size:11px;color:red;">Date should not be older than six months ago.</i>-->
                                                    <small class="my_place"></small>
                                                </div>
                                                @if ($errors->has('fillingDate'))
                                                    <p class="alert alert-danger">{{ $errors->first('fillingDate') }}</p>
                                                @endif
                                                <br>
                                                <div class="form-group">{{ trans('servicelable/servicelable.filling-number') }}
                                                    <span data-toggle="tooltip" title="Filing Number is the unique number
                                                 provided by the local trademark office
                                                 when submitting an application to file
                                                 a trademark. The filing number is
                                                 usually included on the top of a
                                                 certificate of registration."><i class="fa fa-exclamation-circle"
                                                                                  aria-hidden="true"></i></span>
                                                    <input type="text" name="fillingNumber"
                                                           class="my_form-control center-block"
                                                           value="{{ old('fillingNumber') }}" placeholder="Type"
                                                           id="fillingNumber" onkeyup="validateNext()"/><br>
														    <i style="font-size:11px;color:red;">Should enter Number only with length max 15 digit.</i>
                                                    <small class="my_place"></small>
                                                </div>
                                                @if ($errors->has('fillingNumber'))
                                                    <p class="alert alert-danger">{{ $errors->first('fillingNumber') }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <input type="button" name="next" class="next action-button" value="{{ trans('servicelable/servicelable.next') }}"
                                           id="nextStep"
                                           style="pointer-events:none;background:#eee"/>
                                    <h2 class="steps mt-4">{{ trans('servicelable/servicelable.step') }} 1 - 2</h2>
                                </fieldset>
                                <fieldset>
                                    <h2 id="heading">{{ trans('servicelable/servicelable.package-check') }}
                                    </h2>
                                    <hr>
                                    <div class="form-card checkout-page">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h5>{{ trans('servicelable/servicelable.package-type') }}</h5>
                                                <div>
                                                    <span class="checkout-btn">{{ trans('servicelable/servicelable.package-type') }}</span>
                                                    <span
                                                        class="checkout-data"> {{  $package->package .' - '. $package->package_type}}  </span>
                                                </div>
                                                <br>
                                                <h5>{{ trans('servicelable/servicelable.country') }}</h5>
                                                <div>
                                                    <span class="checkout-btn">{{ trans('servicelable/servicelable.country') }} </span>
                                                    <span
                                                        class="checkout-data">{{ $selectedCountry->country_name }}</span>
                                                </div>
                                            </div>
                                            <div class="col-md-6"><br>
                                                <h5 style="display:none;">{{ trans('servicelable/servicelable.quick-turnaround') }} </h5>
                                                <div style="display:none;">
                                                    <div class="form-group">
                                                        <label>
                                                            <input type="checkbox" name="fastSreach"
                                                                   class="my_form-control center-block"/>
                                                            {{ trans('servicelable/servicelable.results-h24') }}
                                                            (+{{ $quickTurnaroundCost. '' .$currencySymbol }})
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
                                        <br>
                                        <!--<p>{{ trans('servicelable/servicelable.upgrade-original-packages') }}</p>-->
                                    </div>
                                    <input type="submit" name="next" class="action-button" value="Review Order"/>
                                    <input type="button" name="previous" class="previous action-button-previous"
                                           value="{{ trans('servicelable/servicelable.previous') }}"/>
                                    <br>
                                    <h2 class="steps">{{ trans('servicelable/servicelable.step') }} 2 - 2</h2>
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
        var imgFile = document.getElementById('imgFile');
        var fillingNumber = document.getElementById('fillingNumber').value;
        var fillingDate = document.getElementById('fillingDate').value;
        if (fillingNumber.length > 0 && fillingDate.length > 0 && imgFile.files.length > 0) {
            document.getElementById("nextStep").style.pointerEvents = 'auto';
            document.getElementById("nextStep").style.background = '#4B57FF';
        } else {
            document.getElementById("nextStep").style.pointerEvents = 'none';
            document.getElementById("nextStep").style.background = '#eee';
        }

        function validateNext() {
            var imgFile = document.getElementById('imgFile');
            var fillingNumber = document.getElementById('fillingNumber').value;
            var fillingDate = document.getElementById('fillingDate').value;
            if (fillingNumber.length > 0 && fillingDate.length > 0 && imgFile.files.length > 0) {
                document.getElementById("nextStep").style.pointerEvents = 'auto';
                document.getElementById("nextStep").style.background = '#4B57FF'
            } else {
                document.getElementById("nextStep").style.pointerEvents = 'none';
                document.getElementById("nextStep").style.background = '#eee';
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
		
		//-------------------------------filling date validation-----------------------------------
		/*function dateValidation() {
        var b = document.getElementById("fillingDate").value; //your input date here
        console.log(b);
        var d = new Date(); // today date
        d.setMonth(d.getMonth() - 6);  //subtract 6 month from current date 
		
		var dd = d.getDate();
		var mm = d.getMonth()+1; 
		var yyyy = d.getFullYear();
		
		d = yyyy+'-'+mm+'-'+dd;
		
		console.log(d);


		 //var validDate = d.toLocaleDateString();

        if (b >= d) {
            //alert("date is less than 6 month");
        } else {
            alert("Date should not be older than six months ago.");
			document.getElementById("fillingDate").value = '';
			document.getElementById("nextStepTwo").style.pointerEvents = 'none';
            document.getElementById("nextStepTwo").style.background = '#eee';
        }
    }*/
	
	function TDate() {
			var UserDate = document.getElementById("fillingDate").value;
			var ToDate = new Date();

			console.log(new Date(UserDate).getTime());
			console.log(ToDate.getTime());

			if (new Date(UserDate).getTime() >= ToDate.getTime()) {
				  
				  alert("The Date must be less or Equal to today date");
				  document.getElementById("fillingDate").value = '';
				  document.getElementById("nextStep").style.pointerEvents = 'none';
				  document.getElementById("nextStep").style.background = '#eee';
				  return false;
			 }
			return true;
}
    </script>
@endsection
