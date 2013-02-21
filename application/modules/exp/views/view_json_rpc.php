<?php 

header('Content-type: application/json; charset=UTF-8');
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');



if(isset($xmcatimeline)){
    $echoJSON();
    return;
}

if (isset($ret)){
    if(isset($doHTMLEntityDecode)){
        array_walk_recursive($ret, function(&$item, $key){
            $item = html_entity_decode($item);
        });
    }
    $ret = json_encode($ret);
}
else{
    $ret = json_encode(array("error" => "No ret object"));
}

if(isset($_GET['callback'])){
    echo $_GET['callback'] . "($ret)";
}
else{
    echo $ret;    
}