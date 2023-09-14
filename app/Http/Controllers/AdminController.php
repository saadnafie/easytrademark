<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;


use App\Models\Service;
use App\Models\ServiceHowDetail;
use App\Models\User;
use App\Models\Country;
use App\Models\Package;
use App\Models\ServicePackageFee;
use App\Models\Classes;
use App\Models\ServicePackageCountryFee;
use App\Models\CompanyType;
use App\Models\ApplicantType;
use App\Models\ApplicantOccupation;
use App\Models\Community;
use App\Models\Faq;
use App\Models\News;
use App\Models\NewsImage;
use App\Models\DocumentTemplate;
use App\Models\ServiceCountryDocument;
use App\Models\TrademarkServiceCountryDocument;
use App\Models\RequiredDocument;
use App\Models\TrademarkResponse;
use App\Models\PaymentCurrency;
use App\Models\RssFeed;
use App\Models\UserGuide;
use App\Models\UserGuideImage;


class AdminController extends Controller
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

	/////////////////////////// Customer list /////////////////////////////////
	public function show_all_customers(){
        $customers = User::where('user_type_id',4)->get();
        return view('admin.clients',compact('customers'));
    }

    /////////////////////////// Alyafy member /////////////////////////////////

    public function show_all_members(){
        $members = User::where('user_type_id',3)->get();
        return view('admin.members',compact('members'));
    }

    public function add_member_form(){

       return view('admin.addMember');
    }

    public function add_new_member(Request $request){

        $this->validate($request, [
        'member_code' => 'unique:users,user_code',
        'member_email' => 'unique:users,email',
        ],[

		    'member_code.unique' =>'code already exist',
		    'member_email.unique' =>'email already exist',
        ]);

        $user = new User();
        $user->user_code = $request->member_code;
        $user->user_name = $request->member_name;
        $user->email = $request->member_email;
        $user->phone = $request->member_phone;
        $user->user_type_id = 3;
        $user->password = Hash::make($request->member_code);
        $user->save();
        session()->flash('success','Data saved successfully');
        return redirect()->route('members');
    }

    public function update_member(Request $request){

		$emailexist = User::where('email', $request->member_email)->where('id','!=', $request->member_id)->get();

		if( count($emailexist)> 0 ){

        $this->validate($request, [
            'member_email' => 'unique:users,email',
        ],[
		    'member_email.unique' =>'email already exist',
        ]);

		}

        $user = User::find($request->member_id);
        $user->user_name = $request->member_name;
        $user->email = $request->member_email;
        $user->phone = $request->member_phone;
        $user->save();
        session()->flash('success','Data saved successfully');
        return redirect()->back();
    }


    /////////////////////////// Service /////////////////////////////////

    public function add_service_form(){

       return view('admin.addService');
    }

    public function add_new_service(Request $request){
       $service = new Service();
	   $service->service_name_en = $request->service_type;
	   $service->service_name_ar = $request->service_type_ar;
	   $service->service_name_zh = $request->service_type_zh;
	   $service->service_name_tr = $request->service_type_tr;
       $service->service_description_en = $request->service_desc;
	   $service->service_description_ar = $request->service_desc_ar;
	   $service->service_description_zh = $request->service_desc_zh;
	   $service->service_description_tr = $request->service_desc_tr;
       $service->service_icon = $request->icon_code;
       $service->service_what_en = $request->what_desc;
	   $service->service_what_ar = $request->what_desc_ar;
	   $service->service_what_zh = $request->what_desc_zh;
	   $service->service_what_tr = $request->what_desc_tr;
       $service->service_why_en = $request->why_desc;
	   $service->service_why_ar = $request->why_desc_ar;
	   $service->service_why_zh = $request->why_desc_zh;
	   $service->service_why_tr = $request->why_desc_tr;
       $service->service_when_en = $request->when_desc;
	   $service->service_when_ar = $request->when_desc_ar;
	   $service->service_when_zh = $request->when_desc_zh;
	   $service->service_when_tr = $request->when_desc_tr;
       $service->service_how_en = $request->how_desc;
	   $service->service_how_ar = $request->how_desc_ar;
	   $service->service_how_zh = $request->how_desc_zh;
	   $service->service_how_tr = $request->how_desc_tr;
       $service->save();
       session()->flash('success','Data saved successfully');
       return redirect()->route('services');
    }

    public function show_all_services(){
       $services = Service::all();
       return view('admin.services',compact('services'));
    }

    public function service_activation($id , $status){
        $service = Service::find($id)->update(['isActive' => $status]);
        session()->flash('success','Updating data successfully');
        return redirect()->back();
    }

     public function service_details($id){
         try {
             $service = Service::where('id',$id)->with('how_details')->firstOrFail();
         } catch (ModelNotFoundException $e) {
             return view('client.errors.copyof404');
         }

       return view('admin.serviceDetail',compact('service'));
    }

    public function update_service(Request $request){
       $service = Service::find($request->service_id);
       $service->service_name_en = $request->service_type;
	   $service->service_name_ar = $request->service_type_ar;
	   $service->service_name_zh = $request->service_type_zh;
	   $service->service_name_tr = $request->service_type_tr;
       $service->service_description_en = $request->service_desc;
	   $service->service_description_ar = $request->service_desc_ar;
	   $service->service_description_zh = $request->service_desc_zh;
	   $service->service_description_tr = $request->service_desc_tr;
       $service->service_icon = $request->icon_code;
       $service->service_what_en = $request->what_desc;
	   $service->service_what_ar = $request->what_desc_ar;
	   $service->service_what_zh = $request->what_desc_zh;
	   $service->service_what_tr = $request->what_desc_tr;
       $service->service_why_en = $request->why_desc;
	   $service->service_why_ar = $request->why_desc_ar;
	   $service->service_why_zh = $request->why_desc_zh;
	   $service->service_why_tr = $request->why_desc_tr;
       $service->service_when_en = $request->when_desc;
	   $service->service_when_ar = $request->when_desc_ar;
	   $service->service_when_zh = $request->when_desc_zh;
	   $service->service_when_tr = $request->when_desc_tr;
       $service->service_how_en = $request->how_desc;
	   $service->service_how_ar = $request->how_desc_ar;
	   $service->service_how_zh = $request->how_desc_zh;
	   $service->service_how_tr = $request->how_desc_tr;
       $service->save();
       session()->flash('success','Data saved successfully');
       return redirect()->back();
    }

    public function add_how_detail(Request $request){
        $how = new ServiceHowDetail();
        $how->service_id = $request->service_id;
        $how->title_en = $request->step_title_en;
		$how->title_ar = $request->step_title_ar;
		$how->title_zh = $request->step_title_zh;
		$how->title_tr = $request->step_title_tr;
        $how->content_en = $request->step_desc_en;
		$how->content_ar = $request->step_desc_ar;
		$how->content_zh = $request->step_desc_zh;
		$how->content_tr = $request->step_desc_tr;
        $how->detail_url = $request->step_url;
        $how->save();
        return redirect()->back();
    }

    public function update_how_detail(Request $request){
        $how = ServiceHowDetail::find($request->step_id);
        $how->title_en = $request->step_title_en;
		$how->title_ar = $request->step_title_ar;
		$how->title_zh = $request->step_title_zh;
		$how->title_tr = $request->step_title_tr;
        $how->content_en = $request->step_desc_en;
		$how->content_ar = $request->step_desc_ar;
		$how->content_zh = $request->step_desc_zh;
		$how->content_tr = $request->step_desc_tr;
        $how->detail_url = $request->step_url;
        $how->save();
        return redirect()->back();
    }

	public function delete_how_detail($id){
        $how = ServiceHowDetail::find($id)->delete();
        return redirect()->back();
    }
    //////////////////////////////// Package ////////////////////////////

	public function show_all_package(){
		$packages = Package::with('service_package')->get();
		$services = Service::all();
		return view('admin.packages',compact('packages','services'));
	}

	public function add_new_package(Request $request){
		$package = new Package();
		$package->package_en = $request->package_title_en;
		$package->package_ar = $request->package_title_ar;
		$package->package_zh = $request->package_title_zh;
		$package->package_tr = $request->package_title_tr;
		$package->package_type_en = $request->package_type_en;
		$package->package_type_ar = $request->package_type_ar;
		$package->package_type_zh = $request->package_type_zh;
		$package->package_type_tr = $request->package_type_tr;
		$package->package_details_en = $request->package_detail_en;
		$package->package_details_ar = $request->package_detail_ar;
		$package->package_details_zh = $request->package_detail_zh;
		$package->package_details_tr = $request->package_detail_tr;
		$package->flag = 1;
		$package->save();


		$pack_serv = new ServicePackageFee();
		$pack_serv->service_id = $request->service_id;
		$pack_serv->package_id = $package->id;
		$pack_serv->fee = $request->package_fees;
		$pack_serv->save();

		return redirect()->back();
	}

	public function update_package(Request $request){
		$package = Package::find($request->package_id);
		$package->package_en = $request->package_title_en;
		$package->package_ar = $request->package_title_ar;
		$package->package_zh = $request->package_title_zh;
		$package->package_tr = $request->package_title_tr;
		$package->package_type_en = $request->package_type_en;
		$package->package_type_ar = $request->package_type_ar;
		$package->package_type_zh = $request->package_type_zh;
		$package->package_type_tr = $request->package_type_tr;
		$package->package_details_en = $request->package_detail_en;
		$package->package_details_ar = $request->package_detail_ar;
		$package->package_details_zh = $request->package_detail_zh;
		$package->package_details_tr = $request->package_detail_tr;
		$package->save();


		$pack_serv = ServicePackageFee::find($request->ser_pack_fee_id);
		$pack_serv->service_id = $request->service_id;
		$pack_serv->fee = $request->package_fees;
		$pack_serv->save();

		return redirect()->back();
	}

	/////////////////////////// Countries /////////////////////////////////

    public function add_country_form(){
       $countries = Country::all();
       return view('admin.countries',compact('countries'));
    }

	public function add_new_country(Request $request){

        $country = new Country();
        $country->country_name_en = $request->country_name;
		$country->country_name_ar = $request->country_name_ar;
		$country->country_name_zh = $request->country_name_zh;
		$country->country_name_tr = $request->country_name_tr;
        $country->save();
        session()->flash('success','Data saved successfully');
        return redirect()->back();
    }

	public function update_country(Request $request){
		$package = Country::find($request->c_id);
		$package->country_name_en = $request->c_name;
		$package->country_name_ar = $request->c_name_ar;
		$package->country_name_zh = $request->c_name_zh;
		$package->country_name_tr = $request->c_name_tr;
		$package->save();
		return redirect()->back();
	}

	public function country_activation($id , $status){
        $service = Country::find($id)->update(['isActive' => $status]);
        session()->flash('success','Updating data successfully');
        return redirect()->back();
    }
