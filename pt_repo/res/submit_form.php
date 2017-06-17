<?php include_once './pt_repo/res/lib.php'; ?>

<form action="./pt_repo.php?p=submit" method="post">
    <input name="id" type="hidden" value="<?php echo($_GET['id']); ?>">
    <input name="post_until" type="hidden" value="<?php echo(date('Y-m-d', strtotime('now + '.POST_WINDOW))); ?>">
    <table>
        <!--TODO: init all fields to their current values-->
        <tr>
            <td>Working Title of Your Game:</td>
            <td><input name="name" type="text"></td>
        </tr>
        <tr>
            <td>Download Link: <i>(Dropbox, GitHub, Google Drive, etc.)</i></td>
            <td><input name="download" type="text"></td>
        </tr>
        <tr>
            <td>Feedback Link: <i>(Google Forms, etc.)</i></td>
            <td><input name="feedback" type="text"></td>
        </tr>
        <tr>
            <td>About Your Game:</td>
            <td><input name="about" type="text"></td> <!--TODO: replace this with a larger text area.-->
        </tr>
    </table>
    <input type="submit" value="Submit">
</form>
