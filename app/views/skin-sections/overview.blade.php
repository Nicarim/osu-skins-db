
<h2>{{$skin->name}} created by {{$skin->user->name}}
@if ($skin->hdsupport == 1) <span class="label label-default">HD</span> @endif
</h2>
<div class="panel panel-primary">
    <div class="panel-heading">Creator's words</div>
    <div class="panel-body">
        @if ($skin->nsfw == 1)
        <div class="alert alert-danger">
            <p><b class="glyphicon glyphicon-flag"></b> This skin contains <b>not safe for work</b> content</p>
        </div>
        @endif
        {{$skin->description}}
    </div>
</div>

<h2>Screenshots</h2>
<div class="jumbotron">

    <div class="row">
        <div class="col-xs-6 col-md-3">
            <a class="fancybox thumbnail" rel="group" href="/previews-content/{{$skin->id}}/countdown.jpg?cache={{time()}}"><img src="/previews-content/{{$skin->id}}/countdown-preview.jpg" alt="" /></a>
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