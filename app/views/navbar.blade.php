<nav class="navbar navbar-default navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-toggle">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="/">Skins Database</a>
    </div>
        <div class="collapse navbar-collapse" id="navbar-toggle">
            <ul class="nav navbar-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Skins <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a class="red-highlight" href="/skins/list/rating"><b class="glyphicon glyphicon-star"></b> Most Favorites</a></li>
                        <li><a class="green-highlight" href="/skins/list/downloads"><b class="glyphicon glyphicon-cloud"></b> Most Downloaded</a></li>
                        <div class="divider"></div>
                        <li><a class="blue-higlight" href="/skins/list"><b class="glyphicon glyphicon-certificate"></b> All</a></li>
                        <!--
                        <div class="divider"></div>
                        <li><a class="green-highlight" href="/skins/list/completed"><b class="glyphicon glyphicon-heart"></b> Completed</a></li>
                        <li><a class="red-highlight" href="/skins/list/wip"><b class="glyphicon glyphicon-edit"></b> Work in Progress</a></li>
                        <li><a class="blue-higlight" href="/skins/list/all"><b class="glyphicon glyphicon-picture"></b> All</a></li>-->
                    </ul>

                </li>
                @if (Auth::check())
                    <!--<li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Tools & Creation <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="/skins/create">Create Skin</a></li>
                            <li><a href="#">Add Group</a></li>
                            <li><a href="#">Add Element</a></li>
                            <li><a href="{{URL::route('PreviewsManage')}}">Add&Manage Previews</a></li>
                        </ul>
                    </li>-->
                @endif
            </ul>
            <ul class="nav navbar-nav navbar-right">
                @if (Auth::check())
                    <li class="dropdown">
                        <a class="dropdown-toggle" href="#" data-toggle="dropdown">{{Auth::user()->email}} (Google)<b class="caret"></b></a>
                        <ul class="dropdown-menu fullsize-dropdown">
                            <li><a href="{{URL::route('CreateSkin')}}">Create Skin</a></li>
                            <li><a href="{{URL::route('ownSkins')}}">My Skins</a></li>
                            <!--<li><a href="#">Users List</a></li>-->
                            <div class="divider"></div>
                            <li><a href="{{URL::route('logout')}}">Log Out</a></li>
                        </ul>
                    </li>
                @else
                    <a class="btn btn-default navbar-btn" role="button" href="{{URL::route('login')}}">Sign in (Google)</a>
                @endif
            </ul>
        </div>

    </div>
</nav>
