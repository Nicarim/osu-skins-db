
<h2>{{$skin->name}} created by {{$skin->user->name}}</h2>
<div class="panel panel-success">
    <div class="panel-heading" style="overflow: hidden;">
        Skin Information
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
            <li><b class="glyphicon glyphicon-cloud"></b>
                <span id="skin-size">
                    {{Helpers::formatSizeUnits($skin->size)}}
                </span>
            </li>
            <li><b class="glyphicon glyphicon-list-alt"></b>
                <span id="element-count">
                    {{$skin->SkinElement->count()}}
                </span> elements
            </li>
            <li>{{$skin->template == 1 ? "<b class='glyphicon glyphicon glyphicon-camera'></b> Template Skin" : ""}}</li>
            <li><b class="glyphicon glyphicon-tag"></b>
                <span id="download-count">
                    {{$skin->download_count}}
                </span> times</li>
            <li><b class="glyphicon glyphicon-star-empty"></b>
                <span id="votes-count">
                    {{$skin->votes}}
                </span> times
            </li>
            <li><a href="/skins/download/{{$skin->id}}" onclick="$('#download-count').text(parseInt($('#download-count').text()) + 1);" role="button">
                    <b class="glyphicon glyphicon-save"></b> Download
                </a>
            </li>
        </ul>
    </div>
</div>
<div class="panel panel-primary">
    <!--<div class="panel-heading">Creator's words</div>-->
    <div class="panel-body">
        {{$skin->parsedDescription()}}
    </div>
</div>
@if ($skin->thumbnail == 1)
<h2>Screenshots</h2>
<div class="jumbotron">

    <div class="row">
        <div class="col-xs-6 col-md-3">
            <a class="fancybox thumbnail" rel="group" href="{{last_modified('/previews-content/'.$skin->id.'/thumbnail.png')}}"><img src="{{last_modified('/previews-content/'.$skin->id.'/thumbnails.png')}}" alt="" /></a>
        </div>
    </div>
</div>
@endif