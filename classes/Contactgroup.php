<?php
require '../models/contactgroup_model.php';

class Contactgroup {
  /**
  * @property int $id Contact group id
  */
  private $id;

  /**
  * @property string $name Contact group name
  */
  private $name;

  /**
  * @property string $description Contact group description
  */
  private $description;

  /**
  * @property object $contactGroupModel Contact group table model
  */
  private $contactGroupModel;

  /**
  * Constructor
  *
  * @param string $name Contact group name
  * @param string $description Contact group description
  */
  public function __construct($name = "", $description = "") {
    $this->name = $name;
    $this->description = $description;
    $this->contactGroupModel = new Contactgroupmodel();
  }

  /**
  * Add new contact group
  *
  * @return int|boolean
  */
  public function add() {
    $data = $this->createDataArray();

    $response = $this->contactGroupModel->insertContactGroup($data);

    if ($response) {
      $this->id = $response;

      return $this->id;
    }

    return false;
  }

  /**
  * Update contact group
  *
  * @param int $contactGroupId Contact group id
  *
  * @return int|boolean
  */
  public function update($contactGroupId) {
    $data = $this->createDataArray();

    $response = $this->contactGroupModel->updateContactGroup($contactGroupId, $data);

    if ($response) {
      $this->id = $response;

      return $this->id;
    }

    return false;
  }

  /**
  * Delete contact group
  *
  * @param int $contactGroupId Contact group id
  *
  * @return boolean
  */
  public function delete($contactGroupId) {
    $response = $this->contactGroupModel->deleteContactGroup($contactGroupId);

    return $response;
  }

  /**
  * Create array with table columns as keys and contact group properties as values
  *
  * @return array
  */
  private function createDataArray() {
    $data = [
      'contact_group_name' => ucfirst($this->name),
      'contact_group_description' => ucfirst($this->description)
    ];

    return $data;
  }

  /**
  * Gets list of all the contact groups from database
  *
  * @return array
  */
  public function fetchAllContactGroups() {
    $data = $this->contactGroupModel->getAllContactGroups();

    return $data;
  }

  /**
  * Gets all details of the contact group from database
  *
  * @param int $contactGroupId Contact group id
  *
  * @return array
  */
  public function fetchContactGroup($contactGroupId) {
    $data = $this->contactGroupModel->getContactGroup($contactGroupId);

    return $data;
  }
}
