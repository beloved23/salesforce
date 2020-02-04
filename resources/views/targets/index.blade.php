@extends('layouts.master')

@section('pagestyles')
                <link href="{{ asset('css/scrollable.css') }}" rel="stylesheet">
                 <link href="{{asset('css/switch.css')}}" rel="stylesheet" />     
                    <link href="{{asset('css/select2.min.css')}}" rel="stylesheet">
                     @include('components.location_show_css')
@endsection

@section('content')
      <!-- Page Content -->
        <div class="page-wrapper" data-ng-controller="SetTargetController">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-8">
                        <div class="white-box">
                            <div class="task-widget2">
                                <div class="task-image">
                                    <img src="{{asset('images/task.jpg')}}" alt="task" class="img-responsive">
                                    <div class="task-image-overlay"></div>
                                    <div class="task-detail">
                                        <h2 class="font-light text-white m-b-0">{{$date}}</h2>
                                    </div>
                                </div>
                                <br />
                                 <div class="col-md-12">
                        <div class="white-box user-table">
                            <div class="row">
                                <div class="col-sm-6">
                                    <h4 class="box-title">My Targets</h4>
                                </div>
                                <div class="col-sm-6">
                                    <ul class="list-inline">
                                        <li>
                                            <a href="javascript:void(0);" class="btn btn-default btn-outline font-16"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" class="btn btn-default btn-outline font-16"><i class="fa fa-commenting" aria-hidden="true"></i></a>
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
                            <div class="table-responsive" id="targetsScroll">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Tag</th>
                                            <th>Gross Ads</th>
                                            <th>Decrement</th>
                                            <th>Kit</th>
                                             <th>Assigned To</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr data-ng-repeat="target in targets">
                                            <td><a href="javascript:void(0);" class="text-link">@{{target.tag}}</a></td>
                                            <td><span class="label label-warning">@{{target.gross_ads}}</span></td>
                                            <td>@{{target.decrement}}</td>
                                            <td><span class="label label-success">@{{target.kit}}</span></td>
                                             <td>@{{target.profile_count}}</td>
                                                <td>
                                               <span title="assign target" data-ng-click="retrieveDownlines($index)"  class="cursor-pointer"><i class="icon-user-follow"></i></span>
                                            <a title="view target profile" href="{{route('targetsprofile.index')}}/@{{target.id}}"><span class="p-10 cursor-pointer" ><i class="fa fa-television"></i></span></a>
                                             <span data-toggle="modal" title="modify target" data-target="#modify-target" data-ng-click="currentTargetToModify($index)" class="p-10 cursor-pointer"><i class="fa fa-edit"></i></span>
                                            <span title="delete target" data-ng-click="destroyTarget($index)" class="cursor-pointer"><i class="fa fa-trash-o"></i></span>
                                            </td>
                                           
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <a href="javascript:void(0);" data-target="#create-target" data-toggle="modal" class="btn btn-success pull-right m-t-10 font-20">+</a>
                        </div>
                    </div>
                                <div class="task-loadmore">
                                    <a href="javascript:void(0);" data-ng-click="loadMoreTargets()" class="btn btn-default btn-outline btn-rounded">Load More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @role('HQ')
                      <div class="col-md-4 col-sm-12">
                <div class="white-box " style="height:500px;">
                                                           <div class="col-md-12">
                                                <div class="m-b-20">
                                                <h4 class="box-title text-center">Assign Target</h4> 
                                                <div> <span data-ng-show="showAssignTargetButton" class="label label-info">@{{currentTargetTag}} </span> <span data-ng-show="!showAssignTargetButton" class="label label-warning pull-right">select a target</span></div>
                                                </div>
                                                <div class="clearfix"></div>
                                                  <div class="form-group">
                            @verbatim      
                            <div data-ng-show="showAssignTarget" >     
                        <label for="recipient-name" class="control-label">Assign to specific downlines</label>                
                                     <select id="usersListForSelection" multiple  data-ng-model="selectedDownlines" class="width-full" data-placeholder="Search for user via auuid or email">
                              <option value="VL" >Hello</option>
                                </select>
                                    </div>
                            @endverbatim 
                            <br />
                    <button data-ng-click="assignTarget()" data-ng-show="showAssignTargetButton" class="btn btn-warning waves-effect waves-light btn-block btn-bg">Assign Target</button>
                                                    </div>
                                                    </div>
                                                    </div>
                                                    </div>
                 
                    @else
                <div class="col-md-4 col-sm-12">
                <div class="white-box">
                                                           <div class="col-md-12">
                                                <div class="m-b-20">
                                                <h4 class="box-title text-center">Assign Target</h4> 
                                                <div> <span data-ng-show="showAssignTargetButton" class="label label-info">@{{currentTargetTag}} </span> <span data-ng-show="!showAssignTargetButton" class="label label-warning pull-right">select a target</span></div>
                                                </div>
                                                <div class="clearfix"></div>
                                                      <div class="form-group">
                                          <input type="checkbox" checked id="js-switch"  data-color="#6164c1" />
                                          <span class="m-l-30">Assign target to me</span>
                                                    </div>
                                                     <div class="form-group">
                                          @role("ROD")
                                        <input type="checkbox" checked id="assignToAll" data-color="#99d683" />
                                          <span class="m-l-30" >Cascade target to all my ZBM</span>
                                          @endrole
                                          @role("ZBM")
                                        <input type="checkbox" checked id="assignToAll" data-color="#99d683" />
                                    <span class="m-l-30" >Cascade target to all my ASM</span>

                                          @endrole
                                          @role("ASM")
                                        <input type="checkbox" checked id="assignToAll" data-color="#99d683" />
                                          <span class="m-l-30" >Cascade target to all my MD</span>

                                          @endrole

                                                    </div>
                                            </div>
                                            @if(Auth::user()->hasRole('ROD') || Auth::user()->hasRole('ZBM') || Auth::user()->hasRole('ASM'))
                                             <div class="form-group">
                            @verbatim      
                            <div data-ng-show="showAssignTarget" >     
                        <label for="recipient-name" class="control-label">Assign to specific downlines</label>                
                           <select class="selectpicker" data-ng-model='selectedDownlines' multiple="multiple"  style="width:100%"  data-style="form-control">
                                        <option value="{{downline.user.id}}" data-ng-repeat="downline in downlineList">AUUID: {{downline.auuid}} Email: {{downline.user.email}}</option>
                                    </select>
                                    </div>
                            @endverbatim 
                                                    </div>
                                                    @endif

                                     <button data-ng-click="assignTarget()" data-ng-show="showAssignTargetButton" class="btn btn-warning waves-effect waves-light btn-block btn-bg">Assign Target</button>
                        
                          <h4 class="box-title">Targets Assigned To Me</h4>
                            <div class="task-widget t-a-c">
                                <div class="task-chart" id="sparklinedashdb"></div>
                                <div class="task-content font-16 t-a-c">
                                    <div class="col-sm-6 b-r">
                                        This Month
                                        <h1 class="text-primary">{{$targetsThisMonth}} <span class="font-16 text-muted">Target(s)</span></h1>
                                    </div>
                                    <div class="col-sm-6">
                                       Uncompleted 
                                        <h1 class="text-primary">{{$uncompletedTargets}} <span class="font-16 text-muted">Target(s)</span></h1>
                                    </div>  
                                </div>
                                <div class="task-assign font-16">
                                    Assigned By
                                    <ul class="list-inline">
                                   @if(count($targetsPicture) < 4)
                                       @foreach($targetsPicture as $pic)
                                           <li class="p-l-0">
                                            <img height="40" width="80" style="height:40px;" src="{{asset('storage')}}/{{$pic->profile_picture}}"  alt="user" data-toggle="tooltip" data-placement="top" title="" data-original-title="{{$pic->first_name}} {{$pic->last_name}}">
                                        </li> 
                                       @endforeach
                                   @else
                                       @for($i = 0; $i < 4; $i++)
                                        <li>
                                            <img src="../plugins/images/users/2.png" alt="user" data-toggle="tooltip" data-placement="top" title="" data-original-title="Steave">
                                        </li>
                                       @endfor
                                       <li class="p-r-0">
                                            <a href="javascript:void(0);" class="btn btn-success font-16">{{count($targetsPicture)-3}}</a>
                                        </li>
                                   @endif
                                        
                                    </ul>
                                </div>
                            </div>
                              </div>
                    </div>
                    @endif
                </div>
