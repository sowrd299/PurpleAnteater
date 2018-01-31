<form action="?p=game_uploads_set" method="post" enctype="multipart/form-data">
    Title of the game:
    <input type="text" name="title"/><br/>
    Please upload the <b><i>zipped</b></i> WebGL compiled game:
    <input type="file" name="gameFile" id="gameFile"/><br/>
    <!--TODO: consider putting this last option under higher protection:-->
    <input type="checkbox" name="replace"/>
    This game a subsequent version (please replace the old one) <br/>
    <input type="submit" value="Upload Game"/>
</form>