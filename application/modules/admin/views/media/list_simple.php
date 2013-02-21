
<?php

$media_uuid = "/assets/media/" . $upload_data['file_name'];

echo "<html>
          <body onload='if(null != window.parent.popup_callback) window.parent.popup_callback(\"$media_uuid\");'>";

$url = "/assets/media/" . $upload_data['file_name'];

$html = "url: <a href='$url'>$url</a><br>" . 
        "size: " . $upload_data['file_size'] . " KB<br>" . 
        "<div style='float:left'>id:&nbsp;</div><div style='float:left;' id='media_id'>" . $item->id . "</div><div style='clear:both;' /></h3>";
        
$html .="<div style='width:0px;height:0px;' id='media_uuid'>$media_uuid</div>";

$params = array('url' => $url, 
                'mime' => $upload_data['file_type'], 
                'width' => 100, 
                'height' => 100);


echo "<table>";
echo "<tr><td>" . displayMedia($params) . "</td><td>$html</td></tr>";
echo "</table>";
echo "</body></html>";