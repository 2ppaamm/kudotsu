@extends('layouts.master')
@section('contents')
<h1>List of Transactions</h1>
<table class="table borderless">
    @foreach($transactions as $transaction)
        @include(('transaction.activity'), array('transaction'=> $transaction))
    @endforeach
</table>
@endsection
@section('advertisement')
    @parent
    <p>Buy more pigs that fly</p>
@endsection