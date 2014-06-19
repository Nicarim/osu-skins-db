<div class="container">
    <div class="form-group">
        <form role="form" name="overview" method="post" action="{{$url}}" enctype="multipart/form-data">
            <h1>{{$header}}</h1>
            <label for="title">
                Skin name:
            </label>
            <input class="form-control" type="text" id="title" name="title" value="{{isset($skin) ? $skin->name : ''}}"/>
            <label for="overviewedit">
                Creator's words:
            </label>
            <textarea name="description" id="overviewedit" class="form-control"
                      rows="20">{{isset($skin) ? $skin->description : ''}}</textarea>
            <div class="checkbox">
                <label for="warnnsfw">
                    Mark as NSFW content
                </label>
                <input type="checkbox" id="warnnsfw" name="warnnsfw" value="1"/>
                <small><br/>Check this, if your skin is not 13+ save.</small>
            </div>
            <div class="form-group">
                <label for="thumbnail">Thumbnail of your skin</label>
                <input class="form-control" type="file" id="thumbnail" name="thumbnail">
                <p class="help-block">Optimal resolution is 1024x768</p>
            </div>

            <button class="btn btn-danger" type="submit">Save Changes</button>
        </form>
    </div>
</div>