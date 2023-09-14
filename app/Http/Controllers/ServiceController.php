<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Country;
use App\Models\ServicePackageFee;
use App;

/**
 * Class ServiceController
 * @package App\Http\Controllers
 * @author Andrew Nady <andro.nady2015@gmail.com>
 */
class ServiceController extends Controller
{
    /**
     * show all countries on search page
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function search()
    {
        $countryNameOrderBy = 'country_name_' . App::getLocale();
        $allCountries = Country::where('isActive',1)->orderBy($countryNameOrderBy, 'asc')->get();
        return view('client.search', ['allCountries' => $allCountries]);
    }

    /**
     * search on home page with country and service
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function homeSearch(Request $request)
    {
        $countryNameOrderBy = 'country_name_' . App::getLocale();
        $allCountries = Country::where('isActive',1)->orderBy($countryNameOrderBy, 'asc')->get();
        $service = $request->service;
        $country = $request->country;
        $packagesFees = ServicePackageFee::where('service_id', $service)->with('service')->with('package')->with('country_package_fees')->whereHas('country_package_fees', function ($query) use ($country) {
            $query->where('country_id', $country);
        })->get();
        $countryName = Country::find($country);
        $data = ['packageFees' => $packagesFees, 'countryName' => $countryName];
        return view('client.search', ['allCountries' => $allCountries, 'searchService' => $service, 'searchCountry' => $country, 'data' => $data]);
    }

    /**
     * show search result on search page with service id
     *
     * @param $serviceID
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function searchId($serviceID)
    {
        $countryNameOrderBy = 'country_name_' . App::getLocale();
        $selectedService = Service::find($serviceID);
        $allCountries = Country::where('isActive',1)->orderBy($countryNameOrderBy, 'asc')->get();
        return view('client.searchId', ['allCountries' => $allCountries, 'selectedService' => $selectedService]);
    }
}
