<?php

// Contient la définition de la superclasse
$cur_dir = dirname(dirname(__FILE__));
include($cur_dir . '/data/dao.php');

/**
 * Gestion des enregistrements de la table "profil"
 */
final class Logs extends CL_Dao {

  // Propriétés (champs de la table) et constantes
  const TABLE_NAME = "logs";
  private $idlogs;
  private $test;
  private $tiknum;

  // Ascesseurs et mutateurs
  public function getidlogs()         { return $this->idlogs; }
  public function setidlogs($val)     { $this->idlogs = $val; }
  public function gettest()        { return $this->test; }
  public function settest($val)    { $this->test = $val; }
  public function gettiknum()        { return $this->tiknum; }
  public function settiknum($val)    { $this->tiknum = $val; }

  // Constructeur de la classe
  function __construct() {
    $this->idlogs = null;
    $this->test = null;
    $this->tiknum = null;
  }

  /**
   * Fonction récupérant et renvoyant la liste des éléments de la table en fonction des paramètres
   * @param  object $params Objet contenant les paramètres (filtres, par ex)
   * @return array          Une liste d'enregistrements au format objet (si connexion réussie)
   *         CL_DbErr       Objet contenant le code et le message d'erreur (si échec connexion)
   */
  public static function getList($params, $db_conn) {
    $sql = "SELECT idlogs, test, tiknum FROM " . Logs::TABLE_NAME;
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
   * @param  int       $idlogs Clé de l'enregistrement
   * @return Logs     Objet initialisé avec les valeurs du tuple (si connexion réussie)
   *         CL_DbErr      Objet contenant le code et le message d'erreur (si échec connexion)
   */
  public static function get($idlogs, $db_conn) {
    $sql = "SELECT idlogs, test, tiknum FROM " . Logs::TABLE_NAME . " WHERE idlogs = $idlogs";
    $result = CL_Dao::query($sql, $db_conn);
    if (is_a($result, "CL_DbErr"))            // Si c'est un CL_DbErr, on le retourne
      return $result;
    else if ($result->num_rows === 0)         // Si aucun résultat, on retourne une erreur
      return new CL_DbErr($sql, 0, "Logs inconnu $idlogs");
    else {                                    // Sinon, on retourne l'objet correspondant au résultat
      $ligne = $result->fetch_assoc();
      $retour = new Logs();
      $retour->setidlogs($ligne['idlogs']);
      $retour->settest($ligne['test']);
      $retour->settiknum($ligne['tiknum']);
      return $retour;
    }
  }

  /**
   * Fonction supprimant un enregistrement de la table
   * @param  int $idlogs  Clé de l'enregistrement à supprimer
   * @return int      Un code permettant de savoir si l'opération s'est bien passée (si connexion réussie)
   *         CL_DbErr Objet contenant le code et le message d'erreur (si échec connexion)
   */
  public static function delete($idlogs, $db_conn) {
    $sql = "DELETE FROM " . Logs::TABLE_NAME . " WHERE idlogs = $idlogs";
    $result = CL_Dao::query($sql, $db_conn);
    return $result;   // Qu'il s'agisse d'un CL_DbErr ou du testbre de lignes supprimées, on le retourne
  }
  /**
   * Fonction d'aiguillage vers insert() / update()
   * @return int      Un code permettant de savoir si l'opération s'est bien passée (si connexion réussie)
   *         CL_DbErr Objet contenant le code et le message d'erreur (si échec connexion)
   */
  public function write($db_conn) {
    if ($this->idlogs)
      return $this->update($db_conn);
    else return $this->insert($db_conn);
  }

  /**
   * Fonction d'insertion d'un enregistrement en base de données
   * @return int      Un code permettant de savoir si l'opération s'est bien passée (si connexion réussie)
   *         CL_DbErr Objet contenant le code et le message d'erreur (si échec connexion)
   */
  protected function insert($db_conn) {
    $sql = "INSERT INTO " . Logs::TABLE_NAME . " (test, tiknum)" .
           "VALUES ('" . ($this->test) . "','" . ($this->tiknum) . "' )";
    $result = CL_Dao::query($sql, $db_conn);
    $this->idlogs = $db_conn->insert_id;
    return $result;   // Qu'il s'agisse d'un CL_DbErr ou du testbre de lignes insérées, on le retourne
  }

  /**
   * Fonction de mise à jour d'un enregistrement en base de données
   * @return int      Un code permettant de savoir si l'opération s'est bien passée (si connexion réussie)
   *         CL_DbErr Objet contenant le code et le message d'erreur (si échec connexion)
   */
  protected function update($db_conn) {
    $sql = "UPDATE " . Logs::TABLE_NAME . " " .
           "SET test = " . CL_Dao::getSqlString($this->test) . " " .
           "SET tiknum =" . CL_Dao::getSqlString($this->tiknum) . " " .
           "WHERE idlogs = $this->idlogs";
    $result = CL_Dao::query($sql, $db_conn);
    return $result;   // Qu'il s'agisse d'un CL_DbErr ou du testbre de lignes mises à jour, on le retourne
  }
}
?>