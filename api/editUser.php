<?php
require_once '../config/constants.php';
require_once '../classes/User.php';
require_once '../classes/Address.php';

$response = [
  'status' => SERVER_ERROR_CODE,
  'message' => 'Server error! Please try again',
  'data' => []
];

$postData = $_POST;
$postFields = array_keys($postData);

if (empty($postData)) {
  $response = [
    'status' => BAD_REQUEST_CODE,
    'message' => 'No data submitted',
    'data' => []
  ];
} else {
  $missingFields = [];

  foreach (ADD_POST_FIELDS as $field) {
    if (!in_array($field, $postFields)) {
      $missingFields[$field] = $field . " cannot be empty";
    }
  }

  foreach (EDIT_POST_FIELDS as $field) {
    if (!in_array($field, $postFields)) {
      $missingFields[$field] = $field . " cannot be empty";
    }
  }

  if (empty($missingFields)) {
    $userId = $postData['user_id'];
    $addressId = $postData['address_id'];
    $address = new Address(
      $userId,
      $postData['house_no'],
      $postData['street'],
      $postData['zipcode'],
      $postData['city_id']
    );
    $addressUpdated = $address->update($addressId, $userId);

    if ($addressUpdated == $addressId) {
      $user = new User($postData['first_name'], $postData['last_name'], $postData['email']);
      $userUpdated = $user->update($userId);

      if ($userUpdated == $userId) {
        $data = [
          'user_id' => $userId,
          'address_id' => $addressId
        ];
        $response = [
          'status' => SUCCESS_CODE,
          'message' => 'User updated successfully',
          'data' => $data
        ];
      }
    }
  } else {
    $response = [
      'status' => BAD_REQUEST_CODE,
      'message' => 'Missing Fields',
      'data' => $missingFields
    ];
  }
}

echo json_encode($response);
?>
