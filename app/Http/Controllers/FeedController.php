<?php

namespace App\Http\Controllers;

use App\Models\RssFeed;

class FeedController extends Controller
{
	
	public function display_all_feeds($id)
    {
		$allfeedslist = RssFeed::all();
		//$feedcount = count($allfeedslist);
		$allfeeds = RssFeed::where('id', $id)->first();
        return view('feed',compact('allfeeds', 'allfeedslist', 'id'));
    }
    
}
	
	