/////////////////////////// Classes /////////////////////////////////

	public function show_all_classes(){
		$classes = Classes::all();
		return view('admin.classes',compact('classes'));
	}

	/////////////////////////// Package Country /////////////////////////////////

	public function show_all_country_packages($id){
        try {
            $country = Country::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return view('client.errors.copyof404');
        }

		$packages = Country::find($id)->service_package_country;
		return view('admin.packagesfees',compact('packages','country'));
	}

	public function country_packages_activation($id , $status){
		$service = ServicePackageCountryFee::find($id)->update(['isActive' => $status]);
        session()->flash('success','Updating data successfully');
        return redirect()->back();
    }

	public function update_govfees(Request $request){
        ServicePackageCountryFee::find($request->id)->update(['fees' => $request->govfees]);
        session()->flash('success','Updating data successfully');
        return redirect()->back();
    }


	/////////////////////////// Country Required Documents /////////////////////////////////

	public function show_all_countryreqdocs(){
        $countryreqdocs = TrademarkServiceCountryDocument::with('service')->with('country')->with('document')->get();
		$services = Service::all();
        $countries = Country::all();
        return view('admin.countryreqdocs',compact('countryreqdocs','services','countries'));
    }

	public function add_new_countryreqdocs(Request $request){

		$countryreqdocs = new RequiredDocument();
		$countryreqdocs->document_title = $request->title;
		$countryreqdocs->save();

		foreach($request->services as $value){
			$ctyservdoc = new TrademarkServiceCountryDocument();
			$ctyservdoc->document_id = $countryreqdocs->id;
			$ctyservdoc->service_id = $value;
			$ctyservdoc->country_id = $request->country_id;
			$ctyservdoc->save();
		}

		return redirect()->back();
	}

	public function update_countryreqdocs(Request $request){
		$countryreqdoctitle = RequiredDocument::find($request->doc_id);
		$countryreqdoctitle->document_title = $request->title;
		$countryreqdoctitle->save();

		return redirect()->back();
	}

	/////////////////////////// TrademarkResponse /////////////////////////////////

	public function show_all_trademarkresponse(){
        $tmresponse = TrademarkResponse::all();
        return view('admin.trademarkresponse',compact('tmresponse'));
    }

	public function update_tmresponsemsg(Request $request){
		$tmresponsemsg = TrademarkResponse::find($request->response_id);
		$tmresponsemsg->response_msg = $request->tmresponse;
		$tmresponsemsg->save();

		return redirect()->back();
	}

		/////////////////////////// RSS Feed /////////////////////////////////

	public function show_all_rssfeed(){
        $rssfeeds = RssFeed::all();
        return view('admin.rssfeed',compact('rssfeeds'));
    }

	public function add_new_rssfeed(Request $request){

        $rssfeed = new RssFeed();
        $rssfeed->rss_title = $request->rss_title;
		$rssfeed->rss_link = $request->rss_link;
		$rssfeed->rss_description = $request->rss_detail;
		$rssfeed->rss_date = $request->rss_date;
        $rssfeed->save();
        return redirect()->back();
    }

	public function update_rssfeed(Request $request){
		$rssfeed = RssFeed::find($request->rssfeed_id);
		$rssfeed->rss_title = $request->rss_title;
		$rssfeed->rss_link = $request->rss_link;
		$rssfeed->rss_description = $request->rss_detail;
		//$rssfeed->rss_date = $request->rss_date;
		$rssfeed->save();

		return redirect()->back();
	}

	public function delete_rssfeed($id){
        $rssfeed = RssFeed::find($id)->delete();
        return redirect()->back();
    }

	/////////////////////////// Payment Currency /////////////////////////////////

	public function show_all_paymentcurrency(){
        $paycurrencies = PaymentCurrency::all();
        return view('admin.paymentcurrency',compact('paycurrencies'));
    }

	/////////////////////////// CompanyType /////////////////////////////////
	public function show_all_companiestype(){
        $companytype = CompanyType::all();
        return view('admin.companytype',compact('companytype'));
    }

	/////////////////////////// ApplicantType /////////////////////////////////
	public function show_all_applicanttype(){
        $applicanttype = ApplicantType::all();
        return view('admin.applicanttype',compact('applicanttype'));
    }

	/////////////////////////// ApplicantOccupation/////////////////////////////////
	public function show_all_occupation(){
        $applicantccupation = ApplicantOccupation::all();
        return view('admin.occupation',compact('applicantccupation'));
    }

	/////////////////////////// Resource Center - Community/////////////////////////////////
	public function show_all_communities(){
        $communities = Community::all();
        return view('admin.community',compact('communities'));
    }

	public function add_new_community(Request $request){

		$file = $request->file('logo');

		$community = new Community();
		$community->title_en = $request->title;
		$community->title_ar = $request->title_ar;
		$community->title_zh = $request->title_zh;
		$community->title_tr = $request->title_tr;
		$community->country_en = $request->country;
		$community->country_ar = $request->country_ar;
		$community->country_zh = $request->country_zh;
		$community->country_tr = $request->country_tr;
		$community->description_en = $request->description;
		$community->description_ar = $request->description_ar;
		$community->description_zh = $request->description_zh;
		$community->description_tr = $request->description_tr;
		$community->website_url = $request->website_url;
		$community->logo = $request->country."1.jpg";
		$community->save();
		$file_path = "comm_".$community->id."_".date("Ymdhis").".jpg";
		$community->logo = $file_path;
		$community->save();

		$file->move(public_path("resource_center/community/"), $file_path);

		return redirect()->back();
	}

	public function update_community(Request $request){

		$file = $request->file('logo');

		$community = Community::find($request->id);
		$community->title_en = $request->title;
		$community->title_ar = $request->title_ar;
		$community->title_zh = $request->title_zh;
		$community->title_tr = $request->title_tr;
		$community->country_en = $request->country;
		$community->country_ar = $request->country_ar;
		$community->country_zh = $request->country_zh;
		$community->country_tr = $request->country_tr;
		$community->description_en = $request->description;
		$community->description_ar = $request->description_ar;
		$community->description_zh = $request->description_zh;
		$community->description_tr = $request->description_tr;
		$community->website_url = $request->website_url;
		$community->save();

		if(isset($file))
			$file->move(public_path("resource_center/community/"), $community->logo);

		return redirect()->back();
	}



	/////////////////////////// Resource Center - FAQs/////////////////////////////////
	public function show_all_FAQs(){

        $FAQs = Faq::all();
        return view('admin.FAQs',compact('FAQs'));
    }

	public function add_new_FAQs(Request $request){
		
		$validator = Validator::make($request->all(), [
            'q_slug' => ['required','unique:faqs'],
        ]);
        if ($validator->fails()) {
            Session::flash('error', $validator->messages());
            return Redirect::back()->withErrors($validator)->withInput();
        }

		$FAQs = new Faq();
		$FAQs->question_en = $request->question;
		$FAQs->question_ar = $request->question_ar;
		$FAQs->question_zh = $request->question_zh;
		$FAQs->question_tr = $request->question_tr;
		$FAQs->q_slug = $request->q_slug;
		$FAQs->answer_en = $request->answer;
		$FAQs->answer_ar = $request->answer_ar;
		$FAQs->answer_zh = $request->answer_zh;
		$FAQs->answer_tr = $request->answer_tr;
		$FAQs->save();

		return redirect()->back();
	}

	public function update_FAQs(Request $request){

		$FAQs = Faq::find($request->id);
		$FAQs->question_en = $request->question;
		$FAQs->question_ar = $request->question_ar;
		$FAQs->question_zh = $request->question_zh;
		$FAQs->question_tr = $request->question_tr;
		$FAQs->answer_en = $request->answer;
		$FAQs->answer_ar = $request->answer_ar;
		$FAQs->answer_zh = $request->answer_zh;
		$FAQs->answer_tr = $request->answer_tr;
		$FAQs->save();

		return redirect()->back();
	}

	public function delete_faq($id){

		$faq = Faq::find($id)->delete();
		return redirect()->back();
	}

		/////////////////////////// Resource Center - News/////////////////////////////////
	public function show_all_articles(){
        $news = News::with('images')->get();
        return view('admin.news',compact('news'));
    }

	public function add_new_article(Request $request){
		
		$validator = Validator::make($request->all(), [
            'description_en' => ['required'],
			'description_ar' => ['required'],
			'description_zh' => ['required'],
			'description_tr' => ['required'],
        ]);
        if ($validator->fails()) {
            Session::flash('error', $validator->messages());
            return Redirect::back()->withErrors($validator)->withInput();
        }

		$file = $request->file('logo');

		$news = new News();
		$news->title_en = $request->title_en;
		$news->title_ar = $request->title_ar;
		$news->title_zh = $request->title_zh;
		$news->title_tr = $request->title_tr;
		$news->news_slug = $request->url_slug;
		$news->description_en = $request->description_en;
		$news->description_ar = $request->description_ar;
		$news->description_zh = $request->description_zh;
		$news->description_tr = $request->description_tr;
		$news->save();
		$fileimg = $request->img;
		foreach($fileimg as $index=>$value){
		    $x = $index+1;
		    $file_path = "news".$x."_".$news->id."_".date("Ymdhis").".jpg";
    		$img = new NewsImage();
    		$img->news_id = $news->id;
    		$img->image_path = $file_path;
    		$img->save();

    		$value->move(public_path("resource_center/news/"), $file_path);
		}
		return redirect()->back();
	}

	public function edit_article_cms($id){
		try {
		$newdetail = News::where('id',$id)->firstOrFail();
		} catch (ModelNotFoundException $e) {
            return view('client.errors.copyof404');
        }
		return view('admin.editnews',compact('newdetail'));
	}

	public function delete_article($id){
		$news_images = NewsImage::where('news_id',$id)->get();
		foreach($news_images as $image){
			File::delete(public_path("resource_center/news/").$image->image_path);
			$news_image = NewsImage::find($image->id)->delete();
		}
		$news = News::find($id)->delete();
		
		return redirect()->back();
	}

	public function update_article(Request $request){
		
		$validator = Validator::make($request->all(), [
            'description_en' => ['required'],
			'description_ar' => ['required'],
			'description_zh' => ['required'],
			'description_tr' => ['required'],
        ]);
        if ($validator->fails()) {
            Session::flash('error', $validator->messages());
            return Redirect::back()->withErrors($validator)->withInput();
        }
		
		$news = News::find($request->id);
		$news->title_en = $request->title_en;
		$news->title_ar = $request->title_ar;
		$news->title_zh = $request->title_zh;
		$news->title_tr = $request->title_tr;
		$news->description_en = $request->description_en;
		$news->description_ar = $request->description_ar;
		$news->description_zh = $request->description_zh;
		$news->description_tr = $request->description_tr;
		$news->save();

		return redirect()->back();
	}



