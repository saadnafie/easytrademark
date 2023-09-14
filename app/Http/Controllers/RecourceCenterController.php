<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\NewsImage;
use App\Models\ServiceCountryDocument;
use Illuminate\Http\Request;
use App\Models\Community;
use App\Models\News;
use App\Models\Faq;
use App\Models\RssFeed;
use App\Models\UserGuide;
use Illuminate\Support\Facades\App;

/**
 * Class RecourceCenterController
 * @package App\Http\Controllers
 * @author Andrew Nady <andro.nady2015@gmail.com>
 */
class RecourceCenterController extends Controller
{
    /**
     * show resource center page
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function recourseCenter()
    {
        return view('client.recourseCenter.recourseCenter');
    }

    /**
     * show FAQs page
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function faq(Request $request)
    {
        if ($request->has('searchFAQ') && $request->get('searchFAQ') !== null) {
            $questionCol = 'question_' . App::getLocale();
            $answerCol = 'answer_' . App::getLocale();
            $searchFAQ = $request->get('searchFAQ');
            $faqs = Faq::where($questionCol, 'like', '%'. $searchFAQ . '%')->orWhere($answerCol, 'like', '%'. $searchFAQ . '%')->get();
        } else {
            $faqs = Faq::all();
        }
        $searchValue = ($request->has('searchFAQ')) ? $request->get('searchFAQ') : '';
        return view('client.recourseCenter.faq', ['faqs' => $faqs, 'searchValue' => $searchValue]);
    }
	
	public function faqDetails($slug)
    {
        try {
            $faqs = Faq::where('q_slug',$slug)->firstorfail();
        } catch (ModelNotFoundException $e) {
             return view('client.errors.copyof404');
        }
            return view('client.recourseCenter.faq-details', ['faqs' => $faqs]);
    }

    /**
     * show our community page
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function community()
    {
        $community = Community::all();
        return view('client.recourseCenter.community', compact('community'));
    }

    /**
     * show Forms & template page
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function templates()
    {
        $countries = Country::all();
        return view('client.recourseCenter.templates', ['countries' => $countries]);
    }

    /**
     * search on Forms & template page
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function templatesSearch(Request $request)
    {
        $countryId = $request->country;
        $Documents = ServiceCountryDocument::where('country_id',$countryId)->with('country')->with('service')->with('document')->get()->groupBy('service_id');
        $countries = Country::all();
        $selectedCountry = Country::find($request->country);
        return view('client.recourseCenter.templates',
            [
                'countries' => $countries,
                'selectedCountry' => $selectedCountry,
                'Documents' => $Documents,
            ]);
    }

    /**
     * show News page
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function News()
    {
        $news = News::with('images')->paginate(10);

        return view('client.recourseCenter.news', ['news' => $news]);
    }
	
	   public function rss_feed_list($id)
    {

		$allfeedslist = RssFeed::all();
		//$feedcount = count($allfeedslist);
		$allfeeds = RssFeed::where('id', $id)->first();

		$allfeeds1 = RssFeed::where('id', $id)->get();
		if(count($allfeeds1) == 0)
			return view('client/errors/pageNotFound');

        return view('client.recourseCenter.rssfeedlist', [ 'allfeeds' => $allfeeds, 'allfeedslist' => $allfeedslist, 'id' => $id]);
    }

    /**
     * article details page
     *
     * @param $id
     * @return mixed
     */
    public function newsDetails($new_slug){
		$details = News::where('news_slug',$new_slug)->with('images')->firstorfail();
        return view('client.recourseCenter.newsDetails',compact('details'));
    }

    public function userguide_list()
    {
        $userguide = UserGuide::with('images')->paginate(10);

        //return $userguide;

        return view('client.recourseCenter.userguide', ['userguide' => $userguide]);
    }

     public function userguide_Detail($ug_slug){
        $userguidedetail = UserGuide::where('guide_slug', $ug_slug)->with('images')->firstorfail();
        return view('client.recourseCenter.userguidedetail',compact('userguidedetail'));
    }
}
