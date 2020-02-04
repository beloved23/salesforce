
@extends('layouts.master')
@section('pagestyles')
    
@endsection

@section('content')
 <!-- Page Content -->
        <div class="page-wrapper">
            <div class="container-fluid">
            <!--Start ROD list -->
     <div class="row">
                    <div class="col-md-12">
                        <div class="white-box p-0">
                            <!-- .left-right-aside-column-->
                            <div class="page-aside">
                                <div class="right-aside">
                                    <div class="right-page-header">
                                        <div class="pull-right">
                                            <input type="text" id="demo-input-search2" placeholder="search contacts" class="form-control"> </div>
                                        <h3 class="box-title">{{$userFullName}} ROD List<span class="label label-warning"> Role: {{$userRole}}</span></h3> 
                                         </div>
                                    <div class="clearfix"></div>
                                    <div class="scrollable"></div>
                                        <div class="table-responsive">
                                            <table id="demo-foo-addrow" class="table m-t-30 table-hover contact-list" data-page-size="10">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Picture</th>
                                                        <th>First Name</th>
                                                        <th>Last Name</th>
                                                        <th>Phone</th>
                                                        <th>Auuid</th>
                                                        <th>Region</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($rodCollection as $item)
                                                    <tr>
                                                        <td>{{$loop->index+1}}</td>
                                                        <td>
                                                            <a href="#"><img src="{{asset('storage')}}/{{$item->userprofile->profile_picture}}" alt="user" class="img-circle" /> </a>
                                                        </td>
                                                        <td>
                                                        {{$item->userprofile->first_name}}
                                                        </td>
                                                        <td>{{$item->userprofile->last_name}}</td>
                                                        <td>{{$item->userprofile->phone_number}}</td>
                                                        <td>{{$item->auuid}}</td>
                                                        <td>{{$item->region->name}}</td>
                                                        <td>
                                                        @role('HR')
                <a href="{{route('application.users.hierachyprofile',$item->user_id)}}" type="button" class="btn btn-sm btn-icon btn-pure btn-outline" data-toggle="tooltip" data-original-title="View Hierachy Profile"><i class="fa fa-television" aria-hidden="true"></i></a>
                                                        @else
            <button type="button" class="btn btn-sm btn-icon btn-pure btn-outline" data-toggle="tooltip" data-original-title="View"><i class="fa fa-television" aria-hidden="true"></i></button>
                                                        @endrole
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
                                <!--End ROD list -->
                                <!-- Start ZBM list -->
 <div class="row">
                    <div class="col-md-12">
                        <div class="white-box p-0">
                            <!-- .left-right-aside-column-->
                            <div class="page-aside">
                                <div class="right-aside">
                                    <div class="right-page-header">
                                        <div class="pull-right">
                                            <input type="text" id="demo-input-search2" placeholder="search contacts" class="form-control"> </div>
                                        <h3 class="box-title">
                                   {{$userFullName}}  ZBM List
                                        </h3>
                                         </div>
                                    <div class="clearfix"></div>
                                    <div class="scrollable">
                                        <div class="table-responsive">
                                            <table id="demo-foo-addrow" class="table m-t-30 table-hover contact-list" data-page-size="10">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Picture</th>
                                                        <th>First Name</th>
                                                        <th>Last Name</th>
                                                        <th>Phone</th>
                                                        <th>Auuid</th>
                                                        <th>Zone</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($zbmCollection as $item)
                                                    <tr>
                                                        <td>{{$loop->index+1}}</td>
                                                        <td>
                                                            <a href="#"><img src="{{asset('storage')}}/{{$item->userprofile->profile_picture}}" alt="user" class="img-circle" /> </a>
                                                        </td>
                                                        <td>
                                                        {{$item->userprofile->first_name}}
                                                        </td>
                                                        <td>{{$item->userprofile->last_name}}</td>
                                                        <td>{{$item->userprofile->phone_number}}</td>
                                                        <td>{{$item->auuid}}</td>
                                                        <td>{{$item->zone->name}}</td>
                                                        <td>
 @role('HR')
                <a href="{{route('application.users.hierachyprofile',$item->user_id)}}" type="button" class="btn btn-sm btn-icon btn-pure btn-outline" data-toggle="tooltip" data-original-title="View Hierachy Profile"><i class="fa fa-television" aria-hidden="true"></i></a>
                                                        @else
            <button type="button" class="btn btn-sm btn-icon btn-pure btn-outline" data-toggle="tooltip" data-original-title="View"><i class="fa fa-television" aria-hidden="true"></i></button>
                                                        @endrole
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
                                <!-- End ZBM list -->
                                <!--Start ASM list -->
 <div class="row">
                    <div class="col-md-12">
                        <div class="white-box p-0">
                            <!-- .left-right-aside-column-->
                            <div class="page-aside">
                                <div class="right-aside">
                                    <div class="right-page-header">
                                        <div class="pull-right">
                                            <input type="text" id="demo-input-search2" placeholder="search contacts" class="form-control"> </div>
                                        <h3 class="box-title">{{$userFullName}}  ASM List  </h3> </div>
                                    <div class="clearfix"></div>
                                    <div class="scrollable">
                                        <div class="table-responsive">
                                            <table id="demo-foo-addrow" class="table m-t-30 table-hover contact-list" data-page-size="10">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Picture</th>
                                                        <th>First Name</th>
                                                        <th>Last Name</th>
                                                        <th>Phone</th>
                                                        <th>Auuid</th>
                                                        <th>Area Name</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($asmCollection as $item)
                                                    <tr>
                                                        <td>{{$loop->index+1}}</td>
                                                        <td>
                                                            <a href="#"><img src="{{asset('storage')}}/{{$item->userprofile->profile_picture}}" alt="user" class="img-circle" /> </a>
                                                        </td>
                                                        <td>
                                                       {{$item->userprofile->first_name}}
                                                        </td>
                                                        <td>{{$item->userprofile->last_name}}</td>
                                                        <td>{{$item->userprofile->phone_number}}</td>
                                                        <td>{{$item->auuid}}</td>
                                                        <td>{{$item->area->name}}</td>
                                                        <td>
 @role('HR')
                <a href="{{route('application.users.hierachyprofile',$item->user_id)}}" type="button" class="btn btn-sm btn-icon btn-pure btn-outline" data-toggle="tooltip" data-original-title="View Hierachy Profile"><i class="fa fa-television" aria-hidden="true"></i></a>
                                                        @else
            <button type="button" class="btn btn-sm btn-icon btn-pure btn-outline" data-toggle="tooltip" data-original-title="View"><i class="fa fa-television" aria-hidden="true"></i></button>
                                                        @endrole
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
                                <!--End ASM list -->
                                <!-- MD List -->
 <div class="row">
                    <div class="col-md-12">
                        <div class="white-box p-0">
                            <!-- .left-right-aside-column-->
                            <div class="page-aside">
                                <div class="right-aside">
                                    <div class="right-page-header">
                                        <div class="pull-right">
                                            <input type="text" id="demo-input-search2" placeholder="search contacts" class="form-control"> </div>
                                        <h3 class="box-title">{{$userFullName}}  MD List  </h3> </div>
                                    <div class="clearfix"></div>
                                    <div class="scrollable">
                                        <div class="table-responsive">
                                            <table id="demo-foo-addrow" class="table m-t-30 table-hover contact-list" data-page-size="10">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Picture</th>
                                                        <th>First Name</th>
                                                        <th>Last Name</th>
                                                        <th>Phone</th>
                                                        <th>Auuid</th>
                                                        <th>Territory Name</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($mdCollection as $item)
                                                    <tr>
                                                        <td>{{$loop->index+1}}</td>
                                                        <td>
                                                            <a href="#"><img src="{{asset('storage')}}/{{$item->userprofile->profile_picture}}" alt="user" class="img-circle" /> </a>
                                                        </td>
                                                        <td>
                                                       {{$item->userprofile->first_name}}
                                                        </td>
                                                        <td>{{$item->userprofile->last_name}}</td>
                                                        <td>{{$item->userprofile->phone_number}}</td>
                                                        <td>{{$item->auuid}}</td>
                                                        <td>{{$item->territory->name}}</td>
                                                        <td>
 @role('HR')
                <a href="{{route('application.users.hierachyprofile',$item->user_id)}}" type="button" class="btn btn-sm btn-icon btn-pure btn-outline" data-toggle="tooltip" data-original-title="View Hierachy Profile"><i class="fa fa-television" aria-hidden="true"></i></a>
                                                        @else
            <button type="button" class="btn btn-sm btn-icon btn-pure btn-outline" data-toggle="tooltip" data-original-title="View"><i class="fa fa-television" aria-hidden="true"></i></button>
                                                        @endrole
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
                                <!--Path to Location Profile -->
             <a href="{{route('application.users.locationprofile',$user)}}" type="button" class="btn btn-block btn-danger" data-toggle="tooltip" data-original-title="View {{$userFullName}}'s Location Profile">{{$userFullName}}'s Location Profile</a>   
                                </div>
                                </div>
                                <!-- End MD List -->
                
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