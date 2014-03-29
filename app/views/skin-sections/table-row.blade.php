@foreach ($elements as $element)
    <tr>
        <td>
            <!--<a class="fancybox label label-danger" href="/previews-content/{{$element->skin->id}}/countdown.jpg?cache={{time()}}">Preview-set</a>-->
            {{$element->highdef == 1 ? "<span class='label label-info'>HD</span>" : ""}}
            <a href="/skins-content/{{$element->skin->id}}/{{$element->filename}}" class="fancybox element-filename">{{$element->filename}}</a>
        </td>
        <td>Sprite</td>
        <td>{{round((float)($element->size / 1000000),2)}} MB</td>
        <td><a href="#" onclick="deleteRow(this,{{$element->id}})">Delete</a></td>
    </tr>
@endforeach