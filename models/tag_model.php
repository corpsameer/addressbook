<?php
require '../config/tables.php';
require_once 'base_model.php';

class Tagmodel extends Basemodel{
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
  public function insertTag($tagDetails) {
    $columns = $this->implodeColumns(array_keys($tagDetails));
    $values = $this->implodeData($this->escapeData(array_values($tagDetails)));

    $query = "INSERT INTO " . TABLE_TAG . " ($columns) VALUES ($values)";

    if ($this->db->conn->query($query) === TRUE) {
      $tagId = $this->db->conn->insert_id;

      return $tagId;
    }

    return false;
  }

  /**
  * Edit tag details in tag table
  *
  * @param int $tagId Tag id
  * @param array $tagDetails Tag data
  *
  * @return int|boolean
  */
  public function updateTag($tagId, $tagDetails) {
    $updateData = $this->escapeData($tagDetails);
    $id = $this->escapeData($tagId);

    $query = "UPDATE " . TABLE_TAG . " SET `tag_name` = '$updateData[tag_name]', ";
    $query .= "`tag_description` = '$updateData[tag_description]' WHERE `tag_id` = '$id'";

    if ($this->db->conn->query($query) === TRUE) {
      return $tagId;
    }

    return false;
  }

  /**
  * Delete tag details from tag table
  *
  * @param int $tagId Tag id
  *
  * @return boolean
  */
  public function deleteTag($tagId) {
    $id = $this->escapeData($tagId);

    $query = "DELETE FROM " . TABLE_TAG . " WHERE `tag_id` = '$id'";

    if ($this->db->conn->query($query) === TRUE) {
      return true;
    }

    return false;
  }

  /**
  * Get details of all tags sorted by name from tag table
  *
  * @return array
  */
  public function getAllTags() {
    $data = [];

    $query = "SELECT * FROM " . TABLE_TAG . " ORDER BY tag_name";

    $result = $this->db->conn->query($query);

    if ($result->num_rows > 0) {
      $data = $result->fetch_all(MYSQLI_ASSOC);
    }

    return $data;;
  }

  /**
  * Gets details of the tag from database joining user, address and city tables
  *
  * @param int $tagId Tag id
  *
  * @return array
  */
  public function getTag($tagId) {
    $id = $this->escapeData($tagId);
    $data = [];

    $query = "SELECT * FROM " . TABLE_TAG . " WHERE `tag_id` = '$id'";

    $result = $this->db->conn->query($query);

    if ($result->num_rows > 0) {
      $data = $result->fetch_assoc();
    }

    return $data;
  }
}
?>
