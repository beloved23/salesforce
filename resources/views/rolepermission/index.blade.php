@extends('layouts.master')
@section('pagestyles')
            <link href="{{ asset('css/scrollable.css') }}" rel="stylesheet">
             <link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet">
                 <link href="{{asset('css/select2.min.css')}}" rel="stylesheet" />
@endsection

@section('content')
     <!-- Page Content -->
        <div data-ng-controller="RolePermissionController" id="RolePermissionController" class="page-wrapper">
            <div class="container-fluid">
                <!--.row-->
                <div class="row">
                    <div class="col-md-6">
                        <div class="white-box">
                            <h3 class="box-title m-b-0">Roles and Permissions Creation</h3>
                            <br />
                        <div class="panel panel-info">
                            <div class="panel-heading">Available Roles
                                <div class="pull-right"><a href="#" data-perform="panel-collapse"><i class="ti-minus"></i></a> <a href="#" data-perform="panel-dismiss"><i class="ti-close"></i></a> </div>
                            </div>
                            <div class="panel-wrapper collapse" aria-expanded="true">
                                <div class="panel-body" id="slimtest2">
                                @verbatim
                              <ul class="list-group">

                               <li data-ng-repeat="role in roles" class="list-group-item">
                               {{role.name}}
                               <span data-ng-mouseover="showTip(role.id+'AppRole')"  id="{{role.id+'AppRole'}}" data-pt-title="Delete {{role.name}} role" data-ng-click="destroyRole(role.id,role.name)" class="badge cursor-pointer tooltip-primary">{{usersPerRole[$index]}} <i class="fa fa-trash"></i></span>
                               </li>
                               </ul>
                                @endverbatim
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-info">
                            <div class="panel-heading">Available Permissions
                                <div class="pull-right"><a href="#" data-perform="panel-collapse"><i class="ti-minus"></i></a> <a href="#" data-perform="panel-dismiss"><i class="ti-close"></i></a> </div>
                            </div>
                            <div class="panel-wrapper collapse" aria-expanded="true">
                                <div class="panel-body" id="availablePermissionsScroll">
                                @verbatim
                              <ul class="list-group">

                               <li data-ng-repeat="permit in permissions" class="list-group-item">
                               {{permit.name}}
                               <span data-ng-mouseover="showTip(permit.id+'AppPermission')"  id="{{permit.id+'AppPermission'}}" data-pt-title="Delete {{permit.name}} permission" data-ng-click="destroyPermission(permit.id,permit.name)" class="badge cursor-pointer tooltip-primary"> <i class="fa fa-trash"></i></span>
                               </li>
                               </ul>
                                @endverbatim
                                </div>
                            </div>
                        </div>
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                  <div class="text-muted m-b-30 font-15 text-center"> Create Role </div>
                                        <div class="form-group">
                                            <label for="exampleInputuname">Role Name</label>
                                            <div class="input-group">
                                                <div class="input-group-addon"><i class="fa fa-male"></i></div>
                                                <input data-ng-model="roleName" type="text" class="form-control" id="exampleInputuname" placeholder="Role Name"> </div>
                                        </div>
                                        <button type="submit" data-ng-click="createRole()" class="btn btn-success btn-block waves-effect waves-light m-r-10">Submit</button>
                                </div>
                                   <div class="col-sm-12 col-xs-12">
                                  <div class="text-muted m-b-30 font-15 text-center margin-top-10"> Create Permission</div>
                                        <div class="form-group">
                                            <label for="exampleInputuname">Permission Name</label>
                                            <div class="input-group">
                                                <div class="input-group-addon"><i class="fa fa-male"></i></div>
                                                <input data-ng-model="permissionName" type="text" class="form-control" placeholder="Permission Name"> </div>
                                        </div>
                                        <button type="submit" data-ng-click="createPermission()" class="btn btn-success btn-block waves-effect waves-light m-r-10">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="white-box">
                            <h3 class="box-title m-b-0">Roles and Permissions Assignment</h3>
                            <p class="text-muted m-b-30 font-13">Assign to user or role </p>
                            <div class="row">
                            @verbatim
                                <div class="col-sm-12 col-xs-12">
                                            <select id="usersListForSelection" data-ng-model="selectedUsers" class="width-full" multiple="multiple" data-placeholder="Search for user via auuid or email">
                                    <option data-ng-repeat="user in chooseUsers" value="{{user.id}}">ID: {{user.id}} Email: {{user.email}}</option>
                            </select>
                                                        <div class="text-muted font-13 margin-top-10">Roles</div>
                                        <select id="rolesListForSelection" data-ng-model="selectedRoles" class="form-control selectpicker margin-top-10" multiple data-style="form-control">
                                        <option value="{{role.id}}" data-ng-repeat="role in roles">{{role.name}}</option>
                                    </select>
                                                                <div class="text-muted font-13 margin-top-10">Permissions</div>
                                     <select id="permissionsListForSelection" data-ng-model="selectedPermissions" class="form-control selectpicker margin-top-10" multiple data-style="form-control">
                                        <option value="{{permit.id}}" data-ng-repeat="permit in permissions">{{permit.name}}</option>
                                    </select>
                                    <br />
                                <div class="col-md-6 margin-top-20">
                                                                 <button data-ng-click="assignToUsers()" class="btn btn-info waves-effect waves-light m-r-10 btn-block margin-top-10">Assign to User</button>
                                </div>
                                <div class="col-md-6 margin-top-20">
                                                                 <button data-ng-click="assignToRoles()" class="btn btn-danger waves-effect waves-light m-r-10 btn-block margin-top-10">Assign to Role</button>
                                </div>
                                <br />
                                                            <h3 class="box-title m-b-10 text-center margin-top-20">Profile User or Role</h3>
                                                            <br/>
                                                          <div class="col-md-9 margin-bottom-20">
                                                               <select id="profileUsersForSelection" data-ng-model="selectedProfileElement" class="width-full margin-bottom-20" data-placeholder="Choose User or Role">
                        <option></option>
                            </select>
                                                          </div>
                                                          <div class="col-md-3 margin-bottom-20">
                                                         <select data-ng-model="filterAction" id="profileActionFilters" class="margin-bottom-20 m-l-10" data-style="form-control">
                                        <option value="USER">Filter By User</option>
                                        <option value="ROLE">Filter By Role</option>
                                    </select>
                                                          </div>
                                                                                 <button data-ng-click="initiateFiltering()" class="btn btn-warning waves-effect waves-light m-r-10 btn-block margin-top-10 margin-bottom-20">Go</button>
                                                          
                            <br />
                                        <div class="col-md-6">
                                                <div class="panel panel-info">
                            <div class="panel-heading">Role(s)
                                <div class="pull-right"><a href="#" data-perform="panel-collapse"><i class="ti-minus"></i></a> <a href="#" data-perform="panel-dismiss"><i class="ti-close"></i></a> </div>
                            </div>
                            <div class="panel-wrapper collapse" aria-expanded="true">
                                <div class="panel-body" id="profileRolesScroll">
                              <ul class="list-group">
                               <li data-ng-repeat="role in profileRoles" class="list-group-item">
                               {{role.name}}
                               <span  id="{{role.id+'AppRoleForProfile'}}"  data-ng-click="deleteRoleForUser(filterAction,role.pivot.model_id,role.id,role.name)" class="badge cursor-pointer tooltip-primary"><i class="fa fa-trash"></i></span>
                               </li>
                               </ul>
                                </div>
                            </div>
                        </div>
                                        </div>
                                        <div class="col-md-6">
                                                <div class="panel panel-info">
                            <div class="panel-heading">Permission(s)
                                <div class="pull-right"><a href="#" data-perform="panel-collapse"><i class="ti-minus"></i></a> <a href="#" data-perform="panel-dismiss"><i class="ti-close"></i></a> </div>
                            </div>
                            <div class="panel-wrapper collapse" aria-expanded="true">
                                <div class="panel-body" id="profilePermissionsScroll">
                              <ul class="list-group">

                               <li data-ng-repeat="permit in profilePermissions" class="list-group-item">
                               {{permit.name}}
                               <span data-ng-mouseover="showTip(permit.id+'AppRole')"  id="{{permit.id+'AppRole'}}" data-pt-title="Delete '{{permit.name}}' permission" data-ng-click="deletePermissionForUserOrRole(filterAction,permit.pivot.model_id,permit.id,permit.name)" class="badge cursor-pointer tooltip-primary"><i class="fa fa-trash"></i></span>
                               </li>
                               </ul>
                                </div>
                            </div>
                        </div>
                                        </div>
                                </div>
                                 @endverbatim
                            </div>
                        </div>
                    </div>
                </div>
                <!--./row-->
                </div>
                </div>
