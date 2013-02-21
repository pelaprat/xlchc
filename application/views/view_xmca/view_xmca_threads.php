
<table>

<?php

    echo "<tr><td>" . searchWidget($words, $mode, $simplehtml, $date_start, $date_end) . "</td></tr>";

    if(isset($recent_threads)){
        echo "<tr><td align='center'>" . prettyPagination(array(), $getTotalThreads(), count($recent_threads), $index_start, $mode, $simplehtml, "XMCA Threads") . "</td></tr>";
        echo "<tr><td>";

        echo "<div class='list_table'>
                <div class='title-row'>
                    <div class='cell' style='width: 16px'></div>
                    <div class='cell' style='width: 225px'><a href='/exp_xmca?order_threads_by=id'>Last Post</a></div>
                    <div class='cell' style='width: 150px'><a href='/exp_xmca?order_threads_by=person_id'>Last Author</a></div>
                    <div class='cell' style='width: 515px'><a href='/exp_xmca?order_threads_by=name'>Thread</a></div>
                </div>";
        foreach($recent_threads as $thread){
            echo "<div class='row'>
                    <div class='cell'></div>
                    <div class='cell date'>" . $thread->created_at . "</div>
                    <div class='cell'><a href='/people/" .$thread->pID . "'>" . $thread->auth_name . "</a></div>
                    <div class='cell'><a href='/exp_xmca?threadId=" . $thread->yID . "'>" . $thread->name . " (" . $thread->items . ")</a></div>
                  </div>";
        }
        
        echo "</div>";
        echo  "</td></tr>";
        
    }
?>
</table>