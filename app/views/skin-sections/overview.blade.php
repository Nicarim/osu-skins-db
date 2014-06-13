
<h2>{{$skin->name}} created by {{$skin->user->name}}</h2>
<div class="panel panel-success">
    <div class="panel-heading" style="overflow: hidden;">
        Skin Informations
        @if (isset($vote))
            <div class="btn-group pull-right">
                <button id="star-skin" data-skinId="{{$skin->id}}" type="button" class="btn btn-sm btn-default">
                    <span class="glyphicon glyphicon-star"></span>
                    <span class="star-text">Unstar</span>
                </button>
            </div>
        @elseif (Auth::check() && Auth::user()->id != $skin->user_id)
            <div class="btn-group pull-right">
                <button id="star-skin" data-skinId="{{$skin->id}}" type="button" class="btn btn-sm btn-default">
                    <span class="glyphicon glyphicon-star"></span>
                    <span class="star-text">Star</span>
                </button>
            </div>
        @endif
    </div>
    <div class="panel-body">
        <ul class="list-unstyled">
            <li>{{$skin->nsfw == 1 ? "<span style='color:red;'><b class='glyphicon glyphicon-flag'></b> NSFW</span>" : ""}}</li>
            <li><b class="glyphicon glyphicon-cloud"></b> {{Helpers::formatSizeUnits($skin->size)}}</li>
            <li><b class="glyphicon glyphicon-list-alt"></b> {{$skin->SkinElement->count()}} elements </li>
            <li>{{$skin->template == 1 ? "<b class='glyphicon glyphicon glyphicon-camera'></b> Template Skin" : ""}}</li>
            <li><b class="glyphicon glyphicon-tag"></b> {{$skin->download_count}} times</li>
            <li><b class="glyphicon glyphicon-star-empty"></b> {{$skin->votes}} times</li>
            <li><a href="/skins/download/{{$skin->id}}" role="button"><b class="glyphicon glyphicon-save"></b> Download</a></li>
        </ul>
    </div>
</div>
<div class="panel panel-primary">
    <!--<div class="panel-heading">Creator's words</div>-->
    <div class="panel-body">
        {{$skin->parsedDescription()}}
    </div>
</div>
<!--
<h2>Screenshots</h2>
<div class="jumbotron">

    <div class="row">
        <div class="col-xs-6 col-md-3">
            <a class="fancybox thumbnail" rel="group" href="/previews-content/{{$skin->id}}/countdown.jpg?cache={{time()}}"><img src="/previews-content/{{$skin->id}}/countdown-preview.jpg" alt="" /></a>
        </div>
        <div class="col-xs-6 col-md-3">
            <a class="fancybox thumbnail" rel="group" href="/1389588.jpg"><img src="/1389588-min.jpg" alt="" /></a>
        </div>
        <div class="col-xs-6 col-md-4">
            <form action="/file-upload" class="dropzone dz-clickable dropzone-custom" id="my-awesome-dropzone">


            </form>
        </div>
    </div>
</div>-->