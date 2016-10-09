@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Printers</div>

                <div class="panel-body">
                    <div class="row">
                        @foreach(App\Printer::all() as $printer)
                            <div class="col-lg-4 col-md-6">
                                <a href="{{ route('printer_info', ['id' => $printer->id]) }}">
                                    <div id="border-{{str_replace(' ', '', $printer->name)}}" class="panel panel-default" style='border-color: {{ $colors[$printer->state] }};'>
                                        <div id="heading-{{str_replace(' ', '', $printer->name)}}" class="panel-heading" style='background-color: {{ $colors[$printer->state] }}; color: white;'>
                                            <h3 class="panel-title">#{{ $printer->id }} {{ $printer->name }} ({{ $printer->host }})</h3>
                                        </div>
                                        <div class="panel-body">
                                            <center>
                                                <i id='icon-{{str_replace(' ', '', $printer->name)}}' style='color: {{ $colors[$printer->state] }}; font-size: 100px' class="mdi mdi-cloud-print-outline"></i>
                                            </center>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                        @if(count(App\Printer::all()) == 0)
                            <center>
                                No printers found yet!
                            </center>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    $(function (){
        var states = [ @foreach($states as $state)'{{ $state }}',@endforeach ];
        var colors = [ @foreach($colors as $color)'{{ $color }}',@endforeach ];

        @foreach(App\Printer::all() as $printer)
            setInterval(function() {
                $.getJSON( "http://localhost/api/printer/{{ $printer->id }}/1029384756", function( jdata ) {
                    $('#border-{{str_replace(' ', '', $printer->name)}}').css('border-color', colors[jdata['state']]);
                    $('#heading-{{str_replace(' ', '', $printer->name)}}').css('background-color', colors[jdata['state']]);
                    $('#icon-{{str_replace(' ', '', $printer->name)}}').css('color', colors[jdata['state']]);
                })
            }, 1000);
        @endforeach
    });
</script>
@endsection