@endsection


@section('pagejs')
    <script src="{{asset('js/controllers/role.permission.js')}}"></script>
        <script src="{{asset('js/select2.min.js')}}"></script>
 <script src="{{asset('js/bootstrap-select.min.js')}}"></script>
        <script>
                $(document).ready(function() {
    $('#profileActionFilters').select2();
  $("#usersListForSelection").select2(
     {
  ajax: {
    url: app_url+"users/search",
    dataType: 'json',
    delay: 250,
    data: function (params) {
      return {
        q: params.term, // search term
        page: params.page
      };
    },
    processResults: function (data, params) {
      // parse the results into the format expected by Select2
      // since we are using custom formatting functions we do not need to
      // alter the remote JSON data, except to indicate that infinite
      // scrolling can be used
      params.page = params.page || 1;

      return {
        results: data.items,
        pagination: {
          more: (params.page * 30) < data.total_count
        }
      };
    },
    cache: true
  },
  placeholder: 'Search for a User',
  escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
  minimumInputLength: 3,
templateResult: formatRepo,
  templateSelection: formatRepoSelection  
}
  );
  $("#profileUsersForSelection").select2(
     {
  ajax: {
    url: app_url+"rolepermission/search",
    dataType: 'json',
    delay: 250,
    data: function (params) {
      return {
        q: params.term, // search term
        page: params.page
      };
    },
    processResults: function (data, params) {
      // parse the results into the format expected by Select2
      // since we are using custom formatting functions we do not need to
      // alter the remote JSON data, except to indicate that infinite
      // scrolling can be used
      params.page = params.page || 1;

      return {
        results: data.items,
        pagination: {
          more: (params.page * 30) < data.total_count
        }
      };
    },
    cache: true
  },
  placeholder: 'Search for a User or role',
  escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
  minimumInputLength: 3,
templateResult: formatRepo,
  templateSelection: formatProfileSelection 
}
  );

function formatRepo (repo) {
  if (repo.loading) {
    return repo.id;
  }
    var markup =  "<a href='javascript:void(0);'>"+
                 "<div class='user-img'>"+
                "<img style='width:40px;height:40px;' src='" + app_url +"storage/"+repo.profile_main.profile_picture+ "' alt='user' class='img-circle'>"+
                 "<span class='profile-status busy pull-right'></span>"+
                " </div><div style='color:black' class='mail-contnet hover-white'>"+
                "<span> User AUUID: " +repo.auuid+ " <span style='padding-right:10px;'> Email  "+repo.email +" </span></span>"+
                "</div></a>";
  return markup;
}

function formatRepoSelection (repo) {
  return repo.auuid;
}
function formatProfile (repo) {
  if (repo.loading) {
    return repo.auuid;
  }

  if(repo.name){
  var markup = "<div class='' >ID: " +repo.id+ "<span class='margin-left-10'> Name : "+repo.name+"</span></div>";
  return markup;
  }
  if(repo.email){
  var markup = "<div class='' >ID: " +repo.id+ "<span class='margin-left-10'> Email : "+repo.email+"</span></div>";
  return markup;
  }
}
function formatProfileSelection (repo) {
    if(repo.name){
  return repo.name;
    }
    if(repo.id){
        return repo.auuid;
    }
}

});
        </script>
@endsection