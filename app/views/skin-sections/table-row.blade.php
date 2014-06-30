@foreach ($elements as $element)
<div class="list-group-item">
    <h4 class="list-group-item-heading element-row">
        <a href="/skins-content/{{$element->skin->id}}/{{$element->getFullname()}}"
           rel="skin-element{{$element->ishd == 1 ? '2x' : ''}}"
           class="element-filename
           {{$element->isAudio() ? 'audio-element' : ''}}
           {{$element->isImage() ? 'fancybox' : ''}}
           {{$element->isConfig() ? 'config-element' : ''}}" data-elementid="{{$element->id}}">
            {{$element->getName()}}
        </a>
        @if (Auth::check() && Auth::user()->id == $element->skin->user->id)
            <span style="float:right;">
                <a role="link" onclick="deleteRow(this,{{$element->id}})">Delete</a>
            </span>
        @endif
        @if ($element->isAudio())
            <audio id="{{$element->id}}-audio" src="/skins-content/{{$element->skin->id}}/{{$element->getFullname()}}"></audio>
        @endif
    </h4>
    @if ($element->isConfig())
    <pre style="display:none;" id="{{$element->id}}-config">

    </pre>
    @endif
    <p class="list-group-item-text">
        <b>Attributes:</b>
        @if (!isset($missing))
            @if($element->isImage())
                <span class="label label-success label-margin">Sprite</span>
            @elseif($element->isAudio())
                <span class="label label-evenmoresuccess label-margin">Sound</span>
            @elseif($element->isConfig())
                <span class="label label-evenlesssuccess label-margin">Configuration</span>
            @endif
            {{$element->issequence == 1 ? "<span class='label label-warning'>Animation</span>" : ""}}
            {{$element->ishd == 1 ? "<span class='label label-info'>HD</span>" : ""}}
            @if (Auth::check() && Auth::user()->id == $element->skin->user->id)
                @if ($element->useroverriden == 0 && $element->ishd == 0)
                    <span class='label label-primary'>Auto Generated</span>
                @elseif ($element->useroverriden == 1)
                    <span class='label label-danger'>User Overriden</span>
                @endif
            @endif
            @if ($element->group_id == -1 || $element->group_id == -2)
                {{--<span class='label label-default'>Undefined</span>--}}
            @else
                {{--<span class='label label-default'>{{$element->group->name}}</span>--}}
            @endif
        @else
            <span class='label label-default'>MISSING</span>
        @endif
        <span style="float:right;" class="element-size" data-elementsize="{{$element->size}}">
            <b>Size:</b> {{Helpers::formatSizeUnits($element->size)}}
        </span>
    </p>
</div>
@endforeach