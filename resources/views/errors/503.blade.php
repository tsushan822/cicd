@section('content')
    <div class="Container_holder">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="error-template">
                        @extends('layouts.error_main')
                        @section('css')
                            <style>
                                body {
                                    background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABoAAAAaCAYAAACpSkzOAAAABHNCSVQICAgIfAhkiAAAAAlwSFlzAAALEgAACxIB0t1+/AAAABZ0RVh0Q3JlYXRpb24gVGltZQAxMC8yOS8xMiKqq3kAAAAcdEVYdFNvZnR3YXJlAEFkb2JlIEZpcmV3b3JrcyBDUzVxteM2AAABHklEQVRIib2Vyw6EIAxFW5idr///Qx9sfG3pLEyJ3tAwi5EmBqRo7vHawiEEERHS6x7MTMxMVv6+z3tPMUYSkfTM/R0fEaG2bbMv+Gc4nZzn+dN4HAcREa3r+hi3bcuu68jLskhVIlW073tWaYlQ9+F9IpqmSfq+fwskhdO/AwmUTJXrOuaRQNeRkOd5lq7rXmS5InmERKoER/QMvUAPlZDHcZRhGN4CSeGY+aHMqgcks5RrHv/eeh455x5KrMq2yHQdibDO6ncG/KZWL7M8xDyS1/MIO0NJqdULLS81X6/X6aR0nqBSJcPeZnlZrzN477NKURn2Nus8sjzmEII0TfMiyxUuxphVWjpJkbx0btUnshRihVv70Bv8ItXq6Asoi/ZiCbU6YgAAAABJRU5ErkJggg==) !important;
                                }

                                .error-template {
                                    padding: 40px 15px;
                                    text-align: center;
                                }

                                .error-actions {
                                    margin-top: 15px;
                                    margin-bottom: 15px;
                                }

                                .error-actions .btn {
                                    margin-right: 10px;
                                }

                                .Container_holder {

                                    display: flex;
                                    justify-content: center;
                                    align-items: center;
                                    height: -webkit-fill-available;
                                    height:fill-available;
                                    height:-moz-fill-available;


                                }
                                .footer_area{
                                    display:none
                                }
                            </style>
                        @stop
                        @section('content')
                            <div class="Container_holder">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="error-template">
                                                <b>Temporarily Down for Maintenance </b>

                                                <p>We should be back online shortly</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        @stop

                        @section('javascript')
                            <script>
                                function goBack() {
                                    window.history.back();
                                }
                            </script>
                        @endsection
                        <div class="error-actions">
                            <a href="/" class="btn btn-primary btn-lg"><i
                                        class="fas fa-home"></i>
                                Home </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@stop

@section('javascript')
    <script>
        function goBack() {
            window.history.back();
        }
    </script>
@endsection