@extends('client.layouts.app')
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
@section('content')
    <div class="profile">
        <div class="container">
            <br><br>
            <div class="head">
                <br><br>
                <h3 class="text-center">TM Labels Orders
                    <hr>
                </h3>
            </div>
            <br><br>
            <div class="my-orders">
                <table class="table" class="text-center">
                    <thead>
                    <br>
                    <tr class="text-center">
                        <th scope="col"> ID</th>
                        <th scope="col">Order No</th>
                        <th scope="col">Country</th>
                        <th scope="col">Service</th>
                        <th scope="col">Created At</th>
                        <th scope="col">Due Date</th>
						<th scope="col" style="width:20%;">TM Status</th>
                        <th scope="col">Order Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($orderDetail as $data)
                        <tr class="text-center">
                            <th scope="row">
                                <a href="{{url('order/details/') .'/'.Illuminate\Support\Facades\Crypt::encryptString($data->id) }}"> {{ $data->id }}  </a>
                            </th>
                            <td>{{$data->order->order_number}}</td>
                            <td>{{$data->trademark_country->country->country_name}}</td>
                            <td>{{$data->order->service_package->service->service_name}}</td>
                            <td>{{$data->order->created_at->toDateString()}}</td>
                            <td>{{$data->order->due_date}}</td>
							<td>{{$data->trademark_response->response_msg}}</td>
                             <td>
                                @if($data->country_order_status == 0)
                                    Received
                                @elseif($data->country_order_status == 1)
                                    Inprocess
                                @elseif($data->country_order_status == 2)
                                    Completed
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <br><br>
                @if ($trademarkDetail->trademark_response_doc->count() > 0 )
                    <table class="table text-center">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Document title</th>
                            <th scope="col">Document file</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($trademarkDetail->trademark_response_doc as $key => $document)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$document->document_title}}</td>
                                <td><a href="{{url('public/response_documents/')}}/{{$document->document_file}}"
                                       download>Download</a></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @endif()
                <br><br><br>
                <div class="container ">
                    <h2>Messages</h2>
                    <div class="media-body">
                        @foreach($comments as $comment)
                            <div class="row">
                                <div
                                    class="media  @if(isset($comment->user->id)) {{ $comment->user->id == auth()->user()->id ? 'float-right' : '' }} @endif">
                                    {{-- check if user is a client (customer) --}}
                                    @if($comment->user->user_type_id == 4)
                                        <img src="{{ asset('public/assets/img/comments/imageclient.png')}}"
                                             alt="Jane Doe"
                                             class="mr-3 mt-3 rounded-circle" style="width:45px;">
                                    @else
                                        <img src="{{ asset('public/assets/img/comments/imagemember.png')}}"
                                             alt="Jane Doe"
                                             class="mr-3 mt-3 rounded-circle" style="width:45px;">
                                    @endif
                                    <div class="media-body">
                                        <h4 style="color: forestgreen">{{$comment->user->user_name}} <small><i>Posted
                                                    on {{$comment->created_at}}</i></small></h4>
                                        <p> {{$comment->comment_detail}} </p>
                                    </div>
                                    @if($comment->user->user_type_id == 4)
                                        <button style="margin-left: 11px;color: red;" type="button"
                                                class="delete-comment close" value="{{$comment->id}}">&times;
                                        </button>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <br>
            <div class="widget-area no-padding blank">
                <div class="status-upload">
                    <form action="{{route('comment.store')}}" method="post">
                        @csrf
                        <input type="hidden" value="{{$trademarkDetail->id}}" name="trademarkId">
                        <input type="hidden" value="{{auth()->user()->id}}" name="userId">
                        <textarea placeholder="your comment" name="comment" class="my_form-control "
                                  style="width: 100%;border: 1px solid #000;padding: 40px" required></textarea><br><br>
                        <button type="submit" class="btn btn-success float-right" style="width: 150px">comment</button>
                    </form>
                </div>
                <br><br>
            </div>
        </div>
        <br><br>
    </div>
    </div>
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('.delete-comment').on('click', function () {
            let token = $("meta[name='csrf-token']").attr("content");
            $.ajax(
                {
                    url: '{{\LaravelLocalization::localizeURL('/deleteComment')}}' + '/' + this.value,
                    dataType: "JSON",
                    type: 'DELETE',
                    data: {
                        '_token': token,
                    },
                    success: function () {
                        location.reload(true);
                    }
                });
        })
    });
</script>
