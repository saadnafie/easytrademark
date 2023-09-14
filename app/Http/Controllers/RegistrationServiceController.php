<?php

namespace App\Http\Controllers;

use App\Models\ApplicantCountry;
use App\Models\TrademarkCountry;
use App\Models\TrademarkCountryOrder;
use App\Models\TrademarkFilling;
use App\Models\TrademarkResponse;
use App\Models\TrademarkServicePackageCountry;
use App\Utility\AllowedCurrencies;
use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\Package;
use App\Models\ApplicantType;
use App\Models\Language;
use App\Models\Trademark;
use Auth;
use Illuminate\Support\Facades\App;
use Mail;
use Illuminate\Support\Facades\Crypt;

use Redirect;
use App\Models\TrademarkColor;
use App\Models\Service;
use App\Models\Order;
use Carbon\Carbon;
use App\Models\ServicePackageFee;
use App\Models\ServicePackageCountryFee;
use App\Models\TrademarkRegistration;
use App\Models\ApplicantOccupation;
use App\Models\ClaimConventionDetail;
use App\Models\CompanyType;
use App\Models\Color;
use App\Models\TrademarkCountryClasses;
use App\Models\Nationality;
use App\Models\CountryClass;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

/**
 * Class RegistrationServiceController
 * @package App\Http\Controllers
 * @author Andrew Nady <andro.nady2015@gmail.com>
 */
class RegistrationServiceController extends Controller
{
    const STRIPE_FEES_PERCENTAGE = 3.5;
    const QUICK_TURNAROUND_COST = 50;
    //const QUICK_TURNAROUND_COST = 50 + (50 * self::STRIPE_FEES_PERCENTAGE) / 100;

