@extends('layouts.master')
@section('contents')
<h1>Pay by Kudotsu</h1>
<ul>
    @foreach($errors->all() as $error)
        <li> {{$error }}</li>
    @endforeach
</ul>
{!! Form::open(['url'=>'oauth/access_token','class'=>'form']) !!}
    <div class="form-group">
        {!! Form:: text('grant_type', null,['required',
        'class'=>'form-control','placeholder'=>'grant_type = password']) !!}
        {!! Form:: text('client_id', null,['required',
        'class'=>'form-control','placeholder'=>'client_id = 1']) !!}
        {!! Form:: text('client_secret', null,['required',
        'class'=>'form-control','placeholder'=>'client_secret = 123456']) !!}
        {!! Form::label('Username') !!}
        {!! Form:: text('username', null, [
            'required', 'class' => 'form-control', 'placeholder' => 'pamelaliusm@gmail.com'
        ]) !!}
    </div>
    <div class="form-group">
        {!! Form::label('Amount') !!}
        {!! Form::input('number','amount') !!}
    </div>
    <div class="form-group">
        {!! Form:: label('PIN') !!}
        {!! Form:: password('password') !!}
    </div>
    <div class="form-group">
        {!! Form::submit('Pay now', ['class'=>'btn btn-primary']) !!}
    </div>
{!! Form::close() !!}
@stop
@section('advertisement')
    @parent
    <p>Pay with Kudos!</p>
@endsection