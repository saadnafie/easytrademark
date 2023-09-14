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
                        <h3 class="panel-title"><i class="lnr lnr-layers"></i> Received Orders List</h3>
                        <hr>
                    </div>
                    <div class="panel-body">

                        <form method="get" action="{{route('recievedorder')}}">
                            From: <input type="date" id="min" name="start_date" value="{{$start_date}}">
                            To: <input type="date" id="max" name="end_date" value="{{$end_date}}">
                            <input type="submit" value="filter by date">
                        </form>

                        <hr>
                        <table id="example" class="table table-bordered table-striped" style="width:100%">
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

    <script>
        $(document).ready(function () {
            var table = $('#example').DataTable({
                lengthChange: false,
                buttons: ['copy', 'excel', 'pdf', 'colvis']
            });

            table.buttons().container()
                .appendTo('#example_wrapper .col-sm-6:eq(0)');
        });

        $(document).ready(function () {
            $.fn.dataTable.ext.search.push(
                function (settings, data, dataIndex) {
                    var min = $('#min').datepicker('getDate');
                    var max = $('#max').datepicker('getDate');
                    var startDate = new Date(data[4]);
                    if (min == null && max == null) return true;
                    if (min == null && startDate <= max) return true;
                    if (max == null && startDate >= min) return true;
                    if (startDate <= max && startDate >= min) return true;
                    return false;
                }
            );

            $('#min').datepicker({
                onSelect: function () {
                    table.draw();
                }, changeMonth: true, changeYear: true
            });
            $('#max').datepicker({
                onSelect: function () {
                    table.draw();
                }, changeMonth: true, changeYear: true
            });
            var table = $('#example').DataTable();

            // Event listener to the two range filtering inputs to redraw on input
            $('#min, #max').change(function () {
                table.draw();
            });
        });
    </script>

    <!-- END MAIN -->
    <div class="clearfix"></div>
@endsection
