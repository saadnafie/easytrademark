<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Question;
use App\Survey;
use App\Utility\SurveyResultMessages;
use App\Utility\SurveyTypesAliases;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

/**
 * Class SurveyController
 * @package App\Http\Controllers
 * @author Hesham Mohamed <hesham.mohamed19930@gmail.com>
 */
class SurveyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create(Request $request)
    {
        if ($request->has('survey_id') && $request->get('survey_id') !== null) {
            $surveyId = $request->get('survey_id');
            $survey = Survey::find($surveyId);
            switch ($survey->survey_alias) {
                case SurveyTypesAliases::IDENTIFY_THE_TYPE_OF_IP:
                    if ($request->has('is_master')) {
                        $request->session()->forget('surveyResult');
                        $questions = Question::where(['is_master' => true, 'survey_id' => $surveyId])->get();
                    } else {
                        $currentQuestionId = $request->get('current_question_id');
                        $questions = Question::where('id', $currentQuestionId)->get();
                    }
                    break;
                case SurveyTypesAliases::STRENGTH:
                    if ($request->has('is_master')) {
                        $request->session()->forget('surveyResult');
                        $questions = Question::where(['is_master' => true, 'survey_id' => $surveyId])->get();
                        $questions->is_master = true;
                    } else {
                        $questionsIds = explode(',' , $request->get('current_question_ids'));
                        if (!empty($questionsIds)) {
                            $questions = Question::whereIn('id', $questionsIds)->get();
                        }
                    }
                    break;
                case SurveyTypesAliases::FOLLOW_THE_GUIDED_STEPS:
                    echo "Your favorite color is green!";
                    break;
                case SurveyTypesAliases::ENSURE_PROTECTION:
                    echo "Your favorite color is red!";
                    break;
            }
        }
        return view('survey.create')->with('questions', $questions);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $selectedAnswersIds = ($request->session()->has('surveyResult')) ? $request->session()->get('surveyResult')['selectedAnswersIds']: [];
        $slider = ($request->session()->has('surveyResult')) ? $request->session()->get('surveyResult')['slider']: 0;
        $nextQuestionsIds = '';
        $isFinal = false;
        $finalMessage = ($request->session()->has('surveyResult')) ? $request->session()->get('surveyResult')['finalMessage']: '';
        $queryParam = [];
        $surveyId = $request->get('survey_id');
        foreach ($request->all() as $key => $postData) {
            if (strpos($key, 'question_answer') !== false) {
                $answer = Answer::where('id', $postData)->first();
                $selectedAnswersIds[] = $answer->id;
                if ($answer->next_question_ids !== null) {
                    (empty($nextQuestionsIds)) ? $nextQuestionsIds = $answer->next_question_ids :
                        $nextQuestionsIds = $nextQuestionsIds . ',' . $answer->next_question_ids;
                }
                if ($answer->is_final == true) {
                    $isFinal = true;
                    if ($answer->final_answer_message !== NULL) {
                        $finalMessage = $finalMessage . $answer->final_answer_message;
                    }
                }
            }
        }

        $survey = Survey::find($surveyId);
        switch ($survey->survey_alias) {
            case SurveyTypesAliases::IDENTIFY_THE_TYPE_OF_IP:
                if ($isFinal == true) {
                    return view('survey.result')->with('finalAnswer', $finalMessage);
                }
                $queryParam = [
                    'survey_id' => $surveyId,
                    'current_question_id' => $nextQuestionsIds
                ];
                break;
            case SurveyTypesAliases::STRENGTH:
                if ($request->has('slider') && !empty($request->get('slider'))) {
                    $slider = $request->get('slider');
                }
                $queryParam = [
                    'survey_id' => $surveyId,
                    'current_question_ids' => $nextQuestionsIds
                ];
                $surveyResult = [
                  'finalMessage' => $finalMessage,
                  'selectedAnswersIds' => $selectedAnswersIds,
                  'slider' => $slider
                ];
                $request->session()->put('surveyResult', $surveyResult);
                if (empty($nextQuestionsIds)) {
                    $selectedAnswersIds = $surveyResult['selectedAnswersIds'];
                    $selectedAnswersIds = array_unique($selectedAnswersIds);
                    $totalScore = Answer::whereIn('id', $selectedAnswersIds)->sum('min_points');
                    $maxScore = Answer::whereIn('id', $selectedAnswersIds)->sum('max_points');
                    $surveyResult['score'] = $totalScore;
                    $surveyResult['maxScore'] = $maxScore;
                    $surveyResult['scorePercentage'] =
                        ($totalScore < 0) ? 0 : round(($totalScore/$maxScore) * 100, 2);
                    if ($surveyResult['scorePercentage'] >= 0 && $surveyResult['scorePercentage'] <= 50) {
                        $surveyResult['scoreMessage'] = SurveyResultMessages::STRENGTH_SURVEY_SCORE_BETWEEN_0_TO_50;
                    } else if ($surveyResult['scorePercentage'] >= 50 && $surveyResult['scorePercentage'] <= 75) {
                        $surveyResult['scoreMessage'] = SurveyResultMessages::STRENGTH_SURVEY_SCORE_BETWEEN_50_TO_75;
                    } else if ($surveyResult['scorePercentage'] >= 75 && $surveyResult['scorePercentage'] <= 95) {
                        $surveyResult['scoreMessage'] = SurveyResultMessages::STRENGTH_SURVEY_SCORE_BETWEEN_75_TO_95;
                    }
                    $request->session()->put('surveyResult', $surveyResult);
                    return redirect()->route('result');
                }
                break;
            case SurveyTypesAliases::FOLLOW_THE_GUIDED_STEPS:
                echo "Your favorite color is green!";
                break;
            case SurveyTypesAliases::ENSURE_PROTECTION:
                echo "Your favorite color is red!";
                break;
        }
        return redirect()->route('survey.create', $queryParam);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function result(Request $request)
    {
        $surveyResult = $request->session()->get('surveyResult');
        return view('survey.result')->with('surveyResult', $surveyResult);
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
        //
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function mail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'name' => 'required|string',
            'score' => 'required|numeric',
            'max_score' => 'required|numeric',
            'slider' => 'required|numeric',
            'score_percentage' => 'required|numeric',
            'g-recaptcha-response' => 'required'
        ]);

       $to = $request->get('email');
       $name = $request->get('name');
       // user guess about his trademark strength
       $slider = $request->get('slider');
       $score = $request->get('score');
       $maxScore = $request->get('max_score');
       $scorePercentage = $request->get('score_percentage');
       $finalMessage = ($request->has('final_message')) ? $request->get('final_message') : null;
       $scoreMessage = ($request->has('score_message')) ? $request->get('score_message') : null;

       $email = new \stdClass();
       $email->to = $to;
       $email->score = $score;
       $email->maxScore = $maxScore;
       $email->scorePercentage = $scorePercentage;
       $email->slider = $slider;
       $email->name = $name;
       $email->finalMessage = $finalMessage;
       $email->scoreMessage = $scoreMessage;
        Mail::send('client.emails.surveyResultMail', ['email' => $email], function ($message) use ($email) {
            $message->from('info@easy-trademarks.com', 'Your Application');
            $message->to($email->to, $email->name)->subject('Result Of You Trademark Survey');
        });
        return redirect()->route('home');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
