@extends('client.layouts.app')
@section('content')
    <style>
        .bootstrap-select .bs-ok-default::after {
            width: 0.3em;
            height: 0.6em;
            border-width: 0 0.1em 0.1em 0;
            transform: rotate(45deg) translateY(0.5rem);
        }

        .btn.dropdown-toggle:focus {
            outline: none !important;
        }
    </style>
    <main>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="steper">
                        <div class="card">
                            <form id="msform" role="form" method="post" action="{{route('store_registration_service')}}"
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
                                    <h2 id="heading">{{ trans('servicelable/servicelable.trademark-details') }}
                                    </h2>
                                    <hr>
                                    <div class="form-card">
                                        <div class="contactForm row">
                                            <div class="col-md-4">
                                                <div class="continer">
                                                    <div class="form-group">
                                                        {{ trans('servicelable/servicelable.upload-trademark') }}
                                                        <span data-toggle="tooltip"
                                                              title="Whether the trademark is a wordmark or a logo, please upload the trademark in JPG format."><i
                                                                class="fa fa-exclamation-circle"
                                                                aria-hidden="true"></i></span>
                                                        <input type="file" name="trademarkImg"
                                                               class="my_form-control center-block" placeholder="Type"
                                                               id="imgFile" onchange="validateNextStepOne()"
                                                               accept="image/x-png,image/gif,image/jpeg"/><br>
                                                        <span style="color:red;font-size:11px;"> MAX Size (30 MB) - [PNG, JPEG, GIF]</span>
                                                        
                                                        <small class="my_place"> </small>
                                                    </div>
                                                    @if ($errors->has('trademarkImg'))
                                                        <p class="alert alert-danger">{{ $errors->first('trademarkImg') }}</p>
                                                    @endif
                                                    <br>
                                                    <div class="form-group">
                                                        {{ trans('servicelable/servicelable.trademark-describe') }}
                                                        <span data-toggle="tooltip"
                                                              title="The description does not have to be long."><i
                                                                class="fa fa-exclamation-circle"
                                                                aria-hidden="true"></i></span>
                                                        <textarea type="file" name="brief"
                                                                  onkeyup="validateNextStepOne()"
                                                                  class="my_form-control center-block" id="brief"
                                                                  placeholder="Limit to 3 sentences">{{ old('brief') }}</textarea>
                                                        <small class="my_place"> </small>
                                                    </div>
                                                    @if ($errors->has('brief'))
                                                        <p class="alert alert-danger">{{ $errors->first('brief') }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                            <br><br>
                                            <div class="col-md-4">
                                                <div class="continer">
                                                    {{ trans('servicelable/servicelable.trademark-meaning') }}
                                                    <span data-toggle="tooltip"
                                                          title="If the trademark has a meaning in the dictionary of the official language of the mark please add it."><i
                                                            class="fa fa-exclamation-circle"
                                                            aria-hidden="true"></i></span>
                                                    <div class="form-check text-left">
                                                        <input class="form-check-input" type="radio" name="isMeaning"
                                                               id="hasMeaning"
                                                               {{ old('isMeaning') == 'yes' ? 'checked' : ''  }} value="yes"
                                                               onclick="hasMeaningFunction();validateNextStepOne()"
                                                               onkeyup="">
                                                        <label class="form-check-label" for="hasMeaning">
                                                            Yes
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="isMeaning"
                                                               id="noMeaning"
                                                               {{ old('isMeaning') == 'no' ? 'checked' : ''  }}
                                                               value="no"
                                                               onclick="hasMeaningFunction();validateNextStepOne()"
                                                               onkeyup="">
                                                        <label class="form-check-label" for="noMeaning">
                                                            No
                                                        </label>
                                                    </div>
                                                    @if ($errors->has('isMeaning'))
                                                        <p class="alert alert-danger">{{ $errors->first('isMeaning') }}</p>
                                                    @endif
                                                    <br>
                                                </div>
                                                <br>
                                                <div class="continer">
												{{--
                                                    {{ trans('servicelable/servicelable.trademark-arabic') }}
                                                    <span data-toggle="tooltip"
                                                          title="If the trademark consists of more than 1 language whether Arabic is included or not, please choose No and select all the applicable languages. ">
                                                            <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                                                        </span>
                                                    <div class="form-check text-left">
                                                        <input class="form-check-input"
                                                               type="radio"
                                                               name="isArabic"
                                                               {{ old('isArabic') == 'yes' ? 'checked' : ''  }}
                                                               id="inArabic"
                                                               value="yes"
                                                               onclick="inArabicFunction();validateNextStepOne()"
                                                               onkeyup="">
                                                        <label class="form-check-label" for="inArabic">
                                                            Yes
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input"
                                                               type="radio"
                                                               name="isArabic"
                                                               {{ old('isArabic') == 'no' ? 'checked' : ''  }}
                                                               id="noArabic"
                                                               value="no"
                                                               onclick="inArabicFunction();validateNextStepOne()"
                                                               onkeyup="">
                                                        <label class="form-check-label" for="noArabic">
                                                            No
                                                        </label>
                                                    </div>
                                                    @if ($errors->has('isArabic'))
                                                        <p class="alert alert-danger">{{ $errors->first('isArabic') }}</p>
                                                    @endif
													--}}
                                                    <br> <br> 
													
													<div class="form-group"  > <!-- id="hasLanguage" -->
                                                       {{ trans('servicelable/servicelable.What-Language-your-trademark') }}<br><br>
                                                        <select name="language" id="LanguageID" class="my_form-control "
                                                                onchange="validateNextStepOne()"
                                                                onload="inArabicFunction()">

                                                             <option selected="true" value="0" disabled>Select language</option>
                                                            @foreach ($allLanguages as $language)
                                                                <option
                                                                    value="{{ $language->id }}" >{{$language->language}}

                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <small class="my_place">
                                                        </small>
                                                    </div>
													<br> <br> 
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="continer">
                                                    <div style="display:none" id="hasExplanation">
                                                        <div class="form-group">
                                                            {{ trans('servicelable/servicelable.What-trademark-mean') }}
                                                            <textarea name="explanation" id="explanation"
                                                                      class="my_form-control center-block"
                                                                      placeholder="Limit to 3 sentences"
                                                                      onkeyup="validateNextStepOne();hasMeaningFunction()"
                                                                      onload=""></textarea>
                                                            <small class="my_place"> </small>
                                                        </div>
                                                    </div>
                                                    <br><br>
                                                    {{--<div class="form-group"  id="hasLanguage">
                                                       {{ trans('servicelable/servicelable.What-Language-your-trademark') }}
                                                        <select name="language" id="LanguageID" class="my_form-control "
                                                                onchange="validateNextStepOne()"
                                                                onload="inArabicFunction()">

                                                           
                                                            @foreach ($allLanguages as $language)
                                                                <option
                                                                    value="{{ $language->id }}" {{($language->id==4)?'selected':''}}>{{$language->language}}

                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <small class="my_place">
                                                        </small>
                                                    </div>--}}
                                                </div>
                                            </div>
                                            <br><br>
                                        </div>
                                    </div>
                                    <hr>
                                    <input type="button" name="next" class="next action-button text-center" value="{{ trans('servicelable/servicelable.next') }}"
                                           id="nextStepOne" style="pointer-events:none;background:#eee"/>
                                    <h2 class="steps text-left">{{ trans('servicelable/servicelable.step') }} 1 - 5</h2>
                                </fieldset>
                                <fieldset>
                                    <h2 id="heading"> {{ trans('servicelable/servicelable.claims') }}
                                    </h2>
                                    <hr>
                                    <div class="form-card">
                                        <div class="contactForm row">
                                            <div class="col-md-6">
                                                <div class="continer">
                                                    {{ trans('servicelable/servicelable.trademark-color') }}
                                                    <span data-toggle="tooltip"
                                                          title="Claiming the colors of your trademark is making sure that no one infringes your trademark with its specific colors."><i
                                                            class="fa fa-exclamation-circle"
                                                            aria-hidden="true"></i></span>
                                                    <div class="form-check text-left">
                                                        <input class="form-check-input" type="radio" name="isColor"
                                                               id="yesCheck"
                                                               {{ old('isColor') == 'yes' ? 'checked' : ''  }}
                                                               value="yes"
                                                               onclick="javascript:yesnoCheck();javascript:validateNextStepTwo()"
                                                               style="margin-left: -268px;">
                                                        <label class="form-check-label" for="exampleRadios1111">
                                                            Yes
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="isColor"
                                                               id="noCheck"
                                                               {{ old('isColor') == 'no' ? 'checked' : ''  }}
                                                               value="no"
                                                               onclick="javascript:yesnoCheck();javascript:validateNextStepTwo()"
                                                               style="margin-left: -268px;">
                                                        <label class="form-check-label" for="noCheck">
                                                            No
                                                        </label>
                                                    </div>
                                                    @if ($errors->has('isColor'))
                                                        <p class="alert alert-danger">{{ $errors->first('isColor') }}</p>
                                                    @endif
                                                    <br>
                                                </div>
                                                <br>
                                                <div class="continer">
                                                    {{ trans('servicelable/servicelable.trademark-claim-convention') }}
                                                    <span data-toggle="tooltip"
                                                          title="To claim priority, you need to have a filing of the same trademark done in another country in less than a period of 6 months. The Paris Convention is an international agreement that grants the applicant the right to apply for protection of its trademark in any other Contracting Member within a period of 6 months from the date of filing. These subsequent applications will be regarded as if they have been filed on the same day as the first application, thus having priority over applications filed by others during the said period of time for the same trademark."><i
                                                            class="fa fa-exclamation-circle"
                                                            aria-hidden="true"></i></span>
                                                    <div class="form-check text-left">
                                                        <input class="form-check-input" type="radio"
                                                               name="claimConvention"
                                                               {{ old('claimConvention') == 'yes' ? 'checked' : ''  }}
                                                               id="yesClaim" value="yes"
                                                               onclick="javascript:yesClaimTrig();javascript:validateNextStepTwo()"
                                                               style="margin-left: -268px;">
                                                        <label class="form-check-label" for="jkjk">
                                                            Yes
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                               name="claimConvention"
                                                               {{ old('claimConvention') == 'no' ? 'checked' : ''  }}
                                                               id="noClaim" value="no"
                                                               onclick="javascript:yesClaimTrig();javascript:validateNextStepTwo()"
                                                               style="margin-left: -268px;">
                                                        <label class="form-check-label" for="noClaim">
                                                            No
                                                        </label>
                                                    </div>
                                                    @if ($errors->has('claimConvention'))
                                                        <p class="alert alert-danger">{{ $errors->first('claimConvention') }}
                                                        </p>
                                                    @endif
                                                    <br>
                                                </div>
                                            </div>
                                            <br><br>
                                            <div class="col-md-6">
                                                <div class="form-group" style=" display: none;" id="ifYes">
                                                    {{ trans('servicelable/servicelable.select-colors') }}
                                                    <select
                                                        class="js-example-basic-multiple"
                                                        name="color[]"
                                                        multiple="multiple"
                                                        style="width: 60%;height: 46px;border: none"
                                                        onchange="validateNextStepTwo()"
                                                        id="trademarks_colors"
                                                    >
                                                        @foreach ($allColors as $color)
                                                            <option
                                                                value="{{ $color->id }}"
                                                                {{ old('trademarkClasse') == $color->id ? 'checked' : ''  }}
                                                            >{{$color->color_name}}</option>
                                                        @endforeach
                                                    </select>
                                                    <script>
                                                        $(document).ready(function () {
                                                            $('.js-example-basic-multiple').select2();
                                                        });
                                                    </script>
                                                </div>
                                                <div id="claimConvension_inputs" style="display: none">
                                                    <div class="form-group ">
                                                        {{ trans('servicelable/servicelable.filling-number') }}
                                                        <span data-toggle="tooltip"
                                                              title="Filing number of the filed or registered application as per the filing or registration application document."><i
                                                                class="fa fa-exclamation-circle"
                                                                aria-hidden="true"></i></span>
                                                        <input type="text" name="fillingNumber"
                                                               class="my_form-control center-block" placeholder="Type"
                                                               id="fillingNumber" onkeyup="validateNextStepTwo()"/>
                                                        <small class="my_place">
                                                        </small>
                                                    </div>
                                                    <div class="form-group">
                                                        {{ trans('servicelable/servicelable.filling-date') }}
                                                        <span data-toggle="tooltip"
                                                              title="The filing date of the priority application the mark is claiming priority to."><i
                                                                class="fa fa-exclamation-circle"
                                                                aria-hidden="true"></i></span>
                                                        <input type="date" name="fillingDate"
                                                               class="my_form-control  center-block" placeholder="Type"
                                                               id="fillingDate" onchange="validateNextStepTwo();dateValidation();TDate();"/>
															   <i style="font-size:11px;color:red;">Date should not in the future and no more than 6 months in the past.</i>
                                                        <small class="my_place">
                                                        </small>
                                                        @if ($errors->has('fillingDate'))
                                                            <p class="alert alert-danger">{{ $errors->first('fillingDate') }}</p>
                                                        @endif
                                                    </div>
                                                    <div class="form-group">
                                                        {{ trans('servicelable/servicelable.country') }}
                                                        <span data-toggle="tooltip"
                                                              title="Country of the application priority is being claimed for."><i
                                                                class="fa fa-exclamation-circle"
                                                                aria-hidden="true"></i></span>
                                                        <select name="country" class="my_form-control"
                                                                id="fillingCountry" onchange="validateNextStepTwo()">
                                                            <option value=""></option>
                                                            @foreach ($allCountries as $country)
                                                                <option
                                                                    value="{{ $country->id }}">{{$country->country}}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <small class="my_place"> </small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="button" name="next" class="next action-button" value="{{ trans('servicelable/servicelable.next') }}"
                                           id="nextStepTwo" style="pointer-events:none;background:#eee"/>
                                    <input type="button" name="previous" class="previous action-button-previous"
                                           value="{{ trans('servicelable/servicelable.previous') }}"/>
                                    <h2 class="steps text-left">{{ trans('servicelable/servicelable.step') }} 2 - 5</h2>
                                </fieldset>
                                <fieldset>
                                    <h2 id="heading">  {{ trans('servicelable/servicelable.applicant-details') }}
                                    </h2>
                                    <hr>
                                    <div class="form-card">
                                        <div class="contactForm row">
                                            <div class="col-md-6 ">
                                                <div class="form-group">
                                                    {{ trans('servicelable/servicelable.type-applicant') }}
                                                    <select name="applicantType" class="my_form-control"
                                                            id="isIndividual"
                                                            onchange="javascript:isIndividuall();validateNextStepThree()">
                                                        <option value=""></option>
                                                        @foreach ($allApplicantType as $type)

                                                            <option value="{{ $type->id }}"
                                                                {{ old('applicantType') == $type->id ? 'selected' : ''  }}>
                                                                {{ $type->type }}</option>
                                                        @endforeach
                                                    </select>
                                                    <small class="my_place"></small>
                                                </div>
                                                @if ($errors->has('applicantType'))
                                                    <p class="alert alert-danger">{{ $errors->first('applicantType') }}</p>
                                                @endif
												<!-------------------------other value input--------------------------------------->
												<div class="form-group" id="otherVal" style="display:none;">
                                                    please, insert type:
                                                    <input type="text" name="othervalue" id="other_value"
                                                           class="my_form-control center-block"
                                                           placeholder="Write Type of Applicant"
                                                           onkeyup="validateNextStepThree()"/>
                                                    <small class="my_place"></small>
                                                </div>
												<!----------------------------------------------------------------------------------->
                                                <div class="form-group">
                                                    {{ trans('servicelable/servicelable.applicant-occupation') }}
                                                    <select name="applicantOccupation" class="my_form-control "
                                                            id="applicantOccupation" onchange="validateNextStepThree()">
                                                        <option value=""></option>
                                                        @foreach ($allApplicantOccupations as $ApplicantOccupation)
                                                            <option value="{{$ApplicantOccupation->id}}"
                                                                {{ old('applicantOccupation') == $ApplicantOccupation->id ? 'selected' : ''  }}>
                                                                {{$ApplicantOccupation->occupation}}</option>
                                                        @endforeach
                                                    </select>
                                                    <small class="my_place"></small>
                                                </div>
                                                @if ($errors->has('applicantOccupation'))
                                                    <p class="alert alert-danger">{{ $errors->first('applicantOccupation') }}
                                                    </p>
                                                @endif
                                                <div class="form-group" id="hasCompany">
                                                    {{ trans('servicelable/servicelable.Company-type') }}
                                                    <select name="company" class="my_form-control "
                                                            id="companyNameEnglish" onchange="validateNextStepThree()">
                                                        <option value=""></option>
                                                        @foreach ($allCompanyType as $type)
                                                            <option value="{{$type->id}}">{{$type->type}}</option>
                                                        @endforeach
                                                    </select>
                                                    <small class="my_place"></small>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                   {{ trans('servicelable/servicelable.applicant-name') }}
                                                    <span data-toggle="tooltip"
                                                          title="Applicant name should be the legal name of the entity which would be the same as the one mentioned on the trade license, commercial certificate, or certificate of incorporation. The applicant name should also be included on the Power of Attorney document. It is very important that this information is entered accurately, uniformly and correctly. Differences between applicant address entered here and applicant address entered on power of attorney may cause an office action."><i
                                                            class="fa fa-exclamation-circle"
                                                            aria-hidden="true"></i></span>
                                                    <input type="text" name="applicantName"
                                                           class="my_form-control center-block"
                                                           value="{{ old('applicantName') }}" placeholder="Type"
                                                           id="applicantName" onkeyup="validateNextStepThree()"/>
                                                    <small class="my_place"></small>
                                                </div>
                                                @if ($errors->has('applicantName'))
                                                    <p class="alert alert-danger">{{ $errors->first('applicantName') }}</p>
                                                @endif
                                                <div class="form-group">
                                                    {{ trans('servicelable/servicelable.applicant-nationality') }}
                                                    <select name="applicantNationality" class="my_form-control "
                                                            id="applicantNationality"
                                                            onchange="validateNextStepThree()">
                                                        <option value=""></option>
                                                        @foreach ($allNationalities as $nationalty)
                                                            <option value="{{$nationalty->id}}"
                                                                {{ old('applicantNationality') == $nationalty->id ? 'selected' : ''  }}>
                                                                {{$nationalty->nationality}}</option>
                                                        @endforeach
                                                    </select>
                                                    <small class="my_place"></small>
                                                </div>
                                                @if ($errors->has('applicantNationality'))
                                                    <p class="alert alert-danger">{{ $errors->first('applicantNationality') }}
                                                    </p>
                                                @endif
                                                <div class="form-group">
                                                    {{ trans('servicelable/servicelable.applicant-address') }}
                                                    <span data-toggle="tooltip"
                                                          title="Applicant address should be the legal Address of the entity which would be the same as the one mentioned on the trade license, commercial certificate, or certificate of incorporation. The applicant address should also be included on the Power of Attorney document. It is very important that this information is entered accurately, uniformly and correctly. Differences between applicant  address entered here and applicant address entered on power of attorney may cause an office action."><i
                                                            class="fa fa-exclamation-circle"
                                                            aria-hidden="true"></i></span>
                                                    <input type="text" name="applicantAddress"
                                                           class="my_form-control center-block"
                                                           value="{{ old('applicantAddress') }}"
                                                           placeholder="Country , City , Street "
                                                           id="applicantAddress" onkeyup="validateNextStepThree()"/>
                                                    <small class="my_place"></small>
                                                </div>
                                                @if ($errors->has('applicantAddress'))
                                                    <p class="alert alert-danger">{{ $errors->first('applicantAddress') }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <input type="button" name="next" class="next action-button" value="{{ trans('servicelable/servicelable.next') }}"
                                           id="nextStepThree" style="pointer-events:none;background:#eee"/>
                                    <input type="button" name="previous" class="previous action-button-previous"
                                           value="{{ trans('servicelable/servicelable.previous') }}"/>
                                    <h2 class="steps text-left">{{ trans('servicelable/servicelable.step') }} 3 - 5</h2>
                                </fieldset>
                                <fieldset>
                                    <h2 id="heading"> {{ trans('servicelable/servicelable.class') }}
                                    </h2>
                                    <hr>
                                    <div class="form-card">
                                        <div class="contactForm row">
                                            <div class="col-md-6 ">
                                                <br><br>
                                                <div class="form-group">
                                                    {{ trans('servicelable/servicelable.class') }}
                                                    <select name="OneClass" class="my_form-control" id="OneClass"
                                                            onchange="validateNextStepFour();getDescription()">
                                                        <option value=""></option>
                                                        @foreach ($allClasses as $class)
                                                            <option value="{{ $class->class_id }}"
                                                                {{ old('OneClass') == $class->class_id ? 'selected' : ''  }}>
                                                                {{ $class->class_id }}</option>
                                                        @endforeach
                                                    </select>
                                                    <small class="my_place"></small>
                                                </div>
                                                @if ($errors->has('OneClass'))
                                                    <p class="alert alert-danger">{{ $errors->first('OneClass') }}</p>
                                                @endif
                                                <br>
                                                <span> {{ trans('servicelable/servicelable.class-description') }} </span><br>
                                                <p class="classDescription">
                                                </p>
                                            </div>
                                            <br><br>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    {{ trans('servicelable/servicelable.specify-goods') }}
                                                    <span data-toggle="tooltip"
                                                          title="The description does not have to be long."><i
                                                            class="fa fa-exclamation-circle"
                                                            aria-hidden="true"></i></span>
                                                    <textarea name="serviceDescription" onkeyup="validateNextStepFour()"
                                                              class="my_form-control center-block"
                                                              id="serviceDescription"
                                                              rows="4" placeholder="Limit to 10 sentences"
                                                              style="background: #f7f7f7">{{ old('serviceDescription') }}</textarea>
                                                    <small class="my_place"> </small>
                                                </div>
                                                @if ($errors->has('serviceDescription'))
                                                    <p class="alert alert-danger">{{ $errors->first('serviceDescription') }}</p>
                                                @endif
                                            </div>
                                            <p class="text-left">{{ trans('servicelable/servicelable.classification-goods') }}
                                                <a href="https://www.wipo.int/classifications/nice/nclpub/en/fr/"
                                                   target="_blank" style="color: #4B57FF"> {{ trans('servicelable/servicelable.nice-classification') }} </a> </p>
                                        </div>
                                    </div>
                                    <input type="button" name="next" class="next action-button" value="{{ trans('servicelable/servicelable.next') }}"
                                           id="nextStepFour" style="pointer-events:none;background:#eee"/>
                                    <input type="button" name="previous" class="previous action-button-previous"
                                           value="{{ trans('servicelable/servicelable.previous') }}"/>
                                    <h2 class="steps text-left">{{ trans('servicelable/servicelable.step') }} 4 - 5</h2>
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
                                                        class="checkout-data">{{$selectedCountry->country_name}}</span>
                                                </div>
                                            </div>
                                            <div class="col-md-6"><br>
                                                <h5 style="display:none;"> {{ trans('servicelable/servicelable.quick-turnaround') }}</h5>
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
                                        <p>{{ trans('servicelable/servicelable.upgrade-original-packages') }}</p>
                                    </div>

                                    <input type="submit" name="next" class="action-button" value="Review Order"/>
                                    <input type="button" name="previous" class="previous action-button-previous"
                                           value="{{ trans('servicelable/servicelable.previous') }}"/>
                                    <br>
                                    <h2 class="steps text-left">{{ trans('servicelable/servicelable.step') }} 5 - 5</h2>
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

        var expanded = false;

        function showCheckboxes() {
            var checkboxes = document.getElementById("checkboxes");
            if (!expanded) {
                checkboxes.style.display = "block";
                //expanded = true;
            } else {
                checkboxes.style.display = "none";
                // expanded = false;
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
		
		/*function isOther() {
            if (document.getElementById('isIndividual').value == 4) {
                document.getElementById('hasCompany').style.display = 'none';
				document.getElementById('otherVal').style.display = 'block';
            } else {
                document.getElementById('hasCompany').style.display = 'block';
				document.getElementById('otherVal').style.display = 'none';
            }
        }*/

        function yesnoCheck() {
            if (document.getElementById('yesCheck').checked) {
                document.getElementById('ifYes').style.display = 'block';
            } else {
                document.getElementById('ifYes').style.display = 'none';
                $('#trademarks_colors').val(null).trigger('change');
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

        function hasMeaningFunction() {
            if (document.getElementById('hasMeaning').checked) {

                document.getElementById('hasExplanation').style.display = 'block';
            } else {
                document.getElementById('hasExplanation').style.display = 'none';
                document.getElementById('explanation').value = '';
            }
        }

        function inArabicFunction() {
           /* if (document.getElementById('noArabic').checked) {
                document.getElementById('hasLanguage').style.display = 'block';
            } else {
                document.getElementById('LanguageID').value = '';
                document.getElementById('hasLanguage').style.display = 'none';

            }*/
        }

        function validateNextStepOne() {
            var brief = document.getElementById('brief').value;
            var imgFile = document.getElementById('imgFile');
        var hasLanguage = document.getElementById('LanguageID').value;

        console.log('val = '+hasLanguage);

            if (document.getElementById('hasMeaning').checked ) {
				//&& !document.getElementById('noArabic').checked
                var explanation = document.getElementById('explanation').value;
                var hasLanguage = document.getElementById('LanguageID').value;
                if (brief.length > 0 && explanation.length > 0 &&  hasLanguage > 0 &&
                    (document.getElementById('noMeaning').checked || document.getElementById('hasMeaning').checked)
                     && imgFile.files.length > 0) {
						 //(document.getElementById('inArabic').checked || document.getElementById('noArabic').checked)
                    document.getElementById("nextStepOne").style.pointerEvents = 'auto';
                    document.getElementById("nextStepOne").style.background = '#4B57FF';
                } else {
                    document.getElementById("nextStepOne").style.pointerEvents = 'none';
                    document.getElementById("nextStepOne").style.background = '#eee';
                }
            } else if (!document.getElementById('hasMeaning').checked && hasLanguage.length > 0) {
				//document.getElementById('noArabic').checked && 
                var hasLanguage = document.getElementById('LanguageID').value;
                if (brief.length > 0 && hasLanguage > 0 &&
                    (document.getElementById('noMeaning').checked || document.getElementById('hasMeaning').checked) &&
                    imgFile.files.length > 0) {
						//(document.getElementById('inArabic').checked || document.getElementById('noArabic').checked) &&
                    document.getElementById("nextStepOne").style.pointerEvents = 'auto';
                    document.getElementById("nextStepOne").style.background = '#4B57FF';
                } else {
                    document.getElementById("nextStepOne").style.pointerEvents = 'none';
                    document.getElementById("nextStepOne").style.background = '#eee';
                }
            } else if (document.getElementById('hasMeaning').checked ) {
				//document.getElementById('noArabic').checked && 
                var explanation = document.getElementById('explanation').value;
                var hasLanguage = document.getElementById('LanguageID').value;
                if (brief.length > 0 && hasLanguage > 0 && explanation.length > 0 &&
                    (document.getElementById('noMeaning').checked || document.getElementById('hasMeaning').checked)  &&
                    imgFile.files.length > 0) {
						//&&(document.getElementById('inArabic').checked || document.getElementById('noArabic').checked)
                    document.getElementById("nextStepOne").style.pointerEvents = 'auto';
                    document.getElementById("nextStepOne").style.background = '#4B57FF';
                } else {
                    document.getElementById("nextStepOne").style.pointerEvents = 'none';
                    document.getElementById("nextStepOne").style.background = '#eee';
                }
            } else {
                if (brief.length > 0 &&
                    (document.getElementById('noMeaning').checked || document.getElementById('hasMeaning').checked) &&
                    
                    imgFile.files.length > 0 && hasLanguage.length > 0) {
						//(document.getElementById('inArabic').checked || document.getElementById('noArabic').checked) &&
                    document.getElementById("nextStepOne").style.pointerEvents = 'auto';
                    document.getElementById("nextStepOne").style.background = '#4B57FF';
                } else {
                    document.getElementById("nextStepOne").style.pointerEvents = 'none';
                    document.getElementById("nextStepOne").style.background = '#eee';
                }
            }
        }

        function repeat() {
            if (brief.length > 0 &&
                (document.getElementById('noMeaning').checked || document.getElementById('hasMeaning').checked) &&
                
                imgFile.files.length > 0) {
					//(document.getElementById('inArabic').checked || document.getElementById('noArabic').checked) &&
                document.getElementById("nextStepOne").style.pointerEvents = 'auto';
                document.getElementById("nextStepOne").style.background = '#4B57FF';
            } else {
                document.getElementById("nextStepOne").style.pointerEvents = 'none';
                document.getElementById("nextStepOne").style.background = '#eee';
            }
        }

        function validateNextStepTwo() {
            if (document.getElementById('yesCheck').checked && !document.getElementById('yesClaim').checked) {
                var hasColor = document.getElementById('trademarks_colors').value;
                if (hasColor.length > 0 &&
                    (document.getElementById('yesCheck').checked || document.getElementById('noCheck').checked) &&
                    (document.getElementById('yesClaim').checked || document.getElementById('noClaim').checked)) {
                    document.getElementById("nextStepTwo").style.pointerEvents = 'auto';
                    document.getElementById("nextStepTwo").style.background = '#4B57FF';
                } else {
                    document.getElementById("nextStepTwo").style.pointerEvents = 'none';
                    document.getElementById("nextStepTwo").style.background = '#eee';
                }
            } else if (document.getElementById('yesClaim').checked && !document.getElementById('yesCheck').checked) {
                var fillingNumber = document.getElementById('fillingNumber').value;
                var fillingDate = document.getElementById('fillingDate').value;
                var fillingCountry = document.getElementById('fillingCountry').value;
                if (fillingNumber.length > 0 && fillingDate.length > 0 && fillingCountry.length > 0 &&
                    (document.getElementById('yesCheck').checked || document.getElementById('noCheck').checked) &&
                    (document.getElementById('yesClaim').checked || document.getElementById('noClaim').checked)) {
                    document.getElementById("nextStepTwo").style.pointerEvents = 'auto';
                    document.getElementById("nextStepTwo").style.background = '#4B57FF';
                } else {
                    document.getElementById("nextStepTwo").style.pointerEvents = 'none';
                    document.getElementById("nextStepTwo").style.background = '#eee';
                }
            } else if (document.getElementById('yesClaim').checked && document.getElementById('yesCheck').checked) {
                var hasColor = document.getElementById('trademarks_colors').value;
                var fillingNumber = document.getElementById('fillingNumber').value;
                var fillingDate = document.getElementById('fillingDate').value;
                var fillingCountry = document.getElementById('fillingCountry').value;
                if (hasColor.length > 0 && fillingNumber.length > 0 && fillingDate.length > 0 && fillingCountry.length > 0 &&
                    (document.getElementById('yesCheck').checked || document.getElementById('noCheck').checked) &&
                    (document.getElementById('yesClaim').checked || document.getElementById('noClaim').checked)) {
                    document.getElementById("nextStepTwo").style.pointerEvents = 'auto';
                    document.getElementById("nextStepTwo").style.background = '#4B57FF';
                } else {
                    document.getElementById("nextStepTwo").style.pointerEvents = 'none';
                    document.getElementById("nextStepTwo").style.background = '#eee';
                }
            } else {
                if (
                    (document.getElementById('yesCheck').checked || document.getElementById('noCheck').checked) &&
                    (document.getElementById('yesClaim').checked || document.getElementById('noClaim').checked)) {
                    document.getElementById("nextStepTwo").style.pointerEvents = 'auto';
                    document.getElementById("nextStepTwo").style.background = '#4B57FF';
                } else {
                    document.getElementById("nextStepTwo").style.pointerEvents = 'none';
                    document.getElementById("nextStepTwo").style.background = '#eee';
                }
            }
        }

        function validateNextStepThree() {
            var isIndividual = document.getElementById('isIndividual').value;
            var applicantOccupation = document.getElementById('applicantOccupation').value;
            var applicantName = document.getElementById('applicantName').value;
            var applicantNationality = document.getElementById('applicantNationality').value;
            var applicantAddress = document.getElementById('applicantAddress').value;
            if (isIndividual > 1 && isIndividual != 4) {
                var companyNameEnglish = document.getElementById('companyNameEnglish').value;
                if (isIndividual.length > 0 && applicantOccupation.length > 0 && applicantName.length > 0 && companyNameEnglish.length > 0 &&
                    applicantNationality.length > 0 && applicantAddress.length > 0) {
                    document.getElementById("nextStepThree").style.pointerEvents = 'auto';
                    document.getElementById("nextStepThree").style.background = '#4B57FF';
                } else {
                    document.getElementById("nextStepThree").style.pointerEvents = 'none';
                    document.getElementById("nextStepThree").style.background = '#eee';
                }
            } else if (isIndividual == 1) {
                if (isIndividual.length > 0 && applicantOccupation.length > 0 && applicantName.length > 0 &&
                    applicantNationality.length > 0 && applicantAddress.length > 0) {
                    document.getElementById("nextStepThree").style.pointerEvents = 'auto';
                    document.getElementById("nextStepThree").style.background = '#4B57FF';
                } else {
                    document.getElementById("nextStepThree").style.pointerEvents = 'none';
                    document.getElementById("nextStepThree").style.background = '#eee';
                }
            } else if (isIndividual == 4) {
				var typeOtherValue = document.getElementById('other_value').value;
				
                if (isIndividual.length > 0 && typeOtherValue.length > 0 && applicantOccupation.length > 0 && applicantName.length > 0 &&
                    applicantNationality.length > 0 && applicantAddress.length > 0) {
                    document.getElementById("nextStepThree").style.pointerEvents = 'auto';
                    document.getElementById("nextStepThree").style.background = '#4B57FF';
                } else {
                    document.getElementById("nextStepThree").style.pointerEvents = 'none';
                    document.getElementById("nextStepThree").style.background = '#eee';
                }
            }

        }

        function validateNextStepFour() {
            var OneClass = document.getElementById('OneClass').value;
            var serviceDescription = document.getElementById('serviceDescription').value;
            if (OneClass.length > 0 && serviceDescription.length > 0) {
                document.getElementById("nextStepFour").style.pointerEvents = 'auto';
                document.getElementById("nextStepFour").style.background = '#4B57FF';
            } else {
                document.getElementById("nextStepFour").style.pointerEvents = 'none';
                document.getElementById("nextStepFour").style.background = '#eee';
            }
        }

        var brief = document.getElementById('brief').value;
        var imgFile = document.getElementById('imgFile');
        if (document.getElementById('hasMeaning').checked) {
            var explanation = document.getElementById('explanation').value;
            if (brief.length > 0 && explanation.length > 0 &&
                (document.getElementById('noMeaning').checked || document.getElementById('hasMeaning').checked) &&
                
                imgFile.files.length > 0) {
					//(document.getElementById('inArabic').checked || document.getElementById('noArabic').checked) &&
                document.getElementById("nextStepOne").style.pointerEvents = 'auto';
                document.getElementById("nextStepOne").style.background = '#4B57FF';
            } else {
                document.getElementById("nextStepOne").style.pointerEvents = 'none';
                document.getElementById("nextStepOne").style.background = '#eee';
            }
        } else {
            repeat();
        }
        /*if (document.getElementById('noArabic').checked) {
            var hasLanguage = document.getElementById('LanguageID').value;
            if (brief.length > 0 && hasLanguage.length > 0 &&
                (document.getElementById('noMeaning').checked || document.getElementById('hasMeaning').checked) &&
                (document.getElementById('inArabic').checked || document.getElementById('noArabic').checked) &&
                imgFile.files.length > 0) {
                document.getElementById("nextStepOne").style.pointerEvents = 'auto';
                document.getElementById("nextStepOne").style.background = '#4B57FF';
            } else {
                document.getElementById("nextStepOne").style.pointerEvents = 'none';
                document.getElementById("nextStepOne").style.background = '#eee';
            }
        } else {
           repeat();
        }*/
        if (document.getElementById('hasMeaning').checked) {
			//document.getElementById('noArabic').checked && 
            var explanation = document.getElementById('explanation').value;
            var hasLanguage = document.getElementById('LanguageID').value;
            if (brief.length > 0 && hasLanguage.length > 0 && explanation.length > 0 &&
                (document.getElementById('noMeaning').checked || document.getElementById('hasMeaning').checked) &&
                imgFile.files.length > 0) {
					//(document.getElementById('inArabic').checked || document.getElementById('noArabic').checked) &&
                document.getElementById("nextStepOne").style.pointerEvents = 'auto';
                document.getElementById("nextStepOne").style.background = '#4B57FF';
            } else {
                document.getElementById("nextStepOne").style.pointerEvents = 'none';
                document.getElementById("nextStepOne").style.background = '#eee';
            }
        } else {
            repeat();
        }

        if ((document.getElementById('yesClaim').checked || document.getElementById('noClaim').checked) && (document
            .getElementById('yesCheck').checked || document.getElementById('noCheck').checked)) {
            document.getElementById("nextStepTwo").style.pointerEvents = 'auto';
            document.getElementById("nextStepTwo").style.background = '#4B57FF';
        } else {
            document.getElementById("nextStepTwo").style.pointerEvents = 'none';
            document.getElementById("nextStepTwo").style.background = '#eee';
        }

        var isIndividual = document.getElementById('isIndividual').value;
        var applicantOccupation = document.getElementById('applicantOccupation').value;
        var applicantName = document.getElementById('applicantName').value;
        var applicantNationality = document.getElementById('applicantNationality').value;
        var applicantAddress = document.getElementById('applicantAddress').value;

        if (isIndividual.length > 0 && applicantOccupation.length > 0 && applicantName.length > 0 && applicantNationality
            .length > 0 && applicantAddress.length > 0) {
            document.getElementById("nextStepThree").style.pointerEvents = 'auto';
            document.getElementById("nextStepThree").style.background = '#4B57FF';
        } else {
            document.getElementById("nextStepThree").style.pointerEvents = 'none';
            document.getElementById("nextStepThree").style.background = '#eee';
        }

        var OneClass = document.getElementById('OneClass').value;
        var serviceDescription = document.getElementById('serviceDescription').value;

        if (OneClass.length > 0 && serviceDescription.length > 0) {
            document.getElementById("nextStepFour").style.pointerEvents = 'auto';
            document.getElementById("nextStepFour").style.background = '#4B57FF';
        } else {
            document.getElementById("nextStepFour").style.pointerEvents = 'none';
            document.getElementById("nextStepFour").style.background = '#eee';
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
	
	function TDate() {
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
