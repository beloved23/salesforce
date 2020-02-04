@extends('layouts.master')

@section('pagestyles')
    <link href="{{ asset('css/all.css') }}" rel="stylesheet">
        <link href="{{ asset('css/scrollable.css') }}" rel="stylesheet">
        <link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet">
                <link href="{{asset('css/select2.min.css')}}" rel="stylesheet">
@endsection

@section('content')
      <!-- Page Content -->
        <div class="page-wrapper">
            <div class="container-fluid">
                <!--.row-->
                <div data-ng-controller="CreateUserController" class="row">
                    <div class="col-md-6">
                        <div class="white-box">
                            <h3 class="box-title m-b-0">Account Creation Form</h3>
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <form id="create-form" name="create-form" method="post" action="{{route('users.store')}}">
                                    {{csrf_field()}}
                                        <div class="form-group">
                                        <label for="exampleInputuname">Auuid</label>
                                            <div id="auuid-input-group" class="input-group">
                                                <div class="input-group-addon"><i class="ti-user"></i></div>
                                                <input data-ng-model="auuid" data-ng-keyup="auuidKeyUp($event)" data-validation="required" name="auuid" type="text" required class="form-control" id="" placeholder="Auuid">
                                                 </div>
                                                  <span id="auuid-error" class="hidden font-red">Error</span>
                                        <div class="form-group">
                                           <label for="exampleInputuname">Msisdn</label>
                                            <div id="auuid-input-group" class="input-group">
                                                <div class="input-group-addon"><i class="ti-user"></i></div>
                                                <input data-validation="required" name="msisdn" type="text" required class="form-control" id="" placeholder="Msisdn">
                                                 </div>
                                                  <span id="auuid-error" class="hidden font-red">Error</span>
                                        </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Email address</label>
                                            <div class="input-group">
                                                <div class="input-group-addon"><i class="ti-email"></i></div>
                                                <input data-ng-model="email" name="email" type="email" data-validation="email" required class="form-control" id="exampleInputEmail1" placeholder="Enter email"> </div>
                                        </div>
                                        {{--  <div class="form-group m-b-10">
                                        <div class="col-md-6">
                                        <label for="exampleInputpwd1">Password</label>
                                            <div class="input-group">
                                                <div class="input-group-addon"><i class="ti-lock"></i></div>
                                                <input type="password" data-ng-keyup="passwordKeyUp($event)" data-validation="required" name="password" data-ng-model="password" required class="form-control" id="exampleInputpwd1" placeholder="Enter password"> </div>
                                        </div>
                                        <div class="col-md-6">
                                          <label for="exampleInputpwd2">Confirm Password</label>
                                            <div id="password-input-group" class="input-group">
                                                <div class="input-group-addon"><i class="ti-lock"></i></div>
                                                <input type="password" data-ng-keyup="passwordKeyUp($event)" name="cpassword" data-ng-model="cpassword" required class="form-control" id="exampleInputpwd2" placeholder="Confirm password"> </div>
                                        <span id="password-error" class="hidden font-red">Hello</span>
                                        </div>
                                                        </div>  --}}
                                        <div class="form-group">
                                        <label for="SelectRoles">Select Role</label>
                                        <select data-ng-change="changeProfile()" data-ng-model='selectedProfile' class="location-geography width-full" data-validation="required" name="profileRole"  data-style="form-control">
                                        @foreach($roles as $role)
                                             <option value="{{$role->name}}">{{$role->name}}</option>
                                        @endforeach
                                    </select>
                                    </div>
                                    <!--Select Profile -->
                                    @verbatim
                                    <!--Select Region -->
                                        <div data-ng-show="showRegionList" class="form-group">
                                 <h4 class="box-title">Select Region</h4>
                                   
                                <select class="location-geography width-full" name="selectedRegion" data-ng-model="selectedRegion">
                                        <option data-ng-repeat="region in regionList" value="{{region.id}}">{{region.name}}</option>
                                    </select>
                                    </div>
                                    <!--End Select Region -->
                                    <!--Select Zone -->
                                    <div data-ng-show="showZoneList" class="form-group">
                                    <h4 class="box-title">Select Zone</h4>
                                         <select class="location-geography width-full" name="selectedZone" data-ng-model="selectedZone">
                                        <option data-ng-repeat ="zone  in zoneList" value="{{zone.id}}">{{zone.name}}</option>
                                    </select>
                                    </div>
                                    <!--End Select Zone -->
                                    <!-- Select State -->
                                    <div data-ng-show="showStateList" class="form-group">
                                 <h4 class="box-title">Select State</h4>
                                <select class="location-geography width-full" name="selectedState" data-ng-model="selectedState">
                                        <option data-ng-repeat="state in stateList" value="{{state.id}}">{{state.name}}</option>
                                    </select>
                                    </div>
                                    <!-- End Select State -->
                                    <!--Select Area -->
                                 <div data-ng-show="showAreaList" class="form-group">
                                 <h4 class="box-title">Select Area</h4>
                                <select class="location-geography width-full" name="selectedArea" data-ng-model="selectedArea">
                                        <option data-ng-repeat="area in areaList" value="{{area.id}}">{{area.name}}</option>
                                    </select>
                                    </div>
                                           <!--Select Territory-->
                                        <div data-ng-show="showTerritoryList" class="form-group">
                                      <h4 class="box-title">Select Territory</h4>
                                    <select class="location-geography width-full" name="selectedTerritory" data-ng-model="selectedTerritory">
                                        <option data-ng-repeat="territory in territoryList" value="{{territory.id}}">{{territory.name}}</option>
                                    </select>
                                            </div>
                                            <!--End Select Territory -->
                                    @endverbatim
                                    <!-- End Select Profile -->
                                        <button data-ng-click="createAccount()" class="btn btn-success btn-lg btn-block waves-effect waves-light m-r-10">Add User</button>
                                    
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 colorbox-group-widget">
                     <h3 class="box-title">Available Account Profiles</h3>
