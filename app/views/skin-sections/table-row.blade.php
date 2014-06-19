@foreach ($elements as $element)
    <tr {{!isset($missing) ?: "data-typeOfRow='missing'"}}>
        @if($element->skin->template == 1 && !isset($missing))
        <td>
            <input class='markedItems' type='checkbox' name='selectedItems[]' value='{{$element->id}}' form='submit-form'/>
        </td>
        @endif
        <td class="element-row">
            <a href="/skins-content/{{$element->skin->id}}/{{$element->getFullname()}}" rel="skin-element{{$element->ishd == 1 ? '2x' : ''}}" class="fancybox element-filename">{{$element->getName()}}</a>
        </td>
        <td>
            <!-- attributions -->
            @if (!isset($missing))
                @if(in_array($element->extension, array("jpg","jpeg","png")))
                    <span class="label label-success label-margin">Sprite</span>
                @elseif(in_array($element->extension, array("mp3","ogg","wav")))
                    <span class="label label-evenmoresuccess label-margin">Sound</span>
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

        </td>
        <td class="element-size" data-elementsize="{{$element->size}}">{{Helpers::formatSizeUnits($element->size)}}</td>
        @if (Auth::check() && Auth::user()->id == $element->skin->user->id)
            <td><a role="link" onclick="deleteRow(this,{{$element->id}})">Delete</a></td>
        @endif
    </tr>
@endforeach