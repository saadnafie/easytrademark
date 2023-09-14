<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use Session;
use Stripe;
use App\Models\Order;
use App\Models\OrderPayment;
use App;
use App\Models\OrderTranslation;
use Mail;

class AliWeChatPaymentController extends Controller
{

	public function select_payment($order_id, $isDocument, $isTranslation){
		
		if($isTranslation == 0){
		$order = Order::find($order_id);
		}else{
		$order = OrderTranslation::find($order_id);
		}
        //return $order;
		return view('client.payment.selectpayment',compact('order','order_id', 'isDocument', 'isTranslation'));
	}
	
	public function alipay_paymentintent(Request $request){
		
		if($request->isTranslation == 0)
		$order = Order::find($request->order_id);
		else
		$order = OrderTranslation::findOrFail($request->order_id);
		
       	Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        
		if($request->isTranslation == 0){
			if($order->discount_id == null)
			$amount = $order->total_fees;
			else
			$amount = $order->final_fees_after_discount;
		$pay = \Stripe\PaymentIntent::create([
			'payment_method_types' => ['alipay'],
			'amount' => $amount * 100,
			'metadata' => array("Order number" => $order->order_number, "Customer Name" => auth()->user()->user_name, "email" => auth()->user()->email, "Phone" => auth()->user()->phone),
			'description' => "for trademark registration process",
			'currency' => 'usd',
			//'metadata' => ['integration_check' => 'accept_a_payment'],
	        //'owner' => ['name' => auth()->user()->user_name],
		]);
		}else{
		$pay = \Stripe\PaymentIntent::create([
			'payment_method_types' => ['alipay'],
			'amount' => $order->total_price * 100,
			'metadata' => array("Customer Name" => auth()->user()->user_name, "email" => auth()->user()->email, "Phone" => auth()->user()->phone),
			'description' => "for trademark Translation Services",
			'currency' => 'usd',
		]);
		}
		
		if($request->isTranslation == 0){		
			if($order->discount_id == null)
			$amount = $order->total_fees;
			else
			$amount = $order->final_fees_after_discount;
		}else
			$amount = $order->total_price;
			
		$order_id = $request->order_id;
		$isDocument = $request->isDocument;
		$isTranslation = $request->isTranslation;
						
		return view('client.payment.alipay',compact('pay','amount','order_id','isDocument','isTranslation'));
    }

    public function alipay_redirect($order_id,$isDocument,$isTranslation,Request $request){
    	//return $request;
    	//$redirect_status = 'mm';
    	if($request->redirect_status == 'succeeded'){
	    	$order = Order::where('id',$order_id)->with('service_package')->first();

			$this->payment_success($order_id , $request->payment_intent,$isTranslation);

			Session::flash('success', 'Payment successful!');
	        $id = $request->order_id;
			if($isTranslation == 0){
				if ($isDocument == true) {
					if($order->service_package->service_id == 1){
						Session::flash('success', 'Payment successful!');
						return redirect()->route('home');
					}else{
						return redirect()->route('document_required', compact('id'));
					}
				} else {
					Session::flash('success', 'Payment successful!');
					return redirect()->route('home');
				}
			}else{
				Session::flash('success', 'Payment successful!');
	            return redirect()->route('home');
			}
    	}else{
    		Session::flash('failed', 'Payment failed, check Your wallet and try again!');
    		return redirect()->route('selectpayment',array('order_id'=>$order_id, 'isDocument'=>$isDocument, 'isTranslation'=>$isTranslation) );
    		//return redirect()->back();
    	}
    	//return redirect()->route('home');
    }
	
