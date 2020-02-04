@extends('layouts.master')

@section('pagestyles')
    @include('components.location_show_css')
@endsection

@section('content')
 <!-- Page Content -->
        <div class="page-wrapper" data-ng-controller="ShowAreaController">
            <div class="container-fluid">
<div class="row">     <div id="showZoneTable" class="col-lg-12">
                        <div class="white-box">
                            <h3 class="box-title">Geography: Area</h3>
                            <!--Zone table -->
                            <table class="table table-striped table-bordered" id="example23">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Area Code</th>
                                        <th>State ID</th>
                                        <th>State name</th>
                                         <th>Area ASM</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($areas as $area)
                                    <tr class="gradeC">
                                        <td>{{$area->name}}</td>
                                        <td>{{$area->area_code}}</td>
                                        <td>{{$area->state_id}}</td>
                                        <td class="center">{{$area->state->name}}</td>
                                        @if(isset($area->asmByLocation))
                            <td class="center">{{$area->asmByLocation->userprofile->first_name.' '.$area->asmByLocation->userprofile->last_name}}</td>
                                        @else
                         <td class="center">N/A</td>
                                        @endif
                                   <td>    <a href="#showZoneItem" class=" text-inverse m-r-10" data-toggle="tooltip" data-ng-click="showZoneDetails({{$loop->index}})" data-original-title="View complete details"> <i class="fa fa-television text-inverse m-r-10 text-dark"></i> </a>
                                                <a href="javascript:void(0);" class=" text-inverse m-r-10 tooltip-danger" data-toggle="tooltip" data-original-title="Delete zone" data-ng-click="deleteZone({{$loop->index}})"> <i class="fa fa-trash text-danger text-inverse m-r-10"></i> </a>
                                   </td>
                                    </tr>
                                     @endforeach
                                </tbody>
                            </table>

                            <!--Zone table-->
                        </div>
                    </div>
                    </div>

 <!--Details Section -->
                    <section id="showZoneItem" data-ng-show="showZoneItem">
                    <div class="row">    
                    <div class="col-md-6">
                                      <div class="white-box">
                                      <div class="row">
                    <div class="col-lg-12">
                    <form action="zone/modify" name="modify-form" id="modify-form" method="POST">
                    {{csrf_field()}}
                      @verbatim
                        <div class="col-lg-12">
                                 <h4 class="box-title">Country</h4>
                                <select disabled class="form-control" name="selectedCountry" data-ng-validation="select_option" data-ng-model="selectedCountry" data-style="form-control">
                                        <option data-ng-repeat="country in countryList" value="{{country.id}}">{{country.name}}</option>
                                    </select>
                                </div>
                                <div class="col-lg-12">
                                 <h4 class="box-title">Region</h4>
                                <select class="form-control" name="selectedRegion" data-ng-validation="select_option" data-ng-model="selectedRegion" data-style="form-control">
                                        <option data-ng-repeat="region in regionList" value="{{region.id}}">{{region.name}}</option>
                                    </select>
                                    @endverbatim
                                </div>
                    <div class="col-lg-12">
                                    <h4 class="box-title">Zone name</h4>
                                <input type="text" data-ng-model="zoneName" data-validation="required" class="form-control" name="zoneName" />
                                </div>
                                <div class="col-lg-12">
                                    <h4 class="box-title">Zone code</h4>
                                    <input type="text" data-ng-model="zoneCode" data-validation="required" class="form-control" name="zoneCode" />
                                </div>
                                <div class="col-lg-12">
                                <button type="submit" class="btn btn-info btn-block btn-lg m-r-20 margin-top-30">Update Zone</button>
                                </div>
                                </form>
                                </div>
                                </div>
                                </div>
                                </div>
                                @verbatim
                               
                    <div class="col-md-6">
                        <div class="white-box">
                            <h3 class="box-title">Region Relations</h3>
                            <div class="row line-steps">
                                <div class="col-md-3 column-step start">
                                    <div class="step-number"><i class="icon-globe"></i></div>
                                    <div class="step-title">States</div>
                                    <div class="step-info">Total: <span class="font-dark"> {{states}}  </span></div>
                                </div>
                                <div class="col-md-3 column-step active">
                                    <div class="step-number"><i class="icon-layers"></i></div>
                                    <div class="step-title">Areas</div>
                                    <div class="step-info">Total: <span class="font-dark"> {{areas}}  </span></div>
                                </div>
                                <div class="col-md-3 column-step upcoming">
                                    <div class="step-number"><i class="icon-grid"></i></div>
                                    <div class="step-title">Lgas</div>
                                    <div class="step-info">Total: <span class="font-dark"> {{Lgas}}  </span></div>
                                </div>
                                <div class="col-md-3 column-step finish">
                                    <div class="step-number"><i class="icon-compass"></i></div>
                                    <div class="step-title">Territories</div>
                                    <div class="step-info">Total: <span class="font-dark">{{Territories}} </span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                                @endverbatim
                            </div>
                <!-- .row -->
            </section>
        <!--End Details Section -->


                    </div>
                    </div>

    @endsection
            @section('pagejs')
    <script src="{{asset('js/controllers/show.area.js')}}"></script>
@include('components.location_show')
@include('components.action_response')
@endsection