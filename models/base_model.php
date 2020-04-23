<?php
require_once '../classes/Database.php';

class Basemodel {
  /**
  * @property object $db Databse object
  */
  protected $db;

  /**
  * Constructor
  *
  */
  public function __construct() {
    $this->db = new Database();
  }

  /**
  * Implode columns with backtick and comma for database operations
  *
  * @param array $data Data to be imploded
  *
  * @return string
  */
  public function implodeColumns($data) {
    $columns = "`" . implode ( "`, `", $data ) . "`";

    return $columns;
  }

  /**
  * Implode data with single quote and comma for database operations
  *
  * @param array $data Data to be imploded
  *
  * @return string
  */
  public function implodeData($data) {
    $columns = "'" . implode ( "', '", $data ) . "'";

    return $columns;
  }

  /**
  * Escapes data to be used for database operations
  *
  * @param array|string $data Data to be escaped
  *
  * @return array|string
  */
  public function escapeData($data) {
    if (is_array($data)) {
      foreach ($data as $field => $value) {
        $data[$field] = $this->db->conn->real_escape_string($value);
      }
    } else {
      $data = $this->db->conn->real_escape_string($data);
    }

    return $data;
  }
}
?>
