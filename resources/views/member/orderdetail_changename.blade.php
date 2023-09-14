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
                        <h3 class="panel-title"><i class="lnr lnr-layers"></i>&nbsp;Order Detail</h3>
                        <hr>
                    </div>
                    <div class="panel-body">

                        @if($order->trademark->trademark_image != null)
                            <img src="{{ url('public/img/trademarksImages') }}/{{$order->trademark->trademark_image}}"
                                 width="120px">
                            <br><br>
                        @endif
                        <div class="row">
                            <div class="col-md-6">
                                @if($order->trademark->trademark_word_en != null)
                                    <div class="input-group">
                                        <span class="input-group-addon">English</span>
                                        <input id="email" type="text" class="form-control" name="email"
                                               value="{{$order->trademark->trademark_word_en}}" disabled>
                                    </div>
                                    <br>
                                @endif
                                @if($order->trademark->trademark_word_ar != null)
                                    <div class="input-group">
                                        <span class="input-group-addon">Arabic</span>
                                        <input id="email" type="text" class="form-control" name="email"
                                               value="{{$order->trademark->trademark_word_ar}}" disabled>
                                    </div>
                                    <br>
                                @endif
                                <div class="input-group">
                                    <span class="input-group-addon">Service</span>
                                    <input id="email" type="text" class="form-control" name="email"
                                           value="{{$order->service_package_country->service_package->service->service_name}}"
                                           disabled>
                                </div>
                                <br>
                                <div class="input-group">
                                    <span class="input-group-addon">Package Type</span>
                                    <input id="email" type="text" class="form-control" name="email"
                                           value="{{$order->service_package_country->service_package->package->package}}"
                                           disabled>
                                </div>
                                <br>
                                <div class="input-group">
                                    <span class="input-group-addon">Country</span>
                                    <input id="email" type="text" class="form-control" name="email"
                                           value="{{$order->service_package_country->country->country_name}}" disabled>
                                </div>
                                <br>
                                <div class="input-group">
                                    <span class="input-group-addon">Old Name</span>
                                    <input id="email" type="text" class="form-control" name="email"
                                           value="{{$order_details->tm_name_change->old_name}}" disabled>
                                </div>
                                <br>
                                <div class="input-group">
                                    <span class="input-group-addon">New Name</span>
                                    <input id="email" type="text" class="form-control" name="email"
                                           value="{{$order_details->tm_name_change->new_name}}" disabled>
                                </div>
                                <br>
                                <div class="input-group">
                                    <span class="input-group-addon">Filing Number</span>
                                    <input id="email" type="text" class="form-control" name="email"
                                           value="{{$order_details->trademark_filling->filling_number}}" disabled>
                                </div>
                                <br>
                                <div class="input-group">
                                    <span class="input-group-addon">Filing Date</span>
                                    <input id="email" type="text" class="form-control" name="email"
                                           value="{{$order_details->trademark_filling->filling_date}}" disabled>
                                </div>
                                <br>
                                <div class="input-group">
                                    <span class="input-group-addon">Fast Search</span>
                                    @if($order->isFast == 1)
                                        <input id="email" type="text" class="form-control" name="email" value="Yes"
                                               disabled>
                                    @else
                                        <input id="email" type="text" class="form-control" name="email" value="No"
                                               disabled>
                                    @endif
                                </div>
                                <br><br>
                                <div class="panel panel-default">
                                    <div class="panel-heading"><i class="lnr lnr-layers"></i>&nbsp;Trademark Documents
                                        List
                                    </div>
                                    <div class="panel-body">
                                        <br>
                                        @if($order->trademark_document != '')
                                            @if($order->trademark_document->poa_document != null)
                                                <b>Power of Attorney:</b> <a
                                                    href="{{ url('public/img/documents') }}/{{$order->trademark_document->poa_document}}">POA</a>
                                                &nbsp;&nbsp;
                                                <hr>
                                            @endif
                                            @if($order->trademark_document->tm_certificate != null)
                                                <b>Comercial Certificate:</b> <a
                                                    href="{{ url('public/img/documents') }}/{{$order->trademark_document->tm_certificate}}">Certificate</a>
                                                &nbsp;&nbsp;
                                                <hr>
                                            @endif
                                            @if($order->trademark_document->assign_document != null)
                                                <b>Comercial Certificate Arabic:</b> <a
                                                    href="{{ url('public/img/documents') }}/{{$order->trademark_document->assign_document}}">Assign</a>
                                            @endif
                                        @else
                                            <i>No Documents Available for this trademark!</i>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon">Order Status</span>
                                    @if($order->isPayed == 0)
                                        <input id="email" type="text" class="form-control" name="email" value="In Cart"
                                               disabled>
                                    @else
                                        @if($order->order_status == 0)
                                            <input id="email" type="text" class="form-control" name="email"
                                                   value="Recieved" disabled>
                                        @elseif($order->order_status == 1)
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
                                    <span class="input-group-addon">Response</span>
                                    <input id="email" type="text" class="form-control" name="email"
                                           value="{{$order->response}}" disabled>
                                </div>

                                <hr>
                                @if($order->isPayed == 1)
                                    @if($order->order_status == 0)

                                        <form method="post" action="{{ route('update_order_status') }}">
                                            @csrf
                                            <input type="hidden" name="order_id" value="{{ $order->id }}">
                                            <input type="hidden" name="order_status" value="1">
                                            <input type="submit" class="btn btn-primary" value="Move Order Inprocess"/>

                                            @elseif($order->order_status == 1)

                                                <form method="post" action="{{ route('update_order_status') }}">
                                                    @csrf
                                                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                                                    <input type="hidden" name="order_status" value="2">
                                                    <div class="input-group">
                                                        <label>Update Trademark Response</label>
                                                        <input type="text" name="tm_response" class="form-control"
                                                               required>
                                                    </div>
                                                    <br>
                                                    <input type="submit" class="btn btn-success"
                                                           value="Move Order Completed"/>
                                                </form>

                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END OVERVIEW -->
            </div>
        </div>
        <!-- END MAIN CONTENT -->
    </div>
    <!-- END MAIN -->
    <div class="clearfix"></div>
@endsection
