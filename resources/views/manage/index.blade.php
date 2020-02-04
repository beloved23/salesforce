
@extends('layouts.master')
@section('pagestyles')
      <link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet">
        <link href="{{asset('css/select2.min.css')}}" rel="stylesheet">
                     <link href="{{asset('css/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
                        <link href="{{ asset('css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/buttons.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection


@section('content')
     <!-- Page Content -->
        <div class="page-wrapper" data-ng-controller="ManageController">
            <div class="container-fluid">
            <div class="row" >
               <div class="col-sm-12">
                <div class="white-box">
               <div class="page-aside">
						<div class="right-aside">
							<div class="right-page-header">
							  <div class="btn-group">
														<button type="button" class="btn btn-primary dropdown-toggle waves-effect waves-light m-r-5" data-toggle="dropdown" aria-expanded="false"> Filter <b class="caret"></b> </button>
														<ul class="dropdown-menu" role="menu">
                                                        
                                                        @foreach (Role::all() as $item)
                                    <li><a href="{{route('application.users.manage')}}?role={{$item->name}}">{{$item->name}}</a></li>
                                                        @endforeach
                                                        
														</ul>
													</div>
												</div>
											</div>
										</div>
                       
                            <h3 class="box-title m-b-0">All Staff</h3>
                            <div class="table-responsive">
                                <table id="example23" class="display nowrap" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                        <th>S/N</th>
                                        <th>ID</th>
                                            <th>Full Name</th>
                                            <th>Email</th>
                                            <th>AUUID</th>
                                            <th>MSISDN</th>
                                            <th>Role</th>
                                            <th>Date</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                         <th>S/N</th>
                                        <th>ID</th>
                                            <th>Full Name</th>
                                            <th>Email</th>
                                            <th>AUUID</th>
                                            <th>MSISDN</th>
                                            <th>Role</th>
                                            <th>Date</th>
                                             <th>Actions</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                    @foreach($collection as $item)
                                         <tr>
                                         <th>{{$loop->index+1}}</th>
                                        <th>{{$item->id}}</th>
                                         <th>
                                         @isset($item->profile)
                                          {{$item->profile->last_name.' '.$item->profile->first_name}}
                                         @else
                                         N/A
                                         @endisset
                                        
                                         </th>
                                        <th>{{$item->email}}</th>
                                        <th>{{$item->auuid}}</th>
                                        <th>
                                          @isset($item->profile)
                                            {{$item->profile->phone_number}}
                                          @else
                                         N/A
                                         @endisset
                                        </th>
                                        <th>
                                        @isset($item->roles[0])
                                            {{$item->roles[0]->name}}
                                        @else
                                        N/A
                                        @endisset
                                        </th>
                                        <th>{{$item->created_at}}</th>
                                        <th>
                                         <a href="#showProfileSection" class=" text-inverse m-r-10" data-toggle="tooltip"
                                         data-ng-click="changeUser('{{$item->id}}')"
                                        data-original-title="Edit">
                                         <i class="fa fa-pencil text-inverse text-dark"></i> 
                                         </a>  
                                        </th>
                                        </tr>
                                    @endforeach
                                         </tbody>
                                </table>
                            </div>
                            {{$collection->links()}}
                        </div>
                </div>
            </div>
                <!-- .row -->
                <div class="row" data-ng-show="showProfile" id="showProfileSection">
                    <div class="col-md-4 col-xs-12">
                        <div class="white-box">
                            <div class="user-bg"> <img width="100%" alt="user" src="@{{userPicture}}"> </div>
                            <div class="user-btm-box">
                                <!-- .row -->
                                <div class="row text-center m-t-10">
                                    <div class="col-md-6 b-r"><strong>Full Name</strong>
                                        <p>@{{userFullName}}</p>
                                    </div>
                                    <div class="col-md-6"><strong>Designation</strong>
                                        <p>@{{userRole}}</p>
                                    </div>
                                </div>
                                <!-- /.row -->
                                <hr>
                                <!-- .row -->
                                <div class="row text-center m-t-10">
                                    <div class="col-md-6 b-r"><strong>Email</strong>
                                        <p>@{{userEmail}}</p>
                                    </div>
                                    <div class="col-md-6"><strong>Phone</strong>
                                        <p>@{{userPhone}}</p>
                                    </div>
                                </div>
                                <!-- /.row -->
                                <hr>
                                <!-- /.row -->
                                <div class="col-md-4 col-sm-4 text-center">
                                    <p class="text-purple">ZBM</p>
                                    <h1>@{{zbmCount}}</h1> </div>
                                <div class="col-md-4 col-sm-4 text-center">
                                    <p class="text-blue">ASM</p>
                                    <h1>@{{asmCount}}</h1> </div>
                                <div class="col-md-4 col-sm-4 text-center">
                                    <p class="text-danger">MD</p>
                                    <h1>@{{mdCount}}</h1> </div>
                                    <div class="col-md-12">
                                    <div data-ng-show="showDeactivateUser" >
                                    <label   class="label label-danger">User is currently deactivated</label>
                                <button class="btn btn-info m-t-10" data-ng-click="activateUser()">Activate User</button>
                                    </div>
                                    <button data-ng-show="!showDeactivateUser" class="btn btn-danger" data-ng-click="deactivateUser()">Deactivate User</button>
                                    </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 col-xs-12">
                        <div class="white-box">
                            <!-- .tabs -->
                            <ul class="nav nav-tabs tabs customtab">
                                {{--  <li class="active tab">
                                    <a href="#home" data-toggle="tab"> <span class="visible-xs"><i class="fa fa-home"></i></span> <span class="hidden-xs">Activity</span> </a>
                                </li>  --}}
                                <li class="active tab">
                                    <a href="#settings" data-toggle="tab" aria-expanded="false"> <span class="visible-xs"><i class="fa fa-cog"></i></span> <span class="hidden-xs">Edit Detail</span> </a>
                                </li>
                            </ul>
                            <!-- /.tabs -->
                            <div class="tab-content">
                                <!-- .tabs 1 -->
                                {{--  <div class="tab-pane active" id="home">
                                    <div class="steamline">
                                        <div class="sl-item">
                                            <div class="sl-left"> <img src="../plugins/images/users/1.jpg" alt="user" class="img-circle" /> </div>
                                            <div class="sl-right">
                                                <div class="m-l-40"><a href="#" class="text-info">John Doe</a> <span class="sl-date">5 minutes ago</span>
                                                    <p>assign a new task <a href="#"> Design weblayout</a></p>
                                                    <div class="m-t-20 row"><img src="../plugins/images/img1.jpg" alt="user" class="col-md-3 col-xs-12" /> <img src="../plugins/images/img2.jpg" alt="user" class="col-md-3 col-xs-12" /> <img src="../plugins/images/img3.jpg" alt="user" class="col-md-3 col-xs-12" /></div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="sl-item">
                                            <div class="sl-left"> <img src="../plugins/images/users/2.jpg" alt="user" class="img-circle" /> </div>
                                            <div class="sl-right">
                                                <div class="m-l-40"> <a href="#" class="text-info">John Doe</a> <span class="sl-date">5 minutes ago</span>
                                                    <div class="m-t-20 row">
                                                        <div class="col-md-2 col-xs-12"><img src="../plugins/images/img1.jpg" alt="user" class="img-responsive" /></div>
                                                        <div class="col-md-9 col-xs-12">
                                                            <p> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio. Praesent libero. Sed cursus ante dapibus diam. Sed nisi. Nulla quis sem at nibh elementum imperdiet. Duis sagittis ipsum. Praesent mauris. Fusce nec tellus sed augue semper porta. Mauris massa</p> <a href="#" class="btn btn-success"> Design weblayout</a></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="sl-item">
                                            <div class="sl-left"> <img src="../plugins/images/users/3.jpg" alt="user" class="img-circle" /> </div>
                                            <div class="sl-right">
                                                <div class="m-l-40"><a href="#" class="text-info">John Doe</a> <span class="sl-date">5 minutes ago</span>
                                                    <p class="m-t-10"> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio. Praesent libero. Sed cursus ante dapibus diam. Sed nisi. Nulla quis sem at nibh elementum imperdiet. Duis sagittis ipsum. Praesent mauris. Fusce nec tellus sed augue semper </p>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="sl-item">
                                            <div class="sl-left"> <img src="../plugins/images/users/4.jpg" alt="user" class="img-circle" /> </div>
                                            <div class="sl-right">
                                                <div class="m-l-40"><a href="#" class="text-info">John Doe</a> <span class="sl-date">5 minutes ago</span>
                                                    <p>assign a new task <a href="#"> Design weblayout</a></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>  --}}
                                <!-- /.tabs1 -->
                                <!-- .tabs3 -->
                                <div class="tab-pane active" id="settings">
                                 <form action="{{route('application.users.profile.update','00')}}" id="update-profile"  name="upload-picture" method="POST" role="form" enctype="multipart/form-data" >
                                      {{csrf_field()}}
                                      <input class="hidden" type="text" name="action" value="UploadPicture" />
                                                                <div class="form-group">
                                                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                                                        <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                                                            <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt="" /> </div>
                                                                        <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
                                                                        <div>
                                                                            <span class="btn default btn-file">
                                                                                <span class="fileinput-new"> Select image </span>
                                                                                <span class="fileinput-exists"> Change </span>
                                                                                <input type="file" name="picture"> </span>
                                                                            <a href="javascript:;" class="btn default fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="margin-top-10">
                                                                    <button type="submit" role="button" class="btn green"> Upload Picture </button>
                                                                    <a href="javascript:;" class="btn default"> Cancel </a>
                                                                </div>
                                                            </form>
                                                            <br />
                                @verbatim
                                    <form class="form-horizontal form-material"> 
                                        <input class="hidden" type="text" name="action" value="update" />                                  
                                        <div class="form-group">
                                            <div class="col-md-6">
                                                <label for="user-first-name" class="col-md-12">First Name</label>
                                                 <div class="col-md-12">
                                                <input type="text" data-ng-model="userFirstName" placeholder="{{userFirstName}}" name="user-first-name"  class="form-control form-control-line"> 
                                                </div>
                                                </div>
                                                 <div class="col-md-6">
                                                <label class="col-md-12">Last Name</label>
                                                 <div class="col-md-12">
                                                <input type="text"data-ng-model="userLastName" placeholder="{{userLastName}}" class="form-control form-control-line"> 
                                                </div>
                                                </div>
                                        </div>
                                        <div class="form-group">
                                        <div class="col-md-6">
                                            <label  class="col-md-12">Email</label>
                                            <div class="col-md-12">
                                                <input type="email" data-ng-model="userEmail" placeholder="{{userEmail}}" class="form-control form-control-line" name="example-email" id="example-email"> </div>
                                        </div>
                                        <div class="col-md-6">
                                         <label class="col-md-12">Phone No</label>
                                            <div class="col-md-12">
                                                <input type="text" data-ng-model="userPhone" placeholder="{{userPhone}}" class="form-control form-control-line">
                                                 </div>
                                                 </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-12 text-center">
                                                <button data-ng-click="UpdateProfile()" class="btn btn-success">Update Profile</button>
                                            </div>
                                        </div>
                                    </form>
                                    @endverbatim
                                </div>
                                <!-- /.tabs3 -->
                            </div>
                        </div>
                    </div>
                </div>
                </div>
                </div>
@endsection

@section('pagejs')
    <script src="{{asset('js/controllers/manage.js')}}"> </script>
     <script src="{{asset('js/bootstrap-select.min.js')}}"></script>
             <script src="{{asset('js/select2.min.js')}}"></script>
                          <script src="{{asset('js/bootstrap-fileinput.js')}}" type="text/javascript"></script>
                                   <script src="{{asset('js/jquery.dataTables.min.js')}}"></script>
                         @include('components.select2_users')
                         @include('components.datatable_buttons')
                         <script>
                          $('#example23').DataTable({
           "pageLength": 200,
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
    </script>
@endsection