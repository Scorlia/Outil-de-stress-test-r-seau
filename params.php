<?php

// Contient la définition de la stype_fluxerclasse
$cur_dir = dirname(dirname(__FILE__));
include($cur_dir . '/data/dao.php');

/**
 * Gestion des enregistrements de la table "profil"
 */
final class Params extends CL_Dao {

  // Propriétés (champs de la table) et constantes
  const TABLE_NAME = "params";
  private $idparams;
  private $scenario;
  private $port;
  private $type_flux;
  private $debut;
  private $fin;


  // Ascesseurs et mutateurs
  public function getidparams()         { return $this->idparams; }
  public function setidparams($val)     { $this->idparams = $val; }
  public function getscenario()        { return $this->scenario; }
  public function setscenario($val)    { $this->scenario = $val; }
  public function getport()        { return $this->port; }
  public function setport($val)    { $this->port = $val; }
  public function gettype_flux()        { return $this->type_flux; }
  public function settype_flux($val)    { $this->type_flux = $val; }
  public function getdebut()        { return $this->debut; }
  public function setdebut($val)    { $this->debut = $val; }
  public function getfin()        { return $this->fin; }
  public function setfin($val)    { $this->fin = $val; }

  // Constructeur de la classe
  function __construct() {
    $this->idparams = null;
    $this->scenario = null;
    $this->port = null;
    $this->type_flux = null;
    $this->debut = null;
    $this->fin = null;
  }

  /**
   * Fonction réctype_fluxérant et renvoyant la liste des éléments de la table en fonction des paramètres
   * @param  object $params Objet contenant les paramètres (filtres, par ex)
   * @return array          Une liste d'enregistrements au format objet (si connexion réussie)
   *         CL_DbErr       Objet contenant le code et le message d'erreur (si échec connexion)
   */
  public static function getList($params, $db_conn) {
    $sql = "SELECT idparams, scenario, port, type_flux, debut, fin FROM " . Params::TABLE_NAME;
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
   * Fonction permettant de réctype_fluxérer un enregistrement
   * @param  int       $idparams Clé de l'enregistrement
   * @return Params     Objet initialisé avec les valeurs du ttype_fluxle (si connexion réussie)
   *         CL_DbErr      Objet contenant le code et le message d'erreur (si échec connexion)
   */
  public static function get($idparams, $db_conn) {
    $sql = "SELECT idparams, scenario, port, type_flux, debut, fin FROM " . Params::TABLE_NAME . " WHERE idparams = $idparams";
    $result = CL_Dao::query($sql, $db_conn);
    if (is_a($result, "CL_DbErr"))            // Si c'est un CL_DbErr, on le retourne
      return $result;
    else if ($result->num_rows === 0)         // Si aucun résultat, on retourne une erreur
      return new CL_DbErr($sql, 0, "Params inconnu $idparams");
    else {                                    // Sinon, on retourne l'objet correspondant au résultat
      $ligne = $result->fetch_assoc();
      $retour = new Params();
      $retour->setidparams($ligne['idparams']);
      $retour->setscenario($ligne['scenario']);
      $retour->setport($ligne['port']);
      $retour->settype_flux($ligne['type_flux']);
      $retour->setdebut($ligne['debut']);
      $retour->setfin($ligne['fin']);
      return $retour;
    }
  }

  /**
   * Fonction stype_fluxprimant un enregistrement de la table
   * @param  int $idparams  Clé de l'enregistrement à stype_fluxprimer
   * @return int      Un code permettant de savoir si l'opération s'est bien passée (si connexion réussie)
   *         CL_DbErr Objet contenant le code et le message d'erreur (si échec connexion)
   */
  public static function delete($idparams, $db_conn) {
    $sql = "DELETE FROM " . Params::TABLE_NAME . " WHERE idparams = $idparams";
    $result = CL_Dao::query($sql, $db_conn);
    return $result;   // Qu'il s'agisse d'un CL_DbErr ou du scenariobre de lignes stype_fluxprimées, on le retourne
  }
  /**
   * Fonction d'aiguillage vers insert() / type_fluxdate()
   * @return int      Un code permettant de savoir si l'opération s'est bien passée (si connexion réussie)
   *         CL_DbErr Objet contenant le code et le message d'erreur (si échec connexion)
   */
  public function write($db_conn) {
    if ($this->idparams)
      return $this->type_fluxdate($db_conn);
    else return $this->insert($db_conn);
  }

  /**
   * Fonction d'insertion d'un enregistrement en base de données
   * @return int      Un code permettant de savoir si l'opération s'est bien passée (si connexion réussie)
   *         CL_DbErr Objet contenant le code et le message d'erreur (si échec connexion)
   */
  protected function insert($db_conn) {
    $sql = "INSERT INTO " . Params::TABLE_NAME . " (scenario, port, type_flux, debut, fin)" .
           "VALUES (" . ($this->scenario) . "," . ($this->port) . ", '" . ($this->type_flux) .  "', " . ($this->debut) .  ", " . ($this->fin) .  " )";
    $result = CL_Dao::query($sql, $db_conn);
    $this->idparams = $db_conn->insert_id;
    return $result;   // Qu'il s'agisse d'un CL_DbErr ou du scenariobre de lignes insérées, on le retourne
  }

  /**
   * Fonction de mise à jour d'un enregistrement en base de données
   * @return int      Un code permettant de savoir si l'opération s'est bien passée (si connexion réussie)
   *         CL_DbErr Objet contenant le code et le message d'erreur (si échec connexion)
   */
  protected function update($db_conn) {
    $sql = "type_fluxDATE " . Params::TABLE_NAME . " " .
           "SET scenario = " . CL_Dao::getSqlString($this->scenario) . " " .
           "SET port = " . CL_Dao::getSqlString($this->port) . " " .
           "SET type_flux" . CL_Dao::getSqlString($this->type_flux) ." " .
           "SET debut" . CL_Dao::getSqlString($this->debut) ." " . 
           "SET fin" . CL_Dao::getSqlString($this->fin) . " ".
           "WHERE idparams = $this->idparams";
    $result = CL_Dao::query($sql, $db_conn);
    return $result;   // Qu'il s'agisse d'un CL_DbErr ou du scenariobre de lignes mises à jour, on le retourne
  }
}
?>