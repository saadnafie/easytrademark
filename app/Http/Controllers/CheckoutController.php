<?php

namespace App\Http\Controllers;

use App\Models\ClaimConventionDetail;
use App\Models\Classes;
use App\Models\Country;
use App\Models\Discount;
use App\Models\Order;
use App\Models\Service;
use App\Models\ServicePackageCountryFee;
use App\Models\ServicePackageFee;
use App\Models\Trademark;
use App\Models\TrademarkAddressChange;
use App\Models\TrademarkAssignment;
use App\Models\TrademarkColor;
use App\Models\TrademarkCountry;
use App\Models\TrademarkCountryClasses;
use App\Models\TrademarkCountryOrder;
use App\Models\TrademarkFilling;
use App\Models\TrademarkNameChange;
use App\Models\TrademarkRegistration;
use App\Models\TrademarkResponse;
use App\Models\UserDiscountHistory;
use App\Utility\AllowedCurrencies;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
    const STRIPE_FEES_PERCENTAGE = 3.5;
    const FAST_SEARCH_COST = 50 + (50 * self::STRIPE_FEES_PERCENTAGE) / 100;

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
     * show order details on checkout page
     *
     * @param $tid
     * @param $oid
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function checkoutDetails($tid, $oid)
    {
        if (Order::find($oid)) {
            $allServices = Service::all();
            $systemDefaultCurrencyCode = Session::get('systemDefaultCurrencyCode');
            $userCountryCurrencyCode = Session::get('userCountryCurrencyCode');
            $isDefaultCurrency = true;
            if ($userCountryCurrencyCode !== $systemDefaultCurrencyCode) {
                $isDefaultCurrency = false;
            }
            $trademark = Trademark::find($tid);
            $order = Order::with('service_package')->where('id', $oid)->with('trademark_country_order')->first();
            
			$excludeCountryIds = [];
                foreach ($order->trademark_country_order as $trademarkCountryOrder) {
                    $excludeCountryIds[] = $trademarkCountryOrder->trademark_country->country_id;
				}
					$allCountries = Country::whereNotIn('id', $excludeCountryIds)->where('isActive',1)->get();
			/*if (
                $order->service_package->service->service_name !== "Search" &&
                $order->service_package->service->service_name !== "Registration"
            ) {
                $excludeCountryIds = [];
                foreach ($order->trademark_country_order as $trademarkCountryOrder) {
                    $excludeCountryIds[] = $trademarkCountryOrder->trademark_country->country_id;
                }
                $allCountries = Country::whereNotIn('id', $excludeCountryIds)->get();
            } else {
                $allCountries = Country::all();
            }*/

            $data = TrademarkCountryOrder::where('order_id', $order->id)->with('order')->with('trademark_country')->get();
            $allClasses = Classes::all();
            $userCountryCurrencySymbol = Session::get('userCountryCurrencySymbol');
            return view('client.checkout.checkout',
                [
                    'allCountries' => $allCountries,
                    'trademark' => $trademark,
                    'order' => $order,
                    'allClasses' => $allClasses,
                    'currencySymbol' => $userCountryCurrencySymbol,
                    'isDefaultCurrency' => $isDefaultCurrency,
                    'allServices' => $allServices
                ]);
        } else {
            return view('client.errors.orderNotFound');
        }
    }

    /**
     * add another class on checkout page
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function addAnotherClass(Request $request)
    {
        if (Order::find($request->orderId)) {
            $systemDefaultCurrencyCode = Session::get('systemDefaultCurrencyCode');
            $userCountryCurrencyCode = Session::get('userCountryCurrencyCode');
            $TrademarkCountryClasses = new TrademarkCountryClasses();
            $TrademarkCountryClasses->trademark_country_id = $request->TrademarkCountryId;
            $TrademarkCountryClasses->class_id = $request->anotherClass;
            $TrademarkCountryClasses->save();
            $trademarkCountry = TrademarkCountry::where('id', $request->TrademarkCountryId)->first();
            $allowedCurrencies = new AllowedCurrencies();
            $order = Order::find($request->orderId);
            $orderTotalFees = $order->total_fees + $trademarkCountry->sub_total;
            $order->total_fees = $orderTotalFees;
            if ($userCountryCurrencyCode !== $systemDefaultCurrencyCode) {
                $order->total_fees_currency =
                    $allowedCurrencies->convertCurrency($orderTotalFees, $systemDefaultCurrencyCode, $userCountryCurrencyCode);
            } else {
                $order->total_fees_currency = $orderTotalFees;
            }
            $order->save();
            return redirect()->back();
        } else {
            return view('client.errors.orderNotFound');
        }
    }

    /**
     * delete class from checkout page
     * @param $classId
     * @param $trademarkCountryId
     * @param $orderId
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function deleteClass($classId, $trademarkCountryId, $orderId)
    {
        if (Order::find($orderId)) {
            $systemDefaultCurrencyCode = Session::get('systemDefaultCurrencyCode');
            $userCountryCurrencyCode = Session::get('userCountryCurrencyCode');
            $deleteClass = TrademarkCountryClasses::where('trademark_country_id', $trademarkCountryId)->where('class_id', $classId)->first();
            $trademarkCountry = TrademarkCountry::where('id', $trademarkCountryId)->first();
            $allowedCurrencies = new AllowedCurrencies();
            $order = Order::find($orderId);
            $orderTotalFees = $order->total_fees - $trademarkCountry->sub_total;
            $order->total_fees = $orderTotalFees;
            if ($userCountryCurrencyCode !== $systemDefaultCurrencyCode) {
                $order->total_fees_currency =
                    $allowedCurrencies->convertCurrency($orderTotalFees, $systemDefaultCurrencyCode, $userCountryCurrencyCode);
            } else {
                $order->total_fees_currency = $orderTotalFees;
            }
            $order->save();
            $deleteClass->delete();
            return redirect()->back();
        } else {
            return view('client.errors.orderNotFound');
        }
    }


    /**
     * add another country on checkout page
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function addAnotherCountry(Request $request)
    {
        $order = Order::find($request->orderId);
        if ($order) {
            $systemDefaultCurrencyCode = Session::get('systemDefaultCurrencyCode');
            $userCountryCurrencyCode = Session::get('userCountryCurrencyCode');
            $countryFees = ServicePackageCountryFee::where('country_id', $request->anotherCountry)->where('service_package_id', $request->servicePackageId)->first();
            $serviceFees = ServicePackageFee::find($request->servicePackageId);
            $trademarkCountry = new TrademarkCountry;
            $trademarkCountry->trademark_id = $request->trademarkId;
            $trademarkCountry->country_id = $request->anotherCountry;
            $subTotal = $countryFees->fees + $serviceFees->fee;
            //$subTotal = $subTotal + round(($subTotal * self::STRIPE_FEES_PERCENTAGE) / 100, 2);
            $trademarkCountry->sub_total = $subTotal;
            if ($order->discount_id !== null) {
                $discount = Discount::where('id', $order->discount_id)->first();
                if ($discount->is_percentage == true) {
                    // apply discount of the service fees value
                    $serviceFees->fee =
                        round($serviceFees->fee - (($serviceFees->fee * $discount->discount_amount) / 100), 2);
                } else {
                    $serviceFees->fee = $serviceFees->fee - $discount->discount_amount;
                }
                // update subtotal with new value after discounts
                $subTotal = $countryFees->fees + $serviceFees->fee;
                //$subTotal = $subTotal + round(($subTotal * self::STRIPE_FEES_PERCENTAGE) / 100, 2);
                $trademarkCountry->sub_total_after_discount = $subTotal;
                $trademarkCountry->discount_id = $discount->id;
            }

            $allowedCurrencies = new AllowedCurrencies();
            if ($userCountryCurrencyCode !== $systemDefaultCurrencyCode) {
                $trademarkCountry->sub_total_currency =
                    $allowedCurrencies->convertCurrency($subTotal, $systemDefaultCurrencyCode, $userCountryCurrencyCode);
            } else {
                $trademarkCountry->sub_total_currency = $subTotal;
            }
            if ($request->fastSearch == 'on') {
                $trademarkCountry->isFast = 1;
            } else {
                $trademarkCountry->isFast = 0;
            }
            $trademarkCountry->currency_type = $userCountryCurrencyCode;
            $trademarkCountry->save();
			
			//-----------------------filling data-----------------------------------
			if (isset($request->fillingDate) && isset($request->fillingNumber)){
			$trademarkFilling = new TrademarkFilling;
			$trademarkFilling->trademark_country_id = $trademarkCountry->id;
			$trademarkFilling->filling_date	 = $request->fillingDate;
			$trademarkFilling->filling_number = $request->fillingNumber;
			
			$trademarkFilling->save();
			}
			//----------------------------------------------------------------------

            $trademarkCountryOrder = new TrademarkCountryOrder;
            $trademarkCountryOrder->trademark_country_id = $trademarkCountry->id;
            $trademarkCountryOrder->order_id = $request->orderId;
            $trademarkResponseDefault = TrademarkResponse::where('service_id', $serviceFees->service_id)->first();
            $trademarkCountryOrder->response_id = $trademarkResponseDefault->id;
            $trademarkCountryOrder->save();

            if (isset($request->anotherClass)) {
                $TrademarkCountryClasses = new TrademarkCountryClasses();
                $TrademarkCountryClasses->trademark_country_id = $trademarkCountry->id;
                $TrademarkCountryClasses->class_id = $request->anotherClass;
                $TrademarkCountryClasses->save();
            }

            $allowedCurrencies = new AllowedCurrencies();
            if ($request->fastSearch == 'on') {
                $orderTotalFees = $order->total_fees + $trademarkCountry->sub_total + self::FAST_SEARCH_COST;
                $order->total_fees = $orderTotalFees;
                if ($userCountryCurrencyCode !== $systemDefaultCurrencyCode) {
                    $order->total_fees_currency = $allowedCurrencies->convertCurrency($orderTotalFees, $systemDefaultCurrencyCode, $userCountryCurrencyCode);
                } else {
                    $order->total_fees_currency = $orderTotalFees;
                }
            } else {
				$sub_total = $trademarkCountry->sub_total + round(($trademarkCountry->sub_total * self::STRIPE_FEES_PERCENTAGE) / 100, 2);
                $orderTotalFees = $order->total_fees + $sub_total;
				$order->total_fees = $orderTotalFees;
                if ($userCountryCurrencyCode !== $systemDefaultCurrencyCode) {
                    $order->total_fees_currency = $allowedCurrencies->convertCurrency($orderTotalFees, $systemDefaultCurrencyCode, $userCountryCurrencyCode);
                } else {
                    $order->total_fees_currency = $orderTotalFees;
                }
            }
            if ($order->discount_id !== null) {
                $order->final_fees_after_discount =
                    $order->final_fees_after_discount + $trademarkCountry->sub_total_after_discount;
                $order->total_fees_currency = $allowedCurrencies->convertCurrency($order->final_fees_after_discount, $systemDefaultCurrencyCode, $userCountryCurrencyCode);
            }
            $order->save();
            return redirect()->back();
        } else {
            return view('client.errors.orderNotFound');
        }
    }

    /**
     * delete country on checkout page
     *
     * @param $trademarkCountryId
     * @param $orderId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteCountry($trademarkCountryId, $orderId)
    {
        $order = Order::find($orderId);
        if ($order) {
            $systemDefaultCurrencyCode = Session::get('systemDefaultCurrencyCode');
            $userCountryCurrencyCode = Session::get('userCountryCurrencyCode');
            $TrademarkCountry = TrademarkCountry::where('id', $trademarkCountryId)->first();
            $TrademarkCountryClasses = TrademarkCountryClasses::where('trademark_country_id', $trademarkCountryId)->count();
            $allowedCurrencies = new AllowedCurrencies();
            if ($TrademarkCountry->isFast == 1 && $TrademarkCountry->isFast != null) {
                if ($TrademarkCountryClasses > 0) {
                    $orderTotalFees = $order->total_fees - ($TrademarkCountry->sub_total * $TrademarkCountryClasses) - self::FAST_SEARCH_COST;
                } else {
                    $orderTotalFees = $order->total_fees - ($TrademarkCountry->sub_total) - self::FAST_SEARCH_COST;
                }
                $order->total_fees = $orderTotalFees;
                if ($userCountryCurrencyCode !== $systemDefaultCurrencyCode) {
                    $order->total_fees_currency = $allowedCurrencies->convertCurrency($orderTotalFees, $systemDefaultCurrencyCode, $userCountryCurrencyCode);
                } else {
                    $order->total_fees_currency = $orderTotalFees;
                }
            } else {
                if ($TrademarkCountryClasses > 0) {
                    $orderTotalFees = $order->total_fees - ($TrademarkCountry->sub_total * $TrademarkCountryClasses);
                } else {
                    $orderTotalFees = $order->total_fees - ($TrademarkCountry->sub_total);
                }
                $order->total_fees = $orderTotalFees;
                if ($userCountryCurrencyCode !== $systemDefaultCurrencyCode) {
                    $order->total_fees_currency = $allowedCurrencies->convertCurrency($orderTotalFees, $systemDefaultCurrencyCode, $userCountryCurrencyCode);
                } else {
                    $order->total_fees_currency = $orderTotalFees;
                }
            }
            if ($order->discount_id !== null) {
                $order->final_fees_after_discount = $order->final_fees_after_discount - $TrademarkCountry->sub_total_after_discount;
                $order->total_fees_currency = $order->final_fees_after_discount;
                if ($userCountryCurrencyCode !== $systemDefaultCurrencyCode) {
                    $order->total_fees_currency = $allowedCurrencies->convertCurrency($order->final_fees_after_discount, $systemDefaultCurrencyCode, $userCountryCurrencyCode);
                }
            }

            $order->save();
			
			TrademarkFilling::where('trademark_country_id', $trademarkCountryId)->delete();
            TrademarkCountryClasses::where('trademark_country_id', $trademarkCountryId)->delete();
            TrademarkCountryOrder::where('trademark_country_id', $trademarkCountryId)->delete();
            TrademarkCountry::where('id', $trademarkCountryId)->delete();
            return redirect()->back();
        } else {
            return view('client.errors.orderNotFound');
        }
    }

    /**
     * delete the order
     *
     * @param $orderId
     * @param $trademarkId
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function deleteOrder($orderId, $trademarkId)
    {
        if (Order::find($orderId)) {
            $countries = TrademarkCountryOrder::select('trademark_country_id')->where('order_id', $orderId)->get();
            TrademarkCountryClasses::whereIn('trademark_country_id', $countries)->delete();
            TrademarkFilling::whereIn('trademark_country_id', $countries)->delete();
            TrademarkAddressChange::where('order_id', $orderId)->delete();
            TrademarkNameChange::where('order_id', $orderId)->delete();
            TrademarkAssignment::where('order_id', $orderId)->delete();
            TrademarkColor::where('order_id', $orderId)->delete();
            $registrationId = TrademarkRegistration::where('order_id', $orderId)->first();
            if (isset($registrationId->id) && $registrationId->id != null) {
                ClaimConventionDetail::where('trademark_registration_id', $registrationId->id)->delete();
            }
            TrademarkRegistration::where('order_id', $orderId)->delete();
            TrademarkCountryOrder::where('order_id', $orderId)->delete();
            UserDiscountHistory::where('order_id', $orderId)->delete();
            TrademarkCountry::whereIn('id', $countries)->delete();
            Order::find($orderId)->delete();
            $TrademarkCountryCount = TrademarkCountry::where('trademark_id', $trademarkId)->count();
            if ($TrademarkCountryCount == 0) {
                Trademark::find($trademarkId)->delete();
            }
            Session::flash('success', 'order deleted successful!');
            return redirect('home');
        } else {
            return view('client.errors.orderNotFound');
        }
    }

    public function applyDiscount(Request $request)
    {
        $systemDefaultCurrencyCode = Session::get('systemDefaultCurrencyCode');
        $userCountryCurrencyCode = Session::get('userCountryCurrencyCode');
        if (
            $request->has('discount-code') &&
            $request->get('discount-code') !== null &&
            !empty($request->get('discount-code'))
        ) {
            $orderId = $request->get('order-id');
            $discountAlias = strtolower(str_replace(' ', '-', $request->get('discount-code')));
            try {
                $discount = Discount::where('alias', $discountAlias)->firstOrFail();
            } catch (ModelNotFoundException $e) {
                return response()->json(
                    ['message' => 'Sorry this discount code is not valid!'],
                    404
                );
            }

            // validate if this order had applied discount before
            $discountAppliedToOrder =
                UserDiscountHistory::where(['order_id' => $orderId, 'discount_id' => $discount->id])->count();
            if ($discountAppliedToOrder >= 1) {
                return response()->json(
                    ['message' => 'Sorry you already applied a discount for this order please cancel old discount first'],
                    403
                );
            }

            // validate discount is valid for user
            if ($discount->allowed_num_of_use !== null) {
                $countOfUserUsageDiscountCode =
                    UserDiscountHistory::where(['user_id' => Auth::id(), 'discount_id' => $discount->id])
                        ->count();
                if ($countOfUserUsageDiscountCode >= $discount->allowed_num_of_use) {
                    return response()->json(
                        ['message' => 'Sorry you already passed the allowed number of usage for this discount code'],
                        403
                    );
                }
            }

            $order = Order::where('id', $orderId)->with('trademark_country_order')->with('service_package')->first();

            $countOfCountries = $order->trademark_country_order->count();

            // get the service fee with value of stripe percentage
            $totalServiceFees =
                round($order->service_package->fee + (($order->service_package->fee * self::STRIPE_FEES_PERCENTAGE) / 100), 2);
            // multiple with total number of added countries to order
            $totalServiceFeesForCountries = $totalServiceFees * $countOfCountries;

            if ($discount->is_percentage == true) {
                // apply discount of the service fees value
                $totalServiceFeesAfterDiscount =
                    round($totalServiceFeesForCountries - (($totalServiceFeesForCountries * $discount->discount_amount) / 100), 2);
            } else {
                $totalServiceFeesAfterDiscount = $totalServiceFeesForCountries - ($discount->discount_amount * $countOfCountries);
            }
            /* deduct the old value without discount from the total fees then all the new service fees value
                 after apply the discount on it */
            $order->final_fees_after_discount = $order->total_fees - $totalServiceFeesForCountries + $totalServiceFeesAfterDiscount;
            $order->total_fees_currency = $order->final_fees_after_discount;
            if ($userCountryCurrencyCode !== $systemDefaultCurrencyCode) {
                $allowedCurrencies = new AllowedCurrencies();
                $order->total_fees_currency =
                    $allowedCurrencies->convertCurrency($order->final_fees_after_discount, $systemDefaultCurrencyCode, $userCountryCurrencyCode);
            }
            $order->discount_id = $discount->id;
            $order->save();
            // loop through all trademark country order to add discounts on subtotal
            foreach ($order->trademark_country_order as $trademark_country_order) {
                if ($discount->is_percentage == true) {
                    $sub_total_after_discount =
                        round($trademark_country_order->trademark_country->sub_total
                            - (($totalServiceFees * $discount->discount_amount) / 100) , 2);
                } else {
                    $sub_total_after_discount =
                        $trademark_country_order->trademark_country->sub_total - $discount->discount_amount;
                }
                $trademark_country_order->trademark_country->sub_total_after_discount = $sub_total_after_discount;
                $trademark_country_order->trademark_country->sub_total_currency = $sub_total_after_discount;
                $trademark_country_order->trademark_country->discount_id = $discount->id;
                if ($userCountryCurrencyCode !== $systemDefaultCurrencyCode) {
                    $allowedCurrencies = new AllowedCurrencies();
                    $order->total_fees_currency =
                        $allowedCurrencies->convertCurrency($sub_total_after_discount, $systemDefaultCurrencyCode, $userCountryCurrencyCode);
                }
                $trademark_country_order->trademark_country->save();
            }

            $userDiscountHistory = new UserDiscountHistory();
            $userDiscountHistory->user_id = Auth::id();
            $userDiscountHistory->discount_id = $discount->id;
            $userDiscountHistory->order_id = $orderId;
            $userDiscountHistory->save();
            return response()->json(
                [
                    'message' => 'Discount applied successfully',
                    'discount' => $discount,
                    'userDiscountHistory' => $userDiscountHistory
                ],
                200
            );
        }
    }

    public function cancelDiscount($id)
    {
        $systemDefaultCurrencyCode = Session::get('systemDefaultCurrencyCode');
        // check if this discount is applied to this user
        try {
            $userDiscountHistory = UserDiscountHistory::where(['id' => $id, 'user_id' => Auth::id()])->first();
            $order = Order::where('id', $userDiscountHistory->order_id)->first();
            // remove foreign key and value of discounts in orders table
            $order->discount_id = null;
            $order->final_fees_after_discount = 0.00;
            $order->total_fees_currency = $order->total_fees;
            // check if currency of order wasn't same default system currency to convert it to base order currency type
            $allowedCurrencies = new AllowedCurrencies();
            if ($order->currency_type !== $systemDefaultCurrencyCode) {
                $order->total_fees_currency =
                    $allowedCurrencies->convertCurrency($order->total_fees, $systemDefaultCurrencyCode, $order->currency_type);
            }
            $order->save();
            foreach ($order->trademark_country_order as $trademarkCountryOrder) {
                $trademarkCountry = TrademarkCountry::where('id', $trademarkCountryOrder->trademark_country->id)->first();
                $trademarkCountry->discount_id = null;
                $trademarkCountry->sub_total_after_discount = 0.00;
                $trademarkCountry->sub_total_currency = $trademarkCountry->sub_total;
                if ($order->currency_type !== $systemDefaultCurrencyCode) {
                    $trademarkCountry->sub_total_currency =
                        $allowedCurrencies->convertCurrency($trademarkCountry->sub_total, $systemDefaultCurrencyCode, $trademarkCountry->currency_type);
                }
                $trademarkCountry->save();
            }
            // delete this discount from history
            $userDiscountHistory->delete();
            return response()->json(
                ['message' => 'Discount cancelled successfully'],
                200
            );

        } catch (ModelNotFoundException $e) {
            return response()->json(
                ['message' => 'Sorry this discount is not related to your current order'],
                404
            );
        }
    }
}
