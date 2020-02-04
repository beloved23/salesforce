
@extends('layouts.master')

@section('pagestyles')
           <link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet">
        <link href="{{asset('css/select2.min.css')}}" rel="stylesheet">
@endsection

@section('content')
      <!-- Page Content -->
        <div class="page-wrapper" data-ng-controller="LocationMovementController">
            <div class="container-fluid">
                 <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="white-box comment-widget">
                        <form action="{{route('location.movement.store')}}" id='create-request' method="POST">
                        {{csrf_field()}}
                            <h4 class="box-title">Create a Location Transfer Request</h4>
                            <br />
                            <div class="form-group">
                            <div><h4 class="box-title">Select Resource Role</h4></div>
                            <div class="col-lg-10 col-md-10 col-sm-12">
                            <select name="role" required data-ng-change="changeResourceRole()" data-ng-model="selectedResourceRole" class="select2 form-control" data-style="form-control">
                                    @role('ROD')
                                     <option value="ZBM">ZBM</option>
                                    @endrole
                                     @hasanyrole('ROD|ZBM')
                                    <option value="ASM">ASM</option>
                                    <option value="MD">MD</option>
                                    @endhasanyrole
                                    @role('ASM')
                                    <option value="MD">MD</option>
                                    @endrole
                                    </select>
                                </div>
                            </div>
                            <br />
                         <br />
                                @verbatim
                                <div data-ng-show="showResourceList"  class="form-group">
                                        <div><h4 class="box-title">{{showResourceListBanner}}</h4></div>
                                        <div class="col-lg-10 col-md-10 col-sm-12">
        <select name="selectedUser" required data-ng-model="selectedResource" class="select2 form-control"  data-style="form-control">
                <option data-ng-repeat ="resource in resourceList" value="{{resource.user_id}}"> Auuid: {{resource.auuid}} Email: {{resource.user.email}}</option>
                    </select>
                </div>
                 </div>
                                @endverbatim
                               <br />
                                @verbatim
                                <div data-ng-show="showLocationList" class="form-group">
                                        <div><h4 class="box-title">Select Desired {{locationModel}}</h4></div>
                                        <div class="col-lg-10 col-md-10 col-sm-12">
                                       
                                        <select name="selectedLocationId" required class="select2 form-control" data-style="form-control">
                                                <option data-ng-repeat ="item in locationList" value="{{item.id}}">{{item.name}}</option>
                                                </select>
                                      
                                            </div>
                                </div>
                                @endverbatim
                                <br />
                         <div data-ng-show="showResourceList" class="form-group">
                        <h4 class="box-title">Request Comment</h4>
                        <div class="col-lg-12 col-md-12 col-sm-12">
<input data-ng-model="requestComment" data-validation="required" name="comment" type="text" required class="form-control" placeholder="Type a comment">
                         </div>
                        </div>
                        <br />
                         <div data-ng-show="showResourceList" class="form-group">
                        <button type="submit" class="btn btn-warning btn-block btn-lg m-t-20">Submit Request</button>
                         </div>
                          </form>
                        </div>
                    </div>
                    {{--  <div class="col-md-4 col-sm-12">
                        <div class="white-box">
                            <div class="profile-widget">
                            <h4>Location Movement Profile </h4>
                                <div class="profile-img clearfix">
                                @role('ROD')
                                @else
                                    <img src="@{{resourcePicture}}" style="width:80px;height:80px;" alt="user-img" class="img-circle">
                                @endrole
                                    <p class="m-t-10 m-b-5">
                                    <a href="javascript:void(0);" class="profile-text font-22 font-semibold">
                                        @role('ROD')
                                        Country : 
                                        @endrole
                                        @role('ZBM')
                                        ROD :
                                        @endrole
                                        @role('ASM')
                                        ZBM :
                                        @endrole
                                        @role('MD')
                                        ASM :
                                        @endrole
                                    @{{uplineFullName}}
                                    </a></p>
                                    <span class="font-16">@{{selectedResourceRole}}</span>
                                </div>
                                <div class="profile-info">
                                    <div class="col-xs-6 col-md-6 b-r">
                                        <h3 class="text-primary">Attester</h3>
                                        <span class="font-16">@{{attester}}</span>
                                    </div>
                                    <div class="col-xs-6 col-md-6">
                                        <h3 class="text-primary font-16">Desired Location</h3>
                                        <span class="font-16">@{{locationName}}</span>
                                    </div>
                                </div>
                                <div class="profile-detail font-15">
                                    <p>
                                    @{{comment}}
                                    </p>
                                </div>
                                <div class="profile-btn">
                                @role('ROD')
                                @else
                                    <a href="{{route('inbox.create')}}" data-ng-show="showResourceList" class="btn btn-success">Message Upline</a>
                                @endrole
                                </div>
                            </div>
                        </div>
                    </div>  --}}
                </div>
             </div></div>
@endsection
@section('pagejs')
    <script src="{{asset('js/controllers/location.movement.js')}}"></script>
       <script src="{{asset('js/bootstrap-select.min.js')}}"></script>
             <script src="{{asset('js/select2.min.js')}}"></script>
            <script src="{{asset('js/jquery.form-validator.js')}}"></script>
    <script>
        $('#locationListForSelection').select2();
        $('.select2').select2();
        $.validate();
    </script>
    @include('components.action_response')
@endsection