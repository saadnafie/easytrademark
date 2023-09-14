@extends('member.layouts.header')

@section('content')
    <!-- MAIN -->
    <div class="main">
        <!-- MAIN CONTENT -->
        <div class="main-content">
            <div class="container-fluid">
                <!-- OVERVIEW -->
                <div class="panel panel-headline">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="lnr lnr-layers"></i> Completed Orders List</h3>
                        <hr>
                    </div>
                    <div class="panel-body">

                        <form method="get" action="{{route('completedorder')}}">
                            From: <input type="date" id="min" name="start_date" value="{{$start_date}}">
                            To: <input type="date" id="max" name="end_date" value="{{$end_date}}">
                            <input type="submit" value="filter by date">
                        </form>
                        <hr>

                        <table id="example" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Order Number</th>
                                <th>Service Name</th>
                                <th>Customer Name / Email</th>
                                <th>Created Date</th>
                                <th>Due Date</th>
                                <th>TM Status</th>
                                <th>Details</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($orders as $index=>$value)
                                <tr>
                                    <td>{{$index+1}}</td>
                                    <td>{{$value->order_number}}</td>
                                    <td>{{$value->service_package_country->service_package->service->service_name}}</td>
                                    <td>{{$value->trademark->user->user_name}} <br> {{$value->trademark->user->email}}
                                    </td>
                                    <td>{{$value->created_at->toDateString()}}</td>
                                    <td>{{$value->due_date}}</td>
                                    <td>{{$value->response}}</td>
                                    <td>
                                        <a href="{{url('member/orderdetail')}}/{{$value->id}}" class="btn btn-info"><i
                                                class="fa fa-eye" aria-hidden="true"></i> </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
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
                buttons: ['copy', 'excel', 'pdf', 'colvis']
            });

            table.buttons().container()
                .appendTo('#example_wrapper .col-sm-6:eq(0)');
        });
    </script>
    <div class="clearfix"></div>
@endsection
