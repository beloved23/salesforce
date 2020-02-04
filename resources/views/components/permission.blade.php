 <!--Display Permissions -->
<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingOne">
      <h4 class="panel-title">
        <a role="button" class="collapsed"  data-toggle="collapse" data-parent="#accordion" href="#collapseOne{{$role->id}}" aria-expanded="true" aria-controls="collapseOne">
          {{$role->name}} Permissions
        </a>
      </h4>
    </div>
    <div id="collapseOne{{$role->id}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
      <div class="panel-body" id="slimtest1">
       <ul class="icheck-list">
       @if(count($permissions)>0)
           @foreach($permissions as $permit)
            <li>
                                                    <input type="checkbox" disabled data-ng-model="{{str_replace(' ','',$permit->name)}}" data-ng-change="changePermission()" class="check" checked id="{{str_replace(' ','-',$permit->id.$permit->name)}}" data-checkbox="icheckbox_square-red">
                                                    <label for="square-checkbox-1">{{$permit->name}}</label>
                                                </li>
       @endforeach  
       @else
             No permissions 
       @endif
      
      
                                            </ul>
      </div>
    </div>
  </div>
</div>
<!--End permissions -->