@extends('master')

@section('content')
<div class="container">

        <form role="form" name="preview-add" method="post" action="{{URL::route('CreatePreview')}}">
            <h2>Create new preview</h2>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <p><b>Previews available:</b></p>
                </div>
                <div class="panel-body">
                    <ul>
                        @foreach ($previews as $preview)
                        <li>{{$preview->name}}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="form-group">
                <label for="screenshot-name">Name of dynamic screenshot:</label>
                <input class="form-control" id="screenshot-name" type="text" name="screenshot-name"/>
            </div>
                <button class="btn btn-danger" type="submit">Create</button>
        </form>
        @if ($previews->count() != 0)
        <form role="form" name="preview-edit" method="post" action="#">
            <h2>Edit existing preview</h2>
            <select name="preview-select" class="form-control">
                @foreach ($previews as $preview)
                <option>{{$preview->name}}</option>
                @endforeach
            </select>
        </form>
        @endif
</div>
@stop