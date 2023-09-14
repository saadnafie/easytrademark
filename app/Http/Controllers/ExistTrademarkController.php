<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use mysql_xdevapi\Exception;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Utility\AllowedCurrencies;
//use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\App;
use Redirect;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Auth;
use DB;
use Mail;

use App\Models\Service;
use App\Models\Country;
use App\Models\Order;
use App\Models\ServicePackageFee;
use App\Models\Package;
use App\Models\OrderTranslation;
use App\Models\CountryClass;
use App\Models\ServicePackageCountryFee;

use App\Models\Trademark;
use App\Models\TrademarkComment;
use App\Models\TrademarkCountry;
use App\Models\TrademarkCountryOrder;
use App\Models\TrademarkCountryClasses;
use App\Models\TrademarkResponse;
use App\Models\TrademarkFilling;
use App\Models\TrademarkNameChange;
use App\Models\TrademarkAddressChange;
use App\Models\TrademarkAssignment;
use App\Models\TrademarkRegistration;
use App\Models\TrademarkColor;


use App\Models\Language;
use App\Models\Color;
use App\Models\ApplicantOccupation;
use App\Models\Nationality;
use App\Models\ApplicantType;
use App\Models\ClaimConventionDetail;
use App\Models\CompanyType;
use App\Models\ApplicantCountry;
/**
 * Class ExistTrademarkController
 * @package App\Http\Controllers
 * 
 */
class ExistTrademarkController extends Controller
{
	