    /**
     * show registration service form ( stepper )
     *
     * @param $packageID
     * @param $serviceId
     * @param $countryId
     * @param $countryPackageFees
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function stepper($packageID, $serviceId, $countryId, $countryPackageFees, Request $request)
    {
        $systemDefaultCurrencyCode = Session::get('systemDefaultCurrencyCode');
        $userCountryCurrencyCode = Session::get('userCountryCurrencyCode');
        $userCountryCurrencySymbol = Session::get('userCountryCurrencySymbol');
        $quickTurnaroundCost = self::QUICK_TURNAROUND_COST;
        $allClasses = CountryClass::where('country_id', $countryId)->with('classes')->get();
        $allApplicantOccupations = ApplicantOccupation::all();
        $allNationalities = Nationality::all();
        $allCompanyType = CompanyType::all();
        $allLanguages = Language::all();
       // return $allLanguages;
        $color_lang = 'color_name_' . App::getLocale();
        $allColors = Color::orderBy($color_lang, 'asc')->get();
        $allCountries = ApplicantCountry::all();
        $allApplicantType = ApplicantType::all();
        $selectedCountry = Country::find($countryId);
        $trademarkLabel = $request->existingTrademarkLabel;
        $trademarkId = $request->existingTrademark;
        $package = Package::find($packageID);
        $servicePackageFee = ServicePackageFee::where('package_id', $packageID)->with('package')->first();
        $servicePackageCountryFee = ServicePackageCountryFee::where('service_package_id', $servicePackageFee->id)->where('country_id', $countryId)->first();
        if ($userCountryCurrencyCode !== $systemDefaultCurrencyCode) {
            $userCountryCurrencyCode = Session::get('userCountryCurrencyCode');
            $allowedCurrencies = new AllowedCurrencies();
            $quickTurnaroundCost =
                $allowedCurrencies->convertCurrency($quickTurnaroundCost, $systemDefaultCurrencyCode, $userCountryCurrencyCode);
        }
        $nextFlag = $package->flag + 1;
        $nextPackage = Service::find($serviceId)->package->where('flag', $nextFlag)->first();
        $returnData = [
            'quickTurnaround' => $quickTurnaroundCost,
            'allClasses' => $allClasses,
            'allCountries' => $allCountries,
            'selectedCountry' => $selectedCountry,
            'allApplicantType' => $allApplicantType,
            'allNationalities' => $allNationalities,
            'allCompanyType' => $allCompanyType,
            'allLanguages' => $allLanguages,
            'allApplicantOccupations' => $allApplicantOccupations,
            'allColors' => $allColors,
            'countryPackageFees' => $countryPackageFees,
            'serviceId' => $serviceId,
            'currencySymbol' => $userCountryCurrencySymbol,
            'trademarkLabel' => $trademarkLabel,
            'trademarkId' => $trademarkId,
            'package' => $package,
            'existingTrademarkLabel' => $request->existingTrademarkLabel,
            'newTrademarkLabel' => $request->newTrademarkLabel,
            'existingTrademarkId' => $request->existingTrademarkId,

        ];
        if ($nextPackage == null) {
            return view('client.services.registration', $returnData);
        } else {
            $nextPackage = Service::find($serviceId)->package->where('flag', $nextFlag)->first();
            $nextServicePackageFee = ServicePackageFee::where('package_id', $nextPackage->id)->with('package')->first();
            $nextServicePackageCountryFee = ServicePackageCountryFee::where('service_package_id', $nextServicePackageFee->id)->where('country_id', $countryId)->first();
            $nextPackageUpgradeFees = (($nextServicePackageFee->fee + $nextServicePackageCountryFee->fees) - ($servicePackageFee->fee + $servicePackageCountryFee->fees));
            if ($userCountryCurrencyCode !== $systemDefaultCurrencyCode) {
                $userCountryCurrencyCode = Session::get('userCountryCurrencyCode');
                $allowedCurrencies = new AllowedCurrencies();
                $nextPackageUpgradeFees =
                    $allowedCurrencies->convertCurrency($nextPackageUpgradeFees, $systemDefaultCurrencyCode, $userCountryCurrencyCode);
            }
            $returnData['nextPackage'] = $nextPackage;
            $returnData['nextPackageUpgradeFees'] = $nextPackageUpgradeFees;
            return view('client.services.registration', $returnData);
        }
    }

    /**
     * store Registration service data in DB
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function store(Request $request)
    {
        $systemDefaultCurrencyCode = Session::get('systemDefaultCurrencyCode');
        $userCountryCurrencyCode = Session::get('userCountryCurrencyCode');
        $end_date = Carbon::now()->subMonths(6)->startOfMonth();
        // Validator
        $validator = Validator::make($request->all(), [
            'trademarkImg' => ['required', 'mimes:jpeg,jpg,png,gif', 'max:30720'],
            'brief' => ['required', 'string'],
            'isMeaning' => ['required'],
            //'isArabic' => ['required'],
            'isColor' => ['required'],
            'claimConvention' => ['required'],
            'applicantType' => ['required'],
            'applicantOccupation' => ['required'],
            'applicantName' => ['required', 'string'],
            'applicantNationality' => ['required'],
            'applicantAddress' => ['required', 'string'],
            'OneClass' => ['required'],
            'serviceDescription' => ['required'],
        ]);
        if ($validator->fails()) {
            Session::flash('error', $validator->messages());
            return Redirect::back()->withErrors($validator)->withInput();
        }

        if ($request->trademarkId == null) {
            // store in table Trademark [ img - user_id - deadline]
            $trademark = new Trademark();
            if ($request->trademarkImg) {
                $photoName = date('Y-m-d-H-i-s') . '_' . $request->trademarkImg->getClientOriginalName();
                $trademark->trademark_image = $photoName;
                $request->trademarkImg->move(public_path('img/trademarksImages/'), $photoName);
            }
            $trademark->user_id = (Auth::check() == true) ? Auth::id() : null;
            $trademark->deadline = '01/07/27';
            $trademark->trademark_reference = time();
            $trademark->trademark_label = $request->trademarkLabel;
        } else {
            $trademark = new Trademark();
            $trademark->id = $request->trademarkId;
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

        $service = Service::find($request->serviceId);
        // store in table Order
        $order = new Order;
        $date = Carbon::createFromFormat('Y-m-d', Date('Y-m-d'));
        $allowedCurrencies = new AllowedCurrencies();
        if ($request->fastSreach == 'on') {
            $totalWithoutUpgrade = $totalWithoutUpgrade + self::QUICK_TURNAROUND_COST;
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

        // store in table TrademarkRegistration
        $registration = new TrademarkRegistration;
        // this input come from form ( yes - no ) I convert it to   [ 0 || 1 ]
        if ($request->isMeaning == 'yes') {
            $registration->isMeaning = 1;
        } else {
            $registration->isMeaning = 0;
        }

        // this input come from form ( yes - no ) I convert it to   [ 0 || 1 ]
        if ($request->language == 4) {
            $registration->isArabic = 1;
        } else {
            $registration->isArabic = 0;
        }

        $registration->explanation = $request->explanation;
        $registration->language_id = $request->language;

        // this input come from form ( yes - no ) I convert it to   [ 0 || 1 ]
        if ($request->isColor == 'yes') {
            $registration->isColor = 1;
        } else {
            $registration->isColor = 0;
        }
        $registration->brief = $request->brief;

        // this input come from form ( yes - no ) I convert it to   [ 0 || 1 ]
        if ($request->claimConvention == 'yes') {
            $registration->claim_convention = 1;
        } else {
            $registration->claim_convention = 0;
        }
        $registration->applicant_type_id = $request->applicantType;
		
		if($request->applicantType == 4){
		$registration->other_option_value = $request->othervalue;
		}
		
        $registration->applicant_name = $request->applicantName;
        $registration->applicant_occupation_id = $request->applicantOccupation;
        $registration->applicant_nationality_id = $request->applicantNationality;
        $registration->applicant_company_type_id = $request->company;
        $registration->applicant_address = $request->applicantAddress;
        $registration->status = 0;

        $trademarkCountry = new TrademarkCountry;
		$totalWithoutUpgrade = $totalWithoutUpgradeWithoutStripeFees;
        $trademarkCountry->country_id = $request->countryId;
        if ($request->fastSreach == 'on') {
            $trademarkCountry->isFast = 1;
            $subTotal = $totalWithoutUpgrade - self::QUICK_TURNAROUND_COST;
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

        $trademarkCountryOrder = new TrademarkCountryOrder;
        $trademarkCountryOrder->response_id = 5;

        // store in table TrademarkCountryClasses
        $trademarkCountryClasses = new TrademarkCountryClasses();
        $trademarkCountryClasses->class_id = $request->OneClass;
        $trademarkCountryClasses->description = $request->serviceDescription;

        // store in table ClaimConventionDetail
        if ($request->fillingNumber != null && $request->fillingDate != null && $request->country != null) {
            $filling = new ClaimConventionDetail;
            $filling->country_id = $request->country;
            $filling->filling_number = $request->fillingNumber;
            $filling->filling_date = $request->fillingDate;
            $filling->status = 0;
        }
        if (Auth::check() == true) {
            if ($request->trademarkId == null) {
                $trademark->save();
            }
            $order->save();
            $order->order_number = $service->service_abbreviation . '-00' . $order->id;
            $order->save();
            $registration->order_id = $order->id;
            $registration->save();
            // store in table TrademarkColor
            if ($request['color'] != null) {
                foreach ($request['color'] as $color) {
                    $TrademarkColor = new TrademarkColor();
                    $TrademarkColor->order_id = $order->id;
                    $TrademarkColor->color_id = $color;
                    $TrademarkColor->save();
                }
            }
            $trademarkCountry->trademark_id = $trademark->id;
            $trademarkCountry->save();
            $trademarkCountryOrder->trademark_country_id = $trademarkCountry->id;
            $trademarkCountryOrder->order_id = $order->id;
            $trademarkCountryOrder->save();
            $trademarkCountryClasses->trademark_country_id = $trademarkCountry->id;
            $trademarkCountryClasses->save();
            if ($request->fillingNumber != null && $request->fillingDate != null && $request->country != null) {
                $filling->trademark_registration_id = $registration->id;
                $filling->save();
            }

            $countryName = Country::where('id', $request->countryId)->first();

            if (App::environment('production')) {
                // Send email to client after ordering this service
                $email = new \stdClass();
				$email->user_name = auth()->user()->user_name;
				$email->order_id = $order->id;
				$email->tm_id = $trademark->id;
                $email->order_number = $order->order_number;
                $email->tm_ref = $trademark->trademark_reference;
                $email->trademark_label = $request->trademarkLabel;
                $email->isArabic = $request->isArabic;
                $email->explanation = $request->explanation;
                $email->brief = $request->brief;
                $email->country_name = $countryName->country_name_en;
                $email->OneClass = $request->OneClass;
                $email->serviceDescription = $request->serviceDescription;
                $email->filling_number = $request->fillingNumber;
                $email->filling_date = $request->fillingDate;
                $email->total_fees_currency = $order->total_fees_currency;
                $email->userCountryCurrencyCode = $userCountryCurrencyCode;

                $SUBJECT = 'ACTION REQURED - order confirmation - '.$order->order_number.' - '.$trademark->trademark_reference.' - '.$request->trademarkLabel.' - '.$countryName->country_name_en.' - '.$request->OneClass;

                \Illuminate\Support\Facades\Mail::send('client.emails.serviceMail', ['email' => $email], function ($message) use ($SUBJECT){
                    $message->from('info@easy-trademarks.com', 'Easytrademark');
                    $message->to(auth()->user()->email, auth()->user()->user_name)->subject($SUBJECT);
                });
            }

            $orderId = $order->id;
            $trademarkId = $trademark->id;
            return redirect("checkoutDetails/$trademarkId/$orderId");
        } else {
            $request->except('trademarkImg');
            $fullOrderData = [
                'submittedRequest' => $request->except('trademarkImg'),
                'trademark' => $trademark,
                'registration' => $registration,
                'order' => $order,
                'trademarkCountry' => $trademarkCountry,
                'trademarkCountryOrder' => $trademarkCountryOrder,
                'trademarkCountryClasses' => $trademarkCountryClasses
            ];
            session()->put('fullOrderData', $fullOrderData);
            session()->put('intendedUrl', route('store-registration-order-after-login'));
            return redirect()->route('forceUserLogin');
        }
    }

    public function publicationForm($trademarkCountryId, $countryId, $trademarkId)
    {
		$service_packages = ServicePackageFee::select('id')->where('service_id',7)->get();
		/*$tm_country = TrademarkCountry::with('orders')->whereHas('orders' ,  function ($query) use ($service_packages) {
            $query->whereIn('service_package_id', $service_packages);
        })->find($trademarkCountryId);*/
		
