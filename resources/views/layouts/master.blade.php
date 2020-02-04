<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="keywords" content="">
	<meta name="description" content="">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="author" content="">
	<link rel="icon" type="image/png" sizes="16x16" href="../plugins/images/favicon.png">
	<title>{{ $title }}</title>
	<!-- ===== Bootstrap CSS ===== -->
	<link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
	<link href="{{asset('css/components.min.css') }} " rel="stylesheet">
	<!--Toastr -->
	<link href="{{asset('css/toastr.css') }}" rel="stylesheet">
	<!-- ===== Plugin CSS ===== -->
	<link href="{{ asset('css/chartist.min.css') }}" rel="stylesheet">
	<link href="{{asset('css/chartist-plugin-tooltip.css') }}" rel="stylesheet">
	<!-- ===== Animation CSS ===== -->
	<link href="{{ asset('css/animate.css') }} " rel="stylesheet">
	<!-- ===== Custom CSS ===== -->
	<link href="{{ asset('css/style.css') }}" rel="stylesheet">
	<!-- ===== Color CSS ===== -->
	<link href="{{ asset('css/colors/red.css') }}" id="theme" rel="stylesheet">
	<link href="{{ asset('css/protip.css') }} " rel="stylesheet">
	<!-- =====Sweet Alert Css ==== -->
	<link href="{{ asset('css/sweetalert.css') }} " rel="stylesheet">
	<link href="{{asset('css/custom.css')}}" rel="stylesheet">
	<link href="{{asset('css/nprogress.css')}}" rel="stylesheet">
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
	@yield('pagestyles')

	<!-- Pusher Application -->
	<!--Begin Pusher Plugin -->
	<!--  <script src="https://js.pusher.com/4.1/pusher.min.js"></script>-->
	<script>
		var app_url = "{{config('app.url')}}/";
     window.Laravel = '{{csrf_field()}}';
    /* window.Token = document.head.querySelector('meta[name="csrf-token"]').content;
// Enable pusher logging - don't include this in production
Pusher.logToConsole = true;
var pusher = new Pusher('a6b246a297fca110d65d', {
cluster: 'us2',
encrypted: true,
authEndpoint: app_url+'pusher/auth',
auth: {
      headers: {
        'X-CSRF-Token': window.Token
      }
    }
});
var channel = pusher.subscribe('private-my-channel');
channel.bind('my-event', function(data) {
alert(data.message);
}); 
console.log(app_url+'pusher/auth');
**/
	</script>

	<!--end pusher plugin -->

</head>

