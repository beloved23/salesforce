 @extends('layouts.auth')
  @section('content')
<div class="inner-bg">
	<div class="container">
		<div class="row">
			<div class="col-sm-6 col-sm-offset-3">
				<div class="social-login-buttons">
					@isset($invalid)
					<div id="error-container" style="background:rgba(1,1,1,0.8); padding:15px;">
						<h3>
							<font color="White">
								<b>{{$invalid}}</b>
							</font>
							<span id="close-error" style="cursor:pointer;color:white;float:right;">
								<i class="fa fa-close"></i>
							</span>
						</h3>
					</div>
					@endisset
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-6 col-sm-offset-3 form-box">
				<div class="form-top">
					<div class="form-top-left">
						<h3>
							<img src="{{ asset('images/airtel.png') }}">
							<br>Login to Airtel Sales Force System</h3>
					</div>
					<div class="form-top-right">
						<i class="fa fa-key"></i>
					</div>
				</div>
				<div class="form-bottom">
					<form name="loginform" method="post" action="{{route('login')}}" class="login-form">
						{{ csrf_field() }}
						<div class="form-group {{ $errors->has('auuid') ? ' has-error' : '' }}">
							<label class="sr-only" for="form-username">Auuid</label>
							<input type="text" required name="auuid" placeholder="Auuid" value="{{ isset($auuid) ? $auuid : '' }}"
							 id="form-username" class="form-username form-control custom-control"> @if ($errors->has('auuid'))
							<span class="help-block">
								<strong>{{ $errors->first('auuid') }}</strong>
							</span>
							@endif

						</div>
						<div class="form-group">
							<label class="sr-only" for="form-password">Password</label>
							<input type="password" required placeholder="Password" name="password" value="" id="form-password"
							 class="form-password form-control custom-control"> @if ($errors->has('password'))
							<span class="help-block">
								<strong>{{ $errors->first('password') }}</strong>
							</span>
							@endif
						</div>
						<a href="">
							<button type="submit" class="btn">Sign in!</button>
						</a>
					</form>

				</div>
			</div>
		</div>

	</div>
	<div align="bottom" style="color:white;"> © 2017 Airtel </div>

</div>
@endsection
@section('pagejs')
   <script>
//Define Hide Global Ajax Loader
function HideGlobalLoader() {
$('.preloader').fadeOut(300);
}
$(document).ready(function(){
HideGlobalLoader();
});

</script> 
@if(session('actionError'))
<script>
        $.notify("{{ session('actionError') }}", {
            animate: {
                enter: 'animated rollIn',
                exit: 'animated rollOut'
            },
                type: 'danger'
        });
</script>
@endif
@endsection

