<?php
require '../config/tables.php';
require '../config/constants.php';
require_once 'base_model.php';

class Usertocontactgroupmodel extends Basemodel{
  /**
  * Constructor
  *
  */
  public function __construct() {
    parent::__construct();
  }

  /**
  * Check if user is linked to contact group
  *
  * @param int $userId User id
  * @param int|array $contactGroupId Contact group id
  *
  * @return boolean
  */
  public function isUserLinkedToGroup($userId, $contactGroupId) {
    $userId = $this->escapeData($userId);
    $contactGroupIds = "";

    if (is_array($contactGroupId)) {
      $contactGroupIds = $this->implodeData($this->escapeData(array_values($contactGroupId)));
    } else {
      $contactGroupId = $this->escapeData($contactGroupId);
    }

    $isLinked = false;

    $query = "SELECT * FROM " . TABLE_USER_TO_CONTACT_GROUP . " ";
    $query .= "WHERE `user_id` = '$userId' AND ";

    if (is_array($contactGroupId)) {
      $query .= "`contact_group_id` IN ($contactGroupIds) AND `is_blocked` = " . STATUS_NOT_BLOCKED;
    } else {
      $query .= "`contact_group_id` = '$contactGroupId'";
    }

    $result = $this->db->conn->query($query);

    if ($result->num_rows > 0) {
      $isLinked = true;
    }

    return $isLinked;
  }

  /**
  * Check if user is blocked from contact group
  *
  * @param int $userId User id
  * @param int $contactGroupId Contact group id
  *
  * @return boolean
  */
  public function isUserBlockedFromGroup($userId, $contactGroupId) {
    $userId = $this->escapeData($userId);
    $contactGroupId = $this->escapeData($contactGroupId);
    $isBlocked = false;

    $query = "SELECT * FROM " . TABLE_USER_TO_CONTACT_GROUP . " ";
    $query .= "WHERE `user_id` = '$userId' AND `contact_group_id` = '$contactGroupId'";
    $result = $this->db->conn->query($query);

    if ($result->num_rows > 0) {
      $data = $result->fetch_assoc();

      if ($data['is_blocked'] == STATUS_BLOCKED) {
        $isBlocked = true;
      }
    }

    return $isBlocked;
  }

  /**
  * Link user to contact group
  *
  * @param int $userId User id
  * @param int $contactGroupId Contact group id
  *
  * @return boolean
  */
  public function insertUserToGroupLink($userId, $contactGroupId) {
    $userId = $this->escapeData($userId);
    $contactGroupId = $this->escapeData($contactGroupId);
    $isLinked = false;

    $query = "INSERT INTO " . TABLE_USER_TO_CONTACT_GROUP . " ";
    $query .= "(`user_id`, `contact_group_id`) VALUES ('$userId', '$contactGroupId')";

    if ($this->db->conn->query($query) === TRUE) {
      $isLinked = true;
    }

    return $isLinked;
  }

  /**
  * Block given user from given contact group
  *
  * @param int $userId User id
  * @param int $contactGroupId Contact group id
  *
  * @return boolean
  */
  public function blockUserFromGroup($userId, $contactGroupId) {
    $userId = $this->escapeData($userId);
    $contactGroupId = $this->escapeData($contactGroupId);

    $query = "REPLACE INTO " . TABLE_USER_TO_CONTACT_GROUP . " ";
    $query .= "(`user_id`, `contact_group_id`, `is_blocked`) VALUES ('$userId', '$contactGroupId', " . STATUS_BLOCKED . ")";

    if ($this->db->conn->query($query) === TRUE) {
      return true;
    }

    return false;
  }

  /**
  * Unblock given user from given contact group
  *
  * @param int $userId User id
  * @param int $contactGroupId Contact group id
  *
  * @return boolean
  */
  public function unblockUserFromGroup($userId, $contactGroupId) {
    $userId = $this->escapeData($userId);
    $contactGroupId = $this->escapeData($contactGroupId);

    $query = "REPLACE INTO " . TABLE_USER_TO_CONTACT_GROUP . " ";
    $query .= "(`user_id`, `contact_group_id`, `is_blocked`) VALUES ('$userId', '$contactGroupId', " . STATUS_NOT_BLOCKED . ")";

    if ($this->db->conn->query($query) === TRUE) {
      return true;
    }

    return false;
  }

