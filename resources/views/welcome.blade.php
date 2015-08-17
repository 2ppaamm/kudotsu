<!DOCTYPE html>
<html>
    <head>
        <title>Laravel</title>

        <link href="//fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                display: table;
                font-weight: 100;
                font-family: 'Lato';
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 96px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <div class="title">Laravel 5 for NFC</div>
{!! Form::open(['url'=>'http://kudotsu.pamelalim.me/transactions/store','class'=>'form']) !!}
    <div class="form-group">
        {!! Form::label('UserID/Email') !!}
        {!! Form:: text('user_id', null, [
            'required', 'class' => 'form-control', 'placeholder' => 'pamelaliusm@gmail.com'
        ]) !!}
    </div>
    <div class="form-group">
        {!! Form:: label('Password') !!}
        {!! Form:: password('password') !!}
    </div>
    <div class="form-group">
        {!! Form::label('Amount') !!}
        {!! Form::input('number','amount_in_txn_currency') !!}
    </div>
    <div class="form-group">
        {!! Form::submit('Pay now', ['class'=>'btn btn-primary']) !!}
    </div>
{!! Form::close() !!}
            </div>
        </div>
    </body>
</html>
