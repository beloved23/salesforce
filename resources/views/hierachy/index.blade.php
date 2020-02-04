@extends('layouts.master')


@section('pagestyles')
       <link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet">
        <link href="{{asset('css/select2.min.css')}}" rel="stylesheet">
@endsection

 @section('content')
    <!-- Page Content -->
        <div class="page-wrapper" data-ng-controller="HierachyRelationshipController">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-3 col-sm-3 col-xs-12">
                        <div class="white-box analytics-info">
                            <h3 class="box-title">Total ROD</h3>
                            <ul class="list-inline two-part">
                                <li>
                                    <div id="sparklinedash"></div>
                                </li>
                                <li class="text-right"><i class="ti-arrow-up text-success"></i> <span class="counter text-success">@{{rodCount}}</span></li>
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
                                <li class="text-right"><i class="ti-arrow-up text-purple"></i> <span class="counter text-purple">@{{zbmCount}}</span></li>
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
                                <li class="text-right"><i class="ti-arrow-up text-info"></i> <span class="counter text-info">@{{asmCount}}</span></li>
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
                                <li class="text-right"><i class="ti-arrow-down text-danger"></i> <span class="text-danger">@{{mdCount}}</span></li>
                            </ul>
                        </div>
                    </div>
                </div>

 <div class="row">
    <div class="col-md-6">
                        <div class="white-box">
                            <h3 class="box-title m-b-0">Define Hierachy Relationships</h3>
                            <div class="row">
                                                            <div class="col-sm-12 col-xs-12">
                                                        <p class="text-muted m-b-10 font-13">Select Profile</p>
                                        <select data-ng-change="changeProfile()" id="profileListForSelection" data-ng-model="selectedProfile" class="form-control" data-style="form-control">
                                        <option value="ROD">ROD</option>
                                        <option value="ZBM">ZBM</option>
                                        <option value="ASM">ASM</option>
                                        <option value="MD">MD</option>
                                    </select>
                                    </div>
                                             <div class="col-sm-12 col-xs-12">
                                             <p class="text-muted m-b-10 font-13">Select Users</p>
                                     @verbatim      
 <select id="usersListForSelection" data-ng-model="selectedUsers" class="form-control" multiple="multiple" data-placeholder="Search for user via auuid or email">
                                    <option data-ng-repeat="user in chooseUsers" value="{{user.id}}">ID: {{user.id}} Email: {{user.email}}</option>
                            </select>
                            @endverbatim 
                                    </div>

                                     @verbatim
                                <div class="col-sm-12 col-xs-12">
                                        <!--Select ROD -->
                                        <div data-ng-show="showRodList" class="form-group m-t-15">
                                    <h4 class="box-title">Select ROD</h4>
 <select class="location-geography form-control" data-ng-model="selectedRod" data-style="form-control">
                                        <option data-ng-repeat ="rod  in rodList" value="{{rod.auuid}}">ID: {{rod.auuid}} Email: {{rod.user.email}}</option>
                                    </select>                                        
                                          </div>
                                                  <div data-ng-show="showRegionList" class="form-group">
                                 <h4 class="box-title">Select Region</h4>
                                   
                                <select class="location-geography form-control" data-ng-model="selectedRegion" data-style="form-control">
                                        <option data-ng-repeat="region in regionList" value="{{region.id}}">{{region.name}}</option>
                                    </select>
                                    </div>
                                        <!--Select ZBM -->
                                        <div data-ng-show="showZbmList" class="form-group">
                                    <h4 class="box-title">Select ZBM</h4>
                                        <select class="location-geography form-control" data-ng-model="selectedZbm" data-style="form-control">
                                        <option data-ng-repeat ="zbm  in zbmList" value="{{zbm.auuid}}">ID: {{zbm.auuid}} Email: {{zbm.user.email}}</option>
                                    </select> 
                                            </div>
                                              <div data-ng-show="showStateList" class="form-group">
                                 <h4 class="box-title">Select State</h4>
                                   
                                <select class="location-geography form-control" data-ng-model="selectedState" data-style="form-control">
                                        <option data-ng-repeat="state in stateList" value="{{state.id}}">{{state.name}}</option>
                                    </select>
                                    </div>
                                             <div data-ng-show="showZoneList" class="form-group">
                                    <h4 class="box-title">Select Zone</h4>
                                         <select class="location-geography form-control" data-ng-model="selectedZone" data-style="form-control">
                                        <option data-ng-repeat ="zone  in zoneList" value="{{zone.id}}">{{zone.name}}</option>
                                    </select>
                                  
                                    </div>
                                       <div data-ng-show="showAreaList" class="form-group">
                                 <h4 class="box-title">Select Area</h4>
                                   
                                <select class="location-geography form-control" data-ng-model="selectedArea" data-style="form-control">
                                        <option data-ng-repeat="area in areaList" value="{{area.id}}">{{area.name}}</option>
                                    </select>
                                    </div>
 <!--Select ASM -->
                                        <div data-ng-show="showAsmList" class="form-group">
                                    <h4 class="box-title">Select ASM</h4>
                                        <select class="location-geography form-control" data-ng-model="selectedAsm" data-style="form-control">
                                        <option data-ng-repeat ="asm in asmList" value="{{asm.auuid}}">ID: {{asm.auuid}} Email: {{asm.user.email}}</option>
                                    </select> 
                                            </div>

                                        <!--Select Territory-->
                                        <div data-ng-show="showTerritoryList" class="form-group">
                                      <h4 class="box-title">Select Territory</h4>
                                    <select class="location-geography form-control" data-ng-model="selectedTerritory" data-style="form-control">
                                        <option data-ng-repeat="territory in territoryList" value="{{territory.id}}">{{territory.name}}</option>
                                    </select>
                                            </div>
                                             <div class="col-md-12 m-t-20">
            <button type="submit" data-ng-click="createRelationship()" class="btn btn-success waves-effect btn-block waves-light m-r-10">Create Relationship</button>
                                             </div>
                                </div>
                                  @endverbatim
                            </div>
                        </div>
                    </div>
                       <div class="col-md-6 col-sm-12">
                        <div class="white-box">
                            <h4 class="box-title">Task Progress</h4>
                            <div class="task-widget t-a-c">
                                <div class="task-chart" id="sparklinedashdb"></div>
                                <div class="task-content font-16 t-a-c">
                                    <div class="col-sm-6 b-r">
                                        Urgent Tasks
                                        <h1 class="text-primary">05 <span class="font-16 text-muted">Tasks</span></h1>
                                    </div>
                                    <div class="col-sm-6">
                                        Normal Tasks
                                        <h1 class="text-primary">03 <span class="font-16 text-muted">Tasks</span></h1>
                                    </div>
                                </div>
                                <div class="task-assign font-16">
                                    Assigned To
                                    <ul class="list-inline">
                                        <li class="p-l-0">
                                            <img src="{{asset('images/users/1.png')}}" alt="user" data-toggle="tooltip" data-placement="top" title="" data-original-title="Steave">
                                        </li>
                                        <li>
                                            <img src="{{asset('images/users/2.png')}}" alt="user" data-toggle="tooltip" data-placement="top" title="" data-original-title="Steave">
                                        </li>
                                        <li>
                                            <img src="{{asset('images/users/3.png')}}" alt="user" data-toggle="tooltip" data-placement="top" title="" data-original-title="Steave">
                                        </li>
                                        <li class="p-r-0">
                                            <a href="javascript:void(0);" class="btn btn-success font-16">3+</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
 </div>

                </div>
                </div>
{{--  End Page content  --}} 
 @endsection
 
  @section('pagejs')
  <script src="{{asset('js/controllers/hierachy.relationship.js')}}"></script>
       <script src="{{asset('js/bootstrap-select.min.js')}}"></script>
             <script src="{{asset('js/select2.min.js')}}"></script>
             <script>
                 $('#profileListForSelection').select2();
                 $('.location-geography').select2();
             </script>
            @include('components.select2_users')
  @endsection