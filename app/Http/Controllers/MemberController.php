<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Mail;
use DB;
use URL;

use App\Models\User;
use App\Models\Trademark;
use App\Models\TrademarkCountry;
use App\Models\TrademarkCountryOrder;
use App\Models\Order;
use App\Models\TrademarkResponse;
use App\Models\TrademarkComment;
use App\Models\TrademarkRegistration;
use App\Models\TrademarkAssignment;
use App\Models\TrademarkNameChange;
use App\Models\TrademarkAddressChange;
use App\Models\TrademarkCountryOrderDate;
use App\Models\ServiceDate;
use App\Models\TrademarkFilling;
use App\Models\TranslationDocument;
use App\Models\OrderTranslation;
use App\Models\TrademarkResponseDocument;

class MemberController extends Controller
{

	public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('member');
    }

	/*	public function display_profile (){
		return view('member.dashboard');
	}*/


		public function trademark_display (Request $request){
		$end_date = '';
		$start_date = '';

		if(isset($request->start_date) && isset($request->end_date)){
		    $end_date = $request->end_date;
			$start_date = $request->start_date;
			$tmarks = $tmarks = Trademark::with('user')->whereBetween(DB::raw('DATE(created_at)'), [$request->start_date, $request->end_date])->get();
		    return view('member.trademarks',compact('tmarks','end_date','start_date'));
		}else{

		$tmarks = Trademark::with('user')->orderBy('id', 'desc')->get();
		return view('member.trademarks',compact('tmarks','end_date','start_date'));
	    }
	}

	public function display_all_orders (Request $request){

		$end_date = '';
		$start_date = '';

		if(isset($request->start_date) && isset($request->end_date)){
		    $end_date = $request->end_date;
			$start_date = $request->start_date;
			$allorders = TrademarkCountryOrder::with('order')->whereHas('order', function ($query) {
        $query->where('isPayed',1);})->with('trademark_country')->with('trademark_response')->where('country_order_status','!=',2)->whereBetween(DB::raw('DATE(created_at)'), [$request->start_date, $request->end_date])->get();
		    return view('member.orderscms',compact('allorders','end_date','start_date'));
		}else{
		//$allorders = TrademarkCountryOrder::with('order')->with('trademark_country')->where('country_order_status','!=',2)->orderBy('id', 'desc')->get();

		$allorders = TrademarkCountryOrder::with('order')->whereHas('order', function ($query) {
        $query->where('isPayed',1);})->with('trademark_country')->with('trademark_response')->where('country_order_status','!=',2)->orderBy('id', 'desc')->get();

		//return $allorders;
		return view('member.orderscms',compact('allorders','end_date','start_date'));
        }
	}

	public function display_unpaid_orders (Request $request){

		$end_date = '';
		$start_date = '';

		if(isset($request->start_date) && isset($request->end_date)){
		    $end_date = $request->end_date;
			$start_date = $request->start_date;
			$allorders = TrademarkCountryOrder::with('order')->whereHas('order', function ($query) {
        $query->where('isPayed',0);})->with('trademark_country')->with('trademark_response')->where('country_order_status','!=',2)->whereBetween(DB::raw('DATE(created_at)'), [$request->start_date, $request->end_date])->get();
		    return view('member.unpaidorderscms',compact('allorders','end_date','start_date'));
		}else{
		//$allorders = TrademarkCountryOrder::with('order')->with('trademark_country')->where('country_order_status','!=',2)->orderBy('id', 'desc')->get();

		$allorders = TrademarkCountryOrder::with('order')->whereHas('order', function ($query) {
        $query->where('isPayed',0);})->with('trademark_country')->with('trademark_response')->where('country_order_status','!=',2)->orderBy('id', 'desc')->get();

		//return $allorders;
		return view('member.unpaidorderscms',compact('allorders','end_date','start_date'));
        }
	}

     public function display_completed_orders(Request $request){

		$allorders = TrademarkCountryOrder::with('order')->with('trademark_country')->where('country_order_status','=',2)->orderBy('id', 'desc')->get();
		return view('member.completedorderscms',compact('allorders'));
	}



	public function trademark_history_display ($tm_id){
		    try {
                $tmark_detail = Trademark::where('id',$tm_id)->with('user')->with('representative')->with('trademark_country')->with('trademark_response_doc')->firstOrFail();
            } catch (ModelNotFoundException $e) {
                return view('client.errors.copyof404');
            }

		//return $tmark_detail;
		$country = TrademarkCountry::select('id')->where('trademark_id', $tm_id)->get();
		$order_detail = TrademarkCountryOrder::whereIn('trademark_country_id', $country)->with('order')->whereHas('order', function ($query) {
        $query->where('isPayed',1);})->with('trademark_country')->with('trademark_ctry_order_date')->get();

		$tm_representative = User::where('user_type_id', 3)->get();
		$tm_comments = TrademarkComment::withTrashed()->where('trademark_id', $tm_id)->with('user')->get();
		$orderslistid = TrademarkCountryOrder::select('order_id')->whereIn('trademark_country_id', $country)->get();
		$translationdocs = OrderTranslation::whereIn('order_id', $orderslistid)->with('order')->with('translation_document')->get();
		//return $translationdocs;
		//return $order_detail;
		//dd($order_detail);
		return view('member.trademarkhistory',compact('tmark_detail', 'order_detail', 'tm_comments', 'tm_representative','translationdocs'));
	}


	public function update_tm_representative(Request $request){
		Trademark::find($request->tm_id)->update(['member_representative_id'=>$request->tm_member_rep]);
        $tmrep = Trademark::find($request->tm_id);
		$user = User::find($request->tm_member_rep);
		$email = $user->email;
		Mail::send('member/assigntrademarkemail',
		array(
           'trademark_reference' => $tmrep->trademark_reference,
		   'trademark_label' => $tmrep->trademark_label,
		), function($message) use ($email)
		{
		   $message->from('info@easy-trademarks.com');
		   $message->to($email, 'Easytrademark Memeber')->subject('Trademark assigned to your responsibilities');
		});
		
        return redirect()->back();
    }


	public function single_order_detail ($c_o_id){
		$orders_id = null;
		$tmresponse_publish = null;
		$tmresponse_fregister = null;
		$acceptance_date_val = '';
		//$tmark_detail = Trademark::where('id',$tm_id)->with('user')->with('trademark_country')->first();
		//$country = TrademarkCountry::select('id')->where('trademark_id', $tm_id)->get();
		try {
            $order = TrademarkCountryOrder::where('id', $c_o_id)->with('order')->with('trademark_country')->with('trademark_response')->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return view('client.errors.copyof404');
        }

		//return($order);
		$order_detail = Order::Where('id', $order->order->id)->with('trademark_registration')->with('trademark_assignment')->with('trademark_color')->with('tm_name_change')->with('tm_address_change')->first();
		//return $order_detail;
		$service_id = $order->order->service_package->service_id;
		$tmresponse = TrademarkResponse::where('service_id', $service_id)->get();

		$date_list = TrademarkCountryOrderDate::where('trademark_country_order_id', $c_o_id)->with('service_date')->get();
		//return $date_list;
		$date_list_id = TrademarkCountryOrderDate::select('date_sevice_id')->where('trademark_country_order_id', $c_o_id)->get();
		$service_date = ServiceDate::where('service_id', $service_id)->where(function ($query) use ($date_list_id) {
																	$query->whereNotIn('id' ,$date_list_id )->orWhere('isEditable', '=', 1);
																	})->get();
		if($service_id == 2){
			//$tm_country_id = $order->trademark_country->id;
			$orders_id = TrademarkCountryOrder::with('order')->with('trademark_response')->where('trademark_country_id',$order->trademark_country->id)->get();
			$tmresponse_publish = TrademarkResponse::where('service_id', 7)->get();
			$tmresponse_fregister = TrademarkResponse::where('service_id', 8)->get();
			$acceptance_date_val = TrademarkCountryOrderDate::where('date_sevice_id', 1)->where('trademark_country_order_id',$orders_id[0]->id)->first();
			//return $acceptance_date_val;
		}
		//return $service_date;
		//dd($order_detail);
		return view('member.odetail_search',compact('order', 'tmresponse', 'order_detail', 'service_date', 'date_list', 'orders_id', 'tmresponse_publish', 'tmresponse_fregister', 'acceptance_date_val'));
	}


	public function set_country_order_dates(Request $request){

		$updatedate = TrademarkCountryOrderDate::where('date_sevice_id', $request->service_date_id)->where('trademark_country_order_id', $request->tm_ctry_order_id)->first();
		if($updatedate == ''){
		$orderdates = new TrademarkCountryOrderDate();
        $orderdates->trademark_country_order_id = $request->tm_ctry_order_id;
        $orderdates->date_sevice_id  = $request->service_date_id;
        $orderdates->date = $request->date_val;
        $orderdates->save();
		}else{
		$updatedatevalue = TrademarkCountryOrderDate::find($updatedate->id)->update(['date' => $request->date_val]);
		}
        return redirect()->back();
    }

	/*public function edit_date_of_action(Request $request){
        $updatedate = TrademarkCountryOrderDate::find($request->date_id)->update(['date' => $request->date_val]);
		return redirect()->back();
    }*/


	public function set_filling_data(Request $request){

		$fillingdata = new TrademarkFilling();
        $fillingdata->trademark_country_id = $request->tm_ctry_id;
        $fillingdata->filling_number  = $request->fill_no;
        $fillingdata->filling_date = $request->fill_date;
        $fillingdata->save();
        return redirect()->back();
    }

	/*public function update_expiration_date(Request $request){
        $tmdate = TrademarkCountryOrder::find($request->c_o_id)->update(['date_expiration'=>$request->expire_date]);
        return redirect()->back();
    }

	public function update_action_date(Request $request){
        $tmdate = TrademarkCountryOrder::find($request->c_o_id)->update(['date_action'=>$request->action_date]);
        return redirect()->back();
    }


	public function update_acceptance_date(Request $request){
        $tmdate = TrademarkRegistration::find($request->tm_reg_id)->update(['acceptance_date'=>$request->accept_date]);
        return redirect()->back();
    }

		public function update_publication_date(Request $request){
        $tmdate = TrademarkRegistration::find($request->tm_reg_id)->update(['publication_date'=>$request->publish_date]);
        return redirect()->back();
    }

		public function update_registration_date(Request $request){
        $tmdate = TrademarkRegistration::find($request->tm_reg_id)->update(['registration_date'=>$request->register_date]);
        return redirect()->back();
    }

	public function update_assignment_date(Request $request){
        $tmdate = TrademarkAssignment::find($request->tm_ass_id)->update(['assign_record_date'=>$request->assign_date]);
        return redirect()->back();
    }

	public function update_namechange_date(Request $request){
        $tmdate = TrademarkNameChange::find($request->tm_nc_id)->update(['change_record_date'=>$request->namechange_date]);
        return redirect()->back();
    }

	public function update_addresschange_date(Request $request){
        $tmdate = TrademarkAddressChange::find($request->tm_ac_id)->update(['change_record_date'=>$request->addresschange_date]);
        return redirect()->back();
    }*/


	public function unpaid_order_display (){
		$end_date = '';
		$start_date = '';
		$orders = Order::where('isPayed',0)->with('service_package_country')->with('trademark')->get();
		return view('member.unpaidorders',compact('orders','end_date','start_date'));
	}

    public function received_order_display(Request $request){
        $end_date = '';
		$start_date = '';
		if(isset($request->start_date) && isset($request->end_date)){
		    $end_date = $request->end_date;
			$start_date = $request->start_date;
			$orders = Order::where('isPayed',1)->where('order_status',0)->with('service_package_country')->with('trademark')->whereBetween('created_at', [$request->start_date, $request->end_date])->get();
		}	else
		$orders = Order::where('isPayed',1)->where('order_status',0)->with('service_package_country')->with('trademark')->get();

        return view('member.receivedorders',compact('orders','end_date','start_date'));
    }

	public function received_order_detail_display($id){
		//$id = 2;
		$order = Order::where('id',$id)->with('trademark')->with('service_package_country')->first();
		$service_id = $order->service_package_country->service_package->service->id;
		$order_details = '';
		//dd($service_id);
		switch($service_id){
			case 1:
				$order_details = order::find($id)->trademark_country_classes;
				//dd($order_details);
				return view('member.orderdetail_search',compact('order','order_details'));
				break;
			case 2:
				$order_details = Order::where('id',$id)->with('trademark_registration')
				->with('trademark_country_classes')->with('trademark_document')->first();
				//dd($order_details);
				return view('member.orderdetail_registration',compact('order','order_details'));
				break;
			case 3:
				$order_details = Order::where('id',$id)->with('trademark_document')->with('trademark_filling')->first();
				return view('member.orderdetail_renewal',compact('order','order_details'));
				break;
			case 4:
				$order_details = Order::where('id',$id)->with('trademark_assignment')->
				with('trademark_document')->with('trademark_filling')->first();
				return view('member.orderdetail_assignment',compact('order','order_details'));
				break;
			case 5:
				$order_details = Order::where('id',$id)->with('tm_name_change')->
				with('trademark_document')->with('trademark_filling')->first();
				return view('member.orderdetail_changename',compact('order','order_details'));
				break;
			case 6:
				$order_details = Order::where('id',$id)->with('tm_address_change')->
				with('trademark_document')->with('trademark_filling')->first();
				return view('member.orderdetail_changeaddress',compact('order','order_details'));
				break;

		}
        //return view('member.receivedorderdetail',compact('order','order_details'));
    }

	public function inprogress_order_display(Request $request){
	         $end_date = '';
		$start_date = '';
		if(isset($request->start_date) && isset($request->end_date)){
		      $end_date = $request->end_date;
			$start_date = $request->start_date;

			$orders = Order::where('order_status',1)->with('service_package_country')->with('trademark')->whereBetween('created_at', [$request->start_date, $request->end_date])->get();
			}else
		$orders = Order::where('order_status',1)->with('trademark')->get();
        return view('member.inprogressorders',compact('orders','end_date','start_date'));
    }

	public function completed_order_display(Request $request){
	     $end_date = '';
		$start_date = '';
		if(isset($request->start_date) && isset($request->end_date)){
		    $end_date = $request->end_date;
			$start_date = $request->start_date;
			$orders = Order::where('order_status',2)->with('service_package_country')->with('trademark')->whereBetween('created_at', [$request->start_date, $request->end_date])->get();
		}	else
		$orders = Order::where('order_status',2)->with('trademark')->get();
        return view('member.completedorders',compact('orders','end_date','start_date'));
    }

	public function update_order_status(Request $request){
		//dd($request->order_id);

		$Order_Status = TrademarkCountryOrder::find($request->order_id)->update(['country_order_status' => $request->order_status]);
		return redirect()->back();
		/*$order = Order::where('id',$request->order_id)->with('trademark')->first();
		$message['order_number'] = $order->order_number;
		$message['response'] = $order->response;

		if($request->order_status == 1){
			$order->update(['order_status' => $request->order_status]);
			$message['order_status'] = 'In Process';
			$this->send_email($order->trademark->user->email,$message);
			return redirect()->route('recievedorder');
		}else {
			$order->update(['order_status' => $request->order_status , 'response' => $request->tm_response ]);
			$message['order_status'] = 'Completed';
			$message['response'] = $order->response;
			$this->send_email($order->trademark->user->email,$message);
			return redirect()->route('progressorder');
		}*/



	}


		public function update_tm_response(Request $request){
		//dd($request->order_id);
       $message['publication'] = '';
		$message['finalregistration'] = '';

		TrademarkCountryOrder::find($request->order_id)->update(['response_id' => $request->tm_response_val]);

		$tm_response = TrademarkCountryOrder::where('id', $request->order_id)->with('order')->with('trademark_response')->with('trademark_country')->first();

		//return $tm_response;
		
		$representative = $tm_response->trademark_country->trademark->representative;
		$tm_ref = $tm_response->trademark_country->trademark->trademark_reference;
		$tm_label = $tm_response->trademark_country->trademark->trademark_label;
		
		$message['tm_ref'] = $tm_ref;
		$message['tm_label'] = $tm_label;


		if($representative != null){
		$message['rep_username'] = $tm_response->trademark_country->trademark->representative->user_name;
		$message['rep_email'] = $tm_response->trademark_country->trademark->representative->email;
		}else{
			$message['rep_username'] = null;
			$message['rep_email'] = null;
		}

		$message['order_number'] = $tm_response->order->order_number;
		$message['order_country'] = $tm_response->trademark_country->country->country_name;

		if($tm_response->country_order_status == 0)
		$message['order_status'] = 'Recieved';
	    elseif($tm_response->country_order_status == 1)
		$message['order_status'] = 'In process';
		else
		$message['order_status'] = 'Completed';

		$message['response'] = $tm_response->trademark_response->response_msg;
		$message['user_name'] = $tm_response->trademark_country->trademark->user->user_name;

		if($request->tm_response_val == 12 && $tm_response->country_order_status == 2){
			$message['publication'] = URL::to('/publication').'/'.$tm_response->trademark_country_id.'/'.$tm_response->trademark_country->country_id.'/'.$tm_response->trademark_country->trademark_id;

		$this->send_email(auth()->user()->email,$message);
		}


		if($request->tm_response_val == 17){
			$message['finalregistration'] = URL::to('/finalRegistration').'/'.$tm_response->trademark_country_id.'/'.$tm_response->trademark_country->country_id.'/'.$tm_response->trademark_country->trademark_id;

		$this->send_email(auth()->user()->email,$message);
		}

		$this->send_email($tm_response->trademark_country->trademark->user->email,$message);
		return redirect()->back();

	}

        public function add_tm_comment(Request $request){
        $tmcomment = new TrademarkComment();
        $tmcomment->trademark_id = $request->tm_id;
        $tmcomment->user_id = $request->user_id;
        $tmcomment->comment_detail = $request->tm_comment;
        $tmcomment->save();
		
		
		$tmark_detail = Trademark::where('id',$request->tm_id)->with('user')->with('representative')->with('trademark_country')->with('trademark_response_doc')->firstOrFail();
		
		//return $tmark_detail;

		//$orderCountry = $tmark_detail->trademark_country->country->country_name_en;
		
		$email = $request->customer_email;
		
		$representative = $tmark_detail->representative;
		if($representative != null){
		   $rep_username = $tmark_detail->representative->user_name;
		   $rep_email = $tmark_detail->representative->email;
			}else{
				$rep_username = null;
			 	$rep_email = null;
			}

			$SUBJECT = 'New comment - '.$tmark_detail->trademark_reference.' - '.$tmark_detail->trademark_label;

		//return $email;
		Mail::send('member/trademarkcommentemail',
		array(
		   'user_name' => $tmark_detail->user->user_name,
		   'trademark_id' => $tmark_detail->id,
		   'trademark_label' => $tmark_detail->trademark_label,
           'trademark_ref' => $tmark_detail->trademark_reference,
           'rep_username' => $rep_username,
		   'rep_email' => $rep_email,
		), function($message) use ($email, $rep_email, $SUBJECT)
		{
		   $message->from('info@easy-trademarks.com');
		   $message->to($email, 'Easytrademark Customer')->subject($SUBJECT);
		   $message->Bcc('help@easy-trademarks.com');
		   //$message->cc(['saadnafie@gmail.com','help@easy-trademarks.com']);
		   if($rep_email != null)
		   $message->Bcc($rep_email);
		});
		
		
        return redirect()->back();
    }


   public function add_tm_response_doc(Request $request){

		$file = $request->file('doc_file');

		$responsedoc = new TrademarkResponseDocument();
        $responsedoc->trademark_id = $request->tm_id;
		$responsedoc->document_title = $request->doc_title;
		$responsedoc->document_file = "1.pdf";
		$responsedoc->save();
		$ext= $file->getClientOriginalExtension();
		$file_path = "resdoc_".$responsedoc->id."_".date("Ymdhis").".".$ext;
		$responsedoc->document_file = $file_path;
		$responsedoc->save();

		$file->move(public_path("response_documents/"), $file_path);
		
		$tmark_detail = Trademark::where('id',$request->tm_id)->with('user')->with('representative')->with('trademark_country')->with('trademark_response_doc')->firstOrFail();
		
		//return $tmark_detail;
		
		$email = $request->customer_email;
		
		$representative = $tmark_detail->representative;
		

		if($representative != null){
		   $rep_username = $tmark_detail->representative->user_name;
		   $rep_email = $tmark_detail->representative->email;
			}else{
				$rep_username = null;
			 	$rep_email = null;
			}
		//return $email;
			$SUBJECT = 'New uploaded document - '.$tmark_detail->trademark_reference.' - '.$tmark_detail->trademark_label;
		Mail::send('member/trademarkdocumentemail',
		array(
		   'user_name' => $tmark_detail->user->user_name,
		   'trademark_id' => $tmark_detail->id,
		   'trademark_label' => $tmark_detail->trademark_label,
           'trademark_ref' => $tmark_detail->trademark_reference,
		   'rep_username' => $rep_username,
		   'rep_email' => $rep_email,
		), function($message) use ($email, $rep_email, $SUBJECT)
		{
		   $message->from('info@easy-trademarks.com');
		   $message->to($email, 'Easytrademark Customer')->subject($SUBJECT);
		   $message->Bcc('help@easy-trademarks.com');
		   //$message->cc(['saadnafie@gmail.com','help@easy-trademarks.com']);
		   if($rep_email != null)
		   $message->Bcc($rep_email);
		});
		

		return redirect()->back();
	}

    public function delete_tm_response_doc($id){
        $resdoc = TrademarkResponseDocument::find($id);
        File::delete(public_path("response_documents/").$resdoc->document_file);
       $resdoc = TrademarkResponseDocument::find($id)->delete();
       return redirect()->back();
    }
    
	function send_email($email,$data){
		
		//dd($email);
        $SUBJECT = 'ACTION REQURED - '.$data['order_number'].' - '.$data['tm_ref'].' - '.$data['tm_label'].' - '.$data['order_country'];

		Mail::send('member/to_progress_email',

		array(
		   'user_name' => $data['user_name'],
           'order_number' => $data['order_number'],
           'tm_ref' =>$data['tm_ref'],
           'tm_label' =>$data['tm_label'],
		   'order_country' => $data['order_country'],
           'order_status' => $data['order_status'],
           'response' => $data['response'],
		   'publication' => $data['publication'],
		   'finalregistration' => $data['finalregistration'],
		   'rep_username' => $data['rep_username'],
		   'rep_email' => $data['rep_email'],
		), function($message) use ($email, $SUBJECT, $data)
		{
		   $message->from('info@easy-trademarks.com');
		   $message->to($email, 'Easytrademark Customer')->subject($SUBJECT);
		   $message->Bcc('help@easy-trademarks.com');
		   //$message->cc(['saadnafie@gmail.com','help@easy-trademarks.com']);
		   if($data['rep_email'] != null)
		   $message->Bcc($data['rep_email']);
		});
	}



	/////////////////////////// Customer list /////////////////////////////////
	public function display_all_clients(){
        $customers = User::where('user_type_id',4)->get();
        return view('member/clientreminder',compact('customers'));
    }
}
