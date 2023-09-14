@extends('member.layouts.header')

@section('content')



    <head>
        <style>
            .input-group-addon {
                width: 150px;
            }

            .input-group {
                width: 80%;
            }

            .form-control[disabled], .form-control[readonly], fieldset[disabled] .form-control {
                background-color: #fff;
                opacity: 1;
            }

            .dataTables_info, .pagination, .dataTables_filter {
                display: none;
            }

            .btn-default:hover, .btn-default:focus {
    background-color: #00a0f0; 
}
        </style>
    </head>
    <!-- MAIN -->
    <div class="main">
        <!-- MAIN CONTENT -->
        <div class="main-content">
            <div class="container-fluid">
                <!-- OVERVIEW -->
                <div class="panel panel-headline">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <a href="{{url('member/trademark_history_display')}}/{{$order->trademark_country->trademark->id}}"><i
                                    class="lnr lnr-arrow-left-circle"></i></a>
                            <i class="lnr lnr-layers"></i>&nbsp;Order Detail
                            <a class="btn btn-default" style="float:right;"
                               href="{{url('member/trademark_history_display')}}/{{$order->trademark_country->trademark->id}}"><i
                                    class="fa fa-undo" aria-hidden="true"></i> Back</a>
                        </h3>
                        <hr>
						<a href="{{url('member/trademark_history_display')}}/{{$order->trademark_country->trademark->id}}" class="btn btn-info"><i class="fa fa-cloud-upload" aria-hidden="true"></i> Upload TM Response Documents</a>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table id="example" class="table table-bordered table-striped"
                                       style="width:100%;display:none;">
                                    <thead>
									<td>#</td>
                                    <th>Order Details</th>
                                    <th>Trademark Information</th>
									<td>Arabic Details</td>
                                    </thead>
                                    <tbody>
									<tr><!------1-Label-------->
										<td>1</td>
                                        <td>Label</td>
                                        <td>{{$order->trademark_country->trademark->trademark_label}}</td>
										<td>-</td>
                                    </tr>
									<tr><!------2-Service-------->
										<td>2</td>
                                        <td>Service</td>
                                        <td>{{$order->order->service_package->service->service_name}}</td>
										<td>-</td>
                                    </tr>
									<tr><!------3-Order Status-------->
										<td>3</td>
                                        <td>Order Status</td>
                                        <td>
                                            @if($order->order->isPayed == 0)
                                                In-cart
                                            @else
                                                @if($order->country_order_status == 0)
                                                    Recieved
                                                @elseif($order->country_order_status == 1)
                                                    In Process
                                                @elseif($order->country_order_status == 2)
                                                    Completed
                                                @endif
                                            @endif
                                        </td>
										<td>-</td>
                                    </tr>
									<tr><!------4-Country-------->
										<td>4</td>
										<td>@if($order->order->service_package->service_id == 2) Registration Country @else Country @endif</td>
										<td>{{$order->trademark_country->country->country_name}}</td>
										<td>-</td>
									</tr>
									<tr><!------5-Package Type-------->
										<td>5</td>
                                        <td>Package Type</td>
                                        <td>{{$order->order->service_package->package->package}} {{$order->order->service_package->package->package_type}}</td>
										<td>-</td>
                                    </tr>
									<tr><!------6-Quick Turnaround-------->
										<td>6</td>
                                        <td>@if($order->order->service_package->service_id == 1) Fast Search @else Quick Turnaround @endif</td>
                                        <td>@if($order->trademark_country->isFast == 1) Yes @else No @endif</td>
										<td>-</td>
                                    </tr>
									<tr><!------7-TM Status-------->
										<td>7</td>
                                        <td>TM Status</td>
                                        <td>{{$order->trademark_response->response_msg}}</td>
										<td>-</td>
                                    </tr>
                                    <tr><!------8-TM Reference-------->
										<td>8</td>
                                        <td>TM Reference</td>
                                        <td>{{$order->trademark_country->trademark->trademark_reference}}</td>
										<td>-</td>
                                    </tr>
                                    <!--////////////////////Search/////////////////////////////-->
									@if($order->order->service_package->service_id == 1)
									<tr><!------9-TM Word in En-------->
										<td>9</td>
										<td>TM Word in English</td>
										<td>
										@if($order->trademark_country->trademark->trademark_word_en != null)
										{{$order->trademark_country->trademark->trademark_word_en}}
										@else
											-
										@endif
										</td>
										<td>-</td>
									</tr>
									<tr><!------10-TM Word in Ar-------->
										<td>10</td>
										<td>TM Word in Arabic </td>
										<td>
											@if($order->trademark_country->trademark->trademark_word_ar != null)
											{{$order->trademark_country->trademark->trademark_word_ar}}
											@else
												-
											@endif
										</td>
										<td>-</td>
								    </tr>
									
									<tr>
										<td>11</td>
										<td>Classes</td>
										<td>
											@if(count($order->trademark_country->trademark_country_classes)>0)
											@php $classes = $order->trademark_country->trademark_country_classes[0]->class_id; @endphp
											@for($i=1;$i < count($order->trademark_country->trademark_country_classes);$i++)
												@php $classes = $classes.', '.$order->trademark_country->trademark_country_classes[$i]->class_id; @endphp
											@endfor
											{{$classes}}
											@else
												-
											@endif
										</td>
										<td>-</td>
									</tr>
									@endif
                                    <!--////////////////////Registration/////////////////////////////-->
                                    @if($order->order->service_package->service_id == 2)
										<tr>
											<td>9</td>
                                            <td>Is it has a meaning?</td>
                                            <td>@if($order_detail->trademark_registration->isMeaning == 1) Yes @else No @endif </td>
											<td>-</td>
                                        </tr>
                                        <tr>
											<td>10</td>
                                            <td>Trademark Meaning</td>
                                            <td>
											@if($order_detail->trademark_registration->explanation != '')
											{{$order_detail->trademark_registration->explanation}}
											@else
												-
											@endif
											</td>
											<td>-</td>
                                        </tr>
                                        <tr>
											<td>11</td>
                                            <td>Briefly Describe</td>
                                            <td>{{$order_detail->trademark_registration->brief}}</td>
											<td>-</td>
                                        </tr>
                                        <tr>
											<td>12</td>
											<td>TM Language</td>
											<td>{{$order_detail->trademark_registration->language->language}}</td>
											<td>-</td>
										</tr>
										<tr>
											<td>13</td>
                                            <td>Applicant Name</td>
                                            <td>{{$order_detail->trademark_registration->applicant_name}}</td>
											<td>-</td>
                                        </tr>
										<tr>
											<td>14</td>
                                            <td>Applicant Address</td>
                                            <td>{{$order_detail->trademark_registration->applicant_address}}</td>
											<td>-</td>
                                        </tr>
										<tr>
											<td>15</td>
                                            <td>Applicant Nationality</td>
                                            <td>{{$order_detail->trademark_registration->nationality->nationality}}</td>
											<td>-</td>
                                        </tr>
										<tr>
											<td>16</td>
                                            <td>Applicant Occupation</td>
                                            <td>{{$order_detail->trademark_registration->applicant_occupation->occupation}}</td>
											<td>{{$order_detail->trademark_registration->applicant_occupation->occupation_ar}}</td>
                                        </tr>
										<tr>
											<td>17</td>
                                            <td>Applicant's Type</td>
                                            <td>{{$order_detail->trademark_registration->applicant_type->type}}</td>
											<td>{{$order_detail->trademark_registration->applicant_type->type_ar}}</td>
                                        </tr>
										<tr>
											<td>18</td>
											<td>Applicant's Other Type</td>
											<td>
											@if($order_detail->trademark_registration->other_option_value != null)
											{{$order_detail->trademark_registration->other_option_value}}
											@else
												-
											@endif
											</td>
											<td>-</td>
										</tr>
										<tr>
											<td>19</td>
											<td>Company Type</td>
											@if($order_detail->trademark_registration->applicant_company_type != null)
											<td>{{$order_detail->trademark_registration->applicant_company_type->type}}</td>
											<td>{{$order_detail->trademark_registration->applicant_company_type->type_ar}}</td>
											@else
											<td>-</td>
											<td>-</td>
											@endif
										</tr>
										<tr>
											<td>20</td>
                                            <td>Protect in Color?</td>
                                            <td>@if($order_detail->trademark_registration->isColor == 1) Yes @else No @endif</td>
											<td>-</td>
                                        </tr>
										<tr>
											<td>21</td>
											<td>TM Colors</td>
											@if($order_detail->trademark_registration->isColor == 1)
											<td>
												@php $colors = $order_detail->trademark_color[0]->color->color_name; @endphp
												@php $colors_ar = $order_detail->trademark_color[0]->color->color_name_ar; @endphp
												@for($i=1;$i < count($order_detail->trademark_color);$i++)
													@php
														$colors = $colors.', '.$order_detail->trademark_color[$i]->color->color_name;
														$colors_ar = $colors_ar.', '.$order_detail->trademark_color[$i]->color->color_name_ar;
													@endphp
												@endfor
												{{$colors}}
											</td>
											<td>{{$colors_ar}}</td>
											@else
											<td>-</td>
											<td>-</td>
											@endif
										</tr>
										<tr>
											<td>22</td>
											<td>Classes</td>
											<td>
												@if(count($order->trademark_country->trademark_country_classes)>0)
												@php $classes = $order->trademark_country->trademark_country_classes[0]->class_id; @endphp
												@for($i=1;$i < count($order->trademark_country->trademark_country_classes);$i++)
													@php $classes = $classes.', '.$order->trademark_country->trademark_country_classes[$i]->class_id; @endphp
												@endfor
												{{$classes}}
												@else
													-
												@endif
											</td>
											<td>-</td>
										</tr>
										<tr>
											<td>23</td>
											<td>Goods/Services Desc</td>
											<td>
											@if(count($order->trademark_country->trademark_country_classes)>0)
											{{$order->trademark_country->trademark_country_classes[0]->description}}
											@else
												-
											@endif
											</td>
											<td>-</td>
										</tr>
										{{--<tr>
											<td>26</td>
											<td>Filling Number</td>
											<td>
											@if($order->trademark_country->trademark_filling != '')
											{{$order->trademark_country->trademark_filling->filling_number}}
											@else
												-
											@endif
											</td>
											<td>-</td>
										</tr>
										<tr>
											<td>27</td>
											<td>Filling Date</td>
											<td>
											@if($order->trademark_country->trademark_filling != '')
											{{$order->trademark_country->trademark_filling->filling_date}}
											@else
												-
											@endif
											</td>
											<td>-</td>
										</tr>--}}
										<tr>
											<td>24</td>
                                            <td>Claim convention?</td>
                                            <td>@if($order_detail->trademark_registration->claim_convention == 1) Yes @else No @endif</td>
											<td>-</td>
                                        </tr>
										<tr>
											<td>25</td>
											<td>Claim Filling Number</td>
											<td>
											@if($order_detail->trademark_registration->claim_convention == 1)
											{{$order_detail->trademark_registration->claim_convention_filling->filling_number}}
											@else
												-
											@endif
											</td>
											<td>-</td>
										</tr>
										<tr>
											<td>26</td>
											<td>Claim Filling Date</td>
											<td>
											@if($order_detail->trademark_registration->claim_convention == 1)
											{{$order_detail->trademark_registration->claim_convention_filling->filling_date}}
											@else
												-
											@endif
											</td>
											<td>-</td>
										</tr>
										<tr>
											<td>27</td>
											<td>Claim Country</td>
											@if($order_detail->trademark_registration->claim_convention == 1)
											<td>{{$order_detail->trademark_registration->claim_convention_filling->country->country_en}}</td>
											<td>{{$order_detail->trademark_registration->claim_convention_filling->country->country_ar}}</td>
											@else
											<td>-</td>
											<td>-</td>
											@endif
										</tr>
                                     
										
                                       

										
										
										{{--
                                        <tr>
											<td>-</td>
                                            <td>TM Is Arabic?</td>
                                            <td>
                                                @if($order_detail->trademark_registration->isArabic == 1)
                                                    Yes
                                                @else
                                                    No
                                                @endif
                                            </td>
                                        </tr>
                                        @if($order_detail->trademark_registration->isArabic == 0)
                                            <tr>
                                                <td>TM Language</td>
                                                <td>{{$order_detail->trademark_registration->language->language}}</td>
                                            </tr>
										@else
											<tr><td>TM Language</td><td>-</td></tr>
                                        @endif
										--}}
                                        
                                    @endif
                                    <!--/////////////////////////////////////////////////-->
                                    <!---//////////////////////Assignment Service//////////////////////////////////////////-->
                                    
									@if($order->order->service_package->service_id == 4)
                                        <tr>
											<td>9</td>
                                            <td>Assignor Name</td>
                                            <td>{{$order_detail->trademark_assignment->assignor_name}}</td>
											<td>-</td>
                                        </tr>
                                        <tr>
											<td>10</td>
                                            <td>Assignor Address</td>
                                            <td>{{$order_detail->trademark_assignment->assignor_address}}</td>
											<td>-</td>
                                        </tr>
                                        <tr>
											<td>11</td>
                                            <td>Assignee Name</td>
                                            <td>{{$order_detail->trademark_assignment->assignee_name}}</td>
											<td>-</td>
                                        </tr>
                                        <tr>
											<td>12</td>
                                            <td>Assignee Address</td>
                                            <td>{{$order_detail->trademark_assignment->assignee_address}}</td>
											<td>-</td>
                                        </tr>
										@if($order->trademark_country->trademark_filling != '')
                                            <tr>
												<td>13</td>
                                                <td>Filling Number</td>
                                                <td>{{$order->trademark_country->trademark_filling->filling_number}}</td>
												<td>-</td>
                                            </tr>
                                            <tr>
												<td>14</td>
                                                <td>Filling Date</td>
                                                <td>{{$order->trademark_country->trademark_filling->filling_date}}</td>
												<td>-</td>
                                            </tr>
                                        @endif

                                    @endif

                                    <!---//////////////////////Name Change Service//////////////////////////////////////////-->
                                    @if($order->order->service_package->service_id == 5)
                                        <tr>
											<td>9</td>
                                            <td>Old Name Change</td>
                                            <td>{{$order_detail->tm_name_change->old_name}}</td>
											<td>-</td>
                                        </tr>
                                        <tr>
											<td>10</td>
                                            <td>New Name Change</td>
                                            <td>{{$order_detail->tm_name_change->new_name}}</td>
											<td>-</td>
                                        </tr>
										@if($order->trademark_country->trademark_filling != '')
                                            <tr>
												<td>11</td>
                                                <td>Filling Number</td>
                                                <td>{{$order->trademark_country->trademark_filling->filling_number}}</td>
												<td>-</td>
                                            </tr>
                                            <tr>
												<td>12</td>
                                                <td>Filling Date</td>
                                                <td>{{$order->trademark_country->trademark_filling->filling_date}}</td>
												<td>-</td>
                                            </tr>
                                        @endif
                                    @endif

                                    <!---//////////////////////Address Change Service//////////////////////////////////////////-->
                                    @if($order->order->service_package->service_id == 6)
                                        <tr>
											<td>9</td>
                                            <td>Old Address Change</td>
                                            <td>{{$order_detail->tm_address_change->old_address}}</td>
											<td>-</td>
                                        </tr>
                                        <tr>
											<td>10</td>
                                            <td>New Address Change</td>
                                            <td>{{$order_detail->tm_address_change->new_address}}</td>
											<td>-</td>
                                        </tr>
										@if($order->trademark_country->trademark_filling != '')
                                            <tr>
												<td>11</td>
                                                <td>Filling Number</td>
                                                <td>{{$order->trademark_country->trademark_filling->filling_number}}</td>
												<td>-</td>
                                            </tr>
                                            <tr>
												<td>12</td>
                                                <td>Filling Date</td>
                                                <td>{{$order->trademark_country->trademark_filling->filling_date}}</td>
												<td>-</td>
                                            </tr>
                                        @endif
                                    @endif
									
									
									{{--
                                    @if($order->order->service_package->service_id != 1 )

                                        @if($order->trademark_country->trademark_filling != '')
                                            <tr>
                                                <td>Filling Number</td>
                                                <td>{{$order->trademark_country->trademark_filling->filling_number}}</td>
                                            </tr>
                                            <tr>
                                                <td>Filling Date</td>
                                                <td>{{$order->trademark_country->trademark_filling->filling_date}}</td>
                                            </tr>
                                        @endif
                                    @endif
									--}}

                                    
                                    
									
                                    </tbody>

                                </table>
                            </div>
                        </div>

                        <hr>
                        @if($order->trademark_country->trademark->trademark_image != null)
                            
							<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModalimageview">
										  View TM Image
										</button>
										
                            <a href="{{ url('public/img/trademarksImages') }}/{{$order->trademark_country->trademark->trademark_image}}"
                               class="btn btn-default" download><i class="fa fa-download"></i></a>
							   
							   <!-- Button to Open the Modal -->
										

										<!-- The Modal -->
										<div class="modal" id="myModalimageview">
										  <div class="modal-dialog">
											<div class="modal-content">

											  <!-- Modal Header -->
											  <div class="modal-header">
												<button type="button" class="close" data-dismiss="modal">&times;</button>
											  </div>

											  <!-- Modal body -->
											  <div class="modal-body">
												<center>
												<h4 class="modal-title">Trademark Image</h4><br>
												<img
													src="{{ url('public/img/trademarksImages') }}/{{$order->trademark_country->trademark->trademark_image}}" width="100%">
											  </center>
											  </div>

											</div>
										  </div>
										</div>
                            <br>
                            <br>
                        @endif

                        @if($order->order->service_package->service_id == 2)
                            <div class="panel panel-info">
                                <div class="panel-heading">Registration</div>
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon">TM Reference</span>
                                    <input type="text" class="form-control"
                                           value="{{$order->trademark_country->trademark->trademark_reference}}"
                                           disabled>
                                </div>
                                <br>

                                <div class="input-group">
                                    <span class="input-group-addon">TM Label</span>
                                    <input type="text" class="form-control"
                                           value="{{$order->trademark_country->trademark->trademark_label}}" disabled>
                                </div>
                                <br>

                                @if($order->trademark_country->trademark->trademark_word_en != null)
                                    <div class="input-group">
                                        <span class="input-group-addon">TM English</span>
                                        <input type="text" class="form-control"
                                               value="{{$order->trademark_country->trademark->trademark_word_en}}"
                                               disabled>
                                    </div>
                                    <br>
                                @endif
                                @if($order->trademark_country->trademark->trademark_word_ar != null)
                                    <div class="input-group">
                                        <span class="input-group-addon">TM Arabic</span>
                                        <input type="text" class="form-control"
                                               value="{{$order->trademark_country->trademark->trademark_word_ar}}"
                                               disabled>
                                    </div>
                                    <br>
                                @endif

                                <div class="input-group">
                                    <span class="input-group-addon">Service</span>
                                    <input type="text" class="form-control"
                                           value="{{$order->order->service_package->service->service_name}}" disabled>
                                </div>
                                <br>
                                <div class="input-group">
                                    <span class="input-group-addon">Package Type</span>
                                    <input type="text" class="form-control"
                                           value="{{$order->order->service_package->package->package}} {{$order->order->service_package->package->package_type}}"
                                           disabled>
                                </div>
                                <br>
                                <div class="input-group">
                                    <span class="input-group-addon">Country</span>
                                    <input type="text" class="form-control"
                                           value="{{$order->trademark_country->country->country_name}}" disabled>
                                </div>
                                <br>
                                @if(count($order->trademark_country->trademark_country_classes)>0)
                                    <div class="input-group">
                                        <span class="input-group-addon">Classes</span>
                                        @php $classes = $order->trademark_country->trademark_country_classes[0]->class_id; @endphp
                                        @for($i=1;$i < count($order->trademark_country->trademark_country_classes);$i++)
                                            @php $classes = $classes.', '.$order->trademark_country->trademark_country_classes[$i]->class_id; @endphp
                                        @endfor
                                        <input id="email" type="text" class="form-control" value="{{$classes}}"
                                               disabled>
                                    </div>
                                    <br>
                                @endif
                                <div class="input-group">
                                    @if($order->order->service_package->service_id == 1)
                                        <span class="input-group-addon">Fast Search</span>
                                    @else
                                        <span class="input-group-addon">Quick Turnaround</span>
                                    @endif
                                    @if($order->trademark_country->isFast == 1)
                                        <input id="email" type="text" class="form-control" value="Yes" disabled>
                                    @else
                                        <input id="email" type="text" class="form-control" value="No" disabled>
                                    @endif
                                </div>

                                <!---//////////////////////Registration Service//////////////////////////////////////////-->
                                @if($order->order->service_package->service_id == 2)
                                    <br>
                                    <div class="input-group">
                                        <span class="input-group-addon">Briefly describe</span>
                                        <textarea rows="3" class="form-control"
                                                  disabled>{{$order_detail->trademark_registration->brief}}</textarea>
                                    </div>
                                    <br>
                                    @if($order_detail->trademark_registration->isMeaning != 1)
                                        <div class="input-group">
                                            <span class="input-group-addon">Trademark Meaning</span>
                                            @if($order_detail->trademark_registration->isMeaning == 1)
                                                <input id="email" type="text" class="form-control" value="Yes" disabled>
                                            @else
                                                <input id="email" type="text" class="form-control" value="No" disabled>
                                            @endif
                                        </div>
                                        <br>
                                    @endif
                                    @if($order_detail->trademark_registration->isMeaning == 1)
                                        <div class="input-group">
                                            <span class="input-group-addon">Trademark Meaning</span>
                                            <textarea rows="3" class="form-control"
                                                      disabled>{{$order_detail->trademark_registration->explanation}}</textarea>
                                        </div>
                                        <br>
                                    @endif
                                    {{--<div class="input-group">
                                        <span class="input-group-addon">TM Is Arabic?</span>
                                        @if($order_detail->trademark_registration->isArabic == 1)
                                            <input id="email" type="text" class="form-control" value="Yes" disabled>
                                        @else
                                            <input id="email" type="text" class="form-control" value="No" disabled>
                                        @endif
                                    </div>
                                    @if($order_detail->trademark_registration->isArabic == 0)--}}
                                        
                                        <div class="input-group">
                                            <span class="input-group-addon">TM Language</span>
                                            <input id="email" type="text" class="form-control"
                                                   value="{{$order_detail->trademark_registration->language->language}}"
                                                   disabled>
                                        </div>

                                   {{-- @endif --}}
                                    <br>
                                    <div class="input-group">
                                        <span class="input-group-addon">Protect in Color?</span>
                                        @if($order_detail->trademark_registration->isColor == 1)
                                            <input type="text" class="form-control" value="Yes" disabled>
                                        @else
                                            <input type="text" class="form-control" value="No" disabled>
                                        @endif

                                    </div>
                                    <br>
                                    <div class="input-group">
                                        <span class="input-group-addon">TM Colors</span>
                                        @if($order_detail->trademark_registration->isColor == 1)
                                            @php $colors = $order_detail->trademark_color[0]->color->color_name; @endphp
                                            @php $colors_ar = $order_detail->trademark_color[0]->color->color_name_ar; @endphp
                                            @for($i=1;$i < count($order_detail->trademark_color);$i++)
                                                @php
                                                    $colors = $colors.', '.$order_detail->trademark_color[$i]->color->color_name;
                                                    $colors_ar = $colors_ar.', '.$order_detail->trademark_color[$i]->color->color_name_ar;
                                                @endphp
                                            @endfor
                                            <textarea rows="3" class="form-control" name="email"
                                                      disabled>{{$colors}} - {{$colors_ar}} </textarea>
                                        @else
                                            <input type="text" class="form-control" value="-" disabled>
                                        @endif
                                    </div>

                                    <!--////////////////////////////////Claim Convention Data/////////////////////////////-->
                                    <br><br>
                                    Claiming Convention Priority
                                    <hr>
                                    <div class="input-group">
                                        <span class="input-group-addon">Claim convention?</span>
                                        @if($order_detail->trademark_registration->claim_convention == 1)
                                            <input type="text" class="form-control" value="Yes" disabled>
                                        @else
                                            <input type="text" class="form-control" value="No" disabled>
                                        @endif
                                    </div>
                                    <br>
                                    @if($order_detail->trademark_registration->claim_convention == 1)
                                        <div class="input-group">
                                            <span class="input-group-addon">Filling Number</span>
                                            <input type="text" class="form-control"
                                                   value="{{$order_detail->trademark_registration->claim_convention_filling->filling_number}}"
                                                   disabled>
                                        </div>
                                        <br>
                                        <div class="input-group">
                                            <span class="input-group-addon">Filling Date</span>
                                            <input type="text" class="form-control"
                                                   value="{{$order_detail->trademark_registration->claim_convention_filling->filling_date}}"
                                                   disabled>
                                        </div>
                                        <br>
                                        <div class="input-group">
                                            <span class="input-group-addon">Country</span>
                                            <input type="text" class="form-control"
                                                   value="{{$order_detail->trademark_registration->claim_convention_filling->country->country_en}} - {{$order_detail->trademark_registration->claim_convention_filling->country->country_ar}}"
                                                   disabled>
                                        </div>
                                    @endif
                                    <hr>

                                    <br>
                                    <div class="input-group">
                                        <span class="input-group-addon">Applicant's Type</span>
                                        <input type="text" class="form-control"
                                               value="{{$order_detail->trademark_registration->applicant_type->type}} - {{$order_detail->trademark_registration->applicant_type->type_ar}}"
                                               disabled>
                                    </div>
                                    <br>
									@if($order_detail->trademark_registration->other_option_value != null)
									<div class="input-group">
                                        <span class="input-group-addon">Applicant Other Type</span>
                                        <input type="text" class="form-control"
                                               value="{{$order_detail->trademark_registration->other_option_value}}"
                                               disabled>
                                    </div>
                                    <br>
									@endif
                                    <div class="input-group">
                                        <span class="input-group-addon">Applicant Occupation</span>
                                        <input type="text" class="form-control"
                                               value="{{$order_detail->trademark_registration->applicant_occupation->occupation}} - {{$order_detail->trademark_registration->applicant_occupation->occupation_ar}}"
                                               disabled>
                                    </div>
                                    <br>
                                    @if($order_detail->trademark_registration->applicant_company_type != null)
                                        <div class="input-group">
                                            <span class="input-group-addon">Company Type</span>
                                            <input type="text" class="form-control"
                                                   value="{{$order_detail->trademark_registration->applicant_company_type->type}} - {{$order_detail->trademark_registration->applicant_company_type->type_ar}}"
                                                   disabled>
                                        </div>
                                        <br>
                                    @endif
                                    <div class="input-group">
                                        <span class="input-group-addon">Applicant Name</span>
                                        <input type="text" class="form-control"
                                               value="{{$order_detail->trademark_registration->applicant_name}}"
                                               disabled>
                                    </div>
                                    <br>
                                    <div class="input-group">
                                        <span class="input-group-addon">Applicant Nationality</span>
                                        <input type="text" class="form-control"
                                               value="{{$order_detail->trademark_registration->nationality->nationality}}"
                                               disabled>
                                    </div>
                                    <br>
                                    <div class="input-group">
                                        <span class="input-group-addon">Applicant Address</span>
                                        <textarea rows="3" class="form-control"
                                                  disabled>{{$order_detail->trademark_registration->applicant_address}}</textarea>
                                    </div>
                                    <br>
                                    @if(count($order->trademark_country->trademark_country_classes)>0)
                                        <div class="input-group">
                                            <span class="input-group-addon">Goods/Services Desc</span>
                                            <textarea rows="3" class="form-control"
                                                      disabled>{{$order->trademark_country->trademark_country_classes[0]->description}}</textarea>
                                        </div>
                                    @endif
                                @endif

                            <!---//////////////////////Assignment Service//////////////////////////////////////////-->
                                @if($order->order->service_package->service_id == 4)
                                    <br>
                                    <div class="input-group">
                                        <span class="input-group-addon">Assignor Name</span>
                                        <input type="text" class="form-control"
                                               value="{{$order_detail->trademark_assignment->assignor_name}}" disabled>
                                    </div>
                                    <br>
                                    <div class="input-group">
                                        <span class="input-group-addon">Assignor Address</span>
                                        <input type="text" class="form-control"
                                               value="{{$order_detail->trademark_assignment->assignor_address}}"
                                               disabled>
                                    </div>
                                    <br>
                                    <div class="input-group">
                                        <span class="input-group-addon">Assignee Name</span>
                                        <input type="text" class="form-control"
                                               value="{{$order_detail->trademark_assignment->assignee_name}}" disabled>
                                    </div>
                                    <br>
                                    <div class="input-group">
                                        <span class="input-group-addon">Assignee Address</span>
                                        <input type="text" class="form-control"
                                               value="{{$order_detail->trademark_assignment->assignee_address}}"
                                               disabled>
                                    </div>
                                @endif

                            <!---//////////////////////Name Change Service//////////////////////////////////////////-->
                                @if($order->order->service_package->service_id == 5)
                                    <br>
                                    <div class="input-group">
                                        <span class="input-group-addon">Old Name Change</span>
                                        <input type="text" class="form-control"
                                               value="{{$order_detail->tm_name_change->old_name}}" disabled>
                                    </div>
                                    <br>
                                    <div class="input-group">
                                        <span class="input-group-addon">New Name Change</span>
                                        <input type="text" class="form-control"
                                               value="{{$order_detail->tm_name_change->new_name}}" disabled>
                                    </div>
                                @endif

                            <!---//////////////////////Address Change Service//////////////////////////////////////////-->
                                @if($order->order->service_package->service_id == 6)
                                    <br>
                                    <div class="input-group">
                                        <span class="input-group-addon">Old Address Change</span>
                                        <input type="text" class="form-control"
                                               value="{{$order_detail->tm_address_change->old_address}}" disabled>
                                    </div>
                                    <br>
                                    <div class="input-group">
                                        <span class="input-group-addon">New Address Change</span>
                                        <input type="text" class="form-control"
                                               value="{{$order_detail->tm_address_change->new_address}}" disabled>
                                    </div>
                                @endif
                                <br><br>
                            </div>

                            <!---///////////////col-2////////////////////-->

                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon">Order Status</span>
                                    @if($order->order->isPayed == 0)
                                        <input type="text" class="form-control" value="In Cart" disabled>
                                    @else
                                        @if($order->country_order_status == 0)
                                            <input type="text" class="form-control" value="Recieved" disabled>
                                        @elseif($order->country_order_status == 1)
                                            <input type="text" class="form-control" value="In Process" disabled>
                                        @else
                                            <input type="text" class="form-control" value="Completed" disabled>
                                        @endif
                                    @endif
                                </div>
                                <br>
                                <div class="input-group">
                                    <span class="input-group-addon">TM Status</span>
                                    <textarea rows="3" class="form-control"
                                              disabled>{{$order->trademark_response->response_msg}}</textarea>
                                </div>
                                <hr>
								@if($order->order->isPayed == 1)
                                <form method="post" action="{{ route('update_tm_response') }}">
                                    @csrf
                                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                                    <div class="input-group">
                                        <span class="input-group-addon">Select TM Status</span>
                                        <select class="form-control" name="tm_response_val">
                                            @foreach($tmresponse as $responseval)
                                                <option
                                                    value="{{$responseval->id}}" {{ $order->response_id == $responseval->id ? 'selected' : '' }}>{{$responseval->response_msg}}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                    <br>
                                    <input type="submit" class="btn btn-success" value="Update Trademark Status"/>
                                </form>
								@endif

                                <hr>
                                @if($order->order->isPayed == 1)
                                    @if($order->country_order_status == 0)

							  <form method="post" action="{{ route('update_order_status') }}">
							  @csrf
							  <input type="hidden" name="order_id" value="{{ $order->id }}" >
							  <input type="hidden" name="order_status" value="1" >
							  <input type="submit" class="btn btn-primary" value="Move Order to In process List" />
							  </form>

                              @elseif($order->country_order_status == 1)

							  <form method="post" action="{{ route('update_order_status') }}">
							  @csrf
							  <input type="hidden" name="order_id" value="{{ $order->id }}" >
							  <input type="hidden" name="order_status" value="2" >
							  <br>
							  @if($order->order->service_package->service_id == 2 && $order->trademark_country->trademark_filling != '' && $acceptance_date_val != '')
							  <input type="submit" class="btn btn-primary" value="Move Order to Completed List" />
							  @elseif($order->order->service_package->service_id != 2)
							  	<input type="submit" class="btn btn-primary" value="Move Order to Completed List" />
							  @else
							  <input type="submit" class="btn btn-primary" value="Move Order to Completed List" disabled>
							  <p style="color:red;">
							  	Before you move order to complete, you must set filling number and filling date and set Acceptance Date.
							  </p>
							  @endif
							  </form>
							  @endif
							  @endif





							<br><br>
							<br><br>
							@if($order->order->service_package->service_id != 1 )
								<div class="row">
							<div class="col-md-12">
							<i class="fa fa-sun-o" aria-hidden="true"></i> Filling Data
							<hr>
							@if($order->trademark_country->trademark_filling == '')
							 <form method="post" action="{{route('set_filling_data')}}" >
							  @csrf
							  <input type="hidden" name="tm_ctry_id" value="{{ $order->trademark_country->id }}" >
							 <div class="form-group">
								<label for="email">Filling Number</label>
								<input type="text" class="form-control" name="fill_no" required>
							  </div>

							   <div class="form-group">
								<label for="email">Filling Date</label>
								<input type="date" class="form-control" name="fill_date" required>
							  </div>
							  @if($order->order->isPayed == 1)
							  <input type="submit" class="btn btn-info" value="Set Filling Data" >
							  @endif
							  <hr>
							</form>
							@else
								<br>
							  <div class="input-group">
								<span class="input-group-addon">Filling Number</span>
								<input  type="text" class="form-control" value="{{$order->trademark_country->trademark_filling->filling_number}}" disabled>
							  </div>
							  <br>
							  <div class="input-group">
								<span class="input-group-addon">Filling Date</span>
								<input  type="text" class="form-control"  value="{{$order->trademark_country->trademark_filling->filling_date}}" disabled>
							  </div>
							@endif
							</div>
							</div>
							<br><br>

							<div class="row">
							<div class="col-md-12">
                           <i class="fa fa-calendar" aria-hidden="true"></i> Dates List
							<hr>
							 @foreach($date_list as $value)
							  <div class="input-group">
								<span class="input-group-addon">{{$value->service_date->date_for }}</span>
								<input type="text" class="form-control" name="email" value="{{$value->date }}" disabled>
							  </div>
							  <br>
							  <!--@if($value->service_date->isEditable == 1)
								  <hr>
							  <form method="post" action="">
						      @csrf
							  <input type="hidden" name="date_id" value="{{$value->id}}" >
								  <label>{{$value->service_date->date_for }}</label>
								   <div class="input-group">
								<input type="date" class="form-control" name="date_val" value="{{$value->date }}" >
							  </div>
							  <br>
							  <button type="submit" class="btn btn-info" >Edit Date of Action</button>
							  </form>
							  <hr>
							  @endif-->
							  @endforeach
							  <br>
							@foreach($service_date as $index_date=>$value)
							<form method="post" action="{{ route('set_country_order_dates') }}">
						      @csrf
						      <input type="hidden" name="service_date_id" value="{{$value->id}}" >
							  <input type="hidden" name="tm_ctry_order_id" value="{{$order->id}}" >
							  <label for="email">{{$value->date_for}}</label>
							  @if($value->id == 1)
							  <div class="input-group">
								<input type="date" class="form-control" id="date_validate{{$index_date}}" onchange="TDate({{$index_date}});" name="date_val"  required>
								<div class="input-group-btn">
								  <button type="submit" class="btn btn-info" >Update</button>
								</div>
							  </div>
							  @else
							  <div class="input-group">
								<input type="date" class="form-control" id="date_validate{{$index_date}}"  name="date_val"  required>
								<div class="input-group-btn">
								  <button type="submit" class="btn btn-info" >Update</button>
								</div>
							  </div>
							  @endif
							</form>
							<br>
							@endforeach




							</div>
							</div>

							<br><br>
							<i class="fa fa-clipboard" aria-hidden="true"></i>&nbsp;Trademark Documents List
							   <hr>
							    @if(count($order->trademark_country->trademark_document) > 0)
								@foreach($order->trademark_country->trademark_document as $docs)
											<a href="{{ url('public/img/documents') }}/{{$docs->document_file}}"  download><b>{{$docs->document_title->document_title}}</b> </a>
											<br>
								@endforeach
							    @else
								No documents yet!
							     @endif

                          @endif


							</div>

							</div>

                            <br><br>
							@if($order->order->service_package->service_id == 2)
							<div class="panel panel-info">
							  <div class="panel-heading">Publication</div>
							</div>

                            @if(count($orders_id) > 1)

                                <div class="row">

                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <span class="input-group-addon">Order No</span>
                                            <input type="text" class="form-control" name="email"
                                                   value="{{$orders_id[1]->order->order_number}}" disabled>
                                        </div>
                                        <br>
                                        <div class="input-group">
                                            <span class="input-group-addon">Order Fees</span>
                                            <input type="text" class="form-control" name="email"
                                                   value="{{$orders_id[1]->order->total_fees}} $" disabled>
                                        </div>
                                        <br>
                                        <div class="input-group">
                                            <span class="input-group-addon">Created Date</span>
                                            <input type="text" class="form-control" name="email"
                                                   value="{{$orders_id[1]->order->created_at->toDateString()}}"
                                                   disabled>
                                        </div>
                                        <br>
                                        <div class="input-group">
                                            <span class="input-group-addon">Due Date</span>
                                            <input type="text" class="form-control" name="email"
                                                   value="{{$orders_id[1]->order->due_date}}" disabled>
                                        </div>
                                        <br>
                                        <div class="input-group">
                                            <span class="input-group-addon">Service</span>
                                            <input type="text" class="form-control" name="email"
                                                   value="{{$orders_id[1]->order->service_package->service->service_name}}"
                                                   disabled>
                                        </div>
                                        <br>
                                        <div class="input-group">
                                            <span class="input-group-addon">Package</span>
                                            <input type="text" class="form-control" name="email"
                                                   value="{{$orders_id[1]->order->service_package->package->package}} {{$orders_id[1]->order->service_package->package->package_type}}"
                                                   disabled>
                                        </div>
                                        <br>

                                    </div>

                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <span class="input-group-addon">Order Status</span>
                                            @if($orders_id[1]->order->isPayed == 0)
                                                <input id="email" type="text" class="form-control" name="email"
                                                       value="In Cart" disabled>
                                            @else
                                                @if($orders_id[1]->country_order_status == 0)
                                                    <input id="email" type="text" class="form-control" name="email"
                                                           value="Recieved" disabled>
                                                @elseif($orders_id[1]->country_order_status == 1)
                                                    <input id="email" type="text" class="form-control" name="email"
                                                           value="In Process" disabled>
                                                @else
                                                    <input id="email" type="text" class="form-control" name="email"
                                                           value="Completed" disabled>
                                                @endif
                                            @endif
                                        </div>
                                        <br>
                                        <div class="input-group">
                                            <span class="input-group-addon">TM Status</span>
                                            <textarea rows="3" class="form-control"
                                                      disabled>{{$orders_id[1]->trademark_response->response_msg}}</textarea>
                                        </div>
                                        <hr>
                                        <form method="post" action="{{ route('update_tm_response') }}">
                                            @csrf
                                            <input type="hidden" name="order_id" value="{{ $orders_id[1]->id }}">
                                            <div class="input-group">
                                                <span class="input-group-addon">Select TM Status</span>
                                                <select class="form-control" name="tm_response_val">
                                                    @foreach($tmresponse_publish as $responseval)
                                                        <option
                                                            value="{{$responseval->id}}" {{ $orders_id[1]->response_id == $responseval->id ? 'selected' : '' }}>{{$responseval->response_msg}}</option>
                                                    @endforeach
                                                </select>

                                            </div>
                                            <br>
                                            <input type="submit" class="btn btn-success"
                                                   value="Update Trademark Status"/>
                                        </form>
                                        <br>
                                        <hr>
                                        @if($orders_id[1]->order->isPayed == 1)
                                            @if($orders_id[1]->country_order_status == 0)

							  <form method="post" action="{{ route('update_order_status') }}">
							  @csrf
							  <input type="hidden" name="order_id" value="{{ $orders_id[1]->id }}" >
							  <input type="hidden" name="order_status" value="1" >
							  <input type="submit" class="btn btn-primary" value="Move Order to In process List" />
							</form>
							  @elseif($orders_id[1]->country_order_status == 1)

							  <form method="post" action="{{ route('update_order_status') }}">
							  @csrf
							  <input type="hidden" name="order_id" value="{{ $orders_id[1]->id }}" >
							  <input type="hidden" name="order_status" value="2" >

							  <input type="submit" class="btn btn-primary" value="Move Order to Completed List" />
							  </form>



							  @endif
							  @endif

									</div>

                                    <div class="col-md-6">

                                    </div>

                                </div>

                            @endif
                            <br><br>
                            <div class="panel panel-info">
                                <div class="panel-heading">Final Registration</div>
                            </div>
                            @if(count($orders_id) > 2)

                                <div class="row">

                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <span class="input-group-addon">Order No</span>
                                            <input type="text" class="form-control"
                                                   value="{{$orders_id[2]->order->order_number}}" disabled>
                                        </div>
                                        <br>
                                        <div class="input-group">
                                            <span class="input-group-addon">Order Fees</span>
                                            <input type="text" class="form-control"
                                                   value="{{$orders_id[2]->order->total_fees}} $" disabled>
                                        </div>
                                        <br>
                                        <div class="input-group">
                                            <span class="input-group-addon">Created Date</span>
                                            <input type="text" class="form-control"
                                                   value="{{$orders_id[2]->order->created_at->toDateString()}}"
                                                   disabled>
                                        </div>
                                        <br>
                                        <div class="input-group">
                                            <span class="input-group-addon">Due Date</span>
                                            <input type="text" class="form-control"
                                                   value="{{$orders_id[2]->order->due_date}}" disabled>
                                        </div>
                                        <br>
                                        <div class="input-group">
                                            <span class="input-group-addon">Service</span>
                                            <input type="text" class="form-control"
                                                   value="{{$orders_id[2]->order->service_package->service->service_name}}"
                                                   disabled>
                                        </div>
                                        <br>
                                        <div class="input-group">
                                            <span class="input-group-addon">Package</span>
                                            <input type="text" class="form-control"
                                                   value="{{$orders_id[2]->order->service_package->package->package}} {{$orders_id[1]->order->service_package->package->package_type}}"
                                                   disabled>
                                        </div>
                                        <br>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <span class="input-group-addon">Order Status</span>
                                            @if($orders_id[2]->order->isPayed == 0)
                                                <input type="text" class="form-control" value="In Cart" disabled>
                                            @else
                                                @if($orders_id[2]->country_order_status == 0)
                                                    <input type="text" class="form-control" value="Recieved" disabled>
                                                @elseif($orders_id[2]->country_order_status == 1)
                                                    <input type="text" class="form-control" value="In Process" disabled>
                                                @else
                                                    <input type="text" class="form-control" value="Completed" disabled>
                                                @endif
                                            @endif
                                        </div>
                                        <br>
                                        <div class="input-group">
                                            <span class="input-group-addon">TM Status</span>
                                            <textarea rows="3" class="form-control"
                                                      disabled>{{$orders_id[2]->trademark_response->response_msg}}</textarea>
                                        </div>
                                        <hr>
                                        <form method="post" action="{{ route('update_tm_response') }}">
                                            @csrf
                                            <input type="hidden" name="order_id" value="{{ $orders_id[2]->id }}">
                                            <div class="input-group">
                                                <span class="input-group-addon">Select TM Status</span>
                                                <select class="form-control" name="tm_response_val">
                                                    @foreach($tmresponse_fregister as $responseval)
                                                        <option
                                                            value="{{$responseval->id}}" {{ $orders_id[2]->response_id == $responseval->id ? 'selected' : '' }}>{{$responseval->response_msg}}</option>
                                                    @endforeach
                                                </select>

                                            </div>
                                            <br>
                                            <input type="submit" class="btn btn-success"
                                                   value="Update Trademark Status"/>
                                        </form>
                                        <br>
                                        <hr>
                                        @if($orders_id[2]->order->isPayed == 1)
                                            @if($orders_id[2]->country_order_status == 0)

                                                <form method="post" action="{{ route('update_order_status') }}">
                                                    @csrf
                                                    <input type="hidden" name="order_id"
                                                           value="{{ $orders_id[2]->id }}">
                                                    <input type="hidden" name="order_status" value="1">
                                                    <input type="submit" class="btn btn-primary"
                                                           value="Move Order to In process List"/>

                                                    @elseif($orders_id[2]->country_order_status == 1)

                                                        <form method="post" action="{{ route('update_order_status') }}">
                                                            @csrf
                                                            <input type="hidden" name="order_id"
                                                                   value="{{ $orders_id[2]->id }}">
                                                            <input type="hidden" name="order_status" value="2">
                                                            <input type="submit" class="btn btn-primary"
                                                                   value="Move Order to Completed List"/>
                                                        </form>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            @endif
                        @endif
                        <br><br>

                    </div><!-- END Panel Body -->
                </div>
                <!-- END OVERVIEW -->
            </div>
        </div>
        <!-- END MAIN CONTENT -->
    </div>
    <!-- END MAIN -->
    <script>
        $(document).ready(function () {


            var table = $('#example').DataTable({
                lengthChange: false,
                 "dom": 'Btri',
			    "searching": false,
			    "paging": false,
			    "info": false,
                buttons: [{
		        extend: 'excelHtml5',
		        className: 'btn btn-primary',
		        text: 'Export Excel File',
		        autoFilter: true,
		        attr: {id: 'exportButton'},
		        sheetName: 'data',
		        title: 'Trademark Details',
		        filename: '{{$order->trademark_country->trademark->trademark_label}}-{{$order->trademark_country->trademark->trademark_reference}}'
    }]
            });

            table.buttons().container()
                .appendTo('#example_wrapper .col-sm-6:eq(0)');
        });

