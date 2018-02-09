<script type="text/javascript">
    //to be called to assure the user that yes,
    //there game is uploading
    function sayUploading(){
        var parent = document.getElementById('uploading_message');
        var child = document.createTextNode('Your game is uploading; this may take a minute...');
        parent.appendChild(child);
    }
</script>
<form action="?p=game_uploads_set" method="post" enctype="multipart/form-data"
        onsubmit="sayUploading()">
    <div class="form_section">
        <strong>Title</strong><br/>
        <input type="text" name="title"/><br/>
    </div>
    <div class="form_section">
        <strong>Upload</strong><br/>
        Please upload the <b><i>zipped</b></i> WebGL compiled game:<br>
        <input type="file" name="gameFile" id="gameFile"/><br/>
    </div>
    <!--TODO: consider putting this last option under higher protection:-->
    <!--<input type="checkbox" name="replace"/>
    This game a subsequent version (please replace the old one) <br/>-->
    <div class="form_section">
        <strong>Discription</strong><br/>
        <textarea rows="4" cols="50" name="about">Tell us about your game. Remember to include controls.</textarea>
    </div>
    <input type="submit" value="Upload Game"/>
    <i id="uploading_message"></i>
</form>