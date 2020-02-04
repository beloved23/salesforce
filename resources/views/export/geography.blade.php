

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
                            <h3 class="box-title m-b-0">Export Geography Master</h3>
                            <div class="table-responsive">
                                <table id="example23" class="display nowrap" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                        <th>S/N</th>
                                            <th>Global</th>
                                            <th>Global Code</th>
                                            <th>Continent</th>
                                            <th>Continent Code</th>
                                            <th>Hub</th>
                                            <th>Hub Code </th>
                                            <th>Country</th>
                                            <th>Country Code</th>
                                            <th> Region</th>
                                            <th>Region Code</th>
                                            <th>Zone </th>
                                            <th>Zone Code</th>
                                            <th>State Name</th>
                                            <th>State Code</th>
                                            <th>LGA Name</th>
                                            <th>LGA Code </th>
                                            <th> Area Name</th>
                                            <th> Area Code </th>
                                            <th>Territory Name</th>
                                            <th>Territory Code</th>
                                            <th>Site Classification</th>
                                            <th>Site Class Code</th>
                                            <th>Site Category</th>
                                            <th>Site Category Code </th>
                                            <th>Site ID</th>
                                            <th>Site Code</th>
                                            <th> MSC Name </th>
                                            <th> MSC Code </th>
                                            <th>BSC Name </th>
                                            <th> BSC Code </th>
                                            <th>BTS Type </th>
                                            <th>Network Code</th>
                                            <th>CELL ID</th>
                                            <th>Cell Code </th>
                                            <th>City </th>
                                            <th>City Code </th>
                                            <th>Site Type </th>
                                            <th>Longitude </th>
                                            <th>Latitude </th>
                                            <th>Operational Date </th>
                                            <th>LAC </th>
                                            <th>CI </th>
                                            <th>CGI </th>
                                            <th>BSC/RNC </th>
                                            <th>MSS </th>
                                            <th>NEW MSS POOL </th>
                                            <th>Coverage Area </th>
                                            <th> City/ Town Name</th>
                                            <th>OM Classification </th>
                                            <th>Commercial Sites Classification </th>
                                            <th>Address </th>
                                            <th>Vendor </th>
                                            <th>LGA </th>
                                            <th>State </th>
                                            <th>LGA State Concatenate </th>
                                            <th>LGA Rank </th>
                                            <th>New Zone </th>
                                            <th> New Region</th>
                                            <th> Comment </th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>S/N</th>
                                            <th>Global</th>
                                            <th>Global Code</th>
                                            <th>Continent</th>
                                            <th>Continent Code</th>
                                            <th>Hub</th>
                                            <th>Hub Code </th>
                                            <th>Country</th>
                                            <th>Country Code</th>
                                            <th> Region</th>
                                            <th>Region Code</th>
                                            <th>Zone </th>
                                            <th>Zone Code</th>
                                            <th>State Name</th>
                                            <th>State Code</th>
                                            <th>LGA Name</th>
                                            <th>LGA Code </th>
                                            <th> Area Name</th>
                                            <th> Area Code </th>
                                            <th>Territory Name</th>
                                            <th>Territory Code</th>
                                            <th>Site Classification</th>
                                            <th>Site Class Code</th>
                                            <th>Site Category</th>
                                            <th>Site Category Code </th>
                                            <th>Site ID</th>
                                            <th>Site Code</th>
                                            <th> MSC Name </th>
                                            <th> MSC Code </th>
                                            <th>BSC Name </th>
                                            <th> BSC Code </th>
                                            <th>BTS Type </th>
                                            <th>Network Code</th>
                                            <th>CELL ID</th>
                                            <th>Cell Code </th>
                                            <th>City </th>
                                            <th>City Code </th>
                                            <th>Site Type </th>
                                            <th>Longitude </th>
                                            <th>Latitude </th>
                                            <th>Operational Date </th>
                                            <th>LAC </th>
                                            <th>CI </th>
                                            <th>CGI </th>
                                            <th>BSC/RNC </th>
                                            <th>MSS </th>
                                            <th>NEW MSS POOL </th>
                                            <th>Coverage Area </th>
                                            <th> City/ Town Name</th>
                                            <th>OM Classification </th>
                                            <th>Commercial Sites Classification </th>
                                            <th>Address </th>
                                            <th>Vendor </th>
                                            <th>LGA </th>
                                            <th>State </th>
                                            <th>LGA State Concatenate </th>
                                            <th>LGA Rank </th>
                                            <th>New Zone </th>
                                            <th> New Region</th>
                                            <th> Comment </th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                    @foreach($collection as $item)
                                         <tr>
                                            <th>{{$loop->index+1}}</th>
                                            <td>AIRTEL</td>
                                            <td>A0100000000</td>
                                            <td>AFRICA</td>
                                            <td>B0120000000</td>
                                            <td>NIGERIA</td>
                                            <td>C0123000000</td>
                                            <td>NIGERIA</td>
                             <td>{{$item->territory->lga->area->state->zone->region->country->country_code}}</td>
                                            <td>{{$item->territory->lga->area->state->zone->region->name}}</td>
                                            <td>{{$item->territory->lga->area->state->zone->region->region_code}}</td>
                                            <td>{{$item->territory->lga->area->state->zone->name}}</td>
                                            <td>{{$item->territory->lga->area->state->zone->zone_code}}</td>
                                            <td>{{$item->territory->lga->area->state->name}}</td>
                                            <td>{{$item->territory->lga->area->state->state_code}}</td>
                                            <td>{{$item->territory->lga->name}}</td>
                                            <td>{{$item->territory->lga->lga_code}}</td>
                                            <td> {{$item->territory->lga->area->name}}</td>
                                            <td> {{$item->territory->lga->area->area_code}}</td>
                                            <td>{{$item->territory->name}}</td>
                                            <td>{{$item->territory->territory_code}}</td>
                                            <td>{{$item->classification}}</td>
                                            <td>{{$item->class_code}}</td>
                                            <td>{{$item->category}}</td>
                                            <td>{{$item->category_code}}</td>
                                            <td>{{$item->site_id}}</td>
                                            <td>{{$item->site_code}}</td>
                                            <td> {{$item->msc_name}}</td>
                                            <td> {{$item->msc_code}}</td>
                                            <td>{{$item->bsc_name}}</td>
                                            <td> {{$item->bsc_code}}</td>
                                            <td>{{$item->bts_type}}</td>
                                            <td>Network Code</td>
                                            <td>{{$item->cell_id}}</td>
                                            <td>{{$item->cell_code}}</td>
                                            <td>{{$item->city}}</td>
                                            <td>{{$item->city_code}}</td>
                                            <td>{{$item->type}} </td>
                                            <td>{{$item->longitude}}</td>
                                            <td>{{$item->latitude}}</td>
                                            <td>{{$item->operational_date}}</td>
                                            <td>{{$item->lac}}</td>
                                            <td>{{$item->ci}}</td>
                                            <td>{{$item->cgi}}</td>
                                            <td>{{$item->bsc_rnc}}</td>
                                            <td>{{$item->mss}}</td>
                                            <td>{{$item->new_mss_pool}}</td>
                                            <td>{{$item->coverage_area}}</td>
                                            <td>{{$item->town_name}}</td>
                                            <td>{{$item->om_classfication}}</td>
                                            <td>{{$item->commercial_classification}} </td>
                                            <td>{{$item->address}}</td>
                                            <td>{{$item->vendor}}</td>
                                            <td>{{$item->territory->lga->name}}</td>
                                            <td>{{$item->territory->lga->area->state->name}}</td>
                                            <td>{{$item->territory->lga->name.''.$item->territory->lga->area->state->name}}</td>
                                            <td>N/A</td>
                                            <td>{{$item->new_zone}}</td>
                                            <td>{{$item->new_region}}</td>
                                            <td>{{$item->comment}}</td>
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
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
    </script>
@endsection