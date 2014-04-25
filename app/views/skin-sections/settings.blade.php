<div class="form-group">
    <form role="form" name="overview" method="post" action="/skins/settings/{{$skin->id}}">
        <h2>Settings</h2>
        <label for="overviewedit">
            Creator's words:

        </label>
        <textarea name="description" id="overviewedit" class="form-control"
                  rows="20">{{$skin->description}}</textarea>
        <a href="http://daringfireball.net/projects/markdown/basics">Description allows <b>markdown</b> usage! Check syntax here</a>
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