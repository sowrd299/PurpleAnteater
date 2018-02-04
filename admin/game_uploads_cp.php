<form action="?p=game_uploads_set" method="post" enctype="multipart/form-data">
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
</form>