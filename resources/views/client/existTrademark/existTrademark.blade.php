@extends('client.layouts.app')
@section('content')



<style>
.form-control:disabled, .form-control[readonly] {
    background-color: white;
	
}
.input-group-text {
    background-color: #4B57FF;
	color: white;
}



.select2-container--default .select2-selection--multiple {
	margin-top: 15px;
	border:unset;
	border-bottom: 1px solid #aaa;
}
</style>
    <div class="profile">
        <div class="container">
		<br><br>
		 <div class="card bg-primary text-white">
			<div class="card-body">Complete Your Order</div>
		  </div>
          <br>
			  <div class="row">
			  
		  <div class="col-md-7">
		  
			<div class="card">
			  <div class="card-body">
			  <form method="post" id="msform1" name="msform1" role="form" action="{{route('create_order_existTM')}}" enctype="multipart/form-data" autocomplete="off">
			  @csrf
			  <input name="trademarkId" type="hidden" value="{{$currentTrademark->id}}">
			  <input name="countryPackageFeesID" type="hidden" value="{{ $serviceCntryPackage->id }}">
				<input name="packageID" type="hidden" value="{{$serviceCntryPackage->service_package->package->id}}">
				<input name="serviceId" type="hidden" value="{{$serviceCntryPackage->service_package->service->id}}">
				<input name="countryId" type="hidden" value="{{$serviceCntryPackage->country->id}}">
			  <!--------------------------Search Service Process ----------------------------------->
			  @if($serviceCntryPackage->service_package->service_id == 1)
			  <p><b>
					{{ trans('servicelable/servicelable.choose-the-class') }}
				</b></p>
			   @foreach ($allClasses as $index=>$class)
					<label class="checkbox-inline" style="display: inline-block">
						<input type="radio" value="{{ $class->class_id }}"
							      name="trademarkClasse" id="classes" {{ $index == 0 ? 'checked' : ''  }}>
						<span style="width: 27px;display: inline-block;">
					{{ $class->class_id }}
					</span>
					</label>
				@endforeach
				<br><br>
				<p><b>{{ trans('servicelable/servicelable.fast-search') }}</b></p>
					<input type="checkbox" name="fastSreach"> {{ trans('servicelable/servicelable.results-h24') }} (+ 50$)
                <br>
				@endif
				<!--------------------------Renewal Service Process ----------------------------------->
				@if($serviceCntryPackage->service_package->service_id == 3)
				<b>  {{ trans('servicelable/servicelable.filling-date') }}</b>
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
								  <br>
					<input type="date" name="fillingDate"
						   class="my_form-control  center-block" id="renewalfillingDate"
						   onchange="TDate();" value="{{ old('fillingDate') }}" style="width:100%;" required><br>
						   

				<br><br>
				<b>{{ trans('servicelable/servicelable.filling-number') }}</b>
					<span data-toggle="tooltip" title="Filing Number is the unique number
				 provided by the local trademark office
				 when submitting an application to file
				 a trademark. The filing number is
				 usually included on the top of a
				 certificate of registration."><i class="fa fa-exclamation-circle"
												  aria-hidden="true"></i></span><br>
					<input type="text" name="fillingNumber"
						   class="my_form-control center-block"
						   value="{{ old('fillingNumber') }}" placeholder="Type"
						   id="fillingNumber"  style="width:100%;" required><br>
						   <i style="font-size:11px;color:red;">Should enter Number only with length max 15 digit.</i>
	            <br><br><br>	
				@endif
				<!--------------------------Assignment Service Process ----------------------------------->
				@if($serviceCntryPackage->service_package->service_id == 4)
			   <b>{{ trans('servicelable/servicelable.assignor-name') }}</b>
						<span data-toggle="tooltip" title="Assignor Name: is the
					name of the original
					holder of the registered
					trademark, as per the
					certificate of
					registration."><i class="fa fa-exclamation-circle"
									  aria-hidden="true"></i></span><br>
						<input type="text" name="assignorName"
							   class="my_form-control center-block" id="assignorName" 
							   placeholder="Type" 
							   value="{{ old('assignorName') }}" style="width:100%;" required>
							   <i style="font-size:11px;color:red;">You should write letters only.</i>

					<br><br>
					<b>{{ trans('servicelable/servicelable.assignor-address') }}</b>
						<span data-toggle="tooltip" title="Assignor address: is the
					name of the original holder
					of the registered trademark,
					as per the certificate of
					registration."><i class="fa fa-exclamation-circle"
									  aria-hidden="true"></i></span><br>
						<input type="text" name="assignorAddress" onchange="alphanumeric(document.msform1.assignorAddress.value)"
							   class="my_form-control center-block" id="assignorAddress"
							   placeholder="Type" 
							   value="{{ old('assignorAddress') }}" style="width:100%;" required>
							  <!-- <i style="font-size:11px;color:red;">You should write Numbers and letters together only.</i>-->
				<br><br>
				<b>{{ trans('servicelable/servicelable.assignee-name') }}</b>
						<span data-toggle="tooltip" title="Assignee name: is the
					name of the individual or
					company whom the
					trademark rights are being
					transferred to. This name
					should be reflected on the
					power of attorney and the
					deed of assignment."><i class="fa fa-exclamation-circle"
											aria-hidden="true"></i></span><br>
						<input type="text" name="assigneeName" 
							   class="my_form-control center-block" id="assigneeName"
							   placeholder="Type" 
							   value="{{ old('assigneeName') }}" style="width:100%;" required>
							   <i style="font-size:11px;color:red;">You should write letters only.</i>

					<br><br>
					<b>{{ trans('servicelable/servicelable.assignee-address') }}</b>
						<span data-toggle="tooltip" title="Assignee address: is the
					address of the individual or
					company whom the
					trademark rights are being
					transferred to. This address
					should be reflected on the
					power of attorney and the
					deed of assignment."><i class="fa fa-exclamation-circle"
											aria-hidden="true"></i></span><br>
						<input type="text" name="assigneeAddress" onchange="alphanumeric(document.msform1.assigneeAddress.value)"
							   class="my_form-control  center-block" id="assigneeAddress"
							   placeholder="Type" 
							   value="{{ old('assigneeAddress') }}" style="width:100%;" required>
							   <!--<i style="font-size:11px;color:red;">You should write Numbers and letters together only.</i>-->

				<br><br>
				@endif
				
				<!--------------------------NameChange Service Process ----------------------------------->
				@if($serviceCntryPackage->service_package->service_id == 5)
				<b> {{ trans('servicelable/servicelable.old-name') }} </b> 
				<span data-toggle="tooltip" title="Old Name: is the name
					of the original holder of
					the registered
					trademark (the
					applicant), as per the
					certificate of
					registration."><i class="fa fa-exclamation-circle"
									  aria-hidden="true"></i></span><br>
				<input type="text" name="oldName"
									   class="my_form-control center-block"
									    placeholder="Type"
									   id="oldName"
									   value="{{ old('oldName') }}" style="width:100%;" required>
					
				<br><br>
				<b>{{ trans('servicelable/servicelable.new-name') }}</b>
				<span data-toggle="tooltip" title="New Name: New name
					refers to the name of the
					current owner of the
					trademark or (applicant)
					What is the name of the
					current owner of the
					trademark?"><i class="fa fa-exclamation-circle"
					   aria-hidden="true"></i></span><br>
				<input type="text" name="newName"
						   
						   class="my_form-control center-block" placeholder="Type"
						   id="newName" value="{{ old('newName') }}" style="width:100%;" required>
                <br><br>
				@endif
				
				<!--------------------------AddressChange Service Process ----------------------------------->
				@if($serviceCntryPackage->service_package->service_id == 6)
				<b>{{ trans('servicelable/servicelable.old-address') }}</b>
						<span data-toggle="tooltip" title="Old address: is the last
															address recorded at the
															trademark office.
															Usually included on the
															certificate of
															registration."><i class="fa fa-exclamation-circle"
									  aria-hidden="true"></i></span><br>
				<input type="text" name="oldAddress"
							   class="my_form-control center-block {{ $errors->has('oldAddress') ? ' is-invalid' : '' }}"
							   id="oldAddress" placeholder="Type"
							   
							   value="{{ old('oldAddress') }}" style="width:100%;" required>

				<br><br>
				<b>{{ trans('servicelable/servicelable.new-address') }}</b>
						<span data-toggle="tooltip" title="New address: New legal
															address of the current
															owner of the trademark
															(applicant). This should be
															reflected on the change of
															address document."><i class="fa fa-exclamation-circle"
										  aria-hidden="true"></i></span><br>
				<input type="text" name="newAddress"
							   class="my_form-control center-block {{ $errors->has('newAddress') ? ' is-invalid' : '' }}"
							   id="newAddress" placeholder="Type"
							   
							   value="{{ old('newAddress') }}" style="width:100%;" required>
                <br><br>
				@endif
				<!--------------------------Renewal - NameChange - AddressChange Service Process ----------------------------------->
				@if($serviceCntryPackage->service_package->service_id == 4 || $serviceCntryPackage->service_package->service_id == 5 || $serviceCntryPackage->service_package->service_id == 6)
			    <b>  {{ trans('servicelable/servicelable.filling-date') }}</b>
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
								  <br>
					<input type="date" name="fillingDate"
						   class="my_form-control  center-block" id="fillingDate"
						   onchange="TDateall()" value="{{ old('fillingDate') }}" style="width:100%;" required><br>
						   <!--<i style="font-size:11px;color:red;">Date should not be older than six months ago.</i>-->

				<br><br>
				<b>{{ trans('servicelable/servicelable.filling-number') }}</b>
					<span data-toggle="tooltip" title="Filing Number is the unique number
				 provided by the local trademark office
				 when submitting an application to file
				 a trademark. The filing number is
				 usually included on the top of a
				 certificate of registration."><i class="fa fa-exclamation-circle"
												  aria-hidden="true"></i></span><br>
					<input type="text" name="fillingNumber"
						   class="my_form-control center-block"
						   value="{{ old('fillingNumber') }}" placeholder="Type"
						   id="fillingNumber"  style="width:100%;" required><br>
						   <i style="font-size:11px;color:red;">Should enter Number only with length max 15 digit.</i>
	            <br><br><br>
				@endif
				<!--------------------------Registration Service Process ----------------------------------->
				
				@if($serviceCntryPackage->service_package->service_id == 2)
				<ul class="list-group">
					<li class="list-group-item list-group-item-info">{{ trans('servicelable/servicelable.trademark-details') }}</li>
				</ul>
				<br>
				<div class="row">
				<div class="col-md-6">
				<span style="color:red;">*</span> {{ trans('servicelable/servicelable.trademark-describe') }}
				<span data-toggle="tooltip"
					  title="The description does not have to be long."><i
						class="fa fa-exclamation-circle"
						aria-hidden="true"></i></span>
				<textarea type="file" name="brief"
						  
						  class="my_form-control center-block" id="brief"
						  placeholder="Limit to 3 sentences" style="width:100%;" required>{{($isRegExist != '')? $isRegExist->orders[0]->trademark_registration->brief : ''}}</textarea>
						  
				<br><br>		  
				  {{ trans('servicelable/servicelable.What-Language-your-trademark') }}<br><br>
				  @if($isRegExist != '')
					  @if($isRegExist->orders[0]->trademark_registration->isArabic == 1)
					 @php $langval = 4 ; @endphp
					 @else
						@php $langval = $isRegExist->orders[0]->trademark_registration->language_id ; @endphp 
					 @endif
					 
				  @else
					 @php $langval = 0 ; @endphp  
				  @endif
					<select name="language" id="LanguageID" class="my_form-control "
							
							onload="inArabicFunction()" style="width:100%;">
							  <option selected="true" disabled>Select language</option>
						@foreach ($allLanguages as $language)
							<option
								value="{{ $language->id }}" {{($language->id==$langval)?'selected':''}}>{{$language->language}}

							</option>
						@endforeach
					</select>
					
					</div>
					
					<div class="col-md-6">

					{{ trans('servicelable/servicelable.What-trademark-mean') }}
				<textarea name="explanation" id="explanation"
						  class="my_form-control center-block"
						  placeholder="Limit to 3 sentences"
						  onkeyup="hasMeaningFunction()"
						  onload="" style="width:100%;">{{($isRegExist != '')? $isRegExist->orders[0]->trademark_registration->explanation : ''}}</textarea>
				<br><br>	
						@if($isRegExist != '')
						 @php $colorval = $isRegExist->orders[0]->tm_color ; @endphp
					     <input type="hidden" value="{{$colorval}}" id="color_list">
						@else
							 @php $colorval = [] ; @endphp  
						    <input type="hidden"  id="color_list">
						@endif				
				<span style="margin-bottom: 15px;"> {{ trans('servicelable/servicelable.trademark-color') }}</span><br>
					
					<select
						class="js-example-basic-multiple"
						name="color[]"
						multiple="multiple"
						style="width: 100%;height: 46px;border: none;"
						id="trademarks_colors"  >			
						@foreach ($allColors as $color)
						<option value="{{$color->id}}">{{$color->color_name}}</option>	
						@endforeach
					</select>
					
					
					<br><br>
					</div>
					</div><!------------part-1----------------------->
				    <ul class="list-group">
					<li class="list-group-item list-group-item-info">{{ trans('servicelable/servicelable.claims') }}</li>
					</ul>
					<br>
					<div class="row">
					<div class="col-md-12">
					@if($isRegExist != '')
					 @php $claimval = $isRegExist->orders[0]->trademark_registration->claim_convention ; @endphp
					@else
						 @php $claimval = 0 ; @endphp  
					@endif
					{{ trans('servicelable/servicelable.trademark-claim-convention') }}
						<span data-toggle="tooltip"
							  title="To claim priority, you need to have a filing of the same trademark done in another country in less than a period of 6 months. The Paris Convention is an international agreement that grants the applicant the right to apply for protection of its trademark in any other Contracting Member within a period of 6 months from the date of filing. These subsequent applications will be regarded as if they have been filed on the same day as the first application, thus having priority over applications filed by others during the said period of time for the same trademark."><i
								class="fa fa-exclamation-circle"
								aria-hidden="true"></i></span>
					        <br>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<input class="form-check-input" type="radio"
								   name="claimConvention" id="noClaim" value="0" onclick="yesClaimTrig()" {{ $claimval == 0 ? 'checked' : ''  }}>
							<label class="form-check-label" for="noClaim">
								No
							</label>
							 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<input class="form-check-input" type="radio"
								   name="claimConvention" id="yesClaim" onclick="yesClaimTrig()" value="1" {{ $claimval == 1 ? 'checked' : ''  }}>
							<label class="form-check-label" for="yesClaim">
								Yes
							</label>
							<br><br>

					</div>
					</div>
					
					<div id="claimConvension_inputs" style="display: {{ $claimval == 1 ? 'block' : 'none'  }};">
					@php 
						$fillingNumberval = '' ; 
						$fillingDateval = '' ; 
						$fillingCountryval = 1 ; 
				    @endphp
					@if($isRegExist != '')
						
						@if($isRegExist->orders[0]->trademark_registration->claim_convention_filling != null)
					 @php 
						$fillingNumberval = $isRegExist->orders[0]->trademark_registration->claim_convention_filling->filling_number ; 
						$fillingDateval = $isRegExist->orders[0]->trademark_registration->claim_convention_filling->filling_date ; 
						$fillingCountryval = $isRegExist->orders[0]->trademark_registration->claim_convention_filling->country_id ; 
				    @endphp

					@endif
						
					@endif
					<div class="row">
					<div class="col-md-4">
					
							{{ trans('servicelable/servicelable.filling-number') }}
							<span data-toggle="tooltip"
								  title="Filing number of the filed or registered application as per the filing or registration application document."><i
									class="fa fa-exclamation-circle"
									aria-hidden="true"></i></span><br>
							<input type="text" name="fillingNumber" value="{{$fillingNumberval}}"
								   class="my_form-control center-block" placeholder="Type"
								   id="fillingNumber"  style="width:100%;"/>
						</div>	
					<div class="col-md-4">
						
							{{ trans('servicelable/servicelable.filling-date') }}
							<span data-toggle="tooltip"
								  title="The filing date of the priority application the mark is claiming priority to."><i
									class="fa fa-exclamation-circle"
									aria-hidden="true"></i></span><br>
							<input type="date" name="fillingDate" value="{{$fillingDateval}}"
								   class="my_form-control  center-block" placeholder="Type"
								   id="fillingDateReg" onchange="dateValidationRegSer();TDateRegSer();" style="width:100%;"/>
						</div>	
					<div class="col-md-4">	
							{{ trans('servicelable/servicelable.country') }}
							<span data-toggle="tooltip"
								  title="Country of the application priority is being claimed for."><i
									class="fa fa-exclamation-circle"
									aria-hidden="true"></i></span><br>
							<select name="country" class="my_form-control"
									id="fillingCountry"  style="width:100%;">
								@foreach ($allCountries as $country)
									<option
										value="{{ $country->id }}" {{ $fillingCountryval == $country->id ? 'selected' : ''  }}>{{$country->country}}
									</option>
								@endforeach
							</select>
						</div>	
					</div>
					
                    <br>
					</div><!------------part-2----------------------->
					<ul class="list-group">
					<li class="list-group-item list-group-item-info">{{ trans('servicelable/servicelable.applicant-details') }}</li>
					</ul>
					<br>
					<div class="row">
					<div class="col-md-6">
					@if($isRegExist != '')
					 @php $applicantTypeval = $isRegExist->orders[0]->trademark_registration->applicant_type_id ; @endphp
					@else
						 @php $applicantTypeval = 2 ; @endphp  
					@endif
					{{ trans('servicelable/servicelable.type-applicant') }}
					<select name="applicantType" class="my_form-control"
							id="isIndividual"
							onchange="javascript:isIndividuall();" style="width:100%;">
						@foreach ($allApplicantType as $type)

							<option value="{{ $type->id }}"
								{{ $type->id == $applicantTypeval ? 'selected' : ''  }}>
								{{ $type->type }}</option>
						@endforeach
					</select>
					<br><br>
					<!-------------------------other value input--------------------------------------->

					<div class="form-group" id="otherVal" style="display:{{ $applicantTypeval == 4 ? 'block' : 'none'  }};">
						please, insert type:
						<input type="text" name="othervalue" id="other_value" 
							   value="{{($isRegExist != '')? $isRegExist->orders[0]->trademark_registration->other_option_value : ''}}"
							   class="my_form-control center-block"
							   placeholder="Write Type of Applicant"
							    style="width:100%;"/>
					</div>
					<!----------------------------------------------------------------------------------->
					@if($isRegExist != '')
					 @php $Occupationval = $isRegExist->orders[0]->trademark_registration->applicant_occupation->id ; @endphp
					@else
						 @php $Occupationval = 1 ; @endphp  
					@endif
						{{ trans('servicelable/servicelable.applicant-occupation') }}
						<select name="applicantOccupation" class="my_form-control "
								id="applicantOccupation"  style="width:100%;">
					
							@foreach ($allApplicantOccupations as $ApplicantOccupation)
								<option value="{{$ApplicantOccupation->id}}" {{ $Occupationval == $ApplicantOccupation->id ? 'selected' : ''  }}>
									{{$ApplicantOccupation->occupation}}</option>
							@endforeach
						</select>	
						<br><br>
						<div  id="hasCompany" style="display:{{ ($applicantTypeval == 1) || ($applicantTypeval == 4) ? 'none' : 'block'  }};">
						{{ trans('servicelable/servicelable.Company-type') }}
						<select name="company" class="my_form-control "
								id="companyNameEnglish"  style="width:100%;">
							@foreach ($allCompanyType as $type)
								<option value="{{$type->id}}" {{ $type->id == 2 ? 'selected' : ''  }}>{{$type->type}}</option>
							@endforeach
						</select>
						</div>
						<br>
						
				</div>
				
				<div class="col-md-6">

					 {{ trans('servicelable/servicelable.applicant-name') }}
					<span data-toggle="tooltip"
						  title="Applicant name should be the legal name of the entity which would be the same as the one mentioned on the trade license, commercial certificate, or certificate of incorporation. The applicant name should also be included on the Power of Attorney document. It is very important that this information is entered accurately, uniformly and correctly. Differences between applicant address entered here and applicant address entered on power of attorney may cause an office action."><i
							class="fa fa-exclamation-circle"
							aria-hidden="true"></i></span>
					@if(old('applicantName') != '')
					<input type="text" name="applicantName"
						   class="my_form-control center-block"
						   value="{{ old('applicantName') }}" placeholder="Type"
						   id="applicantName"  style="width:100%;" required>
					@elseif($isRegExist != '')
					<input type="text" name="applicantName"
						   class="my_form-control center-block"
						   value="{{ $isRegExist->orders[0]->trademark_registration->applicant_name }}" placeholder="Type"
						   id="applicantName"  style="width:100%;" required>
					@else
					<input type="text" name="applicantName"
						   class="my_form-control center-block"
						   value="" placeholder="Type"
						   id="applicantName"  style="width:100%;" required>	
					@endif
						   
					<br><br>
					@if($isRegExist != '')
					 @php $nationalityval = $isRegExist->orders[0]->trademark_registration->nationality->id ; @endphp
					@else
						 @php $nationalityval = 1 ; @endphp  
					@endif
				   {{ trans('servicelable/servicelable.applicant-nationality') }}
					<select name="applicantNationality" class="my_form-control "
							id="applicantNationality"
							 style="width:100%;">
						@foreach ($allNationalities as $nationalty)
							<option value="{{$nationalty->id}}"
								{{ $nationalityval == $nationalty->id ? 'selected' : ''  }}>
								{{$nationalty->nationality}}</option>
						@endforeach
					</select>
					<br><br>
					 {{ trans('servicelable/servicelable.applicant-address') }}
					<span data-toggle="tooltip"
						  title="Applicant address should be the legal Address of the entity which would be the same as the one mentioned on the trade license, commercial certificate, or certificate of incorporation. The applicant address should also be included on the Power of Attorney document. It is very important that this information is entered accurately, uniformly and correctly. Differences between applicant  address entered here and applicant address entered on power of attorney may cause an office action."><i
							class="fa fa-exclamation-circle"
							aria-hidden="true"></i></span><br>
					@if(old('applicantAddress') != '')
					<input type="text" name="applicantAddress"
						   class="my_form-control center-block"
						   value="{{ old('applicantAddress') }}"
						   placeholder="Country , City , Street "
						   id="applicantAddress"  style="width:100%;margin-top: 15px;" required>
					@elseif($isRegExist != '')
					<input type="text" name="applicantAddress"
						   class="my_form-control center-block"
						   value="{{ $isRegExist->orders[0]->trademark_registration->applicant_address }}"
						   placeholder="Country , City , Street "
						   id="applicantAddress"  style="width:100%;margin-top: 15px;" required>
					@else
					<input type="text" name="applicantAddress"
						   class="my_form-control center-block"
						   value=""
						   placeholder="Country , City , Street "
						   id="applicantAddress"  style="width:100%;margin-top: 15px;" required>	
					@endif
					<br><br>	   
					

				</div>
				
				</div><!------------part-3----------------------->
					<ul class="list-group">
					<li class="list-group-item list-group-item-info">{{ trans('servicelable/servicelable.class') }}</li>
					</ul>
					<br>
				<div class="row">
					<div class="col-md-6">
					@if($isRegExist != '')
					 @php $classval = $isRegExist->trademark_country_classes[0]->class_id ; @endphp
					@else
						 @php $classval = 1 ; @endphp  
					@endif
					{{ trans('servicelable/servicelable.class') }}
						<select name="trademarkClasse" class="my_form-control" id="OneClass"
								onchange="getDescription()" style="width:100%;">
							@foreach ($allClasses as $class)
								<option value="{{ $class->class_id }}"
									{{ $classval == $class->class_id ? 'selected' : ''  }}>
									{{ $class->class_id }}</option>
							@endforeach
						</select>
						
					</div>
					
					<div class="col-md-6">
					{{ trans('servicelable/servicelable.specify-goods') }}
					<span data-toggle="tooltip"
						  title="The description does not have to be long."><i
							class="fa fa-exclamation-circle"
							aria-hidden="true"></i></span>
					<textarea name="serviceDescription" 
							  class="my_form-control center-block"
							  id="serviceDescription"
							  rows="1" placeholder="Limit to 10 sentences"
							  style="background: #f7f7f7;width:100%;" required>@if(old('serviceDescription') != '') {{ old('serviceDescription') }} @elseif($isRegExist != '') {{ $isRegExist->trademark_country_classes[0]->description }} @else @endif</textarea>
							  
							  
					</div>
					</div><!------------part-4----------------------->
					<hr>
				 <p class="text-left" style="font-size:12px;">{{ trans('servicelable/servicelable.classification-goods') }}
                                                <a href="https://www.wipo.int/classifications/nice/nclpub/en/fr/"
                                                   target="_blank" style="color: #4B57FF"> {{ trans('servicelable/servicelable.nice-classification') }} </a> </p>

				<p class="classDescription">
                                                </p>
				@endif
				
				
				
				<button type="submit"  class="btn btn-primary" style="float:right;width:auto;padding: 24px;">Review Order</button>
				</form>
				</div>
			  </div>

			</div>
			  <!---------------------------Trademark Details--------------------------------------------->
			  <div class="col-md-5">
			  <div class="jumbotron">
			    <div class="input-group mb-3" >
				<div class="input-group-prepend" >
				  <span class="input-group-text" style="width:80px;font-size:13px;">Reference</span>
				</div>
				<input type="text" value="{{$currentTrademark->trademark_reference }}" style="font-size:13px;" class="form-control" disabled>
			  </div>

			    <div class="input-group mb-3">
				<div class="input-group-prepend">
				  <span class="input-group-text" style="width:80px;font-size:13px;">TM Label</span>
				</div>
				<input type="text" value="{{$currentTrademark->trademark_label }}" class="form-control" style="font-size:13px;" disabled>
			  </div>

			    <div class="input-group mb-3">
				<div class="input-group-prepend">
				  <span class="input-group-text" style="width:80px;font-size:13px;">Service</span>
				</div>
				<input type="text" value="{{$serviceCntryPackage->service_package->service->service_name}}" class="form-control" style="font-size:13px;" disabled>
			  </div>

			    <div class="input-group mb-3">
				<div class="input-group-prepend">
				  <span class="input-group-text" style="width:80px;font-size:13px;">Country</span>
				</div>
				<input type="text" value="{{$serviceCntryPackage->country->country_name}}" class="form-control" style="font-size:13px;" disabled>
			  </div>

			    <div class="input-group mb-3">
				<div class="input-group-prepend">
				  <span class="input-group-text" style="width:80px;font-size:13px;">Package</span>
				</div>
				<input type="text" value="{{$serviceCntryPackage->service_package->package->package}} {{$serviceCntryPackage->service_package->package->package_type}}" style="font-size:12px;" class="form-control" disabled>
			  </div>
			  </div>
			  
			  </div>
			  
			  
		      </div>
			  
			  

            <br><br>
    </div>
	</div>
	
	<script>
	

	
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


    
    function isIndividuall() {
            if (document.getElementById('isIndividual').value == 1) {
                document.getElementById('hasCompany').style.display = 'none';
				document.getElementById('otherVal').value = '';
				document.getElementById('otherVal').style.display = 'none';
				
            } else if(document.getElementById('isIndividual').value == 4){
                document.getElementById('hasCompany').style.display = 'none';
				document.getElementById('otherVal').style.display = 'block';
            }else{
				document.getElementById('hasCompany').style.display = 'block';
				document.getElementById('otherVal').value = '';
				document.getElementById('otherVal').style.display = 'none';
				
			}
        }
		
		
		function yesClaimTrig() {
            if (document.getElementById('yesClaim').checked) {
                document.getElementById('claimConvension_inputs').style.display = 'block';
            } else {
                document.getElementById('claimConvension_inputs').style.display = 'none';
                document.getElementById('fillingCountry').value = '';
                document.getElementById('fillingNumber').value = '';
                document.getElementById('fillingDate').value = '';
            }
        }
		
		
		
		// fetch class description
        function getDescription() {
            let classId = document.getElementById('OneClass').value;
            $.ajax({
                url: '{{ \LaravelLocalization::localizeURL('getClassDescription') }}' + '/' + classId,
                dataType: 'json',
                type: 'GET',
                cache: false,
                async: true,
                success: function (data) {
                    $('.classDescription').html('<i>' + data['class_brief_' + locale] + '</i>');
                },
                error: function (jqXhr, textStatus, errorThrown) {
                    console.log(errorThrown);
                    alert(errorThrown);
                }
            })
        }
		
		
		
		$(document).ready(function () {
		
		//$('.js-example-basic-multiple').select2();
       if(document.getElementById('color_list'))		
		var colorlist = document.getElementById('color_list').value;
		
		if(colorlist != null){
		var s2 = $("#trademarks_colors").select2({
			placeholder: "Choose color",
			tags: true
		});
        
		
		var vals = JSON.parse(colorlist);//["Gold", "Gray"];
		var vals2 = vals.map(a => a.id);
		var vals3 = vals.map(a => a.color_name_en);
		//console.log(vals2);
		
		vals.forEach(function(e){
		console.log(e);
		//s2.append($('<option>').text(e.color_name_en));
		//s2.append($('<option>').val(e.id));
			s2.val(vals2).trigger("change"); 
		});
		
		/*var vals = ["Trade Fair", "CA", "Party", "Black"];JSON.parse(colorlist);//
		vals.forEach(function(e){
		if(!s2.find('option:contains(' + e + ')').length) 
		  s2.append($('<option>').text(e));
		});

		s2.val(vals).trigger("change"); */
		
		
		}

		});
		
		
		
		
		function TDate() {
			var UserDate = document.getElementById("renewalfillingDate").value;
			var ToDate = new Date();

			console.log(new Date(UserDate).getTime());
			console.log(ToDate.getTime());

			if (new Date(UserDate).getTime() >= ToDate.getTime()) {
				  
				  alert("The Date must be less or Equal to today date");
				  document.getElementById("renewalfillingDate").value = '';
				  return false;
			 }
			return true;
}

