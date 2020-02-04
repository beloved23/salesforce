@extends('layouts.master')

@section('pagestyles')
@include('components.location_show_css')
@endsection

@section('content')
 <!-- Page Content -->
        <div class="page-wrapper" data-ng-controller="ShowSiteController">
            <div class="container-fluid">
              <!--Data table for all sites in the application -->
            
             <div class="col-sm-12">
                        <div class="white-box">
                            <h3 class="box-title m-b-0 text-center">Display All Sites</h3>
                            <p class="text-muted m-b-30">Export data to Copy, CSV, Excel, PDF & Print</p>
                            <div class="table-responsive">
                                <table id="example23" class="display nowrap" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Site ID</th>
                                            <th>Town Name</th>
                                            <th>Site Code</th>
                                            <th>Classification</th>
                                            <th>Category</th>
                                            <th>Territory</th>
                                               <th>Lga</th>
                                                  <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                           <th>Site ID</th>
                                            <th>Town Name</th>
                                            <th>Site Code</th>
                                            <th>Classification</th>
                                            <th>Category</th>
                                            <th>Territory</th>
                                               <th>Lga</th>
                                               <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                          @foreach($sites as $site)
                                             <tr >
                                            <td>{{$site->site_id}}</td>
                                            <td>{{$site->town_name}}</td>
                                            <td>{{$site->site_code}}</td>
                                            <td>{{$site->classification}}</td>
                                            <td>{{$site->category}}</td>
                                            <td>{{$site->territory->name}}</td>
                                            <td>{{$site->territory->lga->name}}</td>
                                             <td>
                                          <a href="#create-form">   <span data-title="View complete details" data-toggle="tooltip" data-ng-click="siteView({{$loop->index}})"  class="cursor-pointer tooltip-info"><i class="fa fa-television text-inverse m-r-10"></i></span></a>
                                               <span data-title="View hierachy Relations" data-toggle="tooltip" data-ng-click="siteLayers({{$loop->index}})"  class="cursor-pointer tooltip-success"><i class="icon-layers text-inverse m-r-10"></i></span>
                                                 <span data-title="Delete site item" data-toggle="tooltip" data-ng-click="siteDelete({{$loop->index}})"  class="cursor-pointer tooltip-danger"><i class="fa fa-trash-o text-inverse m-r-10"></i></span>
                                             </td>
                                        </tr>
                                        @endforeach
                                        </tbody>
                                        </table>
                                        </div>
                                        </div>
                                        </div>
                                        <!--end row -->
                                <!--Begin Edit Form -->
                                <div class="row">
                                <div class="col-md-12">
                                                             <!--Form row -->
            <form id="create-form" data-ng-show="showEditForm" name="update-form" action="site/modify" method="POST" >
                {{csrf_field()}}
                    <div class="row">
                    <div class="col-lg-12 col-sm-12 col-xs-12">
                        <div class="white-box">
                            <h3 class="box-title">Site Creation</h3>
                         <div class="row">
                        @verbatim
                          <div  class="col-lg-6">
                                      <h4 class="box-title">Select Territory</h4>
                                       <select data-validation="select_option" name="selectedTerritory" data-ng-model="selectedTerritory" class="location-geography form-control" data-style="form-control">
                                        <option data-ng-repeat="territory in territoryList" value="{{territory.id}}">{{territory.name}}</option>
                                    </select>
                                </div>
                        @endverbatim
                         

                                  <div  class="col-lg-6">
                                      <h4  class="box-title">Site Classification</h4>
                <input type="text" data-validation="required" class="form-control" data-ng-model="siteClassification" name="siteClassification" />

                                </div>
                                <div class="col-lg-4">
                            <h5  class="box-title">Site ID</h5>
                            <input data-validation="required" type="text" class="form-control" data-ng-model="siteId" name="siteId" />
                         </div>
                            <div class="col-lg-4">
                            <h5 class="box-title">Site Code</h5>
                            <input type="text" data-validation="required" class="form-control" data-ng-model="siteCode" name="siteCode" />
                       </div>
                        <div class="col-lg-4">
                            <h5 class="box-title">Site Category</h5>
                            <input type="text"  class="form-control" data-ng-model="siteCategory" name="siteCategory" />
                         </div>
                     
                          <div class="col-lg-4">
                            <h5 class="box-title">Town Name</h5>
                            <input type="text" data-validation="required" class="form-control" data-ng-model="townName" name="townName" />
                           </div>
                           <div class="col-lg-4">
                            <h5 class="box-title">Site Class Code</h5>
                            <input type="text" data-validation="required" class="form-control" data-ng-model="siteClassCode" name="siteClassCode" />
                         </div>
 <div class="col-lg-4">
                            <h5 class="box-title">Site Category Code</h5>
                            <input type="text" class="form-control" data-ng-model="siteCategoryCode" name="siteCategoryCode" />
                           </div>
                           <div class="col-lg-4">
                            <h5 class="box-title">Site Type</h5>
                            <input type="text" class="form-control" data-ng-model="siteType" name="siteType" />
                           </div>
                              <div class="col-lg-4">
                            <h5 class="box-title">Site HubCode</h5>
                            <input type="text" class="form-control" data-ng-model="siteHubCode" name="siteHubCode" />
                         </div>
                                 
                  <div class="col-lg-4">
                            <h5 class="box-title">Bts Type</h5>
                            <input type="text" class="form-control" data-ng-model="siteBtsType" name="siteBtsType" />
                           </div>
                         <div class="col-lg-6">
                            <h5 class="box-title">Commercial Site Classification</h5>
                            <input type="text" class="form-control" data-ng-model="siteCommercialClassification" name="siteCommercialClassification" />
                           </div>
                          

                       
                           <div class="col-lg-6">
                            <h5 class="box-title">Bsc Code</h5>
                            <input type="text" class="form-control" data-ng-model="siteBscCode" name="siteBscCode" />
                         </div>

                  <div class="col-lg-4">
                            <h5 class="box-title">Bsc Name</h5>
                            <input type="text" class="form-control" data-ng-model="siteBscName" name="siteBscName" />
                           </div>
                           <div class="col-lg-4">
                            <h5 class="box-title">Bsc Rnc</h5>
                            <input type="text" class="form-control" data-ng-model="siteBscRnc" name="siteBscRnc" />
                         </div>
                           <div class="col-lg-4">
                            <h5 class="box-title">Cell code</h5>
                            <input type="text" class="form-control" name="siteCellCode" data-ng-model="siteCellCode" />
                         </div>
                                                    <div class="col-lg-4">
                            <h5 class="box-title">Cell ID</h5>
                            <input type="text"  class="form-control" data-ng-model="siteCellId" name="siteCellId" />
                         </div>

                                              <div class="col-lg-4">
                            <h5 class="box-title">CGI</h5>
                            <input type="text" class="form-control" data-ng-model="siteCgi" name="siteCgi" />
                         </div>
                                        <div class="col-lg-4">
                            <h5 class="box-title">City</h5>
                            <input type="text" class="form-control" data-ng-model="siteCity" name="siteCity" />
                         </div>
                                              <div class="col-lg-4">
                            <h5 class="box-title">CI</h5>
                            <input type="text" class="form-control" data-ng-model="siteCi" name="siteCi" />
                         </div>
                                              <div class="col-lg-4">
                            <h5 class="box-title">City Code</h5>
                            <input type="text" class="form-control" data-ng-model="siteCityCode" name="siteCityCode" />
                         </div>
                            
                                              <div class="col-lg-4">
                            <h5 class="box-title">Corresponding Network</h5>
                            <input type="text"  class="form-control" data-ng-model="siteCorrespondingNetwork" name="siteCorrespondingNetwork" />
                         </div>
                                              <div class="col-lg-4">
                            <h5 class="box-title">Coverage Area</h5>
                            <input type="text" class="form-control" data-ng-model="siteCoverageArea" name="siteCoverageArea" />
                         </div>

                                 <div class="col-lg-4">
                            <h5 class="box-title">LAC</h5>
                            <input type="text" class="form-control" data-ng-model="siteLac" name="siteLac" />
                         </div>
                                              <div class="col-lg-4">
                            <h5 class="box-title">Msc Name</h5>
                            <input type="text" class="form-control" data-ng-model="siteMscName" name="siteMscName" />
                         </div>
                                       <div class="col-lg-4">
                            <h5 class="box-title">Msc Code</h5>
                            <input type="text" class="form-control" data-ng-model="siteMscCode" name="siteMscCode" />
                         </div>
                                              <div class="col-lg-4">
                            <h5 class="box-title">MSS</h5>
                            <input type="text" class="form-control" data-ng-model="siteMss" name="siteMss" />
                         </div>

  <div class="col-lg-4">
                            <h5 class="box-title">Network Code</h5>
                            <input type="text" class="form-control" data-ng-model="siteNetworkCode" name="siteNetworkCode" />
                         </div>
                                              <div class="col-lg-4">
                            <h5 class="box-title">New Mss Pool</h5>
                            <input type="text" class="form-control" data-ng-model="siteNewMssPool" name="siteNewMssPool" />
                         </div>

