@extends('master')
@section('content')
<script>

</script>
<title>{{$skin->name}}</title>
{{--@include('sidebar-skin')--}}
<div class="container">
    <ul class="nav nav-tabs nav-justified">
        <li class="active"><a href="#overview" data-toggle="tab">Overview</a></li>
        <li><a href="#filesmanager" id="filesmanager-link" data-toggle="tab" data-skinid="{{$skin->id}}">Files Manager</a></li>
        @if (Auth::check() && Auth::user()->id == $skin->user->id)
            <li><a href="#settings" data-toggle="tab">Settings</a></li>
        @endif
    </ul>
    <div class="tab-content">
        <div class="tab-pane fade in active" id="overview">
            @include('skin-sections/overview')
        </div>
        <div class="tab-pane fade" id="filesmanager">
            @include("skin-sections/filemanager")
        </div>
        @if (Auth::check() && Auth::user()->id == $skin->user->id)
            <div class="tab-pane fade" id="settings">
                @include('skin-sections/settings')
            </div>
        @endif
    </div>
</div>

@stop
