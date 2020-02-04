
@extends('layouts.master')

@section('pagestyles')
             <link href="{{asset('css/jquery.dialog.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
        <!-- Page Content -->
        <div class="page-wrapper">
            <div class="container-fluid">
       <div class="row">
                    <div class="col-md-12">
                        <div class="white-box user-table">
                            <div class="row">
                                <div class="col-sm-6">
                                    <h4 class="box-title">Role Movement History</h4>
                                </div>
                                <div class="col-sm-6">
                                    <ul class="list-inline">
                                        <li>
                                            <a href="javascript:void(0);" class="btn btn-default btn-outline font-16"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" class="btn btn-default btn-outline font-16"><i class="fa fa-commenting" aria-hidden="true"></i></a>
                                        </li>
                                    </ul>
                                    <select class="custom-select">
                                        <option selected>Sort by</option>
                                        <option value="1">Name</option>
                                        <option value="2">Location</option>
                                        <option value="3">Type</option>
                                        <option value="4">Role</option>
                                        <option value="5">Action</option>
                                    </select>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                        <th>S/N</th>
                                            <th>Requester Name</th>
                                            <th>Resource Name</th>
                                            <th>HR Auuid</th>
                                            <th>Attester Auuid</th>
                                            <th>From</th>
                                            <th>To</th>
                                            <th>Approved</th>
                                            <th>Denied</th>
                                            <th>Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($roleMovement as $item)
                                          <tr>
                                          <td>{{$loop->index+1}}</td>
                                            <td>
                                            @isset ($item->requesterProfile)
                                                 <a href="javascript:void(0);" class="text-link">
                                            {{$item->requesterProfile->first_name.' '.$item->requesterProfile->last_name}}
                                            </a>
                                             <img style="height:40px; width:40px;" src="{{asset('storage')}}/{{$item->requesterProfile->profile_picture}}" 
                                             class="img-circle m-l-5"/>
                                            @else
                                                <a href="javascript:void(0);" class="text-link">
                                           N/A
                                            </a>
                                            @endisset
                                            </td>
                                            <td>{{$item->resourceProfile->first_name.' '.$item->resourceProfile->last_name}}<img style="height:40px; width:40px;" src="{{asset('storage')}}/{{$item->resourceProfile->profile_picture}}" class="img-circle m-l-5"/></td>
                                            <td>{{(isset($item->hrProfile) ? $item->hrProfile->first_name.' '.$item->hrProfile->last_name : 'N/A')}}</td>
                                            <td>{{(isset($item->attester_auuid) ? $item->attester_auuid : 'N/A')}}</td>
                                            <td>{{$item->resourceRole->name}}</td>
                                            <td>{{$item->destinationRole->name}}</td>
                                            <td><span class="label {{($item->is_approved == 0 ? 'label-danger' : 'label-success')}}">
                                            @if($item->is_approved)
                                            <i class="fa fa-check-square-o"> </i>
                                            @else
                                            <i class="fa fa-close"> </i>
                                            @endif
                                            </span></td>
                                            <td><span class="label {{($item->is_denied == 0 ? 'label-success' : 'label-danger')}}">
                                            @if($item->is_denied)
                                            <i class="fa fa-check-square-o"> </i>
                                            @else
                                            <i class="fa fa-close"> </i>
                                            @endif                                             </span></td>
                                            <td>
                                               {{substr($item->created_at,0,strlen($item->created_at)-8)}}
                                            </td>
                                            <td>
                                            <a href="{{route('role.movement.profile',$item->id)}}">
                                            <span data-toggle="tooltip" data-title="View Profile" class="cursor-pointer tooltip-info">
                                            <i class="fa fa-television"></i></span>
                                            </a>
                                               <a href="javascript:;" style="margin:10px;" class="btn-red" onclick="invokeDelete('delete_form{{$item->id}}',{{$loop->index+1}})">
                                            <span data-toggle="tooltip" data-title="Delete" class="cursor-pointer tooltip-info">
                                            <i class="fa fa-trash"></i></span>
                                            </a>
                                            <form id="delete_form{{$item->id}}" hidden method="POST" action="{{route('role.movement.destroy', $item->id)}}") >
                                                {{method_field('DELETE')}}
                                            {!! Form::token() !!}
                                            
                                            <input name="role_id" hidden value="{{$item->id}}" />
                                            </form>
                                            </td>
                                        </tr>  
                                    @endforeach
                                    
   </tbody>
                                </table>
                            </div>
                            {{ $roleMovement->links() }}
                                        </div></div>
@endsection

@section('pagejs')
<script src="{{asset('js/jquery.dialog.js')}}"></script>
    <script> 
        function invokeDelete(element,id){
 dialog.confirm({
  title: "Role movement",
  message: "Remove role movement item with S/N of "+id+' ?',
  cancel: "Cancel",
  button: "Continue",
  required: false,
  callback: function(value){
    if(value){
        $('#'+element).submit();
    }
  }
});
        }
    </script>
@endsection