<div class="col-lg-4">
                            <h5 class="box-title">OM Classification</h5>
                            <input type="text" class="form-control" data-ng-model="siteOmClassification" name="siteOmClassification" />
                         </div>
                                              <div class="col-lg-4">
                            <h5 class="box-title">Vendor</h5>
                            <input type="text" class="form-control" data-ng-model="siteVendor" name="siteVendor" />
                         </div>
                                             <div class="col-lg-4">
                            <h5 class="box-title">New Zone</h5>
                            <input type="text"  class="form-control" data-ng-model="siteNewZone" name="siteNewZone" />
                         </div>
                                       <div class="col-lg-4">
                            <h5 class="box-title">New Region</h5>
                            <input type="text" class="form-control" data-ng-model="siteNewRegion" name="siteNewRegion" />
                         </div>

                                              <div class="col-lg-4">
                            <h5 class="box-title">Operational Date</h5>
                            <input type="text" class="form-control" id="datepicker-autoclose" data-ng-model="siteOperationalDate" name="siteOperationalDate" placeholder="mm/dd/yyyy">
                         </div>
 
                                      <div class="col-lg-6">
                            <h5 class="box-title">Location Information</h5>
                            <input type="text" class="form-control" data-ng-model="siteLocationInfo" name="siteLocationInfo" />
                         </div>  
            <div class="col-lg-6">
                            <h5 class="box-title">Comment</h5>
                            <input type="text" class="form-control" data-ng-model="siteComment" name="siteComment" />
                         </div>
                          <div class="col-lg-4">
                            <h5 class="box-title">Longitude</h5>
                            <input type="text" data-validation="required" data-ng-model="siteLongitude" class="form-control" name="siteLongitude" />
                           </div>
                           <div class="col-lg-4">
                            <h5 class="box-title">Latitude</h5>
                            <input type="text" data-validation="required" data-ng-model="siteLatitude" class="form-control" name="siteLatitude" />
                         </div>
                         <div class="col-lg-4">
                            <h5 class="box-title">Status</h5>
                          <select class="location-geography form-control" data-validation="select_option" name="siteStatus" data-ng-model="siteStatus" data-style="form-control" >
                          <option value="1" >Active </option>
                         <option value="0" >In Active</option>
                          </select>
                         </div>
                           <div class="col-lg-12">
                            <h5 class="box-title">Site Address</h5>
                            <input type="text" data-validation="required" data-ng-model="siteAddress" class="form-control" name="siteAddress" />
                            </div>
                            <div class="col-lg-8 margin-top-20">
            <button data-toggle="tooltip" data-original-title="update this site" type="submit" class="btn btn-warning btn-outline btn-lg btn-block tooltip-info" >Update Site</button>
                                </div>
                                <div class="col-lg-4 margin-top-20">
                         <a data-toggle="tooltip" data-original-title="click to get longitude and latitude" id="showMap" class="btn btn-default  btn-bg btn-block tooltip-primary" >Show Map</a>
                                </div>
                         </div>
                    </div>
                </div>
                </div>
                    {{--  Begin map row  --}}
                    <div style="" id="map-anchor" class="row">
                    <div class="col-sm-12">
                        <div class="white-box">
                            <h3 class="box-title">Select Site Location on Map</h3>
                            <div id="markermap" class="gmaps"></div>
                        </div>
                    </div>
                </div>
                   {{--  End map row  --}}
                </form>
                                </div>
                                </div>     
                                <!--End edit form -->     