<!--Modals -->
<!-- Create Target -->
  <div id="create-target" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            <h4 class="modal-title">Create Target</h4>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{route('targets.store')}}" name="create-target" method="POST" >
                                            {{csrf_field()}}
                                            <div class="col-md-6">
                                             <div class="form-group">
                                                    <label for="recipient-name" class="control-label">Tag</label>
                                                    <input type="text" name="tag" data-validation="required" class="form-control"> 
                                                    </div>
                                                      <div class="form-group">
                                                    <label for="recipient-name" class="control-label">Decrement</label>
                                                    <input type="text" name="decrement" data-validation="only_number" class="form-control"> 
                                                    </div>
                                            </div>
                                               <div class="col-md-6">
                                             <div class="form-group">
                                                    <label for="recipient-name" class="control-label">Gross Ads</label>
                                                    <input type="text" name="gross_ads" data-validation="only_number" class="form-control" > 
                                                    </div>
                                                      <div class="form-group">
                                                    <label for="recipient-name" class="control-label">Kit</label>
                                                    <input type="text" name="kit" data-validation="only_number" class="form-control"> 
                                                    </div>
                                            </div>
                                     <button type="submit" class="btn btn-danger waves-effect waves-light btn-block btn-bg">Create Target</button>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
<!--Modify Target -->
 <div id="modify-target" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            <h4 class="modal-title">Modify Target</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="col-md-6">
                                             <div class="form-group">
                                                    <label for="recipient-name" class="control-label">Tag</label>
                                                    <input type="text" name="tag" data-ng-model="modifyTag" data-validation="required" class="form-control"> 
                                                    </div>
                                                      <div class="form-group">
                                                    <label for="recipient-name" class="control-label">Decrement</label>
                                                    <input type="text" name="decrement" data-ng-model="modifyDecrement" data-validation="only_number" class="form-control"> 
                                                    </div>
                                            </div>
                                               <div class="col-md-6">
                                             <div class="form-group">
                                                    <label for="recipient-name" class="control-label">Gross Ads</label>
                                                    <input type="text" name="gross_ads" data-ng-model="modifyGrossAds" data-validation="only_number" class="form-control" > 
                                                    </div>
                                                      <div class="form-group">
                                                    <label for="recipient-name" class="control-label">Kit</label>
                                                    <input type="text" name="kit" data-ng-model="modifyKit" data-validation="only_number" class="form-control"> 
                                                    </div>
                                            </div>
                                     <button data-ng-click="modifyTarget()" class="btn btn-warning waves-effect waves-light btn-block btn-bg">Modify Target</button>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
