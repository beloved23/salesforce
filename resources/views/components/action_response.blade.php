    @if(Session::has('actionSuccessMessage'))
        <script>
        GlobalSuccessNotification("{{session('actionSuccessMessage')}}");
        </script>
    @endif
    @if(Session::has('actionWarningMessage'))
        <script>
        GlobalWarningNotification("{{session('actionWarningMessage')}}");
        </script>
    @endif
    @if(Session::has('actionErrorMessage'))
                <script>
                GlobalErrorNotification("{{session('actionErrorMessage')}}")
                </script>
    @endif
       {{--  Validation Error  --}}
      @if ($errors->any())
            @foreach ($errors->all() as $error)
            <script >
              GlobalErrorNotification("{{$error}}");
            </script>
            @endforeach
@endif
