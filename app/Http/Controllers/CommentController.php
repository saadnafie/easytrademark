<?php

namespace App\Http\Controllers;

use App\Models\Trademark;
use App\Models\TrademarkComment;
use Illuminate\Http\Request;

use Mail;
/**
 * Class CommentController
 * @package App\Http\Controllers
 * @author Andrew Nady <andro.nady2015@gmail.com>
 */
class CommentController extends Controller
{
    /**
     * store comment on trademark orders
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request){
        $comment = new TrademarkComment();
        $comment->user_id = $request->userId;
        $comment->trademark_id = $request->trademarkId;
        $comment->comment_detail = $request->comment;
        $comment->save();
		
		$tmark_detail = Trademark::where('id',$request->trademarkId)->with('user')->with('representative')->with('trademark_country')->with('trademark_response_doc')->firstOrFail();
		
		
		if($tmark_detail->representative != null){
			
		$email = $tmark_detail->representative->email;
		
		//return $email;
		Mail::send('client/emails/trademarkcommentemail',
		array(
           'trademark_ref' => $tmark_detail->trademark_reference,
		   'trademark_link' => url('member/trademark_history_display/').'/'.$request->trademarkId,
		), function($message) use ($email)
		{
		   $message->from('info@easy-trademarks.com');
		   $message->to($email, 'Easytrademark Customer')->subject('Trademark Comment Notification');
		});	
		}else{
		
		//return $tmark_detail;
		
		$email = 'info@easy-trademarks.com';
		
		//return $email;
		Mail::send('client/emails/trademarkcommentemail',
		array(
           'trademark_ref' => $tmark_detail->trademark_reference,
		   'trademark_link' => url('member/trademark_history_display/').'/'.$request->trademarkId,
		), function($message) use ($email)
		{
		   $message->from('info@easy-trademarks.com');
		   $message->to($email, 'Easytrademark Customer')->subject('Trademark Comment Notification');
		});
		}
		
        return redirect()->back();
		
		
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id)
    {
        $trademarkComment = TrademarkComment::where('id', $id)->firstOrFail();
        $trademarkComment->delete();
        return response()->json(['status'=>true,'message'=>"Comment hidden successfully."]);
    }
}
