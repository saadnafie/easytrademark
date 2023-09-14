@extends('member.layouts.header')

@section('content')
<style>
thead input {
        width: 100%;
    }

	.btn-circle{
	width:40px;
	height:40px;
	border-radius:40px;
	padding:10px;
	float:right;
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
							<h3 class="panel-title"><i class="lnr lnr-layers"></i> Completed Orders List</h3>
							<hr>
						</div>
						<div class="panel-body">

                            <div class="table-responsive">
							<table id="example" class="table table-bordered table-striped" style="width:100%">
								<thead>
									<tr>
										<th>#</th>
                                        <th>TM Label</th>
                                        <th>TM Ref No</th>
										<th>Order Number</th>
										<th>Service</th>
										<th>Country</th>
										<th>Create Date</th>
										<th>Due Date</th>
									</tr>
								</thead>
								<tbody>
								@foreach($allorders as $index=>$value)
									<tr>
										<td>{{$index+1}}</td>
                                        <td>{{$value->trademark_country->trademark->trademark_label}}</td>
                                        <td>{{$value->trademark_country->trademark->trademark_reference}}</td>
										<td>{{$value->order->order_number}}</td>
										<td>{{$value->order->service_package->service->service_name}}</td>
										<td>{{$value->trademark_country->country->country_name}}</td>
										<td>{{$value->order->created_at->toDateString()}}</td>
										<td>{{$value->order->due_date}}
										<a href="{{url('member/single_order_detail')}}/{{$value->id}}" class="btn btn-default btn-circle"><i class="fa fa-eye" aria-hidden="true"></i> </a>
										</td>
									</tr>
								@endforeach
								</tbody>
							</table>
                            </div>
						</div>
					</div>
					<!-- END OVERVIEW -->
				</div>
			</div>
			<!-- END MAIN CONTENT -->
		</div>

			<script>


			$(document).ready(function() {

    // Setup - add a text input to each footer cell
    $('#example thead tr').clone(true).appendTo( '#example thead' );
    $('#example thead tr:eq(1) th').each( function (i) {
        var title = $(this).text();
        (title == '#') ? $(this).html('#') : $(this).html( '<input type="text" placeholder="Search '+title+'" />' );

        $( 'input', this ).on( 'keyup change', function () {
            if ( table.column(i).search() !== this.value ) {
                table
                    .column(i)
                    .search( this.value )
                    .draw();
            }
        } );
    } );

    var table = $('#example').DataTable( {
        orderCellsTop: true,
        fixedHeader: false
    } );




} );

/*$(document).ready(function() {
    var table = $('#example').DataTable( {
        lengthChange: false,
        buttons: [ 'copy', 'excel','colvis' ]
    } );

    table.buttons().container()
        .appendTo( '#example_wrapper .col-sm-6:eq(0)' );
} );*/



/*
// Bootstrap datepicker
$('.input-daterange input').each(function() {
  $(this).datepicker('clearDates');
});

// Set up your table
table = $('#example').DataTable({
  paging: false,
  info: false
});

// Extend dataTables search
$.fn.dataTable.ext.search.push(
  function(settings, data, dataIndex) {
    var min = $('#min-date').val();
    var max = $('#max-date').val();
    var createdAt = data[2] || 0; // Our date column in the table

    if (
      (min == "" || max == "") ||
      (moment(createdAt).isSameOrAfter(min) && moment(createdAt).isSameOrBefore(max))
    ) {
      return true;
    }
    return false;
  }
);

// Re-draw the table when the a date range filter changes
$('.date-range-filter').change(function() {
  table.draw();
});

$('#my-table_filter').hide();
*/

/*$(document).ready(function () {
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

    $('#min').datepicker({ onSelect: function () { table.draw(); }, changeMonth: true, changeYear: true });
    $('#max').datepicker({ onSelect: function () { table.draw(); }, changeMonth: true, changeYear: true });
    var table = $('#example').DataTable();

    // Event listener to the two range filtering inputs to redraw on input
    $('#min, #max').change(function () {
        table.draw();
    });
});*/
</script>

 <!-- <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>-->




		<!-- END MAIN -->
		<div class="clearfix"></div>
	@endsection
