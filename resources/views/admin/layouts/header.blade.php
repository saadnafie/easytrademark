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
	<!--<link rel="stylesheet" href="{{asset('public/assets_admin/vendor/chartist/css/chartist-custom.css')}}">-->
	<!-- MAIN CSS -->
	<link rel="stylesheet" href="{{asset('public/assets_admin/css/main.css')}}">
	<!-- FOR DEMO PURPOSES ONLY. You should remove this in your project -->
	<link rel="stylesheet" href="{{asset('public/assets_admin/css/demo.css')}}">
	<!-- GOOGLE FONTS -->
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
	<!-- ICONS -->
	<link rel="apple-touch-icon" sizes="76x76" href="{{asset('public/assets_admin/img/apple-icon.png')}}">
	<link rel="icon" type="image/png" sizes="96x96" href="{{asset('public/assets_admin/img/favicon.png')}}">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" >

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
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src="{{asset('public/assets_admin/img/apple-icon.png')}}" class="img-circle" alt="Avatar"> <span>Alyafi IP Group</span> <i class="icon-submenu lnr lnr-chevron-down"></i></a>
							<ul class="dropdown-menu">
								<li><a href="{{url('adminpanel/dashboard')}}"><i class="lnr lnr-user"></i> <span>My Profile</span></a></li>
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
						<li><a href="{{url('adminpanel/dashboard')}}" class="{{ (request()->is('adminpanel/dashboard')) ? 'active' : '' }}{{ (request()->is('home')) ? 'active' : '' }}"><i class="lnr lnr-home"></i> <span>Dashboard</span></a></li>
						<li><a href="{{url('adminpanel/clients')}}" class="{{ (request()->is('adminpanel/clients')) ? 'active' : '' }}"><i class="lnr lnr-user"></i> <span>Clients</span></a></li>
						<li><a href="{{url('adminpanel/members')}}" class="{{ (request()->is('adminpanel/members')) ? 'active' : '' }}"><i class="lnr lnr-users"></i> <span>Memebers</span></a></li>
						<li><a href="{{url('adminpanel/services')}}" class="{{ (request()->is('adminpanel/services')) ? 'active' : '' }}"><i class="lnr lnr-layers"></i> <span>Services</span></a></li>
						<li><a href="{{url('adminpanel/countries')}}" class="{{ (request()->is('adminpanel/countries')) ? 'active' : '' }}"><i class="lnr lnr-map"></i> <span>Countries</span></a></li>
						<li><a href="{{url('adminpanel/packages')}}" class="{{ (request()->is('adminpanel/packages')) ? 'active' : '' }}"><i class="lnr lnr-dice"></i> <span>Packages</span></a></li>
						<!--<li><a href="{{url('adminpanel/packagesfees')}}" class="{{ (request()->is('adminpanel/packagesfees')) ? 'active' : '' }}"><i class="lnr lnr-pie-chart"></i> <span>Packages Fees</span></a></li>-->
						<li><a href="{{url('adminpanel/classes')}}" class="{{ (request()->is('adminpanel/classes')) ? 'active' : '' }}"><i class="fa fa-diamond" aria-hidden="true"></i> <span>Classes</span></a></li>
						<li><a href="{{url('adminpanel/countryreqdocs')}}" class="{{ (request()->is('adminpanel/countryreqdocs')) ? 'active' : '' }}"><i class="fa fa-files-o" aria-hidden="true"></i> <span>Country Require Docs</span></a></li>
						<li><a href="{{url('adminpanel/trademarkresponse')}}" class="{{ (request()->is('adminpanel/trademarkresponse')) ? 'active' : '' }}"><i class="fa fa-commenting-o" aria-hidden="true"></i> <span>Trademark Response</span></a></li>
						<li><a href="{{url('adminpanel/rssfeed')}}" class="{{ (request()->is('adminpanel/rssfeed')) ? 'active' : '' }}"><i class="fa fa-rss" aria-hidden="true"></i> <span>RSS Feeds</span></a></li>
						<li><a href="{{url('adminpanel/paymentcurrency')}}" class="{{ (request()->is('adminpanel/paymentcurrency')) ? 'active' : '' }}"><i class="fa fa-money" aria-hidden="true"></i> <span>Payment Currencies</span></a></li>
						<li><a href="{{route('discount.index')}}" class="{{ (request()->is('discount')) ? 'active' : '' }}"><i class="fa fa-percent" aria-hidden="true"></i> <span>Discounts</span></a></li>

						<li>
							<a href="#subPages2" data-toggle="collapse" class="collapsed"><i class="lnr lnr-file-empty"></i> <span>Resource Center</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
							<div id="subPages2" class="collapse ">
								<ul class="nav">
									<li><a href="{{url('adminpanel/community')}}" class="">Community</a></li>
									<li><a href="{{url('adminpanel/article')}}" class="">Blogs</a></li>
									<li><a href="{{url('adminpanel/userguide')}}" class="">User Guide</a></li>
									<li><a href="{{url('adminpanel/FAQs')}}" class="">FAQs</a></li>
									<li><a href="{{url('adminpanel/doctemplate')}}" class="">Documents Templates</a></li>
								</ul>
							</div>
						</li>
						<li>
							<a href="#subPages1" data-toggle="collapse" class="collapsed"><i class="lnr lnr-file-empty"></i> <span>Applicants Info</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
							<div id="subPages1" class="collapse ">
								<ul class="nav">
									<li><a href="{{url('adminpanel/companies')}}" class="{{ (request()->is('adminpanel/companies')) ? 'active' : '' }}"><span>Companies Type</span></a></li>
									<li><a href="{{url('adminpanel/applicants')}}" class="{{ (request()->is('adminpanel/applicants')) ? 'active' : '' }}"><span>Applicants Type</span></a></li>
									<li><a href="{{url('adminpanel/occupation')}}" class="{{ (request()->is('adminpanel/occupation')) ? 'active' : '' }}"><span>Applicants Occupation</span></a></li>


								</ul>
							</div>
						</li>

				       <li>
							<a href="#subPages3" data-toggle="collapse" class="collapsed"><i class="lnr lnr-file-empty"></i> <span>Trademark Info</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
							<div id="subPages3" class="collapse ">
								<ul class="nav">
									<li><a href="#" class=""><span>Color</span></a></li>
									<li><a href="#" class=""><span>Languages</span></a></li>
									<li><a href="#" class=""><span>Claim Countries</span></a></li>


								</ul>
							</div>
						</li>
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


		 <footer>
			<div class="container-fluid">
				<p class="copyright">&copy; 2020 easytrademarks. All Rights Reserved.</p>
			</div>
		</footer>
	</div>
	<!-- END WRAPPER -->
	<!-- Javascript -->
	<script src="{{asset('public/assets_admin/vendor/jquery/jquery.min.js')}}"></script>
	<script src="{{asset('public/assets_admin/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
	<script src="{{asset('public/assets_admin/vendor/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>
	<script src="{{asset('public/assets_admin/vendor/jquery.easy-pie-chart/jquery.easypiechart.min.js')}}"></script>
	<!--<script src="{{asset('public/assets_admin/vendor/chartist/js/chartist.min.js')}}"></script>-->
	<script src="{{asset('public/assets_admin/scripts/klorofil-common.js')}}"></script>
	<script>
	$(function() {
		var data, options;

		// headline charts
		data = {
			labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
			series: [
				[23, 29, 24, 40, 25, 24, 35],
				[14, 25, 18, 34, 29, 38, 44],
			]
		};

		options = {
			height: 300,
			showArea: true,
			showLine: false,
			showPoint: false,
			fullWidth: true,
			axisX: {
				showGrid: false
			},
			lineSmooth: false,
		};

		new Chartist.Line('#headline-chart', data, options);


		// visits trend charts
		data = {
			labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
			series: [{
				name: 'series-real',
				data: [200, 380, 350, 320, 410, 450, 570, 400, 555, 620, 750, 900],
			}, {
				name: 'series-projection',
				data: [240, 350, 360, 380, 400, 450, 480, 523, 555, 600, 700, 800],
			}]
		};

		options = {
			fullWidth: true,
			lineSmooth: false,
			height: "270px",
			low: 0,
			high: 'auto',
			series: {
				'series-projection': {
					showArea: true,
					showPoint: false,
					showLine: false
				},
			},
			axisX: {
				showGrid: false,

			},
			axisY: {
				showGrid: false,
				onlyInteger: true,
				offset: 0,
			},
			chartPadding: {
				left: 20,
				right: 20
			}
		};

		new Chartist.Line('#visits-trends-chart', data, options);


		// visits chart
		data = {
			labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
			series: [
				[6384, 6342, 5437, 2764, 3958, 5068, 7654]
			]
		};

		options = {
			height: 300,
			axisX: {
				showGrid: false
			},
		};

		new Chartist.Bar('#visits-chart', data, options);


		// real-time pie chart
		var sysLoad = $('#system-load').easyPieChart({
			size: 130,
			barColor: function(percent) {
				return "rgb(" + Math.round(200 * percent / 100) + ", " + Math.round(200 * (1.1 - percent / 100)) + ", 0)";
			},
			trackColor: 'rgba(245, 245, 245, 0.8)',
			scaleColor: false,
			lineWidth: 5,
			lineCap: "square",
			animate: 800
		});

		var updateInterval = 3000; // in milliseconds

		setInterval(function() {
			var randomVal;
			randomVal = getRandomInt(0, 100);

			sysLoad.data('easyPieChart').update(randomVal);
			sysLoad.find('.percent').text(randomVal);
		}, updateInterval);

		function getRandomInt(min, max) {
			return Math.floor(Math.random() * (max - min + 1)) + min;
		}

	});
	</script>
</body>

</html>
