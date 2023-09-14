<!doctype html>
<html lang="en">

<head>
	<title>easytrademarks</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<!-- VENDOR CSS -->
	<link rel="stylesheet" href="{{asset('public/assets_admin/vendor/bootstrap/css/bootstrap.min.css')}}">
	<link rel="stylesheet" href="{{asset('public/assets_admin/vendor/font-awesome/css/font-awesome.min.css')}}">
	<link rel="stylesheet" href="{{asset('public/assets_admin/vendor/linearicons/style.css')}}">
	<link rel="stylesheet" href="{{asset('public/assets_admin/vendor/chartist/css/chartist-custom.css')}}">
	<!-- MAIN CSS -->
	<link rel="stylesheet" href="{{asset('public/assets_admin/css/main.css')}}">
	<!-- FOR DEMO PURPOSES ONLY. You should remove this in your project -->
	<link rel="stylesheet" href="{{asset('public/assets_admin/css/demo.css')}}">
	<!-- GOOGLE FONTS -->
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
	<!-- ICONS -->
	<link rel="apple-touch-icon" sizes="76x76" href="{{asset('public/assets_admin/img/apple-icon.png')}}">
	<link rel="icon" type="image/png" sizes="96x96" href="{{asset('public/assets_admin/img/favicon.png')}}">
	 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<!--<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" >-->
	 <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">-->

  <!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>-->

<!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">-->

<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.2/css/buttons.bootstrap.min.css">
<meta name="viewport" content="width=device-width, initial-scale=1">


	@if (session('success'))
    <script>
        new Noty({
            type: 'info',
            layout: 'topCenter',
            text: "{{ session('success') }}",
            timeout: 4000,
            killer: true
        }).show();
    </script>

@endif

</head>

