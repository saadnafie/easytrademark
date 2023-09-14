<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Models\Discount;
use App\Question;
use App\Survey;
use App\Utility\SurveyResultMessages;
use App\Utility\SurveyTypesAliases;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

/**
 * Class DiscountController
 * @package App\Http\Controllers
 * @author Hesham Mohamed <hesham.mohamed19930@gmail.com>
 */
class DiscountController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    /**
     * Display a listing of the resource.
     *
     *
     */
    public function index()
    {
        $discounts = Discount::all();
        return view('admin.discounts',compact('discounts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create(Request $request)
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'discount_code' => 'required|string',
            'discount_amount' => 'required|integer|gt:0',
            'allowed_num_of_use' => 'integer|gt:0',
            'is_percentage' => 'boolean',
            'is_date_range' => 'boolean',
            'start_from' => 'nullable|date|after_or_equal:today',
            'end_at' => 'nullable|date|after_or_equal:start_from'
        ]);

        $discount = new Discount();
        $discount->discount_code = $request->discount_code;
        $discount->alias = str_replace(' ', '-', strtolower($request->discount_code));
        $discount->discount_amount = $request->discount_amount;
        $discount->allowed_num_of_use = $request->allowed_num_of_use;
        $discount->is_percentage = (isset($request->is_percentage)) ? $request->is_percentage : 0;
        $discount->is_date_range = (isset($request->is_date_range)) ? $request->is_date_range : 0;
        $discount->start_from = $request->start_from;
        $discount->end_at = $request->end_at;
        $discount->save();
        session()->flash('success','Data saved successfully');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $discount = Discount::findOrFail($id);

        $this->validate($request, [
            'discount_code' => 'required|string',
            'discount_amount' => 'required|integer|gt:0',
            'allowed_num_of_use' => 'integer|gt:0',
            'is_percentage' => 'boolean',
            'is_date_range' => 'boolean',
            'start_from' => 'nullable|date|after_or_equal:today',
            'end_at' => 'nullable|date|after_or_equal:start_from'
        ]);

        $discount->discount_code = $request->discount_code;
        $discount->alias = str_replace(' ', '-', strtolower($request->discount_code));
        $discount->discount_amount = $request->discount_amount;
        $discount->allowed_num_of_use = $request->allowed_num_of_use;
        $discount->is_percentage = (isset($request->is_percentage)) ? $request->is_percentage : 0;
        $discount->is_date_range = (isset($request->is_date_range)) ? $request->is_date_range : 0;
        $discount->start_from = $request->start_from;
        $discount->end_at = $request->end_at;
        $discount->save();
        session()->flash('success','Data saved successfully');
        return redirect()->back();
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Discount::destroy($id);
        return redirect()->back();
    }
}
