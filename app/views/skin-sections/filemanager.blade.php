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
        <select id='groupsAvailable' name="group_id" class="form-control">
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
<!--<input id="missingElementsCheck" type="checkbox">
<label for="missingElementsCheck">Check for missing elements</label>-->
<div class="btn-group btn-group-lg btn-group-justified">
    <button type="button" class="btn btn-default">
        <b class="glyphicon glyphicon-picture filter-files" data-type="picture"></b>
    </button>
    <button type="button" class="btn btn-default">
        <b class="glyphicon glyphicon-volume-up filter-files" data-type="sound"></b>
    </button>
    <button type="button" class="btn btn-default">
        <b class="glyphicon glyphicon-file filter-files" data-type="text"></b>
    </button>
</div>



<div class="list-group" id="fileslist">
    @include('/skin-sections/table-row', array('elements' => $elements))
</div>