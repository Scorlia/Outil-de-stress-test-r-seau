<?php

// Contient la définition de la superclasse
$cur_dir = dirname(dirname(__FILE__));
include($cur_dir . '/data/dao.php');

/**
 * Gestion des enregistrements de la table "profil"
 */
final class Details_logs extends CL_Dao {

  // Propriétés (champs de la table) et constantes
  const TABLE_NAME = "detail_log";
  private $iddetail_log;
  private $logs;
  private $port;
  private $up;
  private $down;
  private $ping;


  // Ascesseurs et mutateurs
  public function getiddetail_log()         { return $this->iddetail_log; }
  public function setiddetail_log($val)     { $this->iddetail_log = $val; }
  public function getlogs()        { return $this->logs; }
  public function setlogs($val)    { $this->logs = $val; }
  public function getport()        { return $this->port; }
  public function setport($val)    { $this->port = $val; }
  public function getup()        { return $this->up; }
  public function setup($val)    { $this->up = $val; }
  public function getdown()        { return $this->down; }
  public function setdown($val)    { $this->down = $val; }
  public function getping()        { return $this->ping; }
  public function setping($val)    { $this->ping = $val; }

  // Constructeur de la classe
  function __construct() {
    $this->iddetail_log = null;
    $this->logs = null;
    $this->port = null;
    $this->up = null;
    $this->down = null;
    $this->ping = null;
  }

  /**
   * Fonction récupérant et renvoyant la liste des éléments de la table en fonction des paramètres
   * @param  object $params Objet contenant les paramètres (filtres, par ex)
   * @return array          Une liste d'enregistrements au format objet (si connexion réussie)
   *         CL_DbErr       Objet contenant le code et le message d'erreur (si échec connexion)
   */
  public static function getList($params, $db_conn) {
    $sql = "SELECT iddetail_log, logs, port, up, down, ping FROM " . Details_logs::TABLE_NAME;
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
   * @param  int       $iddetail_log Clé de l'enregistrement
   * @return Details_logs     Objet initialisé avec les valeurs du tuple (si connexion réussie)
   *         CL_DbErr      Objet contenant le code et le message d'erreur (si échec connexion)
   */
  public static function get($iddetail_log, $db_conn) {
    $sql = "SELECT iddetail_log, logs, port, up, down, ping FROM " . Details_logs::TABLE_NAME . " WHERE iddetail_log = $iddetail_log";
    $result = CL_Dao::query($sql, $db_conn);
    if (is_a($result, "CL_DbErr"))            // Si c'est un CL_DbErr, on le retourne
      return $result;
    else if ($result->num_rows === 0)         // Si aucun résultat, on retourne une erreur
      return new CL_DbErr($sql, 0, "Details_logs inconnu $iddetail_log");
    else {                                    // Sinon, on retourne l'objet correspondant au résultat
      $ligne = $result->fetch_assoc();
      $retour = new Details_logs();
      $retour->setiddetail_log($ligne['iddetail_log']);
      $retour->setlogs($ligne['logs']);
      $retour->setport($ligne['port']);
      $retour->setup($ligne['up']);
      $retour->setdown($ligne['down']);
      $retour->setping($ligne['ping']);
      return $retour;
    }
  }

  /**
   * Fonction supprimant un enregistrement de la table
   * @param  int $iddetail_log  Clé de l'enregistrement à supprimer
   * @return int      Un code permettant de savoir si l'opération s'est bien passée (si connexion réussie)
   *         CL_DbErr Objet contenant le code et le message d'erreur (si échec connexion)
   */
  public static function delete($iddetail_log, $db_conn) {
    $sql = "DELETE FROM " . Details_logs::TABLE_NAME . " WHERE iddetail_log = $iddetail_log";
    $result = CL_Dao::query($sql, $db_conn);
    return $result;   // Qu'il s'agisse d'un CL_DbErr ou du logsbre de lignes supprimées, on le retourne
  }
  /**
   * Fonction d'aiguillage vers insert() / update()
   * @return int      Un code permettant de savoir si l'opération s'est bien passée (si connexion réussie)
   *         CL_DbErr Objet contenant le code et le message d'erreur (si échec connexion)
   */
  public function write($db_conn) {
    if ($this->iddetail_log)
      return $this->update($db_conn);
    else return $this->insert($db_conn);
  }

  /**
   * Fonction d'insertion d'un enregistrement en base de données
   * @return int      Un code permettant de savoir si l'opération s'est bien passée (si connexion réussie)
   *         CL_DbErr Objet contenant le code et le message d'erreur (si échec connexion)
   */
  protected function insert($db_conn) {
    $sql = "INSERT INTO " . Details_logs::TABLE_NAME . " (logs, port, up, down, ping)" .
           "VALUES ('" . ($this->logs) . "','" . ($this->port) . "', '" . ($this->up) .  "', '" . ($this->down) .  "', '" . ($this->ping) .  "' )";
    $result = CL_Dao::query($sql, $db_conn);
    $this->iddetail_log = $db_conn->insert_id;
    return $result;   // Qu'il s'agisse d'un CL_DbErr ou du logsbre de lignes insérées, on le retourne
  }

  /**
   * Fonction de mise à jour d'un enregistrement en base de données
   * @return int      Un code permettant de savoir si l'opération s'est bien passée (si connexion réussie)
   *         CL_DbErr Objet contenant le code et le message d'erreur (si échec connexion)
   */
  protected function update($db_conn) {
    $sql = "UPDATE " . Details_logs::TABLE_NAME . " " .
           "SET logs = " . CL_Dao::getSqlString($this->logs) . " " . CL_Dao::getSqlString($this->port) . " " . CL_Dao::getSqlString($this->up) ." " . CL_Dao::getSqlString($this->down) ." " . CL_Dao::getSqlString($this->ping) .
           "WHERE iddetail_log = $this->iddetail_log";
    $result = CL_Dao::query($sql, $db_conn);
    return $result;   // Qu'il s'agisse d'un CL_DbErr ou du logsbre de lignes mises à jour, on le retourne
  }
}
?>