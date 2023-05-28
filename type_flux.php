<?php

// Contient la définition de la superclasse
$cur_dir = dirname(dirname(__FILE__));
include($cur_dir . '/data/dao.php');

/**
 * Gestion des enregistrements de la table "utilisateur"
 */
final class Type_flux extends CL_Dao {

  // Propriétés (champs de la table) et constantes
  const TABLE_NAME = "type_flux";
  private $code;
  private $lib;


  // Ascesseurs et mutateurs
  public function getcode()         { return $this->code; }
  public function setcode($val)     { $this->code= $val; }
  public function getlib()        { return $this->lib; }
  public function setlib($val)    { $this->lib = $val; }
  

  // Constructeur de la classe
  function __construct() {
    $this->code = null;
    $this->lib = null;
    
    
  }

  /**
   * Fonction récupérant et renvoyant la liste des éléments de la table en fonction des paramètres
   * @param  object $params Objet contenant les paramètres (filtres, par ex)
   * @return array          Une liste d'enregistrements au format objet (si connexion réussie)
   *         CL_DbErr       Objet contenant le code et le message d'erreur (si échec connexion)
   */
  public static function getList($params, $db_conn) {
    $sql = "SELECT code, lib FROM " . Type_flux::TABLE_NAME;
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
   * @param  int       $code Clé de l'enregistrement
   * @return Type_flux     Objet initialisé avec les valeurs du tuple (si connexion réussie)
   *         CL_DbErr      Objet contenant le code et le message d'erreur (si échec connexion)
   */
  public static function get($code, $db_conn) {
    $sql = "SELECT code, lib    FROM " . Type_flux::TABLE_NAME . " WHERE codeuser = $code";
    $result = CL_Dao::query($sql, $db_conn);
    if (is_a($result, "CL_DbErr"))            // Si c'est un CL_DbErr, on le retourne
      return $result;
    else if ($result->num_rows === 0)         // Si aucun résultat, on retourne une erreur
      return new CL_DbErr($sql, 0, "Utilisateurs inconnu $code");
    else {                                    // Sinon, on retourne l'objet correspondant au résultat
      $ligne = $result->fetch_assoc();
      $retour = new Type_flux();
      $retour->setcode($ligne['code']);
      $retour->setlib($ligne['lib']);
      return $retour;
    }
  }

  /**
   * Fonction supprimant un enregistrement de la table
   * @param  int $code  Clé de l'enregistrement à supprimer
   * @return int      Un code permettant de savoir si l'opération s'est bien passée (si connexion réussie)
   *         CL_DbErr Objet contenant le code et le message d'erreur (si échec connexion)
   */
  public static function delete($code, $db_conn) {
    $sql = "DELETE FROM " . Type_flux::TABLE_NAME . " WHERE code = $code";
    $result = CL_Dao::query($sql, $db_conn);
    return $result;   // Qu'il s'agisse d'un CL_DbErr ou du nombre de lignes supprimées, on le retourne
  }

  public function exists($db_conn){
    $sql = "SELECT *    FROM " . Type_flux::TABLE_NAME . " WHERE code = '" . $this->code . "'";
    $result = CL_Dao::query($sql, $db_conn);
    if (is_a($result, "CL_DbErr"))            // Si c'est un CL_DbErr, on le retourne
      return $result;
    else return $result->num_rows > 0;
  }

  /**
   * Fonction d'aiguillage vers insert() / update()
   * @return int      Un code permettant de savoir si l'opération s'est bien passée (si connexion réussie)
   *         CL_DbErr Objet contenant le code et le message d'erreur (si échec connexion)
   */
  public function write($db_conn) {
    if ($this->exists($db_conn))
      return $this->update($db_conn);
    else return $this->insert($db_conn);
  }

  /**
   * Fonction d'insertion d'un enregistrement en base de données
   * @return int      Un code permettant de savoir si l'opération s'est bien passée (si connexion réussie)
   *         CL_DbErr Objet contenant le code et le message d'erreur (si échec connexion)
   */
  protected function insert($db_conn) {
    $sql = "INSERT INTO " . Type_flux::TABLE_NAME . " (code, lib) " .
           "VALUES (" . CL_Dao::getSqlString($this->code) . ", " . CL_Dao::getSqlString($this->lib) . ")";
    $result = CL_Dao::query($sql, $db_conn);
    return $result;   // Qu'il s'agisse d'un CL_DbErr ou du nombre de lignes insérées, on le retourne
  }

  /**
   * Fonction de mise à jour d'un enregistrement en base de données
   * @return int      Un code permettant de savoir si l'opération s'est bien passée (si connexion réussie)
   *         CL_DbErr Objet contenant le code et le message d'erreur (si échec connexion)
   */
  protected function update($db_conn) {
    $sql = "UPDATE " . Type_flux::TABLE_NAME . " " .
           "SET lib = " . CL_Dao::getSqlString($this->lib) . " " .
           "WHERE code = " . CL_Dao::getSqlString($this->code);
    $result = CL_Dao::query($sql, $db_conn);
    return $result;   // Qu'il s'agisse d'un CL_DbErr ou du nombre de lignes mises à jour, on le retourne
  }
}

?>