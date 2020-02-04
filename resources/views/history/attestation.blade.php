 @extends('layouts.master') 
 @section('pagestyles')
  @endsection 
  @section('content')
<!-- Page Content -->
<div class="page-wrapper">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="white-box user-table">
					<div class="row">
						<div class="col-sm-6">
							<h4 class="box-title">Attestation History</h4>
						</div>
						<div class="col-sm-6">
							
						</div>
					</div>
					<div class="table-responsive">
						<table class="table">
							<thead>
								<tr>
									<th>Requester Name</th>
									<th>HR Name</th>
									<th>HR Auuid</th>
									<th>Number of Kits</th>
									<th>Location Type</th>
									<th>From</th>
									<th>To</th>
									<th>Approved</th>
									<th>Denied</th>
									<th>Cancelled</th>
									<th>Date</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								@foreach($locationMovement as $item)
								<tr>
									<td>
										<a href="javascript:void(0);" class="text-link">{{$item->requesterProfile->first_name.' '.$item->requesterProfile->last_name}}</a>
									</td>
									<td>
										@isset($item->hr_auuid) {{$item->hrProfile->first_name.' '.$item->hrProfile->last_name}}
										 @else
										  N/A 
										  @endisset
									</td>
									<td>{{(isset($item->hr_auuid) ? $item->hr_auuid : 'N/A')}}</td>
									<td class=""><span class="label label-info">{{$item->profile->no_of_kits}}</span></td>
									<td>{{substr($item->location_model,19,strlen($item->location_model)-19)}}</td>
									<td>{{LocationFacade::getLocation($item->location_model,$item->requester_location_id)->name}}</td>
									<td>{{LocationFacade::getLocation($item->location_model,$item->location_id)->name}}</td>
									<td>
										<span data-toggle="tooltip" data-original-title="{{((isset($item->hr_auuid) && (!$item->is_approved)) ? 'Awaiting approval' : (isset($item->hr_auuid) && ($item->is_approved)) ? 'Transfer Approved' : 'Pending HR claim' )}}"
										 class="label cursor-pointer tooltip-info {{($item->is_approved == 0 ? 'label-danger' : 'label-success')}}">
											@if($item->is_approved)
											<i class="fa fa-check-square-o"> </i>
											@else
											<i class="fa fa-close"> </i>
											@endif
										</span>
									</td>
									<td>
										<span class="label {{($item->is_denied == 0 ? 'label-success' : 'label-danger')}}">
											@if($item->is_denied)
											<i class="fa fa-check-square-o"> </i>
											@else
											<i class="fa fa-close"> </i>
											@endif
										</span>
									</td>
									<td>
										<span class="label {{($item->is_cancelled == 0 ? 'label-success' : 'label-danger')}}">
											@if($item->is_cancelled)
											<i class="fa fa-check-square-o"> </i>
											@else
											<i class="fa fa-close"> </i>
											@endif
										</span>
									</td>
									<td>
										{{substr($item->created_at,0,strlen($item->created_at)-8)}}
									</td>
									<td>
										<a href="{{route('location.movement.profile',$item->id)}}">
											<span data-toggle="tooltip" data-title="View Profile" class="cursor-pointer tooltip-info">
												<i class="fa fa-television"></i>
											</span>
										</a>
										@if($item->requester_auuid==Auth::user()->id && !$item->is_cancelled)
										<a href="{{route('location.movement.cancel',$item->id)}}">
											<span data-toggle="tooltip" data-title="Cancel Transfer Request" style="color:red;" class="cursor-pointer  tooltip-danger">
												<i class="fa fa-close"></i>
											</span>
										</a>
										@endif
									</td>
								</tr>
								@endforeach

							</tbody>
						</table>
					</div>
					{{ $locationMovement->links() }}
				</div>
			</div>
			@endsection 
			@section('pagejs') 
			@include('components.action_response')
			@endsection