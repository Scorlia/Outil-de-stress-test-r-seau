<?php

/**
 * La classe abstraite CL_Dao définit les méthodes à implémenter pour les classes en héritant
 * Il s'agit de la classe abstraite sur laquelle vont s'appuyer tous les DAO
 */
abstract class CL_Dao {

  // Constantes utilisée pour se connecter à la base de données (configuration)
  /*const DB_HOST = "cm671538-001.privatesql";
  const DB_USER = "francois";
  const DB_PASSWD = "gnTr654CK";
  const DB_NAME = "configurateur";
  const DB_PORT = 35566;*/

  // Configuration pour lescigales.org
  /*const DB_HOST = "localhost";
  const DB_USER = "m05_mysql";
  const DB_PASSWD = "eeca7sho";
  const DB_NAME = "m05_mysql";
  const DB_PORT = 3306;*/

  // Configuration pour l'environnement de tests
  const DB_HOST = "localhost";
  const DB_USER = "root";
  const DB_PASSWD = "";
  const DB_NAME = "projet";
  const DB_PORT = 3306;

  // Méthodes abstraites => ces méthodes doivent être implémentées par les classes filles
  abstract  static function getList($params, $db_conn); // Obtenir la liste des enregistrements
  abstract  static function get($id, $db_conn);         // Lire un enregistrement
  abstract  static function delete($id, $db_conn);      // Supprimer un enregistrement
  abstract  function write($db_conn);                   // Aiguillage -> insert() / update()
  abstract protected function insert($db_conn);               // Insérer le record courant
  abstract protected function update($db_conn);               // Mettre à jour le record courant

  // Méthode de connexion à la base de données (retourne une connexion BdD ou un CL_DbErr)
  public static function connect() {
    $db_conn = new mysqli("localhost", "root", "", "projet", 3306);
    $db_conn->set_charset("utf8");
    if ($db_conn->connect_errno)
      return new CL_DbErr(null, $db_conn->connect_errno, $db_conn->connect_error);
    else return $db_conn;
  }

  // Méthode de requête (retourne un résultat ou un CL_DbErr)
  public static function query($sql, $db_conn) {
    if (!$result = $db_conn->query($sql))
      $result = new CL_DbErr($sql, $db_conn->connect_errno, $db_conn->connect_error);
    return $result;
  }

  // Méthode d'injection de chaînes dans un champ, en base de données (doublage des ')
  public static function getSqlString($str) { return "'" . str_replace("'", "''", $str) . "'"; }

  // Méthode générant un DATETIME correspondant à l'instant T
  public static function getSqlNow() {
    $now = new DateTime();
    return "STR_TO_DATE('" . $now->format('d/m/Y H:i:s') . "', '%d/%m/%Y %H:%i:%s')";
  }
}

//-----------------------------------------------------------------------------------------------
/* Les fonctions DA renverront le type attendu si tout se passe bien, sinon un CL_DbErr */
//-----------------------------------------------------------------------------------------------
/**
 * La classe CL_DbErr définit les erreurs issues de la base de données
 */
final class CL_DbErr {
  
  // Propriétés
  private $query;
  private $errno;
  private $error;

  // Ascesseurs et mutateurs
  public function getQuery()      { return $this->query; }
  public function setQuery($val)  { $this->query = $val; }
  public function getErrno()      { return $this->errno; }
  public function setErrno($val)  { $this->errno = $val; }
  public function getError()      { return $this->error; }
  public function setError($val)  { $this->error = $val; }

  // Constructeur
  function __construct($query, $errno, $error) {
    $this->query = $query;
    $this->errno = $errno;
    $this->error = $error;
  }

  // Fonction d'affichage --> surcharge fonction magique __toString()
  public function __toString() {
    if ($this->query)
      return "Query: $this->query \nCode: $this->errno \nError: $this->error";
    else return 'Échec connexion => ' . $this->errno . ': ' . $this->error; 
  }
}
?>