<?php
require '../config/tables.php';
require_once 'base_model.php';

class Addressmodel extends Basemodel{
  /**
  * Constructor
  *
  */
  public function __construct() {
    parent::__construct();
  }

  /**
  * Insert address address table
  *
  * @param array $addressDetails Address data
  *
  * @return int|boolean
  */
  public function insertAddress($addressDetails) {
    $columns = $this->implodeColumns(array_keys($addressDetails));
    $values = $this->implodeData($this->escapeData(array_values($addressDetails)));

    $query = "INSERT INTO " . TABLE_ADDRESS . " ($columns) VALUES ($values)";

    if ($this->db->conn->query($query) === TRUE) {
      $userId = $this->db->conn->insert_id;

      return $userId;
    }

    return false;
  }

  /**
  * Edit user details in user table
  *
  * @param int $addressId Address id
  * @param int $userId User id
  * @param array $addressDetails Address data
  *
  * @return int|boolean
  */
  public function updateAddress($addressId, $userId, $addressDetails) {
    $updateData = $this->escapeData($addressDetails);
    $id = $this->escapeData($addressId);
    $userId = $this->escapeData($userId);

    $query = "UPDATE " . TABLE_ADDRESS . " SET `address_user_id` = '$updateData[address_user_id]', ";
    $query .= "`house_no` = '$updateData[house_no]', `street` = '$updateData[street]', ";
    $query .= "`zipcode` = '$updateData[zipcode]', `address_city_id` = '$updateData[address_city_id]' ";
    $query .= "WHERE `address_id` = '$id' AND `address_user_id` = '$userId'";

    if ($this->db->conn->query($query) === TRUE) {
      return $addressId;
    }

    return false;
  }

  /**
  * Delete address details from address table
  *
  * @param int $addressId Address id
  *
  * @return boolean
  */
  public function deleteAddress($addressId, $userId) {
    $id = $this->escapeData($addressId);

    $query = "DELETE FROM " . TABLE_ADDRESS . " WHERE `address_id` = '$id'";

    if ($this->db->conn->query($query) === TRUE) {
      return true;
    }

    return false;
  }
}
