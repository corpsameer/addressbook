<?php
require '../config/tables.php';
require_once 'base_model.php';

class Contactgroupmodel extends Basemodel{
  /**
  * Constructor
  *
  */
  public function __construct() {
    parent::__construct();
  }

  /**
  * Insert new contact group to contact group table
  *
  * @param array $contactGroupDetails Contact group data
  *
  * @return int|boolean
  */
  public function insertContactGroup($contactGroupDetails) {
    $columns = $this->implodeColumns(array_keys($contactGroupDetails));
    $values = $this->implodeData($this->escapeData(array_values($contactGroupDetails)));

    $query = "INSERT INTO " . TABLE_CONTACT_GROUP . " ($columns) VALUES ($values)";

    if ($this->db->conn->query($query) === TRUE) {
      $tagId = $this->db->conn->insert_id;

      return $tagId;
    }

    return false;
  }

  /**
  * Edit contact group details in contact group table
  *
  * @param int $contactGroupId Contact group id
  * @param array $contactGroupDetails Contact group data
  *
  * @return int|boolean
  */
  public function updateContactGroup($contactGroupId, $contactGroupDetails) {
    $updateData = $this->escapeData($contactGroupDetails);
    $id = $this->escapeData($contactGroupId);

    $query = "UPDATE " . TABLE_CONTACT_GROUP . " SET `contact_group_name` = '$updateData[contact_group_name]', ";
    $query .= "`contact_group_description` = '$updateData[contact_group_description]' WHERE `contact_group_id` = '$id'";

    if ($this->db->conn->query($query) === TRUE) {
      return $contactGroupId;
    }

    return false;
  }

  /**
  * Delete contact group details from contact group table
  *
  * @param int $contactGroupId Contact group id
  *
  * @return boolean
  */
  public function deleteContactGroup($contactGroupId) {
    $id = $this->escapeData($contactGroupId);

    $query = "DELETE FROM " . TABLE_CONTACT_GROUP . " WHERE `contact_group_id` = '$id'";

    if ($this->db->conn->query($query) === TRUE) {
      return true;
    }

    return false;
  }

  /**
  * Get details of all contact groups sorted by name from contact group table
  *
  * @return array
  */
  public function getAllContactGroups() {
    $data = [];

    $query = "SELECT * FROM " . TABLE_CONTACT_GROUP . " ORDER BY contact_group_name";

    $result = $this->db->conn->query($query);

    if ($result->num_rows > 0) {
      $data = $result->fetch_all(MYSQLI_ASSOC);
    }

    return $data;;
  }

  /**
  * Gets details of the contact group from contact group table
  *
  * @param int $contactGroupId Contact group id
  *
  * @return array
  */
  public function getContactGroup($contactGroupId) {
    $id = $this->escapeData($contactGroupId);
    $data = [];

    $query = "SELECT * FROM " . TABLE_CONTACT_GROUP . " WHERE `contact_group_id` = '$id'";

    $result = $this->db->conn->query($query);

    if ($result->num_rows > 0) {
      $data = $result->fetch_assoc();
    }

    return $data;
  }
}
