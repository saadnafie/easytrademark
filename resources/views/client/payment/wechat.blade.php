@extends('client.layouts.app')
@section('content')
    <head>
        <link rel="stylesheet"
              href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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

    </head>

    <div class="container">
        <center>
            <br>Using WeChat wallet to pay<br>Experience fast, easy and safe online payment
            <br>
            <img src="{{url('public/img/wechat.png')}}" width="200px">
        </center>

        <div class="row">
            <div class="col-md-6">
                <div class="card bg-primary text-white">
                    <div class="card-body"><i class="fa fa-hand-o-right" style="font-size:24px"></i> Step-1: Scan
                        QR-Code
                    </div>
                </div>
                <br>
                <center>
                    <div style="background-color: rgb(255,255,204);padding:20px;width:fit-content;">
                        {!! QrCode::size(150) ->generate($pay->wechat->qr_code_url)!!}
                    </div>
                </center>
            </div>

            <div class="col-md-6">
                <div class="card bg-primary text-white">
                    <div class="card-body"><i class="fa fa-hand-o-right" style="font-size:24px"></i> Step-2: Confirm
                        Payment Transfer
                    </div>
                </div>
                <br>
                <form id="payment-form" action="{{route('charge')}}" method="post">
                    @csrf
                    <input type="hidden" value="{{$pay->id}}" id="source" name="source">
                    <input type="hidden" name="order_id" value="{{$order_id}}">
                    <input type="hidden" name="isDocument" value="{{$isDocument}}">
                    <input type="hidden" name="isTranslation" value="{{$isTranslation}}">

                    <div id="card-element">
                        <!-- Elements will create input elements here -->
                    </div>

                    <!-- We'll put the error messages in this element -->
                    <div id="card-errors" role="alert"></div>

                    <center>
                        <p style="color:red;font-size:12px;">* After you scan QR-code and confirm in wechat App money
                            transfer..you should confirm on our website to guarantee secure transaction.</p>
                        <button id="submit" class="btn btn-success btn-lg"><b style="font-size:20px;color:white;"><i
                                    class="fa fa-check" style="font-size:24px"></i> Confirm {{$amount}} $</b></button>

                    </center>
                </form>
            </div>
        </div>
        <br><br>
    </div>
@endsection
