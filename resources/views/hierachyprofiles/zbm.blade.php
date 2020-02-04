
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
                                                                    <li><a href="{{route('hierachy.downlines.zbm')}}">ASM List</a></li>
                                                                     <li class="divider"></li>
                                                                    <li><a href="{{route('hierachy.downlines.asm')}}">MD List</a></li>
                                                                     <li class="divider"></li>
                                                                    <li><a href="{{route('hierachy.downlines.territories')}}">Territories</a></li>
                                                                         <li class="divider"></li>
                                                                    <li><a href="{{route('hierachy.downlines.sites')}}">Sites</a></li>
                                                                @endrole
                                                                @role('ROD')
                                                                    <li><a href="{{route('hierachy.downlines.zbm')}}">My ASM</a></li>
                                                                     <li class="divider"></li>
                                                                    <li><a href="{{route('hierachy.downlines.asm')}}">My MD</a></li>
                                                                     <li class="divider"></li>
                                                                    <li><a href="{{route('hierachy.downlines.territories')}}">My Territories</a></li>
                                                                         <li class="divider"></li>
                                                                    <li><a href="{{route('hierachy.downlines.sites')}}">My Sites</a></li>
                                                                @endrole
                                                                 @role('ASM')
                                                                    <li><a href="{{route('hierachy.downlines.hr')}}">My ROD</a></li>
                                                                     <li class="divider"></li>
                                                                    <li><a href="{{route('hierachy.downlines.asm')}}">My MD</a></li>
                                                                     <li class="divider"></li>
                                                                    <li><a href="{{route('hierachy.downlines.territories')}}">My Territories</a></li>
                                                                         <li class="divider"></li>
                                                                    <li><a href="{{route('hierachy.downlines.sites')}}">My Sites</a></li>
                                                                @endrole
                                                                 @role('MD')
                                                                    <li><a href="{{route('hierachy.downlines.hr')}}">My ROD</a></li>
                                                                     <li class="divider"></li>
                                                                    <li><a href="{{route('hierachy.downlines.zbm')}}">My ASM</a></li>
                                                                     <li class="divider"></li>
                                                                    <li><a href="{{route('hierachy.downlines.territories')}}">My Territories</a></li>
                                                                         <li class="divider"></li>
                                                                    <li><a href="{{route('hierachy.downlines.sites')}}">My Sites</a></li>
                                                                @endrole
                                                                </ul>
                                                            </div>
                                        <div class="pull-right">
                                            <input type="text" id="demo-input-search2" placeholder="search contacts" class="form-control"> </div>
                                        <h3 class="box-title">
                                        @role('HR')
                                        ZBM List
                                        @else
                                        My ZBM List 
                                        @endrole
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
                                                @foreach($data as $item)
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