<?php

namespace App\Utility;

/**
 * Class SurveyTypesAliases
 * @package App\Utility
 * @author hesham.mohamed19930@gmail.com
 */
class SurveyTypesAliases
{
    /**
     * Identify the type of IP survey
     */
    const IDENTIFY_THE_TYPE_OF_IP = 'identify-the-type-of-ip';

    /**
     * Strength survey
     */
    const STRENGTH = 'strength';

    /**
     * Follow the guided steps survey
     */
    const FOLLOW_THE_GUIDED_STEPS = 'follow-the-guided-steps';

    /**
     * Ensure protection survey
     */
    const ENSURE_PROTECTION = 'ensure-protection';

    /**
     * get all constant of available survey types aliases
     * @return array()
     */
    public function getSurveyTypesAliases()
    {
        return [
            self::IDENTIFY_THE_TYPE_OF_IP,
            self::STRENGTH,
            self::FOLLOW_THE_GUIDED_STEPS,
            self::ENSURE_PROTECTION
        ];
    }
}
