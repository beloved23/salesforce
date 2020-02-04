
@extends('layouts.master')

@section('pagestyles')
           <link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet">
        <link href="{{asset('css/select2.min.css')}}" rel="stylesheet">
@endsection

@section('content')
      <!-- Page Content -->
        <div class="page-wrapper" data-ng-controller="RoleMovementController">
            <div class="container-fluid">
                 <div class="row">
                    <div class="col-md-8 col-sm-12">
                        <div class="white-box comment-widget">
                            <h4 class="box-title">Create a Role Movement Request</h4>
                            <br />
                         <div class="form-group">
                         <!-- Show all profiles for HR -->
                         <h4 class="box-title">Select Resource Role</h4>
                             <select data-ng-change="changeResourceRole()" id="profileListForSelection" data-ng-model="selectedResourceRole" class="width-full" data-style="form-control">
                            @if(Auth::user()->hasRole('HR') || Auth::user()->hasRole('ROD') || Auth::user()->hasRole('ZBM'))
                             <option value="ZBM">ZBM</option>
                            <option value="ASM">ASM</option>
                            <option value="MD">MD</option>
                            @endif
                             @role('ASM')
                            <option value="ASM">ASM</option>
                            <option value="MD">MD</option>
                            @endrole
                            @role('MD')
                            <option value="MD">MD</option>
                            @endrole
                            </select>
                         </div>
                          @verbatim
                         <div data-ng-show="showResourceList"  class="form-group">
                                                <h4 class="box-title">{{showResourceListBanner}}</h4>
                <select id="userListForSelection" data-ng-model="selectedResourceIndex" data-ng-change="onChangeResource()" class="width-full"  data-style="form-control">
                        <option data-ng-repeat ="resource in resourceList" value="{{$index}}">Auuid: {{resource.auuid}} Email: {{resource.user.email}}</option>
                            </select>
                         </div>
                         <div data-ng-show="showResourceList" class="form-group" >
                         <h4 class="box-title">Destination Role</h4>
                        <select id="destinationRole" data-ng-model="destinationRole" data-ng-change="onChangeDestinationRole()" class="width-full" data-style="form-control">
                         <option data-ng-repeat="destination in destinationRoleList" value="{{destination.name}}">{{destination.name}}</option>
                        </select>
                         </div>
                          <div data-ng-show="showDestinationLocationProfile" class="form-group" >
                         <h4 class="box-title">{{destinationLocationTitle}}</h4>
                        <select id="destinationLocation" data-ng-model="destinationLocation" class="width-full" data-style="form-control">
                         <option data-ng-repeat="location in vacantLocationList" value="{{location.id}}">{{location.name}}</option>
                        </select>
                         </div>
                         <div data-ng-show="showResourceList" class="form-group">
                        <a href="javascript:void(0);" data-ng-click="sendRequestToServer()" class="btn btn-warning btn-block btn-lg">Submit Request</a>
                         </div>
                          @endverbatim
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <div class="white-box">
                            <div class="profile-widget">
                            <h4>Resource Profile <span data-ng-show="!showResourceList" class="label label-info pull-right" >please select a user first</span></h4>
                                <div class="profile-img clearfix">
                                    <img src="@{{resourcePicture}}" style="width:80px;height:80px;" alt="user-img" class="img-circle">
                                    <p class="m-t-10 m-b-5"><a href="javascript:void(0);" class="profile-text font-22 font-semibold">@{{resourceFullName}}</a></p>
                                    <span class="font-16">@{{selectedResourceRole}}</span>
                                </div>
                                <div class="profile-info">
                                    <div class="col-xs-6 col-md-6 b-r">
                                        <h3 class="text-primary">Attester</h3>
                                        <span class="font-16">@{{attester}}</span>
                                    </div>
                                    <div class="col-xs-6 col-md-6">
                                        <h3 class="text-primary font-16">Destination Role</h3>
                                        <span class="font-16">@{{destinationRole}}</span>
                                    </div>
                                </div>
                                <div class="profile-detail font-15">
                                    <p>
                                    @{{comment}}
                                    </p>
                                </div>
                                <div class="profile-btn">
                                    <a href="{{route('inbox.create')}}" class="btn btn-success">Message Resource</a>
                                    <a href="javascript:void(0);" data-ng-click="sendRequestToServer()" data-ng-show="showResourceList" class="btn btn-default btn-outline m-r-0">Submit Request</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
             </div></div>
@endsection

@section('pagejs')
    <script src="{{asset('js/controllers/role.movement.js')}}"></script>
       <script src="{{asset('js/bootstrap-select.min.js')}}"></script>
             <script src="{{asset('js/select2.min.js')}}"></script>
    <script>
        $('#profileListForSelection').select2();
        $('#userListForSelection').select2(); 
        $('#destinationRole').select2();
        $('#destinationLocation').select2();
    </script>
@endsection