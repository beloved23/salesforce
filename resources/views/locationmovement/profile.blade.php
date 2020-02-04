@extends('layouts.master')

@section('pagestyles')
    
@endsection

@section('content')
       <!-- Page Content -->
        <div class="page-wrapper">
            <div class="container-fluid">
            @foreach($locationMovementProfile as $item)
                        <div class="row">
                    <div class="col-md-4 col-sm-12">
                        <div class="white-box upload-widget2">
                            <h3 class="box-title">Requester</h3>
                            <div class="form-group text-center">
                        <img class="img-circle" style="60px; width:60px;" src="{{asset('storage')}}/{{$item->requesterProfile->profile_picture}}"/>
                          </div>
                          <div class="form-group">
                        <h4>  Requester Name : {{$item->requesterProfile->first_name.' '.$item->requesterProfile->last_name}} </h4>
                          </div>
                           <div class="form-group">
                        <h4>  Requester Auuid : {{$item->requesterUser->auuid}}</h4>
                          </div>
                               <div class="form-group">
                         <h4> Requester Email : {{$item->requesterUser->email}}</h4>
                          </div>
                          <div class="form-group">
                         <h4> Location : {{substr($item->location_model,19,strlen($item->location_model)-19)}}</h4>
                          </div>
                          <div class="form-group">
                         <h4> From : {{LocationFacade::getLocation($item->location_model,$item->requester_location_id)->name}}</h4>
                          </div>
                          <div class="form-group">
                         <h4> To : {{LocationFacade::getLocation($item->location_model,$item->location_id)->name}}</h4>
                          </div>
                          <div class="form-group">
                         <h4>Date:  {{substr($item->created_at,0,strlen($item->created_at)-8)}}</h4>
                          </div>
                          @if($item->is_attestation_required)
                            <h3 class="box-title">Attestation</h3>
                              <div class="form-group">
                        <h4>  Attester Auuid : {{$item->attester_auuid}}</h4>
                        @role('ZBM')
                        @if($item->attester_auuid==Auth::user()->id)
                              <!-- attestation form -->
                                      <form method="POST" class="m-t-10" action ="{{route('location.movement.profile.action.attest',$item->id)}}" >
                                      {{csrf_field()}}
                                      <input class="form-control" data-valdation="only_number" placeholder="Number of Kits" />
                                       <input class="form-control" data-validation="required" placeholder="Attester comment" />
                        <a type="submit" class="btn btn-danger m-t-10"><i class="fa fa-plus p-r-5"></i>Attest Request</a>
                             </form>
                        @endif
                        @endrole
                          </div>
                          @endif
                   
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="white-box upload-widget">
                            <div class="t-a-c">
                             <div class="white-box upload-widget2">
                            <h3 class="box-title">Human Resource</h3>
                            <div class="form-group text-center">
                            @if(isset($item->hrProfile))
                            <img class="img-circle" style="60px; width:60px;" src="{{asset('storage')}}/{{$item->hrProfile->profile_picture}}"/>
                            @else
                               <h4> N/A </h4>
                            @endif
                          </div>
                          <div class="form-group">
                            @if(isset($item->hrProfile))
                            <h4>  HR Name : {{$item->hrProfile->first_name.' '.$item->hrProfile->last_name}} </h4>
                            @else
                           <h4>N/A</h4>
                            @endif
                          </div>
                           <div class="form-group">
                            @if(isset($item->hrProfile))
                        <h4>  HR Auuid : {{$item->hrUser->id}}</h4>
                        @else
                        <h4>N/A</h4>
                        @endif
                          </div>
                               <div class="form-group">
                                 @if(isset($item->hrProfile))
                         <h4> HR Email : {{$item->hrUser->email}}</h4>
                        @else
                        <h4>N/A</h4>
                        @endif
                          </div>
                        </div>
                                <span class="up-speed m-t-20 m-b-10">
                                <!--Check if cancelled -->
                                @if($item->is_cancelled)
                                Cancelled by User
                                @else
                                <!--Attestation is required -->
                                  @if($item->profile->is_attestation_required)
