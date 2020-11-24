

{!!Form::open(array(
'route'=>'360t.import.post',
'files' => true)) !!}

<div class="col-md-12 col-sm-12 col-xs-12 form_outher_layer">
    <div class="form-group">
        <label class="col-md-4 col-sm-4 col-xs-12">Import 360T transactions
        </label>
        <div class="col-md-4 col-sm-4 col-xs-12">

            {!! Form::file('360t_excel[]', array('multiple'=>true)) !!}
            <span class="help-block">
                            Please input one or more files

                        </span>
        </div>
        <div class="col-md-4 col-sm-4 col-xs-12">
            <button class="btn btn-app" type="submit" value="submit" name="submit"><i class="fa fa-cloud-upload"></i> Import</button>

        </div>

    </div></div>
{!! Form::close() !!}