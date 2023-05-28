<?php

// Inclusion des classes DAO nécessaires.
$cur_dir = dirname(dirname(dirname(__FILE__)));
include($cur_dir . '/data/type_flux.php');

// Récupération de l'ID
$code = $_GET['code'];

// Connexion à la base de données
$db_conn = CL_Dao::connect();
if (is_a($db_conn, "CL_DbErr"))       // Si erreur connexion, on renvoi le CL_DbErr
  $response = $db_conn;
else $response = Type_flux::delete($code, $db_conn);

// On renvoie le résultat vers la sortie standard au format JSON 
header('Content-type: application/json');
if (is_a($response, "CL_DbErr")) {
  echo  '{"query":"' . $response->getQuery() . '",' .
        '"errno":' . $response->getErrno() . ',' .
        '"error":"' . $response->getError() . '"}';
}

?>