<div class="row">
 <div class="col-sm-12">
                        <div class="white-box">
                            <h3 class="box-title m-b-0">Targets assigned to me</h3>
                            <div id="assignedTargets" class="table-responsive">
                                <table id="example23" class="display nowrap" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Tag</th>
                                            <th>Owner</th>
                                            <th>Gross Ads</th>
                                              <th>Decrement</th>
                                            <th>Kit</th>
                                            <th>Status</th>
                                            <th >Action</th>
                                            <th>Date </th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                          <th>Tag</th>
                                            <th>Owner</th>
                                            <th>Gross Ads</th>
                                              <th>Decrement</th>
                                            <th>Kit</th>
                                            <th>Status</th>
                                            <th >Action</th>
                                            <th>Date </th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                    @foreach($assignedTargets as $item)
                                        <tr>
                                            <td>{{$item->target->tag}}</td>
                                      @if(isset( $item->target->ownerProfile))
                                           <td>
                                           @if($item->target->user_id==Auth::user()->id)
                                           You
                                           @else
                                {{$item->target->ownerProfile->first_name." ".$item->target->ownerProfile->last_name}}
                                           @endif
                                           </td>
                                      @else
                                           <td>N/A</td>
                                      @endif
                                            <td>{{$item->gross_ads}}</td>
                                            <td>{{$item->decrement}}</td>
                                            <td>{{$item->kit}}</td>
                                            <td>
                                            @if(!$item->completed)
                                           <span class="label label-danger"> Uncompleted</span>
                                            @else
                                          <span class="label label-success">  Completed </span>
                                            @endif
                                            </td>
                                            <td >
                                            <span data-ng-click="markAsCompleted({{$item->id}})" data-toggle="tooltip" data-title="Mark as accomplished" class="p-10 tooltip-danger cursor-pointer"><i class="fa fa-check"></i></span>
                                            </td>
                                            <td>{{$item->datetime}}</td>
                                        </tr>
                                    @endforeach
                                          </tbody>
                                </table>
                            </div>
                        </div>
                    </div></div>

        </div>
        </div>
@endsection


@section('pagejs')
<script src="{{asset('js/controllers/set.target.js')}}"></script>
<script src="{{asset('js/jquery.form-validator.js')}}"></script>
  <script src="{{asset('js/switch.js')}}"></script>
               <script src="{{asset('js/select2.min.js')}}"></script>
  @include('components.location_show')
<script>
  $('#targetsScroll').slimScroll({
    height: '350px'
});
 $.formUtils.addValidator({
  name : 'only_number',
  validatorFunction : function(value, $el, config, language, $form) {
    return /^\d+$/.test(value);
  },
  errorMessage : 'Only numbers are allowed',
  errorMessageKey: 'enterNumber'
});
$.validate();

                     $('.downline-list').select2();
                    $('.selectpicker').select2();
</script>
               @include('components.action_response')
                @include('components.select2_users')
@endsection