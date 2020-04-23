<?php
require_once '../models/city_model.php';

class City {
  /**
  * @property int $id City id
  */
  private   $id;

  /**
  * @property string $name City name
  */
  private $name;

  /**
  * @property object $cityModel City table model
  */
  private $cityModel;

  /**
  * Constructor
  *
  * @param string $name City name
  */
  public function __construct($name = "") {
    $this->name = $name;
    $this->cityModel = new Citymodel();
  }

  /**
  * Gets list of all the cities from database
  *
  * @return array
  */
  public function fetchAllCities() {
    $data = $this->cityModel->getAllCities();

    return $data;
  }
}
?>
