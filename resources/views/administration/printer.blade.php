@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div id='formuler' style='display: none;' class="row">
                <div class="col-sm-12">
                    <div class="panel panel-default">
                        <div class="panel-heading" style='color: white;background-color: #009688;'>Job's done! What's next?</div>
                        <div class="panel-body">
                            <center>
                                <h3 id='question'>Is the result in good shape?</h3>
                                <form method="POST">
                                    {{ csrf_field() }}
                                    <input type="submit" id='yes' class="btn btn-success" value='Of course!'>
                                    <input hidden type="number" name='value' id='value' value='1'>
                                    <a id='no' class="btn btn-danger">Not today...</a>
                                    <br>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6 col-md-offset-3">
                                            <select id='form-select' name='wtype' style='display: none;' class="form-control">
                                                @foreach(App\Wtype::all() as $type)
                                                    <option value='{{ $type->id }}'>{{ $type->description }}</option>
                                                @endforeach
                                            </select>
                                            <br>
                                            <input id='form-input' style='display: none;' class="btn btn-danger" type="submit" value="Add Warning">
                                        </div>
                                    </div>
                                </form>
                            </center>
                            <br>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-default" id='p_panel' style='border-color: {{ $colors[$printer->state] }};'>
                        <div id='p_header' class="panel-heading" style='background-color: {{ $colors[$printer->state] }}; color: white;'>
                            <h3 class="panel-title">{{ $printer->name }}</h3>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-12 col-md-4">
                                    <b>Identifier: </b>#{{ $printer->id }}<br>
                                    <b>Host: </b>{{ $printer->host }}<br>
                                    <b>State: </b><span id='state' style='color: {{ $colors [$printer->state] }}'>{{ $states[$printer->state] }}</span><br>
                                    <b>Aprox. Estimated time: </b>{{ $printer->aprox_time }} sec<br>
                                    <b>Elapsed time: </b><span id='elapsed_time'>{{ $printer->elapsed_time }}</span> sec<br>
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <b>Remaining time: </b><span id='estimated_time'>{{ $printer->estimated_time }}</span> sec<br>
                                    <b>Tool0 Temperature: </b><span id='tool0_temp'>{{ $printer->tool0_temp }}</span>ºC<br>
                                    <b>Bed Temperature: </b><span id='bed_temp'>{{ $printer->bed_temp }}</span>ºC<br>
                                    <b>Last Updated: </b>{{ date('F jS, Y \a\t H:i:s', strtotime($printer->updated_at)) }}<br>
                                    <b>Consecutive Errors: </b><span id='consecutive_errors'>{{ $printer->consecutive_errors }}</span> errors
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <center>
                                        <a id='enable_p' @if($printer->state == 1) disabled @endif href="{{ route('enable_printer', ['id' => $printer->id]) }}" class="btn btn-success" role="button">Enable Printer</a>
                                        <br><br>
                                        <a id='disable_p' @if($printer->state == 4) disabled @endif href="{{ route('disable_printer', ['id' => $printer->id]) }}" class="btn btn-danger" role="button">Disable Printer</a>
                                    </center>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div>

                                  <!-- Nav tabs -->
                                  <ul class="nav nav-pills" role="tablist">
                                      <li role="presentation" class="active"><a href="#printer" aria-controls="home" role="tab" data-toggle="tab">Realtime Statistics</a></li>
                                      <li role="presentation"><a href="#order" aria-controls="home" role="tab" data-toggle="tab">Order information</a></li>
                                      <li role="presentation"><a href="#warnings" aria-controls="profile" role="tab" data-toggle="tab">Warnings</a></li>
                                  </ul>

                                  <!-- Tab panes -->
                                  <div class="tab-content">
                                        <div role="tabpanel" class="tab-pane active" id="printer">
                                            <br>
                                            <div class="row">
                                                <div class="col-md-6 col-sm-12">
                                                    <div class="panel panel-default" >
                                                        <div class="panel-heading">
                                                            <h3 class="panel-title">Extruder Current Temperature</h3>
                                                        </div>
                                                        <div class="panel-body">
                                                            <center>
                                                                {!! $tool0_temp->render() !!}
                                                            </center>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-12">
                                                    <div class="panel panel-default" >
                                                        <div class="panel-heading">
                                                            <h3 class="panel-title">Bed Current Temperature</h3>
                                                        </div>
                                                        <div class="panel-body">
                                                            <center>
                                                                {!! $bed_temp->render() !!}
                                                            </center>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 col-sm-12">
                                                    <div class="panel panel-default" >
                                                        <div class="panel-heading">
                                                            <h3 class="panel-title">Current Progress</h3>
                                                        </div>
                                                        <div class="panel-body">
                                                            <center>
                                                                {!! $percentage->render() !!}
                                                            </center>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-12">
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            <h3 class="panel-title">Latest Warnings</h3>
                                                        </div>
                                                        <div class="panel-body">
                                                            {!! $warnings->render() !!}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div role="tabpanel" class="tab-pane active" id="order">
                                            <br>
                                            @if($order)
                                                <b>Filename: </b>{{ $order->filename }}<br>
                                                <b>Quality: </b>{{ $order->quality }}<br>
                                                <b>User: </b>{{ $order->user->name }} ({{ $order->user->email }})<br>
                                                <b>Price: </b>@if($order->price) {{ $order->price }}€ @else 0€ @endif<br>
                                            @else
                                                Whops! Seems like no other print had gone that far in this printer!
                                            @endif
                                        </div>
                                        <div role="tabpanel" class="tab-pane" id="warnings">
                                            <br>
                                            @foreach($printer->warnings->reverse() as $warning)
                                            <div class="panel panel-warning" >
                                                <div class="panel-heading">
                                                    <h3 class="panel-title">{{ date('F jS, Y \a\t H:i:s', strtotime($warning->created_at)) }}</h3>
                                                </div>
                                                <div class="panel-body">
                                                    {{ $warning->type->description }}
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                  </div>

                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script>
    $('#no').click(function() {
        $('#question').text('Sad to hear this... tell us what happened!');
        $('#yes').hide();
        $(this).hide();
        $('#form-select').show();
        $('#form-input').show();
        $('#value').val(0);
    });

    setInterval(function() {
        var states = [ @foreach($states as $state)'{{ $state }}',@endforeach ];
        var colors = [ @foreach($colors as $color)'{{ $color }}',@endforeach ];
        $.getJSON( "http://localhost/api/printer/{{ $printer->id }}/1029384756", function( jdata ) {
            $('#elapsed_time').text(jdata['elapsed_time']);
            $('#estimated_time').text(jdata['estimated_time']);
            $('#tool0_temp').text(jdata['tool0_temp']);
            $('#bed_temp').text(jdata['bed_temp']);
            $('#updated_at').text(jdata['updated_at']);
            $('#consecutive_errors').text(jdata['consecutive_errors']);
            $('#state').text(states[jdata['state']]);
            $('#state').css('color', colors[jdata['state']]);
            $('#p_panel').css('border-color', colors[jdata['state']]);
            $('#p_header').css('background-color', colors[jdata['state']]);
            if(jdata['state'] == 1) {
                $('#formuler').hide();
                $('#disable_p').removeClass('disabled');
                $('#enable_p').addClass('disabled');
            } else if(jdata['state'] == 2) {
                $('#formuler').hide();
                $('#disable_p').removeClass('disabled');
                $('#enable_p').addClass('disabled');
            } else if(jdata['state'] == 3) {
                $('#formuler').show();
                $('#enable_p').addClass('disabled');
                $('#disable_p').addClass('disabled');
            } else if(jdata['state'] == 4) {
                $('#formuler').hide();
                $('#enable_p').removeClass('disabled');
                $('#disable_p').addClass('disabled');
            } else if(jdata['state'] == 5) {
                $('#formuler').hide();
                $('#enable_p').removeClass('disabled');
                $('#disable_p').addClass('disabled');
            } else {
                $('#formuler').hide();
                $('#enable_p').addClass('disabled');
                $('#disable_p').addClass('disabled');
            }
        })
    }, 1000);
</script>
@endsection