/////////////////////////// Resource Center - User Guide/////////////////////////////////
	public function show_all_user_guide(){
        $user_guides = UserGuide::with('images')->get();
        return view('admin.userguide',compact('user_guides'));
    }

	public function add_new_user_guide(Request $request){

		$validator = Validator::make($request->all(), [
            'description_en' => ['required'],
			'description_ar' => ['required'],
			'description_zh' => ['required'],
			'description_tr' => ['required'],
        ]);
        if ($validator->fails()) {
            Session::flash('error', $validator->messages());
            return Redirect::back()->withErrors($validator)->withInput();
        }

		$file = $request->file('logo');

		$user_guide = new UserGuide();
		$user_guide->title_en = $request->title_en;
		$user_guide->title_ar = $request->title_ar;
		$user_guide->title_zh = $request->title_zh;
		$user_guide->title_tr = $request->title_tr;
		$user_guide->guide_slug = $request->url_slug;
		$user_guide->description_en = $request->description_en;
		$user_guide->description_ar = $request->description_ar;
		$user_guide->description_zh = $request->description_zh;
		$user_guide->description_tr = $request->description_tr;
		$user_guide->save();

		$fileimg = $request->img;
		if(isset($fileimg)){
			foreach($fileimg as $index=>$value){
			    $x = $index+1;
			    $file_path = "usr_gid".$x."_".$user_guide->id."_".date("Ymdhis").".jpg";
	    		$img = new UserGuideImage();
	    		$img->user_guide_id = $user_guide->id;
	    		$img->image_path = $file_path;
	    		$img->save();

	    		$value->move(public_path("resource_center/user_guides/"), $file_path);
			}
		}
		return redirect()->back();
	}

	public function edit_user_guide_cms($id){
		try {
		$user_guide_detail = UserGuide::findOrFail($id);
		} catch (ModelNotFoundException $e) {
            return view('client.errors.copyof404');
        }
		return view('admin.edituserguide',compact('user_guide_detail'));
	}

	public function update_user_guide(Request $request){
		$validator = Validator::make($request->all(), [
            'description_en' => ['required'],
			'description_ar' => ['required'],
			'description_zh' => ['required'],
			'description_tr' => ['required'],
        ]);
        if ($validator->fails()) {
            Session::flash('error', $validator->messages());
            return Redirect::back()->withErrors($validator)->withInput();
        }
        
		$user_guide = UserGuide::find($request->id);
		$user_guide->title_en = $request->title_en;
		$user_guide->title_ar = $request->title_ar;
		$user_guide->title_zh = $request->title_zh;
		$user_guide->title_tr = $request->title_tr;
		$user_guide->description_en = $request->description_en;
		$user_guide->description_ar = $request->description_ar;
		$user_guide->description_zh = $request->description_zh;
		$user_guide->description_tr = $request->description_tr;
		$user_guide->save();

		return redirect()->back();
	}


	public function delete_user_guide($id){
		$userguide_images = UserGuideImage::where('user_guide_id',$id)->get();
		foreach($userguide_images as $image){
			File::delete(public_path("resource_center/user_guides/").$image->image_path);
			$news_image = UserGuideImage::find($image->id)->delete();
		}
		$news = UserGuide::find($id)->delete();
		
		return redirect()->back();
	}


			/////////////////////////// Resource Center - Document Template/////////////////////////////////
	public function show_all_doctemplates(){
	    //$doctemplates = DocumentTemplate::with('service_country_doctemplate')->get();

	    $doctemplates = ServiceCountryDocument::with('service')->with('country')->with('document')->get();
	    //dd($doctemplates);
        $services = Service::all();
        $countries = Country::all();
        return view('admin.doctemplate',compact('doctemplates', 'services', 'countries'));
    }

    public function add_new_doctemplate(Request $request){

		$file = $request->file('doctemp');

		$doctemplate = new DocumentTemplate();
		$doctemplate->doc_title = $request->title;
		$doctemplate->doc_file = 'x1.jpg';
		$doctemplate->save();
		$file_path = "doctemp_".$doctemplate->id."_".date("Ymdhis").".".$file->getClientOriginalExtension();
		$doctemplate->doc_file = $file_path;
		$doctemplate->save();

		foreach($request->services as $value){
			$servctydoc = new ServiceCountryDocument();
			$servctydoc->document_id = $doctemplate->id;
			$servctydoc->service_id = $value;
			$servctydoc->country_id = $request->country_id;
			$servctydoc->save();
		}
		$file->move(public_path("resource_center/document_template/"), $file_path);

		return redirect()->back();
	}

	public function update_doc_template(Request $request){
		$doctemp = DocumentTemplate::find($request->id);
		$doctemp->doc_title = $request->title;
		$doctemp->save();

		return redirect()->back();
	}

	public function delete_doc_template($id,$doc_id){

        ServiceCountryDocument::find($id)->delete();

		$doctemp = ServiceCountryDocument::where('document_id',$doc_id)->get();
		if(count($doctemp) == 0){
			$docfile = DocumentTemplate::find($doc_id);
		    File::delete(public_path("resource_center/document_template/").$docfile->doc_file);
			DocumentTemplate::find($doc_id)->delete();
		}
		return redirect()->back();
    }
    
}
