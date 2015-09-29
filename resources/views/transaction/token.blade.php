@extends('layouts.master')
@section('contents')
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/3.51/jquery.form.min.js"></script>
    <script>
        // wait for the DOM to be loaded
//        $(document).ready(function() {
            // bind 'myForm' and provide a simple callback function
//            $('#payment').ajaxForm(function() {
 //               alert("Form submitted!");
 //           });
 //       });
    </script>
    <h1>Pay by Kudotsu</h1>
<ul>
    @foreach($errors->all() as $error)
        <li> {{$error }}</li>
    @endforeach
</ul>
{!! Form::open(['action'=>'ActivityController@store','id'=>'payment','class'=>'form', 'method'=>'post']) !!}
    <div class="form-group">
        {!! Form:: hidden('payer_id', '3',['required',
        'class'=>'form-control']) !!}
        {!! Form:: hidden('txn_currencyid', '3',['required',
        'class'=>'form-control']) !!}
        {!! Form:: hidden('merchant_code', '1',['required',
        'class'=>'form-control']) !!}
        {!! Form:: hidden('grant_type', 'password',['required',
        'class'=>'form-control']) !!}
        {!! Form:: hidden('payee_id', '3',['required',
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