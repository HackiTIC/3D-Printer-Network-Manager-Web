@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Printers</div>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-6 col-md-offset-3">
                            <center>
                                <form method="POST" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <h1>Upload Files</h1>
                                    <br>
                                    <input  required type="file" name="file" id="file"><br>
                                    Print Quality
                                    <select name='quality'>
                                        <option value='0'>HQ</option>
                                        <option value='1'>HS</option>
                                        <option value='2'>ST</option>
                                        <option value='3'>STR</option>
                                        <option value='4'>WALL</option>
                                    </select>
                                    <br><br>
                                    <button type="submit" class="btn btn-default">Upload Files</button>
                                </form>
                            </center>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
