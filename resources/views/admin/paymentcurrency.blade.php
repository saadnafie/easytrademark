@extends('admin.layouts.header')

@section('content')
    <!-- MAIN -->
    <div class="main">
        <!-- MAIN CONTENT -->
        <div class="main-content">
            <div class="container-fluid">
                <!-- OVERVIEW -->
                <div class="panel panel-headline">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="fa fa-money" aria-hidden="true"></i> Payment Currencies</h3>
                        <hr>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Currency Name</th>
                                            <th>Code</th>
                                            <th>Symbol</th>
                                            <th>Description</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($paycurrencies as $index=>$value)
                                            <tr>
                                                <td>{{$index+1}}</td>
                                                <td>{{$value->currency_name}}</td>
                                                <td>{{$value->currency_code}}</td>
                                                <td>{{$value->currency_symbol}}</td>
                                                <td>{{$value->currency_desc}}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
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

