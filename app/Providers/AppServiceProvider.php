<?php

namespace App\Providers;

use App\Models\Service;
use App\Utility\AllowedCurrencies;
use http\Env;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\Intl\Currencies;
use Illuminate\Support\Facades\Session;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $allActiveServices = Service::where('isActive',1)->get();
        $allowedCurrencies = new AllowedCurrencies();
        if (App::environment('production')) {
            $clientIpAddress = \Request::ip();
            $response = Http::get("http://www.geoplugin.net/json.gp?ip=$clientIpAddress");
            $response = $response->json();
            $userCountryCurrencyCode = $response['geoplugin_currencyCode'];
        } else {
            $userCountryCurrencyCode = $allowedCurrencies->getDefaultSystemCurrencyCode();
        }
        if (in_array($userCountryCurrencyCode, $allowedCurrencies->getAllowedCurrenciesCode())) {
            $userCountryCurrencySymbol = Currencies::getSymbol($userCountryCurrencyCode);
        } else {
            $userCountryCurrencyCode = $allowedCurrencies->getDefaultSystemCurrencyCode();
            $userCountryCurrencySymbol = $allowedCurrencies->getDefaultSystemCurrencySymbol();
        }
        Session::put('systemDefaultCurrencyCode', $allowedCurrencies->getDefaultSystemCurrencyCode());
        Session::put('userCountryCurrencyCode', $userCountryCurrencyCode);
        Session::put('userCountryCurrencySymbol', $userCountryCurrencySymbol);
        View::share('allowCurrencies', $allowedCurrencies->getAllowedCurrenciesCode());
        View::share('allActiveServices', $allActiveServices);
    }
}
