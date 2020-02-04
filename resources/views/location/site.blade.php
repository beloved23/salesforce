@extends('layouts.master')

@section('pagestyles')
                     <link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet">
                                      <link href="{{asset('css/select2.min.css')}}" rel="stylesheet" />
                                          <link href="{{asset('css/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />
 
@endsection

@section('content')
     <!-- Page Content -->
        <div class="page-wrapper" data-ng-controller="SiteController">
            <div class="container-fluid">
            <!--Begin Number of sites profile-->
     <!-- .row -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="white-box">
                            <h3 class="box-title">Sites Profile</h3>
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
                                            <td>Site</td>
                                            <td>
                                            @{{siteCount}}
                                            </td>
                                            <td>@{{siteTimestamp}}</td>
                                            <td class="text-nowrap">
                                         <a href="{{route('site.index')}}" data-toggle="tooltip" data-original-title="View details"> <i class="fa fa-television text-inverse m-r-10"></i> </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!--End number of sites profile -->

            <!--Form row -->
            <form id="create-form" name="create-form" action="{{route('site.store')}}" method="POST" >
                {{csrf_field()}}
                    <div class="row">
                    <div class="col-lg-12 col-sm-12 col-xs-12">
                        <div class="white-box">
                            <h3 class="box-title">Site Creation</h3>
                         <div class="row">
                        @verbatim
                          <div  class="col-lg-6">
                                      <h4 class="box-title">Select Territory</h4>
                                       <select data-validation="select_option" name="selectedTerritory" data-ng-model="selectedTerritory"
                                        class="location-geography width-full">
                                        <option data-ng-repeat="territory in territoryList" value="{{territory.id}}">{{territory.name}}</option>
                                    </select>
                                </div>
                        @endverbatim
                         

                                  <div  class="col-lg-6">
                                      <h4  class="box-title">Site Classification</h4>
                <input type="text" data-validation="required"  class="form-control" name="siteClassification" />

                                </div>
                                <div class="col-lg-4">
                            <h5  class="box-title">Site ID</h5>
                            <input data-validation="required" type="text"  class="form-control" name="siteId" />
                         </div>
                            <div class="col-lg-4">
                            <h5 class="box-title">Site Code</h5>
                            <input type="text" data-validation="required" class="form-control" name="siteCode" />
                       </div>
                        <div class="col-lg-4">
                            <h5 class="box-title">Site Category</h5>
                            <input type="text"  class="form-control" name="siteCategory" />
                         </div>
                          <div class="col-lg-4">
                            <h5 class="box-title">Town Name</h5>
                            <input type="text" data-validation="required" class="form-control" name="townName" />
                           </div>
                           <div class="col-lg-4">
                            <h5 class="box-title">Site Class Code</h5>
                            <input type="text" data-validation="required" class="form-control" name="siteClassCode" />
                         </div>
 <div class="col-lg-4">
                            <h5 class="box-title">Site Category Code</h5>
                            <input type="text" class="form-control" name="siteCategoryCode" />
                           </div>
                           <div class="col-lg-4">
                            <h5 class="box-title">Site Type</h5>
                            <input type="text" class="form-control" name="siteType" />
                           </div>
                              <div class="col-lg-4">
                            <h5 class="box-title">Site HubCode</h5>
                            <input type="text" class="form-control" name="siteHubCode" />
                         </div>
                         <div class="col-lg-4">
                            <h5 class="box-title">Bts Type</h5>
                            <input type="text" class="form-control" name="siteBtsType" />
                           </div>
                         <div class="col-lg-6">
                            <h5 class="box-title">Commercial Site Classification</h5>
                            <input type="text" class="form-control" name="siteCommercialClassification" />
                           </div>
                          

                       
                           <div class="col-lg-6">
                            <h5 class="box-title">Bsc Code</h5>
                            <input type="text" class="form-control" name="siteBscCode" />
                         </div>

                  <div class="col-lg-4">
                            <h5 class="box-title">Bsc Name</h5>
                            <input type="text" class="form-control" name="siteBscName" />
                           </div>
                           <div class="col-lg-4">
                            <h5 class="box-title">Bsc Rnc</h5>
                            <input type="text" class="form-control" name="siteBscRnc" />
                         </div>
                           <div class="col-lg-4">
                            <h5 class="box-title">Cell code</h5>
                            <input type="text" class="form-control" name="siteCellCode" />
                         </div>
                                                    <div class="col-lg-4">
                            <h5 class="box-title">Cell ID</h5>
                            <input type="text"  class="form-control" name="siteCellId" />
                         </div>

                                              <div class="col-lg-4">
                            <h5 class="box-title">CGI</h5>
                            <input type="text" class="form-control" name="siteCgi" />
                         </div>
                                        <div class="col-lg-4">
                            <h5 class="box-title">City</h5>
                            <input type="text" class="form-control" name="siteCity" />
                         </div>
                                              <div class="col-lg-4">
                            <h5 class="box-title">CI</h5>
                            <input type="text" class="form-control" name="siteCi" />
                         </div>
                                              <div class="col-lg-4">
                            <h5 class="box-title">City Code</h5>
                            <input type="text" class="form-control" name="siteCityCode" />
                         </div>
                                              <div class="col-lg-4">
                            <h5 class="box-title">Corresponding Network</h5>
                            <input type="text"  class="form-control" name="siteCorrespondingNetwork" />
                         </div>
                                              <div class="col-lg-4">
                            <h5 class="box-title">Coverage Area</h5>
                            <input type="text" class="form-control" name="siteCoverageArea" />
                         </div>

                                 <div class="col-lg-4">
                            <h5 class="box-title">LAC</h5>
                            <input type="text" class="form-control" name="siteLac" />
                         </div>
                                              <div class="col-lg-4">
                            <h5 class="box-title">Msc Name</h5>
                            <input type="text" class="form-control" name="siteMscName" />
                         </div>
                                       <div class="col-lg-4">
                            <h5 class="box-title">Msc Code</h5>
                            <input type="text" class="form-control" name="siteMscCode" />
                         </div>
                                              <div class="col-lg-4">
                            <h5 class="box-title">MSS</h5>
                            <input type="text" class="form-control" name="siteMss" />
                         </div>

  <div class="col-lg-4">
                            <h5 class="box-title">Network Code</h5>
                            <input type="text" class="form-control" name="siteNetworkCode" />
                         </div>
                                              <div class="col-lg-4">
                            <h5 class="box-title">New Mss Pool</h5>
                            <input type="text" class="form-control" name="siteNewMssPool" />
                         </div>

