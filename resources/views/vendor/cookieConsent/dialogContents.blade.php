<div class="js-cookie-consent cookie-consent text-center"
     style="">

    <span class="cookie-consent__message">
        {!! trans('cookieConsent::texts.message') !!}
    </span>

    <button class="js-cookie-consent-agree cookie-consent__agree"
            style="
            box-shadow: 0 0 10px 3px rgba(108, 98, 98, 0.2);
                border: 0;
                background: #fff;
                border-radius: 11px;
                color: #000;
                width: 70px;
                height: 40px;
                cursor: pointer;
                margin-left: 15px;
            ">
        {{ trans('cookieConsent::texts.agree') }}
    </button>

</div>
