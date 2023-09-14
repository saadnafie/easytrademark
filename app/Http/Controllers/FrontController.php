<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\CountryClass;
use App\Models\Order;
use App\Models\Package;
use App\Models\Trademark;
use App\Models\TrademarkCountryClasses;
use App\Utility\AllowedCurrencies;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Models\CountryClasses;
use App\Models\ServicePackageFee;
use App\Models\ServicePackageCountryFee;
use App\Models\Service;
use App\Models\Country;
use App\Models\ServiceHowDetail;
use Auth;
use Illuminate\Support\Facades\Session;
use Symfony\Component\Intl\Currencies;
use App;

/**
 * Class FrontController
 * @package App\Http\Controllers
 * @author Andrew Nady <andro.nady2015@gmail.com>
 */
class FrontController extends Controller
{
    /**
     *  show all  countries in homePage
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function home()
    {
        $s = 'country_name_' . App::getLocale();
        $allCountries = Country::where('isActive',1)->orderBy($s,'asc')->get();
        return view('client.home', ['allCountries' => $allCountries]);
    }

    /**
     * show all countries on search page
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function search()
    {
        $allCountries = Country::where('isActive',1)->get();
        return view('client.search', ['allCountries' => $allCountries]);
    }

    /**
     * pass to ajax function on search service  all classes depend on country selected
     *
     * @param $countryID
     * @return mixed
     */
    public function getClassesCountry($countryID)
    {
        return CountryClasses::where('country_id', $countryID)->get();
    }

    /**
     * pass to ajax function on search page all services fees and details
     *
     * @param $id
     * @return mixed
     */
    public function getServiceShowDetails($id)
    {
        return ServiceHowDetail::where('service_id', $id)->get();
    }

    /**
     * pass to ajax function on search page every service details
     *
     * @param $id
     * @return mixed
     */
    public function getServiceDetails($id)
    {
        return Service::find($id);
    }

    /**
     * get all packages with official fees and governmental fess
     *
     * @param $serviceID
     * @param $countryId
     * @return mixed
     * @throws \AshAllenDesign\LaravelExchangeRates\Exceptions\ExchangeRateException
     * @throws \AshAllenDesign\LaravelExchangeRates\Exceptions\InvalidCurrencyException
     * @throws \AshAllenDesign\LaravelExchangeRates\Exceptions\InvalidDateException
     */
    public function getPackages($serviceID, $countryId)
    {
        $servicePackageFeeId = ServicePackageFee::select('id')->where('service_id', $serviceID)->get();
        $servicePackagesCountryFees = ServicePackageCountryFee::whereIn('service_package_id', $servicePackageFeeId)
            ->where('isActive', 1)
            ->where('country_id', $countryId)->with('country')
            ->with('service_package')->get();
        $systemDefaultCurrencyCode = Session::get('systemDefaultCurrencyCode');
        $userCountryCurrencyCode = Session::get('userCountryCurrencyCode');
        $userCountryCurrencySymbol = Session::get('userCountryCurrencySymbol');
        $allowedCurrencies = new AllowedCurrencies();
        foreach ($servicePackagesCountryFees as &$servicePackageCountryFee) {
            $servicePackageCountryFee->symbol = $userCountryCurrencySymbol;
            // if current user use the default system currency we don't need any currency conversion
            if ($userCountryCurrencyCode !== $systemDefaultCurrencyCode) {
                $servicePackageCountryFee->fees =
                    $allowedCurrencies->convertCurrency($servicePackageCountryFee->fees, $systemDefaultCurrencyCode, $userCountryCurrencyCode);
                $servicePackageCountryFee->service_package->fee =
                    $allowedCurrencies->convertCurrency($servicePackageCountryFee->service_package->fee, $systemDefaultCurrencyCode, $userCountryCurrencyCode);
            }
        }
        return $servicePackagesCountryFees;
    }

    /**
     * pass to ajax function on search page every package details ( service_id only )
     *
     * @param $serviceID
     * @return mixed
     */
    public function getPackageServiceId($serviceID)
    {
        return ServicePackageFee::where('service_id', $serviceID)->with('package')->get();
    }

    /**
     * get all documents in required documents page depend on country_id
     *
     * @param $countryId
     * @return array
     */
    public function getServiceDocuments($countryId)
    {
        $Documents = Service::with('service_country_doc')->whereHas('service_country_doc', function ($query) use ($countryId) {
            $query->where('country_id', $countryId);
        })->get();
        $country = Country::find($countryId);
        return [$Documents, $country];
    }

    /**
     * get the description for selected class on registration service
     *
     * @param $classId
     * @return mixed
     */
    public function getClassDescription($classId)
    {
        return Classes::find($classId);
    }

