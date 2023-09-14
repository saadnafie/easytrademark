<?php

namespace App\Http\Controllers;

use App\Models\Trademark;
use App\Models\TrademarkComment;
use App\Models\TrademarkCountry;
use App\Models\TrademarkCountryOrder;
use App\Models\OrderTranslation;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Auth;
use DB;
use mysql_xdevapi\Exception;
use Illuminate\Support\Facades\Crypt;
/**
 * Class ProfileController
 * @package App\Http\Controllers
 * @author Andrew Nady <andro.nady2015@gmail.com>
 */
class ProfileController extends Controller
{
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
    public function index()
    {
        $trademarks = Trademark::where('user_id', Auth::id())->paginate(10);
        return view('client.profile.trademarks', compact('trademarks'));
    }

    /**
     * show all orders related to selected trademark from profile page
     *
     * @param $trademarkId
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function trademarks($trademarkId)
    {
        try {
			$trademarkId = Crypt::decryptString($trademarkId);
            $trademarkDetail = Trademark::where('id', $trademarkId)->with('trademark_country')->with('trademark_response_doc')->firstOrFail();
            $country = TrademarkCountry::select('id')->where('trademark_id', $trademarkId)->get();
            $orderDetail = TrademarkCountryOrder::whereIn('trademark_country_id', $country)->with('order')->with('trademark_country')->with('trademark_response')->get();
            $comments = TrademarkComment::where('trademark_id',$trademarkId)->with('user')->get();
			
			//return $orderDetail;
            return view('client.profile.orders', ['orderDetail' => $orderDetail, 'trademarkDetail' => $trademarkDetail,'comments'=>$comments]);
        } catch (\Exception $e) {
            return view('client.errors.copyof404');
        }
    }

    /**
     * show order details
     *
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function details($id)
    {
        try {
			$id = Crypt::decryptString($id);
            $orders = TrademarkCountryOrder::where('id', $id)->with('order')->with('trademark_country')->with('trademark_response')->firstOrFail();
			$subserviceIsExist = TrademarkCountryOrder::where('trademark_country_id', $orders->trademark_country_id)->with('order')->get();
			$isExistpublication = 'No';
			$isExistFinalRegistration = 'No';
			foreach ($subserviceIsExist as $subservice) {
				if($subservice->order->service_package->service_id == 7)
				$isExistpublication = 'Yes';
				
				if($subservice->order->service_package->service_id == 8)
				$isExistFinalRegistration = 'Yes';
			}

			$transdoc = OrderTranslation::where('order_id',$orders->order_id)->with('translation_document')->get();
			//return $transdoc;
            return view('client.orderDetails.details', compact('orders','transdoc', 'isExistpublication' , 'isExistFinalRegistration'));
        } catch (\Exception $e) {
            return view('client.errors.copyof404');
        }
    }

    /**
     * search on trademarks
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function trademarkSearch(Request $request)
    {
        $searchFrom = $request->searchFrom;
        $searchTo = $request->searchTo;
        $orders = Trademark::where('user_id', Auth::id())->whereBetween(DB::raw('DATE(created_at)'), [$searchFrom, $searchTo])->get();
        return view('client.profile.trademarkSearchResult', compact('orders', 'searchFrom', 'searchTo'));
    }
}
