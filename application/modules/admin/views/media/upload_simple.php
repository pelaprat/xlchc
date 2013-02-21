<?php
echo "<html><body>";
if(isset($_GET['message']))
{
    echo "<font color='#8080ff'>" . $_GET['message'] . "</font><br><br>";
}
if(isset($error))
{
    echo "<font color='red'>$error</font><br><br>";
}
echo form_open_multipart('admin/media/upload?mode=browser');
echo form_upload("userfile");
echo form_submit("upload", "Upload");
echo form_close();
echo "</body></html>";