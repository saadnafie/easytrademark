<?php

namespace App\Http\Controllers;

use Session;
use Illuminate\Support\Facades\App;
use Mail;
use Illuminate\Http\Request;

/**
 * Class ContactUsController
 * @package App\Http\Controllers
 * @author Andrew Nady <andro.nady2015@gmail.com>
 */
class ContactUsController extends Controller
{
    /**
     * show contact us form
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function contactUs()
    {
        return view('client.contactUs');
    }

    /**
     * store data from contact form in DB
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        if (App::environment('production')) {
            // Send email to client after ordering this service
            $email = new \stdClass();
            $email->name =  $request->get('name');
            $email->email =  $request->get('email');
            $email->subject =  $request->get('subject');
            $email->phone =  $request->get('phone');
            $email->message =  $request->get('message');

            \Illuminate\Support\Facades\Mail::send('client.emails.email', ['email' => $email], function ($message) {
                $message->from('info@easy-trademarks.com','Easytrademark');
                $message->to('help@easy-trademarks.com')->subject('contact us form - clients inquiries ! ');
            });
        }
        Session::flash('success', 'we received your message ... Thank You ');
        return redirect()->back();
    }
}