	const STRIPE_FEES_PERCENTAGE = 3.5;
	const FAST_SEARCH_COST = 50;
    /**
     * ProfileController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * show all trademarks on profile page
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function Exist_trademark_details(Request $request)
    {
		$tmID = $request->existingTrademarkId;
		$serviceCtryPackageID = $request->countryPackageFeesID;
		$currentTrademark = Trademark::find($tmID);
		$serviceCntryPackage = ServicePackageCountryFee::with('country')->with('service_package')->find($serviceCtryPackageID);
		
		 if ($currentTrademark && $serviceCntryPackage) {

		$servicePackages = ServicePackageFee::select('id')->where('service_id', 2)->get();
		$isRegExist = TrademarkCountry::with('orders')->with('trademark_country_classes')->where('trademark_id', $tmID)->whereHas('orders', function ($query) use($servicePackages) {
        $query->whereIn('service_package_id', $servicePackages);})->latest()->first();
		
		//return $isRegExist;
	    
	    
        
		
		$allApplicantOccupations = ApplicantOccupation::all();
        $allNationalities = Nationality::all();
        $allCompanyType = CompanyType::all();
        $allLanguages = Language::all();
		$allApplicantType = ApplicantType::all();
		$allCountries = ApplicantCountry::all();
		
		
		 $color_lang = 'color_name_' . App::getLocale();
        $allColors = Color::orderBy($color_lang, 'asc')->get();
		//return $serviceCntryPackage;
		$allClasses = CountryClass::where('country_id', $serviceCntryPackage->country_id)->get();
		$fastSearchCost = self::FAST_SEARCH_COST;
        
		
		return view('client.existTrademark.existTrademark', compact('currentTrademark', 'allClasses', 'fastSearchCost', 'serviceCntryPackage', 'allApplicantOccupations', 'allNationalities', 'allCompanyType', 'allLanguages', 'allColors', 'allApplicantType', 'allCountries', 'isRegExist'));
		 } else {
                return redirect('client.errors.copyof404');
            }
	
	}
	
	
	public function create_order_existTM1(Request $request){
		
		/*$systemDefaultCurrencyCode = Session::get('systemDefaultCurrencyCode');
        $userCountryCurrencyCode = Session::get('userCountryCurrencyCode');
        // Validator
        $validator = Validator::make($request->all(), [
            'trademarkClasse' => ['required'],
            'trademarkImg' => ['mimes:jpeg,jpg,png,gif', 'max:30720']
        ]);
        if ($validator->fails()) {
            Session::flash('error', $validator->messages());
            return Redirect::back()->withErrors($validator)->withInput();
        }
        // to know if Client Authenticated or Not
            if ($request->trademarkId == null) {
                // store in table Trademark [ img - user_id - deadline]
                $searchService = new Trademark();
                if ($request->trademarkImg) {
                    $photoName = date('Y-m-d-H-i-s') . '_' . $request->trademarkImg->getClientOriginalName();
                    $searchService->trademark_image = $photoName;
                    $request->trademarkImg->move(public_path('img/trademarksImages/'), $photoName);
                }
                $searchService->user_id = (Auth::check() == true) ? Auth::id() : null;
                $searchService->trademark_word_en = $request->trademarkEnglishWord;
                $searchService->trademark_word_ar = $request->trademarkArabicWord;
                $searchService->deadline = '01/09/25';
                $searchService->trademark_reference = time();
                $searchService->trademark_label = $request->trademarkLabel;
            } else {
                $searchService = new Trademark();
                $searchService->id = $request->trademarkId;
            }
            if ($request->upgradePackage != null) {
                // find countryFees & serviceFees to calculate total Fees
                $serviceFees = ServicePackageFee::where('package_id', $request->upgradePackage)->first();
                $countryFees = ServicePackageCountryFee::where('service_package_id', $serviceFees->id)->where('country_id', $request->countryId)->first();
                $totalWithoutUpgrade = $serviceFees->fee + $countryFees->fees;
            } else {
                $serviceFees = ServicePackageFee::where('package_id', $request->packageID)->first();
                $countryFees = ServicePackageCountryFee::where('service_package_id', $serviceFees->id)->where('country_id', $request->countryId)->first();
                $totalWithoutUpgrade = $serviceFees->fee + $countryFees->fees;
            }
			$totalWithoutUpgradeWithoutStripeFees = $totalWithoutUpgrade;

            // add 3.5 from here to all calculation process
            $totalWithoutUpgrade = $totalWithoutUpgrade + round(($totalWithoutUpgrade * self::STRIPE_FEES_PERCENTAGE) / 100, 2);

            // select service based on service which selected in the beginning of the process ( search box ( country - service ))
            $service = Service::find($request->serviceId);
            $order = new Order;
            // if client select fast search due date will be 1 day if not will be 5 days or coming from DB
            $date = Carbon::createFromFormat('Y-m-d', Date('Y-m-d'));
            $allowedCurrencies = new AllowedCurrencies();
            if ($request->fastSreach == 'on') {
                $totalWithoutUpgrade = $totalWithoutUpgrade + self::FAST_SEARCH_COST + (50 * self::STRIPE_FEES_PERCENTAGE) / 100;
                $order->total_fees = $totalWithoutUpgrade;
                if ($userCountryCurrencyCode !== $systemDefaultCurrencyCode) {
                    $order->total_fees_currency =
                        $allowedCurrencies->convertCurrency($totalWithoutUpgrade, $systemDefaultCurrencyCode, $userCountryCurrencyCode);
                } else {
                    $order->total_fees_currency = $totalWithoutUpgrade;
                }
                $order->currency_type = $userCountryCurrencyCode;
                $daysToAdd = 1;
            } else {
                $order->total_fees = $totalWithoutUpgrade;
                if ($userCountryCurrencyCode !== $systemDefaultCurrencyCode) {
                    $order->total_fees_currency =
                        $allowedCurrencies->convertCurrency($totalWithoutUpgrade, $systemDefaultCurrencyCode, $userCountryCurrencyCode);
                } else {
                    $order->total_fees_currency = $totalWithoutUpgrade;
                }

                $order->currency_type = $userCountryCurrencyCode;
                $daysToAdd = $service->execution_days;
            }
            $date = $date->addDays($daysToAdd);
            $order->due_date = $date;
            $order->service_package_id = $serviceFees->id;

            // prepare Trademark country to global data
            $trademarkCountry = new TrademarkCountry;
            $totalWithoutUpgrade = $totalWithoutUpgradeWithoutStripeFees;
            $trademarkCountry->trademark_id = $searchService->id;
            $trademarkCountry->country_id = $request->countryId;
            if ($request->fastSreach == 'on') {
                $trademarkCountry->isFast = 1;
                $subTotal = $totalWithoutUpgrade;
                $trademarkCountry->sub_total = $subTotal;
                if ($userCountryCurrencyCode !== $systemDefaultCurrencyCode) {
                    $trademarkCountry->sub_total_currency =
                        $allowedCurrencies->convertCurrency($subTotal, $systemDefaultCurrencyCode, $userCountryCurrencyCode);
                } else {
                    $trademarkCountry->sub_total_currency = $subTotal;
                }
            } else {
                $trademarkCountry->isFast = 0;
                $trademarkCountry->sub_total = $totalWithoutUpgrade;

                if ($userCountryCurrencyCode !== $systemDefaultCurrencyCode) {
                    $trademarkCountry->sub_total_currency =
                        $allowedCurrencies->convertCurrency($totalWithoutUpgrade, $systemDefaultCurrencyCode, $userCountryCurrencyCode);
                } else {
                    $trademarkCountry->sub_total_currency = $totalWithoutUpgrade;
                }

            }
            $trademarkCountry->currency_type = $userCountryCurrencyCode;

            // prepare Trademark country order to global data
            $trademarkCountryOrder = new TrademarkCountryOrder;
            $trademarkResponseDefault = TrademarkResponse::where('service_id', $request->serviceId)->first();
            $trademarkCountryOrder->response_id = $trademarkResponseDefault->id;

            // prepare Trademark country classes to global data
            $trademarkCountryClasses = new TrademarkCountryClasses();
            $trademarkCountryClasses->class_id = $request->trademarkClasse;
            // authorized actions allow saved in database it's used as private not global
            if (Auth::check() == true) {
                if ($request->trademarkId == null) {
                    $searchService->save();
                }
                $order->save();
                $order->order_number = $service->service_abbreviation . '-00' . $order->id;
                $order->save();
                $trademarkCountry->trademark_id = $searchService->id;
                $trademarkCountry->save();
                $trademarkCountryOrder->trademark_country_id = $trademarkCountry->id;
                $trademarkCountryOrder->order_id = $order->id;
                $trademarkCountryOrder->save();
                $trademarkCountryClasses->trademark_country_id = $trademarkCountry->id;
                $trademarkCountryClasses->save();

                if (App::environment('production')) {
                    // Send email to client after ordering this service
                    $email = new \stdClass();
                    $email->order_number = $order->order_number;
                    $email->trademark_word_en = $request->trademarkEnglishWord;
                    $email->trademark_word_ar = $request->trademarkArabicWord;
                    $email->trademark_label = $request->trademarkLabel;
                    $email->class = $request->trademarkClasse;
                    $email->total_fees_currency = $order->total_fees_currency;
                    //$email->userCountryCurrencyCode = $userCountryCurrencyCode;
                    Mail::send('client.emails.serviceMail', ['email' => $email], function ($message) {
                        $message->from('info@easy-trademarks.com', 'Easytrademark');
                        $message->to(auth()->user()->email, auth()->user()->name)->subject('We received Your Order ! ');
                    });
                }

                $orderId = $order->id;
                $searchServiceId = $searchService->id;
                return redirect("checkoutDetails/$searchServiceId/$orderId");
            } else {
                $request->except('trademarkImg');
                $fullOrderData = [
                    'submittedRequest' => $request->except('trademarkImg'),
                    'searchService' => $searchService,
                    'order' => $order,
                    'trademarkCountry' => $trademarkCountry,
                    'trademarkCountryOrder' => $trademarkCountryOrder,
                    'trademarkCountryClasses' => $trademarkCountryClasses
                ];
                session()->put('fullOrderData', $fullOrderData);
                session()->put('intendedUrl', route('store-order-after-login'));
                return redirect()->route('forceUserLogin');
            }*/
	}
	
	public function create_order_existTM(Request $request){
		//return $request;
		$s_p_c = ServicePackageCountryFee::with('country')->with('service_package')->find($request->countryPackageFeesID);
		
		/////////////////// tm country /////////////////////////////
		$tm_country = new TrademarkCountry();
		$tm_country->trademark_id = $request->trademarkId;
		$tm_country->country_id = $s_p_c->country_id;
		$tm_country->sub_total = $s_p_c->fees + $s_p_c->service_package->fee;
		$tm_country->sub_total_currency = $s_p_c->fees + $s_p_c->service_package->fee;
		$tm_country->currency_type = "USD";
		if(isset($request->fastSreach)){
			$tm_country->isFast = 1;
			$no_days = 1;
		}else{
			$no_days = $s_p_c->service_package->service->execution_days;
		}
		$tm_country->save();
		
		////////////////////////////////// order /////////////////////////////////////
		$date = Carbon::createFromFormat('Y-m-d', Date('Y-m-d'));
		$date = $date->addDays($no_days);
		$order = new Order();
		$order->order_number = $s_p_c->service_package->service->service_abbreviation . '-00';
		$order->service_package_id = $s_p_c->service_package_id;
		$order->currency_type = "USD";
		$order->due_date = $date;
		if(isset($request->fastSreach)){
			$order->total_fees = $tm_country->sub_total + self::FAST_SEARCH_COST +  round((($tm_country->sub_total + self::FAST_SEARCH_COST) * self::STRIPE_FEES_PERCENTAGE) / 100, 2);
			$order->total_fees_currency = $tm_country->sub_total + self::FAST_SEARCH_COST +  round((($tm_country->sub_total + self::FAST_SEARCH_COST) * self::STRIPE_FEES_PERCENTAGE) / 100, 2);
		}else{
			$order->total_fees = $tm_country->sub_total +  round(($tm_country->sub_total * self::STRIPE_FEES_PERCENTAGE) / 100, 2);
			$order->total_fees_currency = $tm_country->sub_total +  round(($tm_country->sub_total * self::STRIPE_FEES_PERCENTAGE) / 100, 2);
		}
		$order->save();
		$order->order_number = $s_p_c->service_package->service->service_abbreviation . '-00' . $order->id;
		$order->save();
		////////////////////////////// tm country order /////////////////////////////////////
		$tm_defualt_response = TrademarkResponse::where('service_id', $s_p_c->service_package->service_id)->first();
		$tm_country_order = new TrademarkCountryOrder();
		$tm_country_order->trademark_country_id = $tm_country->id;
		$tm_country_order->order_id = $order->id;
		$tm_country_order->	response_id = $tm_defualt_response->id;
		$tm_country_order->save();
		
		/////////////////////////////////// classes /////////////////////////////////
		if(isset($request->trademarkClasse)){
            if(isset($request->serviceDescription))
                $des = $request->serviceDescription;
            else
               $des = null; 
			$this->set_class($tm_country->id , $request->trademarkClasse , $des);
        }

        ////////////////////////////////// registration /////////////////////////////////
        if($s_p_c->service_package->service_id == 2)
            $this->set_registration($order->id , $request);
		
		/////////////////////////// filling ///////////////////////////////
		if($s_p_c->service_package->service_id == 3 || $s_p_c->service_package->service_id == 4 || $s_p_c->service_package->service_id == 5 || $s_p_c->service_package->service_id == 6)
			$this->set_filling($tm_country->id , $request->fillingDate , $request->fillingNumber);
			
		////////////////////////////////// assignment /////////////////////////////////
		if($s_p_c->service_package->service_id == 4)
			$this->set_assignment($order->id , $request->assignorName , $request->assignorAddress , $request->assigneeName , $request->assigneeAddress);
			
		////////////////////////////////// name change /////////////////////////////////
		if($s_p_c->service_package->service_id == 5)
			$this->set_name_change($order->id , $request->oldName , $request->newName);
			
		////////////////////////////////// name change /////////////////////////////////
		if($s_p_c->service_package->service_id == 6)
			$this->set_address_change($order->id , $request->oldAddress , $request->newAddress);
		

        $countryName = Country::where('id', $s_p_c->country_id)->first();
        $trademarkData = Trademark::where('id', $request->trademarkId)->first();

        if (App::environment('production')) {
                // Send email to client after ordering this service
                $email = new \stdClass();
                $email->user_name = auth()->user()->user_name;
                $email->order_id = $order->id;
                $email->tm_id = $request->trademarkId;
                $email->order_number = $order->order_number;
                $email->tm_ref = $trademarkData->trademark_reference;
                $email->trademark_label = $trademarkData->trademark_label;
                $email->country_name = $countryName->country_name_en;
                $email->total_fees_currency = $order->total_fees_currency;
                $email->userCountryCurrencyCode = '$';


                $SUBJECT = 'ACTION REQURED - order confirmation - '.$order->order_number.' - '.$trademarkData->trademark_reference.' - '.$trademarkData->trademark_label.' - '.$countryName->country_name_en;

                \Illuminate\Support\Facades\Mail::send('client.emails.serviceMail', ['email' => $email], function ($message) use ($SUBJECT) {
                    $message->from('info@easy-trademarks.com', 'Easytrademark');
                    $message->to(auth()->user()->email, auth()->user()->user_name)->subject($SUBJECT);
                });
            }

		return redirect("checkoutDetails/$request->trademarkId/$order->id");
	}
	
	function set_class($tm_country_id , $class_id , $description){
		$tm_country_class = new TrademarkCountryClasses();
		$tm_country_class->trademark_country_id = $tm_country_id;
		$tm_country_class->class_id = $class_id;
		$tm_country_class->description = $description;
		$tm_country_class->save();
	}
	
	function set_filling($tm_country_id , $filling_date , $filling_number){
		$filling = new TrademarkFilling();
		$filling->trademark_country_id = $tm_country_id;
		$filling->filling_date = $filling_date;
		$filling->filling_number = $filling_number;
		$filling->save();
	}
	
	function set_name_change($order_id , $old_name , $new_name){
		$name = new TrademarkNameChange();
		$name->order_id = $order_id;
		$name->old_name = $old_name;
		$name->new_name = $new_name;
		$name->save();
	}
	
	function set_address_change($order_id , $old_address , $new_address){
		$address = new TrademarkAddressChange();
		$address->order_id = $order_id;
		$address->old_address = $old_address;
		$address->new_address = $new_address;
		$address->save();
	}

	function set_assignment($order_id , $assignor_name , $assignor_address , $assignee_name , $assignee_address){
		$assignment = new TrademarkAssignment();
		$assignment->order_id = $order_id;
		$assignment->assignor_name = $assignor_name;
		$assignment->assignor_address = $assignor_address;
		$assignment->assignee_name = $assignee_name;
		$assignment->assignee_address = $assignee_address;
		$assignment->save();
	}

    function set_registration($order_id , $request){
        $regist = new TrademarkRegistration();
        $regist->order_id = $order_id;
        if(isset($request->explanation)){
            $regist->isMeaning = 1;
            $regist->explanation = $request->explanation;
        }
        if($request->language == 4){
            $regist->isArabic = 1;
			$regist->language_id = $request->language;
		} else{
				$regist->language_id = $request->language;
		}
        $regist->brief = $request->brief;
        if(isset($request->color))
            if(count($request->color) > 0 )
            $regist->isColor = 1;
        $regist->claim_convention = $request->claimConvention;
        $regist->applicant_type_id = $request->applicantType;
        if(isset($request->othervalue) && $request->applicantType == 4)
            $regist->other_option_value = $request->othervalue;
        $regist->applicant_name = $request->applicantName;
        $regist->applicant_occupation_id = $request->applicantOccupation;
        $regist->applicant_nationality_id = $request->applicantNationality;
        if($request->applicantType == 2 || $request->applicantType == 3)
            $regist->applicant_company_type_id = $request->company;
        $regist->applicant_address = $request->applicantAddress;
        $regist->save();
		///////////////////////// color ////////////////////////////
        if(isset($request->color)){
            foreach ($request->color as $value) {
                $color = new TrademarkColor();
                $color->order_id = $order_id;
                $color->color_id = $value;
                $color->save();
            }
        }
		
		if($request->claimConvention == 1){
			$claim = new ClaimConventionDetail();
			$claim->trademark_registration_id = $regist->id;
			$claim->country_id = $request->country;
			$claim->filling_number = $request->fillingNumber;
			$claim->filling_date = $request->fillingDate;
			$claim->save();
		}
	}
}
