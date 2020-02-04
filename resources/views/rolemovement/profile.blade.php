@extends('layouts.master')

@section('pagestyles')
    
@endsection

@section('content')
       <!-- Page Content -->
        <div class="page-wrapper">
            <div class="container-fluid">
                        <div class="row">
                    <div class="col-md-4 col-sm-12">
                        <div class="white-box upload-widget2">
                            <h3 class="box-title">Requester</h3>
                            <div class="form-group text-center">
                        <img class="img-circle" style="60px; width:60px;" src="{{asset('storage')}}/{${roleMovementProfile->requesterProfile->profile_picture}}"/>
                          </div>
                          <div class="form-group">
                        <h4>  Requester Name : {{$roleMovementProfile->requesterProfile->first_name.' '.$roleMovementProfile->requesterProfile->last_name}} </h4>
                          </div>
                           <div class="form-group">
                        <h4>  Requester Auuid : {{$roleMovementProfile->requesterUser->auuid}}</h4>
                          </div>
                               <div class="form-group">
                         <h4> Requester Email : {{$roleMovementProfile->requesterUser->email}}</h4>
                          </div>
                          <div class="form-group">
                         <h4> Requested Role For Resource : {{$roleMovementProfile->destinationRole->name}}</h4>
                          </div>
                           <div class="form-group">
                         <h4>To : {{$destionationLocation}}</h4>
                          </div>
                          @if($roleMovementProfile->is_attestation_required)
                            <h3 class="box-title">Attestation</h3>
                              <div class="form-group">
                        <h4>  Attester Auuid : {{$roleMovementProfile->attester_auuid}}</h4>
                        @role('ZBM')
                        @if($roleMovementProfile->attester_auuid==Auth::user()->id)
                              <!-- attestation form -->
                                      <form method="POST" class="m-t-10" action ="{{route('role.movement.profile.action.attest',$roleMovementProfile->id)}}" >
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
                            <h3 class="box-title">Resource</h3>
                            <div class="form-group text-center">
                        <img class="img-circle" style="60px; width:60px;"
                         src="{{asset('storage')}}/{{$roleMovementProfile->resourceProfile->profile_picture}}"/>
                          </div>
                          <div class="form-group">
                        <h4>  Resource Name : {{$roleMovementProfile->resourceProfile->first_name.' '.$roleMovementProfile->resourceProfile->last_name}} </h4>
                          </div>
                           <div class="form-group">
                        <h4>  Resource Auuid : {{$roleMovementProfile->resourceUser->auuid}}</h4>
                          </div>
                               <div class="form-group">
                         <h4> Resource Email : {{$roleMovementProfile->resourceUser->email}}</h4>
                          </div>
                          <div class="form-group">
                         <h4> Resource Role : {{$roleMovementProfile->resourceRole->name}}</h4>
                          </div>
                          @if($roleMovementProfile->profile->is_attestation_required)
                          <h3 class="box-title">Attestation</h3>
                           <div class="form-group">
                         <span>Attester Auuid : {{$roleMovementProfile->attester_auuid}}</span>
                          </div>
                          <div class="form-group">
                         <span>Attester FullName : {{$roleMovementProfile->attesterProfile->last_name.' '.$roleMovementProfile->attesterProfile->first_name}}</span>
                          </div>
                           <!--Prepare Attestation form -->
                        @role('ZBM')
                        @if($roleMovementProfile->profile->is_attestation_required && ($roleMovementProfile->attester_id==Auth::user()->id) && !$roleMovementProfile->profile->is_attested)
                         <form method="POST" id="attest-form" name="attest-form" class="m-t-10" action ="{{route('role.movement.attest',$roleMovementProfile->id)}}" >
                                      {{csrf_field()}}
                                      <input class="form-control m-t-5" name="attestation_comment" data-validation="required" placeholder="Attester comment" />
                                      <input class="form-control m-t-5" name="kits" data-validation="required" placeholder="Number of Kits" />
                        <button type="submit" class="btn btn-info m-t-10"><i class="fa fa-plus p-r-5"></i>Attest Transfer</button>
                             </form>
                             @endif
                        @endrole
                          @endif
                        </div>
                                <span class="up-speed m-t-20 m-b-10">
                                <!--If move is denied -->
                                @if($roleMovementProfile->is_denied)
                                 Request Denied: {{$roleMovementProfile->profile->denial_comment}}
                                @else
                                <!--Attestation is required -->
                                  @if($roleMovementProfile->profile->is_attestation_required)
<!--Attested, claimed and approved -->
                               @if($roleMovementProfile->profile->is_attested && $roleMovementProfile->is_approved && $roleMovementProfile->is_claimed)
                              Role Movement Approved
                               @else
                               <!-- Not attested -->
@if(!$roleMovementProfile->profile->is_attested)
                               Awaiting Attestation by ZBM
@endif
<!--Attest but not claimed -->
@if($roleMovementProfile->profile->is_attested && !$roleMovementProfile->is_claimed)
                                   Awaiting to be claimed by HR
