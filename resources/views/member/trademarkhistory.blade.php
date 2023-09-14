@extends('member.layouts.header')

@section('content')
    <style>
        footer {
            display: none;
        }

        .btn-circle {
            width: 50px;
            height: 50px;
            border-radius: 50px;
            padding: 15px;
        }

        .input-group-addon {
            width: 150px;
        }

        .input-group {
            width: 100%;
        }

        .form-control[disabled], .form-control[readonly], fieldset[disabled] .form-control {
            background-color: #fff;
            opacity: 1;
        }
    </style>
    <!-- MAIN -->
    <div class="main">
        <!-- MAIN CONTENT -->
        <div class="main-content">
            <div class="container-fluid">
                <!-- OVERVIEW -->


                <div class="panel panel-headline">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="fa fa-trademark" aria-hidden="true"></i> | Trademark History
                        </h3>
                    </div>
                    <div class="panel-body">

                        <div class="row">

                            <div class="col-md-6">
                                <table class="table table-striped">
                                    <tbody>
                                    <th><i class="fa fa-paperclip" aria-hidden="true"></i> <i class="fa fa-trademark"
                                                                                              aria-hidden="true"></i>
                                        Reference No<br>{{$tmark_detail->trademark_reference}}</th>
                                    </tbody>
                                </table>

                                <table class="table table-striped">
                                    <tbody>
                                    <th><i class="fa fa-tag" aria-hidden="true"></i> <i class="fa fa-trademark"
                                                                                        aria-hidden="true"></i>
                                        Label<br>{{$tmark_detail->trademark_label}}</th>
                                    </tbody>
                                </table>


                                <table class="table table-striped">
                                    <tbody>
                                    <th><i class="fa fa-calendar" aria-hidden="true"></i> <i class="fa fa-trademark"
                                                                                             aria-hidden="true"></i>
                                        Created Date<br>{{$tmark_detail->created_at->toDateString()}}</th>
                                    </tbody>
                                </table>

                                <table class="table table-striped">
                                    <tbody>
                                    <th><i class="fa fa-user" aria-hidden="true"></i> <i class="fa fa-trademark"
                                                                                         aria-hidden="true"></i>
                                        Representative<br>
                                        @if($tmark_detail->representative != null)
                                            {{$tmark_detail->representative->user_name}}
                                        @endif
                                    </th>
                                    </tbody>
                                </table>

                                <div class="panel panel-headline">
                                    <div class="panel-body">
                                        <form method="post" action="{{route('update_tm_representative')}}">
                                            @csrf
                                            <input type="hidden" name="tm_id" value="{{$tmark_detail->id}}">
                                            <label for="sel1">Trademark Representative:</label>
                                            <select class="form-control" name="tm_member_rep">
                                                @foreach($tm_representative as $value)
                                                    <option value="{{$value->id}}" 
                                                        @if($tmark_detail->representative != null)
                                                        {{ ($tmark_detail->representative->id == $value->id)? 'selected':'' }} @endif>{{$value->user_name}}</option>
                                                @endforeach
                                            </select>
                                            <br>
                                            <button type="submit" class="btn btn-primary" style="width:150px;">Assign
                                                Trademark
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-----//////////////////////user Info////////////////////////////////////////-->

                            <div class="col-md-6">
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <table>
                                            <tr>
                                                <td>
                                                    <center>
                                                        <img src="{{url('public/img/user_professional_icon.png') }}"
                                                             width="120px"><br>
                                                        {{$tmark_detail->user->user_code}}
                                                    </center>
                                                </td>
                                                <td>
                                                    <i class="fa fa-user"
                                                       aria-hidden="true"></i> {{$tmark_detail->user->user_name}}
                                                    <hr>
                                                    <i class="fa fa-envelope-o"
                                                       aria-hidden="true"></i> {{$tmark_detail->user->email}}
                                                    <hr>
                                                    <i class="fa fa-phone"
                                                       aria-hidden="true"></i> {{$tmark_detail->user->phone}}<br>
                                                </td>
                                            </tr>
                                        </table>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-md-4">
                                <br><br>
                                <i class="fa fa-map-o" aria-hidden="true"></i> Country List
                                <hr>

                                <ul class="nav nav-pills nav-stacked">
                                    @foreach($order_detail as $index=>$detail)
                                        <li class="{{ ($index == 0) ? 'active' : '' }}">
                                            <a data-toggle="pill" href="#details{{$index+1}}">
                                                <button type="button" class="btn btn-primary"
                                                        style="width:200px;">{{$detail->trademark_country->country->country_name}}</button>
                                                <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
                                                @foreach($detail->trademark_country->trademark_country_classes as $class_detail)
                                                    <span class="badge">{{$class_detail->class_id}}</span>
                                                @endforeach
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="col-md-2"></div>
                            <div class="col-md-6">
                                <br><br><br>

                                <div class="tab-content">
                                    @foreach($order_detail as $index=>$detail)

                                        <div id="details{{$index+1}}"
                                             class="tab-pane fade  {{ ($index == 0) ? 'in active' : '' }}">
                                            <div class="panel panel-default">
                                                <div class="panel-body">
                                                    Details:
                                                    <hr>
                                                    <div class="input-group">
                                                        <span class="input-group-addon">TM Reference</span>
                                                        <input id="email" type="text" class="form-control" name="email"
                                                               value="{{$tmark_detail->trademark_reference}}" disabled>
                                                    </div>
                                                    <br>
                                                    <div class="input-group">
                                                        <span class="input-group-addon">Label</span>
                                                        <input id="email" type="text" class="form-control" name="email"
                                                               value="{{$tmark_detail->trademark_label}}" disabled>
                                                    </div>
                                                    <br>
                                                    @if($detail->order->service_package->service_id ==2)
                                                        <div class="input-group">
                                                            <span class="input-group-addon">Applicant Name</span>
                                                            <input id="email" type="text" class="form-control"
                                                                   name="email"
                                                                   value="{{$tmark_detail->user->user_name}}" disabled>
                                                        </div>
                                                        <br>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">Applicant Address</span>
                                                            <input id="email" type="text" class="form-control"
                                                                   name="email" value="{{$tmark_detail->user->email}}"
                                                                   disabled>
                                                        </div>
                                                        <br>
                                                    @endif
                                                    <div class="input-group">
                                                        <span class="input-group-addon">TM Rep</span>
                                                        <input id="email" type="text" class="form-control" name="email"
                                                               value="@if($tmark_detail->representative != null) {{$tmark_detail->representative->user_name}} @endif"
                                                               disabled>
                                                    </div>
                                                    <br>
                                                    <div class="input-group">
                                                        <span class="input-group-addon">Service</span>
                                                        <input id="email" type="text" class="form-control" name="email"
                                                               value="{{$detail->order->service_package->service->service_name}}"
                                                               disabled>
                                                    </div>
                                                    <br>
                                                    <div class="input-group">
                                                        <span class="input-group-addon">Country</span>
                                                        <input id="email" type="text" class="form-control" name="email"
                                                               value="{{$detail->trademark_country->country->country_name}}"
                                                               disabled>
                                                    </div>
                                                    <br>
                                                    @if($detail->trademark_country->trademark_filling != null)
                                                        <div class="input-group">
                                                            <span class="input-group-addon">Filling Number</span>
                                                            <input id="email" type="text" class="form-control"
                                                                   name="email"
                                                                   value="{{$detail->trademark_country->trademark_filling->filling_number}}"
                                                                   disabled>
                                                        </div>
                                                        <br>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">Filling Date</span>
                                                            <input id="email" type="text" class="form-control"
                                                                   name="email"
                                                                   value="{{$detail->trademark_country->trademark_filling->filling_date}}"
                                                                   disabled>
                                                        </div>
                                                    @endif
                                                    <br><br>
                                                    <i class="fa fa-calendar" aria-hidden="true"></i> Dates:
                                                    <hr>
                                                    @foreach($detail->trademark_ctry_order_date as $dates)
                                                        <div class="input-group">
                                                            <span
                                                                class="input-group-addon">{{$dates->service_date->date_for}}</span>
                                                            <input id="email" type="text" class="form-control"
                                                                   name="email" value="{{$dates->date}}" disabled>
                                                        </div>
                                                        <br>
                                                    @endforeach

                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

			   


					<div class="row">
					<div class="col-md-12">
					<br><br>
					<i class="fa fa-list" aria-hidden="true"></i> Orders List
					<hr>
					<div class="table-responsive">
				<table class="table table-striped">
				<tbody>

					@foreach($order_detail as $orderdetail)


					@if($orderdetail->order->service_package->service_id != 7)
					@if($orderdetail->order->service_package->service_id != 8)
					<tr>
					</td>
					<td style="text-align:center;vertical-align: middle;">
					<img src="{{url('public/img/order_icon.png') }}" width="40px"><br>{{$orderdetail->order->order_number}}
					</td>
					<td style="vertical-align: middle;">
					<span class="badge"><i class="fa fa-trademark" aria-hidden="true"></i></span> {{$orderdetail->order->service_package->service->service_name}}<br>
					<i class="fa fa-long-arrow-right" aria-hidden="true"></i> {{$orderdetail->trademark_country->country->country_name}}
					</td>
					<td style="vertical-align: middle;">
					<i class="fa fa-calendar" aria-hidden="true"></i> {{$orderdetail->order->created_at->toDateString()}}
					<br><img src="{{url('public/img/arrow_curve.png') }}" width="20px">
                    <i class="fa fa-calendar" aria-hidden="true"></i> {{$orderdetail->order->due_date}}
					</td>
					<td style="vertical-align: middle;">
					<i class="fa fa-money" aria-hidden="true" style="font-size:30px;"></i><br>
                    {{$orderdetail->order->total_fees}} $
					</td>
					<td style="vertical-align: middle;">
					@if($orderdetail->country_order_status == 0)
					<span class="label label-primary">Recieved</span>
				    @elseif($orderdetail->country_order_status == 1)
				    <span class="label label-info">In process</span>
				    @elseif($orderdetail->country_order_status == 2)
					<span class="label label-success">Completed</span>
					@endif
					</td>
					<td style="vertical-align: middle;">
					<a href="{{url('member/single_order_detail')}}/{{$orderdetail->id}}" class="btn btn-default btn-circle"><i class="fa fa-eye" aria-hidden="true"></i></a>
					</td>
					</tr>
					@endif
					@endif

			        @endforeach



				</tbody>
			  </table>
					</div>



