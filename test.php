<?php

// Contient la définition de la superclasse
$cur_dir = dirname(dirname(__FILE__));
include($cur_dir . '/data/dao.php');

/**
 * Gestion des enregistrements de la table "profil"
 */
final class Tests extends CL_Dao {

  // Propriétés (champs de la table) et constantes
  const TABLE_NAME = "test";
  private $idtest;
  private $nom;
  private $scenario;
  private $ts_debut;

  // Ascesseurs et mutateurs
  public function getidtest()         { return $this->idtest; }
  public function setidtest($val)     { $this->idtest = $val; }
  public function getnom()        { return $this->nom; }
  public function setnom($val)    { $this->nom = $val; }
  public function getscenario()        { return $this->scenario; }
  public function setscenario($val)    { $this->scenario = $val; }
  public function getts_debut()        { return $this->ts_debut; }
  public function setts_debut($val)    { $this->ts_debut = $val; }

  // Constructeur de la classe
  function __construct() {
    $this->idtest = null;
    $this->nom = null;
    $this->scenario = null;
    $this->ts_debut = null;
  }

  /**
   * Fonction récupérant et renvoyant la liste des éléments de la table en fonction des paramètres
   * @param  object $params Objet contenant les paramètres (filtres, par ex)
   * @return array          Une liste d'enregistrements au format objet (si connexion réussie)
   *         CL_DbErr       Objet contenant le code et le message d'erreur (si échec connexion)
   */
  public static function getList($params, $db_conn) {
    $sql = "SELECT idtest, nom, scenario, ts_debut FROM " . Tests::TABLE_NAME;
    $result = CL_Dao::query($sql, $db_conn);
    if (is_a($result, "CL_DbErr"))
      return $result;
    else {
      $retour = [];
      while($row = $result->fetch_assoc())
        array_push($retour, $row);
      return $retour;
    }
  }

  /**
   * Fonction permettant de récupérer un enregistrement
   * @param  int       $idtest Clé de l'enregistrement
   * @return Tests     Objet initialisé avec les valeurs du tuple (si connexion réussie)
   *         CL_DbErr      Objet contenant le code et le message d'erreur (si échec connexion)
   */
  public static function get($idtest, $db_conn) {
    $sql = "SELECT idtest, nom, scenario, ts_debut FROM " . Tests::TABLE_NAME . " WHERE idtest = $idtest";
    $result = CL_Dao::query($sql, $db_conn);
    if (is_a($result, "CL_DbErr"))            // Si c'est un CL_DbErr, on le retourne
      return $result;
    else if ($result->num_rows === 0)         // Si aucun résultat, on retourne une erreur
      return new CL_DbErr($sql, 0, "Tests inconnu $idtest");
    else {                                    // Sinon, on retourne l'objet correspondant au résultat
      $ligne = $result->fetch_assoc();
      $retour = new Tests();
      $retour->setidtest($ligne['idtest']);
      $retour->setnom($ligne['nom']);
      $retour->setscenario($ligne['scenario']);
      $retour->setts_debut($ligne['ts_debut']);
      return $retour;
    }
  }

  /**
   * Fonction supprimant un enregistrement de la table
   * @param  int $idtest  Clé de l'enregistrement à supprimer
   * @return int      Un code permettant de savoir si l'opération s'est bien passée (si connexion réussie)
   *         CL_DbErr Objet contenant le code et le message d'erreur (si échec connexion)
   */
  public static function delete($idtest, $db_conn) {
    $sql = "DELETE FROM " . Tests::TABLE_NAME . " WHERE idtest = $idtest";
    $result = CL_Dao::query($sql, $db_conn);
    return $result;   // Qu'il s'agisse d'un CL_DbErr ou du nombre de lignes supprimées, on le retourne
  }
  /**
   * Fonction d'aiguillage vers insert() / update()
   * @return int      Un code permettant de savoir si l'opération s'est bien passée (si connexion réussie)
   *         CL_DbErr Objet contenant le code et le message d'erreur (si échec connexion)
   */
  public function write($db_conn) {
    if ($this->idtest)
      return $this->update($db_conn);
    else return $this->insert($db_conn);
  }

  /**
   * Fonction d'insertion d'un enregistrement en base de données
   * @return int      Un code permettant de savoir si l'opération s'est bien passée (si connexion réussie)
   *         CL_DbErr Objet contenant le code et le message d'erreur (si échec connexion)
   */
  protected function insert($db_conn) {
    $sql = "INSERT INTO " . Tests::TABLE_NAME . " (nom, scenario, ts_debut)" .
           "VALUES ('" . ($this->nom) . "','" . ($this->scenario) . "', STR_TO_DATE('" . ($this->ts_debut) . "','%Y%m%dT%T') )";
    $result = CL_Dao::query($sql, $db_conn);
    $this->idtest = $db_conn->insert_id;
    return $result;   // Qu'il s'agisse d'un CL_DbErr ou du nombre de lignes insérées, on le retourne
  }

  /**
   * Fonction de mise à jour d'un enregistrement en base de données
   * @return int      Un code permettant de savoir si l'opération s'est bien passée (si connexion réussie)
   *         CL_DbErr Objet contenant le code et le message d'erreur (si échec connexion)
   */
  protected function update($db_conn) {
    $sql = "UPDATE " . Tests::TABLE_NAME . " " .
           "SET nom = " . CL_Dao::getSqlString($this->nom) . " " . CL_Dao::getSqlString($this->scenario) . " " . CL_Dao::getSqlString($this->ts_debut) .
           "WHERE idtest = $this->idtest";
    $result = CL_Dao::query($sql, $db_conn);
    return $result;   // Qu'il s'agisse d'un CL_DbErr ou du nombre de lignes mises à jour, on le retourne
  }
}
?>