<body>
	<!-- WRAPPER -->
	<div id="wrapper">
		<!-- NAVBAR -->
		<nav class="navbar navbar-default navbar-fixed-top">
			<div class="brand">
				<a href="{{url('/')}}" target="_blank"><span style="color:#0011FF;">easy</span>trademarks</a>
			</div>
			<div class="container-fluid">
				<div class="navbar-btn">
					<button type="button" class="btn-toggle-fullwidth"><i class="lnr lnr-arrow-left-circle"></i></button>
				</div>
				<!--<form class="navbar-form navbar-left">
					<div class="input-group">
						<input type="text" value="" class="form-control" placeholder="Search dashboard...">
						<span class="input-group-btn"><button type="button" class="btn btn-primary">Go</button></span>
					</div>
				</form>-->
				<div id="navbar-menu">
					<ul class="nav navbar-nav navbar-right">
						<li class="dropdown">
							<a href="#" class="dropdown-toggle icon-menu" data-toggle="dropdown">
								<i class="lnr lnr-alarm"></i>
								<span class="badge bg-danger">5</span>
							</a>
							<ul class="dropdown-menu notifications">
								<li><a href="#" class="notification-item"><span class="dot bg-warning"></span>System space is almost full</a></li>
								<li><a href="#" class="notification-item"><span class="dot bg-danger"></span>You have 9 unfinished tasks</a></li>
								<li><a href="#" class="notification-item"><span class="dot bg-success"></span>Monthly report is available</a></li>
								<li><a href="#" class="notification-item"><span class="dot bg-warning"></span>Weekly meeting in 1 hour</a></li>
								<li><a href="#" class="notification-item"><span class="dot bg-success"></span>Your request has been approved</a></li>
								<li><a href="#" class="more">See all notifications</a></li>
							</ul>
						</li>
						<!--<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="lnr lnr-question-circle"></i> <span>Help</span> <i class="icon-submenu lnr lnr-chevron-down"></i></a>
							<ul class="dropdown-menu">
								<li><a href="#">Basic Use</a></li>
								<li><a href="#">Working With Data</a></li>
								<li><a href="#">Security</a></li>
								<li><a href="#">Troubleshooting</a></li>
							</ul>
						</li>-->
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src="{{asset('public/assets_admin/img/icon_user.png')}}" class="img-circle" alt="Avatar"> <span>{{auth()->user()->user_name}}</span> <i class="icon-submenu lnr lnr-chevron-down"></i></a>
							<ul class="dropdown-menu">
								<li><a href="{{url('member/mprofile')}}"><i class="lnr lnr-user"></i> <span>My Profile</span></a></li>
								<!--<li><a href="#"><i class="lnr lnr-envelope"></i> <span>Message</span></a></li>
								<li><a href="#"><i class="lnr lnr-cog"></i> <span>Settings</span></a></li>-->
								<li><a href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"><i class="lnr lnr-exit"></i> <span>Logout</span></a></li>
							</ul>
						</li>
						<!-- <li>
							<a class="update-pro" href="https://www.themeineed.com/downloads/klorofil-pro-bootstrap-admin-dashboard-template/?utm_source=klorofil&utm_medium=template&utm_campaign=KlorofilPro" title="Upgrade to Pro" target="_blank"><i class="fa fa-rocket"></i> <span>UPGRADE TO PRO</span></a>
						</li> -->
					</ul>
				</div>
			</div>
		</nav>
		<!-- END NAVBAR -->
		<!-- LEFT SIDEBAR -->
		<div id="sidebar-nav" class="sidebar">
			<div class="sidebar-scroll">
				<nav>
					<ul class="nav">
						<li><a href="{{url('member/mprofile')}}" class="{{ (request()->is('en/member/mprofile')) ? 'active' : '' }}{{ (request()->is('home')) ? 'active' : '' }}"><i class="lnr lnr-home"></i> <span>Profile</span></a></li>
						<li><a href="{{url('member/trademarkscms')}}" class="{{ (request()->is('en/member/trademarkscms')) ? 'active' : '' }}"><i class="fa fa-trademark" aria-hidden="true"></i> <span>Trademarks List</span></a></li>
						<li><a href="{{url('member/orderscms')}}" class="{{ (request()->is('en/member/orderscms')) ? 'active' : '' }}"><i class="lnr lnr-layers"></i> <span>Current Orders</span></a></li>
						<li><a href="{{url('member/unpaidordercms')}}" class="{{ (request()->is('en/member/unpaidordercms')) ? 'active' : '' }}"><i class="fa fa-chain-broken" aria-hidden="true"></i> <span>Unpaid Orders</span></a></li>
						<li><a href="{{url('member/completedorderscms')}}" class="{{ (request()->is('en/member/completedorderscms')) ? 'active' : '' }}"><i class="fa fa-check"></i> <span>Completed Orders</span></a></li>
						<li><a href="{{url('member/clientreminder')}}" class="{{ (request()->is('en/member/clientreminder')) ? 'active' : '' }}"><i class="fa fa-bell"></i> <span>Clients Email Reminder</span></a></li>

						<!--
						<li><a href="{{url('member/unpaidorder')}}" class="{{ (request()->is('member/unpaidorder')) ? 'active' : '' }}"><i class="lnr lnr-layers"></i> <span>Unpaid Orders</span></a></li>
						<li><a href="{{url('member/recievedorder')}}" class="{{ (request()->is('member/recievedorder')) ? 'active' : '' }}"><i class="lnr lnr-layers"></i> <span>Recieved Orders</span></a></li>
						<li><a href="{{url('member/progressorder')}}" class="{{ (request()->is('member/progressorder')) ? 'active' : '' }}"><i class="lnr lnr-layers"></i> <span>Inprocess Orders</span></a></li>
						<li><a href="{{url('member/completedorder')}}" class="{{ (request()->is('member/completedorder')) ? 'active' : '' }}"><i class="lnr lnr-layers"></i> <span>Completed Orders</span></a></li>
                         -->

						<li><a href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
						<i class="lnr lnr-exit"></i> <span>Logout</span></a>
						<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
							@csrf
						</form>
						</li>
					</ul>
				</nav>
			</div>
		</div>
		<!-- END LEFT SIDEBAR -->

		 @yield('content')


		 <!--<footer>
			<div class="container-fluid">
				<p class="copyright">&copy; 2020 easytrademarks. All Rights Reserved.</p>
			</div>
		</footer>-->
	</div>
	<!-- END WRAPPER -->
	<!-- Javascript -->
<!--	<script src="{{asset('public/assets_admin/vendor/jquery/jquery.min.js')}}"></script>-->

	<script src="{{asset('public/assets_admin/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
	<script src="{{asset('public/assets_admin/vendor/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>
	<!--<script src="{{asset('public/assets_admin/vendor/jquery.easy-pie-chart/jquery.easypiechart.min.js')}}"></script>
	<script src="{{asset('public/assets_admin/vendor/chartist/js/chartist.min.js')}}"></script>-->
	<script src="{{asset('public/assets_admin/scripts/klorofil-common.js')}}"></script>
	<!--<script src="https://code.jquery.com/jquery-3.5.1.js"></script>-->
  <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
  <!--<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>-->
   <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
	 <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.bootstrap.min.js"></script>
	  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
	   <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
	    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
		 <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
		  <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.print.min.js"></script>
		   <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.colVis.min.js"></script>


<script src="https://cdn.datatables.net/fixedheader/3.1.7/js/dataTables.fixedHeader.min.js"></script>

</body>

</html>