</div>
</div>


 <!-- Left-aligned media object -->
  <!--<div class="media">
    <div class="media-left">
      <img src="{{url('public/img/img_avatar1.png')}}" class="media-object" style="width:60px">
    </div>
    <div class="media-body">
       <h4 class="media-heading">John Doe <small><i>Posted on February 19, 2020</i></small></h4>
      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
    </div>
  </div>
  <hr>
  <div class="media">
    <div class="media-left">
      <img src="{{url('public/img/img_avatar1.png')}}" class="media-object" style="width:60px">
    </div>
    <div class="media-body">
       <h4 class="media-heading">John Doe <small><i>Posted on February 19, 2020</i></small></h4>
      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
    </div>
  </div>
  <hr>
  <div class="media">
    <div class="media-left">
      <img src="{{url('public/img/img_avatar1.png')}}" class="media-object" style="width:60px">
    </div>
    <div class="media-body">
       <h4 class="media-heading">John Doe <small><i>Posted on February 19, 2020</i></small></h4>
      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
    </div>
  </div>
  <hr>-->
    	<div class="row">
					<div class="col-md-12">
<br><br>
<i class="fa fa-globe" aria-hidden="true"></i> Translation Documents List
<hr>
<div class="table-responsive">
<table class="table table-striped">
<thead>
<tr>
<th>Order No</th>
<!--<th>Document No</th>-->
<th>Page No</th>
<th>Payment Status</th>
<!--<th>Notes</th>-->
<th>Documents</th>
</tr>
</thead>

                                    <tbody>

  @foreach($translationdocs as $orders)
  <tr>
  <td>{{$orders->order->order_number}}</td>
	  {{--<td>{{$orders->document_no}}</td>--}}
  <td>{{$orders->page_no}}</td>
  <td>
  	@if($orders->isPayed == 0)
    <b style="color:red;">Not paid</b>
  	@elseif($orders->isPayed == 1)
    <b style="color:green;">Paid</b>
  	@endif
  </td>
  {{--<td>{{$orders->notes}}</td>--}}
  <td>
  @foreach($orders->translation_document as $docs)
  <a href="{{url('public/img/document_translation')}}/{{$docs->document_file}}" download>Download</a>
  @endforeach
  </td>
  </tr>
  @endforeach
  </tbody>
