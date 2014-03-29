
<form action="/file-upload/{{$skin->id}}" class="dropzone dz-clickable dropzone-custom" id="my-awesome-dropzone">
    <div class="dz-default dz-message"><span>Drop files here to upload</span></div>
</form>
<table class="table table-bordered" id="fileslist">
    <tr>
        <th>Element Name</th>
        <th style="width:10%;">Type</th>
        <th style="width:10%;">Size</th>
        <th style="width:10%;">Options</th>
    </tr>
    @include('/skin-sections/table-row', array('elements' => $skin->SkinElement))
</table>