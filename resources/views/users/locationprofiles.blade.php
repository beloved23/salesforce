
@extends('layouts.master')
@section('pagestyles')
    
@endsection

@section('content')
 <!-- Page Content -->
        <div class="page-wrapper">
            <div class="container-fluid">
     <div class="row">
                    <div class="col-md-12">
                        <div class="white-box p-0">
                            <!-- .left-right-aside-column-->
                            <div class="page-aside">
                                <div class="right-aside">
                                    <div class="right-page-header">
                                        <div class="pull-right">
                                            <input type="text" id="demo-input-search2" placeholder="search contacts" class="form-control demo-input-search2"> </div>
                                        <h3 class="box-title">{{$userFullName}} Territory List <span class="label label-warning"> Role: {{$userRole}}</span></h3> 
                                        </div>
                                    <div class="clearfix"></div>
                                    <div class="scrollable">
                                        <div class="table-responsive">
                                            <table id="demo-foo-addrow" class="table m-t-30 table-hover contact-list" data-page-size="10">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Territory Name</th>
                                                        <th>Territory Code</th>
                                                        <th>LGA ID</th>
                                                        <th>Number of MDs</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($territoryCollection as $item)
                                                    <tr>
                                                        <td>{{$item->id}}</td>
                                                        <td>
                                                       {{$item->name}}
                                                        </td>
                                                        <td>{{$item->territory_code}}</td>
                                                        <td>{{$item->lga_id}}</td>
                                                        <td>{{count($item->mds)}}</td>
                                                        <td>
                                                            <button type="button" class="btn btn-sm btn-icon btn-pure btn-outline" data-toggle="tooltip" data-original-title="View"><i class="fa fa-television" aria-hidden="true"></i></button>
                                                        </td>
                                                    </tr>  
                                                @endforeach 
                                                      </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="2">
                                                        
                                                        </td>
                                                        <td colspan="7">
                                                            <div class="text-right">
                                                                <ul class="pagination"> </ul>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                </div>
                                </div>
                                </div>
                                </div>
                <!--end row  -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="white-box p-0">
                            <!-- .left-right-aside-column-->
                            <div class="page-aside">
                                <div class="right-aside">
                                    <div class="right-page-header">
                                        <div class="pull-right">
                                            <input type="text" id="demo-input-search3" placeholder="search contacts" class="form-control "> </div>
                <h3 class="box-title">{{$userFullName}} Site List </h3> 
                                    <div class="clearfix"></div>
                                    <div class="scrollable">
                                        <div class="table-responsive">
                                            <table id="demo-foo-addrow2" class="table m-t-30 table-hover contact-list" data-page-size="10">
                                                <thead>
                                                    <tr>
                                                        <th>Site ID</th>
                                                        <th>Town Name</th>
                                                        <th>Site Code</th>
                                                        <th>Class Code</th>
                                                        <th>Classification</th>
                                                        <th>Territory Name</th>
                                                        <th>Address</th>
                                                        <th>Latitude </th>
                                                        <th>Longitude</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($siteCollection as $item)
                                                    <tr>
                                                        <td>{{$item->site_id}}</td>
                                                        <td>
                                                       {{$item->town_name}}
                                                        </td>
                                                        <td>{{$item->site_code}}</td>
                                                        <td>{{$item->class_code}}</td>
                                                        <td>{{$item->classification}}</td>
                                                        <td>
                                                        {{$item->territory->name}}
                                                        </td>
                                                        <td>{{$item->address}}</td>
                                                        <td>{{substr($item->latitude,0,7)}}</td>
                                                        <td>{{substr($item->longitude,0,7)}}</td>
                                                    </tr>  
                                                @endforeach 
                                                      </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="2">
                                                        
                                                        </td>
                                                     
                                                        <td colspan="7">
                                                            <div class="text-right">
                                                                <ul class="pagination"> </ul>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                </div>
                                </div>
                                </div>
                </div>
                </div>
@endsection

@section('pagejs')
    <!-- Footable -->
    <script src="{{asset('js/footable.all.min.js')}}"></script>
    <script src="{{asset('js/bootstrap-select.min.js')}}" type="text/javascript"></script>
    <!--FooTable init-->
    <script src="{{asset('js/footable-init.js')}}"></script>
@endsection