function TDateRegSer() {
			var UserDate = document.getElementById("fillingDateReg").value;
			var ToDate = new Date();

			console.log(new Date(UserDate).getTime());
			console.log(ToDate.getTime());

			if (new Date(UserDate).getTime() >= ToDate.getTime()) {
				  
				  alert("The Date must be less or Equal to today date");
				  document.getElementById("fillingDateReg").value = '';
				  return false;
			 }
			return true;
}

function dateValidationRegSer() {
        var b = document.getElementById("fillingDateReg").value; //your input date here
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
			document.getElementById("fillingDateReg").value = '';
			document.getElementById("nextStepTwo").style.pointerEvents = 'none';
            document.getElementById("nextStepTwo").style.background = '#eee';
        }
    }
	
	
	
	function validateInput(str) {
		  // check length, if is a number, if is whole number, if no periods
		  return /^[0-9]{0,15}$/.test(str);
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
	
	
	function TDateall() {
			var UserDate = document.getElementById("fillingDate").value;
			var ToDate = new Date();

			console.log(new Date(UserDate).getTime());
			console.log(ToDate.getTime());

			if (new Date(UserDate).getTime() >= ToDate.getTime()) {
				  
				  alert("The Date must be less or Equal to today date");
				  document.getElementById("fillingDate").value = '';
				  return false;
			 }
			return true;
}
	</script>

@endsection
