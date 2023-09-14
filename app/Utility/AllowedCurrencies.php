<?php

namespace App\Utility;

use AshAllenDesign\LaravelExchangeRates\Classes\ExchangeRate;
use Carbon\Carbon;

/**
 * Class AllowedCurrencies
 * @package App\Utility
 * @author hesham.mohamed19930@gmail.com
 */
class AllowedCurrencies
{
    /**
     * united states of america dollar
     */
    const USA_DOLLAR = 'USD';

    /**
     * europa euro
     */
    const EURO = 'EUR';

    /**
     * australia dollar
     */
    const AUSTRALIA_DOLLAR = 'AUD';

    /**
     * british pound sterling
     */
    const BRITISH_POUND_STERLING = 'GBP';

    /**
     * china yuan
     */
    const CHINA_YUAN = 'CNY';

    /**
     * japan yen
     */
    const JAPAN_YEN = 'JPY';

    /**
     * canada dollar
     */
    const CANADA_DOLLAR = 'CAD';
	
	/**
     * Egyptian Pound
     */
    const EGYPTIAN_POUND = 'EGP';

    /**
     *
     */
    const SYSTEM_DEFAULT_CURRENCY_CODE = 'USD';

    /**
     *
     */
    const SYSTEM_DEFAULT_CURRENCY_SYMBOL = '$';

    /**
     * get all constant of available currencies
     * @return array()
     */
    public function getAllowedCurrenciesCode()
    {
        return [
            self::USA_DOLLAR,
            self::EURO,
            self::AUSTRALIA_DOLLAR,
            self::BRITISH_POUND_STERLING,
            self::CHINA_YUAN,
            self::JAPAN_YEN,
            self::CANADA_DOLLAR,
			//self::EGYPTIAN_POUND
        ];
    }

    /**
     * get the default currency code used in easy trademark system (USD)
     * @return string
     */
    public function getDefaultSystemCurrencyCode()
    {
        return self::SYSTEM_DEFAULT_CURRENCY_CODE;
    }

    /**
     * get the default currency symbol used in easy trademark system (USD symbol $)
     * @return string
     */
    public function getDefaultSystemCurrencySymbol()
    {
        return self::SYSTEM_DEFAULT_CURRENCY_SYMBOL;
    }

    /**
     * convert money amount value from currency to another currency use currency code
     * @param $value
     * @param $from
     * @param $to
     * @return int converted value
     */
    public function convertCurrency($value, $from, $to)
    {
        $exchangeRates = new ExchangeRate();
        return round($exchangeRates->convert($value, $from, $to, Carbon::today()), 2);
    }
}
