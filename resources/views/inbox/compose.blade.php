
@extends('layouts.master')

@section('pagestyles')
<link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet">
        <link href="{{asset('css/select2.min.css')}}" rel="stylesheet">
@endsection

@section('content')
            <!-- Page Content -->
        <div class="page-wrapper" data-ng-controller="ComposerController">
            <div class="container-fluid">
                <!-- row -->
                <div class="row">
                    <!-- Left sidebar -->
                    <div class="col-md-12">
                        <div class="white-box">
                            <div class="row">
                                <div class="col-lg-2 col-md-3  col-sm-4 col-xs-12 inbox-panel">
                                    <div> <a href="#" class="btn btn-custom btn-block waves-effect waves-light">Compose</a>
                                        <div class="list-group mail-list m-t-20"> <a href="inbox.html" class="list-group-item active">Inbox <span class="label label-rouded label-success pull-right">{{$inboxCount}}</span></a> <a href="#" class="list-group-item ">Starred</a> <a href="#" class="list-group-item">Draft <span class="label label-rouded label-warning pull-right">{{$draftedCount}}</span></a> <a href="{{route('inbox.sent')}}" class="list-group-item">Sent Mail</a> <a href="#" class="list-group-item">Trash <span class="label label-rouded label-danger pull-right">{{$trashedCount}}</span></a> </div>
                                        <h3 class="panel-title m-t-40 m-b-0">Labels</h3>
                                        <hr class="m-t-5">
                                        <div class="list-group b-0 mail-list">
                                         <a href="#" class="list-group-item">
                                         <span class="fa fa-circle text-info m-r-10"></span>Work</a>
                                         <a href="#" class="list-group-item"><span class="fa fa-circle text-danger m-r-10">
                                         </span>Urgent</a> <a href="#" class="list-group-item">
                                         <span class="fa fa-circle text-warning m-r-10"></span>Family</a> 
                                         <a href="#" class="list-group-item"><span class="fa fa-circle text-purple m-r-10">
                                         </span>Private</a>
                                          </div>
                                    </div>
                                </div>
                                <div class="col-lg-10 col-md-9 col-sm-8 col-xs-12 mail_listing">
                                    <h3 class="box-title">Compose New Message</h3>
                                      <form action="{{route('inbox.store')}}" method="POST" enctype="multipart/form-data">
                                      {{csrf_field()}}
                                    <div class="form-group">
                                          <select id="userListForSelection" data-validation="required" multiple="multiple" name="users[]" class="width-full"  data-style="form-control">
                        <option value="To:">Auuid: Email:</option>
                            </select>
                                        </div>
                                    <div class="form-group">
                                        <input class="form-control" data-validation="required" name="subject" placeholder="Subject:"> </div>
                                    <div class="form-group">
                                        <textarea class="textarea_editor form-control" data-validation="required" name="message" rows="10" placeholder="Enter text ..."></textarea>
                                    </div>
                                    <h4><i class="ti-link"></i> Attachment</h4>
                                        <div class=" block m-b-10">
                                        <div class="col-md-8">
                          <input name="file[]" type="file" multiple /> 
                                        </div>
                                        <div class="col-md-4 pull-right">
                                                 <select name="label" class="selectpicker" id="selectLabel" >
                                            <option selected val="work"> Work</option>
                                            <option val="Family">Family </option>
                                            <option  val="Private"> Private</option>
                                            <option val="Urgent">Urgent</option>
                                            </select>  
                                        </div>
                                 
                                            </div>
                                    <hr><br />
                                    <div class="col-md-10">
                                    <button type="submit" class="btn btn-primary btn-lg btn-block"><i class="fa fa-envelope-o"></i> Send</button>
                                    </div>
                                    <div class="col-md-2">
                                    <button class="btn btn-default btn-lg"><i class="fa fa-times"></i>Save as Draft</button>
                                    </div>
                                     </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
                <!-- ===== Right-Sidebar-End ===== -->
            </div>
            <!-- /.container-fluid -->
        </div>
@endsection

@section('pagejs')
<script src="{{asset('js/controllers/composer.js')}}"></script>
           <script src="{{asset('js/bootstrap-select.min.js')}}"></script>
                 <script src="{{asset('js/select2.min.js')}}"></script>
                <script src="{{asset('js/jquery.form-validator.js')}}"></script>
                <script>
                $.validate();
                </script>
                 <script src="{{asset('js/components/bootstrap-select2.js')}}"></script>

                 @include('components.action_response')
@endsection
