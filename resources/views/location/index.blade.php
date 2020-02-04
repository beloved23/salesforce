@extends('layouts.master')

@section('pagestyles')
                 <link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet">
                 <link href="{{asset('css/select2.min.css')}}" rel="stylesheet" />
                 <link href="{{asset('css/datatables.css')}}" rel="stylesheet" />
@endsection
@section('content')

    <!-- Page Content -->
        <div class="page-wrapper" data-ng-controller="LocationController">
            <div class="container-fluid">
                <!-- .row -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="white-box">
                            <h3 class="box-title">Locations Profile</h3>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Geography</th>
                                            <th>Count</th>
                                            <th>Last Updated</th>
                                            <th class="text-nowrap">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Country</td>
                                            <td>
                                            @{{countryCount}}
                                            </td>
                                            <td>@{{countryTimestamp}}</td>
                                            <td class="text-nowrap">
                                         <a href="{{route('country.show')}}" data-toggle="tooltip" data-original-title="View details"> <i class="fa fa-television text-inverse m-r-10"></i> </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Region</td>
                                            <td>
                                            @{{regionCount}}
                                            </td>
                                            <td>@{{regionTimestamp}}</td>
                                            <td class="text-nowrap">
                                                                                     <a href="{{route('region.show')}}"  data-toggle="tooltip" data-original-title="View details"> <i class="fa fa-television text-inverse m-r-10"></i> </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Zone</td>
                                            <td>
                                              @{{zoneCount}}
                                            </td>
                                            <td>@{{zoneTimestamp}}</td>
                                            <td class="text-nowrap">
                                                                                     <a href="{{route('zone.show')}}" data-toggle="tooltip" data-original-title="View details"> <i class="fa fa-television text-inverse m-r-10"></i> </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>State</td>
                                            <td>
                                             @{{stateCount}}
                                            </td>
                                            <td>@{{stateTimestamp}}</td>
                                            <td class="text-nowrap">
                                                                                     <a href="{{route('state.show')}}" data-toggle="tooltip" data-original-title="View details"> <i class="fa fa-television text-inverse m-r-10"></i> </a>
                                            </td>
                                        </tr>
                                             <tr>
                                            <td>Area</td>
                                            <td>
                                             @{{areaCount}}
                                            </td>
                                            <td>@{{areaTimestamp}}</td>
                                            <td class="text-nowrap">
                                                                                     <a href="{{route('area.show')}}" data-toggle="tooltip" data-original-title="View details"> <i class="fa fa-television text-inverse m-r-10"></i> </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>LGA</td>
                                            <td>
                                              @{{lgaCount}}
                                            </td>
                                            <td>@{{lgaTimestamp}}</td>
                                            <td class="text-nowrap">
                                                                                     <a href="{{route('lga.show')}}" data-toggle="tooltip" data-ng-click="retrieveAllLga()" data-original-title="View details"> <i class="fa fa-television text-inverse m-r-10"></i> </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Territory</td>
                                            <td>
                                              @{{territoryCount}}
                                            </td>
                                            <td>@{{territoryTimestamp}}</td>
                                            <td class="text-nowrap">
                                                                                     <a href="{{route('territory.index')}}" data-toggle="tooltip" data-original-title="View details"> <i class="fa fa-television text-inverse m-r-10"></i> </a>
                                                      </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
                @verbatim