<body class="mini-sidebar" id="mySalesForceApp" data-ng-app="myApp">
	<!-- ===== Main-Wrapper ===== -->
	<div id="wrapper">
		{{-- <div style="background:rgba(1,1,1,0.7) !important;" class="preloader">
			<div class="cssload-speeding-wheel"></div>
		</div> --}}
		
		<!-- Top-Navigation -->
		<nav class="navbar navbar-default navbar-static-top m-b-0">
			<div class="navbar-header">
				<a class="navbar-toggle font-20 hidden-sm hidden-md hidden-lg " href="javascript:void(0)" data-toggle="collapse" data-target=".navbar-collapse">
					<i class="fa fa-bars"></i>
				</a>
				<div class="top-left-part">
					<!--<a class="logo" href="{{route('dashboard.index')}}">
                        <b>
                            <img src="{{ asset('images/logo.png') }}" alt="home" />
                        </b>
                        <span>
                            <img src="{{ asset('images/logo-text.png') }}" alt="homepage" class="dark-logo" />
                        </span>
                    </a>-->
				</div>
				<ul class="nav navbar-top-links navbar-left hidden-xs">
					<li>
						<a href="javascript:void(0)" class="sidebartoggler font-20 waves-effect waves-light">
							<i class="icon-arrow-left-circle"></i>
						</a>
					</li>
					<li>
						<form role="search" class="app-search hidden-xs">
							<i class="icon-magnifier"></i>
							<input type="text" placeholder="Search..." class="form-control">
						</form>
					</li>
				</ul>
				<ul class="nav navbar-top-links navbar-right pull-right">
					{{-- Display User Role --}}
					<li class="dropdown visible-lg">
						<a id="create-account-link" style="cursor:text;" class="dropdown-toggle waves-effect waves-light font-20 protip disabled"
						 href="javascript:void(0);" disabled>
							<i class="icon-user"></i>
							@if(null !==Auth::user())
							<span>Role: {{ Auth::user()->roles()->pluck('name')[0] }}</span>
							@else
							<span>Role: Unknown</span>
							@endif

						</a>
					</li>
					<!--Create account Link -->
					{{-- Perform blade protection --}} @role('HR')
					<li class="dropdown visible-lg">
						<a id="create-account-link" class="dropdown-toggle waves-effect waves-light font-20 protip" data-pt-trigger="hover" data-pt-animate="bounceIn"
						 data-pt-title="Create accounts such as ROD, ZBM, ASM, MD" href="{{ route('users.create') }}">
							<i class="icon-people"></i>
							Create Account
						</a>
					</li>
					@else @endrole


					<!--End Create account link -->
					<li class="dropdown" data-ng-controller="MasterNotificationController">
						<a class="dropdown-toggle waves-effect waves-light font-20" data-toggle="dropdown" href="javascript:void(0);">
							<i class="icon-speech"></i>
							<span class="badge badge-xs badge-danger" data-ng-if="newMessagesCount!=0">@{{newMessagesCount}}</span>
						</a>
						<ul class="dropdown-menu mailbox animated bounceInDown">
							<li>
								<div class="drop-title" data-ng-if="newMessagesCount>0">You have @{{newMessagesCount}} new messages</div>
								<div class="drop-title" data-ng-if="newMessagesCount==0">You have no new message</div>
							</li>
							<li>
								<div class="message-center">
									<!-- display unread messages in notification -->
									<a data-ng-repeat="unread in unreadInbox" href="{{config('app.url')}}/inbox/@{{unread.id}}">
										<div class="user-img">
											<img src="{{asset('storage')}}/@{{unread.sender_profile.profile_picture}}" alt="user" class="img-circle">
											<span class="profile-status offline pull-right"></span>
										</div>
										<div class="mail-contnet">
											<h5>@{{unread.sender_profile.first_name}} @{{unread.sender_profile.last_name}}</h5>
											<span class="mail-desc">@{{unread.message}}</span>
											<span class="time">@{{unread.timeline}}</span>
										</div>
									</a>

								</div>
							</li>
							<li>
								<a class="text-center" href="{{route('inbox.index')}}">
									<strong>See all messages</strong>
									<i class="fa fa-angle-right"></i>
								</a>
							</li>
						</ul>
					</li>
					<li class="dropdown" data-ng-controller="MasterNotificationController">
						<a class="dropdown-toggle waves-effect waves-light font-20" data-toggle="dropdown" href="javascript:void(0);">
							<i class="icon-calender"></i>
							<span class="badge badge-xs badge-danger">@{{taskNotificationCount}}</span>
						</a>
						<ul class="dropdown-menu dropdown-tasks animated slideInUp">
															<!-- display pending role movement attestation -->
							<li data-ng-repeat="attest in pendingAttestation">
								<div class="message-center">
									<a href="{{URL::to('role/movement/profile')}}/@{{attest.id}}">
										<div class="user-img">
											<img src="{{asset('storage')}}/@{{attest.requester_profile.profile_picture}}" alt="resource pic" class="img-circle">
											<span class="profile-status offline pull-right"></span>
										</div>
										<div class="mail-contnet">
											<h5>Role Movement Attestation</h5>
											<span class="mail-desc">@{{attest.requester_profile.first_name}} 
											@{{attest.requester_profile.last_name}}
											 From @{{attest.resource_role.name}}
											 To @{{attest.destination_role.name}}
											 </span>
											<span class="time">@{{attest.timeline}}</span>
										</div>
									</a>

								</div>
							</li>
							<li data-ng-repeat="attest in pendingMovementAttestation">
									<div class="message-center">
										<a href="{{URL::to('location/movement/profile')}}/@{{attest.id}}">
											<div class="user-img">
												<img src="{{asset('storage')}}/@{{attest.requester_profile.profile_picture}}" alt="resource pic" class="img-circle">
												<span class="profile-status offline pull-right"></span>
											</div>
											<div class="mail-contnet">
												<h5>Movement Attestation</h5>
												<span class="mail-desc">
												For
													@{{attest.requester_profile.first_name}} 
												@{{attest.requester_profile.last_name}}
												 </span>
												<span class="time">@{{attest.timeline}}</span>
											</div>
										</a>
	
									</div>
								</li>
							<li class="divider"></li>
							<li>
                                <div class="message-center">
                                    <a data-ng-repeat="target in uncompletedTargets" href="{{route('targets.index')}}#assignedTargets">
                                        <div class="user-img">
                                            <img src="{{asset('storage')}}/@{{target.target.owner_profile.profile_picture}}" alt="user" class="img-circle">
                                            <span class="profile-status online pull-right"></span>
                                        </div>
                                        <div class="mail-contnet">
                                            <h5>Target: @{{target.target.tag}}</h5>
                                            <span class="mail-desc">Gross Ads:@{{target.gross_ads}} | Decrement:@{{target.decrement}} | Kit:@{{target.kit}}</span>
                                            <span class="time">@{{target.timeline}}</span>
                                        </div>
                                    </a>
									</div>
							</li>
						</ul>
					</li>
					<li class="dropdown">
						<a id="create-account-link" class="dropdown-toggle waves-effect waves-light font-20 protip tst3" data-pt-trigger="hover"
						 data-pt-animate="bounceIn" data-pt-title="Sign Out" href="{{ route('user/logout') }}">
							<i class="fa fa-power-off"></i>
						</a>
					</li>
					<li class="right-side-toggle">
						<a class="right-side-toggler waves-effect waves-light b-r-0 font-20" href="javascript:void(0)">
							<i class="icon-settings"></i>
						</a>
					</li>
				</ul>
			</div>
		</nav>
		<!-- ===== Top-Navigation-End ===== -->

		<!-- ===== Left-Sidebar ===== -->
		<aside class="sidebar">
			<div class="scroll-sidebar">
				<div class="user-profile">
					<div class="dropdown user-pro-body">
						<div class="profile-image">
							@if(isset(Auth::user()->profile))
							<img src="{{asset('storage')}}/{{Auth::user()->profile->profile_picture}}" class="img-circle" alt="img"> @else
							<img src="{{ asset('images/avatar.jpg') }}" alt="user-img" class="img-circle"> @endif
							<a href="javascript:void(0);" class="dropdown-toggle u-dropdown text-blue" data-toggle="dropdown" role="button" aria-haspopup="true"
							 aria-expanded="false">
								<span class="badge badge-danger">
									<i class="fa fa-angle-down"></i>
								</span>
							</a>
							<ul class="dropdown-menu animated flipInY">
								<li>
									<a href="{{route('profile.index')}}">
										<i class="fa fa-user"></i> Profile</a>
								</li>
								<li>
									<a href="{{route('inbox.index')}}">
										<i class="fa fa-inbox"></i> Inbox</a>
								</li>
								<li role="separator" class="divider"></li>
								<li>
									<a href="javascript:void(0);">
										<i class="fa fa-cog"></i> Account Settings</a>
								</li>
								<li role="separator" class="divider"></li>
								<li>
									<a href="{{route('user/logout')}}">
										<i class="fa fa-power-off"></i> Logout</a>
								</li>
							</ul>
						</div>
						@auth @if(isset(Auth::user()->profile->last_name))
						<p class="profile-text m-t-10 m-b-5 font-16">
							<a href="javascript:void(0);">
								{{Auth::user()->profile->last_name.' '.Auth::user()->profile->first_name}}
							</a>
						</p>
						<p class="profile-text m-t-5 m-b-5 font-16">
							<a href="#">{{Auth::user()->auuid}} </a>
						</p>
						@role("ROD")
						<p class="profile-text m-t-5 m-b-5 font-16">
							<a hre="">REGION: {{LocationFacade::userLocation(Auth::user()->id)->name}} </a>
						</p>
						@endrole @role("ZBM")
						<p class="profile-text m-t-5 m-b-5 font-16">
							<a href="">ZONE: {{LocationFacade::userLocation(Auth::user()->id)->name}} </a>
						</p>
						@endrole @role("ASM")
						<p class="profile-text m-t-5 m-b-5 font-16">
							<a href="">AREA: {{LocationFacade::userLocation(Auth::user()->id)->name}} </a>
						</p>
						@endrole @role("MD")
						<p class="profile-text m-t-5 m-b-5 font-16">
							<a hrfe="">TERRITORY: {{LocationFacade::userLocation(Auth::user()->id)->name}} </a>
						</p>
						@endrole @else
						<p class="profile-text m-t-15 font-16">
							<a href="javascript:void(0);">
								{{Auth::user()->auuid}}
							</a>
						</p>
						@endif @endauth

					</div>
				</div>
				<nav class="sidebar-nav">
					<ul id="side-menu">
						<li>
							<a id="dashboard-highlight" class="waves-effect" href="{{route('dashboard.index')}}" aria-expanded="false">
								<i class="fa fa-dashboard fa-fw"></i>
								<span class="hide-menu"> Dashboard</span>
							</a>
						</li>

						@role('HR')
						<li>
							<a id="export-highlight" class="waves-effect" href="{{route('export.salesforce')}}" aria-expanded="false">
								<i class="fa fa-modx fa-fw"></i>
								<span class="hide-menu">Export Salesforce</span>
							</a>
						</li>
						<li>
							<a class="waves-effect" href="javascript:void(0);" aria-expanded="false">
								<i class="fa fa-group fa-fw"></i>
								<span class="hide-menu">Manage Application Users</span>
							</a>
							<ul aria-expanded="false" class="collapse">
								<li>
									<a href="{{route('hierachy.index')}}">Hierachy Relationship</a>
								</li>
								<li>
									<a id="role-permission" href="{{route('rolepermission.index')}}" aria-expanded="false"> Roles and Permissions</a>
								</li>
								<li>
									<a id="manage-highlight" href="{{route('application.users.manage')}}">Manage Profiles</a>
								</li>
							</ul>
						</li>
						@endrole @role('GeoMarketing')
						<li>
							<a id="export-highlight" class="waves-effect" href="{{route('export.geography')}}" aria-expanded="false">
								<i class="fa fa-modx fa-fw"></i>
								<span class="hide-menu">Export Geography Master</span>
							</a>
						</li>
						@endrole

						<li>
							<a class="waves-effect" href="javascript:void(0);" aria-expanded="false">
								<i class="icon-envelope-letter fa-fw"></i>
								<span class="hide-menu"> Inbox </span>
							</a>
							<ul aria-expanded="false" class="collapse">
								<li>
									<a href="{{route('inbox.index')}}">Mail Box</a>
								</li>
								<li>
									<a href="{{route('inbox.create')}}">Compose Message</a>
								</li>
							</ul>
						</li>
						@role('GeoMarketing')
						<li class="">
							<a class="waves-effect location-highlight" href="javascript:void(0);" aria-expanded="false">
								<i class="icon-equalizer fa-fw"></i>
								<span class="hide-menu"> Geography Information</span>
							</a>
							<ul aria-expanded="false" class="collapse">
								<li>
									<a href="javascript:void(0);">Location Management</a>
									<ul aria-expanded="false" class="collapse">
										<li>
											<a href="{{route('location.index')}}">Create Location Item</a>
										</li>
										<li>
											<a href="{{route('country.show')}}">View Countries</a>
										</li>
										<li>
											<a href="{{route('region.show')}}">View Regions</a>
										</li>
										<li>
											<a href="{{route('zone.show')}}">View Zones</a>
										</li>
										<li>
											<a href="{{route('state.show')}}">View States</a>
										</li>
										<li>
											<a href="{{route('area.show')}}">View Areas</a>
										</li>
										<li>
											<a href="{{route('lga.show')}}">View Lgas</a>
										</li>
										<li>
											<a href="{{route('territory.index')}}">View Territories</a>
										</li>
									</ul>
								</li>
								<li>
									<a href="javascript:void(0);">Site</a>
									<ul aria-expanded="false" class="collapse">
										<li>
											<a href="{{route('site.create')}}">Create a Site</a>
										</li>
										<li>
											<a href="{{route('site.index')}}">View or Modify Sites</a>
										</li>
									</ul>

								</li>

								<li>
									<a href="#">Region Info</a>
								</li>
								<li>
									<a href="#">Zone Info</a>
								</li>
								<li>
									<a href="#">State Info</a>
								</li>
								<li>
									<a href="#">Territory Info</a>
								</li>
								<li>
									<a href="#">Organograms</a>
								</li>
							</ul>
						</li>
						@endrole
						@if(Auth::user()->hasRole('HR') || Auth::user()->hasRole('HQ') || Auth::user()->hasRole('ZBM'))
						<li>
							<a class="waves-effect" href="javascript:void(0);" aria-expanded="false">
								<i class="fa fa-info-circle fa-fw"></i>
								<span class="hide-menu">App Notifications</span>
							</a>
							<ul aria-expanded="false" class="collapse">
							@if(Auth::user()->hasRole('HR'))
								<li>
									<a href="{{route('vacancies.index')}}">Vacancies</a>
								</li>
							@endif
								
								@role('ZBM')
								<li>
									<a href="{{route('history.attestation')}}">Attestation History</a>
								</li>
								<li>
									<a href="{{route('md.verification.index')}}">Monthly Verification</a>
								</li>
								@endrole
							</ul>
						</li>
						@endif
						<li>
							<a class="waves-effect" href="javascript:void(0);" aria-expanded="false">
								<i class="icon-notebook fa-fw"></i>
								<span class="hide-menu">My Profile</span>
							</a>
							<ul aria-expanded="false" class="collapse">
								<li>
									<a href="{{route('profile.index')}}">Personal Profile</a>
								</li>

								@if(Route::has('hierachy.downlines.'.strtolower(Auth::user()->roles()->pluck('name')[0])))
								<li>
									<a href="{{route('hierachy.downlines.'.strtolower(Auth::user()->roles()->pluck('name')[0]))}}">Hierachy Profile</a>
								</li>
								@endif
							</ul>
						</li>
						<li>
							<a class="waves-effect" href="javascript:void(0);" aria-expanded="false">
								<i class="icon-grid fa-fw"></i>
								<span class="hide-menu">Movement</span>
							</a>
							<ul aria-expanded="false" class="collapse">
							@role('HR')
								<li>
									<a href="javascript:void(0);">Role Movement</a>
									<ul aria-expanded="false" class="collapse">
										<li>
											<a href="{{route('role.movement.create')}}">Create Request</a>
										</li>
										<li>
											<a href="{{route('role.movement.history')}}">History</a>
										</li>
									</ul>
								</li>
								@endrole
								<li>
									<a href="javascript:void(0);">Location Movement</a>
									<ul aria-expanded="false" class="collapse">
										@hasanyrole('HR|HQ|GeoMarketing|MD')
										 @else
										<li>
											<a href="{{route('location.movement.create')}}">Create a Request</a>
										</li>
										@endhasanyrole

										<li>
											<a href="{{route('location.movement.history')}}">Movement History</a>
										</li>
									</ul>

								</li>
							</ul>
						</li>
						<li>
							<a class="waves-effect" href="javascript:void(0);" aria-expanded="false">
								<i class="icon-pie-chart fa-fw"></i>
								<span class="hide-menu"> Reports</span>
							</a>
							<ul aria-expanded="false" class="collapse">
								<li>
									<a href="#">Performance Reports</a>
								</li>
								@hasanyrole('ROD|ZBM|ASM')
								<li>
									<a href="{{route('vacancies.report.user',Auth::user()->id)}}">Vacancy Reports</a>
								</li>
								@endhasanyrole
							</ul>
						</li>
						<li>
							<a class="waves-effect" href="javascript:void(0);" aria-expanded="false">
								<i class="fa fa-clock-o fa-fw"></i>
								<span class="hide-menu">History</span>
							</a>
							<ul aria-expanded="false" class="collapse">
								<li>
								<a href="{{route('workhistory.index')}}">Work History</a>
								</li>
								{{--  <li>
									<a href="#">Region history</a>
								</li>
								<li>
									<a href="#">Zone history</a>
								</li>
								<li>
										<a href="#">Area history</a>
									</li>
								<li>
									<a href="#">Territory history</a>
								</li>  --}}
							</ul>
						</li>
						<li>
							<a class="waves-effect" href="javascript:void(0);" aria-expanded="false">
								<i class="icon-location-pin fa-fw"></i>
								<span class="hide-menu"> Targets</span>
							</a>
							<ul aria-expanded="false" class="collapse">
							@if(Auth::user()->hasRole('HR') || Auth::user()->hasRole('HQ') || Auth::user()->hasRole('GeoMarketing'))
								<li>
									<a href="{{route('targetsprofile.index')}}">Targets History</a>
								</li>
								@role('HQ')
								<li>
									<a href="{{route('targets.index')}}">Set Targets</a>
								</li>
								@endrole
							@else
								<li>
									<a href="{{route('targets.index')}}">Set Targets</a>
								</li>
								@endif
							</ul>
						</li>
						@hasanyrole('HR|HQ|GeoMarketing')
						<li>
								<a class="waves-effect" href="{{route('agency.index')}}" aria-expanded="false">
									<i class="fa fa-bank fa-fw"></i>
									<span class="hide-menu"> MD Agencies</span>
								</a>
							</li>
							@endhasanyrole
					</ul>
				</nav>
			</div>
		</aside>
		<!-- ===== Left-Sidebar-End ===== -->


		@yield('content')


		<!-- ===== Right-Sidebar ===== -->
		<div class="right-sidebar">
			<div class="slimscrollright">
				<div class="rpanel-title"> Service Panel
					<span>
						<i class="icon-close right-side-toggler"></i>
					</span>
				</div>
				<div class="r-panel-body">
					<ul class="hidden-xs">
						<li>
							<b>Layout Options</b>
						</li>
						<li>
							<div class="checkbox checkbox-danger">
								<input id="headcheck" type="checkbox" class="fxhdr">
								<label for="headcheck"> Fix Header </label>
							</div>
						</li>
						<li>
							<div class="checkbox checkbox-warning">
								<input id="sidecheck" type="checkbox" class="fxsdr">
								<label for="sidecheck"> Fix Sidebar </label>
							</div>
						</li>
					</ul>
					<ul id="themecolors" class="m-t-20">
						<li>
							<b>With Light sidebar</b>
						</li>
						<li>
							<a href="javascript:void(0)" data-theme="default" class="default-theme working">1</a>
						</li>
						<li>
							<a href="javascript:void(0)" data-theme="green" class="green-theme">2</a>
						</li>
						<li>
							<a href="javascript:void(0)" data-theme="yellow" class="yellow-theme">3</a>
						</li>
						<li>
							<a href="javascript:void(0)" data-theme="red" class="red-theme">4</a>
						</li>
						<li>
							<a href="javascript:void(0)" data-theme="purple" class="purple-theme">5</a>
						</li>
						<li>
							<a href="javascript:void(0)" data-theme="black" class="black-theme">6</a>
						</li>
						<li class="db">
							<b>With Dark sidebar</b>
						</li>
						<li>
							<a href="javascript:void(0)" data-theme="default-dark" class="default-dark-theme">7</a>
						</li>
						<li>
							<a href="javascript:void(0)" data-theme="green-dark" class="green-dark-theme">8</a>
						</li>
						<li>
							<a href="javascript:void(0)" data-theme="yellow-dark" class="yellow-dark-theme">9</a>
						</li>
						<li>
							<a href="javascript:void(0)" data-theme="red-dark" class="red-dark-theme">10</a>
						</li>
						<li>
							<a href="javascript:void(0)" data-theme="purple-dark" class="purple-dark-theme">11</a>
						</li>
						<li>
							<a href="javascript:void(0)" data-theme="black-dark" class="black-dark-theme">12</a>
						</li>
					</ul>
					<ul class="m-t-20 chatonline">
						<li>
							<b>Chat option</b>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<!-- ===== Right-Sidebar-End ===== -->
	</div>



	<footer data-ng-controller="MasterNotificationController" class="footer t-a-c">
		© 2017 Airtel Salesforce System

	</footer>
	@include('footer')
	@include('components.api_bind')
	</div>
	<!-- ===== Page-Content-End ===== -->
	</div>
		<script src="{{asset('js/nprogress.js')}}"></script>
	<script type="text/javascript">
	NProgress.start();
	</script>
	<!-- ===== jQuery  2.1.4 ===== -->
	@if(Request::is('dashboard') || Request::is('organogram/rod') || Request::is('organogram/zbm') || Request::is('organogram/asm') || Request::is('organogram/md'))
	<script type="text/javascript" src="{{asset('js/chart-jquery.js')}}"></script>
	@else
	<script src="{{ asset('js/jquery.js') }}"></script>
    @endif


	<!-- ===== Bootstrap JavaScript ===== -->
	<script src="{{ asset('js/bootstrap.min.js') }}"></script>
		<!-- ===== Menu Plugin JavaScript ===== -->
		<script src="{{ asset('js/sidebarmenu.js') }}"></script>
	<!-- ===== Slimscroll JavaScript ===== -->
	<script src="{{ asset('js/jquery.slimscroll.js') }}"></script>

	<!-- ===== Wave Effects JavaScript ===== -->
	<script src="{{ asset('js/waves.js') }}"></script>

	<!-- ===== Custom JavaScript ===== -->
	<script src="{{ asset('js/custom.js') }}"></script>

	<!--Jquery toast for Notification -->
	<script src="{{ asset('js/toastr.min.js') }} "></script>




	<!-- ===== Plugin JS ===== -->
	@if(Request::is('dashboard'))
	<script src="{{ asset('js/chartist.min.js') }}"></script>
	<script src="{{ asset('js/chartist-plugin-tooltip.min.js') }}"></script>
	<script src="{{ asset('js/jquery.sparkline.min.js') }}"></script>
	<script src="{{ asset('js/jquery.charts-sparkline.js') }}"></script>
	<script src="{{ asset('js/jquery.knob.js') }}"></script>
	<script src="{{asset('js/jquery.easypiechart.min.js') }}"></script>
	<script src="{{ asset('js/db1.js') }}"></script>
	 <script src="{{ asset('js/jQuery.style.switcher.js') }}"></script>
	 @endif
	<script src="{{ asset('js/angular.js') }} "></script>

	<!--My App Theme JS -->
	<script src="{{asset('js/theme/theme.js')}}"></script>
	<!--Footer angular controller -->
	<script src="{{ asset('js/controllers/footer.js') }}"></script>
	<script src="{{ asset('js/protip.js') }}"></script>
	<!--Sweet Alert JS -->
	<script src="{{ asset('js/sweetalert.min.js') }}"></script>

	<!--Master Notification Controller -->
	<script src="{{asset('js/controllers/master.notification.js')}}"></script>
	<script src="{{asset('js/bootstrap-notify.js')}}"></script>

	@yield('pagejs')

	<!--Welcome Notifier -->
	@if (session('welcome')) {{-- //Display Welcome toastr --}}
	<script src="{{ asset('js/toastr.js') }}"></script>
	@endif

	<!--Authorization Error Notifier -->
	@if(Session::has('authorizationError'))
	<script>
		GlobalWarningNotification("{{session('authorizationError')}}");
	</script>
	@endif
</body>

</html>