@foreach($roles as $role)
   <!--Start HR Profile -->
                        <div class="col-md-6 col-sm-12 info-color-box">
                        <div class="white-box">
                            <div style="color:white !important;" class="media {{ $bannerClasses[$loop->index] }}">
                                <div class="media-body">
                                    <h3 class="info-count">
                                    {{$roleUsers[$loop->index]}}
<span class="pull-right"></span></h3>
                                    <p class="info-text font-12">{{ $role->name }}</p>
                                    <p class="info-ot font-15">Permissions<span class="label label-rounded">{{count($rolePermissions[$loop->index])}}</span></p>
                                </div>
                            </div>
                        </div>
   <!--Add Permissions -->
@include('components.permission',
['role'=> $role,
'permissions'=> $rolePermissions[$loop->index]
])
                    </div>
<!--End HR Profile -->  
@endforeach

                    </div>
                </div>
                <!--./row-->
                </div>
        <!-- /#page-wrapper -->
@endsection

@section('pagejs')
    <!-- icheck -->
    <script src="{{asset('js/icheck.min.js') }}"></script>
    <script src="{{ asset('js/icheck.init.js') }}"></script>
        <script src="{{ asset('js/scrollable.js') }}"></script>
    <script src="{{ asset('js/controllers/create.user.js') }}"></script>
    <script src="{{ asset('js/bootstrap-select.min.js') }}"></script>
                      <script src="{{asset('js/jquery.form-validator.js')}}"></script>
                                   <script src="{{asset('js/select2.min.js')}}"></script>
                      <script>
                $.validate();
                                 $('.location-geography').select2();
                      </script>
    {{--  Custom Error  --}}
    @if(Session::has('userCreationError'))
    <script>
            GlobalErrorNotification("{{session('userCreationError')}}");
            </script>
    @else 
    @endif
    {{--  Validation Error  --}}
      @if ($errors->any())
            @foreach ($errors->all() as $error)
            <script >
              GlobalErrorNotification("{{$error}}");
            </script>
            @endforeach
@endif
  {{--  Success Message  --}}
    @if(Session::has('userCreationSuccess'))
    <script>
            GlobalSuccessNotification("{{session('userCreationSuccess')}}");
            </script>
    @else 
    @endif
@endsection