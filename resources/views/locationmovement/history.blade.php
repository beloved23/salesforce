 @extends('layouts.master') 
 @section('pagestyles')
              <link href="{{asset('css/jquery.dialog.css')}}" rel="stylesheet" type="text/css" />
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
							<h4 class="box-title">Location Movement History</h4>
						</div>
						<div class="col-sm-6">
							<ul class="list-inline">
								<li>
									<a href="javascript:void(0);" class="btn btn-default btn-outline font-16">
										<i class="fa fa-trash" aria-hidden="true"></i>
									</a>
								</li>
								<li>
									<a href="javascript:void(0);" class="btn btn-default btn-outline font-16">
										<i class="fa fa-commenting" aria-hidden="true"></i>
									</a>
								</li>
							</ul>
							<select class="custom-select">
								<option selected>Sort by</option>
								<option value="1">Name</option>
								<option value="2">Location</option>
								<option value="3">Type</option>
								<option value="4">Role</option>
								<option value="5">Action</option>
							</select>
						</div>
					</div>
					<div class="table-responsive">
						<table class="table">
							<thead>
								<tr>
									<th>Requester Name</th>
									<th>HR Name</th>
									<th>HR Auuid</th>
									<th>Attester Auuid</th>
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
									<td>{{(isset($item->attester_auuid) ? $item->attester_auuid : 'N/A')}}</td>
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
										@if($item->initiated_by==Auth::user()->id)
												<a href="javascript:;" onclick="invokeDelete('delete_form{{$item->id}}',{{$loop->index+1}})">
											<span data-toggle="tooltip" data-title="Delete" style="color:red;" class="cursor-pointer  tooltip-danger">
												<i class="fa fa-trash"></i>
											</span>
										</a>
										<form id="delete_form{{$item->id}}" hidden action="{{route('location.movement.destroy',$item->id)}}" method="POST">
										
										{!! Form::token() !!}
										
										<input name="location_id" hidden value="{{$item->id}}" />
										{{method_field('DELETE')}}
										</form>
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
			<script src="{{asset('js/jquery.dialog.js')}}"></script>
    <script> 
        function invokeDelete(element,id){
 dialog.confirm({
  title: "Location movement",
  message: "Remove location movement item with S/N of "+id+' ?',
  cancel: "Cancel",
  button: "Continue",
  required: false,
  callback: function(value){
    if(value){
        $('#'+element).submit();
    }
  }
});
        }
    </script>
			@endsection