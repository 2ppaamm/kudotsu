@extends('layouts.master')
@section('contents')
<h1>Pay by Kudotsu</h1>
<ul>
    @foreach($errors->all() as $error)
        <li> {{$error }}</li>
    @endforeach
</ul>
{!! Form::open(['url'=>'transactions','class'=>'form']) !!}
    <div class="form-group">
        {!! Form:: hidden('user_id', '1',['required',
        'class'=>'form-control']) !!}
        {!! Form:: hidden('txn_currencyid', '3',['required',
        'class'=>'form-control']) !!}
        {!! Form:: hidden('merchant_code', '1',['required',
        'class'=>'form-control']) !!}
        {!! Form:: hidden('grant_type', 'password',['required',
        'class'=>'form-control']) !!}
        {!! Form:: hidden('client_id', '2',['required',
        'class'=>'form-control','placeholder'=>'client_id = 1']) !!}
        {!! Form:: hidden('client_secret', 'kenthoie',['required',
        'class'=>'form-control','placeholder'=>'client_secret = 123456', 'value'=>'123456']) !!}
        {!! Form::label('Username') !!}
        {!! Form:: text('username', 'pamelaliusm@gmail.com', [
            'required', 'class' => 'form-control', 'placeholder' => 'pamelaliusm@gmail.com',
            'value'=>'pamelaliusm@gmail.com'
        ]) !!}
    </div>
    <div class="form-group">
        {!! Form::label('Amount') !!}
        {!! Form::input('number','amount_in_txn_currency') !!}
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