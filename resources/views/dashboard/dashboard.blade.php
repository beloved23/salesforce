 @extends('layouts.master') 
 @section('pagestyles')
<link href="{{asset('css/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="{{asset('css/jquery.orgchart.min.css')}}">
<link rel="stylesheet" href="{{asset('css/chart-style.css')}}"> 
@endsection 
@section('content')
<!-- ===== Page-Content ===== -->
<div class="page-wrapper" data-ng-controller="DashboardController">
	<!-- ===== Page-Container ===== -->
	<div class="container-fluid">
		@if(Auth::user()->hasRole('HR') || Auth::user()->hasRole('GeoMarketing') || Auth::user()->hasRole('HQ'))

		@if(Auth::user()->hasRole('HR') || Auth::user()->hasRole('HQ'))
			<div class="row">
			<div class="col-lg-3 col-sm-3 col-xs-12">
				<div class="white-box analytics-info">
					<h3 class="box-title">Total ROD</h3>
					<ul class="list-inline two-part">
						<li>
							<div id="sparklinedash"></div>
						</li>
						<li class="text-right">
							<i class="ti-arrow-up text-success"></i>
							<span class="counter text-success">@{{rodCount}}</span>
						</li>
					</ul>
				</div>
			</div>
			<div class="col-lg-3 col-sm-3 col-xs-12">
				<div class="white-box analytics-info">
					<h3 class="box-title">Total ZBM</h3>
					<ul class="list-inline two-part">
						<li>
							<div id="sparklinedash2"></div>
						</li>
						<li class="text-right">
							<i class="ti-arrow-up text-purple"></i>
							<span class="counter text-purple">@{{zbmCount}}</span>
						</li>
					</ul>
				</div>
			</div>
			<div class="col-lg-3 col-sm-3 col-xs-12">
				<div class="white-box analytics-info">
					<h3 class="box-title">Total ASM</h3>
					<ul class="list-inline two-part">
						<li>
							<div id="sparklinedash3"></div>
						</li>
						<li class="text-right">
							<i class="ti-arrow-up text-info"></i>
							<span class="counter text-info">@{{asmCount}}</span>
						</li>
					</ul>
				</div>
			</div>
			<div class="col-lg-3 col-sm-3 col-xs-12">
				<div class="white-box analytics-info">
					<h3 class="box-title">Total MD</h3>
					<ul class="list-inline two-part">
						<li>
							<div id="sparklinedash4"></div>
						</li>
						<li class="text-right">
							<i class="ti-arrow-down text-danger"></i>
							<span class="text-danger">@{{mdCount}}</span>
						</li>
					</ul>
				</div>
			</div>
		</div>
		@else
			<div class="row">
			<div class="col-lg-3 col-sm-3 col-xs-12">
				<div class="white-box analytics-info">
					<h3 class="box-title">Total Regions</h3>
					<ul class="list-inline two-part">
						<li>
							<div id="sparklinedash"></div>
						</li>
						<li class="text-right">
							<i class="ti-arrow-up text-success"></i>
							<span class="counter text-success">@{{regionCount}}</span>
						</li>
					</ul>
				</div>
			</div>
			<div class="col-lg-3 col-sm-3 col-xs-12">
				<div class="white-box analytics-info">
					<h3 class="box-title">Total Zones</h3>
					<ul class="list-inline two-part">
						<li>
							<div id="sparklinedash2"></div>
						</li>
						<li class="text-right">
							<i class="ti-arrow-up text-purple"></i>
							<span class="counter text-purple">@{{zoneCount}}</span>
						</li>
					</ul>
				</div>
			</div>
			<div class="col-lg-3 col-sm-3 col-xs-12">
				<div class="white-box analytics-info">
					<h3 class="box-title">Total Areas</h3>
					<ul class="list-inline two-part">
						<li>
							<div id="sparklinedash3"></div>
						</li>
						<li class="text-right">
							<i class="ti-arrow-up text-info"></i>
							<span class="counter text-info">@{{areaCount}}</span>
						</li>
					</ul>
				</div>
			</div>
			<div class="col-lg-3 col-sm-3 col-xs-12">
				<div class="white-box analytics-info">
					<h3 class="box-title">Total Territories</h3>
					<ul class="list-inline two-part">
						<li>
							<div id="sparklinedash4"></div>
						</li>
						<li class="text-right">
							<i class="ti-arrow-down text-danger"></i>
							<span class="text-danger">@{{territoryCount}}</span>
						</li>
					</ul>
				</div>
			</div>
		</div>
		@endif
	
		@else
		<div class="row m-0">
			@role('ROD')
			<div class="col-lg-3 col-sm-3 col-xs-12">
				<div class="white-box analytics-info">
					<h3 class="box-title">ZBM</h3>
					<ul class="list-inline two-part">
						<li>
							<div id="sparklinedash"></div>
						</li>
						<li class="text-right">
							<i class="ti-arrow-up text-success"></i>
							<span class="counter text-success">@{{myZbms}}</span>
						</li>
					</ul>
				</div>
			</div>
			<div class="col-lg-3 col-sm-3 col-xs-12">
				<div class="white-box analytics-info">
					<h3 class="box-title">ASM</h3>
					<ul class="list-inline two-part">
						<li>
							<div id="sparklinedash2"></div>
						</li>
						<li class="text-right">
							<i class="ti-arrow-up text-purple"></i>
							<span class="counter text-purple">@{{myAsms}}</span>
						</li>
					</ul>
				</div>
			</div>
			<div class="col-lg-3 col-sm-3 col-xs-12">
				<div class="white-box analytics-info">
					<h3 class="box-title">MD</h3>
					<ul class="list-inline two-part">
						<li>
							<div id="sparklinedash4"></div>
						</li>
						<li class="text-right">
							<i class="ti-arrow-down text-danger"></i>
							<span class="text-danger">@{{myMds}}</span>
						</li>
					</ul>
				</div>
			</div>
			@endrole @role('ZBM')
			<div class="col-lg-3 col-sm-3 col-xs-12">
				<div class="white-box analytics-info">
					<h3 class="box-title">ASM</h3>
					<ul class="list-inline two-part">
						<li>
							<div id="sparklinedash2"></div>
						</li>
						<li class="text-right">
							<i class="ti-arrow-up text-purple"></i>
							<span class="counter text-purple">@{{myAsms}}</span>
						</li>
					</ul>
				</div>
			</div>
			<div class="col-lg-3 col-sm-3 col-xs-12">
				<div class="white-box analytics-info">
					<h3 class="box-title">MD</h3>
					<ul class="list-inline two-part">
						<li>
							<div id="sparklinedash4"></div>
						</li>
						<li class="text-right">
							<i class="ti-arrow-down text-danger"></i>
							<span class="text-danger">@{{myMds}}</span>
						</li>
					</ul>
				</div>
			</div>
			@endrole @role('ROD')
			<div class="col-md-3 col-sm-6 info-box">
				<div class="media">
					<div class="media-left p-r-5">
						<div id="earning" class="e" data-percent="{{$totalZbmPercentage}}">
							<div id="pending" class="p" data-percent="{{$totalAsmPercentage}}"></div>
							<div id="booking" class="b" data-percent="{{$totalMdPercentage}}"></div>
						</div>
					</div>
					<div class="media-body">
						<h2 class="text-blue font-22 m-t-0">My Hierachy </h2>
						<ul class="p-0 m-b-10 font-12">
							<li>
								<i class="fa fa-circle m-r-5 text-primary"></i>{{$totalZbmPercentage}}% My ZBM Total: @{{myZbms}}</li>
							<li>
								<i class="fa fa-circle m-r-5 text-primary"></i>{{$totalAsmPercentage}}% My ASM Total: @{{myAsms}}</li>
							<li>
								<i class="fa fa-circle m-r-5 text-info"></i>{{$totalMdPercentage}}% My Md Total: @{{myMds}}</li>
						</ul>
						<div class="font-15">
							<a href="{{route('organogram.rod')}}" class="btn btn-danger btn-block">View Organogram</a>
						</div>
					</div>
				</div>
			</div>
			@endrole @role('ZBM')
			<div class="col-md-3 col-sm-6 info-box">
				<div class="media">
					<div class="media-left p-r-5">
						<div id="earning" class="e" data-percent="{{$totalAsmPercentage}}">
							<div id="pending" class="p" data-percent="{{$totalMdPercentage}}"></div>
						</div>
					</div>
					<div class="media-body">
						<h2 class="text-blue font-22 m-t-0">My Hierachy</h2>
						<ul class="p-0 m-b-20 font-12">
							<li>
								<i class="fa fa-circle m-r-5 text-primary"></i>{{$totalAsmPercentage}}% My ASMs Total: @{{myAsms}}</li>
							<li>
								<i class="fa fa-circle m-r-5 text-primary"></i>{{$totalMdPercentage}}% My MDs Total: @{{myMds}}</li>
						</ul>
						<div class="font-15">
							<a href="{{route('organogram.zbm')}}" class="btn btn-danger btn-block">View Organogram</a>
						</div>
					</div>
				</div>
			</div>
			@endrole @role('ASM')
			<div class="col-md-3 col-sm-6 info-box">
				<div class="media">
					<div class="media-left p-r-5">
						<div id="earning" class="e" data-percent="{{$totalAsmPercentage}}">
						</div>
					</div>
					<div class="media-body">
						<h2 class="text-blue font-22 m-t-0">My Hierachy</h2>
						<ul class="p-0 m-b-20 font-12">
							<li>
								<i class="fa fa-circle m-r-5 text-primary"></i>{{$totalMdPercentage}}% My MDs Total: @{{myMds}}</li>
						</ul>
						<div class="font-15">
							<a href="{{route('organogram.asm')}}" class="btn btn-danger btn-block">View Organogram</a>
						</div>
					</div>
				</div>
			</div>
			@endrole @role('HR')
			<div class="col-md-3 col-sm-6 info-box">
				<div class="media">
					<div class="media-left p-r-5">
						<div id="earning" class="e" data-percent="60">
							<div id="pending" class="p" data-percent="55"></div>
							<div id="booking" class="b" data-percent="20"></div>
						</div>
					</div>
					<div class="media-body">
						<h2 class="text-blue font-22 m-t-0">Report</h2>
						<ul class="p-0 m-b-20">
							<li>
								<i class="fa fa-circle m-r-5 text-primary"></i>60% Earnings</li>
							<li>
								<i class="fa fa-circle m-r-5 text-primary"></i>55% Pending</li>
							<li>
								<i class="fa fa-circle m-r-5 text-info"></i>50% Bookings</li>
						</ul>
					</div>
				</div>
			</div>
			@endrole @role('HQ')
			<div class="col-md-3 col-sm-6 info-box">
				<div class="media">
					<div class="media-left p-r-5">
						<div id="earning" class="e" data-percent="60">
							<div id="pending" class="p" data-percent="55"></div>
							<div id="booking" class="b" data-percent="20"></div>
						</div>
					</div>
					<div class="media-body">
						<h2 class="text-blue font-22 m-t-0">Report</h2>
						<ul class="p-0 m-b-20">
							<li>
								<i class="fa fa-circle m-r-5 text-primary"></i>60% Earnings</li>
							<li>
								<i class="fa fa-circle m-r-5 text-primary"></i>55% Pending</li>
							<li>
								<i class="fa fa-circle m-r-5 text-info"></i>50% Bookings</li>
						</ul>
					</div>
				</div>
			</div>
			@endrole

		</div>
		@endif
		{{--  <div class="row m-t-10">
			<div class="col-md-4">
				<div class="white-box ecom-stat-widget">
					<div class="row">
						<div class="col-xs-6">
							<span class="text-blue font-light">{{$totalAssignedTargets}}
								<i class="icon-arrow-up-circle text-success"></i>
							</span>
							<p class="font-12">Total Targets assigned</p>
						</div>
						<div class="col-xs-6">
							<span class="icoleaf bg-primary text-white">
								<i class="icon-bag"></i>
							</span>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="white-box ecom-stat-widget">
					<div class="row">
						<div class="col-xs-6">
							<span class="text-blue font-light">{{$totalCompletedTargets}}
								<i class="icon-arrow-up-circle text-warning"></i>
							</span>
							<p class="font-12">Total Completed Targets</p>
						</div>
						<div class="col-xs-6">
							<span class="icoleaf bg-primary text-white">
								<i class="mdi mdi-checkbox-marked-circle-outline"></i>
							</span>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="white-box small-box-widget">
					<div class="p-t-10 p-b-10">
						<div class="icon-box bg-warning">
							<i class="icon-refresh"></i>
						</div>
						<div class="detail-box">
							<h4>Performance
								<span class="pull-right text-warning font-22 font-normal">
								@if($totalAssignedTargets>0)
								{{round($totalCompletedTargets/$totalAssignedTargets,1)*100}}%
								@else
								0%
								@endif
								</span>
							</h4>
							@if($totalAssignedTargets>0)
							<div class="progress">
								<div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="{{round($totalCompletedTargets/$totalAssignedTargets,1)}}" aria-valuemin="0" aria-valuemax="100"
								 style="width: {{round($totalCompletedTargets/$totalAssignedTargets,1)*100}}%">
									<span class="sr-only">{{round($totalCompletedTargets/$totalAssignedTargets,1)*100}}% complete</span>
								</div>
							</div>
							@else
							<div class="progress">
								<div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"
								 style="width: 0%">
									<span class="sr-only">0% complete</span>
								</div>
							</div>
							@endif
							
						</div>
					</div>
				</div>
			</div>
		</div>  --}}
		{{--  <div class="row">
			<div class="col-md-8 col-sm-12">
				<div class="white-box stat-widget">
					<div class="row">
						<div class="col-md-3 col-sm-3">
							<h4 class="box-title">Performance</h4>
						</div>
						<div class="col-md-9 col-sm-9">
							<select class="custom-select">
								<option selected value="0">Feb 04 - Mar 03</option>
								<option value="1">Mar 04 - Apr 03</option>
								<option value="2">Apr 04 - May 03</option>
								<option value="3">May 04 - Jun 03</option>
							</select>
							<ul class="list-inline">
								<li>
									<h6 class="font-15">
										<i class="fa fa-circle m-r-5 text-success"></i>Last Month</h6>
								</li>
								<li>
									<h6 class="font-15">
										<i class="fa fa-circle m-r-5 text-primary"></i>Current Month</h6>
								</li>
							</ul>
						</div>
						<div class="stat chart-pos"></div>
					</div>
				</div>
			</div>
			<div class="col-md-4 col-sm-12">
				<div class="white-box">
					@if(Auth::user()->hasRole('HR') || Auth::user()->hasRole('HQ') || Auth::user()->hasRole('GeoMarketing'))
					<h4 class="box-title label label-info">Total SalesForce: @{{rodCount+zbmCount+asmCount+mdCount}}</h4>
					<h4 class="box-title">Total Targets Assigned</h4>
					@else
					<h4 class="box-title">Targets Assigned To Me</h4>
					@endif
					<div class="task-widget t-a-c">
						<div class="task-chart" id="sparklinedashdb"></div>
						<div class="task-content font-16 t-a-c">
							<div class="col-sm-6 b-r">
								This Month
								<h1 class="text-primary">{{$targetsThisMonth}}
									<span class="font-16 text-muted">Target(s)</span>
								</h1>
							</div>
							<div class="col-sm-6">
								Uncompleted
								<h1 class="text-primary">{{$uncompletedTargets}}
									<span class="font-16 text-muted">Target(s)</span>
								</h1>
							</div>
						</div>
											@if(Auth::user()->hasRole('HR') || Auth::user()->hasRole('HQ') || Auth::user()->hasRole('GeoMarketing'))
											@else
						<div class="task-assign font-16">
							Assigned By
							<ul class="list-inline">
								@if(count($targetsPicture)
								< 4) @foreach($targetsPicture as $pic) <li class="p-l-0">
									<img height="40" width="80" style="height:40px;" src="{{asset('storage')}}/{{$pic->profile_picture}}" alt="user" data-toggle="tooltip"
									 data-placement="top" title="" data-original-title="{{$pic->first_name}} {{$pic->last_name}}">
									</li>
									@endforeach @else @for($i = 0; $i
									< 4; $i++) <li>
										<img src="../plugins/images/users/2.png" alt="user" data-toggle="tooltip" data-placement="top" title="" data-original-title="Steave">
										</li>
										@endfor
										<li class="p-r-0">
											<a href="javascript:void(0);" class="btn btn-success font-16">{{count($targetsPicture)-3}}</a>
										</li>
										@endif

							</ul>
						</div>
						@endif
					</div>
					@if(Auth::user()->hasRole('HR') || Auth::user()->hasRole('HQ') || Auth::user()->hasRole('GeoMarketing'))
											@else
					<a class="btn btn-warning btn-block" href="{{route('targets.index')}}#assignedTargets">View Targets</a>
					@endif
				</div>
			</div>
		</div>  --}}
		<!--Geographical view -->
		@if(Auth::user()->hasRole('ROD') || Auth::user()->hasRole('ZBM'))
		<div class="row">
			<div id="showZoneTable" class="col-lg-12">
				<div class="white-box">
					<h3 class="box-title">Geography: Zone</h3>
					<!--Zone table -->
					<table class="table table-striped table-bordered" id="example23">
						<thead>
							<tr>
								<th>Name</th>
								<th>Zone Code</th>
								<th>Zone ZBM</th>
								<th>Region ID</th>
								<th>Region name</th>
								<th>Region Code</th>
								<th>Region ROD</th>
							</tr>
						</thead>
						<tbody>
							@foreach($locations as $zone)
							<tr class="gradeC">
								<td>{{$zone->name}}</td>
								<td>{{$zone->zone_code}}</td>
								<td>
									@isset($zone->zbmByLocation) {{$zone->zbmByLocation->userprofile->first_name.' '.$zone->zbmByLocation->userprofile->last_name}}
									@else N/A @endisset
								</td>
								<td>{{$zone->region_id}}</td>
								<td class="center">{{$zone->region->name}}</td>
								<td class="center">{{$zone->region->region_code}}</td>
								<td class="center">
									@isset($zone->region->rodByLocation) {{$zone->region->rodByLocation->userprofile->first_name.' '.$zone->region->rodByLocation->userprofile->last_name}}
									@else N/A @endisset
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>

					<!--Zone table-->
				</div>
			</div>
		</div>
		@endif

		<div class="row">
				<div class="page-aside">
						<div class="right-aside">
							<div class="right-page-header">
							  <div class="btn-group">
														<button type="button" class="btn btn-primary dropdown-toggle waves-effect waves-light m-r-5" data-toggle="dropdown" aria-expanded="false"> Filter <b class="caret"></b> </button>
														<ul class="dropdown-menu" role="menu">
														<li><a id="organogram-reload" href="javascript:void(0);">Reload</a></li>
														</ul>
													</div>
												</div>
											</div>
										</div>
			<div class="chart-container" style="overflow-x:scroll;">
			</div>
			{{--  <div class="chart-geography">
				</div>  --}}
		</div>
		<!--Modals below -->
		<div id="profile-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"
		 style="display: none;">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						<h4 class="modal-title">SalesForce Profile</h4>
					</div>
					<div class="modal-body">
						<form name="update-profile" id="update-profile" action="{{route('dashboard.store')}}" method="POST" enctype="multipart/form-data">
							{{csrf_field()}}
							<input class="hidden" name="action" value="profile" />
							<div class="white-box">
								<div class="profile-widget">
									<div class="profile-img">
										@if(isset(Auth::user()->profile))
										<img src="{{asset('storage')}}/{{Auth::user()->profile->profile_picture}}" height="100" width="100" class="img-circle" alt="img"> @else
										<img src="{{ asset('images/avatar.jpg') }}" alt="user-img" class="img-circle"> @endif
										<p class="m-t-10 m-b-5">
											<a href="javascript:void(0);" class="profile-text font-22 font-semibold">My Auuid: {{Auth::user()->auuid}}</a>
										</p>
										<p class="font-16">Hello! , seems like you are a new user. Let us help you get started. Please provide the information required below</p>
									</div>
									<div class="profile-info">
										<div class="col-xs-6 col-md-6 b-r">
											<div class="form-group">
												<div class="fileinput fileinput-new" data-provides="fileinput">
													<div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
														<img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt="" /> </div>
													<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
													<div>
														<span class="btn default btn-file">
															<span class="fileinput-new"> Select image </span>
															<span class="fileinput-exists"> Change </span>
															<input type="file" data-validation="required" name="picture"> </span>
														<a href="javascript:;" class="btn default fileinput-exists" data-dismiss="fileinput"> Remove </a>
													</div>
												</div>
											</div>
										</div>
										<div class="col-xs-6 col-md-6">
											<div class="form-group">
												<label for="exampleInputEmail1">First Name</label>
												<input data-validation="required" type="text" class="form-control" name="first_name" id="exampleInputEmail1" placeholder="Enter Firstname"> </div>
											<div class="form-group">
												<label for="exampleInputEmail1">Last Name</label>
												<input data-validation="required" type="text" class="form-control" name="last_name" id="exampleInputEmail1" placeholder="Enter LastName"> </div>
											<div class="form-group">
												<label for="exampleInputEmail1">Phone Number</label>
												<input data-validation="only_number" type="text" class="form-control" name="msisdn" id="exampleInputEmail1" placeholder="Phone number"> </div>
										</div>
									</div>
									<div class="profile-btn">
										<button type="submit" class="btn btn-success">Update Profile</button>
									</div>
								</div>
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>
		<a href="javascript:void(0);" id="show-profile-modal" class="hidden" data-target="#profile-modal" data-toggle="modal" class="hidden"></a>
		@endsection 
		@section('pagejs')
		<script src="{{asset('js/controllers/dashboard.js')}}"></script>
		<script src="{{asset('js/bootstrap-fileinput.js')}}" type="text/javascript"></script>
		<script src="{{asset('js/jquery.form-validator.js')}}"></script>
		{{-- @if($userRole=="ROD" || $userRole=="ZBM" || $userRole=="ASM" || $userRole=="MD" || $userRole=="HR") --}}
		<script type="text/javascript" src="{{asset('js/html2canvas.min.js')}}"></script>
		<script type="text/javascript" src="{{asset('js/jquery.orgchart.min.js')}}"></script>
		<script src="{{asset('js/controllers/dashboard-organogram.js')}}"></script>
		<script>
			$('.footer').hide();
		</script>
		{{-- @endif --}}
		<script>
			$('#dashboard-highlight').addClass('active');
            //custom validator
                $.formUtils.addValidator({
  name : 'only_number',
  validatorFunction : function(value, $el, config, language, $form) {
    return /^\d+$/.test(value);
  },
  errorMessage : 'Only numbers are allowed',
  errorMessageKey: 'enterNumber'
});
                            $.validate();
		</script>
		{{--  <!--Prompt new user to provide profile information -->
		@if(Session::has('profile')) 
		@if(session('profile'))
		<script>
			$('#show-profile-modal').click();
		</script>
		@endif 
		@endif  --}}
		 @include('components.action_response') @endsection