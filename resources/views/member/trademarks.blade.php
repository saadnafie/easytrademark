@extends('member.layouts.header')

@section('content')
    <style>
        thead input {
            width: 100%;
        }

        .btn-circle {
            width: 40px;
            height: 40px;
            border-radius: 40px;
            padding: 10px;
            float: right;
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
                        <h3 class="panel-title"><i class="lnr lnr-layers"></i> Trademark List</h3>
                        <hr>
                    </div>
                    <div class="panel-body">

                        <form method="get" action="{{route('trademarkscms')}}">
                            From: <input type="date" id="min" name="start_date" value="{{$start_date}}">
                            To: <input type="date" id="max" name="end_date" value="{{$end_date}}">
                            <input type="submit" value="filter by date">
                        </form>

                        <hr>
                        <table id="example" class="table table-bordered table-striped" style="width:100%">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>TM Reference</th>
                                <th>TM Label</th>
                                <th>Client Name</th>
                                <th>Client Email</th>
                                <th>Created Date</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($tmarks as $index=>$value)
                                <tr>
                                    <td>{{$index+1}}</td>
                                    <td>{{$value->trademark_reference}}</td>
                                    <td>{{$value->trademark_label}}</td>
                                    <td>{{$value->user->user_name}}</td>
                                    <td>{{$value->user->email}}</td>
                                    <td>{{$value->created_at->toDateString()}}
                                        <a href="{{url('member/trademark_history_display')}}/{{$value->id}}"
                                           class="btn btn-default btn-circle"><i class="fa fa-eye"
                                                                                 aria-hidden="true"></i> </a>
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
            // Setup - add a text input to each footer cell
            $('#example thead tr').clone(true).appendTo('#example thead');
            $('#example thead tr:eq(1) th').each(function (i) {
                var title = $(this).text();
                (title == '#') ? $(this).html('#') : $(this).html('<input type="text" placeholder="Search ' + title + '" />');

                $('input', this).on('keyup change', function () {
                    if (table.column(i).search() !== this.value) {
                        table
                            .column(i)
                            .search(this.value)
                            .draw();
                    }
                });
            });

            var table = $('#example').DataTable({
                orderCellsTop: true,
                fixedHeader: false
            });
        });
    </script>

    <!-- END MAIN -->
    <div class="clearfix"></div>
@endsection
