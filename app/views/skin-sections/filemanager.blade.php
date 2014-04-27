@if (Auth::check() && Auth::user()->id == $skin->user->id)
    <form action="/skins/upload-element/{{$skin->id}}" class="dropzone dz-clickable dropzone-custom" id="my-awesome-dropzone">
        <div class="dz-default dz-message"><span>Drop files here to upload</span></div>
    </form>
@endif
@if ($skin->template == 1)
<div>
    <form id="submit-form" class="form-inline" name="submitItemsToGroups" method="post" action="/skins/groups/addto">
        <label for="groupsAvailable">
            Groups:
        </label>
        <select id='groupsAvailable' class="form-control">
            @foreach($groups as $group)
            <option value="{{$group->id}}">{{$group->name}}</option>
            @endforeach
        </select>

        <button class="btn btn-danger" type="submit">Add To Group</button>
    </form>
    <form class="form-group" name="createGroup" method="post" action="/skins/groups/add">
        <label for="groupToAdd">New Group:</label>
        <input id="groupToAdd" type="text" name="groupName" />

        <button class="btn btn-danger" type="submit">Add New</button>
    </form>
</div>
@endif
<table class="table table-bordered table-smaller" id="fileslist">
    <tr>
        {{$skin->template == 1 ? "<th style='width:10px;'>Se</th>": ""}}
        <th>Element Name</th>
        <th>Attributes</th>
        <th style="width:10%;">Size</th>
        <th style="width:10%;">Options</th>
    </tr>
    @include('/skin-sections/table-row', array('elements' => $skin->SkinElement))
</table>