<tr>

    <td><a href="/skins-content/{{$element->skin->id}}/{{$element->filename}}" class="fancybox">{{$element->filename}}</a></td>
    <td>Sprite</td>
    <td>{{round((float)($element->size / 100000),2)}} MB</td>
    <td class="text-right"><a href="#" onclick="deleteRow(this,{{$element->id}})">Delete</a>|<a href="#">Rename</a></td>
</tr>