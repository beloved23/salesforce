
@extends('layouts.master')

@section('pagestyles')
    @include('components.location_show_css')
@endsection

@section('content')
 <!-- Page Content -->
        <div class="page-wrapper" data-ng-controller="ShowCountryController">
            <div class="container-fluid">
         <div id="" class="col-lg-12">
                        <div class="white-box">
                            <h3 class="box-title">Geography: Country</h3>
                            <!--Countries table -->
                            <table class="table table-striped table-bordered" id="example23">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Country Name</th>
                                        <th>Country Code</th> 
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
@foreach($countries as $country)
     <tr class="gradeC">
                                        <td>{{$country->id}}</td>
                                        <td>{{$country->name}}</td>
                                        <td>{{$country->country_code}}</td>
                                        <td>
                                         <a href="#showCountryItem" class=" text-inverse m-r-10" data-toggle="tooltip" data-ng-click="showCountryDetails({{$loop->index}})" data-original-title="View complete details"> <i class="fa fa-television text-inverse m-r-10 text-dark"></i> </a>
                                                <a href="javascript:void(0);" class=" text-inverse m-r-10 tooltip-danger" data-toggle="tooltip" data-original-title="Delete country" data-ng-click="deleteCountry({{$loop->index}})"> <i class="fa fa-trash text-danger text-inverse m-r-10"></i> </a>
                                                </td>
                                    </tr>
@endforeach
                                   
                                </tbody>
                            </table>

                            <!--Countries table-->
                        </div>
                    </div>
                    <section id="showCountryItem" data-ng-show="showCountryItem">
                    <div class="row">    
                    <div class="col-md-6">
                                      <div class="white-box">
                                      <div class="row">
                    <div class="col-lg-12">
                    <form action="country/modify" name="modify-form" id="modify-form" method="POST">
                    {{csrf_field()}}
                    <div class="col-lg-12">
                                    <h4 class="box-title">Country name</h4>
                                <input type="text" data-ng-model="countryName" data-validation="required" class="form-control" name="countryName" />
                                </div>
                                <div class="col-lg-12">
                                    <h4 class="box-title">Country code</h4>
                                    <input type="text" data-ng-model="countryCode" data-validation="required" class="form-control" name="countryCode" />
                                </div>
                                <div class="col-lg-12">
                                <button type="submit" class="btn btn-info btn-block btn-lg m-r-20 margin-top-30">Update Country</button>
                                </div>
                                </form>
                                </div>
                                </div>
                                </div>
                                </div>
                               
                    <div class="col-md-6">
                        <div class="white-box">
                            <h3 class="box-title">Country Relations</h3>
                            <div class="row line-steps">
                                <div class="col-md-3 column-step start">
                                    <div class="step-number"><i class="icon-globe"></i></div>
                                    <div class="step-title">Regions</div>
                                    <div class="step-info">Total: <span class="font-dark"> @{{regions}}  </span></div>
                                </div>
                                <div class="col-md-3 column-step active">
                                    <div class="step-number"><i class="icon-layers"></i></div>
                                    <div class="step-title">Zones</div>
                                    <div class="step-info">Total: <span class="font-dark"> @{{zones}}  </span></div>
                                </div>
                                <div class="col-md-3 column-step upcoming">
                                    <div class="step-number"><i class="icon-grid"></i></div>
                                    <div class="step-title">States</div>
                                    <div class="step-info">Total: <span class="font-dark"> @{{states}}  </span></div>
                                </div>
                                <div class="col-md-3 column-step finish">
                                    <div class="step-number"><i class="icon-compass"></i></div>
                                    <div class="step-title">Areas</div>
                                    <div class="step-info">Total: <span class="font-dark">@{{areas}} </span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                            </div>
                <!-- .row -->
            </section>


</div>
</div>
@endsection


@section('pagejs')
    <script src="{{asset('js/controllers/show.country.js')}}"></script>
@include('components.location_show')
@include('components.action_response')
@endsection