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
        <a href="/skins-content/{{$element->skin_id}}/{{$element->getFullname()}}"
           rel="skin-element{{$element->ishd == 1 ? '2x' : ''}}"
           class="element-filename {{$element->getClasses()}}" 
           data-elementframe="{{$element->sequence_frame}}"
           data-sequencename="{{$element->className()}}"
           data-elementid="{{$element->id}}">
            {{$element->getName()}}
        </a>
        @if (Auth::check() && Auth::user()->id == $ownerId)
            <span style="float:right;">
                <a role="link" onclick="deleteRow(this,{{$element->id}})">Delete</a>
            </span>
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
            <b>Size:</b> {{Helpers::formatSizeUnits($element->size)}}
        </span>
    </p>
</div>
@endforeach