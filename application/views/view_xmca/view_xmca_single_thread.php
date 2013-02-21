<table width='100%'>

<?php
    echo "<tr><td>" . searchWidget($words, $mode, $simplehtml, $date_start, $date_end) . "</td></tr>";

    if(isset($threadId)){
        $messageIds = $getThreadMessages($threadId);
        echo "<tr><td><div id='xmca-thread-messages'>";
        foreach($messageIds as $id){
            echo getMessageDiv($getMessage($id->id), $words, $mode);
        }
        echo "</div></td></tr>";
    }
    else{
        echo "<tr><td><div id='xmca_search_no_results'>";
        echo "</div></td></tr>";
    }
?>
</table>
