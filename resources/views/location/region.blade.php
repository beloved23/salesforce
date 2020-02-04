
@extends('layouts.master')

@section('pagestyles')
    @include('components.location_show_css')
@endsection

@section('content')
 <!-- Page Content -->
        <div class="page-wrapper" data-ng-controller="ShowRegionController">
            <div class="container-fluid">

        <div id="showRegionTable" class="col-lg-12">
                        <div class="white-box">
                            <h3 class="box-title">Geography: Region</h3>
                            <!--Region table -->
                            <table class="table table-striped table-bordered" id="example23">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Region Code</th>
                                         <th>Region ROD</th>
                                        <th>Country</th>
                                        <th>Country Code</th>
                                        <th>States </th>
                                         <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                            @foreach($regions as $region)
                                    <tr class="gradeC">
                                        <td>{{$region->name}}</td>
                                        <td>{{$region->region_code}}</td>
                                         <td>{{$region->rodByLocation->userprofile->first_name.' '.$region->rodByLocation->userprofile->last_name}}</td>
                                        <td>{{$region->country->name}}</td>
                                        <td class="center">{{$region->country->country_code}}</td>
                                        <td class="center">{{$region->states_count}}</td>
                                        <td>
                                          <a href="#showRegionItem" class=" text-inverse m-r-10" data-toggle="tooltip" data-ng-click="showRegionDetails({{$loop->index}})" data-original-title="View complete details"> <i class="fa fa-television text-inverse m-r-10 text-dark"></i> </a>
                                                <a href="javascript:void(0);" class=" text-inverse m-r-10 tooltip-danger" data-toggle="tooltip" data-original-title="Delete region" data-ng-click="deleteRegion({{$loop->index}})"> <i class="fa fa-trash text-danger text-inverse m-r-10"></i> </a>
                                        </td>
                                    </tr>
  @endforeach
                                </tbody>

                            </table>

                            <!--Region table-->
                        </div>
                    </div>
            <!--Details Section -->
                    <section id="showRegionItem" data-ng-show="showRegionItem">
                    <div class="row">    
                    <div class="col-md-6">
                                      <div class="white-box">
                                      <div class="row">
                    <div class="col-lg-12">
                    <form action="region/modify" name="modify-form" id="modify-form" method="POST">
                    {{csrf_field()}}
                        <div class="col-lg-12">
                                 <h4 class="box-title">Country</h4>
                                 @verbatim
                                <select class="form-control" name="selectedCountry" data-ng-validation="select_option" data-ng-model="selectedCountry" data-style="form-control">
                                        <option data-ng-repeat="country in countryList" value="{{country.id}}">{{country.name}}</option>
                                    </select>
                                    @endverbatim
                                </div>
                    <div class="col-lg-12">
                                    <h4 class="box-title">Region name</h4>
                                <input type="text" data-ng-model="regionName" data-validation="required" class="form-control" name="regionName" />
                                </div>
                                <div class="col-lg-12">
                                    <h4 class="box-title">Region code</h4>
                                    <input type="text" data-ng-model="regionCode" data-validation="required" class="form-control" name="regionCode" />
                                </div>
                                <div class="col-lg-12">
                                <button type="submit" class="btn btn-info btn-block btn-lg m-r-20 margin-top-30">Update Region</button>
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
                                    <div class="step-title">Zones</div>
                                    <div class="step-info">Total: <span class="font-dark"> {{zones}}  </span></div>
                                </div>
                                <div class="col-md-3 column-step active">
                                    <div class="step-number"><i class="icon-layers"></i></div>
                                    <div class="step-title">States</div>
                                    <div class="step-info">Total: <span class="font-dark"> {{states}}  </span></div>
                                </div>
                                <div class="col-md-3 column-step upcoming">
                                    <div class="step-number"><i class="icon-grid"></i></div>
                                    <div class="step-title">Area</div>
                                    <div class="step-info">Total: <span class="font-dark"> {{areas}}  </span></div>
                                </div>
                                <div class="col-md-3 column-step finish">
                                    <div class="step-number"><i class="icon-compass"></i></div>
                                    <div class="step-title">Lga</div>
                                    <div class="step-info">Total: <span class="font-dark">{{lgas}} </span></div>
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
    <script src="{{asset('js/controllers/show.region.js')}}"></script>
@include('components.location_show')
@include('components.action_response')
@endsection