@extends('master')
@section('content')
<script>

</script>
<div id="wrapper">
    @include('sidebar-skin')
    <div id="page-content-wrapper">
        <div class="container">
            <h2>{{$skin->name}}</h2>
            <div class="panel panel-primary">
                <div class="panel-heading">Creator's words</div>
                <div class="panel-body">
                    <p>Description blablabla</p>
                    <p>Will support markdown</p>
                    <h2><b class="glyphicon glyphicon-arrow-left"></b> On the left, you may be able to see elements for each "Section" <small>And upload as well </small></h2>
                </div>
            </div>

            <h2>Screenshots</h2>
            <div class="jumbotron">

                <div class="row">
                        <div class="col-xs-6 col-md-3">
                            <a class="fancybox thumbnail" rel="group" href="/1389588.jpg"><img src="/1389588-min.jpg" alt="" /></a>
                        </div>
                        <div class="col-xs-6 col-md-3">
                            <a class="fancybox thumbnail" rel="group" href="/1389588.jpg"><img src="/1389588-min.jpg" alt="" /></a>
                        </div>
                    <!--<div class="col-xs-6 col-md-4">
                        <form action="/file-upload" class="dropzone dz-clickable dropzone-custom" id="my-awesome-dropzone">


                        </form>
                    </div>-->
                </div>
            </div>

        </div>
    </div>
</div>
@stop
