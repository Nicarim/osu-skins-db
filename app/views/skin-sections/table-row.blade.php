@foreach ($elements as $element)
    <tr>
        <td>
            {{$element->highdef == 1 ? "<span class='label label-info'>HD</span>" : ""}}
            <a href="/skins-content/{{$element->skin->id}}/{{$element->filename}}" class="fancybox element-filename">{{$element->filename}}</a>
        </td>
        <td>Sprite</td>
        <td>{{round((float)($element->size / 100000),2)}} MB</td>
        @if (Auth::check() && Auth::user()->id == $element->skin->user->id)
            <td><a href="#" onclick="deleteRow(this,{{$element->id}})">Delete</a></td>
        @endif
    </tr>
@endforeach