@extends('admin.layouts.header')

@section('content')
    <script src="{{asset('public/assets_admin/vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('public/assets_admin/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
    <!-- MAIN -->
    <div class="main">
        <!-- MAIN CONTENT -->
        <div class="main-content">
            <div class="container-fluid">
                <!-- OVERVIEW -->
                <div class="panel panel-headline">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="lnr lnr-map"></i> Discounts List</h3>
                        <hr>
                    </div>
                    <div class="panel-body">
                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal"><i
                                class="fa fa-plus" aria-hidden="true"></i> Add Discount
                        </button>
                        <br><br>
                        <!-- Modal -->
                        <div class="modal fade" id="myModal" role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title"> Add New Discount</h4>
                                    </div>
                                    <div class="modal-body">

                                        <form action="{{route('discount.store')}}" method="post">
                                            @csrf

                                            <div class="form-group">
                                                <label for="discount-code"> Discount Code <span
                                                        style="color:red">*</span></label>
                                                <input type="text" class="form-control" id="discount-code"
                                                       name="discount_code" required>
                                            </div>

                                            <div class="form-group">
                                                <label for="discount-amount"> Amount <span
                                                        style="color:red">*</span></label>
                                                <input type="number" class="form-control" id="discount-amount"
                                                       name="discount_amount" required>
                                            </div>

                                            <div class="form-group">
                                                <label for="allowed-num-of-use"> Allowed number of usage <span
                                                        style="color:red">*</span></label>
                                                <input type="number" class="form-control" id="allowed-num-of-use"
                                                       name="allowed_num_of_use" required>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-2 col-form-label">Discount Roles</label>
                                                <div class="checkbox-inline">
                                                    <label class="checkbox">
                                                        <input type="checkbox" id="is-percentage" name="is_percentage" class="is_percentage">
                                                        <span></span> Is percentage amount
                                                    </label>
                                                    <label class="checkbox">
                                                        <input type="checkbox" id="is-date-range" name="is_date_range" class="is_date_range">
                                                        <span></span> Is duration date range
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="start-from" class="col-2 col-form-label">Start from</label>
                                                <input class="form-control" size="16" type="date" id="start-from"
                                                       name="start_from" placeholder="Start from">
                                                <label for="end-at" class="col-2 col-form-label">End at</label>
                                                <input class="form-control" size="16" type="date" id="end-at"
                                                       name="end_at" placeholder="End at">
                                            </div>

                                            <button type="submit" class="btn btn-info"><i class="fa fa-edit"
                                                                                          aria-hidden="true"></i> Add
                                            </button>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Discount Code</th>
                                <th>Amount</th>
                                <th>Allowed num of usage</th>
                                <th>Is Percentage</th>
                                <th>Is Duration Date Range</th>
                                <th>Start at</th>
                                <th>End at</th>
                                <th>Settings</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($discounts as $key => $value)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $value->discount_code }}</td>
                                    <td>{{ $value->discount_amount }}</td>
                                    <td>{{ $value->allowed_num_of_use }}</td>
                                    <td>{{ $value->is_percentage }}</td>
                                    <td>{{ $value->is_date_range }}</td>
                                    <td>{{ $value->start_from }}</td>
                                    <td>{{ $value->end_at }}</td>
                                    <td>
                                        <a href="{{route('discount.show', $value->id)}}" class="btn btn-info"><i
                                                class="fa fa-eye"></i></a>

                                        <a class="btn btn-info" data-toggle="modal"
                                           data-target="#myModal{{$key+1}}"><i class="fa fa-edit"
                                                                               aria-hidden="true"></i></a>
                                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#myModaldelete{{$key+1}}"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                    <!-- Modal -->
                                        <div class="modal fade" id="myModal{{$key+1}}" role="dialog">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal">
                                                            &times;
                                                        </button>
                                                        <h4 class="modal-title"> Edit </h4>
                                                    </div>
                                                    <div class="modal-body">

                                                        <form action="{{ route('discount.update', $value->id) }}" method="post">
                                                            @csrf
                                                            {{ method_field('PUT') }}
{{--                                                            <input type="hidden" value="{{$value->id}}" name="c_id">--}}
                                                            <div class="form-group">
                                                                <label for="discount-code"> Discount Code <span
                                                                        style="color:red">*</span></label>
                                                                <input type="text" class="form-control" id="discount-code"
                                                                       name="discount_code" required value="{{ $value->discount_code }}">
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="discount-amount"> Amount <span
                                                                        style="color:red">*</span></label>
                                                                <input type="number" class="form-control" id="discount-amount"
                                                                       name="discount_amount" required value="{{ $value->discount_amount }}">
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="allowed-num-of-use"> Allowed number of usage <span
                                                                        style="color:red">*</span></label>
                                                                <input type="number" class="form-control" id="allowed-num-of-use"
                                                                       name="allowed_num_of_use" required value="{{ $value->allowed_num_of_use }}">
                                                            </div>

                                                            <div class="form-group">
                                                                <label class="col-2 col-form-label">Discount Roles</label>
                                                                <div class="checkbox-inline">
                                                                    <label class="checkbox">
                                                                        <input type="checkbox" id="is-percentage" name="is_percentage" class="is_percentage"
                                                                            {{ ($value->is_percentage == true) ? 'checked' : ''}}>
                                                                        <span></span> Is percentage amount
                                                                    </label>
                                                                    <label class="checkbox">
                                                                        <input type="checkbox" id="is-date-range" name="is_date_range" class="is_date_range"
                                                                            {{ ($value->is_date_range == true) ? 'checked' : ''}}>
                                                                        <span></span> Is duration date range
                                                                    </label>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="start-from" class="col-2 col-form-label">Start from</label>
                                                                <input class="form-control" size="16" type="date" id="start-from"
                                                                       name="start_from" placeholder="Start from" value="{{ $value->start_from }}">
                                                                <label for="end-at" class="col-2 col-form-label">End at</label>
                                                                <input class="form-control" size="16" type="date" id="end-at"
                                                                       name="end_at" placeholder="End at" value="{{ $value->end_at }}">
                                                            </div>

                                                            <button type="submit" class="btn btn-info"><i class="fa fa-edit"
                                                                                                          aria-hidden="true"></i> Edit
                                                            </button>
                                                        </form>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default"
                                                                data-dismiss="modal">Close
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal fade" id="myModaldelete{{$key+1}}" role="dialog">
                                            <div class="modal-dialog modal-sm">
                                                <div class="modal-content">
                                                    <div class="modal-header" style=" background-color: darkred; color: white; ">
                                                        <button type="button" class="close" data-dismiss="modal" style="color: white;">&times;</button>
                                                        <h4 class="modal-title"> Confirm Delete!</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{ route('discount.destroy', $value->id) }}" method='POST'>
                                                            {{ method_field('DELETE') }}
                                                            @csrf
                                                        <center>
                                                            <img src="{{url('public/img/delete_icon.jpg')}}" width="200px"/><br>
                                                            <button type="submit" class="btn btn-danger">Yes</button>
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                                                        </center>
                                                        </form>
                                                    </div>
                                                    <div class="modal-footer">

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
    <div class="clearfix"></div>
    <script type="text/javascript">
        $(document).ready(function () {
            $('.is_percentage').on('change', function () {
                if($('.is_percentage').is(':checked')) {
                    console.log('erer')
                    $('.is_percentage').attr('value', 1)
                } else {
                    $('.is_percentage').attr('value', 0)
                }
            })

            $('.is_date_range').on('change', function () {
                if($('.is_date_range').is(':checked')) {
                    $('.is_date_range').attr('value', 1)
                } else {
                    $('.is_date_range').attr('value', 0)
                }
            })

            $('#start-from').datepicker({
                minDate: $.now()
            })
        })

    </script>
@endsection
