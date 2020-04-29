<?php
require '../config/tables.php';
require_once 'base_model.php';

class Usermodel extends Basemodel{
  /**
  * Constructor
  *
  */
  public function __construct() {
    parent::__construct();
  }

  /**
  * Insert new tag to tag table
  *
  * @param array $tagDetails Tag data
  *
  * @return int|boolean
  */
  public function insertUser($userDetails) {
    $columns = $this->implodeColumns(array_keys($userDetails));
    $values = $this->implodeData($this->escapeData(array_values($userDetails)));

    $query = "INSERT INTO " . TABLE_USER . " ($columns) VALUES ($values)";

    if ($this->db->conn->query($query) === TRUE) {
      $userId = $this->db->conn->insert_id;

      return $userId;
    }

    return false;
  }
}
?>
