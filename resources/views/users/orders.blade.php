@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">My Orders</div>

                <div class="panel-body">
                    <div class="row">
                        @foreach($orders->reverse() as $order)
                            <div class="col-sm-12">
                                <div class="panel">
                                    <div class="panel-heading">
                                        {{ date('F jS, Y \a\t H:i:s', strtotime($order->created_at)) }}
                                    </div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <b>ID: </b>#{{ $order->id }}
                                            </div>
                                            <div class="col-md-4">
                                                <b>File: </b>{{ $order->filename }}
                                            </div>
                                            <div class="col-md-4">
                                                <b>Quality: </b>{{ $order->quality }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
