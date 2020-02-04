

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
            <!--Begin Number of sites profile-->
     <!-- .row -->
                <div class="row">
                 <div class="col-sm-12">
                        <div class="white-box">
                            <h3 class="box-title m-b-0">Vacancy Report</h3>
                            <div class="table-responsive">
                                    <table id="example23" class="table m-t-30 table-hover"  data-order='[[ 2, "asc" ]]' data-page-size="50">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Profile </th>
                                                    <th>Location</th>
                                                    <th>Location Name</th>
                                                    <th>Location Code</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($vacancies as $item)
                                                <tr>
                                                    <td>{{$loop->index+1}}</td>
                                                    <td>{{$item->required_profile}}</td>
                                                    <td>
                                                        {{substr($item->location_model,19,strlen($item->location_model)-19)}}
                                                    </td>
                                                    <td>{{$item->location_name}}</td>
                                                    <td>{{$item->location_code}}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                    </table>
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