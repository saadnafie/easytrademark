@extends('client.layouts.app')
<head><meta name="csrf-token" content="{{ csrf_token() }}"></head>
@section('content')
    <div class="checkout-page">
        <div class="container">
            <h2 class="text-center mt-5">Cart </h2>
            <hr class="mb-5">
            <div class="row mb-4">
                <div class="col-md-6 mb-4">
                    <span class="checkout-btn">Reference NO </span>
                </div>
                <div class="col-md-6 mb-4">
                    <span class="checkout-data2">
                        {{$trademark->trademark_reference}}
                    </span>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-6 mb-4">
                    <span class="checkout-btn"> Label </span>
                    </div>
                <div class="col-md-6 mb-4">
                    <span class="checkout-data2">
                        {{$trademark->trademark_label}}
                    </span>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-6 mb-4">
                    <span class="checkout-btn">Service </span>
                    </div>
                <div class="col-md-6 mb-4">
                    <span class="checkout-data2">
                        {{$order->service_package->service->service_name}}
                    </span>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-6 mb-4">
                    <span class="checkout-btn">Package </span>
                    </div>
                <div class="col-md-6 mb-4">
                    <span class="checkout-data2">
                        {{$order->service_package->package->package}} {{$order->service_package->package->package_type}}
                    </span>
                </div>
            </div>
            <br><br>
            @foreach($order->trademark_country_order as $index=>$data)
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <span class="checkout-btn">Country </span>
                                </div>
                            <div class="col-md-6 mb-4">
                                <span class="checkout-data2">{{$data->trademark_country->country->country_name}}</span>
                            </div>
                            
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <span class="checkout-btn">
                                    @if($order->service_package->service->id == 1 )
                                        Fast Search
                                    @else
                                        Expedited results
                                    @endif
                                </span>
                                </div>
                <div class="col-md-6 mb-4">
                                <span class="checkout-data2">
                                         {{  $data->trademark_country->isFast == 1 ? 'Yes' : 'No' }}
										 @if($data->trademark_country->isFast == 1)
										 <span class="totalFees text-right">
                                              50 $
                                         </span>
										 @endif
                                </span>
                            </div>
                
                        </div>
						
						
                        @if($order->service_package->service->id == 1 || $order->service_package->service->id == 2 )
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    @if(isset($data->trademark_country->trademark_country_classes) )
                                        <span class="checkout-btn">Classes</span>
                                </div>
                                <div class="col-md-6">

                                        <span class="checkout-data2">
                                             @foreach($data->trademark_country->trademark_country_classes as $index1=>$class)
                                                {{$class->class_id}}
                                                @if($index1 !=0)
                                                    <sup>
                                                        <a href="{{ url('/delete/class/').'/'. $class->class_id.'/'. $data->trademark_country->id . '/'.$order->id}}">
                                                            <i style="color:#f00" class="fa fa-times"
                                                               aria-hidden="true"></i>
                                                        </a>
                                                    </sup>
                                                @endif,
                                            @endforeach
                                         <span class="totalFees text-right">
                                              {{ $data->trademark_country->sub_total_currency  }} {{ $currencySymbol}}
                                         </span>
                                      </span>
                                    @endif
                                </div>
                            </div>
                        @endif
						<div class="col-md-12">
                                @if($index !=0)
                                    <a href="{{ url('/delete/country/').'/'. $data->trademark_country->id.'/'.$order->id }}" class="checkout-discard">
                                        Delete
                                    </a>
                                @endif
                        </div>
						

                    </div>
                </div><br>
            @endforeach
            @if(($order->service_package->service->id != 7) && ($order->service_package->service->id != 8))
                <button type="button" class="float-right  add-c-c" data-toggle="modal" data-target="#country">
                    @if($order->service_package->service->id == 1 || $order->service_package->service->id == 2 )
                        Add Country/Class
                    @else
                        Add Country
                    @endif
                </button>
                <br><br>
                <div class="modal fade" id="country" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                     aria-hidden="true">
                    <div class="modal-dialog modal-md" style="margin-top: 180px;" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Add Country</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-card">
                                    <form method="POST" name="myForm" onsubmit="return validateForm()" action="{{route('addAnotherCountry')}}">
                                        @csrf
                                        <input type="hidden" name="trademarkId" value="{{ $trademark->id   }}">
                                        <input type="hidden" name="orderId" value="{{ $order->id   }}">
                                        <input type="hidden" name="servicePackageId"
                                               value="{{ $order->service_package_id   }}">
                                        <input type="hidden" name="trademarkCountryId" value="{{ $data->id   }}">
										 <div class="contactForm row">
                                            <div class="col-md-6 ">
                                        <div class="form-group" id="">
                                            Select Country
                                            <select name="anotherCountry" id="CountryClass" class="my_form-control"
                                                    onchange="getClasses()" >
													<option value="0" selected="true" disabled>
                                                    </option>
                                                @foreach ($allCountries as $country)
                                                    <option value="{{ $country->id }}">{{$country->country_name}}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <small class="my_place">
                                            </small>
                                        </div>
										</div>
										</div>
										@if($order->service_package->service->id == 3 || $order->service_package->service->id == 4 || $order->service_package->service->id == 5 || $order->service_package->service->id == 6)
										 <div class="contactForm row">
                                            <div class="col-md-6 ">
										 <div class="form-group"> {{ trans('servicelable/servicelable.filling-date') }}
                                                    <input type="date" name="fillingDate" id="fillingDate"
                                                           class="my_form-control  center-block"
                                                           onchange="dateValidation();"  required>
                                                    <small class="my_place"></small>
                                                </div>
												</div>
                                                 <div class="col-md-6 ">
                                                <div class="form-group">{{ trans('servicelable/servicelable.filling-number') }}
                                                    <input type="text" name="fillingNumber" id="fillingNumber"
                                                           class="my_form-control center-block" onkeyup="" required>
                                                    <small class="my_place"></small>
                                                </div>
												</div>
												</div>
										@endif
                                        @if($order->service_package->service->id == 1 || $order->service_package->service->id == 2 )
                                            <hr>
											<i style="color:red;font-size:11px">Select the country first, then choose the class</i><br>
                                            Classes:<br>
                                            <div class="allClasses">
                                            </div>
                                        @endif
                                        <hr>
										@if($order->service_package->service->id == 1)
                                        <h5>
                                            @if($order->service_package->service->id == 1 )
                                                Fast Search
                                            @else
                                                Expedited results
                                            @endif
                                        </h5>
                                        <div>
                                            <div class="form-group">
                                                <input type="checkbox" name="fastSearch" style="width: 6%"
                                                       class="my_form-control"/>Results in 24h
                                            </div>
                                        </div>
										@endif
                                        <div class="modal-footer">
                                            <button type="button" class="add-c-c" data-dismiss="modal">Close</button>
                                            <button  type="submit" class="add-c-c">Add Country</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <hr>
            <div class="row mb-4">
                <div class="col-md-6">
                    @if($order->discount_id == null)
                    <span >Your Promo Code:</span><br>
                      <input type="text" class="form-control" id="discount-code"><br>
                    <button id="apply-discount" onclick="required_discount()" class="btn btn-bottom">Apply discount</button>
                    @else
                        <span  style="color: green;" id="applied-discount">{{ $order->discount->discount_code }}</span> &nbsp;
                        <button id="cancel-applied-discount"
                                style="background-color: red;border-radius:30px;width:30px;height:30px;border: 1px solid rgba(0,0,0,.125);cursor: pointer;"
                        value="{{ $order->user_discount_history->id }}"> <i class="fa fa-trash" ></i></button>
                    @endif
                </div>
                <div class="col-md-6">
					<span>Sub-Total<b></b> </span>
                    <span style="float:right;">
					 @if($order->service_package->service->id == 7 || $order->service_package->service->id == 8)
					 {{$order->total_fees - round(($order->total_fees * .035 ) / 1.035,2) }} $
					 @else
					 {{  $data->trademark_country->sub_total  }} {{ $currencySymbol}}
					 @endif
                    </span>
					<br><br>
					<span>Expedite Fees<b></b> </span>
                    <span style="float:right;">
                        @if($data->trademark_country->isFast == 1)    
						50 $ 
						@else 
						00.00 $ 
						@endif
                    </span>
					<br><br>
				    <span>Payment Processing Fees<b></b> </span>
                    <span style="float:right;">
                            {{ round(($order->total_fees * .035 ) / 1.035,2) }} $
                    </span>
					<br><br>
                    @if($isDefaultCurrency == false)
                        <span>Total </span>
                        <span style="float:right;">
                            {{$order->total_fees_currency}} {{ $currencySymbol}}
                        </span>
						<br><br>
                    @endif
                    <span>Total (USD)<b></b> </span>
                    <span style="float:right;">
                            {{$order->total_fees}} {{\App\Utility\AllowedCurrencies::SYSTEM_DEFAULT_CURRENCY_SYMBOL}}
                    </span>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-6">

                </div>
                <div class="col-md-6">
				    <br>
                    @if($order->discount_id !== null)
                        <span>Total After Discount (USD)</span>
                        <span style="float:right;">
                            {{$order->final_fees_after_discount }} {{ \App\Utility\AllowedCurrencies::SYSTEM_DEFAULT_CURRENCY_SYMBOL}}
                        </span>
                    @endif
                </div>
            </div>

            <hr>
			<div class="alert alert-success">
			  <strong>Success!</strong> Please accept Terms so You can continue with payment.</a>.
			</div>
			
			<div class="row mb-5">
                <div class="col-md-6">
                    <input type="checkbox" onchange="termsBtn()" id="checkTerms"> I have read, understand, and agree
                    to
                    the <a href="{{url('terms-of-service')}}" target="_blank">Terms of Service</a> and <a
                        href="{{url('terms-of-use')}}" target="_blank">Terms of use</a>
                </div>
                <br>
                <div class="col-md-6">
                </div>
            </div>
			

            <div class="row mb-4">
                <div class="col-md-6">
					@if( $data->trademark_country->isFast == 1)
                    <p class="hint"> Expedite Fees have been applied as you checked the expedited service </p>
					@else
					<p class="hint"> Expedite Fees will be applied if you checked fast or expedite service </p>
					@endif
                    <br>
                    <p class="hint"> Additional Payment Processing Fees (3.5%) have been added to the total which is paid as credit card transaction fees</p>
                </div>
                <br>
                <div class="col-md-6">
                    <!--<input type="text" id="discount-code">
                    <button id="apply-discount" class="btn btn-bottom">apply discount</button>
                    <p id="applied-discount" style="color: red"></p>
                    <button id="cancel-applied-discount" style="background-color: red" disabled hidden>X</button>
                    @if($isDefaultCurrency == false)
                        <span class="checkout-total">Total </span>
                        <span class="checkout-data">
                            {{$order->total_fees_currency . $currencySymbol}}
                        </span>
                    @endif
                    <span class="checkout-total">Total (USD)<b></b> </span>
                    <span class="checkout-data">
                            {{$order->total_fees . \App\Utility\AllowedCurrencies::SYSTEM_DEFAULT_CURRENCY_SYMBOL}}
                    </span>-->
                </div>
            </div>
            
            <div class="row mb-5">
                <div class="col-md-6 mb-5">
                    <img class="img-fluid" src="{{ asset('public/assets/img/hero/checkout.png')}}" ><br><br>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img class="img-fluid" src="{{ asset('public/img/Alipay_logo.png')}}" width="200px">&nbsp;&nbsp;|&nbsp;&nbsp;
					<img class="img-fluid" src="{{ asset('public/img/wechat3.png')}}" width="200px">
                </div>
            
                <div class="col-md-6 text-right checkout-buttons">

                    <a href="{{ url('/delete/order/').'/'.$order->id.'/'.$trademark->id }}"
                       class="checkout-discard"> Discard </a>
                    @if(isset($order->id))
                        <a href="{{ url('/selectpayment').'/'.$order->id.'/true/0'}}"
                           class="checkout-discard" id="payBtn" style="pointer-events:none;background:#eee">Go To
                            Pay</a>
                    @endif

                </div>
            </div>
        </div>
		
    </div>
    <script>
        window.onload = function () {
            getClasses();
        };

        function getClasses() {
            var countryId = document.getElementById("CountryClass").value;
            $.ajax({
                url: '{{ \LaravelLocalization::localizeURL('getClasses') }}' + '/' + countryId + '/' + {{$order->id}},
                dataType: 'json',
                type: 'GET',
                cache: false,
                async: true,
                success: function (data) {
                    $('.allClasses').html("");
                    for (var i = 0; i < data.length; i++) {
                        $('.allClasses').html($('.allClasses').html() + `
                        <label class="checkbox-inline" style="display: inline-block">
                        <input type="radio" value="${data[i].class_id}" id="classes" name="anotherClass"  required>
                        <span style="width: 27px;display: inline-block;"> ${data[i].class_id}</span> </label>`);
                    }
                },
                error: function (jqXhr, textStatus, errorThrown) {
                    console.log(errorThrown);
                    alert(errorThrown);
                }
            })
        }

        function termsBtn() {
            if (document.getElementById('checkTerms').checked) {
                document.getElementById("payBtn").style.pointerEvents = 'auto';
                document.getElementById("payBtn").style.background = '#4B57FF';
            } else {
                document.getElementById("payBtn").style.pointerEvents = 'none';
                document.getElementById("payBtn").style.background = '#eee';
            }
        }

        if (document.getElementById('checkTerms').checked) {
            document.getElementById("payBtn").style.pointerEvents = 'auto';
            document.getElementById("payBtn").style.background = '#4B57FF';
        } else {
            document.getElementById("payBtn").style.pointerEvents = 'none';
            document.getElementById("payBtn").style.background = '#eee';
        }

        $('#apply-discount').on('click', function () {
            let token = $("meta[name='csrf-token']").attr("content");
            $.ajax(
                {
                    url: '{{  \LaravelLocalization::localizeURL('/applyDiscount') }}' ,
                    dataType: "JSON",
                    type: 'POST',
                    data: {
                        '_token': token,
                        'discount-code': $('#discount-code').val(),
                        'order-id': {{ $order->id }}
                    },
                    success: function (response){
                        location.reload(true);
                    },
                    error: function (error) {
                        error = error.responseJSON
                        console.log(error.message)
						alert(error.message)
                    }
                })
        })
        $('#cancel-applied-discount').on('click', function () {
            let token = $("meta[name='csrf-token']").attr("content");
            $.ajax(
                {
                    url: '{{\LaravelLocalization::localizeURL('/cancelDiscount')}}' + '/' + this.value ,
                    dataType: "JSON",
                    type: 'DELETE',
                    data: {
                        '_token': token,
                    },
                    success: function (){
                        location.reload(true);
                    }
                })
        })
		
		
		
		

    </script>
	<script>

			function validateForm() {
		  var x = document.forms["myForm"]["anotherCountry"].value;
		  console.log(x);
		  if (x == 0) {
			alert("Please select a Country and then proceed.");
			return false;
		  }
		}
	// If the length of the element's string is 0 then display helper message 
   function required_discount() 
   {
     if (document.getElementById("discount-code").value.length == 0)
      { 
         alert("Enter Promo Code!");  	
         return false; 
      }  	
    } 

	//-------------------------------fillingNumber validation-----------------------------------
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
        }
    }
	</script>
@endsection
