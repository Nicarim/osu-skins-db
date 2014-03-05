@extends('master')
@section('content')
<div id="wrapper">
    @include('sidebar-skin')
    <div id="page-content-wrapper">
        <div class="container">
            <h2>Skin name</h2>
            <div class="row">
                <div class="col-xs-6 col-md-3">
                    <a class="fancybox thumbnail" rel="group" href="/1389588.jpg"><img src="/1389588-min.jpg" alt="" /></a>
                </div><div class="col-xs-6 col-md-3">
                    <a class="fancybox thumbnail" rel="group" href="/1389588.jpg"><img src="/1389588-min.jpg" alt="" /></a>
                </div>
                <div class="col-xs-6 col-md-4">
                    <form action="/file-upload" class="dropzone dz-clickable dropzone-custom" id="my-awesome-dropzone">


                    </form>
                </div>


            </div>


        </div>
    </div>
</div>
@stop
