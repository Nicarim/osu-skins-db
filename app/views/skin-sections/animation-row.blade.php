@foreach ($elements as $element)
<div class="list-group-item">
    <h4 class="list-group-item-heading element-row">
        <b class="glyphicon glyphicon-picture" data-type="picture"></b>
        <a href="/skins-content/{{$element->skin_id}}/{{$element->getFullname()}}?{{strtotime($element->updated_at)}}"
           class="element-filename {{$element->getClasses(false)}}" 
           data-elementframe="{{$element->sequence_frame}}"
           data-sequencename="{{$element->className()}}"
           data-elementid="{{$element->id}}">
            {{{$element->getName()}}}
        </a>
        @if (Auth::check() && Auth::user()->id == $ownerId)
            <span style="float:right;">
                <a role="link" onclick="deleteRow(this,{{$element->id}}, false)">Delete</a>
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
    <p style="min-height:10px;font-size:14px;" class="list-group-item-text">
        <span style="float:right;" class="element-size" data-elementsize="{{$element->size}}">
            <b>Size:</b> {{Helpers::formatSizeUnits($element->size)}}
        </span>
    </p>
</div>
@endforeach