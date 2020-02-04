
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
                                      <div class="btn-group">
                                                                <button type="button" class="btn btn-primary dropdown-toggle waves-effect waves-light m-r-5" data-toggle="dropdown" aria-expanded="false"> Filter <b class="caret"></b> </button>
                                                                <ul class="dropdown-menu" role="menu">
                                                                 @role('HR')
                                                                <li><a href="{{route('hierachy.downlines.hr')}}">ROD List</a></li>
                                                                     <li class="divider"></li>
                                                               <li><a href="{{route('hierachy.downlines.rod')}}">ZBM List</a></li>
                                                                @endrole

                                                                @role('ROD')
                                                                 <li><a href="{{route('hierachy.downlines.rod')}}">My ZBM</a></li>
                                                                 <li class="divider"></li>
                                                                  <li><a href="{{route('hierachy.downlines.zbm')}}">My ASM</a></li>
                                                                    <li class="divider"></li>
                                                                  <li><a href="{{route('hierachy.downlines.zbm')}}">My MD</a></li>
                                                                @endrole

                                                                @role('ZBM')
                                                                  <li><a href="{{route('hierachy.downlines.hr')}}">My ROD</a></li>
                                                                    <li class="divider"></li>
                                                                  <li><a href="{{route('hierachy.downlines.zbm')}}">My ASM</a></li>
                                                                    <li class="divider"></li>
                                                                  <li><a href="{{route('hierachy.downlines.asm')}}">My MD</a></li>
                                                                @endrole
                                                               @role('ASM')
                                                                 <li><a href="{{route('hierachy.downlines.hr')}}">My ROD</a></li>
                                                                     <li class="divider"></li>
                                                               <li><a href="{{route('hierachy.downlines.rod')}}">My ZBM </a></li>
                                                                     <li class="divider"></li>
                                                                  <li><a href="{{route('hierachy.downlines.asm')}}">My MD</a></li>
                                                               @endrole
                                                                @role('MD')
                                                                 <li><a href="{{route('hierachy.downlines.hr')}}">My ROD</a></li>
                                                                     <li class="divider"></li>
                                                               <li><a href="{{route('hierachy.downlines.rod')}}">My ZBM </a></li>
                                                                     <li class="divider"></li>
                                                                  <li><a href="{{route('hierachy.downlines.zbm')}}">My ASM</a></li>
                                                               @endrole
                                                                @role('HR')
                                                                 <li class="divider"></li>
                                                                 <li><a href="{{route('site.index')}}">Sites</a></li>
                                                               @else
                                                                <li class="divider"></li>
                                                                    <li><a href="{{route('hierachy.downlines.sites')}}">My Sites</a></li>
                                                            @endrole
                                                                </ul>
                                                            </div>
                                        <div class="pull-right">
                                            <input type="text" id="demo-input-search2" placeholder="search contacts" class="form-control"> </div>
                                        @role('HR')
                                        <h3 class="box-title">Territories </h3> </div>
                                        @else
                                        <h3 class="box-title">My Territories </h3> </div>
                                        @endrole

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
                                                @foreach($data as $item)
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
                                                        @role('HR')
                                                        <td colspan="2">
                                                            <button type="button" class="btn btn-info btn-rounded" data-toggle="modal" data-target="#add-contact">Add New Contact</button>
                                                        </td>
                                                        @else
                                                        <td colspan="2">
                                                        
                                                        </td>
                                                    @endrole
                                                        <div id="add-contact" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                        <h4 class="modal-title" id="myModalLabel">Add Lable</h4> </div>
                                                                    <div class="modal-body">
                                                                        <from class="form-horizontal form-material">
                                                                            <div class="form-group">
                                                                                <div class="col-md-12 m-b-20">
                                                                                    <input type="text" class="form-control" placeholder="Type name"> </div>
                                                                                <div class="col-md-12 m-b-20">
                                                                                    <input type="text" class="form-control" placeholder="Email"> </div>
                                                                                <div class="col-md-12 m-b-20">
                                                                                    <input type="text" class="form-control" placeholder="Phone"> </div>
                                                                                <div class="col-md-12 m-b-20">
                                                                                    <input type="text" class="form-control" placeholder="Designation"> </div>
                                                                                <div class="col-md-12 m-b-20">
                                                                                    <input type="text" class="form-control" placeholder="Age"> </div>
                                                                                <div class="col-md-12 m-b-20">
                                                                                    <input type="text" class="form-control" placeholder="Date of joining"> </div>
                                                                                <div class="col-md-12 m-b-20">
                                                                                    <input type="text" class="form-control" placeholder="Salary"> </div>
                                                                                <div class="col-md-12 m-b-20">
                                                                                    <div class="fileupload btn btn-danger btn-rounded waves-effect waves-light"><span><i class="ion-upload m-r-5"></i>Upload Contact Image</span>
                                                                                        <input type="file" class="upload"> </div>
                                                                                </div>
                                                                            </div>
                                                                        </from>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">Save</button>
                                                                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Cancel</button>
                                                                    </div>
                                                                </div>
                                                                <!-- /.modal-content -->
                                                            </div>
                                                            <!-- /.modal-dialog -->
                                                        </div>
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