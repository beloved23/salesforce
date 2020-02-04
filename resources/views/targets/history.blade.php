@extends('layouts.master')

@section('pagestyles')
                <link href="{{ asset('css/scrollable.css') }}" rel="stylesheet">
                 <link href="{{asset('css/switch.css')}}" rel="stylesheet" />
                     @include('components.location_show_css')
@endsection

@section('content')
      <!-- Page Content -->
        <div class="page-wrapper" >
            <div class="container-fluid">
                          
<div class="row">
 <div class="col-sm-12">
                        <div class="white-box">
                            <h3 class="box-title m-b-0">Targets assigned</h3>
                              <!-- .left-right-aside-column-->
                            <div class="page-aside">
                                <div class="right-aside">
                                    <div class="right-page-header">
                                      <div class="btn-group">
                                                                <button type="button" class="btn btn-primary dropdown-toggle waves-effect waves-light m-r-5" data-toggle="dropdown" aria-expanded="false"> Filter <b class="caret"></b> </button>
                                                                <ul class="dropdown-menu" role="menu">
                                                                <li><a href="{{route('targetsprofile.filter.uncompleted')}}">Uncompleted Targets</a></li>
                                                                <li><a href="{{route('targetsprofile.filter.completed')}}">Completed Targets</a></li>
                                                                <li><a href="{{route('targetsprofile.filter.thisMonth')}}">This Month</a></li>
                                                                <li><a href="{{route('targetsprofile.filter.lastMonth')}}">Last Month</a></li>
                                                                <li><a href="{{route('targetsprofile.filter.thisYear')}}">This Year</a></li>
                                                                </ul>
                                                            </div>
                                                            </div>
                                                            </div>
                                                            </div>
                            <div id="assignedTargets" class="table-responsive">
                                <table id="example23" class="display nowrap" cellspacing="0" width="100%">
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
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                          <th>Tag</th>
                                            <th>Owner</th>
                                            <th>Assigned To</th>
                                            <th>Gross Ads</th>
                                              <th>Decrement</th>
                                            <th>Kit</th>
                                            <th>Status</th>
                                            <th>Date </th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                    @foreach($assignedTargets as $item)
                                        <tr>
                                            <td>{{$item->target->tag}}</td>
                                      @if(isset( $item->target->ownerProfile))
                                           <td>
                                {{$item->target->ownerProfile->first_name." ".$item->target->ownerProfile->last_name}}
                                           ({{$item->target->ownerProfile->user->auuid}})
                                           </td>
                                      @else
                                           <td>N/A</td>
                                      @endif
                        <td>{{$item->assigneeProfile->first_name.' '.$item->assigneeProfile->last_name}}  ({{$item->assigneeProfile->user->auuid}})</td>
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
                                        <td>{{QuickTaskFacade::toFormattedDateString($item->created_at)}}</td>
                                        </tr>
                                    @endforeach
                                          </tbody>
                                </table>
                                <div>{{$assignedTargets->links()}}</div>
                            </div>
                        </div>
                    </div></div>

        </div>
        </div>
@endsection


@section('pagejs')
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
                    $('#example23_paginate').css('display','none');
</script>
               @include('components.action_response')
@endsection