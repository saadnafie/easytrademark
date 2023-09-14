<?php

namespace App\Utility;

/**
 * Class SurveyResultMessages
 * @package App\Utility
 * @author hesham.mohamed19930@gmail.com
 */
class SurveyResultMessages
{
    /**
     * if your score percentage is between 0% to 50%
     */
    const STRENGTH_SURVEY_SCORE_BETWEEN_0_TO_50 =
        'It seems like your trademark is not strong, take a step back check your actions,
         and make sure to come up with a creative, unique and memorable trademark which no one can claim besides you!';

    /**
     * if your score percentage is between 50% to 75%
     */
    const STRENGTH_SURVEY_SCORE_BETWEEN_50_TO_75 =
        'Not bad, your trademark is not weak, but you can take some steps to make it stronger and claim it!';

    /**
     * if your score percentage is between 75% to 95%
     */
    const STRENGTH_SURVEY_SCORE_BETWEEN_75_TO_95 =
        'Great job! You seem to be on the right track, talk to a lawyer or proceed with doing a search to check if your
         trademark is available.';
}
