<?php

// Inclusion des classes DAO nécessaires.
$cur_dir = dirname(dirname(dirname(__FILE__)));
include($cur_dir . '/data/type_flux.php');


// Récupération d'un formulaire JSON
$json = file_get_contents('php://input');
$data = json_decode($json);

// Connexion à la base de données
$db_conn = CL_Dao::connect();
if (is_a($db_conn, "CL_DbErr"))       // Si erreur connexion, on renvoi le CL_DbErr
  $response = $db_conn;
else {                                // Sinon, on tente l'écriture en base
  $obj = new Type_flux();
  $obj->setcode($data->code);
  $obj->setlib($data->lib);
  $response = $obj->write($db_conn);
}

// On renvoie le résultat vers la sortie standard au format JSON 
header('Content-type: application/json');
if (is_a($response, "CL_DbErr")) {
  echo  '{"query":"' . $response->getQuery() . '",' .
        '"errno":' . $response->getErrno() . ',' .
        '"error":"' . $response->getError() . '"}';
} else echo '{"code": "' . $obj->getcode() . '","lib":"' . $obj->getlib() . '"}';

?>