</table>
</div>
  </div>
  </div>

<div class="row">
	<div class="col-md-12">

        <br><br>
<i class="fa fa-clipboard" aria-hidden="true"></i> Documents List
<hr>



  <div class="row">
					<div class="col-md-6">

                        <div class="panel panel-default">
  <div class="panel-body">

    <form  action="{{route('add_tm_response_doc')}}" method="post" enctype="multipart/form-data">
     @csrf

        <input type="hidden" value="{{$tmark_detail->id}}"  name="tm_id" required>
		 <input type="hidden" value="{{$tmark_detail->user->email}}" name="customer_email">
<div class="form-group">
    <label for="service">Document Title<span style="color:red">*</span></label>
    <input type="text" class="form-control" id="doc_title" name="doc_title" required>
</div>


<div class="form-group">
    <label for="service">Document File<span style="color:red">*</span></label>
    <input type="file" class="form-control" id="doc_file" name="doc_file" accept=".pdf,.doc,.docx" required>
</div>

  <button type="submit" class="btn btn-info"> Save Documnet</button>
  </form>

     </div>
      </div>

         </div>
      </div>

      <br><br>
<i class="fa fa-files-o" aria-hidden="true"></i> TM Response Documents
<hr>
<div class="table-responsive">
<table class="table table-striped">
<thead>
<tr>
<th>#</th>
<th>Document title</th>
<th>Document file</th>
<th>Settings</th>
</tr>
</thead>

                                    <tbody>

  @foreach($tmark_detail->trademark_response_doc as $index=>$resdocs)
  <tr>
      <td>{{$index+1}}</td>
  <td>{{$resdocs->document_title}}</td>
  <td><a href="{{url('public/response_documents/')}}/{{$resdocs->document_file}}" download>Download</a></td>
  <td>
 <a href="{{url('member/delete_tm_response_doc')}}/{{$resdocs->id}}" class="btn btn-danger" ><i class="fa fa-trash" aria-hidden="true"></i></a>
  </td>
  </tr>
  @endforeach
  </tbody>
