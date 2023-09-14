<?php

namespace App\Http\Controllers;

use App\Models\TrademarkCountry;
use App\Models\TrademarkCountryOrder;
use App\Models\TrademarkResponse;
use App\Models\TrademarkServicePackageCountry;
use App\Utility\AllowedCurrencies;
use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\Package;
use App\Models\TrademarkNameChange;
use App\Models\Trademark;
use Auth;
use Illuminate\Support\Facades\App;
use Mail;
use Redirect;
use Carbon\Carbon;
use App\Models\Service;
use App\Models\ServicePackageFee;
use App\Models\ServicePackageCountryFee;
use App\Models\Order;
use App\Models\TrademarkFilling;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

/**
 * Class NameChangeServiceController
 * @package App\Http\Controllers
 * @author Andrew Nady <andro.nady2015@gmail.com>
 */
class NameChangeServiceController extends Controller
{
    const STRIPE_FEES_PERCENTAGE = 3.5;
    const QUICK_TURNAROUND_COST = 50;
    //const QUICK_TURNAROUND_COST = 50 + (50 * self::STRIPE_FEES_PERCENTAGE) / 100;

    /**
     * show name change service form ( stepper )
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
        $allCountries = Country::all();
        $selectedCountry = Country::find($countryId);
        $trademarkLabel = $request->existingTrademarkLabel;
        $trademarkId = $request->existingTrademark;
        $selectedPackage = Package::find($packageID);
        $servicePackageFee = ServicePackageFee::where('package_id', $packageID)->with('package')->first();
        $servicePackageCountryFee = ServicePackageCountryFee::where('service_package_id', $servicePackageFee->id)->where('country_id', $countryId)->first();
        if ($userCountryCurrencyCode !== $systemDefaultCurrencyCode) {
            $userCountryCurrencyCode = Session::get('userCountryCurrencyCode');
            $allowedCurrencies = new AllowedCurrencies();
            $quickTurnaroundCost =
                $allowedCurrencies->convertCurrency($quickTurnaroundCost, $systemDefaultCurrencyCode, $userCountryCurrencyCode);
        }
        $nextFlag = $selectedPackage->flag + 1;
        $nextPackage = Service::find($serviceId)->package->where('flag', $nextFlag)->first();
        $returnData = [
            'allCountries' => $allCountries,
            'selectedCountry' => $selectedCountry,
            'countryPackageFees' => $countryPackageFees,
            'serviceId' => $serviceId,
            'quickTurnaround' => $quickTurnaroundCost,
            'currencySymbol' => $userCountryCurrencySymbol,
            'trademarkLabel' => $trademarkLabel,
            'trademarkId' => $trademarkId,
            'package' => $selectedPackage,
            'existingTrademarkLabel' => $request->existingTrademarkLabel,
            'newTrademarkLabel' => $request->newTrademarkLabel,
            'existingTrademarkId' => $request->existingTrademarkId
        ];
        if ($nextPackage == null) {
            return view('client.services.nameChange', $returnData);
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
            return view('client.services.nameChange', $returnData);
        }
    }


    /**
     * store name change service in DB
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function store(Request $request)
    {
        $systemDefaultCurrencyCode = Session::get('systemDefaultCurrencyCode');
        $userCountryCurrencyCode = Session::get('userCountryCurrencyCode');
        // Validator
        $validator = Validator::make($request->all(), [
            'trademarkImg' => ['required', 'mimes:jpeg,jpg,png,gif', 'max:30720'],
            'oldName' => ['required', 'string'],
            'newName' => ['required', 'string', 'different:oldName'],
            'fillingNumber' => ['required', 'string'],
            'fillingDate' => ['required', 'date', 'before:today'],
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
            $trademark->deadline = '11/11/11';
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

        // add 3.5 from here to all calculation process
        $totalWithoutUpgrade = $totalWithoutUpgrade + round(($totalWithoutUpgrade * self::STRIPE_FEES_PERCENTAGE) / 100, 2);

        // select service based on service which selected in the beginning of the process ( search box ( country - service ))
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

        $trademarkCountry = new TrademarkCountry;
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
        $trademarkResponseDefault = TrademarkResponse::where('service_id', $request->serviceId)->first();
        $trademarkCountryOrder->response_id = $trademarkResponseDefault->id;

        // store in table TrademarkNameChange
        $address = new TrademarkNameChange;
        $address->old_name = $request->oldName;
        $address->new_name = $request->newName;
        $address->status = 0;

        // store in table TrademarkFilling
        $filling = new TrademarkFilling;
        $filling->filling_number = $request->fillingNumber;
        $filling->filling_date = $request->fillingDate;

        if (Auth::check() == true) {
            if ($request->trademarkId == null) {
                $trademark->save();
            }
            $order->save();
            $order->order_number = $service->service_abbreviation . '-00' . $order->id;
            $order->save();
            $trademarkCountry->trademark_id = $trademark->id;
            $trademarkCountry->save();
            $trademarkCountryOrder->trademark_country_id = $trademarkCountry->id;
            $trademarkCountryOrder->order_id = $order->id;
            $trademarkCountryOrder->save();
            $address->order_id = $order->id;
            $address->save();
            $filling->trademark_country_id = $trademarkCountry->id;
            $filling->save();

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
                $email->country_name = $countryName->country_name_en;
                $email->old_name = $request->oldName;
                $email->new_name = $request->newName;
                $email->filling_number = $request->fillingNumber;
                $email->filling_date = $request->fillingDate;
                $email->total_fees_currency = $order->total_fees_currency;
                $email->userCountryCurrencyCode = $userCountryCurrencyCode;

                $SUBJECT = 'ACTION REQURED - order confirmation - '.$order->order_number.' - '.$trademark->trademark_reference.' - '.$request->trademarkLabel.' - '.$countryName->country_name_en;


                \Illuminate\Support\Facades\Mail::send('client.emails.serviceMail', ['email' => $email], function ($message) use ($SUBJECT)  {
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
                'order' => $order,
                'trademarkCountry' => $trademarkCountry,
                'trademarkCountryOrder' => $trademarkCountryOrder,
                'address' => $address,
                'filling' => $filling
            ];
            session()->put('fullOrderData', $fullOrderData);
            session()->put('intendedUrl', route('store-name-change-order-after-login'));
            return redirect()->route('forceUserLogin');
        }
    }

    public function storeNameChangeOrderAfterLogin (Request $request) {
        $fullOrderData = Session::get('fullOrderData');
        $userCountryCurrencyCode = Session::get('userCountryCurrencyCode');
        $submittedRequest = $fullOrderData['submittedRequest'];
        $trademark = $fullOrderData['trademark'];
        $service = Service::find($submittedRequest['serviceId']);
        $order = $fullOrderData['order'];
        $trademarkCountry = $fullOrderData['trademarkCountry'];
        $trademarkCountryOrder = $fullOrderData['trademarkCountryOrder'];
        $address = $fullOrderData['address'];
        $filling = $fullOrderData['filling'];
        if (!isset($submittedRequest['trademarkId'])) {
            $trademark->user_id = Auth::id();
            $trademark->save();
        }
        $order->save();
        $order->order_number = $service->service_abbreviation . '-00' . $order->id;
        $order->save();

        $trademarkCountry->trademark_id = $trademark->id;
        $trademarkCountry->save();
        $trademarkCountryOrder->trademark_country_id = $trademarkCountry->id;
        $trademarkCountryOrder->order_id = $order->id;
        $trademarkCountryOrder->save();
        $address->order_id = $order->id;
        $address->save();
        $filling->trademark_country_id = $trademarkCountry->id;
        $filling->save();

        $orderId = $order->id;
        $trademarkId = $trademark->id;
        // Send email to client after ordering this service
        if (App::environment('production')) {
            // Send email to client after ordering this service
            $email = new \stdClass();
            $email->user_name = auth()->user()->user_name;
            $email->order_id = $order->id;
            $email->tm_id = $trademark->id;
            $email->order_number = $order->order_number;
            $email->trademark_label = $request->trademarkLabel;
            $email->old_name = $request->oldName;
            $email->new_name = $request->newName;
            $email->filling_number = $request->fillingNumber;
            $email->filling_date = $request->fillingDate;
            $email->total_fees_currency = $order->total_fees_currency;
            $email->userCountryCurrencyCode = $userCountryCurrencyCode;
            \Illuminate\Support\Facades\Mail::send('client.emails.serviceMail', ['email' => $email], function ($message) {
                $message->from('info@easy-trademarks.com', 'Easytrademark');
                $message->to(auth()->user()->email, auth()->user()->name)->subject('We received Your Order ! ');
            });
        }
        
        return redirect("checkoutDetails/$trademarkId/$orderId");
    }
}
