
@extends('layouts.master')

@section('pagestyles')
<link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet">
<link href="{{asset('css/select2.min.css')}}" rel="stylesheet" />
<!-- ===== Plugin CSS ===== -->
<link href="{{ asset('css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('css/buttons.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <!-- Page Content -->
<div class="page-wrapper">
        <div class="container-fluid">
                <div class="row">
                        <div class="col-sm-12">
                               <div class="white-box">
                                   <h3 class="box-title m-b-0">Work History</h3>
                                   <div class="table-responsive">
                                           <table id="example23" class="table m-t-30 table-hover"  data-order='[[ 0, "asc" ]]' data-page-size="50">
                                                   <thead>
                                                       <tr>
                                                           <th>Full Name</th>
                                                           <th>Email</th>
                                                           <th>Role</th>
                                                           <th>From</th>
                                                           <th>From Date</th>
                                                           <th>To</th>
                                                           <th>To Date</th>
                                                           <th>Type</th>
                                                       </tr>
                                                   </thead>
                                                   <tbody>
                                                       @foreach($histories as $item)
                                                       <tr>
                                                           <td>
                                                               @if(isset($item->userprofile))
                                                               {{$item->userprofile->last_name.' '.$item->userprofile->first_name}}
                                                               @else
                                                               N/A
                                                               @endif
                                                            </td>
                                                            <td>
                                                                {{$item->user->email}}
                                                            </td>
                                                            <td>
                                                                {{$item->user->roles[0]->name}}
                                                            </td>
                                                           <td>
                                                                @if(isset($item->from_model) && isset($item->from_id))
                                                                {{$item->from_model::find($item->from_id)->name}}
                                                            @else
                                                            N/A
                                                            @endif
                                                            </td>
                                                           <td>
                                                               @if(isset($item->from_date))
                                                               {{$item->from_date}}
                                                               @else
                                                               N/A
                                                               @endif
                                                           </td>
                                                           <td>
                                                               @if(isset($item->destination_model::find($item->destination_id)->name))
                                                               {{$item->destination_model::find($item->destination_id)->name}}
                                                               @else
                                                               N/A
                                                            @endif
                                                           </td>
                                                           <td>{{$item->to_date}}</td>
                                                           <td>{{$item->type}}</td>
                                                       </tr>
                                                       @endforeach
                                                   </tbody>
                                           </table>
                                           {{$histories->links()}}
                                   </div>
                               </div>
                       </div>
                   </div>
        </div>
    </div>
@endsection

@section('pagejs')
            <script src="{{asset('js/jquery.dataTables.js')}}"></script>
    <script>
       $(function(){$('#example23').DataTable({
        pageLength: 50,
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
});
    </script>
    @include('components.datatable_buttons')
@endsection