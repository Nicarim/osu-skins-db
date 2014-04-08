@extends('master')
@section('content')

<!--<div class="row">
    <div class="skin-panel">
        <div class="col-md-5">
            <h1> My awesome skin </h1>
        </div>
        <div class="col-md-3">
            <a href="#">Button1</a>
            <a href="#">Button2</a>
            <a href="#">Button3</a>
            <a href="#">Button4</a>
        </div>
    </div>
</div>-->

<div class="container">
    @include('listing-skin-panel', array("skins" => $skins))
</div>
@stop