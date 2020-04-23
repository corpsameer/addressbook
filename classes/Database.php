<?php
require_once '../config/database.php';

class Database {
  /**
  * @property string $conn MySql connection string
  */
  public $conn;

  /**
  * Constructor - Creates database connection and throws error if connection is not successful
  *
  * @param string $host Database hostname
  * @param string $user Database username
  * @param string $password Database password
  * @param string $db Database name
  */
  public function __construct($host = DB_HOST, $user = DB_USER, $password = DB_PASSWORD, $db = DB_NAME) {
    $this->conn = new mysqli($host, $user, $password, $db);

    if ($this->conn->connect_errno) {
      echo "Failed to connect to MySQL: " . $this->conn->connect_error;
      exit();
    }
  }
}

?>
