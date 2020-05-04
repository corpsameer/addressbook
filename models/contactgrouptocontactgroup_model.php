<?php
require '../config/tables.php';
require_once 'base_model.php';

class Contactgrouptocontactgroupmodel extends Basemodel{
  /**
  * Constructor
  *
  */
  public function __construct() {
    parent::__construct();
  }

  /**
  * Check if parent contact group is already linked to child contact group
  *
  * @param int $parentGroupId Contact group id of parent group
  * @param int $childGroupId Contact group id of child group
  *
  * @return boolean
  */
  public function checkGroupLink($parentGroupId, $childGroupId) {
    $parentGroupId = $this->escapeData($parentGroupId);
    $childGroupId = $this->escapeData($childGroupId);
    $isLinked = false;

    $query = "SELECT * FROM " . TABLE_CONTACT_GROUP_TO_CONTACT_GROUP . " ";
    $query .= "WHERE `parent_id` = '$parentGroupId' AND `child_id` = '$childGroupId'";
    $result = $this->db->conn->query($query);

    if ($result->num_rows > 0) {
      $isLinked = true;
    }

    return $isLinked;
  }

  /**
  * Link parent group to child group
  *
  * @param int $parentGroupId Contact group id of parent group
  * @param int $childGroupId Contact group id of child group
  *
  * @return boolean
  */
  public function insertGroupLink($parentGroupId, $childGroupId) {
    $parentGroupId = $this->escapeData($parentGroupId);
    $childGroupId = $this->escapeData($childGroupId);
    $isLinked = false;

    $query = "INSERT INTO " . TABLE_CONTACT_GROUP_TO_CONTACT_GROUP . " ";
    $query .= "(`parent_id`, `child_id`) VALUES ('$parentGroupId', '$childGroupId')";

    if ($this->db->conn->query($query) === TRUE) {
      $isLinked = true;
    }

    return $isLinked;
  }

  /**
  * Delete all parent groups link to given child group
  *
  * @param int $childGroupId Contact group id of child group
  *
  * @return boolean
  */
  public function deleteParentGroups($childGroupId) {
    $childGroupId = $this->escapeData($childGroupId);

    $query = "DELETE FROM " . TABLE_CONTACT_GROUP_TO_CONTACT_GROUP . " WHERE `child_id` = '$childGroupId'";

    if ($this->db->conn->query($query) === TRUE) {
      return true;
    }

    return false;
  }

  /**
  * Delete all child groups link to given parent group
  *
  * @param int $parentGroupId Contact group id of parent group
  *
  * @return boolean
  */
  public function deleteChildGroups($parentGroupId) {
    $parentGroupId = $this->escapeData($parentGroupId);

    $query = "DELETE FROM " . TABLE_CONTACT_GROUP_TO_CONTACT_GROUP . " WHERE `parent_id` = '$parentGroupId'";

    if ($this->db->conn->query($query) === TRUE) {
      return true;
    }

    return false;
  }

  /**
  * Get all parent groups of given child group
  *
  * @param int $childGroupId Contact group id of child group
  *
  * @return array
  */
  public function getParentGroups($childGroupId) {
    $data = [];

    $query = "SELECT `parent_id` FROM " . TABLE_CONTACT_GROUP_TO_CONTACT_GROUP . " WHERE `child_id` = '$childGroupId'";

    $result = $this->db->conn->query($query);

    if ($result->num_rows > 0) {
      while ($row = mysqli_fetch_array($result)) {
        $data[] = $row['parent_id'];
      }
    }

    return $data;;
  }

  /**
  * Get all parent groups of given child group
  *
  * @param int $parentGroupId Contact group id of parent group
  *
  * @return array
  */
  public function getChildGroups($parentGroupId) {
    $data = [];

    $query = "SELECT `child_id` FROM " . TABLE_CONTACT_GROUP_TO_CONTACT_GROUP . " WHERE `parent_id` = '$parentGroupId'";

    $result = $this->db->conn->query($query);

    if ($result->num_rows > 0) {
      while ($row = mysqli_fetch_array($result)) {
        $data[] = $row['child_id'];
      }
    }

    return $data;;
  }
}
