<?php

namespace App\Http\Controllers;

use App\Models\OrderTranslation;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;
use Session;
use Stripe;
use App\Models\OrderPayment;
use App\Models\Order;

/**
 * Class StripePaymentController
 * @package App\Http\Controllers
 * @author Andrew Nady <andro.nady2015@gmail.com>
 */
class StripePaymentController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('customer');
    }

    /**
     * show stripe form
     *
     * @param $id
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function stripe($id, Request $request)
    {
        // if we are in translation service check the flag and get by ID if fails return 404
        if ($request->has('isTranslationService') && $request->get('isTranslationService') == true) {
            try {
                $orderTranslation = OrderTranslation::findOrFail($id);
                return view('client.payment.stripe', compact('orderTranslation'))->with('isTranslationService', true);
            } catch (ModelNotFoundException $e) {
                return view('client.errors.copyof404');
            }
        }

        // if normal order for trademark needs to be paid
        try {
            $order = Order::findOrFail($id);
            if ($order->isPayed == 0) {
                if ($request->has('isDocument') && $request->get('isDocument') == true) {
                    return view('client.payment.stripe', compact('order'))->with('isDocument', true);
                } else {
                    return view('client.payment.stripe', compact('order'))->with('isDocument', false);
                }
            } else {
                return redirect('home');
            }
        } catch (ModelNotFoundException $e) {
            return view('client.errors.copyof404');
        }
    }


    /**
     * store payment details for authenticated user
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws Stripe\Exception\ApiErrorException
     */
    public function stripePost(Request $request)
    {

        if ($request->has('isTranslationService')) {
            Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
            $order = OrderTranslation::find($request->orderTranslationId);
            $pay = Stripe\Charge::create([
                "amount" => ($order->total_price_currency) * 100,
                "currency" => $order->currency_type,
                "source" => $request->stripeToken,
                "description" => "for trademark registration process",
                "metadata" => array("Order" => $request->order_id, "Customer Name" => auth()->user()->user_name, "email" => auth()->user()->email, "Phone" => auth()->user()->phone)
            ]);
            if ($pay->status == "succeeded") {
                $payment = new OrderPayment();
                $payment->order_id = $request->orderTranslationId;
                $payment->payment_reference_num = $pay->id;
                $payment->payment_date = date('Y-m-d');
                $payment->save();
                $order = OrderTranslation::find($request->orderTranslationId);
                $order->isPayed = 1;
                $order->save();
            }
            Session::flash('success', 'Payment successful!');
            return redirect()->back();
        } else {
            Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
            $order = Order::where('id', $request->order_id)->with('service_package')->first();
            $pay = Stripe\Charge::create([
                "amount" => ($order->total_fees_currency) * 100,
                "currency" => $order->currency_type,
                "source" => $request->stripeToken,
                "description" => "for trademark registration process",
                "metadata" => array("Order" => $request->order_id, "Customer Name" => auth()->user()->user_name, "email" => auth()->user()->email, "Phone" => auth()->user()->phone)
            ]);
            if ($pay->status == "succeeded") {
                $payment = new OrderPayment();
                $payment->order_id = $request->order_id;
                $payment->payment_reference_num = $pay->id;
                $payment->payment_date = date('Y-m-d');
                $payment->save();
                $orderID = $request->order_id;
                $order = Order::find($orderID);
                $order->isPayed = 1;
                $order->save();
                if (App::environment('production')) {
                    // Send email to client after ordering this service
                    $email = new \stdClass();
					$email->user_name = auth()->user()->user_name;
                    $email->order_number = $order->order_number;
                    $email->total_fees_currency = $order->total_fees_currency;
                    $email->userCountryCurrencyCode = $order->currency_type;
                    Mail::send('client.emails.PaymentSuccessfulMail', ['email' => $email], function ($message) {
                        $message->from('info@easy-trademarks.com', 'Easytrademark');
                        $message->to(auth()->user()->email, auth()->user()->user_name)->subject('Successful Payment, Received order ! ');
						$message->Bcc('info@easy-trademarks.com');
                    });
                }
            }
            Session::flash('success', 'Payment successful!');
            $id = $request->order_id;
            if ($request->isDocument == true) {
                if ($order->service_package->service_id == 1) {
                    Session::flash('success', 'Payment successful!');
                    return redirect()->route('home');
                } else {
                    return redirect()->route('document_required', compact('id'));
                }
            } else {
                Session::flash('success', 'Payment successful!');
                return redirect()->back();
            }
        }
    }
}
