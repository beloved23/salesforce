
@extends('layouts.master')

@section('pagestyles')
    
@endsection

@section('content')
      <!-- Page Content -->
        <div class="page-wrapper" data-ng-controller="SentController">
            <div class="container-fluid">
             <!-- row -->
                <div class="row">
                    <!-- Left sidebar -->
                    <div class="col-md-12">
                        <div class="white-box">
                            <!-- row -->
                            <div class="row">
                                <div class="col-lg-2 col-md-3  col-sm-12 col-xs-12 inbox-panel">
                              <div> <a href="{{route('inbox.create')}}" class="btn btn-custom btn-block waves-effect waves-light">Compose</a>
                                        <div class="list-group mail-list m-t-20"> <a href="{{route('inbox.index')}}" class="list-group-item">
                                        Inbox <span class="label label-rouded label-success pull-right">
                                        {{$inboxCount}}</span></a> <a href="{{route('inbox.category','starred')}}" class="list-group-item">
                                        Starred <span class="label label-rouded label-default pull-right">
                                        {{$starredCount}}</span></a> 
                                        <a href="{{route('inbox.category','draft')}}" class="list-group-item">Draft
                                         <span class="label label-rouded label-warning pull-right">
                                         {{$draftedCount}}</span></a> <a href="{{route('inbox.sent')}}" class="list-group-item active">Sent Mail
                                        <span class="label label-rouded label-primary pull-right">{{$sentCount}}</span>
                                        </a> <a href="{{route('inbox.category','trash')}}" class="list-group-item">Trash 
                                        <span class="label label-rouded label-danger pull-right">{{$trashedCount}}</span></a> </div>
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
                                <div class="col-lg-10 col-md-9 col-sm-12 col-xs-12 mail_listing">
                                    <div class="inbox-center">
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th width="30">
                                                            <div class="checkbox m-t-0 m-b-0 ">
                                                                <input id="checkbox0" type="checkbox" class="checkbox-toggle" value="check all">
                                                                <label for="checkbox0"></label>
                                                            </div>
                                                        </th>
                                                        <th colspan="4">
                                                            <div class="btn-group">
                                                                <button type="button" class="btn btn-primary dropdown-toggle waves-effect waves-light m-r-5" data-toggle="dropdown" aria-expanded="false"> Filter <b class="caret"></b> </button>
                                                                <ul class="dropdown-menu" role="menu">
                                                                    <li><a href="#fakelink">Read</a></li>
                                                                    <li><a href="#fakelink">Unread</a></li>
                                                                    <li><a href="#fakelink">Something else here</a></li>
                                                                    <li class="divider"></li>
                                                                    <li><a href="#fakelink">Separated link</a></li>
                                                                </ul>
                                                            </div>
                                                            <div class="btn-group">
                                                                <button type="button" class="btn btn-default waves-effect waves-light  dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> <i class="fa fa-refresh"></i> </button>
                                                            </div>
                                                        </th>
                                                        <th class="hidden-xs" width="100">
                                                            <div class="btn-group pull-right">
                                                                <button type="button" class="btn btn-default waves-effect pull-right"><i class="fa fa-chevron-right"></i></button>
                                                            </div>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($sent as $item)
                                                    <tr class="{{(($item->is_read) ? '' : 'unread')}}">
                                                        <td>
                                                            <div class="checkbox m-t-0 m-b-0">
                                                                <input type="checkbox" id="ch2">
                                                                <label for="ch2"></label>
                                                            </div>
                                                        </td>
                                                        <td class="hidden-xs cursor-pointer"  data-ng-click="starMessage({{$item->id}})"><i id="starred{{$item->id}}" class="fa {{(($item->is_starred) ? 'fa-star text-warning' : 'fa-star-o ')}}"></i></td>
                                                        <td class="hidden-xs">
                                                        @if(isset($item->recipientProfile))
                                                             {{$item->recipientProfile->first_name.' '.$item->recipientProfile->last_name}}
                                                        @else
                                                           {{$item->recipient_auuid}}
                                                        @endif
                                                        </td>
                                                        <td class="max-texts">
                                                        <a href="{{route('inbox.show',$item->id)}}">
                                                        <span class="label {{(($item->label=='Urgent') ? 'label-danger' : (($item->label=='Family') ? 'label-warning' : (($item->label=='Work') ? 'label-info' : 'label-success' )))}} m-r-10">{{$item->label}}</span>
                                                         @if(!$item->is_file)
                                                             {{substr($item->message,0,75).'..'}}
                                                        @else
                                                            File Message
                                                        @endif
                                                        </a></td>
                                                        <td class="hidden-xs">
                                                         @if(count($item->attachments) > 0)
                                                        <i class="fa fa-paperclip"></i>
                                                         @else
                                                             
                                                         @endif
                                                        </td>
                                                        <td class="text-right font-12"> {{$item->format_time}}  </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-7 m-t-20"> {{$sent->links()}} </div>
                                        <div class="col-xs-5 m-t-20">
                                            <div class="btn-group pull-right">
                                                     Total Results : {{$sentCount}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.row -->
                        </div>
                    </div>
                </div>
                <!-- /.row -->
          </div>
          </div>
@endsection

@section('pagejs')
<script src="{{asset('js/controllers/sent.js')}}"></script>
                     @include('components.action_response')
@endsection