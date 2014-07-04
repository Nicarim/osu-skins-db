@foreach ($elements as $element)
<div class="list-group-item">
    <h4 class="list-group-item-heading element-row">
        @if($element->isImage())
            <b class="glyphicon glyphicon-picture" data-type="picture"></b>
        @elseif($element->isAudio())
            <b class="glyphicon glyphicon-volume-up" data-type="sound"></b>
        @elseif($element->isConfig())
            <b class="glyphicon glyphicon-file" data-type="text"></b>
        @else
            <b class="glyphicon glyphicon-file" data-type="other"></b>
        @endif
        @if ($element->isAnimation())
            <b class="glyphicon glyphicon-film"></b>
        @endif
        <a href="/skins-content/{{$element->skin_id}}/{{$element->getFullname()}}"
           rel="skin-element{{$element->ishd == 1 ? '2x' : ''}}"
           class="element-filename {{$element->getClasses(false, $element->issequence == 0)}}" 
           data-elementframe="{{$element->sequence_frame}}"
           data-sequencename="{{$element->className()}}"
           data-filename="{{$element->filename}}"
           data-ishd="{{$element->ishd}}"
           data-elementid="{{$element->id}}">
            {{{$element->getVisibleName()}}}
        </a>
        @if ($element->isAnimation())
            <a href="#" class="glyphicon glyphicon-arrow-down expand-nested-manager"></a>
        @endif
        @if (Auth::check() && Auth::user()->id == $ownerId)
            <span style="float:right;">
            @if ($element->isAnimation())
                <a role="link" onclick="deleteRow(this,{{$element->id}},true)">Delete All</a>
            @else
                <a role="link" onclick="deleteRow(this,{{$element->id}},false)">Delete</a>
            @endif
            </span>
        @endif
        @if($element->isAnimation())
            <div class='nested-manager list-group' style='display:none; padding-top: 20px;'></div>
        @endif
        @if ($element->isAudio())
            <audio id="{{$element->id}}-audio" src="/skins-content/{{$element->skin_id}}/{{$element->getFullname()}}"></audio>
        @endif
    </h4>
    @if ($element->isConfig())
    <pre style="display:none;" id="{{$element->id}}-config">

    </pre>
    @endif
    <p style="min-height:10px;" class="list-group-item-text">
        <span style="float:right;" class="element-size" data-elementsize="{{$element->size}}">
        @if (!$element->isAnimation())
            <b>Size:</b> {{Helpers::formatSizeUnits($element->size)}}
        @endif
        </span>
    </p>
</div>
@endforeach