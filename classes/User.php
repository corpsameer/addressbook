<?php
require '../models/user_model.php';

class User {
  /**
  * @property int $id User id
  */
  private $id;

  /**
  * @property string $fullName User fullname
  */
  private $fullName;

  /**
  * @property string $firstName User firstname
  */
  private $firstName;

  /**
  * @property string $lastName User lastname
  */
  private $lastName;

  /**
  * @property string $email User email
  */
  private $email;

  /**
  * @property object $userModel User table model
  */
  private $userModel;

  /**
  * Constructor
  *
  * @param string $firstName User firstname
  * @param string $lastName User lastname
  * @param string $email User email
  */
  public function __construct($firstName = "", $lastName = "", $email = "") {
    $this->firstName = $firstName;
    $this->lastName = $lastName;
    $this->fullName = $this->createFullName();
    $this->email = $email;
    $this->userModel = new Usermodel();
  }

  /**
  * Create user fullname from firstname and lastname
  *
  */
  private function createFullName() {
    return $this->firstName . " " . $this->lastName;
  }

  /**
  * Add new user
  *
  * @return int|boolean
  */
  public function add() {
    $data = $this->createDataArray();

    $response = $this->userModel->insertUser($data);

    if ($response) {
      $this->id = $response;

      return $this->id;
    }

    return false;
  }

  /**
  * Update user
  *
  * @param int $userId User id
  *
  * @return int|boolean
  */
  public function update($userId) {
    $data = $this->createDataArray();

    $response = $this->userModel->updateUser($userId, $data);

    if ($response) {
      $this->id = $response;

      return $this->id;
    }

    return false;
  }

  /**
  * Delete user
  *
  * @param int $userId User id
  *
  * @return boolean
  */
  public function delete($userId) {
    $response = $this->userModel->deleteUser($userId);

    return $response;
  }

  /**
  * Create array with table columns as keys and user properties as values
  *
  * @return array
  */
  private function createDataArray() {
    $data = [
      'full_name' => $this->fullName,
      'first_name' => $this->firstName,
      'last_name' => $this->lastName,
      'email' => $this->email
    ];

    return $data;
  }

  /**
  * Gets all details of all the users from database
  *
  * @param int $tagId Tag id by which users are to be filtered
  *
  * @return array
  */
  public function fetchAllUsers($tagId) {
    $data = $this->userModel->getAllUsers($tagId);

    return $data;
  }

  /**
  * Gets all details of the user from database
  *
  * @param int|array $userId User id
  *
  * @return array
  */
  public function fetchUser($userId) {
    $data = $this->userModel->getUser($userId);

    return $data;
  }
}
?>
