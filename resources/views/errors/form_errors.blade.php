@if(isset($errors) && $errors->any())
    <div class="container pl-0">
        <div class="row">
            <div class="col-sm-12 pl-0 text-left">
                @foreach ($errors->all() as $error)
                    <div class="chip mt-2 mb-0 text-white waves-effect waves-effect red">
                        {!! $error !!}
                        <i class="close fas fa-times"></i>
                    </div>

                @endforeach

            </div>
        </div>
    </div>
@endif