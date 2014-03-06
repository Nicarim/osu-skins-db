<script>
    Dropzone.options.myAwesomeDropzone = {
        success: function(file,response){
            $("#fileslist > tbody > tr:first").after($(response).hide().fadeIn(1500));
        }
    }
</script>
<form action="/file-upload/{{$skin->id}}" class="dropzone dz-clickable dropzone-custom" id="my-awesome-dropzone">
    <div class="dz-default dz-message"><span>Drop files here to upload</span></div>
</form>
<table class="table table-bordered" id="fileslist">
    <tr>
        <th>Element Name</th>
        <th>Type</th>
        <th>Size</th>
        <th>Options</th>
    </tr>
    @foreach($skin->SkinElement as $element)
        @include('/skin-sections/table-row', array('element' => $element))
    @endforeach
</table>