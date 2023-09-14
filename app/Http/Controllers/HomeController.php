<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\User;
use App\Models\Country;
use App\Models\Package;
use App\Models\Classes;
use App\Models\Order;
use App\Models\Trademark;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
		if(auth()->user()->user_type_id == 1 || auth()->user()->user_type_id == 2){
			$customers = count(User::where('user_type_id',4)->get());
			$members = count(User::where('user_type_id',3)->get());
			$orders = count(Order::all());
			$services = count(Service::all());
			$packages = count(Package::all());
			$countries = count(Country::all());
			$classes = count(Classes::all());
		    return view('admin.dashboard',compact('customers','members','orders','services','packages','countries','classes'));

		}else if(auth()->user()->user_type_id == 3){
			return view('member.dashboard');
			/*$end_date = '';
			$start_date = '';
			$tmarks = Trademark::with('user')->get();
			return view('member.trademarks',compact('tmarks','end_date','start_date'));*/

		}else if(auth()->user()->user_type_id == 4){

            $allCountries = Country::where('isActive',1)->orderBy('country_name','asc')->get();

		return redirect()->route('client.home',['allCountries'=>$allCountries]);
		}
    }
}
