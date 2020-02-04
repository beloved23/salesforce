@extends('layouts.master')

@section('pagestyles')
    @include('components.location_show_css')
    <link href="{{asset('css/jquery.dialog.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
 <!-- Page Content -->
        <div class="page-wrapper" data-ng-controller="ShowTerritoryController">
            <div class="container-fluid">
<div class="row">   
  <div id="showZoneTable" class="col-lg-12">
                        <div class="white-box">
                            <h3 class="box-title">Geography: Territory</h3>
                            <!--Zone table -->
                            <table class="table table-striped table-bordered" id="example23">
                                <thead>
                                    <tr>
                                        <th>Territory ID</th>
                                        <th>Territory Name</th>
                                         <th>Territory Code</th>
                                        <th>LGA ID</th>
                                        <th>Number of MDs</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($territories as $territory)
                                    <tr class="gradeC">
                                        <td>{{$territory->id}}</td>
                                        <td>{{$territory->name}}</td>
                                        <td>{{$territory->territory_code}}</td>
                                        <td>{{$territory->lga_id}}</td>
                                        <td>{{count($territory->mds)}}</td>
                                   <td>
                                          <a href="{{route('territory.edit',$territory->id)}}" class=" text-inverse m-r-10" data-toggle="tooltip"
                                        data-original-title="Edit">
                                         <i class="fa fa-pencil text-inverse text-dark"></i> 
                                         </a>  
                                    <a href="javascript:;" onclick="invokeDelete('delete_form{{$territory->id}}',{{$territory->id}})" class=" text-inverse m-r-10 tooltip-danger"
                                     data-toggle="tooltip" data-original-title="Delete territory">
                                       <i class="fa fa-trash text-danger text-inverse m-r-10"></i> </a>
                                       <form method="POST" id="delete_form{{$territory->id}}" hidden action="{{route('territory.destroy',$territory->id)}}">
                                       {!! Form::token() !!}
                                       {{method_field('DELETE')}}
                                       </form>
                                   </td>
                                    </tr>
                                     @endforeach
                                </tbody>
                            </table>

                            <!--Zone table-->
                        </div>
                    </div>
                    </div>
                    </div>
                    </div>

    @endsection
            @section('pagejs')
    <script src="{{asset('js/controllers/show.territory.js')}}"></script>
@include('components.location_show')
@include('components.action_response')
			<script src="{{asset('js/jquery.dialog.js')}}"></script>
    <script>
      function invokeDelete(element,id){
 dialog.confirm({
  title: "Territory",
  message: "Remove territory with ID of "+id+' ? NB: associated entries will be removed as well',
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