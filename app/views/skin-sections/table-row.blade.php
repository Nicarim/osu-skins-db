@foreach ($elements as $element)
    <tr>
        <td class="element-row">
            {{$element->ishd == 1 ? "<span class='label label-info'>HD</span>" : ""}}
            <a href="/skins-content/{{$element->skin->id}}/{{$element->filename}}{{$element->ishd == 1 ? "@2x" : ""}}.{{$element->extension}}" class="fancybox element-filename">{{$element->filename}}</a>
        </td>
        <td>
            @if(in_array($element->extension, array("jpg","jpeg","png")))
                <span>Sprite</span>
            @elseif(in_array($element->extension, array("mp3","ogg","wav")))
                <span>Sound</span>
            @endif
        </td>
        <td>{{round((float)($element->size / 1000000),2)}} MB</td>
        @if (Auth::check() && Auth::user()->id == $element->skin->user->id)
            <td><a href="#" onclick="deleteRow(this,{{$element->id}})">Delete</a></td>
        @endif
    </tr>
@endforeach