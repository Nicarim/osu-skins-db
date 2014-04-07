@extends('master')
@section('content')
<div class="container">
    <h1>Welcome {{Auth::check() ? Auth::user()->name."!" : "stranger! Please log in to create new skins or vote up existing one."}} </h1>
</div>
@stop