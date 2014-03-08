@extends('master')

@section('content')
<script src="/js/preview-kinetic.js"></script>
<div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">
                <p><b>Previews available:</b></p>
            </div>
            <div class="panel-body">
                <ul>
                    @foreach ($previews as $preview)
                    <li>{{$preview->name}}</li>
                    <ul>
                        @if ($preview->previewscreenshotelements->count() != 0)
                            @foreach($preview->previewscreenshotelements as $element)
                                <li><b>{{$element->filename}}</b> - Anchor:<b>{{$element->position}}</b>, xOffset:<b>{{$element->xoffset}}</b>, yOffset:<b>{{$element->yoffset}}</b></li>
                            @endforeach
                        @else
                            <li><b>This preview contains no elements!</b></li>
                        @endif
                    </ul>
                    @endforeach
                </ul>
            </div>
        </div>
        <form role="form" name="preview-add" method="post" action="{{URL::route('CreatePreview')}}">
            <h2>Create new preview</h2>

            <div class="form-group">
                <label for="screenshot-name">Name of dynamic screenshot:</label>
                <input class="form-control" id="screenshot-name" type="text" name="screenshot-name"/>
            </div>
                <button class="btn btn-danger" type="submit">Create</button>
        </form>
        @if ($previews->count() != 0)
        <form role="form" name="preview-edit" method="post" action="#">

            <h2>Edit existing preview</h2>
            <div id="canvas-container"></div>

            <label for="preview-select">Preview:</label>
            <select id="preview-select" name="preview-select" class="form-control">
                @foreach ($previews as $preview)
                <option>{{$preview->name}}</option>
                @endforeach
            </select>
            <div class="form-group">
                <label for="filename">Filename of element:</label>
                <input class="form-control" type="text" id="filename" name="filename"/>
                <small>If element doesn't exist, default skin will be used</small>
            </div>
            <div class="form-group">
                <label for="anchor-position">Anchor point:</label>
                <select class="form-control" id="anchor-position" name="anchor-position" >
                    <option>top</option>
                    <option>top-left</option>
                    <option>top-right</option>
                    <option>middle</option>
                    <option>middle-left</option>
                    <option>middle-right</option>
                    <option>bottom</option>
                    <option>bottom-left</option>
                    <option>bottom-right</option>
                </select>
                <small><br/>Image will be placed at this point, background is 1366x768 size <br/>
                You can offset this by using values below</small>
            </div>
            <div class="form-group">
                <label for="offsetx">Offset on X axis:</label>
                <input type="number" id="offsetx" name="offsetx" class="form-control"/>
            </div>
            <div class="form-group">
                <label for="offsety">Offset on Y axis:</label>
                <input type="number" id="offsety" name="offsety" class="form-control"/>
            </div>
            <button class="btn btn-danger" type="submit">Add Element</button>
        </form>
        @endif
</div>
@stop