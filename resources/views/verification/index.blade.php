
@extends('layouts.master')
@section('pagestyles')
<link href="{{ asset('css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('css/buttons.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('css/select.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
 <!-- Page Content -->
        <div class="page-wrapper" data-ng-controller="VerificationController">
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
                                                              <li><a href="{{route('territory.index')}}">Territories</a></li>
                                                                            <li class="divider"></li>
                                                                <li><a href="{{route('site.index')}}">Sites</a></li>
                                                                 </ul>
                                                            </div>
                                        <div class="pull-right">
                                            <input type="text" id="demo-input-search2" placeholder="search contacts" class="form-control"> </div>
                                        <h3 class="box-title">MD Verification List </h3> </div>
                                    <div class="clearfix"></div>
                                    <div class="scrollable">
                                            <table id="md-list" class="display" width="100%" cellspacing="0" class="table m-t-30 table-hover" data-page-size="50">
                                                <thead>
                                                    <tr>
                                                        <th>Action</th>
                                                        <th>First Name</th>
                                                        <th>Last Name</th>
                                                        <th>Phone</th>
                                                        <th>Auuid</th>
                                                        <th>Territory Name</th>
                                                        <th>User ID</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($data as $item)
                                                    <tr>
                                                        <td></td>
                                                          @if($item->userprofile!=null)
                                                        <td>
                                                      
                                                       {{$item->userprofile->first_name}}
                                                      
                                                        </td>
                                                         <td>{{$item->userprofile->last_name}}</td>
                                                        <td>{{$item->userprofile->phone_number}}</td>
                                                         @else 
                                                       <td>N/A </td>
                                                       <td>N/A </td>
                                                       <td>N/A </td>
                                                       @endif
                                                       
                                                        <td>{{$item->auuid}}</td>
                                                        <td>{{$item->territory->name}}</td>
                                                        <td>{{$item->user_id}}</td>
                                                    </tr>  
                                                @endforeach 
                                                      </tbody>
                                            </table>
                                            <button data-ng-click="verifySelectedMds()" class="btn btn-block btn-outline margin-top-15 btn-danger">Verify Selected MDs </button>
                                    </div>
                                </div>
                                </div>
                                </div>
                                </div>
                              
                <!--end row  -->
                </div>  </div>
@endsection

@section('pagejs')
    <!-- Footable -->
    <script src="{{asset('js/controllers/vacancy.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/bootstrap-select.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/datatable.min.js')}}"></script>
    <script src="{{asset('js/dataTables.select.min.js')}}"></script>
    <script>
            $(function(){ var table = $('#md-list').DataTable({
             pageLength: 50,
             columnDefs: [ {
                orderable: false,
                className: 'select-checkbox',
                targets:   0
            } ],
            select: {
                style:    'multi',
                selector: 'td:first-child'
            },
             dom: 'Bfrtip',
             buttons: [
                {
                    text: 'Select all',
                    action: function () {
                        table.rows().select();
                    }
                },
                {
                    text: 'Select none',
                    action: function () {
                        table.rows().deselect();
                    }
                },
                 'csv', 'excel', 'print'
             ]
         });
         window.table = table;
     });
         </script>
    @include('components.datatable_buttons')
@endsection