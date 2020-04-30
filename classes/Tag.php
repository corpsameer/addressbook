<?php
require '../models/tag_model.php';

class Tag {
  /**
  * @property int $id Tag id
  */
  private $id;

  /**
  * @property string $name Tag name
  */
  private $name;

  /**
  * @property string $description Tag description
  */
  private $description;

  /**
  * @property object $tagModel Tag table model
  */
  private $tagModel;

  /**
  * Constructor
  *
  * @param string $name Tag name
  * @param string $description Tag description
  */
  public function __construct($name = "", $description = "") {
    $this->name = $name;
    $this->description = $description;
    $this->tagModel = new Tagmodel();
  }

  /**
  * Add new tag
  *
  * @return int|boolean
  */
  public function add() {
    $data = $this->createDataArray();

    $response = $this->tagModel->insertTag($data);

    if ($response) {
      $this->id = $response;

      return $this->id;
    }

    return false;
  }

  /**
  * Update tag
  *
  * @param int $tagId Tag id
  *
  * @return int|boolean
  */
  public function update($tagId) {
    $data = $this->createDataArray();

    $response = $this->tagModel->updateTag($tagId, $data);

    if ($response) {
      $this->id = $response;

      return $this->id;
    }

    return false;
  }

  /**
  * Delete tag
  *
  * @param int $tagId Tag id
  *
  * @return boolean
  */
  public function delete($tagId) {
    $response = $this->tagModel->deleteTag($tagId);

    return $response;
  }

  /**
  * Create array with table columns as keys and user properties as values
  *
  * @return array
  */
  private function createDataArray() {
    $data = [
      'tag_name' => ucfirst($this->name),
      'tag_description' => ucfirst($this->description)
    ];

    return $data;
  }

  /**
  * Gets list of all the tags from database
  *
  * @return array
  */
  public function fetchAllTags() {
    $data = $this->tagModel->getAllTags();

    return $data;
  }

  /**
  * Gets all details of the tag from database
  *
  * @param int $tagId Tag id
  *
  * @return array
  */
  public function fetchTag($tagId) {
    $data = $this->tagModel->getTag($tagId);

    return $data;
  }
}
?>
