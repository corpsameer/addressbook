<?php
require '../config/tables.php';
require_once 'base_model.php';

class Citymodel extends Basemodel{
  /**
  * Constructor
  *
  */
  public function __construct() {
    parent::__construct();
  }

  /**
  * Gets details of all cities from city table sorted by city names
  *
  */
  public function getAllCities() {
    $data = [];

    $query = "SELECT * FROM " . TABLE_CITY . " ORDER BY city_name";

    $result = $this->db->conn->query($query);

    if ($result->num_rows > 0) {
      $data = $result->fetch_all(MYSQLI_ASSOC);
    }

    return $data;
  }
}
?>
