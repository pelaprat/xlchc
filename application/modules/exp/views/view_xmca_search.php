<table width='100%'>

<?php
    echo "<tr><td>" . searchWidget($words, $mode, $simplehtml, $date_start, $date_end) . "</td></tr>";
    if(isset($xmca_search) && 0 < $xmca_search['total']){
        echo "<tr><td align='center'>" . prettyPagination($xmca_search['words'], $xmca_search['total'], count($xmca_search['matches']), $index_start, $mode, $simplehtml, "XMCA Search Results") . "</td></tr>";
        echo "<tr><td><div id='xmca-thread-messages'>";
        foreach($xmca_search['matches'] as $k => $v){
            echo getMessageDiv($getMessage($k), $words, $mode);
        }
        echo "</div></td></tr>";
    }
    else{
        echo "<tr><td align='center'><br><br><div id='xmca_search_no_results'>Your query yielded no results.</div></td></tr>";
    }
?>
</table>