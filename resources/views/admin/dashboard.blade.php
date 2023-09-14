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
                        <h3 class="panel-title">Dashboard Overview</h3>
                        <hr>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="metric">
                                    <span class="icon"><i class="fa fa-users"></i></span>
                                    <p>
                                        <span class="number">{{$customers}}</span>
                                        <span class="title">Customers</span>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="metric">
                                    <span class="icon"><i class="fa fa-shopping-cart"></i></span>
                                    <p>
                                        <span class="number">{{$orders}}</span>
                                        <span class="title">Orders</span>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="metric">
                                    <span class="icon"><i class="fa fa-list"></i></span>
                                    <p>
                                        <span class="number">{{$services}}</span>
                                        <span class="title">Services</span>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="metric">
                                    <span class="icon"><i class="fa fa-map"></i></span>
                                    <p>
                                        <span class="number">{{$countries}}</span>
                                        <span class="title">Countries</span>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="metric">
                                    <span class="icon"><i class="fa fa-users"></i></span>
                                    <p>
                                        <span class="number">{{$members}}</span>
                                        <span class="title">Members</span>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="metric">
                                    <span class="icon"><i class="lnr lnr-dice"></i></span>
                                    <p>
                                        <span class="number">{{$packages}}</span>
                                        <span class="title">Packages</span>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="metric">
                                    <span class="icon"><i class="lnr lnr-linearicons"></i></span>
                                    <p>
                                        <span class="number">{{$classes}}</span>
                                        <span class="title">Classes</span>
                                    </p>
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
