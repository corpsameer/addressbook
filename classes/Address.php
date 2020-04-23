<?php
require_once '../models/address_model.php';

class Address {
  /**
  * @property int $id Address id
  */
  private $id;

  /**
  * @property int $userId Address user id
  */
  private $userId;

  /**
  * @property string $houseNumber Address house number
  */
  private $houseNumber;

  /**
  * @property string $street Address street
  */
  private $street;

  /**
  * @property string $zipcode Address zipcode
  */
  private $zipcode;

  /**
  * @property int $cityId Address city id
  */
  private $cityId;

  /**
  * @property object $addressModel Address table model
  */
  private $addressModel;

  /**
  * Constructor
  *
  * @param int $userId User id
  * @param string $houseNumber House number
  * @param string $street Street
  * @param string $zipcode Zipcode
  * @param int $cityId City id
  */
  public function __construct($userId = "", $houseNumber = "", $street = "", $zipcode = "", $cityId = "") {
    $this->userId = $userId;
    $this->houseNumber = $houseNumber;
    $this->street = $street;
    $this->zipcode = $zipcode;
    $this->cityId = $cityId;
    $this->addressModel = new Addressmodel();
  }

  /**
  * Add new address
  *
  * @return int|boolean
  */
  public function add() {
    $data = $this->createDataArray();

    $response = $this->addressModel->insertAddress($data);

    if ($response) {
      $this->id = $response;

      return $this->id;
    }

    return false;
  }

  /**
  * Update address
  *
  * @param int $addressId Address id
  * @param int $userId User id
  *
  * @return int|boolean
  */
  public function update($addressId, $userId) {
    $data = $this->createDataArray();

    $response = $this->addressModel->updateAddress($addressId, $userId, $data);

    if ($response) {
      $this->id = $response;

      return $this->id;
    }

    return false;
  }

  /**
  * Delete address
  *
  * @param int $addressId Address id
  * @param int $userId User id
  *
  * @return boolean
  */
  public function delete($addressId, $userId) {
    $response = $this->addressModel->deleteAddress($addressId, $userId);

    return $response;
  }

  /**
  * Create array with table columns as keys and address properties as values
  *
  * @return array
  */
  private function createDataArray() {
    $data = [
      'address_user_id' => $this->userId,
      'house_no' => $this->houseNumber,
      'street' => $this->street,
      'zipcode' => $this->zipcode,
      'address_city_id' => $this->cityId
    ];

    return $data;
  }
}
?>