@endif
<!--Attested, claimed but not approved -->
@if($roleMovementProfile->profile->is_attested && $roleMovementProfile->is_claimed && !$roleMovementProfile->is_approved)
    @if(!$roleMovementProfile->is_denied)
                                   Awaiting Approval
    @else
    Request Denied: {{$roleMovementProfile->profile->denial_comment}}
    @endif
@endif
                                @endif
                                
                                  @else <!--Attestation is not required -->
                                  <!--yet to be claimed by HR -->
                                    @if(!$roleMovementProfile->is_claimed)
                                   Awaiting to be claimed by HR
                               @endif
<!--Claimed && approved -->
                               @if($roleMovementProfile->is_claimed && $roleMovementProfile->is_approved)
                                   Role Movement Approved
                               @endif

                               @if($roleMovementProfile->is_claimed && !$roleMovementProfile->is_approved)
                                       @if(!$roleMovementProfile->is_denied)
                                   Awaiting Approval
    @else
    Request Denied: {{$roleMovementProfile->profile->denial_comment}}
    @endif
                               @endif
                                  @endif
                                  <!--End attestation denial -->
                                  @endif
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="white-box upload-widget">
                            <div class="t-a-c">
                             <div class="white-box upload-widget2">
                            <h3 class="box-title">Role Movement Profile</h3>
                          <div class="form-group">
                        <h4>HR to approve:

                          @if(isset($roleMovementProfile->hr_auuid))
                              @if($roleMovementProfile->hr_auuid==Auth::user()->id)
                              You
                              @else
                                {{$roleMovementProfile->hrProfile->first_name.' '.$roleMovementProfile->hrProfile->last_name}}
                              @endif
                          @endif

                         </h4>
                        <div>Claimed <i class="fa {{($roleMovementProfile->is_claimed == 0 ? 'fa-square-o' : 'fa-check-square-o')}}"></i>
                        <!--Prepare unclaim button -->
                        @role('HR')
                        @if(isset($roleMovementProfile->hr_auuid))
                            @if($roleMovementProfile->hr_auuid==Auth::user()->id && !$roleMovementProfile->is_approved)
                     <a href="{{route('role.movement.profile.action.unclaim',$roleMovementProfile->id)}}"  class="btn btn-primary"><i class="fa fa-minus p-r-5"></i>Undo Claim</a>
                            @endif
                        @else
                    <a href="{{route('role.movement.profile.action.claim',$roleMovementProfile->id)}}" class="btn btn-primary"><i class="fa fa-plus p-r-5"></i>Claim</a>
                        @endif
                        @endrole
                      

                        </div>
                          </div>
                                    <div class="form-group">
            Denied: <span class="label {{($roleMovementProfile->is_denied == 0 ? 'label-success' : 'label-danger')}}">
            @if($roleMovementProfile->is_denied)
                                            <i class="fa fa-check-square-o"> </i>
                                            @else
                                            <i class="fa fa-close"> </i>
                                            @endif 
            </span>
                          </div>
                           <div class="form-group">
            Approved: <span class="label {{($roleMovementProfile->is_approved == 0 ? 'label-danger' : 'label-success')}}">
            @if($roleMovementProfile->is_approved)
                                            <i class="fa fa-check-square-o"> </i>
                                            @else
                                            <i class="fa fa-close"> </i>
                                            @endif
            </span>
            @if(!$roleMovementProfile->is_denied)
                            <!--Prepare approve button -->
                            @role('HR')
                              @if(isset($roleMovementProfile->hr_auuid))
                                @if($roleMovementProfile->hr_auuid==Auth::user()->id && !$roleMovementProfile->is_approved)
                                <!-- approval form -->
                                <form id="approval-form" action="{{route('role.movement.profile.action.approve',$roleMovementProfile->id)}}" method="POST" >
                                {{csrf_field()}}
                                <input class="form-control m-t-10" name="approval_comment" data-validation="required" placeholder="Approval comment" />
             <button id="confirmApproval" type="submit" class="btn btn-warning m-t-10"><i class="fa fa-plus p-r-5"></i>Approve Request</button>
                                      </form>
                                      <!-- denial form -->
                                      <form method="POST" id="denial-form" name="denial-form" class="m-t-10" action ="{{route('role.movement.profile.action.deny',$roleMovementProfile->id)}}" >
                                      {{csrf_field()}}
                                      <input class="form-control" name="denial_comment" data-validation="required" placeholder="Denial comment" />
                        <button type="submit" id="denyRequest" class="btn btn-danger m-t-10"><i class="fa fa-plus p-r-5"></i>Deny Request</button>
                             </form>
                                @endif
                              @endif
                            @endrole
        @else 
        @endif
                          </div>
                 
                              
                        </div>
                            </div>
                        </div>
                    </div>
                </div>
                
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
            $.validate('deny-form');
            */
</script>
    @include('components.action_response')
@endsection