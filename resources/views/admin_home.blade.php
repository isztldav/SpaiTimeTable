@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    You are logged in!
                </div>

            </div>
            <div class="panel panel-default">
                <div class="panel-heading">Version</div>

                <div class="panel-body">
                    @foreach ($offlineversion as $offline)
                        <p><b>Local version: {{{ $offline->version }}}</b></p>
                    @endforeach
                    <p>Online version: {{{ $actualversion }}}</p>
                    {!! Form::open(['url' => '/admin', 'method' => 'get']) !!}
                    {!! Form::submit('Update',['class' => 'btn btn-default', 'name' => 'update']) !!}
                    {!! Form::close() !!}
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
