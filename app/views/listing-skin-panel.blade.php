<div class="row">
    @foreach ($skins as $skin)
    <div class="col-sm-5 col-md-3">
        <div class="thumbnail">
            <img src="/1389588-min.jpg" alt="...">
            <div class="caption">
                <h3>{{$skin->name}}</h3>
                @if (!$private)
                    <h4>by {{$skin->user->name}}</h4>
                @endif
                <!--
                <p class="text-center"><b class="taiko"></b><b class="osu"></b></p>
                <div class="progress progress-striped">
                    <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%;">
                        40%
                    </div>
                </div>
                -->
                <p>
                    <a href="/skins/view/{{$skin->id}}" class="btn btn-primary" style="width:100%;" role="button">
                        <b class="glyphicon glyphicon-search pull-left"></b>
                        View Skin</a>
                </p>
                @if (!$private)
                    <p>
                        <a href="/skins/download/{{$skin->id}}" class="btn btn-danger" style="width:100%;" role="button">
                            <b class="glyphicon glyphicon-save pull-left"></b>
                            Download</a>
                    </p>
                @endif
            </div>
        </div>
    </div>
    @endforeach
</div>