		$order = Order::whereIn('service_package_id', $service_packages)->with('trademark_country_order')->
		whereHas('trademark_country_order' ,  function ($query) use ($trademarkCountryId){
            $query->where('trademark_country_id', $trademarkCountryId);})->first();
		//$order = Order::whereIn('id',$tm_country->orders)->get();
		//return $order->trademark_country_order->id;
		if($order != ''){
			$id = Crypt::encryptString(($order->trademark_country_order)[0]->id);
			return redirect()->to('order/details/'.$id);
		}else{
			$country = Country::find($countryId);
			$packages = ServicePackageFee::where('service_id', 7)->with('package')->get();
			$trademarkFilling = TrademarkFilling::where('trademark_country_id',$trademarkCountryId)->first();
			return view('client.services.publication',
				[
					'trademarkFilling' =>$trademarkFilling,
					'trademarkCountryId' => $trademarkCountryId,
					'country' => $country,
					'packages' => $packages,
					'trademarkId' => $trademarkId
				]);
		}
		
		 
		
    }

    public function publicationStore(Request $request)
    {
        $systemDefaultCurrencyCode = Session::get('systemDefaultCurrencyCode');
        $userCountryCurrencyCode = Session::get('userCountryCurrencyCode');
        $service = Service::find(7);
        $order = new Order;
        $date = Carbon::createFromFormat('Y-m-d', Date('Y-m-d'));
        $allowedCurrencies = new AllowedCurrencies();
        $serviceFees = ServicePackageFee::where('id', $request->package)->first();
        $countryFees = ServicePackageCountryFee::where('service_package_id', $serviceFees->id)->where('country_id', $request->countryId)->first();
        $totalFees = $serviceFees->fee + $countryFees->fees;

        // add 3.5 from here to all calculation process
        $totalFees = $totalFees + round(($totalFees * self::STRIPE_FEES_PERCENTAGE) / 100, 2);

        if ($request->fastSreach == 'on') {
            $totalWithoutUpgrade = $totalFees + self::QUICK_TURNAROUND_COST;
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
            $order->total_fees = $totalFees;
            if ($userCountryCurrencyCode !== $systemDefaultCurrencyCode) {
                $order->total_fees_currency =
                    $allowedCurrencies->convertCurrency($totalFees, $systemDefaultCurrencyCode, $userCountryCurrencyCode);
            } else {
                $order->total_fees_currency = $totalFees;
            }
            $order->currency_type = $userCountryCurrencyCode;
            $daysToAdd = $service->execution_days;
        }
        $date = $date->addDays($daysToAdd);
        $order->due_date = $date;
        $order->service_package_id = $request->package;
        $order->save();
        $order->order_number = $service->service_abbreviation . '-00' . $order->id;
        $order->save();

        $trademarkCountryOrder = new TrademarkCountryOrder;
        $trademarkCountryOrder->trademark_country_id = $request->trademarkCountryId;
        $trademarkCountryOrder->order_id = $order->id;
        $trademarkResponseDefault = TrademarkResponse::where('service_id', $serviceFees->service_id)->first();
        $trademarkCountryOrder->response_id = $trademarkResponseDefault->id;
        $trademarkCountryOrder->save();

        $orderId = $order->id;
        $trademarkId = $request->trademarkId;
		$tm_detail = Trademark::find($trademarkId);
		
        $countryName = Country::where('id', $request->countryId)->first();

		if (App::environment('production')) {
                // Send email to client after ordering this service
                $email = new \stdClass();
				$email->user_name = auth()->user()->user_name;
				$email->order_id = $order->id;
				$email->tm_id = $request->trademarkId;
                $email->order_number = $order->order_number;
                $email->tm_ref = $tm_detail->trademark_reference;
                $email->trademark_label = $tm_detail->trademark_label;
                $email->country_name = $countryName->country_name_en;
                $email->total_fees_currency = $order->total_fees_currency;
                $email->userCountryCurrencyCode = $userCountryCurrencyCode;

                $SUBJECT = 'ACTION REQURED - order confirmation - '.$order->order_number.' - '.$tm_detail->trademark_reference.' - '.$tm_detail->trademark_label.' - '.$countryName->country_name_en;

                \Illuminate\Support\Facades\Mail::send('client.emails.serviceMail', ['email' => $email], function ($message) use ($SUBJECT){
                    $message->from('info@easy-trademarks.com', 'Easytrademark');
                    $message->to(auth()->user()->email, auth()->user()->user_name)->subject($SUBJECT);
                });
            }
		
		
        return redirect("checkoutDetails/$trademarkId/$orderId");
    }

    public function finalRegistrationForm($trademarkCountryId, $countryId, $trademarkId)
    {
        
		$service_packages = ServicePackageFee::select('id')->where('service_id',8)->get();
		/*$tm_country = TrademarkCountry::with('orders')->whereHas('orders' ,  function ($query) use ($service_packages) {
            $query->whereIn('service_package_id', $service_packages);
        })->find($trademarkCountryId);*/
		
		$order = Order::whereIn('service_package_id', $service_packages)->with('trademark_country_order')->
		whereHas('trademark_country_order' ,  function ($query) use ($trademarkCountryId){
            $query->where('trademark_country_id', $trademarkCountryId);})->first();
		//$order = Order::whereIn('id',$tm_country->orders)->get();
		//return $order->trademark_country_order->id;
		if($order != ''){
			$id = Crypt::encryptString(($order->trademark_country_order)[0]->id);
			return redirect()->to('order/details/'.$id);
		}else{
		$country = Country::find($countryId);
        $packages = ServicePackageFee::where('service_id', 8)->with('package')->with('country_package_fees')->get();
        $trademarkFilling = TrademarkFilling::where('trademark_country_id',$trademarkCountryId)->first();
        return view('client.services.finalRegistration',
            [
                'trademarkFilling' =>$trademarkFilling,
                'trademarkCountryId' => $trademarkCountryId,
                'country' => $country,
                'packages' => $packages,
                'trademarkId' => $trademarkId
            ]);
		}
    }

    public function finalRegistrationStore(Request $request)
    {
        $systemDefaultCurrencyCode = Session::get('systemDefaultCurrencyCode');
        $userCountryCurrencyCode = Session::get('userCountryCurrencyCode');
        $service = Service::find(8);
        $order = new Order;
        $date = Carbon::createFromFormat('Y-m-d', Date('Y-m-d'));
        $allowedCurrencies = new AllowedCurrencies();
        $serviceFees = ServicePackageFee::where('id', $request->package)->first();
        $countryFees = ServicePackageCountryFee::where('service_package_id', $serviceFees->id)->where('country_id', $request->countryId)->first();
        $totalFees = $serviceFees->fee + $countryFees->fees;

        // add 3.5 from here to all calculation process
        $totalFees = $totalFees + round(($totalFees * self::STRIPE_FEES_PERCENTAGE) / 100, 2);

        if ($request->fastSreach == 'on') {
            $totalWithoutUpgrade = $totalFees + self::QUICK_TURNAROUND_COST;
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
            $order->total_fees = $totalFees;
            if ($userCountryCurrencyCode !== $systemDefaultCurrencyCode) {
                $order->total_fees_currency =
                    $allowedCurrencies->convertCurrency($totalFees, $systemDefaultCurrencyCode, $userCountryCurrencyCode);
            } else {
                $order->total_fees_currency = $totalFees;
            }
            $order->currency_type = $userCountryCurrencyCode;
            $daysToAdd = $service->execution_days;
        }
        $date = $date->addDays($daysToAdd);
        $order->due_date = $date;
        $order->service_package_id = $request->package;
        $order->save();
        $order->order_number = $service->service_abbreviation . '-00' . $order->id;
        $order->save();

        $trademarkCountryOrder = new TrademarkCountryOrder;
        $trademarkCountryOrder->trademark_country_id = $request->trademarkCountryId;
        $trademarkCountryOrder->order_id = $order->id;
        $trademarkResponseDefault = TrademarkResponse::where('service_id', $service->id)->first();
        $trademarkCountryOrder->response_id = $trademarkResponseDefault->id;
        $trademarkCountryOrder->save();

        $orderId = $order->id;
        $trademarkId = $request->trademarkId;
		
		$tm_detail = Trademark::find($trademarkId);

        $countryName = Country::where('id', $request->countryId)->first();
		
		if (App::environment('production')) {
                // Send email to client after ordering this service
                $email = new \stdClass();
				$email->user_name = auth()->user()->user_name;
				$email->order_id = $order->id;
				$email->tm_id = $request->trademarkId;
                $email->order_number = $order->order_number;
                $email->tm_ref = $tm_detail->trademark_reference;
                $email->trademark_label = $tm_detail->trademark_label;
                $email->country_name = $countryName->country_name_en;
                $email->total_fees_currency = $order->total_fees_currency;
                $email->userCountryCurrencyCode = $userCountryCurrencyCode;

                $SUBJECT = 'ACTION REQURED - order confirmation - '.$order->order_number.' - '.$tm_detail->trademark_reference.' - '.$tm_detail->trademark_label.' - '.$countryName->country_name_en;

                \Illuminate\Support\Facades\Mail::send('client.emails.serviceMail', ['email' => $email], function ($message) use ($SUBJECT){
                    $message->from('info@easy-trademarks.com', 'Easytrademark');
                    $message->to(auth()->user()->email, auth()->user()->user_name)->subject($SUBJECT);
                });
            }
        return redirect("checkoutDetails/$trademarkId/$orderId");
    }

    public function storeRegistrationOrderAfterLogin (Request $request) {
        $fullOrderData = Session::get('fullOrderData');

        //return $fullOrderData;

        $userCountryCurrencyCode = Session::get('userCountryCurrencyCode');
        $submittedRequest = $fullOrderData['submittedRequest'];
        $trademark = $fullOrderData['trademark'];
        $service = Service::find($submittedRequest['serviceId']);
        $registration = $fullOrderData['registration'];
        $order = $fullOrderData['order'];
        $trademarkCountry = $fullOrderData['trademarkCountry'];
        $trademarkCountryOrder = $fullOrderData['trademarkCountryOrder'];
        $trademarkCountryClasses = $fullOrderData['trademarkCountryClasses'];

        if (!isset($submittedRequest['trademarkId'])) {
            $trademark->user_id = Auth::id();
            $trademark->save();
        }
        $order->save();
        $order->order_number = $service->service_abbreviation . '-00' . $order->id;
        $order->save();
        $registration->order_id = $order->id;
        $registration->save();
        // store in table TrademarkColor
        if (isset($submittedRequest['color']) && $submittedRequest['color'] != null) {
            foreach ($submittedRequest['color'] as $color) {
                $TrademarkColor = new TrademarkColor();
                $TrademarkColor->order_id = $order->id;
                $TrademarkColor->color_id = $color;
                $TrademarkColor->save();
            }
        }
        $trademarkCountry->trademark_id = $trademark->id;
        $trademarkCountry->save();
        $trademarkCountryOrder->trademark_country_id = $trademarkCountry->id;
        $trademarkCountryOrder->order_id = $order->id;
        $trademarkCountryOrder->save();
        $trademarkCountryClasses->trademark_country_id = $trademarkCountry->id;
        $trademarkCountryClasses->save();
        // store in table ClaimConventionDetail
        if (
        (isset($submittedRequest['fillingNumber']) && $submittedRequest['fillingNumber'] != null) &&
        (isset($submittedRequest['fillingDate']) && $submittedRequest['fillingDate'] != null) &&
        (isset($submittedRequest['country']) && $submittedRequest['country'] != null)
        ) {
            $filling = new ClaimConventionDetail;
            $filling->trademark_registration_id = $registration->id;
            $filling->country_id = $submittedRequest['country'];
            $filling->filling_number = $submittedRequest['fillingNumber'];
            $filling->filling_date = $submittedRequest['fillingDate'];
            $filling->status = 0;
            $filling->save();
        }

        $orderId = $order->id;
        $trademarkId = $trademark->id;
        //return $trademarkId;

        $countryName = Country::where('id', $trademarkCountry['country_id'])->first();
        // Send email to client after ordering this service
        if (App::environment('production')) {
            // Send email to client after ordering this service
            $email = new \stdClass();
            $email->user_name = auth()->user()->user_name;
            $email->order_id = $order->id;
            $email->tm_id = $trademarkId;
            $email->order_number = $order->order_number;
            $email->tm_ref = $trademark['trademark_reference'];
            $email->trademark_label = $trademark['trademark_label'];
            $email->isArabic = $request->isArabic;
            $email->explanation = $request->explanation;
            $email->brief = $request->brief;
            $email->country_name = $countryName->country_name_en;
            $email->OneClass = $trademarkCountryClasses['class_id'];
            $email->serviceDescription = $request->serviceDescription;
            $email->filling_number = $request->fillingNumber;
            $email->filling_date = $request->fillingDate;
            $email->total_fees_currency = $order->total_fees_currency;
            $email->userCountryCurrencyCode = $userCountryCurrencyCode;

            $SUBJECT = 'ACTION REQURED - order confirmation - '.$order->order_number.' - '.$trademark['trademark_reference'].' - '.$trademark['trademark_label'].' - '.$countryName->country_name_en.' - '.$trademarkCountryClasses['class_id'];

            \Illuminate\Support\Facades\Mail::send('client.emails.serviceMail', ['email' => $email], function ($message) use ($SUBJECT) {
                $message->from('info@easy-trademarks.com', 'Easytrademark');
                $message->to(auth()->user()->email, auth()->user()->name)->subject($SUBJECT);
            });
        }
        //$orderId = $order->id;
        //$trademarkId = $trademark->id;
        return redirect("checkoutDetails/$trademarkId/$orderId");
    }
}
