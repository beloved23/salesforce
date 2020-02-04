
@extends('layouts.master')

@section('pagestyles')
<link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet">
<link href="{{asset('css/select2.min.css')}}" rel="stylesheet" />
<link href="{{asset('css/jquery-confirm.min.css')}}" rel="stylesheet">
    @include('components.location_show_css')
@endsection

@section('content')
 <!-- Page Content -->
        <div class="page-wrapper" >
            <div class="container-fluid">
        <div class="row">
        <div class="col-lg-12">
                        <div class="white-box">
                            <h3 class="box-title">MD Agencies</h3>
                            <!--Region table -->
                            <table class="table table-striped table-bordered" id="agenciesTable">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Regions</th>
                                        <th>Date</th>
                                         <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                            @foreach($agencies as $agency)
                                    <tr class="gradeC">
                                        <td>{{$agency->name}}</td>
                                        <td>{{$agency->email}}</td>
                                         <td>{{count($agency->locations)}}</td>
                                        <td class="center">{{$agency->created_at}}</td>
                                        <td>
                                          <a href="javascript:void(0);" data-target="#{{$agency->id}}Modal" data-toggle="modal" class=" text-inverse m-r-10" data-toggle="tooltip"  data-original-title="View complete details"> <i class="fa fa-television text-inverse m-r-10 text-dark"></i> </a>
                                                <a data-title="Delete MD Agency" href="{{route('agency.delete',$agency->id)}}" class=" text-inverse m-r-10 tooltip-danger delete" data-toggle="tooltip" data-original-title="Delete Agency" > <i class="fa fa-trash text-danger text-inverse m-r-10"></i> </a>
                                        </td>
                                    </tr>
                                    <!--Region Details Modal -->
                                     <!-- sample modal content -->
                            <div id="{{$agency->id}}Modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                <h4 class="modal-title" id="myModalLabel">Agency Regions</h4> </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                        <div class="col-md-12">
                                                                <div class="white-box">
                                                                    <div class="task-widget2">
                                                                        <div class="task-list">
                                                                            <ul class="list-group">
                                                                                @foreach ($agency->locations as $item)
                                                                                <li class="list-group-item bl-info">
                                                                                        <div class="">
                                                                                            <label for="c7">
                                                                                                <span class="font-16">{{$loop->index+1}}.  &nbsp; &nbsp; {{$item->model_type::find($item->location_id)->name}} | {{$item->model_type::find($item->location_id)->region_code}}</span>
                                                                                               <a  data-title="MD Agency" class="remove" data-agency="{{$agency->name}}"  href="{{route('agency.remove.region',$item->id)}}"> <span class=""><i class="icon icon-trash"></i></span></a>
                                                                                            </label>
                                                                                           
                                                                                        </div>
                                                                                    </li> 
                                                                                @endforeach
                                                                                
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                </div>              
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
                                <!-- /.modal -->
                            @endforeach
                                </tbody>

                            </table>

                            <!--Region table-->
                        </div>
                    </div>  
            </div>
           
        <div class="row">
                <div class="col-md-6">
                    <div class="white-box">
                        <h3 class="box-title m-b-0">Add Agency</h3>
                        <div class="row">
                            <div class="col-sm-12 col-xs-12">
                                <form action="{{route('agency.store')}}" method="POST">
                                    {{csrf_field()}}
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"> Name</label>
                                        <input type="text" required class="form-control" name="name"  placeholder="Enter Name"> </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Email address</label>
                                        <input type="email" required class="form-control" name="email" placeholder="Enter email"> </div>
                                    <div class="form-group">
                                            <select name="regions[]" required class="form-control selectpicker margin-top-10" multiple data-style="form-control">
                                                @foreach ($regions as $item)
                                                <option value="{{$item->id}}" >{{$item->name}}</option>    
                                                @endforeach
                                        </select>
                                              </div>
                                    <button type="submit" class="btn btn-success waves-effect waves-light m-r-10">Submit</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
            @endsection

@section('pagejs')
<script src="{{asset('js/select2.min.js')}}"></script>
<script src="{{asset('js/bootstrap-select.min.js')}}"></script>
<script src="{{asset('js/jquery.dataTables.js')}}"></script>
<script src="{{asset('js/jquery-confirm.min.js')}}"></script>

<script>
   $(function(){$('#agenciesTable').DataTable({
    pageLength: 50,
    dom: 'Bfrtip',
    buttons: [
        'copy', 'csv', 'excel', 'pdf', 'print'
    ]
});
});
 $('a.remove').confirm({
           content: function(){ return "Do you wish to detach this region under Agency("+this.$target.attr('data-agency')+") ?";},
       });
       $('a.delete').confirm({
        content: function(){ return "Do you wish to delete this Agency and its associated regions ?";},
    });
</script>
@include('components.location_show')
@include('components.action_response')


@include('components.datatable_buttons')

@endsection