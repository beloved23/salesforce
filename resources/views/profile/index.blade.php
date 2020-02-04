@extends('layouts.master')

 @section('pagestyles')
             <link href="{{asset('css/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
 @endsection

 @section('content')
         <!-- Page Content -->
        <div class="page-wrapper">
            <div class="container-fluid">
         <!-- .row -->
                <div class="row">
                    <div class="col-md-4 col-xs-12">
                        <div class="white-box">
                            <div class="user-bg">
                             <img width="100%" alt="user" src="../plugins/images/large/img1.jpg">
                                <div class="overlay-box">
                                    <div class="user-content">
                                        <a href="javascript:void(0)">
                                        @if(isset($profile->profile_picture))
                                       <img src="{{asset('storage')}}/{{$profile->profile_picture}}" class="thumb-lg img-circle" alt="img"></a>
                                        @else
                                     <img src="{{asset('images/avatar.jpg')}}" class="thumb-lg img-circle" alt="img"></a>
                                        @endif
                                        <h4 class="text-white">{{(isset($profile->first_name) ? $profile->first_name : '')}}</h4>
                                        <h5 class="text-white">{{Auth::user()->email}}</h5> </div>
                                </div>
                            </div>
                            <div class="user-btm-box">
                                <div class="col-md-4 col-sm-4 text-center">
                                    <p class="text-purple"><i class="ti-facebook"></i></p>
                                    <h1>258</h1> </div>
                                <div class="col-md-4 col-sm-4 text-center">
                                    <p class="text-blue"><i class="ti-twitter"></i></p>
                                    <h1>125</h1> </div>
                                <div class="col-md-4 col-sm-4 text-center">
                                    <p class="text-danger"><i class="ti-dribbble"></i></p>
                                    <h1>556</h1> </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 col-xs-12">
                        <div class="white-box">
                            <ul class="nav nav-tabs tabs customtab">
                                <li class="tab">
                                    <a href="#home" data-toggle="tab"> <span class="visible-xs"><i class="fa fa-home"></i></span> <span class="hidden-xs">Activity</span> </a>
                                </li>
                                <li class="active tab">
                                    <a href="#profile" data-toggle="tab"> <span class="visible-xs"><i class="fa fa-user"></i></span> <span class="hidden-xs">Profile</span> </a>
                                </li>
                                <li class="tab">
                                    <a href="#messages" data-toggle="tab" aria-expanded="true"> <span class="visible-xs"><i class="fa fa-envelope-o"></i></span> <span class="hidden-xs">Messages</span> </a>
                                </li>
                                <li class="tab">
                                    <a href="#settings" data-toggle="tab" aria-expanded="false"> <span class="visible-xs"><i class="fa fa-cog"></i></span> <span class="hidden-xs">Settings</span> </a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane" id="home">
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
                                </div>
                                <div class="tab-pane active" id="profile">
                                    <div class="row">
                                    <div class="col-md-6">                              
                                              <div class="col-md-12 col-xs-12">
                                               <strong>Full Name</strong>
                                            <br>
                                            <p class="text-muted">{{(isset($profile->first_name) ? $profile->first_name : '')}}
                                            {{(isset($profile->last_name) ? $profile->last_name : '')}}
                                            </p>
                                        </div>
                                        <div class="col-md-12 col-xs-12"> <strong>Mobile</strong>
                                            <br>
                                            <p class="text-muted">{{(isset($profile->phone_number) ? $profile->phone_number : '')}}</p>
                                        </div>
                                        <div class="col-md-12 col-xs-12"> <strong>Email</strong>
                                            <br>
                                            <p class="text-muted">{{Auth::user()->email}}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                      <form action="{{route('profile.store')}}"  name="upload-picture" method="POST" role="form" enctype="multipart/form-data" >
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
                                                                    <button type="submit" role="button" class="btn green"> Submit </button>
                                                                    <a href="javascript:;" class="btn default"> Cancel </a>
                                                                </div>
                                                            </form>
                                    </div>  </div>
                                    <hr>
                                     
                                    <h4 class="font-bold m-t-30">Activity Meter</h4>
                                    <hr>
                                    <h5>Transfers <span class="pull-right">80%</span></h5>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width:80%;"> <span class="sr-only">50% Complete</span> </div>
                                    </div>
                                    <h5>Message board <span class="pull-right">90%</span></h5>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-custom" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100" style="width:90%;"> <span class="sr-only">50% Complete</span> </div>
                                    </div>
                                    <h5>Targets <span class="pull-right">50%</span></h5>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:50%;"> <span class="sr-only">50% Complete</span> </div>
                                    </div>
                                    <h5>My Peers <span class="pull-right">70%</span></h5>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:70%;"> <span class="sr-only">50% Complete</span> </div>
                                    </div>

                                </div>
                                <div class="tab-pane" id="messages">
                                    <div class="steamline">
                                        <div class="sl-item">
                                            <div class="sl-left"> <img src="../plugins/images/users/1.jpg" alt="user" class="img-circle" /> </div>
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
                                            <div class="sl-left"> <img src="../plugins/images/users/2.jpg" alt="user" class="img-circle" /> </div>
                                            <div class="sl-right">
                                                <div class="m-l-40"><a href="#" class="text-info">John Doe</a> <span class="sl-date">5 minutes ago</span>
                                                    <p>assign a new task <a href="#"> Design weblayout</a></p>
                                                    <div class="m-t-20 row"><img src="../plugins/images/img1.jpg" alt="user" class="col-md-3 col-xs-12" /> <img src="../plugins/images/img2.jpg" alt="user" class="col-md-3 col-xs-12" /> <img src="../plugins/images/img3.jpg" alt="user" class="col-md-3 col-xs-12" /></div>
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
                                </div>
                                <div class="tab-pane" id="settings">
                                    <form class="form-horizontal form-material" action="{{route('profile.store')}}"  name="update-profile" method="POST">
                                    {{csrf_field()}}
                                    <input class="hidden" name="action" value="update">
                                        <div class="form-group">
                                            <label class="col-md-12">First Name*</label>
                                            <div class="col-md-12">
                                                <input type="text" data-validation="required" name="first_name" placeholder="First Name" value="{{(isset($profile->first_name) ? $profile->first_name : '')}}" class="form-control form-control-line"> </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-12">Last Name*</label>
                                            <div class="col-md-12">
                                                <input type="text" data-validation="required" name="last_name" placeholder="Last Name" value="{{(isset($profile->last_name) ? $profile->last_name : '')}}" class="form-control form-control-line"> </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="example-email" class="col-md-12">Email*</label>
                                            <div class="col-md-12">
                                                <input type="email" name="email" value="{{Auth::user()->email}}" class="form-control form-control-line" name="example-email" id="example-email"> </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-12">Phone No*</label>
                                            <div class="col-md-12">
                                                <input type="text" data-validation="only_number" name="msisdn" placeholder="Phone no" value="{{(isset($profile->phone_number) ? $profile->phone_number : '')}}" class="form-control form-control-line"> </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <button type="submit" class="btn btn-success">Update Profile</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
                </div></div>
 @endsection

 @section('pagejs')
             <script src="{{asset('js/bootstrap-fileinput.js')}}" type="text/javascript"></script>
                                               <script src="{{asset('js/jquery.form-validator.js')}}"></script>
                                               <script>
                                                               $.formUtils.addValidator({
  name : 'only_number',
  validatorFunction : function(value, $el, config, language, $form) {
    return /^\d+$/.test(value);
  },
  errorMessage : 'Only numbers are allowed',
  errorMessageKey: 'enterNumber'
});
                            $.validate();
                                               </script>
             @include('components.action_response')
 @endsection