@foreach ($elements as $element)
<div class="list-group-item">
    <h4 class="list-group-item-heading element-row">
        @if($element->isImage())
            <b class="glyphicon glyphicon-picture"></b>
        @elseif($element->isAudio())
            <b class="glyphicon glyphicon-volume-up"></b>
        @elseif($element->isConfig())
            <b class="glyphicon glyphicon-file"></b>
        @endif
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
    <p style="min-height:10px;" class="list-group-item-text">
        <!--<b>Attributes:</b>
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
            @endif-->
        <span style="float:right;" class="element-size" data-elementsize="{{$element->size}}">
            <b>Size:</b> {{Helpers::formatSizeUnits($element->size)}}
        </span>
    </p>
</div>
@endforeach