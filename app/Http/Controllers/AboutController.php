<?php

namespace App\Http\Controllers;

/**
 * Class AboutController
 * @package App\Http\Controllers
 * @author Andrew Nady <andro.nady2015@gmail.com>
 */
 
use App\Models\ServicePackageFee;
use App\Models\ServicePackageCountryFee;
use App\Models\Classes;
use App\Models\CountryClass;

class AboutController extends Controller
{
    /**
     * show about us page
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('client.about');
    }
	
	
	public function set_new_country_packages(){
		$country = 19;
		$service_packages = ServicePackageFee::all();
		foreach($service_packages as $s_p){
			$service_package_country = new ServicePackageCountryFee();
			$service_package_country->service_package_id = $s_p->id;
			$service_package_country->country_id = $country;
			$service_package_country->fees = 0;
			$service_package_country->save();
		}
		return "success";
	}
	
	public function set_new_country_classes(){
		$country = 19;
		$allclasses = Classes::all();
		foreach($allclasses as $classval){
			$country_classes = new CountryClass();
			$country_classes->class_id = $classval->id;
			$country_classes->country_id = $country;
			$country_classes->save();
		}
		return "success";
	}
}
