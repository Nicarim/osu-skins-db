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
            <div class="form-group">
                <label for="thumbnail">Thumbnail of your skin</label>
                <input class="form-control" type="file" id="thumbnail" name="thumbnail">
                <p class="help-block">Optimal resolution is 1024x768</p>
            </div>

            <button class="btn btn-danger" type="submit">Save Changes</button>
            @if (isset($skin))
                <button class="btn btn-danger" id="removeskin" data-skinid="{{$skin->id}}">Remove Skin</button>
            @endif
        </form>
    </div>
</div>