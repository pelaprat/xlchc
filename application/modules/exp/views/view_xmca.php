<?php 
$simplehtml = isset($_GET['simplehtml']) && "true" === $_GET['simplehtml']? "true":"";
$content_header = $simplehtml ? "":"content_header";
?>
<h1 class='<?=$content_header;?>'>XMCA (eXtended Mind, Culture, and Activity) Forum</h1>
    <div class="inside_center">

        <table>
        
        <?php
                    
            if(isset($sphinxResults)){}        
            if(isset($showYarn)){}
            if(isset($showMessage)){}

            echo "<tr><td>" . searchWidget($words, $mode, $simplehtml, $date_start, $date_end) . "</td></tr>";

            if(isset($recent_threads)){
                echo "<tr><td>";

                echo "<div class='list_table'>
                        <div class='title-row'>
                            <div class='cell' style='width: 16px'></div>
                            <div class='cell' style='width: 225px'><a href='/xmca?order_threads_by=id'>Last Post</a></div>
                            <div class='cell' style='width: 150px'><a href='/xmca?order_threads_by=person_id'>Last Author</a></div>
                            <div class='cell' style='width: 515px'><a href='/xmca?order_threads_by=name'>Thread</a></div>
                        </div>";
                foreach($recent_threads as $thread){
                    echo "<div class='row'>
                            <div class='cell'></div>
                            <div class='cell-date'>" . $thread->created_at . "</div>
                            <div class='cell-name'><a href='/people/" . $thread->auth_name . "'>" . $thread->auth_name . "</a></div>
                            <div class='cell-link'><a href=''>" . $thread->name . " (" . $thread->items . ")</a></div>
                          </div>";
                }
                
                echo "</div>";
                echo  "</td></tr>";
                
            }
            else if(isset($xmca_search) && 0 == $xmca_search['total']){
                echo "<tr><td>";
                echo "<div id='fill_out_small_content'>";
                echo "No results for query:<br>";
                echo explainNonResults();
                echo "</div>";
                echo  "</td></tr>";
            }
            else{
                echo "<tr><td align='center'>" . prettyPagination($xmca_search, $index_start, $mode, $simplehtml) . "</td></tr>";
                echo "<tr><td>";
                foreach($xmca_search['matches'] as $k => $v){
                    $msg = $getMessage($k);
                    echo "<div id='xmca_message'>";
                    echo "    <div id='xmca_yarn_title'>In thread &quot;" . $msg->name . "&quot; (" . $msg->items . ")</div>";
                    echo "    <div id='xmca_message_body'>" . str_replace("\n", '<br/>', htmlspecialchars($msg->body)) . "</div>";
                    echo "</div>";
                }
                echo "</td></tr>";
            }
        ?>
        </table>
    </div>



<?php

function prettyPagination($sr, $index_start, $mode, $simplehtml){

    $aBegin = "<a href='/xmca?words=" . implode(array_keys($sr['words']), '%20') . "&simplehtml=$simplehtml&mode=$mode&index_start=";

    $prev1000 = ($index_start > 1000 ? "$aBegin" . ($index_start - 1000) . "'>&lt;- prev 1000</a> |":"");
    $next1000 = ($index_start + 1000 < $sr['total'] ? "| $aBegin" . ($index_start + 1000) . "'>next 1000 -&gt;</a>":"");
    $prev100 = ($index_start > 100 ? "$aBegin" . ($index_start - 100) . "'>&lt;- prev 100</a> |":"");
    $next100 = ($index_start + 100 < $sr['total'] ? "| $aBegin" . ($index_start + 100) . "'>next 100 -&gt;</a>":"");
    $prev20 = ($index_start > 20 ? "$aBegin" . ($index_start - 20) . "'>&lt;- prev 20</a>":"");
    $next20 = ($index_start + 20 < $sr['total'] ? "$aBegin" . ($index_start + 20) . "'>next 20 -&gt;</a>":"");
    
    $index_start += 1;    
    return "<div id='pagination'>$prev1000 $prev100 $prev20 <b>(results $index_start - " . count($sr['matches']) . ")</b> $next20 $next100 $next1000</div>";

}

function searchWidget($words, $mode, $simplehtml, $date_start, $date_end){

    $checked_any = $mode === "any";
    $checked_all = $mode === "all";
    $checked_phrase = $mode === "phrase";
    
    if(!($checked_any && $checked_all && $checked_phrase)) $checked_any = true;
    
    $checked_any = $checked_any ? "checked='checked'":"";
    $checked_all = $checked_all ? "checked='checked'":"";
    $checked_phrase = $checked_phrase ? "checked='checked'":"";

    $ret = "<div id='xmca_search_widget'>";
    $ret .= "    <form id='xmca_search_form' action='xmca' method='get'>";
    $ret .= "    <input type='hidden' name='simplehtml' value='$simplehtml' />";
    $ret .= "    <div class='xmca_search_form_element'>Search: <input type='text' class='xmca_search_text_input' name='words' id='xmca_search_q' value='$words'/></div>";
    $ret .= "    <div class='xmca_search_form_element'><input type='radio' name='mode' value='any' id='xmca_search_mode_any' $checked_any /> Any</div>";
    $ret .= "    <div class='xmca_search_form_element'><input type='radio' name='mode' value='all' id='xmca_search_mode_all' $checked_all /> All</div>";
    $ret .= "    <div class='xmca_search_form_element'><input type='radio' name='mode' value='phrase' id='xmca_search_mode_exact' $checked_phrase /> Exact</div>";
    $ret .= "    <div class='xmca_search_form_element_zero_padding'>Begin: <input type='text' class='xmca_search_date' name='date_start' id='xmca_search_start_date' value='$date_start'/></div><div class='xmca_search_form_element'><img src='/assets/images/clear_icon.png' width='21' height='18' onclick='document.getElementById(\"xmca_search_start_date\").value=\"\";' /></div>"; /**/
    $ret .= "    <div class='xmca_search_form_element_zero_padding'>End:  <input type='text' class='xmca_search_date' name='date_end' id='xmca_search_end_date' value='$date_end'/></div><div class='xmca_search_form_element'><img src='/assets/images/clear_icon.png' width='21' height='18' onclick='document.getElementById(\"xmca_search_end_date\").value=\"\";'  /></div>";
    $ret .= "    <div class='xmca_search_form_element_zero_padding'><input type='submit' name='submit' value='GO' class='xmca_search_text_input' /></div>";
    $ret .= "    <div style='clear:both'/>";
    $ret .= "    </form>";
    $ret .= "</div>";
    return $ret;
}

function explainNonResults(){
    return "";
}


?>
<script type="text/javascript" src='assets/scripts/jquery.filter_input.js'></script>
<script type="text/javascript"><!--

    $(document).ready(function(){
    
        $("#xmca_search_start_date").datepicker();
        $("#xmca_search_end_date").datepicker();
    
        $("#xmca_search_q").filter_input({regex:'[a-zA-Z 0-9]'})
        .keydown(function(event){
            if(13 == event.keyCode){
                $("#xmca_search_form").submit();
            }
        })
        .focus();
    });
    
--></script>