//-------------------------------filling date validation-----------------------------------
		function dateValidation(p) {
        var b = document.getElementById("date_validate"+p).value; //your input date here
         /*var b1 = new Date(b);
		 console.log(b1);
		 var dd1 = b1.getDate()+1;
		 var mm1 = b1.getMonth()+1;
		 var yyyy1 = b1.getFullYear();
		 b1 = yyyy1+'-'+mm1+'-'+dd1;*/

		console.log(b);
		//var dd1 = b.getDate();
		//var mm1 = b.getMonth()+1; 
		//var yyyy1 = b.getFullYear();
		//d = yyyy1+'-'+mm1+'-'+dd1;
		//console.log(b);
		
        var d = new Date(); // today date
        console.log(d);
		var dd = d.getDate();
		var mm = d.getMonth()+1; 
		var yyyy = d.getFullYear();
		d = yyyy+'-'+mm+'-'+dd;
		
		console.log(d);




        if (b <= d) {

        } else {
            alert("Date should not be older than Today.");
			document.getElementById("date_validate"+p).value = '';
        }
    }

function TDate(p) {
    var UserDate = document.getElementById("date_validate"+p).value;
    var ToDate = new Date();

console.log(new Date(UserDate).getTime());
console.log(ToDate.getTime());

    if (new Date(UserDate).getTime() >= ToDate.getTime()) {
          
          alert("The Date must be less or Equal to today date");
          document.getElementById("date_validate"+p).value = '';
          return false;
     }
    return true;
}
    </script>

    <div class="clearfix"></div>
@endsection
