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
                        <h3 class="panel-title">Member Profile</h3>
                        <hr>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="metric">
                                    <center><img src="{{url('public/img/icon_user.png')}}" class="img-circle"
                                                 width="160px"/>
                                        <hr>
                                        {{auth()->user()->user_name}}
                                        <hr>
                                        {{auth()->user()->email}}
                                        <hr>
                                        {{auth()->user()->phone}}
                                    </center>
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