	public function wechat_paymentsource(Request $request){
		
		if($request->isTranslation == 0)
		$order = Order::find($request->order_id);
		else
		$order = OrderTranslation::findOrFail($request->order_id);
	
       	Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        
		if($request->isTranslation == 0){
			if($order->discount_id == null)
			$amount = $order->total_fees;
			else
			$amount = $order->final_fees_after_discount;
			
		$pay = \Stripe\Source::create([
		  	'type' => 'wechat',
		  	'amount' => $amount * 100,
		  	'currency' => 'usd',
		  	//'description' => "for trademark registration process",
      		'metadata' => array("Order" => $request->order_id,"Order number" => $order->order_number, "Customer Name" => auth()->user()->user_name, "email" => auth()->user()->email, "Phone" => auth()->user()->phone),
			'owner' => ['name' => auth()->user()->user_name],
		]);
		}else{
		$pay = \Stripe\Source::create([
		  	'type' => 'wechat',
		  	'amount' => $order->total_price * 100,
		  	'currency' => 'usd',
      		'metadata' => array("Order Type" => 'Translation Service', "Customer Name" => auth()->user()->user_name, "email" => auth()->user()->email, "Phone" => auth()->user()->phone),
			'owner' => ['name' => auth()->user()->user_name],
		]);
		}
		
		
		if($request->isTranslation == 0){	
			if($order->discount_id == null)
			$amount = $order->total_fees;
			else
			$amount = $order->final_fees_after_discount;
		}else
			$amount = $order->total_price;
			
		$order_id = $request->order_id;
		$isDocument = $request->isDocument;
		$isTranslation = $request->isTranslation;
		
		return view('client.payment.wechat',compact('pay','amount','order_id','isDocument','isTranslation'));
    }
	
	public function chargeWeChat(Request $request){
		\Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

		$source = \Stripe\Source::retrieve(
		  $request->source,
		  []
		);
	
		/*//$x = (array)$source->metadata ;
		$x = array_slice(explode(',', $source->metadata), 0, 3);//explode(',',$source->metadata);
		return $x;
		//return $source->metadata;array("Order Type" => 'Translation Service')*/
		$charge = "";
		if($source->status =='chargeable'){
			
			$charge = \Stripe\Charge::create([
				'amount' => $source->amount,
				'currency' => $source->currency,
				'source' => $request->source,
				//'metadata' => $x,
			]);
			//return $charge;
		}else{
			Session::flash('failed', 'Payment failed, check Your wallet and try again!');
			return redirect()->route('selectpayment',array('order_id'=>$request->order_id, 'isDocument'=>$request->isDocument, 'isTranslation'=>$request->isTranslation) );
		}
		$pay_id = $charge->id;
        

		$this->payment_success($request->order_id , $pay_id, $request->isTranslation);

		Session::flash('success', 'Payment successful!');
        $id = $request->order_id;
        
		if($request->isTranslation == 0){
			if ($request->isDocument == true) {
				$order = Order::where('id',$request->order_id)->with('service_package')->first();
				if($order->service_package->service_id == 1){
					Session::flash('success', 'Payment successful!');
					return redirect()->route('home');
				}else{
					return redirect()->route('document_required', compact('id'));
				}
			} else {
				Session::flash('success', 'Payment successful!');
				return redirect()->route('home');
			}
		}else {
				Session::flash('success', 'Payment successful!');
				return redirect()->route('home');
			}
		//return redirect()->away($url );
	}

	function payment_success($order_id,$pay_id,$isTranslation){
		$order = '';
		if($isTranslation == 0){
		$payment = new OrderPayment();
        $payment->order_id = $order_id;
        $payment->payment_reference_num = $pay_id;
        $payment->payment_date = date('Y-m-d');
        $payment->save();
        $orderID = $order_id;
        $order = Order::find($order_id);
        $order->isPayed = 1;
        $order->save();
		}else{
			$order = OrderTranslation::findOrFail($order_id);
			$order->isPayed = 1;
			$order->save();
		}
		
        if (App::environment('production')) {
            // Send email to client after ordering this service
            $email = new \stdClass();
            if($isTranslation == 0){
			$email->user_name = auth()->user()->user_name;
			$email->order_number = $order->order_number;
			$email->total_fees_currency = $order->total_fees_currency;
            $email->userCountryCurrencyCode = $order->currency_type;
			}else{
				$email->user_name = auth()->user()->user_name;
				$email->total_fees_currency = $order->total_price;
				$email->userCountryCurrencyCode = $order->currency_type;
			}
            
            Mail::send('client.emails.PaymentSuccessfulMail', ['email' => $email], function ($message) {
                $message->from('info@easy-trademarks.com', 'Easytrademark');
                $message->to(auth()->user()->email, auth()->user()->user_name)->subject('Successful Payment, Received order ! ');
				$message->Bcc('info@easy-trademarks.com');
            });
        }       
	}
}
