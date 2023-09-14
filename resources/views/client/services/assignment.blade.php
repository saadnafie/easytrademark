@extends('client.layouts.app')
@section('content')
    <main>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="steper">
                        <div class="card">
                            <form id="msform" name="msform" role="form" method="post" action="{{route('store_assignment_service')}}"
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
                                    <h2 id="heading"> {{ trans('servicelable/servicelable.assignment-details') }}
                                        <span data-toggle="tooltip" title="When the effective owner of a trademark is changed,
                                    an assignment needs to be recorded, showing the
                                    initial owner (Assignor), and the new owner
                                    (Assignee)."><i class="fa fa-exclamation-circle" aria-hidden="true"></i></span>
                                    </h2>
                                    <hr>
                                    <div class="form-card">
                                        <div class="contactForm row">
                                            <div class="col-md-6 ">
                                                <div class="form-group">{{ trans('servicelable/servicelable.assignor-name') }}
                                                    <span data-toggle="tooltip" title="Assignor Name: is the
                                                name of the original
                                                holder of the registered
                                                trademark, as per the
                                                certificate of
                                                registration."><i class="fa fa-exclamation-circle"
                                                                  aria-hidden="true"></i></span>
                                                    <input type="text" name="assignorName"
                                                           class="my_form-control center-block" id="assignorName" 
                                                           placeholder="Type" onkeyup="validateNextStepOne()"
                                                           value="{{ old('assignorName') }}"/>
														   <i style="font-size:11px;color:red;">You should write letters only.</i>
                                                    <small class="my_place">
                                                    </small>
                                                </div>
                                                @if ($errors->has('assignorName'))
                                                    <p class="alert alert-danger">{{ $errors->first('assignorName') }}</p>
                                                @endif
                                                <br>
                                                <div class="form-group">{{ trans('servicelable/servicelable.assignor-address') }}
                                                    <span data-toggle="tooltip" title="Assignor address: is the
                                                name of the original holder
                                                of the registered trademark,
                                                as per the certificate of
                                                registration."><i class="fa fa-exclamation-circle"
                                                                  aria-hidden="true"></i></span>
                                                    <input type="text" name="assignorAddress" onchange="alphanumeric(document.msform.assignorAddress.value)"
                                                           class="my_form-control center-block" id="assignorAddress"
                                                           placeholder="Type" onkeyup="validateNextStepOne()"
                                                           value="{{ old('assignorAddress') }}"/>
														  <!-- <i style="font-size:11px;color:red;">You should write Numbers and letters together only.</i>-->
                                                    <small class="my_place">
                                                    </small>
                                                </div>
                                                @if ($errors->has('assignorAddress'))
                                                    <p class="alert alert-danger">{{ $errors->first('assignorAddress') }}</p>
                                                @endif
                                            </div>
                                            <br><br>
                                            <div class="col-md-6">
                                                <div class="form-group">{{ trans('servicelable/servicelable.assignee-name') }}
                                                    <span data-toggle="tooltip" title="Assignee name: is the
                                                name of the individual or
                                                company whom the
                                                trademark rights are being
                                                transferred to. This name
                                                should be reflected on the
                                                power of attorney and the
                                                deed of assignment."><i class="fa fa-exclamation-circle"
                                                                        aria-hidden="true"></i></span>
                                                    <input type="text" name="assigneeName" 
                                                           class="my_form-control center-block" id="assigneeName"
                                                           placeholder="Type" onkeyup="validateNextStepOne()"
                                                           value="{{ old('assigneeName') }}"/>
														   <i style="font-size:11px;color:red;">You should write letters only.</i>
                                                    <small class="my_place">
                                                    </small>
                                                </div>
                                                @if ($errors->has('assigneeName'))
                                                    <p class="alert alert-danger">{{ $errors->first('assigneeName') }}</p>
                                                @endif
                                                <br>
                                                <div class="form-group">{{ trans('servicelable/servicelable.assignee-address') }}
                                                    <span data-toggle="tooltip" title="Assignee address: is the
                                                address of the individual or
                                                company whom the
                                                trademark rights are being
                                                transferred to. This address
                                                should be reflected on the
                                                power of attorney and the
                                                deed of assignment."><i class="fa fa-exclamation-circle"
                                                                        aria-hidden="true"></i></span>
                                                    <input type="text" name="assigneeAddress" onchange="alphanumeric(document.msform.assigneeAddress.value)"
                                                           class="my_form-control  center-block" id="assigneeAddress"
                                                           placeholder="Type" onkeyup="validateNextStepOne()"
                                                           value="{{ old('assigneeAddress') }}"/>
														   <!--<i style="font-size:11px;color:red;">You should write Numbers and letters together only.</i>-->
                                                    <small class="my_place">
                                                    </small>
                                                </div>
                                                @if ($errors->has('assigneeAddress'))
                                                    <p class="alert alert-danger">{{ $errors->first('assigneeAddress') }}</p>
                                                @endif
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
                                                <div class="form-group">{{ trans('servicelable/servicelable.upload-trademark-assign') }}
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
                                                <div class="form-group">
                                                    {{ trans('servicelable/servicelable.filling-date') }}
                                                    <input type="date" name="fillingDate"
                                                           class="my_form-control  center-block" id="fillingDate"
                                                           placeholder="Type" onchange="validateNextStepTwo();TDate()"
                                                           value="{{ old('fillingDate') }}"/>
														   <!--<i style="font-size:11px;color:red;">Date should not be older than six months ago.</i>-->
                                                    <small class="my_place"></small>
                                                </div>
                                                @if ($errors->has('fillingDate'))
                                                    <p class="alert alert-danger">{{ $errors->first('fillingDate') }}</p>
                                                @endif
                                                <br>
                                                <div class="form-group">{{ trans('servicelable/servicelable.filling-number') }}
                                                    <input type="text" name="fillingNumber" id="fillingNumber"
                                                           class="my_form-control center-block" placeholder="Type"
                                                           onkeyup="validateNextStepTwo()"
                                                           value="{{ old('fillingNumber') }}"/>
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
                                                <h5>{{ trans('servicelable/servicelable.package-type') }}</h5>
                                                <div>
                                                    <span class="checkout-btn">{{ trans('servicelable/servicelable.package-type') }} </span>
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
        var assignorName = document.getElementById('assignorName').value;
        var assignorAddress = document.getElementById('assignorAddress').value;
        var assigneeName = document.getElementById('assigneeName').value;
        var assigneeAddress = document.getElementById('assigneeAddress').value;
        var imgFile = document.getElementById('imgFile');
        if (assignorName.length > 0 && assignorAddress.length > 0 && assigneeName.length > 0 && assigneeAddress.length >
            0) {
            document.getElementById("nextStepOne").style.pointerEvents = 'auto';
            document.getElementById("nextStepOne").style.background = '#4B57FF';
        } else {
            document.getElementById("nextStepOne").style.pointerEvents = 'none';
            document.getElementById("nextStepOne").style.background = '#eee';
        }
        var fillingNumber = document.getElementById('fillingNumber').value;
        var fillingDate = document.getElementById('fillingDate').value;
        if (fillingNumber.length > 0 && fillingDate.length > 0 && imgFile.files.length > 0) {
            document.getElementById("nextStepTwo").style.pointerEvents = 'auto';
            document.getElementById("nextStepTwo").style.background = '#4B57FF';
        } else {
            document.getElementById("nextStepTwo").style.pointerEvents = 'none';
            document.getElementById("nextStepTwo").style.background = '#eee';
        }

        function validateNextStepOne() {
            var assignorName = document.getElementById('assignorName').value;
            var assignorAddress = document.getElementById('assignorAddress').value;
            var assigneeName = document.getElementById('assigneeName').value;
            var assigneeAddress = document.getElementById('assigneeAddress').value;
            if (assignorName.length > 0 && assignorAddress.length > 0 && assigneeName.length > 0 && assigneeAddress.length >
                0) {
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
		
		
		//-------------------------------filling date validation-----------------------------------
		function dateValidation() {
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
    }
	
	//-------------------------------text validation-----------------------------------
			function alphanumeric(inputtxt)
			{
				if (/[a-zA-Z]/.test(inputtxt)) {
				return true;
				}else if (/\d/.test(inputtxt) && /[a-zA-Z]/.test(inputtxt)) {
				return true;
				}else{
					//document.msform.assignorName.focus();
					 alert("You should enter letters and numbers");
					 document.getElementById("assignorAddress").value = '';
					 document.getElementById("assigneeAddress").value = '';
					 document.getElementById("nextStepOne").style.pointerEvents = 'none';
                     document.getElementById("nextStepOne").style.background = '#eee';
					return false;
				}
				/*if (!/^[a-zA-Z]*$/g.test(inputtxt)) {
					alert("Invalid characters");
					document.msform.assignorName.focus();
					return false;
				}*/
				
				/*var letterNumber = /^[0-9a-zA-Z]+$/;
				if((inputtxt.value.match(letterNumber)){
				   return true;
				}else{ 
				   alert("message"); 
				   return false; 
				}*/
			}
			
	$(document).ready(function(){
    $("#assignorName").keypress(function(event){
        var inputValue = event.charCode;
        if(!(inputValue >= 65 && inputValue <= 120) && (inputValue != 32 && inputValue != 0)){
            event.preventDefault();
        }
    });
	
	$("#assigneeName").keypress(function(event){
        var inputValue = event.charCode;
        if(!(inputValue >= 65 && inputValue <= 120) && (inputValue != 32 && inputValue != 0)){
            event.preventDefault();
        }
    });
});

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
