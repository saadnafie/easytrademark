@extends('client.layouts.app')
@section('content')
    <div class="profile">
        <div class="container">
            <br><br>
            <div class="head">
                <br><br>
                <h3 class="text-center">Details
                    <hr>
                    @if($orders->order->service_package->service_id == 1 || $orders->order->service_package->service_id == 7 || $orders->order->service_package->service_id == 8)
					
					@else
                    <a href="{{url('required-documents').'/' .$orders->order_id }}"> ( Upload required Documents )</a>
                    @endif
                </h3>
            </div>
            <br><br>
            <div class="order-detials">
                <!--  trademark image if exists -->
                @if($orders->trademark_country->trademark->trademark_image != null)
                    <img
                        src="{{ asset('public/img/trademarksImages').'/'.$orders->trademark_country->trademark->trademark_image}} "
                        alt=""
                       /><br><br>
                @endif
            <!--  trademark_label  || trademark_reference  if exists -->
                <div class="row">
                    @if($orders->trademark_country->trademark->trademark_label != null)
                        <div class="col-md-6">
                            <span class="checkout-btn">Label  </span> <span
                                class="checkout-data2">{{$orders->trademark_country->trademark->trademark_label}}</span>
                        </div>
                    @endif
                    <br><br><br>
                    @if($orders->trademark_country->trademark->trademark_reference != null)
                        <div class="col-md-6">
                            <span class="checkout-btn">Reference  </span> <span
                                class="checkout-data2">{{$orders->trademark_country->trademark->trademark_reference}}</span>
                        </div>
                    @endif
                </div>
                <!--   Applicant Name || Applicant Address  if exists -->
                @if(isset($orders->order->trademark_registration->applicant_name) && $orders->order->trademark_registration->applicant_name != null && isset($orders->order->trademark_registration->applicant_address) && $orders->order->trademark_registration->applicant_address != null)
                    <div class="row">
                        <div class="col-md-6">
                            <span class="checkout-btn">Applicant Name </span> <span
                                class="checkout-data2">{{$orders->order->trademark_registration->applicant_name}}</span>
                        </div>
                        <br><br><br>
                        <div class="col-md-6">
                            <span class="checkout-btn"> Address </span> <span
                                class="checkout-data2" style="line-height:normal;padding: 12px 0">{{$orders->order->trademark_registration->applicant_address}}</span>
                        </div>
                    </div>
                @endif
            <!--   Service Name || payment status   if exists -->
                <div class="row">
                    @if($orders->order->service_package->service->service_name)
                        <div class="col-md-6">
                            <span class="checkout-btn">Service </span> <span
                                class="checkout-data2">{{$orders->order->service_package->service->service_name}}</span>
                        </div>
                    @endif<br><br><br>
                    <div class="col-md-6">
                        @if( $orders->order->isPayed == 0)
                            <span class="checkout-btn">Payment </span> <span class="checkout-data">Not Paid</span>
                        @else
                            <span class="checkout-btn">Payment </span> <span class="checkout-data"> Paid</span>
                        @endif
                    </div>
                </div>
                @if($orders->trademark_country->trademark->trademark_word_en )
                    <div class="row">
                        <div class="col-md-6">
                            <span class="checkout-btn">English </span> <span
                                class="checkout-data2">{{$orders->trademark_country->trademark->trademark_word_en}}</span>
                        </div>
                        <br><br><br>
                        <div class="col-md-6">
                        </div>
                    </div>
                @endif
                @if($orders->trademark_country->trademark->trademark_word_ar )
                    <div class="row">
                        <div class="col-md-6">
                            <span class="checkout-btn">Arabic </span> <span
                                class="checkout-data2">{{$orders->trademark_country->trademark->trademark_word_ar}}</span>
                        </div>
                        <br><br><br>
                        <div class="col-md-6">
                        </div>
                    </div>
                @endif
            <!--  filling number   || filling date  if exists -->
                @if($orders->trademark_country->trademark_filling)
                        <div class="row">
                            <div class="col-md-6">
                                <span class="checkout-btn">Filling Number </span> <span
                                    class="checkout-data2">{{$orders->trademark_country->trademark_filling->filling_number}}</span>
                            </div>
                            <br><br><br>
                            <div class="col-md-6">
                                <span class="checkout-btn">Filling Date </span> <span
                                    class="checkout-data2">{{$orders->trademark_country->trademark_filling->filling_date}}</span>
                            </div>
                        </div>
                @endif
            <!-- Package Name  || Country Name  if exists -->
                @if($orders->order->service_package->package->package)
                    <div class="row">
                        <div class="col-md-6">
                            <span class="checkout-btn">Type </span> <span
                                class="checkout-data2">{{$orders->order->service_package->package->package}}</span>
                        </div>
                        <br><br><br>
                        <div class="col-md-6">
                        </div>
                    </div>
                @endif
                @if($orders->trademark_country->country->country_name)
                    <div class="row">
                        <div class="col-md-6">
                            <span class="checkout-btn">Country </span>
                            <span class="checkout-data2">{{$orders->trademark_country->country->country_name}}</span>
                        </div>
                        <br><br><br>
                        <div class="col-md-6">
                        </div>
                    </div>
                @endif
                @if($orders->order->due_date)
                    <div class="row">
                        <div class="col-md-6">
                            <span class="checkout-btn">Due Date </span> <span class="checkout-data2">
                                {{$orders->order->due_date}}
                            </span>
                        </div>
                        <br><br><br>
                        <div class="col-md-6">
                        </div>
                    </div>
                @endif
            <!-- Fast search if exists yes or no -->
                @if($orders->trademark_country->isFast)
                    <div class="row">
                        <div class="col-md-6">
                            <span class="checkout-btn">Fast search </span> <span class="checkout-data2">
                                {{$orders->trademark_country->isFast  == 1 ? 'Yes' : 'No'}}
                            </span>
                        </div>
                        <br><br><br>
                        <div class="col-md-6">
                        </div>
                    </div>
                @endif
            <!-- Documents  if exists -->
			@if($orders->order->service_package->service_id == 1 || $orders->order->service_package->service_id == 7 || $orders->order->service_package->service_id == 8)
					
					@else
                <div class="row">
                    <div class="col-md-6">
                        <span class="checkout-btn">Documents </span>
                        <span class="checkout-data2">
                            <button type="button" class="text-center add-c-c" data-toggle="modal" data-target="#document">
                                see all
                            </button>
                        </span>
                    </div>
                    <br><br><br>
                    <div class="col-md-6"><br><br><br>
                        <div class="modal fade" id="document" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                             aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content" style="top:80px">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Documents</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-card">
                                            <p>
                                                all documents :
                                            </p>
                                            <form method="POST" action="">
                                                @if(count($orders->trademark_country->trademark_document) > 0 )
                                                    @foreach($orders->trademark_country->trademark_document as $document)
                                                        <a href="{{ url('public/img/documents') }}/{{$document->document_file}}">{{$document->document_title->document_title}}</a><br><br>
                                                    @endforeach
                                                @else
                                                    <i>No Documents Available </i>
                                                @endif

                                                <div class="modal-footer">
                                                    <button type="button"  style="color: #000" data-dismiss="modal">Close</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
				@endif
                <!-- is arabic or not -->
                @if( isset($orders->order->trademark_registration->isArabic) && $orders->order->trademark_registration->isArabic != null)
                    <div class="row">
                        <div class="col-md-6">
                            <span class="checkout-btn">Is Arabic  </span> <span class="checkout-data2">
                                    @if($orders->order->trademark_registration->isArabic == 0)
                                    No
                                @else
                                    Yes
                                @endif
                                    </span>
                        </div>
                    </div>
                @endif
            <!--   Order Status From dashboard -->
                <div class="row">
                    <div class="col-md-6">
                        <span class="checkout-btn">Order Status </span> <span class="checkout-data">
                            @if($orders->country_order_status == 0)
                                Received
                            @elseif($orders->country_order_status == 1)
                                In Process
                            @else
                                Completed
                            @endif
                        </span>
                    </div>
                    <br><br><br>
                    <div class="col-md-6">
                    </div>
                </div>
                <!--   Trademark  Status From dashboard -->
                <div class="row">
                    <div class="col-md-12">
                        <span class="checkout-btn" style="line-height:normal;margin:2px">TM Status </span> <span
                            class="checkout-data"
                            style="line-height:normal">{{$orders->trademark_response->response_msg}}</span>
                    </div>
                    <br><br><br>
                    <div class="col-md-6">
                    </div>
                </div><br><br>
                <!-- Trademark Final registration Form if service is Registration -->
                @if($orders->order->service_package->service_id == 7 &&  $orders->trademark_response->id == 17 && $orders->country_order_status == 2)
                    @if($isExistFinalRegistration == 'Yes')
					
					@elseif($isExistFinalRegistration == 'No')
					<div class="row">
                        <div class="col-md-12">
                            <a href="{{url('finalRegistration')}}/{{$orders->trademark_country_id}}/{{$orders->trademark_country->country_id}}/{{$orders->trademark_country->trademark->id}}"
                               class="" style="text-align: left;color:#fff">Starting final registration Service Process
                            </a>
                        </div>
                        <br><br><br>
                        <div class="col-md-6">
                        </div>
                    </div>
					@endif
                @endif
            <!-- Trademark publication Form if service is Registration -->
                @if($orders->order->service_package->service_id == 2 &&  $orders->country_order_status == 2 && $orders->trademark_response->id == 12 )
                    
					@if($isExistpublication == 'Yes')
					
					@elseif($isExistpublication == 'No')
					<div class="row">
                        <div class="col-md-12">
                            <a href="{{url('publication')}}/{{$orders->trademark_country_id}}/{{$orders->trademark_country->country_id}}/{{$orders->trademark_country->trademark->id}}"
                               class="" style="text-align: left;color:#fff">Starting Publication Service Process
                            </a>
                        </div>
                        <br><br><br>
                        <div class="col-md-6">
                        </div>
                    </div>
					@endif
					
                @endif
                <br><br>
                <!-- Pay button-->
                @if( $orders->order->isPayed == 0)
				    <div class="row">
                        <div class="col-md-12 text-center">
                            <a href="{{ url('/checkoutDetails')}}/{{$orders->trademark_country->trademark->id}}/{{$orders->order_id}}"
                               class="btn hero-btn text-center">Go to check</a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <a href="{{ url('/selectpayment')}}/{{$orders->order_id}}/false/0"
                               class="btn hero-btn text-center">Pay Now</a>
                        </div>
                    </div>
                @endif
            </div>
            <br><hr>			
			<h3 class="text-center">
			  Documents list for translation
			<hr>
			</h3>
			<br><br>
			<div class="row">
                        <div class="col-md-12 text-left">
                            <a href="{{ url('/translationDocuments')}}/{{$orders->order_id}}"
                               class="btn text-left" style="width:200px;padding: 20px;"><i class="fa fa-plus"></i>  Translation to cart</a>
                        </div>
                    </div>
			
			 <table class="table table-bordered table-striped">
			<thead>
			  <tr>
				<th>#</th>
				<th>Number of Pages</th>
				<th>Documents</th>
				<th>Fees</th>
				<th>Status</th>
			  </tr>
			</thead>
			<tbody>
			@foreach($transdoc as $index=>$value)
			  <tr>
				<td>{{$index+1}}</td>
				<td>{{$value->page_no}}</td>
				<td>@foreach($value->translation_document as $index2=>$doc)
					Doc-{{$index2+1}}:<a href="{{url('public/img/document_translation')}}/{{$doc->document_file}}" download>Download</a><br>
				@endforeach</td>
				<td>{{$value->total_price}} $</td>
				@if($value->isPayed == 0)
				<td>
				 <a href="{{ url('/selectpayment')}}/{{$value->id}}/false/1" class="btn" style="width:120px;margin-bottom: 0px;padding: 20px;">Pay Now</a>
				</td>
				@else
				<td style="color:green;"><b><i>Paid</i></b></td>
				@endif
			  </tr>
			  @endforeach
			</tbody>
		  </table>
			<br><br>
        </div>
    </div>
@endsection
