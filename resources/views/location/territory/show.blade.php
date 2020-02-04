@extends('layouts.master')

@section('pagestyles')
    @include('components.location_show_css')
@endsection

@section('content')
     <div class="page-wrapper" >
            <div class="container-fluid">
              <form action="{{route('territory.update',$territory->id)}}" id="modify-form" method="POST">
                    {{method_field("PUT")}}
                    {!! Form::token() !!}
                    <div class="row">    
                    <div class="col-md-6">
                                      <div class="white-box">
                                      <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-12">
                                 <h4 class="box-title">Country</h4>
                               {{$country}}
                                </div>
                                <div class="col-lg-12">
                                 <h4 class="box-title">Region</h4>
                                 {{$region}}
                                </div>
                                 <div class="col-lg-12">
                                 <h4 class="box-title">Zone</h4>
                                 {{$zone}}
                                </div>
                                 <div class="col-lg-12">
                                 <h4 class="box-title">Lga</h4>
                                  {{$lga}}
                                </div>
                    <div class="col-lg-12">
                                    <h4 class="box-title">Territory name</h4>
                                <input type="text" required value="{{$territory->name}}" class="form-control" name="name" />
                                </div>
                                <div class="col-lg-12">
                                    <h4 class="box-title">Territory code</h4>
                                    <input type="text" required value="{{$territory->territory_code}}" class="form-control" name="code" />
                                </div>
                                <div class="col-lg-12">
                                <button type="submit" class="btn btn-info btn-block btn-lg m-r-20 margin-top-30">Update Zone</button>
                                </div>
                               
                                </div>
                                </div>
                                </div>
                                </div>
                               
                    <div class="col-md-6">
                        <div class="white-box">
                            <h3 class="box-title">More Information</h3>
                            <div class="row line-steps">
                                <div class="col-md-3 column-step start">
                                    <div class="step-number"><i class="icon-globe"></i></div>
                                    <div class="step-title">Sites</div>
                                    <div class="step-info">Total: <span class="font-dark"> {{$siteCount}}  </span></div>
                                </div>
                            </div>
                             <select id="select-user" class="select-picker" name="selected_md" data-ng-validation="select_option" data-style="form-control">
                             @foreach($profiles as $user)
                                        <option value="{{$user->user_id}}">{{$user->userprofile->last_name.' '.$user->userprofile->first_name}}</option>
                             @endforeach
                             
                             @isset($territory->mdByLocation)
                <option selected value="{{$territory->mdByLocation->user_id}}">{{$territory->mdByLocation->userprofile->last_name.' '.$territory->mdByLocation->userprofile->first_name.' | '.$territory->mdByLocation->user->auuid}}</option>
                             @endisset
                             
                                    </select>
                        </div>
                    </div>
                            </div>
                             </form>
</div>
</div>
@endsection

   @section('pagejs')
@include('components.location_show')
@include('components.action_response')
    <script src="{{asset('js/jquery.form-validator.js')}}"></script>
        <script src="{{ asset('js/bootstrap-select.min.js') }}"></script>
         <script src="{{asset('js/select2.min.js')}}"></script>
    <script>
    $.validate();
    $(".select-picker").selectpicker({iconBase:"fa",tickIcon:"fa-check"})
    </script>
@endsection