<!-- .row -->
                             <!-- .row -->
                <div class="row">
                    <div class="col-lg-12 col-sm-6 col-xs-12">
                        <div class="white-box">
                            <h3 class="box-title">Create Location Item</h3>
                            <div class="row">
                                <div class="col-lg-12">
                                    <h5 class="box-title">Select Location Type</h5>
                                    <select data-ng-change="selectGeography()" data-ng-model="selectedGeography" class="select-picker form-control width-full" data-style="form-control">
                                        <option value="CO">Country</option>
                                        <option value="RE">Region</option>
                                        <option value="ZO">Zone</option>
                                        <option value="ST">State</option>
                                         <option value="AR">Area</option>
                                        <option value="LG">LGA</option>
                                        <option value="TE">Territory</option>
                                    </select>
                                </div>
                                <div class="col-lg-12">
                                    <h4 class="box-title">{{selectedGeographyName}} name</h4>
                                <input type="text" data-ng-model="locationName" class="form-control" name="locationName" />
                                </div>
                                <div class="col-lg-12">
                                    <h4 class="box-title">{{selectedGeographyName}} code</h4>
                                    <input type="text" data-ng-model="locationCode" class="form-control" name="locationCode" />
                                </div>
                                <div data-ng-show="showCountryList" class="col-lg-12">
                                 <h4 class="box-title">Select Country</h4>
                                <select class="select-picker form-control width-full" data-ng-model="selectedCountry" data-style="form-control">
                                        <option data-ng-repeat="country in countryList" value="{{country.id}}">{{country.name}}</option>
                                    </select>
                                </div>
                                    <div data-ng-show="showRegionList" class="col-lg-12">
                                 <h4 class="box-title">Select Region</h4>
                                <select class="select-picker form-control width-full" data-ng-model="selectedRegion" data-style="form-control">
                                        <option data-ng-repeat="region in regionList" value="{{region.id}}">{{region.name}}</option>
                                    </select>
                                    </div>
                                      <div data-ng-show="showZoneList" class="col-lg-12">
                                    <h4 class="box-title">Select Zone</h4>
                                       <select class="select-picker form-control width-full" data-ng-model="selectedZone" data-style="form-control">
                                        <option data-ng-repeat ="zone  in zoneList" value="{{zone.id}}">{{zone.name}}</option>
                                    </select>
                                    </div>
                                      <div data-ng-show="showStateList" class="col-lg-12">
                                      <h4 class="box-title">Select State</h4>
                                       <select class="select-picker form-control width-full" data-ng-model="selectedState" data-style="form-control">
                                        <option data-ng-repeat="state in stateList" value="{{state.id}}">{{state.name}}</option>
                                    </select>
                                </div>
                                 <div data-ng-show="showAreaList" class="col-lg-12">
                                      <h4 class="box-title">Select Area</h4>
                                       <select class="select-picker form-control width-full" data-ng-model="selectedArea" data-style="form-control">
                                        <option data-ng-repeat="area in areaList" value="{{area.id}}">{{area.name}}</option>
                                    </select>
                                </div>
                                  <div data-ng-show="showLgaList" class="col-lg-12">
                                      <h4 class="box-title">Select LGA</h4>
                                       <select class="select-picker form-control width-full" data-ng-model="selectedLga" data-style="form-control">
                                        <option data-ng-repeat="lga in lgaList" value="{{lga.id}}">{{lga.name}}</option>
                                    </select>
                                </div>
                                  <div data-ng-show="showTerritoryList" class="col-lg-12">
                                      <h4 class="box-title">Select Territory</h4>
                                       <select data-ng-model="selectedTerritory" class="location-geography form-control width-full" data-style="form-control">
                                        <option data-ng-repeat="territory in territoryList" value="{{territory.id}}">{{territory.name}}</option>
                                    </select>
                                </div>
                                 <div data-ng-show="showSiteList" class="col-lg-12">
                                      <h4 class="box-title">Select Site</h4>
                                       <select class="select-picker form-control width-full" data-style="form-control">
                                        <option value="CO">Country</option>
                                    </select>
                                </div>
                                <div class="col-lg-12 margin-top-20">
            <a class="btn btn-info btn-outline btn-lg btn-block" data-ng-click="saveLocationItem()" >Submit</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                   @endverbatim
             <a class="hidden" id="edit-region" data-target="#editRegion"></a>
             <!--Define modals below -->
    <div class="modal fade" id="editRegion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title" id="exampleModalLabel1">New message</h4> </div>
                                        <div class="modal-body">
                                            <form>
                                                <div class="form-group">
                                                    <label for="recipient-name" class="control-label">Recipient:</label>
                                                    <input type="text" class="form-control" id="recipient-name1"> </div>
                                                <div class="form-group">
                                                    <label for="message-text" class="control-label">Message:</label>
                                                    <textarea class="form-control" id="message-text1"></textarea>
                                                </div>
                                                 <select class="location-geography form-control" data-style="form-control">
                                        <option value="CO">Country</option>
                                    </select>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary">Send message</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
            <!--End modals -->
                </div>
                </div>
                @endsection

                @section('pagejs')
                    <script src="{{asset('js/controllers/location.js')}}"></script>
                     <script src="{{asset('js/bootstrap-select.min.js')}}"></script>
                             <script src="{{asset('js/select2.min.js')}}"></script>
                               <script src="{{asset('js/jquery.dataTables.js')}}"></script>
                                <script src="{{asset('js/dataTables.bootstrap.js')}}"></script>
                                
    <script src="{{asset('js/mindmup-editabletable.js')}}"></script>
    <script src="{{asset('js/numeric-input-example.js')}}"></script>
                 
                 <script>
                     $('.location-geography').select2();
                     $('.select-picker').select2();
                     //Country Editable table
                      $('#editable-country').DataTable();
                      //Region Editable table
                      $('#editable-region').DataTable();
                             //Zone Editable table
                      $('#editable-zone').DataTable();
                          //State Editable table
                      $('#editable-state').DataTable();
                                     //Lga Editable table
                      $('#editable-lga').DataTable();
                        //Area Editable table
                      $('#editable-area').DataTable();
                          //Territory Editable table
                      $('#editable-territory').DataTable();
       //$(".select-picker").selectpicker({iconBase:"fa",tickIcon:"fa-check"});
                     </script>
                @endsection