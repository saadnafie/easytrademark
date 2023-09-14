<?php

namespace App\Http\Controllers;

use App\Models\TrademarkCountry;
use App\Models\TrademarkCountryOrder;
use App\Models\TrademarkResponse;
use App\Utility\AllowedCurrencies;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\ServicePackageFee;
use App\Models\Package;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use App\Models\ServicePackageCountryFee;
use App\Models\TrademarkCountryClasses;
use App\Models\Service;
use App\Models\Trademark;
use App\Models\CountryClass;
use App\Models\Country;
use App\Models\Order;
use Auth;
use Redirect;
use Illuminate\Support\Facades\Validator;

/**
 * Class SearchServiceController
 * @package App\Http\Controllers
 * @author Andrew Nady <andro.nady2015@gmail.com>
 */
class SearchServiceController extends Controller
{
    const STRIPE_FEES_PERCENTAGE = 3.5;
	const FAST_SEARCH_COST = 50;
    //const FAST_SEARCH_COST = 50 + (50 * self::STRIPE_FEES_PERCENTAGE) / 100;

    /**
     * show search service form ( stepper )
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
        $fastSearchCost = self::FAST_SEARCH_COST;
        $allCountries = Country::all();
        $allClasses = CountryClass::where('country_id', $countryId)->get();
        $selectedCountry = Country::find($countryId);
        $trademarkLabel = $request->existingTrademarkLabel;
        $trademarkId = $request->existingTrademark;
        $package = Package::find($packageID);
        $servicePackageFee = ServicePackageFee::where('package_id', $packageID)->with('package')->first();
        $servicePackageCountryFee = ServicePackageCountryFee::where('service_package_id', $servicePackageFee->id)->where('country_id', $countryId)->first();
        if ($userCountryCurrencyCode !== $systemDefaultCurrencyCode) {
            $userCountryCurrencyCode = Session::get('userCountryCurrencyCode');
            $allowedCurrencies = new AllowedCurrencies();
            $fastSearchCost =
                $allowedCurrencies->convertCurrency($fastSearchCost, $systemDefaultCurrencyCode, $userCountryCurrencyCode);
        }
        $nextFlag = $package->flag + 2;
        $nextPackage = Service::find($serviceId)->package->where('flag', $nextFlag)->first();
        $returnData = [
            'countryPackageFees' => $countryPackageFees,
            'allCountries' => $allCountries,
            'allClasses' => $allClasses,
            'selectedCountry' => $selectedCountry,
            'serviceId' => $serviceId,
            'fastSearch' => $fastSearchCost,
            'currencySymbol' => $userCountryCurrencySymbol,
            'trademarkLabel' => $trademarkLabel,
            'trademarkId' => $trademarkId,
            'package' => $package,
            'existingTrademarkLabel' => $request->existingTrademarkLabel,
            'newTrademarkLabel' => $request->newTrademarkLabel,
            'existingTrademarkId' => $request->existingTrademarkId,
        ];
        if ($nextPackage == null) {
            return view('client.services.search', $returnData);
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

            return view('client.services.search', $returnData);
        }
    }

    /**
     * Store Search service data in DB
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function store(Request $request)
    {
        $systemDefaultCurrencyCode = Session::get('systemDefaultCurrencyCode');
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

                $countryName = Country::where('id', $request->countryId)->first();

                if (App::environment('production')) {
                    // Send email to client after ordering this service
                    $email = new \stdClass();
					$email->user_name = auth()->user()->user_name;
                    $email->order_id = $order->id;
                    $email->tm_id = $searchService->id;
                    $email->order_number = $order->order_number;
                    $email->trademark_word_en = $request->trademarkEnglishWord;
                    $email->trademark_word_ar = $request->trademarkArabicWord;
                    $email->tm_ref = $searchService->trademark_reference;
                    $email->trademark_label = $request->trademarkLabel;
                    $email->country_name = $countryName->country_name_en;
                    $email->class = $request->trademarkClasse;
                    $email->total_fees_currency = $order->total_fees_currency;
                    $email->userCountryCurrencyCode = $userCountryCurrencyCode;

                    $SUBJECT = 'ACTION REQURED - order confirmation - '.$order->order_number.' - '.$searchService->trademark_reference.' - '.$$request->trademarkLabel.' - '.$countryName->country_name_en.' - '.$request->trademarkClasse;

                    Mail::send('client.emails.serviceMail', ['email' => $email], function ($message) use ($SUBJECT){
                        $message->from('info@easy-trademarks.com', 'Easytrademark');
                        $message->to(auth()->user()->email, auth()->user()->user_name)->subject($SUBJECT);
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
            }
    }

    public function storeOrderAfterLogin (Request $request) {
        $fullOrderData = Session::get('fullOrderData');
        //$searchService = $fullOrderData['searchService'];
        //return $searchService['trademark_label'];
        //return $fullOrderData;

        $userCountryCurrencyCode = Session::get('userCountryCurrencyCode');
        $submittedRequest = $fullOrderData['submittedRequest'];
        $searchService = $fullOrderData['searchService']; // need auth user_id
        $service = Service::find($submittedRequest['serviceId']);
        $order = $fullOrderData['order'];
        $trademarkCountry = $fullOrderData['trademarkCountry'];
        $trademarkCountryOrder = $fullOrderData['trademarkCountryOrder'];
        $trademarkCountryClasses = $fullOrderData['trademarkCountryClasses'];
        if (!isset($submittedRequest['trademarkId'])) {
            $searchService->user_id = Auth::id();
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

        $countryName = Country::where('id', $trademarkCountry['country_id'])->first();
        
        

        if (App::environment('production')) {
            // Send email to client after ordering this service
            $email = new \stdClass();
            $email->user_name = auth()->user()->user_name;
            $email->order_id = $order->id;
            $email->tm_id = $searchService->id;
            $email->order_number = $order->order_number;
            $email->trademark_word_en = $searchService['trademarkEnglishWord'];
            $email->trademark_word_ar = $searchService['trademarkArabicWord'];
            $email->tm_ref = $searchService['trademark_reference'];
            $email->trademark_label = $searchService['trademark_label'];
            $email->country_name = $countryName->country_name_en;
            $email->class = $trademarkCountryClasses['class_id'];
            $email->total_fees_currency = $order->total_fees_currency;
            $email->userCountryCurrencyCode = $userCountryCurrencyCode;

            $SUBJECT = 'ACTION REQURED - order confirmation - '.$order->order_number.' - '.$searchService['trademark_reference'].' - '.$searchService['trademark_label'].' - '.$countryName->country_name_en.' - '.$trademarkCountryClasses['class_id'];

            Mail::send('client.emails.serviceMail', ['email' => $email], function ($message) use ($SUBJECT){
                $message->from('info@easy-trademarks.com', 'Easytrademark');
                $message->to(auth()->user()->email, auth()->user()->name)->subject($SUBJECT);
            });
        }
        $orderId = $order->id;
        $searchServiceId = $searchService->id;
        return redirect("checkoutDetails/$searchServiceId/$orderId");
    }
}
