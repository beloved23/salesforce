

       @extends('layouts.master')
       
       @section('pagestyles')
  <link rel="stylesheet" href="{{asset('css/jquery.orgchart.min.css')}}">
  <link rel="stylesheet" href="{{asset('css/chart-style.css')}}">
       @endsection
       
        @section('content')
 <!-- Page Content -->
        <div class="page-wrapper">
            <div class="container-fluid">
                <!-- .row -->
                <div class="row">
                    <div class="col-sm-12">
                <h4 class="box-title text-center">My Downline Organogram</h4>
  <div class="chart-container"></div>
</div></div> 
<!--end first row -->

</div></div>
        @endsection

        @section('pagejs')
  <script type="text/javascript" src="{{asset('js/html2canvas.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('js/jquery.orgchart.min.js')}}"></script>
<script type = "text/javascript" >
    $(function() {
        var customDatasource = {
        'auuid': '1',
        'name': datasource[0].userprofile.first_name+' '+datasource[0].userprofile.last_name,
        'title': datasource[0].title,
        'children': datasource[0].children,
        'userprofile':datasource[0].userprofile,
    };

        $('.chart-container').orgchart({
            'data': customDatasource,
            'depth': 4,
            'nodeContent': 'title',
            'nodeID': 'auuid',
            'exportButton': true,
             'exportFilename': 'SalesForce Chart',
            'direction':'l2r'
        });
    });
     </script>    
     <script>
     //hide footer
     $('.footer').hide();
     </script>
        @endsection