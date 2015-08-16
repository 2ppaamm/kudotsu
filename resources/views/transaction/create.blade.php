@extends('layouts.master')
@section('contents')
<h1>Pay by Kudotsu</h1>
<ul>
    @foreach($errors->all() as $error)
        <li> {{$error }}</li>
    @endforeach
</ul>
{!! Form::open(['route'=>'transactions.store','class'=>'form']) !!}
    <div class="form-group">
        {!! Form::label('Username') !!}
        {!! Form:: text('name', null, [
            'required', 'class' => 'form-control', 'placeholder' => 'pamelalim'
        ]) !!}
    </div>
    <div class="form-group">
        {!! Form:: label('Password') !!}
        {!! Form:: password('secret') !!}
    </div>
    <div class="form-group">
        {!! Form::label('Amount') !!}
        {!! Form::input('number','amount') !!}
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