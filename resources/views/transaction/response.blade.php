@extends('layouts.master')
@section('contents')
    <h1>Pay by Kudotsu</h1>
<ul>
    @foreach($errors->all() as $error)
        <li> {{$error }}</li>
    @endforeach
</ul>
@stop
@section('advertisement')
    @parent
    <p>Pay with Kudos!</p>
@endsection