<!--Attested, claimed and approved -->
                               @if($item->profile->is_attested && $item->is_approved && $item->is_claimed)
                                    Location Transfer Approved
                               @else
                               <!-- Not attested -->
@if(!$item->profile->is_attested)
                               Awaiting Attestation by ZBM
@endif
<!--Attest but not claimed -->
@if($item->profile->is_attested && !$item->is_claimed)
                                   Awaiting to be claimed by HR
@endif
<!--Attested, claimed but not approved -->
@if($item->profile->is_attested && $item->is_claimed && !$item->is_approved)
                                   Awaiting Approval
@endif
                                @endif
                                
                                  @else <!--Attestation is not required -->
                                  <!--yet to be claimed by HR -->
                                    @if(!$item->is_claimed)
                                   Awaiting to be claimed by HR
                               @endif
<!--Claimed && approved -->
                               @if($item->is_claimed && $item->is_approved)
                                    Location Transfer Approved
                               @endif

                               @if($item->is_claimed && !$item->is_approved)
                                        Awaiting Approval
                               @endif

                                  @endif
                               @endif
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="white-box upload-widget">
                            <div class="t-a-c">
                             <div class="white-box upload-widget2">
                            <h3 class="box-title">Location Movement Profile</h3>
                          <div class="form-group">
                        <h4>HR to approve:

                          @if(isset($item->hr_id))
                              @if($item->hr_id==Auth::user()->id)
                              You
                              @else
                                {{$item->hr_auuid}}
                              @endif
                          @endif

                         </h4>
                        <div>Claimed <i class="fa {{($item->is_claimed == 0 ? 'fa-square-o' : 'fa-check-square-o')}}"></i>
                        @if($item->is_cancelled)
                          <div><label class="label label-danger">Cancelled by User</label></div>
                        @else
                        <!--Prepare unclaim button -->
                        @role('HR')
                        @if(isset($item->hr_auuid))
                            @if($item->hr_id==Auth::user()->id && !$item->is_approved)
                     <a href="{{route('location.movement.profile.action.unclaim',$item->id)}}"  class="btn btn-primary"><i class="fa fa-minus p-r-5"></i>Undo Claim</a>
                            @endif
                        @else
                        <!--Prpare claim button -->
                    <a href="{{route('location.movement.profile.action.claim',$item->id)}}" class="btn btn-primary"><i class="fa fa-plus p-r-5"></i>Claim</a>
                        @endif
                        @endrole
                      @endif

                        </div>
                          </div>
                                    <div class="form-group">
            Denied: <span class="label {{($item->is_denied == 0 ? 'label-success' : 'label-danger')}}">
          @if($item->is_denied)
			<i class="fa fa-check-square-o"> </i>
			@else
			<i class="fa fa-close"> </i>
			@endif								
            </span>
                          </div>
                           <div class="form-group">
            Approved: <span data-toggle="tooltip" data-original-title="{{((!$item->is_approved) ? 'Awaiting approval' : 'Transfer Approved' )}}"
             class="label cursor-pointer tooltip-info {{($item->is_approved == 0 ? 'label-danger' : 'label-success')}}">
           @if($item->is_approved)
											<i class="fa fa-check-square-o"> </i>
											@else
											<i class="fa fa-close"> </i>
											@endif
            </span>
                            <!--Prepare approve button -->
                            @role('HR')
                            <!--Check if cancelled -->
                            @if(!$item->is_cancelled)
                              <!--Check for Attestation -->
                              @if($item->profile->is_attestation_required)
                              @if($item->profile->is_attested)
                                @if(isset($item->hr_auuid))
                                @if($item->hr_id==Auth::user()->id && !$item->is_approved)
                                <!-- approval form -->
                                <form id="approval-form" action="{{route('location.movement.profile.action.approve',$item->id)}}" method="POST" >
                                {{csrf_field()}}
                                <input class="form-control m-t-10" name="approval_comment" data-validation="required" placeholder="Approval comment" />
             <button id="confirmApproval" type="submit" class="btn btn-success m-t-10"><i class="fa fa-plus p-r-5"></i>Approve Request</button>
                                      </form>
                                      <!-- denial form -->
                                      <form method="POST" id="denial-form" name="denial-form" class="m-t-10" action ="{{route('location.movement.profile.action.deny',$item->id)}}" >
                                      {{csrf_field()}}
                                      <input class="form-control" name="denial_comment" data-validation="required" placeholder="Denial comment" />
                        <button type="submit" id="denyRequest" class="btn btn-danger m-t-10"><i class="fa fa-plus p-r-5"></i>Deny Request</button>
                             </form>
                                @endif
                              @endif
                              @else
                              <span class="up-speed m-t-20 m-b-10">
                              Awaiting Attestation from ZBM: {{$item->attester_auuid}}
                              </span>
                              @endif
                              @else
                              @if(isset($item->hr_id))
                                @if($item->hr_id==Auth::user()->id && !$item->is_approved)
                                <!-- approval form -->
                                <form id="approval-form" action="{{route('location.movement.profile.action.approve',$item->id)}}" method="POST" >
                                {{csrf_field()}}
                                <input class="form-control m-t-10" name="approval_comment" data-validation="required" placeholder="Approval comment" />
             <button id="confirmApproval" type="submit" class="btn btn-success m-t-10"><i class="fa fa-plus p-r-5"></i>Approve Request</button>
                                      </form>
                                      <!-- denial form -->
                                      <form method="POST" id="denial-form" name="denial-form" class="m-t-10" action ="{{route('location.movement.profile.action.deny',$item->id)}}" >
                                      {{csrf_field()}}
                                      <input class="form-control" name="denial_comment" data-validation="required" placeholder="Denial comment" />
                        <button type="submit" id="denyRequest" class="btn btn-danger m-t-10"><i class="fa fa-plus p-r-5"></i>Deny Request</button>
                             </form>
                                @endif
                              @endif
                              <!--End Attestation -->
                              @endif
                              <!--End if cancelled -->
                              @endif
                            @endrole

                        <!--Prepare Attestation form -->
                        @role('ZBM')
                        @if($item->profile->is_attestation_required && ($item->attester_id==Auth::user()->id) && !$item->profile->is_attested)
                         <form method="POST" id="attest-form" name="attest-form" class="m-t-10" action ="{{route('location.movement.attest',$item->id)}}" >
                                      {{csrf_field()}}
                                      <input class="form-control m-t-5" name="attestation_comment" data-validation="required" placeholder="Attester comment" />
                                      <input class="form-control m-t-5" name="kits" data-validation="required" placeholder="Number of Kits" />
                        <button type="submit" class="btn btn-info m-t-10"><i class="fa fa-plus p-r-5"></i>Attest Transfer</button>
                             </form>
                             @endif
                        @endrole
                          </div>
                 
                              
                        </div>
                            </div>
                        </div>
                    </div>
                </div>
                  @endforeach
        </div>
        </div>
@endsection

@section('pagejs')
<script src="{{asset('js/jquery.confirm.min.js')}}"></script>
<script src="{{asset('js/jquery.form-validator.js')}}"></script>
<script>

                                                              /*        $.formUtils.addValidator({
  name : 'only_number',
  validatorFunction : function(value, $el, config, language, $form) {
    return /^\d+$/.test(value);
  },
  errorMessage : 'Only numbers are allowed',
  errorMessageKey: 'enterNumber'
});
      $.validate('approval-form');
      */
            $.validate();
</script>
    @include('components.action_response')
@endsection