<div class="col-lg-4">
                            <h5 class="box-title">OM Classification</h5>
                            <input type="text" class="form-control" name="siteOmClassification" />
                         </div>
                                              <div class="col-lg-4">
                            <h5 class="box-title">Vendor</h5>
                            <input type="text" class="form-control" name="siteVendor" />
                         </div>
                                             <div class="col-lg-4">
                            <h5 class="box-title">New Zone</h5>
                            <input type="text"  class="form-control" name="siteNewZone" />
                         </div>
                                       <div class="col-lg-4">
                            <h5 class="box-title">New Region</h5>
                            <input type="text" class="form-control" name="siteNewRegion" />
                         </div>

                                              <div class="col-lg-4">
                            <h5 class="box-title">Operational Date</h5>
                            <input type="text" class="form-control" id="datepicker-autoclose" name="siteOperationalDate" placeholder="mm/dd/yyyy">
                         </div>
 
                                      <div class="col-lg-6">
                            <h5 class="box-title">Location Information</h5>
                            <input type="text" class="form-control" name="siteLocationInfo" />
                         </div>  
                         <div class="col-lg-6">
                            <h5 class="box-title">Comment</h5>
                            <input type="text" class="form-control" name="siteComment" />
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
                          <select class="selectpicker form-control" name="siteStatus" data-validation="select_option" data-style="form-control" >
                          <option val="1" >Active </option>
                         <option val="0" >In Active</option>
                          </select>
                         </div>
                           <div class="col-lg-12">
                            <h5 class="box-title">Site Address</h5>
                            <input type="text" data-validation="required" data-ng-model="siteAddress" class="form-control" name="siteAddress" />
                            </div>
                            <div class="col-lg-8 margin-top-20">
            <button data-toggle="tooltip" data-original-title="create a site" type="submit" class="btn btn-warning btn-outline btn-lg btn-block tooltip-info" >Create Site</a>
                                </div>
                                <div class="col-lg-4 margin-top-20">
                         <a data-toggle="tooltip" data-original-title="click to get longitude and latitude" id="showMap" class="btn btn-default  btn-bg btn-block tooltip-primary" >Show Map</a>
                                </div>
                         </div>
                    </div>
                </div>
                </div>
                </form>
                <!--End form row -->
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
             
            </div>
            </div>
<!-- End Page Content -->
@endsection

@section('pagejs')
    <!--Page Angular controller -->
    <script src="{{asset('js/controllers/create.site.js')}}"></script>
    <script src="{{asset('js/bootstrap-select.min.js')}}"></script>
         <script src="{{asset('js/select2.min.js')}}"></script>
         <script src="{{asset('js/jquery.form-validator.js')}}"></script>
             <script src="{{asset('js/bootstrap-datepicker.min.js')}}"></script>
           {{--  Plugins for map  --}}
                    <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=true&key=AIzaSyBROO3Md6_fZD5_fd1u8VTlRxd4VdJnAWU"></script>
                        <script src="{{asset('js/gmaps.js')}}"></script>

                        <script>
                                             $('.location-geography').select2();

                                             $.formUtils.addValidator({
  name : 'select_option',
  validatorFunction : function(value, $el, config, language, $form) {
    return /^\d+$/.test(value);
  },
  errorMessage : 'Please select an option',
  errorMessageKey: 'selectOption'
});
                    $.validate();


                          function showMap(){
         //declare map
       var map = new GMaps({
        el: '#markermap',
        lat: 6.524379300000008,
        lng: 3.3792057000000675
      });  
 map.addListener('center_changed', function() {
    // 3 seconds after the center of the map has changed, pan back to the
    // marker.
    console.log(map.getCenter().lat());
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