<?php

// Contient la définition de la superclasse
$cur_dir = dirname(dirname(__FILE__));
include($cur_dir . '/data/dao.php');

/**
 * Gestion des enregistrements de la table "profil"
 */
final class Ports extends CL_Dao {

  // Propriétés (champs de la table) et constantes
  const TABLE_NAME = "port";
  private $idport;
  private $nom;

  // Ascesseurs et mutateurs
  public function getidport()         { return $this->idport; }
  public function setidport($val)     { $this->idport = $val; }
  public function getnom()        { return $this->nom; }
  public function setnom($val)    { $this->nom = $val; }

  // Constructeur de la classe
  function __construct() {
    $this->idport = null;
    $this->nom = null;
  }

  /**
   * Fonction récupérant et renvoyant la liste des éléments de la table en fonction des paramètres
   * @param  object $params Objet contenant les paramètres (filtres, par ex)
   * @return array          Une liste d'enregistrements au format objet (si connexion réussie)
   *         CL_DbErr       Objet contenant le code et le message d'erreur (si échec connexion)
   */
  public static function getList($params, $db_conn) {
    $sql = "SELECT idport, nom FROM " . Ports::TABLE_NAME;
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
   * @param  int       $idport Clé de l'enregistrement
   * @return Ports     Objet initialisé avec les valeurs du tuple (si connexion réussie)
   *         CL_DbErr      Objet contenant le code et le message d'erreur (si échec connexion)
   */
  public static function get($idport, $db_conn) {
    $sql = "SELECT idport, nom FROM " . Ports::TABLE_NAME . " WHERE idport = $idport";
    $result = CL_Dao::query($sql, $db_conn);
    if (is_a($result, "CL_DbErr"))            // Si c'est un CL_DbErr, on le retourne
      return $result;
    else if ($result->num_rows === 0)         // Si aucun résultat, on retourne une erreur
      return new CL_DbErr($sql, 0, "Ports inconnu $idport");
    else {                                    // Sinon, on retourne l'objet correspondant au résultat
      $ligne = $result->fetch_assoc();
      $retour = new Ports();
      $retour->setidportprofil($ligne['idport']);
      $retour->setnom($ligne['nom']);
      return $retour;
    }
  }

  /**
   * Fonction supprimant un enregistrement de la table
   * @param  int $idport  Clé de l'enregistrement à supprimer
   * @return int      Un code permettant de savoir si l'opération s'est bien passée (si connexion réussie)
   *         CL_DbErr Objet contenant le code et le message d'erreur (si échec connexion)
   */
  public static function delete($idport, $db_conn) {
    $sql = "DELETE FROM " . Ports::TABLE_NAME . " WHERE idport = $idport";
    $result = CL_Dao::query($sql, $db_conn);
    return $result;   // Qu'il s'agisse d'un CL_DbErr ou du nombre de lignes supprimées, on le retourne
  }
  /**
   * Fonction d'aiguillage vers insert() / update()
   * @return int      Un code permettant de savoir si l'opération s'est bien passée (si connexion réussie)
   *         CL_DbErr Objet contenant le code et le message d'erreur (si échec connexion)
   */
  public function write($db_conn) {
    if ($this->idport)
      return $this->update($db_conn);
    else return $this->insert($db_conn);
  }

  /**
   * Fonction d'insertion d'un enregistrement en base de données
   * @return int      Un code permettant de savoir si l'opération s'est bien passée (si connexion réussie)
   *         CL_DbErr Objet contenant le code et le message d'erreur (si échec connexion)
   */
  protected function insert($db_conn) {
    $sql = "INSERT INTO " . Ports::TABLE_NAME . " (nom)" .
           "VALUES ('" . ($this->nom) . "')";
    $result = CL_Dao::query($sql, $db_conn);
    $this->idport = $db_conn->insert_id;
    return $result;   // Qu'il s'agisse d'un CL_DbErr ou du nombre de lignes insérées, on le retourne
  }

  /**
   * Fonction de mise à jour d'un enregistrement en base de données
   * @return int      Un code permettant de savoir si l'opération s'est bien passée (si connexion réussie)
   *         CL_DbErr Objet contenant le code et le message d'erreur (si échec connexion)
   */
  protected function update($db_conn) {
    $sql = "UPDATE " . Ports::TABLE_NAME . " " .
           "SET nom = " . CL_Dao::getSqlString($this->nom) . " " .
           "WHERE idport = $this->idport";
    $result = CL_Dao::query($sql, $db_conn);
    return $result;   // Qu'il s'agisse d'un CL_DbErr ou du nombre de lignes mises à jour, on le retourne
  }
}
?>