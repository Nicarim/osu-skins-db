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
<div id="filters" class="btn-group btn-group-lg btn-group-justified" style="padding-top: 10px; padding-bottom: 10px;">
    <div class="btn-group">
        <button type="button" class="btn btn-danger filter-files" data-type="picture">
            <b class="glyphicon glyphicon-picture"></b> Sprites
        </button>
    </div>
    <div class="btn-group">
        <button type="button" class="btn btn-primary filter-files" data-type="sound">
            <b class="glyphicon glyphicon-volume-up"></b> Sounds
        </button>
    </div>
    <div class="btn-group">
        <button type="button" class="btn btn-success filter-files" data-type="text">
            <b class="glyphicon glyphicon-file"></b> Configs
        </button>
    </div>
</div>



<div class="list-group" id="fileslist">
    @include('/skin-sections/table-row', array('elements' => $elements))
</div>