</table>
    </div>
    </div>
      </div>

  	<div class="row">
					<div class="col-md-12">
<br><br>
<i class="fa fa-comments-o" aria-hidden="true"></i> Comments
<hr>

                                <div class="panel panel-default">
                                    <div class="panel-body">

                                    @foreach($tm_comments as $comments)
                                        @if($comments->user_id == auth()->user()->id || $comments->user->user_type_id == 3)
                                            <!-- Left-aligned -->
                                                <div class="media"
                                                     style="background: aliceblue;border-radius: 40px;padding: 10px;width: 85%;display: inline-block;">
                                                    <div class="media-left">
                                                        <img src="{{url('public/img/img_avatar2.png')}}"
                                                             class="media-object img-circle" style="width:60px">
                                                    </div>
                                                    <div class="media-body">
                                                        <h4 class="media-heading">{{ $comments->user->user_name }}
                                                            <small><i> {{$comments->created_at }}</i></small></h4>
                                                        <p>{{$comments->comment_detail }}</p>
                                                    </div>
                                                </div>
                                        @else
                                            <!-- Right-aligned -->
                                                <div class="media"
                                                     style="background: gainsboro;border-radius: 40px;width: 85%;float: right;padding: 6px;display: inline-block;">
                                                    <div class="media-body" style="text-align:right;">
                                                        <h4 class="media-heading"><small><i>{{$comments->created_at }}
                                                                    &nbsp;</i></small> {{ $comments->user->user_name }}
                                                        </h4>
                                                        <p>{{$comments->comment_detail }}</p>
                                                    </div>
                                                    <div class="media-right">
                                                        <img src="{{url('public/img/img_avatar3.png')}}"
                                                             class="media-object img-circle" style="width:60px">
                                                    </div>
                                                </div>
                                            @endif
                                            <br>
                                        @endforeach

</div>
<hr>
<div style="padding: 0px 30px">
<form method="POST" action="{{ route('add_tm_comment') }}">
@csrf
<input type="hidden" value="{{$tmark_detail->id}}" name="tm_id">
<input type="hidden" value="{{auth()->user()->id}}" name="user_id">
 <input type="hidden" value="{{$tmark_detail->user->email}}" name="customer_email">
 <div class="input-group">
    <textarea rows="2" class="form-control" name="tm_comment" required></textarea>
    <div class="input-group-btn">
      <button class="btn btn-success" type="submit" style=" height: 55px; ">
        <i class="glyphicon glyphicon-send"></i>
      </button>
    </div>
  </div>
</form>
</div>
<br><br>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END OVERVIEW -->
        </div>
    </div>
    <!-- END MAIN CONTENT -->
    <!-- END MAIN -->
    <div class="clearfix"></div>
@endsection
