@extends('layouts.master')

@section('pagestyles')
                <link href="{{ asset('css/scrollable.css') }}" rel="stylesheet">
                 <link href="{{asset('css/switch.css')}}" rel="stylesheet" />
                     @include('components.location_show_css')
@endsection

@section('content')
      <!-- Page Content -->
        <div class="page-wrapper" data-ng-controller="TargetProfileController">
            <div class="container-fluid">
            <div class="row">
                    <div class="col-md-12">
                        <div class="white-box">
                  <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Tag</th>
                                            <th>Gross Ads</th>
                                            <th>Decrement</th>
                                            <th>Kit</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <td>{{$target->tag}}</td>
                                        <td>{{$target->gross_ads}}</td>
                                        <td>{{$target->decrement}}</td>
                                        <td>{{$target->kit}}</td>
                                    </tbody>
                                    </table>
                                    </div>
                                    </div>
                                    </div>
                                    </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="white-box">
                            <div class="task-widget2">
                                <br />
                                 <div class="col-md-12">
                        <div class="white-box user-table">
                            <div class="row">
                                <div class="col-sm-6">
                                    <h4 class="box-title">Target Profile Cascaded to Users</h4>
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
                                            <th>Owner</th>
                                            <th>Assigned To</th>
                                            <th>Gross Ads</th>
                                            <th>Decrement</th>
                                            <th>Kit</th>
                                            <th>Status</th>
                                            <th>Date </th>
                                            <th >Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($targetProfiles as $item)
                                           <tr>
                                            <td><a href="javascript:void(0);" class="text-link">{{$item->target->tag}}</a></td>
                                            <td><a href="javascript:void(0);">{{$item->target->ownerProfile->first_name.' '.$item->target->ownerProfile->last_name}} ({{$item->target->ownerProfile->user->auuid}})</a></td>
                                            <td><a href="javascript:void(0);">{{$item->assigneeProfile->first_name.' '.$item->assigneeProfile->last_name}}  ({{$item->assigneeProfile->user->auuid}})</a></td>
                                            <td><span class="label label-warning">{{$item->gross_ads}}</span></td>
                                            <td>{{$item->decrement}}</td>
                                            <td><span class="label label-success">{{$item->kit}}</span></td>
                                            <td>
                                            @if(!$item->completed)
                                            <span class="label label-danger">Uncompleted</span>
                                            @else
                                            <span class="label label-success">Completed</span>
                                            @endif
                                            </td>
                                        <td>{{QuickTaskFacade::toFormattedDateString($item->created_at)}}</td>
                                        <td>
                                            <span data-ng-click="markAsCompleted({{$item->id}})" data-toggle="tooltip" data-original-title="Mark as completed" class="p-10 cursor-pointer tooltip-info" ><i class="fa fa-check"></i></span>
                                            </td>
                                           
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                                <div class="task-loadmore">
                                    <a href="javascript:void(0);" class="btn btn-default btn-outline btn-rounded">{{$targetProfiles->links()}}</a>
                                </div>
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
        </div>
        </div>
@endsection


@section('pagejs')
<script src="{{asset('js/controllers/target.profile.js')}}"></script>
<script src="{{asset('js/jquery.form-validator.js')}}"></script>
  <script src="{{asset('js/switch.js')}}"></script>
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
@endsection