<div class="row">
<div class="col-md-12">
<a  class="btn btn-default  btn-bg btn-block hidden" id="showHierachyRelations" data-toggle="modal" data-target="#exampleModal" >Show Site Layers</a>
</div>
 </div>
     <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title" id="exampleModalLabel1">Site Layers</h4> </div>
                                        <div class="modal-body">
                    <div class="row">
                    <div class="col-md-12">
                        <div class="white-box">
@verbatim
                            <h3 class="box-title">Upward Hierachy Relations</h3>
                            <div class="row line-steps">
                                <div class="col-md-4 column-step start">
                                    <div class="step-number"><i class="icon-layers"></i></div>
                                    <div class="step-title">Territory</div>
                                    <div class="step-info">Name: <span class="font-dark"> {{hierachyTerritoryName}}</span></div>
                                    <div class="step-info">Code: <span class="font-dark"> {{hierachyTerritoryCode}} </span></div>
                                </div>
                                <div class="col-md-4 column-step active">
                                    <div class="step-number"><i class="icon-globe"></i></div>
                                    <div class="step-title">LGA</div>
                                    <div class="step-info">Name: <span class="font-dark"> {{hierachyLgaName}} </span></div>    
                                    <div class="step-info">Code: <span class="font-dark"> {{hierachyLgaCode}} </span></div>
                                </div>
                                <div class="col-md-4 column-step finish">
                                    <div class="step-number"><i class="icon-grid"></i></div>
                                    <div class="step-title">Area</div>
                                    <div class="step-info">Name: <span class="font-dark"> {{hierachyAreaName}}  </span></div>
                                    <div class="step-info">Code: <span class="font-dark"> {{hierachyAreaCode}} </span></div>
                                </div>
                            </div>
