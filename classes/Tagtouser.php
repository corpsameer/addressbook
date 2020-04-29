<?php
require '../models/tagtouser_model.php';

class Tagtouser {
  /**
  * @property int $id Tag to user id
  */
  private $id;

  /**
  * @property int $tagId Tag id
  */
  private $tagId;

  /**
  * @property int $userId User id
  */
  private $userId;

  /**
  * @property object $tagToUserModel Tag to user table model
  */
  private $tagToUserModel;

  /**
  * Constructor
  *
  * @param int $tagId Tag id
  * @param int $userId User id
  */
  public function __construct($tagId = "", $userId = "") {
    $this->tagId = $tagId;
    $this->userId = $userId;
    $this->tagToUserModel = new Tagtousermodel();
  }

  /**
  * Add new tag to user
  *
  * @return int|boolean
  */
  public function add() {
    $data = $this->createDataArray();

    $response = $this->tagToUserModel->insertTagToUser($data);

    if ($response) {
      $this->id = $response;

      return $this->id;
    }

    return false;
  }

  /**
  * Delete tag from user
  *
  * @param int $tagToUserId Tag to user id
  *
  * @return boolean
  */
  public function delete($tagToUserId) {
    $response = $this->tagToUserModel->deleteTagToUser($tagToUserId);

    return $response;
  }

  /**
  * Delete tag from all users
  *
  * @param int $tagId Tag id
  *
  * @return boolean
  */
  public function deleteTagFromUsers($tagId) {
    $response = $this->tagToUserModel->deleteTagToUsers($tagId);

    return $response;
  }

  /**
  * Create array with table columns as keys and user properties as values
  *
  * @return array
  */
  private function createDataArray() {
    $data = [
      'tag_id' => $this->tagId,
      'user_id' => $this->userId
    ];

    return $data;
  }

  /**
  * Gets list of all the tags which are linked to atleast one user from database
  *
  * @return array
  */
  public function fetchTagsForFilter() {
    $data = $this->tagToUserModel->getFilterTags();

    return $data;
  }

  /**
  * Gets list of all the tags which are linked to the given user
  *
  * @param int $userId User id
  *
  * @return array
  */
  public function fetchTagsLinkedToUser($userId) {
    $data = $this->tagToUserModel->getTagsLinkedToUser($userId);

    return $data;
  }
}
?>
