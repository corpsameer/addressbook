<?php
require '../config/tables.php';
require_once 'base_model.php';

class Tagtousermodel extends Basemodel{
  /**
  * Constructor
  *
  */
  public function __construct() {
    parent::__construct();
  }

  /**
  * Add tag to user
  *
  * @param array $tagToUserDetails Tag to user data
  *
  * @return int|boolean
  */
  public function insertTagToUser($tagToUserDetails) {
    $columns = $this->implodeColumns(array_keys($tagToUserDetails));
    $values = $this->implodeData($this->escapeData(array_values($tagToUserDetails)));

    $query = "INSERT INTO " . TABLE_TAG_TO_USER . " ($columns) VALUES ($values)";

    if ($this->db->conn->query($query) === TRUE) {
      $tagToUserId = $this->db->conn->insert_id;

      return $tagToUserId;
    }

    return false;
  }

  /**
  * Delete tag to user details from tag to user table
  *
  * @param int $tagToUserId Tag to user id
  *
  * @return boolean
  */
  public function deleteTagToUser($tagToUserId) {
    $id = $this->escapeData($tagToUserId);

    $query = "DELETE FROM " . TABLE_TAG_TO_USER . " WHERE `tag_to_user_id` = '$id'";

    if ($this->db->conn->query($query) === TRUE) {
      return true;
    }

    return false;
  }

  /**
  * Delete tag from all users its linked to
  *
  * @param int $tagId Tag id
  *
  * @return boolean
  */
  public function deleteTagToUsers($tagId) {
    $id = $this->escapeData($tagId);

    $query = "DELETE FROM " . TABLE_TAG_TO_USER . " WHERE `tag_id` = '$id'";

    if ($this->db->conn->query($query) === TRUE) {
      return true;
    }

    return false;
  }

  /**
  * Get details of all tags that are linked to atleast one user
  *
  * @return array
  */
  public function getFilterTags() {
    $data = [];

    $query = "SELECT DISTINCT a.tag_id as tag_id, b.tag_name FROM " . TABLE_TAG_TO_USER . " a ";
    $query .= "join " . TABLE_TAG . " b WHERE a.tag_id = b.tag_id ORDER BY b.tag_name";

    $result = $this->db->conn->query($query);

    if ($result->num_rows > 0) {
      $data = $result->fetch_all(MYSQLI_ASSOC);
    }

    return $data;;
  }

  /**
  * Get details of all tags that are linked to the given user
  *
  * @param int $userId User id
  *
  * @return array
  */
  public function getTagsLinkedToUser($userId) {
    $data = [];

    $query = "SELECT DISTINCT a.tag_id as tag_id, b.tag_name FROM " . TABLE_TAG_TO_USER . " a ";
    $query .= "join " . TABLE_TAG . " b WHERE a.tag_id = b.tag_id and a.user_id = '$userId' ORDER BY b.tag_name";

    $result = $this->db->conn->query($query);

    if ($result->num_rows > 0) {
      $data = $result->fetch_all(MYSQLI_ASSOC);
    }

    return $data;;
  }
}