@endverbatim
                        </div>
                    </div>
                </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>



                                        </div>
                                        </div>
                                        <!--end page content -->

@endsection

@section('pagejs')
    <script src="{{asset('js/controllers/show.site.js')}}"></script>       
                   {{--  Plugins for map  --}}
                    <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=true&key=AIzaSyBROO3Md6_fZD5_fd1u8VTlRxd4VdJnAWU"></script>
                        <script src="{{asset('js/gmaps.js')}}"></script>
    @include('components.location_show')
         <script>
            $('.location-geography').select2();
                                                 
                          function showMap(){
         //declare map
       var map = new GMaps({
        el: '#markermap',
        lat: 6.524379300000008,
        lng: 3.3792057000000675
      });  
 map.addListener('center_changed', function() {
                         //retrieve angular app
                     var scope = angular.element($('#mySalesForceApp')).scope();
scope.$apply(function(){
scope.siteLatitude = map.getCenter().lat();
scope.siteLongitude = map.getCenter().lng();
                     });

  });

      GMaps.geolocate({
        success: function(position){
          map.setCenter(position.coords.latitude, position.coords.longitude);
               var scope = angular.element($('#mySalesForceApp')).scope();
scope.$apply(function(){
scope.siteLatitude = position.coords.latitude;
scope.siteLongitude = position.coords.longitude;
                     });
        },
        error: function(error){
                         GlobalErrorNotification("Error "+error.message);  
        },
        not_supported: function(){
                                     GlobalInfoNotification("Your browser does not support geolocation");  
        },
        always: function(){
                    HideGlobalLoader();
                         GlobalSuccessNotification("Map is ready");  
        }
      });  
    }
    $('#showMap').click(function(){
        ShowGlobalLoader();
      showMap();
    });
  //Date Picker initiate
    jQuery('#datepicker-autoclose').datepicker({
        autoclose: true,
        todayHighlight: true
    });
    </script>

@include('components.action_response')
@endsection