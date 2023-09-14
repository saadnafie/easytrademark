@extends('client.layouts.app')
@section('content')
    <main>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="steper">
                        <div class="card">
                            <form id="msform" role="form" method="post" action="{{route('finalRegistrationStore')}}"
                                  enctype="multipart/form-data" autocomplete="off">
                                @csrf
                                <input name="countryId" type="hidden" value="{{ $country->id }}">
                                <input name="trademarkCountryId" type="hidden" value="{{ $trademarkCountryId}}">
                                <input name="trademarkId" type="hidden" value="{{ $trademarkId}}">
                                <fieldset>
                                    <h2 id="heading">Final Registration and issuance of certificate
                                    </h2>
                                    <hr>
                                    <div class="form-card">
                                        <div class="contactForm row">
                                            <div class="col-md-6 ">
                                                <div class="form-group">{{ trans('servicelable/servicelable.filling-date') }}
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
                                                    <input type="date" name="fillingDate" disabled
                                                           class="my_form-control  center-block" id="fillingDate"
                                                           value="{{$trademarkFilling->filling_date}}"/>
                                                    <small class="my_place"></small>
                                                </div>
                                                <br>
                                                <div class="form-group">{{ trans('servicelable/servicelable.filling-number') }}
                                                    <span data-toggle="tooltip" title="Filing Number is the unique number
                                                 provided by the local trademark office
                                                 when submitting an application to file
                                                 a trademark. The filing number is
                                                 usually included on the top of a
                                                 certificate of registration."><i class="fa fa-exclamation-circle"
                                                                                  aria-hidden="true"></i></span>
                                                    <input type="text" name="fillingNumber" disabled
                                                           class="my_form-control center-block"
                                                           value="{{$trademarkFilling->filling_number}}"
                                                           id="fillingNumber"/>
                                                    <small class="my_place"></small>
                                                </div>
                                            </div>
                                            <br><br>
                                            <div class="col-md-6">
                                            </div>
                                        </div>
                                    </div>
                                    <input type="button" name="next" class="next action-button" value="{{ trans('servicelable/servicelable.next') }}"
                                    />
                                    <h2 class="steps text-left">{{ trans('servicelable/servicelable.step') }} 1 - 2</h2>
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
                                                    <span>
                                                          <select name="package" id="" class="my_form-control"
                                                                  onchange="" style="width: 50%">
                                                                    @foreach($packages as $package)
                                                                  <option value="{{$package->id}}">{{$package->package->package}} - ( {{ $package->fee  }} ) + ( {{ $package->country_package_fees->fees  }} ) </option>
                                                              @endforeach
                                                          </select>
                                                    </span>
                                                </div>
                                                <br>
                                                <h5>{{ trans('servicelable/servicelable.country') }}</h5>
                                                <div>
                                                    <span class="checkout-btn">{{ trans('servicelable/servicelable.country') }} </span>
                                                    <span class="checkout-data">{{$country->country_name}}</span>
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
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <br><br>
                                    </div>
                                    @if(Auth::check())
                                        <input type="submit" name="next" class="action-button" value="Review Order"/>
                                    @endif
                                    <input type="button" name="previous" class="previous action-button-previous"
                                           value="{{ trans('servicelable/servicelable.previous') }}"/>
                                    <br>
                                    <h2 class="steps text-left">{{ trans('servicelable/servicelable.step') }} 2 - 2</h2>
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
