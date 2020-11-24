<div class="col-md-6 col-sm-12 col-xs-12">
    <ul class="nav navbar-right panel_toolbox">
        <li><a class="btn btn-app" href="{!! route('roles.index') !!}">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </li>
        <li>
           @can('create_role')
                <button class="btn btn-app" type="submit" value="Save"><i class="fas fa-save"></i>
                    @lang('master.Save')
                </button>
            @endcan
        </li>
    </ul>
</div>

<div class="col-md-12 col-sm-12 col-xs-12 ln_solid"></div>
<div class="row">
    <div class="form-group">
        <label class="control-label col-md-6 col-sm-2 col-xs-12">
            {!!Form::label('role', 'Role Name:')!!}
        </label>
        <div class="col-md-6 col-sm-2 col-xs-12">
            {!!Form::input('text','role',null, array("id"=>"role", "class"=>"form-control","placeholder" => "Enter Role"))!!}
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-md-6 col-sm-2 col-xs-12">
            {!!Form::label('permission', 'Choose Permissions:')!!}
        </label>
        <div class="col-md-6 col-sm-2 col-xs-12">
            {!!Form::select('permission[]',$permissions,null, array("id"=>"role", "size"=>"20",
            "class"=>"form-control","placeholder" => "Enter Role",'multiple'))!!}
        </div>
    </div>
</div>
