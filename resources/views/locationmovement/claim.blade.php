<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="keywords" content="">
	<meta name="description" content="">
	<meta name="author" content="">
	<link rel="icon" type="image/png" sizes="16x16" href="../plugins/images/favicon.png">
	<title>Claim Role Movement | SalesForce</title>
	<!-- ===== Bootstrap CSS ===== -->
	<link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">
	<!-- ===== Animation CSS ===== -->
	<link href="{{asset('css/animate.css')}}" rel="stylesheet">
	<link href="{{asset('css/toastr.css') }}" rel="stylesheet">

	<!-- ===== Custom CSS ===== -->
	<link href="{{asset('css/style.css')}}" rel="stylesheet">
	<!-- ===== Color CSS ===== -->
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body data-ng-app="myApp" data-ng-controller="myController">
	<!-- Preloader -->
	<div class="preloader" style="background:rgba(1,1,1,0.7) !important;">
		<div class="cssload-speeding-wheel"></div>
	</div>
	<section id="wrapper" class="login-register" style="background: url({{asset('images/slava-bowman.jpg')}}) center/cover no-repeat !important;">
		<div class="login-box" style="margin: 4% auto 0 !important">
			<div class="white-box">
				<div class="text-center">
					<h2>Select your account</h2>
				</div>
				<div class="message-center">
					@foreach($allHR[0]->users as $item)
					<a data-ng-click="onSelectAccount({{$loop->index}})" data-toggle="modal" data-target="#responsive-modal" href="javascript:void(0);">
						<div class="user-img">
							<img src="{{asset('storage')}}/{{$item->profile->profile_picture}}" alt="user" class="img-circle">
							<span class="profile-status away pull-right"></span>
						</div>
						<div class="mail-contnet">
							<h5>{{$item->profile->first_name.' '.$item->profile->last_name}}</h5>
							<span class="mail-desc">{{$item->email}}</span>
							<span class="time">Auuid: {{$item->auuid}}</span>
						</div>
					</a>
					@endforeach
				</div>
				<div class="text-center p-10">{{$allHR->links()}}</div>

			</div>
		</div>
	</section>
	<div id="responsive-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"
	 style="display: none;">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title">Authentication</h4>
				</div>
				<div class="modal-body">
					<form>
						<div class="form-group">
							<label for="recipient-name" class="control-label">HR: @{{hrFullName}}
								<span class="m-l-10">Email: @{{hrEmail}}</span>
							</label>
							<div class="form-group ">
								<label for="message-text" class="control-label">Password</label>
								<input data-ng-model="password" data-ng-keyup="authenticateOnEnter($event)" type="password" class="form-control" placeholder="Password"
								 id="message-text"></input>
							</div>
							<button type="button" data-ng-click="authenticate()" class="btn btn-danger btn-lg btn-block waves-effect waves-light">Authenticate</button>
					</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>
		@include('footer')

		<!-- jQuery -->
		<script src="{{asset('js/jquery.min.js')}}"></script>
		<!-- Bootstrap Core JavaScript -->
		<script src="{{asset('js/bootstrap.min.js')}}"></script>
		<!-- Menu Plugin JavaScript -->
		<script src="{{asset('js/sidebarmenu.js')}}"></script>
		<!--slimscroll JavaScript -->
		<script src="{{asset('js/jquery.slimscroll.js')}}"></script>
		<!--Wave Effects -->
		<script src="{{ asset('js/toastr.min.js') }} "></script>
		<script src="{{asset('js/waves.js')}}"></script>
		<!-- Custom Theme JavaScript -->
		<script src="{{asset('js/custom.js')}}"></script>
		<script src="{{ asset('js/sweetalert.min.js') }}"></script>

		<!--Style Switcher -->
		<script src="{{asset('js/jQuery.style.switcher.js')}}"></script>
		<script src="{{ asset('js/angular.js') }} "></script>

		<script>
			$('.message-center').slimScroll({
        height: '450px'
    });
         var app_url = "{{config('app.url')}}/";
    var app  = angular.module('myApp',[]);
    app.controller('myController',function($scope,$http){
        $scope.allHr = allHR;
        $scope.locationMovementId = locationMovementId;
        $scope.token = verificationToken;
        $scope.onSelectAccount = function(index){
            $scope.selectedHr = $scope.allHr[index];
            $scope.hrFullName = $scope.selectedHr.profile.first_name+' '+$scope.selectedHr.profile.last_name;
            $scope.hrEmail = $scope.selectedHr.email;
        }
        $scope.authenticate = function(){
            //perform validation
            if(angular.isDefined($scope.password)){
                if($scope.password.trim().length > 1){
                    ShowGlobalLoader();
                    var data = "hrId=" + encodeURIComponent($scope.selectedHr.id) + "&token=" + encodeURIComponent($scope.token) 
                     + "&locationMovementId="+encodeURIComponent($scope.locationMovementId)+"&password="+encodeURIComponent($scope.password);
                    var config = { headers: { 'Content-Type': 'application/x-www-form-urlencoded' } };
                    $http.post(app_url + "location/movement/claim/verify", data, config).success(function(data) {
                        HideGlobalLoader();
                          if (data.validations && data.action) {
                            GlobalSuccessNotification(data.message);
                            setTimeout(function(){
                            window.location.href = app_url+'login?token='+data.userToken+"&redirect_route="+data.routeToken+"&id="+$scope.locationMovementId;
                            },3000);
                        } else {
                            GlobalWarningNotification('An error occured with message ' + data.message);
                        } 
                    }).error(function(error) {
                        HideGlobalLoader();
                        GlobalInfoNotification('An error occured while processing this request. Please try again');
                        alert(JSON.stringify(error));
                    });
                }
                else{
                GlobalInfoNotification('Please provide password');
                }
            }
            else{
                GlobalInfoNotification('Please provide password');
            }
        }
        $scope.authenticateOnEnter = function(event){
            if(event.keyCode==13){
                $scope.authenticate();
            }
        }
    });
    function ShowGlobalLoader(){
        $('.preloader').show();
    }
    function HideGlobalLoader(){
        $('.preloader').hide();
    }
    //Define Global Notification function
function GlobalInfoNotification(message) {
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "60000",
        "hideDuration": "10000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "escapeHtml": true,
        "hideMethod": "fadeOut"
    }
    toastr["info"](message, "Notification");
}
    //Define Global Notification function
function GlobalSuccessNotification(message) {
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "60000",
        "hideDuration": "10000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "escapeHtml": true,
        "hideMethod": "fadeOut"
    }
    toastr["success"](message, "Notification");
}
    //Define Global Notification function
function GlobalWarningNotification(message) {
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "60000",
        "hideDuration": "10000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "escapeHtml": true,
        "hideMethod": "fadeOut"
    }
    toastr["warning"](message, "Notification");
}
		</script>
</body>

</html>