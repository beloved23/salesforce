

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
                            <h3 class="box-title m-b-0">Export SalesForce</h3>
                            <div class="table-responsive">
                                <table id="example23" class="display nowrap" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                        <th>S/N</th>
                                            <th>ROD Name</th>
                                            <th>ROD AUUID</th>
                                            <th>ROD MSISDN</th>
                                            <th>ROD Email</th>
                                            <th>Region Name</th>
                                            <th>Region Code</th>
                                            <th>ZBM Name</th>
                                            <th> ZBM AUUID</th>
                                            <th>ZBM MSISDN</th>
                                            <th>ZBM Email </th>
                                            <th>Zone Name</th>
                                            <th>Zone Code </th>
                                            <th>ASM Name</th>
                                            <th>ASM AUUID</th>
                                            <th>ASM MSISDN</th>
                                            <th>ASM Email</th>
                                            <th>Area Name </th>
                                            <th> Area Code </th>
                                            <th> MD Name</th>
                                            <th>MD AUUID</th>
                                            <th>MD MSISDN </th>
                                            <th>MD Email </th>
                                            <th>LGA </th>
                                            <th>Territory Name </th>
                                            <th>Territory Code </th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                         <th>S/N</th>
                                            <th>ROD Name</th>
                                            <th>ROD AUUID</th>
                                            <th>ROD MSISDN</th>
                                            <th>ROD Email</th>
                                            <th>Region Name</th>
                                            <th>Region Code</th>
                                            <th>ZBM Name</th>
                                            <th> ZBM AUUID</th>
                                            <th>ZBM MSISDN</th>
                                            <th>ZBM Email </th>
                                            <th>Zone Name</th>
                                            <th>Zone Code </th>
                                            <th>ASM Name</th>
                                            <th>ASM AUUID</th>
                                            <th>ASM MSISDN</th>
                                            <th>ASM Email</th>
                                            <th>Area Name </th>
                                            <th> Area Code </th>
                                            <th> MD Name</th>
                                            <th>MD AUUID</th>
                                            <th>MD MSISDN </th>
                                            <th>MD Email </th>
                                            <th>LGA </th>
                                            <th>Territory Name </th>
                                            <th>Territory Code </th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                    @foreach($collection as $item)
                                         <tr>
                                         <th>{{$loop->index+1}}</th>
                                         <!--ROD Profile -->
                                         @if(isset($item->territory->lga->area->state->zone->region->rodByLocation))
                                                <td>{{$item->territory->lga->area->state->zone->region->rodByLocation->userprofile->last_name.' '.$item->territory->lga->area->state->zone->region->rodByLocation->userprofile->first_name}}</td>
                                            <td>{{$item->territory->lga->area->state->zone->region->rodByLocation->auuid}}</td>
                                            <td>{{'0'.$item->territory->lga->area->state->zone->region->rodByLocation->userprofile->phone_number}}</td>
                                            <td>{{$item->territory->lga->area->state->zone->region->rodByLocation->user->email}}</td>
                                     
                                         @else
                                              N/A
                                                </td>
                                                <td>
                                                N/A
                                                </td>
                                                <td>
                                                N/A
                                                </td>
                                                <td>
                                                N/A
                                                </td>
                                         @endif
                                              <!--End ROD Profile -->

                                            <td>{{$item->territory->lga->area->state->zone->region->name}}</td>
                                            <td>{{$item->territory->lga->area->state->zone->region->region_code}}</td>

                                           <!--ZBM Profile -->
                                            @if(isset($item->territory->lga->area->state->zone->zbmByLocation))
                                            <td>
            {{$item->territory->lga->area->state->zone->zbmByLocation->userprofile->last_name.' '.$item->territory->lga->area->state->zone->zbmByLocation->userprofile->first_name}}  
                                            </td>
                                            <td>
                                {{$item->territory->lga->area->state->zone->zbmByLocation->auuid}}
                                            </td>
                                              <td>{{'0'.$item->territory->lga->area->state->zone->zbmByLocation->userprofile->phone_number}}</td>
                                            <td>{{$item->territory->lga->area->state->zone->zbmByLocation->user->email}}</td>
                                            @else
                                            <td>
                                                N/A
                                                </td>
                                                <td>
                                                N/A
                                                </td>
                                                <td>
                                                N/A
                                                </td>
                                                <td>
                                                N/A
                                                </td>
                                            @endif
                                           <!--End ZBM Profile -->
                                            
                                            <td>{{$item->territory->lga->area->state->zone->name}}</td>
                                            <td>{{$item->territory->lga->area->state->zone->zone_code}}</td>
                                            <!--ASM Profile -->
                                            @if(isset($item->territory->lga->area->asmByLocation))
                                                <td>
                                                @if($item->territory->lga->area->asmByLocation->userprofile !=null)
                                                {{$item->territory->lga->area->asmByLocation->userprofile->last_name.' '.$item->territory->lga->area->asmByLocation->userprofile->first_name}}
                                                @else 
                                                N/A
                                                @endif
                                                </td>
                                            <td>{{$item->territory->lga->area->asmByLocation->auuid}}</td>
                                            <td>{{$item->territory->lga->area->asmByLocation->userprofile->phone_number}}</td>
                                            <td>{{$item->territory->lga->area->asmByLocation->user->email}}</td> 
                                            @else
                                                <td>
                                                N/A
                                                </td>
                                                <td>
                                                N/A
                                                </td>
                                                <td>
                                                N/A
                                                </td>
                                                <td>
                                                N/A
                                                </td>
                                            @endif
                                            <!--End ASM Profile -->
                                            <td>{{$item->territory->lga->area->name}} </td>
                                            <td> {{$item->territory->lga->area->area_code}}</td>
                                            <td>
                                            @if($item->userprofile!=null)
                                            {{$item->userprofile->last_name.' '.$item->userprofile->first_name}}
                                            @else
                                            N/A 
                                            @endif
                                            </td>
                                            <td>{{$item->auuid}}</td>
                                            <td>
                                            @if($item->userprofile!=null)
                                            {{$item->userprofile->phone_number}}
                                            @else
                                            N/A 
                                            @endif
                                            </td>
                                            <td>{{$item->user->email}}</td>
                                            <td>{{$item->territory->lga->name}}</td>
                                            <td>{{$item->territory->name}}</td>
                                            <td>{{$item->territory->territory_code}}</th>
                                        </tr>
                                    @endforeach
                                         </tbody>
                                </table>
                            </div>
                            {{$rods->links()}}
                        </div>
                </div>
            </div>
            </div>
            </div>
@endsection

@section('pagejs')
         <script src="{{asset('js/jquery.dataTables.min.js')}}"></script>
   <!-- start - This is for export functionality only -->
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
        <!-- end - This is for export functionality only -->
    <script>
       $('#example23').DataTable({
           "pageLength": 100,
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
    </script>
@endsection