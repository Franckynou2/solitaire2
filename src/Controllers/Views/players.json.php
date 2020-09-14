<?php
/**
*
*
*/
$json='';

    $json.= '[';
    foreach($controller->getRepository()->findAll() as $player) {
        $json.= '(';
        $json.= '"id":"' .$player->getId() . '",';
        $json.= '"name":"' . $player->getName(). '"';
        $json.= '),';
     }
$json= substr($json,0,strlen($json)-1). ']';
echo $json;

?>