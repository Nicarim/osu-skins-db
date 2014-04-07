<nav class="navbar navbar-default navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
    <div class="navbar-header">
        <a class="navbar-brand" href="/">Skins Database</a>
    </div>
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Skins <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a class="blue-higlight" href="/skins/list"><b class="glyphicon glyphicon-certificate"></b> Newest</a></li>

                        <li><a class="red-highlight "href="#"><b class="glyphicon glyphicon-thumbs-up"></b> Top Rated</a></li>
                        <div class="divider"></div>
                        <li><a class="green-highlight" href="#"><b class="glyphicon glyphicon-heart"></b> Completed</a></li>
                        <li><a class="red-highlight" href="#"><b class="glyphicon glyphicon-edit"></b> Work in Progress</a></li>
                        <li><a class="blue-higlight" href="#"><b class="glyphicon glyphicon-picture"></b> All</a></li>
                    </ul>

                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Tools & Creation <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="/skins/create">Create Skin</a></li>
                        <!--<li><a href="#">Add Group</a></li>
                        <li><a href="#">Add Element</a></li>-->
                        <li><a href="{{URL::route('PreviewsManage')}}">Add&Manage Previews</a></li>
                    </ul>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                @if (Auth::check())
                <li><a>{{Auth::user()->email}} (google)</a></li>
                @else
                <a class="btn btn-default navbar-btn" role="button" href="/login">Sign in (Google)</a>
                @endif
            </ul>
        </div>

    </div>
</nav>
