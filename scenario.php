<?php

// Contient la définition de la superclasse
$cur_dir = dirname(dirname(__FILE__));
include($cur_dir . '/data/dao.php');

/**
 * Gestion des enregistrements de la table "profil"
 */
final class Scenarios extends CL_Dao {

  // Propriétés (champs de la table) et constantes
  const TABLE_NAME = "scenario";
  private $idscenario;
  private $nom;
  private $intervalle;

  // Ascesseurs et mutateurs
  public function getidscenario()         { return $this->idscenario; }
  public function setidscenario($val)     { $this->idscenario = $val; }
  public function getnom()        { return $this->nom; }
  public function setnom($val)    { $this->nom = $val; }
  public function getintervalle()        { return $this->intervalle; }
  public function setintervalle($val)    { $this->intervalle = $val; }

  // Constructeur de la classe
  function __construct() {
    $this->idscenario = null;
    $this->nom = null;
    $this->intervalle = null;
  }

  /**
   * Fonction récupérant et renvoyant la liste des éléments de la table en fonction des paramètres
   * @param  object $params Objet contenant les paramètres (filtres, par ex)
   * @return array          Une liste d'enregistrements au format objet (si connexion réussie)
   *         CL_DbErr       Objet contenant le code et le message d'erreur (si échec connexion)
   */
  public static function getList($params, $db_conn) {
    $sql = "SELECT idscenario, nom, intervalle FROM " . Scenarios::TABLE_NAME;
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
   * @param  int       $idscenario Clé de l'enregistrement
   * @return Scenarios     Objet initialisé avec les valeurs du tuple (si connexion réussie)
   *         CL_DbErr      Objet contenant le code et le message d'erreur (si échec connexion)
   */
  public static function get($idscenario, $db_conn) {
    $sql = "SELECT idscenario, nom, intervalle FROM " . Scenarios::TABLE_NAME . " WHERE idscenario = $idscenario";
    $result = CL_Dao::query($sql, $db_conn);
    if (is_a($result, "CL_DbErr"))            // Si c'est un CL_DbErr, on le retourne
      return $result;
    else if ($result->num_rows === 0)         // Si aucun résultat, on retourne une erreur
      return new CL_DbErr($sql, 0, "Scenarios inconnu $idscenario");
    else {                                    // Sinon, on retourne l'objet correspondant au résultat
      $ligne = $result->fetch_assoc();
      $retour = new Scenarios();
      $retour->setidscenario($ligne['idscenario']);
      $retour->setnom($ligne['nom']);
      $retour->setintervalle($ligne['intervalle']);
      return $retour;
    }
  }

  /**
   * Fonction supprimant un enregistrement de la table
   * @param  int $idscenario  Clé de l'enregistrement à supprimer
   * @return int      Un code permettant de savoir si l'opération s'est bien passée (si connexion réussie)
   *         CL_DbErr Objet contenant le code et le message d'erreur (si échec connexion)
   */
  public static function delete($idscenario, $db_conn) {
    $sql = "DELETE FROM " . Scenarios::TABLE_NAME . " WHERE idscenario = $idscenario";
    $result = CL_Dao::query($sql, $db_conn);
    return $result;   // Qu'il s'agisse d'un CL_DbErr ou du nombre de lignes supprimées, on le retourne
  }
  /**
   * Fonction d'aiguillage vers insert() / update()
   * @return int      Un code permettant de savoir si l'opération s'est bien passée (si connexion réussie)
   *         CL_DbErr Objet contenant le code et le message d'erreur (si échec connexion)
   */
  public function write($db_conn) {
    if ($this->idscenario)
      return $this->update($db_conn);
    else return $this->insert($db_conn);
  }

  /**
   * Fonction d'insertion d'un enregistrement en base de données
   * @return int      Un code permettant de savoir si l'opération s'est bien passée (si connexion réussie)
   *         CL_DbErr Objet contenant le code et le message d'erreur (si échec connexion)
   */
  protected function insert($db_conn) {
    $sql = "INSERT INTO " . Scenarios::TABLE_NAME . " (nom,intervalle)" .
           "VALUES ('" . ($this->nom) . "','" . ($this->intervalle) . "' )";
    $result = CL_Dao::query($sql, $db_conn);
    $this->idscenario = $db_conn->insert_id;
    return $result;   // Qu'il s'agisse d'un CL_DbErr ou du nombre de lignes insérées, on le retourne
  }

  /**
   * Fonction de mise à jour d'un enregistrement en base de données
   * @return int      Un code permettant de savoir si l'opération s'est bien passée (si connexion réussie)
   *         CL_DbErr Objet contenant le code et le message d'erreur (si échec connexion)
   */
  protected function update($db_conn) {
    $sql = "UPDATE " . Scenarios::TABLE_NAME . " " .
           "SET nom = " . CL_Dao::getSqlString($this->nom) . " " . CL_Dao::getSqlString($this->intervalle) .
           "WHERE idscenario = $this->idscenario";
    $result = CL_Dao::query($sql, $db_conn);
    return $result;   // Qu'il s'agisse d'un CL_DbErr ou du nombre de lignes mises à jour, on le retourne
  }
}
?>