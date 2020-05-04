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
  * Insert new user to user table
  *
  * @param array $userDetails User data
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

  /**
  * Edit user details in user table
  *
  * @param int $userId User id
  * @param array $userDetails User data
  *
  * @return int|boolean
  */
  public function updateUser($userId, $userDetails) {
    $updateData = $this->escapeData($userDetails);
    $id = $this->escapeData($userId);

    $query = "UPDATE " . TABLE_USER . " SET `full_name` = '$updateData[full_name]', ";
    $query .= "`first_name` = '$updateData[first_name]', `last_name` = '$updateData[last_name]', ";
    $query .= "`email` = '$updateData[email]' WHERE `user_id` = '$id'";

    if ($this->db->conn->query($query) === TRUE) {
      return $userId;
    }

    return false;
  }

  /**
  * Delete user details from user table
  *
  * @param int $userId User id
  *
  * @return boolean
  */
  public function deleteUser($userId) {
    $id = $this->escapeData($userId);

    $query = "DELETE FROM " . TABLE_USER . " WHERE `user_id` = '$id'";

    if ($this->db->conn->query($query) === TRUE) {
      return true;
    }

    return false;
  }

  /**
  * Gets details of all users from database joining user, address and city tables and apply tag filter if applicable
  *
  * @param int $tagId Tag id by which users can be filtered
  *
  * @return array
  */
  public function getAllUsers($tagId) {
    $data = [];
    $tagId = $this->escapeData($tagId);

    $query = "SELECT u.*, a.*, c.* FROM " . TABLE_USER;
    $query .= " u INNER JOIN " . TABLE_ADDRESS . " a ON u.user_id = a.address_user_id ";
    $query .= "INNER JOIN " . TABLE_CITY . " c ON a.address_city_id = c.city_id ";

    if ($tagId != 0) {
      $query .= "INNER JOIN " . TABLE_TAG_TO_USER . " d ON u.user_id = d.user_id WHERE d.tag_id = '$tagId'";
    }

    $query .= "ORDER BY u.full_name";
    $result = $this->db->conn->query($query);

    if ($result->num_rows > 0) {
      $data = $result->fetch_all(MYSQLI_ASSOC);
    }

    return $data;
  }

  /**
  * Gets details of the user from database joining user, address and city tables
  *
  * @param int|array $userId User id whose details are to be fetched
  *
  * @return array
  */
  public function getUser($userId) {
    $data = [];

    if (is_array($userId)) {
      $userIds = $this->implodeData($this->escapeData(array_values($userId)));
    } else {
      $userId = $this->escapeData($userId);
    }



    $query = "SELECT u.*, a.*, c.* FROM " . TABLE_USER;
    $query .= " u INNER JOIN " . TABLE_ADDRESS . " a ON u.user_id = a.address_user_id ";
    $query .= "INNER JOIN " . TABLE_CITY . " c ON a.address_city_id = c.city_id WHERE ";

    if (is_array($userId)) {
      $query .= "u.user_id IN ($userIds)";
    } else {
      $query .= "u.user_id = '$userId'";
    }

    $result = $this->db->conn->query($query);

    if ($result->num_rows > 0) {
      if (is_array($userId)) {
        $data = $result->fetch_all(MYSQLI_ASSOC);
      } else {
        $data = $result->fetch_assoc();
      }
    }

    return $data;
  }
}
?>
