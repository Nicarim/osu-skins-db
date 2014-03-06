@extends('master')

@section('content')
<div class="container">
    <div class="form-group">
        <form role="form" name="overview" method="post" action="/skins/create">
            <h1>Create new skin</h1>
            <label for="title">
                Skin name:
            </label>
            <input class="form-control" type="text" id="title" name="title"/>
            <label for="overviewedit">
                Creator's words:

            </label>
            <textarea name="description" id="overviewedit" class="form-control"
                      rows="20"></textarea>
            <div class="checkbox">
                <label for="hdsupport">
                    HD Support
                </label>
                <input type="checkbox" name="hdsupport" id="hdsupport" value="1"/>
                <small><br/>Automatically rescales uploaded elements.<br/>
                    E.g. Uploading 128x128 element, will add one more with 64x64 resolution.<br/>
                    Uploaded element will be treated as @2x file.</small>
            </div>
            <div class="checkbox">
                <label for="warnnsfw">
                    Mark as NSFW content
                </label>
                <input type="checkbox" id="warnnsfw" name="warnnsfw" value="1"/>
                <small><br/>Check this, if your skin is not 13+ save.</small>
            </div>
            <button class="btn btn-danger" type="submit">Save Changes</button>
        </form>
    </div>
</div>
@stop