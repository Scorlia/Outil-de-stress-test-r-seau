<?php
    try
    {
        $bdd = new PDO('mysql:host=projet-slam.freeboxos.fr;dbname=projet;charset=utf8', 'laetitia', 'chat'); // On se connecte à MySQL
    }
 
    catch(Exception $e)
    {
        die('Erreur : '.$e->getMessage()); // En cas d'erreur, on affiche un message et on arrête tout
    }
 
    // Si tout va bien, on peut continuer
    // On récupère tout le contenu de la table scenerio
    $reponse = $bdd->query('SELECT * FROM scenerio ORDER BY idscenario');

    // S'il y des données de postées
    if ($_SERVER['REQUEST_METHOD']=='POST') {

      // Récupération des variables et sécurisation des données
      $nom = htmlentities($_POST['nom']); // htmlentities() convertit des caractères "spéciaux" en équivalent HTML
      $intervalle = htmlentities($_POST['intervalle']);
      $p1 = htmlentities($_POST['p1']);
      $p2 = htmlentities($_POST['p2']);
      $p3 = htmlentities($_POST['p3']);

    }
    
    $requete1 = "insert into scenario (nom, intervalle) VALUES ( '$nom','$intervalle')"; 
    if($bdd->query("$requete1")) {
        $idscenario = $bdd->lastInsertId();
        $bdd->query("insert into port_scenario (port, scenario, numport) VALUES ( 1,'$idscenario','$p1')");
        $bdd->query("insert into port_scenario (port, scenario, numport) VALUES ( 2,'$idscenario','$p2')");
        $bdd->query("insert into port_scenario (port, scenario, numport) VALUES ( 3,'$idscenario','$p3')");
        echo 'done';
    } else {
        echo 'bad';
    }
    ?>