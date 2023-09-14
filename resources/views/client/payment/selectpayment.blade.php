@extends('client.layouts.app')
@section('content')

    @if (Session::has('failed'))
        <div class="alert alert-danger text-center" style="margin-bottom: 0px" id="alert">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
            <p>{{ Session::get('failed') }}</p>
        </div>
    @endif
    <script type="text/javascript">
        setTimeout(function () {
            $('#alert').alert('close');
        }, 5000);
    </script>

	<img src="{{url('public/img/stripe.jpg')}}" style="width:100%;opacity:.3;height:300px;">
    <div class="container">
        <br><br>

        <div class="row">
		
		<div class="col-md-8">
		<h3> Billing Summary
	    </h3>
		<br>
		<ul class="list-group list-group-flush">
		<!--<li class="list-group-item d-flex justify-content-between align-items-center">
		  Governmental Fees:	
		  <span class="badge badge-light badge-pill">00.00 $</span>
		</li>
		<li class="list-group-item d-flex justify-content-between align-items-center">
		  Administration Fees:	
		  <span class="badge badge-light badge-pill">00.00 $</span>
		</li>-->
		@if($isTranslation == 0)
		<li class="list-group-item d-flex justify-content-between align-items-center">
		  Sub Total:	
		  <span class="badge badge-light badge-pill">{{$order->total_fees - round(($order->total_fees * .035 ) / 1.035,2)}} $</span>
		</li>
		<li class="list-group-item d-flex justify-content-between align-items-center">
		  Payment Processing Fees:	
		  <span class="badge badge-light badge-pill">{{ round(($order->total_fees * .035 ) / 1.035,2) }} $</span>
		</li>
		@else
		<li class="list-group-item d-flex justify-content-between align-items-center">
		  Sub Total:	
		  <span class="badge badge-light badge-pill">{{$order->total_price - round(($order->total_price * .035 ) / 1.035,2)}} $</span>
		</li>
		<li class="list-group-item d-flex justify-content-between align-items-center">
		  Payment Processing Fees:	
		  <span class="badge badge-light badge-pill">{{ round(($order->total_price * .035 ) / 1.035,2) }} $</span>
		</li>
		
		@endif
		<li class="list-group-item d-flex justify-content-between align-items-center">
		  Shipping Standard:	
		  <span class="badge badge-light badge-pill">00.00 $</span>
		</li>
		@if($isTranslation == 0)
		<li class="list-group-item d-flex justify-content-between align-items-center">
		  Discount(-):	
		  <span class="badge badge-light badge-pill">
		  @if($order->final_fees_after_discount > 0)
		  {{$order->total_fees - $order->final_fees_after_discount}} $
		  @else
		  00.00 $
		  @endif
		  </span>
		</li>
		@else
		<li class="list-group-item d-flex justify-content-between align-items-center">
		  Discount(-):	
		  <span class="badge badge-light badge-pill">00.00 $</span>
		</li>
		@endif
		<li class="list-group-item d-flex justify-content-between align-items-center">
		  Tax:	
		  <span class="badge badge-light badge-pill">00.00 $</span>
		</li>
		
		@if($isTranslation == 0)
		<li class="list-group-item list-group-item-secondary d-flex justify-content-between align-items-center">
		  <b>Total:</b>	
		  <span class="badge badge-light badge-pill">
		  @if($order->discount_id == null)
		  {{$order->total_fees}} $
		  @else
		  {{$order->final_fees_after_discount}} $
		  @endif
		  </span>
		</li>
		@else
		<li class="list-group-item list-group-item-secondary d-flex justify-content-between align-items-center">
		  <b>Total:</b>	
		  <span class="badge badge-light badge-pill">{{$order->total_price}} $</span>
		</li>
		@endif
	  </ul>	
		</div>
		
        <div class="col-md-4">
		<h3> Payment options
	    </h3>
         <br>
		  <img src="{{url('public/img/visamaster.png')}}" width="100px"><br>
		   <p style="font-size:11px;">Accept Visa, Mastercard, American Express, Discover, Diners Club, and JCB payments from customers worldwide.</p>
			@if($isTranslation == 0)
				<a href="{{ route('stripe.create', array('id' => $order_id,  'isDocument' => $isDocument)) }}"
				   class="btn hero-btn btn-lg btn-block">Visa or Master Card</a>
			@else
				<a href="{{ route('stripe.create', array('id' => $order_id,  'isTranslationService' => true)) }}"
				   class="btn hero-btn btn-lg btn-block">Visa or Master Card</a>
			@endif
	     
		<hr>


		  <img src="{{url('public/img/Alipay_logo.png')}}" width="90px"><br>
		  <p style="font-size:11px;">Alipay enables Chinese consumers to pay directly via online transfer
								from their bank account. Customers are redirected to Alipay's
								payment page to log in and approve payments.</p>
		  
			<form method="post" action="{{route('alipay')}}" style=" display: contents; ">
                                @csrf
                                <input type="hidden" name="order_id" value="{{$order_id}}">
                                <input type="hidden" name="isDocument" value="{{$isDocument}}">
                                <input type="hidden" name="isTranslation" value="{{$isTranslation}}">

                                <button type="submit" class="btn hero-btn btn-lg btn-block">Alipay Wallet</button>
                            </form>

		<hr>
	
		

		  <img src="{{url('public/img/wechat3.png')}}" width="100px"><br>
		  <p style="font-size:11px;">WeChat Pay enables Chinese consumers to pay directly via online
											transfer from their account. Customers are given a QR Code to scan
											using their WeChat mobile application to approve payments.</p>
		  
			<form method="post" action="{{route('wechat')}}" style=" display: contents; ">
                                @csrf
                                <input type="hidden" name="order_id" value="{{$order_id}}">
                                <input type="hidden" name="isDocument" value="{{$isDocument}}">
                                <input type="hidden" name="isTranslation" value="{{$isTranslation}}">

                                <button type="submit" class="btn hero-btn btn-lg btn-block">WeChat Wallet</button>

                            </form>

						

		</div>
		
		</div>
		
		<?php /*
		<div class="row justify-content-md-center">
            <div class="col-md-4">
                <table class="table table-striped">

                    <tr>
                        <td><img src="{{url('public/img/visamaster.png')}}" width="100px"><br>&nbsp;&nbsp;</td>
                        <td>
                            @if($isTranslation == 0)
                                <a href="{{ route('stripe.create', array('id' => $order_id,  'isDocument' => $isDocument)) }}"
                                   class="btn hero-btn btn-lg btn-block">Visa or Master Card ({{$order->total_fees}} $)</a></td>
                        @else
                            <a href="{{ route('stripe.create', array('id' => $order_id,  'isTranslationService' => true)) }}"
                               class="btn hero-btn btn-lg btn-block">Visa or Master Card</a></td>
                        @endif
						
                    </tr>
                    <tr>
                        <td colspan="2"><p>Accept Visa, Mastercard, American Express, Discover, Diners Club, and JCB payments from customers worldwide.</p><br></td>
                    </tr>
                    <tr>
                        <td><img src="{{url('public/img/Alipay_logo.png')}}" width="90px">&nbsp;&nbsp;</td>
                        <td>
                            <!--<a href="" class="btn hero-btn btn-lg btn-block"  >Alipay Wallet</a>-->
                            <form method="post" action="{{route('alipay')}}" style=" display: contents; ">
                                @csrf
                                <input type="hidden" name="order_id" value="{{$order_id}}">
                                <input type="hidden" name="isDocument" value="{{$isDocument}}">
                                <input type="hidden" name="isTranslation" value="{{$isTranslation}}">

                                <button type="submit" class="btn hero-btn btn-lg btn-block">Alipay Wallet ({{$order->total_fees}} $)</button>
                            </form>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2"><p>Alipay enables Chinese consumers to pay directly via online transfer
								from their bank account. Customers are redirected to Alipay's
								payment page to log in and approve payments.</p><br></td>
                    </tr>
                    <tr>
                        <td><img src="{{url('public/img/wechat3.png')}}" width="100px">&nbsp;&nbsp;</td>
                        <td>
                            <!--<a href="" class="btn hero-btn btn-lg btn-block"  >WeChat Wallet</a>-->
                            <form method="post" action="{{route('wechat')}}" style=" display: contents; ">
                                @csrf
                                <input type="hidden" name="order_id" value="{{$order_id}}">
                                <input type="hidden" name="isDocument" value="{{$isDocument}}">
                                <input type="hidden" name="isTranslation" value="{{$isTranslation}}">

                                <button type="submit" class="btn hero-btn btn-lg btn-block">WeChat Wallet ({{$order->total_fees}} $)</button>

                            </form>
                        </td>
                    </tr>
					<tr>
                        <td colspan="2"><p>WeChat Pay enables Chinese consumers to pay directly via online
											transfer from their account. Customers are given a QR Code to scan
											using their WeChat mobile application to approve payments.</p><br></td>
                    </tr>

                </table>
            </div>
        </div>
		*/ ?>
        <br><br><br><br>
    </div>
@endsection
