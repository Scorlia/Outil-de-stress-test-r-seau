<?php

// Inclusion des classes DAO nécessaires.
$cur_dir = dirname(dirname(dirname(__FILE__)));
include($cur_dir . '/data/type_flux.php');

// Connexion à la base de données
$db_conn = CL_Dao::connect();
if (is_a($db_conn, "CL_DbErr"))       // Si erreur connexion, on renvoi le CL_DbErr
  $response = $db_conn;
else $response = CL_Type_flux::getList(array(), $db_conn);

// On renvoie le résultat vers la sortie standard au format JSON 
header('Content-type: application/json');
if (is_a($response, "CL_DbErr")) {
  $json = '{"query":"' . $response->getQuery() . '",' .
          '"errno":' . $response->getErrno() . ',' .
          '"error":"' . $response->getError() . '"}';
} else {
  $json = '[';
  for ($i = 0; $i < count($response); $i++) {
    $line = $response[$i];
    if ($i != 0) $json .= ",";
    $json .= '{"code":' . $line["code"] . ',"lib":"' . $line["lib"] . '"}';
  }
  $json .= ']';
}
echo $json;

?>