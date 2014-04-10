<div class="form-group">
    <form role="form" name="overview" method="post" action="/skins/settings/{{$skin->id}}">
        <h2>Settings</h2>
        <label for="overviewedit">
            Creator's words:

        </label>
        <textarea name="description" id="overviewedit" class="form-control"
                  rows="20">{{$skin->description}}</textarea>
        <div class="checkbox">
            <label for="hdsupport">
                HD Support
            </label>
            <input type="checkbox" name="hdsupport" id="hdsupport" value="1" {{$skin->hdsupport == 1 ? "checked" : ""}}/>
            <small><br/>Automatically rescales uploaded elements.<br/>
            E.g. Uploading 128x128 element, will add one more with 64x64 resolution.<br/>
            Uploaded element will be treated as @2x file.</small>
        </div>
        <div class="checkbox">
            <label for="warnnsfw">
                Mark as NSFW content
            </label>
            <input type="checkbox" id="warnnsfw" name="warnnsfw" value="1" {{$skin->nsfw == 1 ? "checked" : ""}}/>
            <small><br/>Check this, if your skin is not 13+ save.</small>
        </div>
        @if ($skin->template != 1)
            <a href="/skins/settings/{{$skin->id}}/markasdefault" class="btn btn-danger">Mark skin as template</a>
        @endif
        <button class="btn btn-danger" type="submit">Save Changes</button>
    </form>
</div>