  /**
  * Delete given user from given contact group
  *
  * @param int|array $userId User id
  * @param int|array $contactGroupId Contact group id
  *
  * @return boolean
  */
  public function deleteUserFromGroup($userId, $contactGroupId) {
    $userId = $this->escapeData($userId);
    $contactGroupIds = "";

    if (is_array($contactGroupId)) {
      $contactGroupIds = $this->implodeData($this->escapeData(array_values($contactGroupId)));
    } else {
      $contactGroupId = $this->escapeData($contactGroupId);
    }

    if (is_array($userId)) {
      $userIds = $this->implodeData($this->escapeData(array_values($userId)));
    } else {
      $userId = $this->escapeData($userId);
    }

    $query = "DELETE FROM " . TABLE_USER_TO_CONTACT_GROUP . " WHERE ";

    if (is_array($userId)) {
      $query .= "`user_id` IN ($userIds) AND ";
    } else {
      $query .= "`user_id` = '$userId' AND ";
    }

    if (is_array($contactGroupId)) {
      $query .= "`contact_group_id` IN ($contactGroupIds) AND `is_blocked` = " . STATUS_NOT_BLOCKED;
    } else {
      $query .= "`contact_group_id` = '$contactGroupId'";
    }

    if ($this->db->conn->query($query) === TRUE) {
      return true;
    }

    return false;
  }

  /**
  * Delete all users from given contact group
  *
  * @param int $contactGroupId Contact group id
  *
  * @return boolean
  */
  public function deleteAllUsersFromGroup($contactGroupId) {
    $contactGroupId = $this->escapeData($contactGroupId);

    $query = "DELETE FROM " . TABLE_USER_TO_CONTACT_GROUP . " ";
    $query .= "WHERE `contact_group_id` = '$contactGroupId'";

    if ($this->db->conn->query($query) === TRUE) {
      return true;
    }

    return false;
  }

  /**
  * Delete given user from all contact group
  *
  * @param int $userId User id
  *
  * @return boolean
  */
  public function deleteUserFromAllGroups($userId) {
    $userId = $this->escapeData($userId);

    $query = "DELETE FROM " . TABLE_USER_TO_CONTACT_GROUP . " ";
    $query .= "WHERE `user_id` = '$userId'";

    if ($this->db->conn->query($query) === TRUE) {
      return true;
    }

    return false;
  }

  /**
  * Get all active users in given group
  *
  * @param int|array $contactGroupId Contact group id
  *
  * @return array
  */
  public function getActiveUsersInGroup($contactGroupId) {
    $data = [];
    $contactGroupIds = "";

    if (is_array($contactGroupId)) {
      $contactGroupIds = $this->implodeData($this->escapeData(array_values($contactGroupId)));
    } else {
      $contactGroupId = $this->escapeData($contactGroupId);
    }

    $query = "SELECT DISTINCT `user_id` FROM " . TABLE_USER_TO_CONTACT_GROUP . " ";
    $query .= "WHERE `is_blocked` = " . STATUS_NOT_BLOCKED . " AND ";

    if (is_array($contactGroupId)) {
      $query .= "`contact_group_id` IN ($contactGroupIds)";
    } else {
      $query .= "`contact_group_id` = '$contactGroupId'";
    }

    $result = $this->db->conn->query($query);

    if ($result->num_rows > 0) {
      while ($row = mysqli_fetch_array($result)) {
        $data[] = $row['user_id'];
      }
    }

    return $data;
  }

  /**
  * Get all blocked users in given group
  *
  * @param int|array $contactGroupId Contact group id
  *
  * @return array
  */
  public function getBlockedUsersInGroup($contactGroupId) {
    $data = [];

    $query = "SELECT `user_id` FROM " . TABLE_USER_TO_CONTACT_GROUP . " ";
    $query .= "WHERE `contact_group_id` = '$contactGroupId' AND `is_blocked` = " . STATUS_BLOCKED;

    $result = $this->db->conn->query($query);

    if ($result->num_rows > 0) {
      while ($row = mysqli_fetch_array($result)) {
        $data[] = $row['user_id'];
      }
    }

    return $data;;
  }
}
