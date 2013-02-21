<?php 
$simplehtml = isset($_GET['simplehtml']) && "true" === $_GET['simplehtml']? "true":"";
$content_header = $simplehtml ? "":"content_header";

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
    $ret .= "    <div class='xmca_search_form_element'><input type='submit' name='submit_go' value='GO' class='xmca_search_text_input' /></div>";
    $ret .= "    <div class='xmca_search_form_element_zero_padding'><input type='submit' name='submit_timeline' value='GO Timeline' class='xmca_search_text_input' /></div>";
    $ret .= "    <div style='float:right'><div class='xmca_search_form_element'><a href='/xmca'>Recent Threads</a></div></div>";
    $ret .= "    <div style='clear:both'/>";
    $ret .= "    </form>";
    $ret .= "</div>";
    return $ret;
}


function prettyPagination($words, $total, $matches, $index_start, $mode, $simplehtml, $resultPromt){
    $aBegin = "<a href='/xmca?words=" . implode(array_keys($words), '%20') . "&simplehtml=$simplehtml&mode=$mode&index_start=";

    $prev10000 = ($index_start > 10000 ? "$aBegin" . ($index_start - 10000) . "'>&lt;- prev 10000</a> |":"");
    $next10000 = ($index_start + 10000 < $total ? "| $aBegin" . ($index_start + 10000) . "'>next 10000 -&gt;</a>":"");
    $prev1000 = ($index_start > 1000 ? "$aBegin" . ($index_start - 1000) . "'>&lt;- prev 1000</a> |":"");
    $next1000 = ($index_start + 1000 < $total ? "| $aBegin" . ($index_start + 1000) . "'>next 1000 -&gt;</a>":"");
    $prev100 = ($index_start > 100 ? "$aBegin" . ($index_start - 100) . "'>&lt;- prev 100</a> |":"");
    $next100 = ($index_start + 100 < $total ? "| $aBegin" . ($index_start + 100) . "'>next 100 -&gt;</a>":"");
    $prev20 = ($index_start > 20 ? "$aBegin" . ($index_start - 20) . "'>&lt;- prev 20</a>":"");
    $next20 = ($index_start + 20 < $total ? "$aBegin" . ($index_start + 20) . "'>next 20 -&gt;</a>":"");
    
    $index_end = $index_start + $matches;
    $index_start += 1;    
    return "<div id='pagination'>$prev10000 $prev1000 $prev100 $prev20 <b>($resultPromt $index_start - $index_end)</b> $next20 $next100 $next1000 $next10000</div>";

}

function getMessageDiv($msg, $words = null, $mode = null){

    $body = str_replace("\n", '<br/>', htmlspecialchars($msg->body));
    
    if("" != $words){
        if("phrase" === $mode){
            $original = $words;
            $words = preg_replace("/\s\s*/", " *", $words);
            $body = preg_replace("/$words/i", "<span style='background:#ffff66'>$original</span>", $body);
        }
        else{
            $words = explode(" ", $words);
            foreach($words as $word){
                $body = preg_replace("/$word/i", "<span style='background:#ffff66'>$word</span>", $body);                
            }
        }
    }

    $ret =  "<div id='xmca_message'>";
    $ret .= "    <div id='xmca_yarn_title'>In thread &quot;" . $msg->name . "&quot; (" . $msg->items . "), created " . $msg->m_created_at . ", by " . $msg->first . " " . $msg->last . "</div>";
    $ret .= "    <div id='xmca_message_body'>$body</div>";
    $ret .= "</div>";
    return $ret;
}

?>
<h1 class='<?=$content_header;?>'>XMCA (eXtended Mind, Culture, and Activity) Forum</h1>

    <div class="inside_center">