    /**
     * fetch country classes on checkout page ( add Country/Class )
     * @param $countryId
     * @param $orderId
     * @return mixed
     */
    public function getClasses($countryId, $orderId){
        $order =  Order::where('id',$orderId)->first();
        $trademarkCountryIds = [];
        $useExcludeCountryClasses = false;
        foreach ($order->trademark_country_order as $trademarkCountryOrder) {
            if ($trademarkCountryOrder->trademark_country->country_id == $countryId) {
                $useExcludeCountryClasses = true;
                $trademarkCountryIds[] = $trademarkCountryOrder->trademark_country_id;
            }
        }
        if ($useExcludeCountryClasses == true) {
            $trademarkCountryClasses = TrademarkCountryClasses::whereIn('trademark_country_id', $trademarkCountryIds)->get();
            $excludeClassIds = [];
            foreach ($trademarkCountryClasses as $trademarkCountryClass) {
                $excludeClassIds[] = $trademarkCountryClass->class_id;
            }
            return CountryClass::where('country_id', $countryId)->whereNotIn('class_id', $excludeClassIds)->get();
        }

        return CountryClass::where('country_id', $countryId)->get();
    }

    /**
     * show first Question before going to any service process
     *
     * @param $packageId
     * @param $serviceId
     * @param $countryId
     * @param $countryPackageFees
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function validateTrademark($packageId, $serviceId, $countryId, $countryPackageFees)
    {
        try {
            $packageId = Package::findOrFail($packageId);
            $selectedCountry = Country::findOrFail($countryId);
        } catch (ModelNotFoundException $e) {
            return view('client.errors.copyof404');
        }

        $existingTrademarks = Trademark::where('user_id', Auth::id())->get();
        return view('client.services.firstQuestion',
            [
                'countryPackageFees' => $countryPackageFees,
                'existingTrademarks' => $existingTrademarks,
                'packageId' => $packageId->id,
                'selectedCountry' => $selectedCountry,
                'countryId' => $countryId,
                'serviceId' => $serviceId,
            ]);
    }

    /**
     * after the first question page redirect to selected service process depend on service_id
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectServiceProcess(Request $request)
    {
        $serviceId = $request->get('serviceId');
        $packageId = $request->get('packageId');
        $countryId = $request->get('countryId');
        $countryPackageFeesID = $request->get('countryPackageFeesID');
        $existingTrademarkLabel = $request->existingTrademarkLabel;
        $newTrademarkLabel = $request->newTrademarkLabel;
        $existingTrademarkId = $request->existingTrademarkId;
        $returnData = [
            'package_id' => $packageId,
            'serviceId' => $serviceId,
            'countryId' => $countryId,
            'countryPackages' => $countryPackageFeesID,
            'existingTrademarkLabel' => $existingTrademarkLabel,
            'newTrademarkLabel' => $newTrademarkLabel,
            'existingTrademarkId' => $existingTrademarkId
        ];
        switch ($serviceId) {
            case 1:
                return redirect()->route('searchProcess', $returnData);
                break;
            case 2:
                return redirect()->route('registrationProcess', $returnData);
                break;
            case 3:
                return redirect()->route('renewalProcess', $returnData);
                break;
            case 4:
                return redirect()->route('assignmentProcess', $returnData);
                break;
            case 5:
                return redirect()->route('nameChangeProcess', $returnData);
                break;
            case 6:
                return redirect()->route('addressChangeProcess', $returnData);
                break;
        }
    }

    /**
     * update currency for user after he change the currency he want to use
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function userCurrency(Request $request)
    {
        //dd($request);
        $userSelectedCurrencyCode = $request->get('currencyCode');
        $userCountryCurrencySymbol = Currencies::getSymbol($userSelectedCurrencyCode);
        Session::put('userCountryCurrencyCode', $userSelectedCurrencyCode);
        Session::put('userCountryCurrencySymbol', $userCountryCurrencySymbol);
        return response()->json([], 200);
    }

    /**
     * show 404 , 500 error page
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function pageNotFound()
    {
        return view('client.errors.pageNotFound');
    }

    /**
     * force user to login to can continue process of creating order of new trademark service
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function forceUserLogin(Request $request)
    {
        if ($request->has('intendedUrl') && !empty($request->get('intendedUrl'))) {
            Session::put('url.intended', $request->get('intendedUrl'));
            return redirect()->route('login');
        } else {
            Session::put('url.intended', Session::get('intendedUrl'));
            return redirect()->route('login');
        }
    }

    /**
     * get lowest package fess on search box home page
     *
     * @param $countryId
     * @param $serviceId
     * @return mixed
     */
    public function getLowestPackageFees($serviceId, $countryId){

        $servicePackageFeeIdAll = ServicePackageFee::where('service_id', $serviceId)->get();
        $servicePackageFeeId = ServicePackageFee::select('id')->where('service_id', $serviceId)->get();
        $servicePackagesCountryFees = ServicePackageCountryFee::whereIn('service_package_id', $servicePackageFeeId)
            ->where('isActive', 1)
            ->where('country_id', $countryId)
            ->get();
        $lowPackageFee = [];
        $lowPackageCountryFee = [];
        foreach ($servicePackageFeeIdAll as $data){
            $lowPackageFee[] = $data->fee;
        }
        foreach ($servicePackagesCountryFees as $data){
            $lowPackageCountryFee[] = $data->fees;
        }
        return min($lowPackageFee) + min($lowPackageCountryFee);
    }
}
