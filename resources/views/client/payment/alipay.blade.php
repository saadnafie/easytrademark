@extends('client.layouts.app')
@section('content')
    <head>


        <style>
            /**
             * The CSS shown here will not be introduced in the Quickstart guide, but shows
             * how you can use CSS to style your Element's container.
             */
            .StripeElement {
                box-sizing: border-box;

                height: 40px;

                padding: 10px 12px;

                border: 1px solid transparent;
                border-radius: 4px;
                background-color: white;

                box-shadow: 0 1px 3px 0 #e6ebf1;
                -webkit-transition: box-shadow 150ms ease;
                transition: box-shadow 150ms ease;
            }

            .StripeElement--focus {
                box-shadow: 0 1px 3px 0 #cfd7df;
            }

            .StripeElement--invalid {
                border-color: #fa755a;
            }

            .StripeElement--webkit-autofill {
                background-color: #fefde5 !important;
            }

        </style>
        <script src="https://js.stripe.com/v3/"></script>
    </head>

    <center>
        <br><br>
        <img src="{{url('public/img/Alipay_logo.png')}}" width="200px"><br><br>
        Using Alipay wallet to pay<br>Experience fast, easy and safe online payment
        <br><br>
        <form id="payment-form">

            <input type="hidden" value="{{$pay->client_secret}}" id="client_secret">

            <input type="hidden" value="{{url('alipay_redirect')}}/{{$order_id}}/{{$isDocument}}/{{$isTranslation}}"
                   id="return_url_val">

            <div id="card-element">
                <!-- Elements will create input elements here -->
            </div>

            <!-- We'll put the error messages in this element -->
            <div id="card-errors" role="alert"></div>

            <button id="submit" class="btn btn-primary btn-lg"><b style="font-size:20px;color:white;">Pay {{$amount}} $
                    <!--¥--></b></button>
        </form>
    </center>
    <br><br>

    <script>

var stripe = Stripe('pk_test_51HCoPaHfokq1HPxE4IehVGUVgKgeifcJcqHEvmFHsf1GprApdgxlBlTPIO0wxZLinl2mh4bm3nEdcqTD1x4wwCXM00Slkg66pv');

//var stripe = Stripe('pk_live_51HCoPaHfokq1HPxEiRpnuQhoPG5JSr7faBvYfw67KMxQofYQKJ8OHAwTMD30kf7GEdORt2tuK1no41jTHQFm1Fs900IFSgYsEK');
var form = document.getElementById('payment-form');
var clientSecret = document.getElementById('client_secret').value;
//var url = "{ url('alipay_redirect')/$order_id/$isDocument) }";
/*var url = 'http://localhost/easymarks_master/alipay_redirect/'.<?php echo $order_id; ?>.'/'.<?php echo $isDocument; ?>;
*/
var url = document.getElementById('return_url_val').value;
console.log(url);

        form.addEventListener('submit', function (event) {
            event.preventDefault();
            // Set the clientSecret here you got in Step 2
            stripe.confirmAlipayPayment(clientSecret, {
                // Return URL where the customer should be redirected to after payment

                return_url: url,
            }).then((result) => {
                if (result.error) {
                    // Inform the customer that there was an error.
                    var errorElement = document.getElementById('error-message');
                    errorElement.textContent = result.error.message;

                }
            });
        });

    </script>
@endsection
