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
    @if($private)
        <h2>My skins</h2>
    @endif
    <ul class="pager">
        @if (Input::has("p") && Input::get("p") > 1)
            <li class="previous"><a href="{{'/'.Request::path().'?p='.(Input::get('p') - 1)}}">&larr; Previous Page</a></li>
        @else
            <li class="previous disabled"><a href="#">&larr; Previous Page</a></li>
        @endif
        @if ($canShowMore)
            @if (Input::has("p") && Input::get("p") > 1)
                <li class="next"><a href="{{'/'.Request::path().'?p='.(Input::get('p') + 1)}}">Next Page &rarr;</a></li>
            @else
                <li class="next"><a href="{{'/'.Request::path().'?p=2'}}">Next Page &rarr;</a></li>
            @endif
        @else
            <li class="next disabled"><a href="#">Next Page &rarr;</a></li>
        @endif

    </ul>
    @include('listing-skin-panel', array("skins" => $skins, "private" => $private))
</div>
@stop