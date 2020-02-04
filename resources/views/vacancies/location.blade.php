 @extends('layouts.master') 
 @section('pagestyles') 
 <link href="{{ asset('css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('css/buttons.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('css/select.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
 @endsection
  @section('content')
<!-- Page Content -->
<div class="page-wrapper" data-ng-controller="VacancyController">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="white-box p-0">
					<!-- .left-right-aside-column-->
					<div class="page-aside">
						<div class="right-aside">
							<div class="right-page-header">
								<div class="pull-right">
									<input type="text" id="demo-input-search2" placeholder="search contacts" class="form-control"> </div>
								<h3 class="box-title">Vacancies </h3>
							</div>
							<a href="{{route('vacancies.sync')}}" class="btn btn-danger btn-outline">Sync
								<i class="fa fa-refresh"></i>
							</a>
							<div class="clearfix"></div>
							<div class="scrollable">
								<div class="table-responsive">
									<table id="vacancies" class="table m-t-30 table-hover contact-list" data-page-size="50">
										<thead>
											<tr>
												<th></th>
												<th>Profile </th>
												<th>Location</th>
												<th>Location Name</th>
												<th>Location Code</th>
												<th>ID</th>
											</tr>
										</thead>
										<tbody>
											@foreach($vacancies as $item)
											<tr>
												<td></td>
												<td>{{$item->required_profile}}</td>
												<td>
													{{substr($item->location_model,19,strlen($item->location_model)-19)}}
												</td>
												<td>{{$item->location_name}}</td>
												<td>{{$item->location_code}}</td>
												<td>{{$item->id}}</td>
											</tr>
											@endforeach
										</tbody>
								</table>
								<button data-ng-click="recruitSelected()" class="btn btn-block btn-outline margin-top-15 btn-danger">Recruit </button>
							</div>
						</div>
						{{$vacancies->links()}}
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>

@endsection @section('pagejs')
<!-- Footable -->
<script src="{{asset('js/footable.all.min.js')}}"></script>
<!--FooTable init-->
{{--  <script src="{{asset('js/footable-init.js')}}"></script>  --}}
<script src="{{asset('js/controllers/vacancies.js')}}" type="text/javascript"></script>
<script src="{{asset('js/bootstrap-select.min.js')}}" type="text/javascript"></script>
<script src="{{asset('js/datatable.min.js')}}"></script>
<script src="{{asset('js/dataTables.select.min.js')}}"></script>
<script>
		$(function(){ var table = $('#vacancies').DataTable({
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