<?php
require_once '../config/constants.php';
require_once '../classes/User.php';
require_once '../classes/Address.php';

// Default response for server error
$response = [
  'status' => SERVER_ERROR_CODE,
  'message' => 'Server error! Please try again',
  'data' => []
];

// Get data in $_REQUEST variable
$requestData = $_REQUEST;

// Get all the fields submitted through delete request
$requestFields = array_keys($requestData);

// Check if request data is empty
if (empty($requestData)) {
  $response = [
    'status' => BAD_REQUEST_CODE,
    'message' => 'No data submitted',
    'data' => []
  ];
} else {
  // Get list of mandatory fields not submitted in the request
  $missingFields = "";

  foreach (ADD_USER_REQUEST_FIELDS as $field) {
    if (!in_array($field, $requestFields)) {
      $missingFields .= $field . " cannot be empty";
    }
  }

  foreach (EDIT_USER_REQUEST_FIELDS as $field) {
    if (!in_array($field, $requestFields)) {
      $missingFields .= $field . " cannot be empty<br>";
    }
  }

  // Process request if all mandatory fields are submitted
  if (empty($missingFields)) {
    $userId = $requestData['user_id'];
    $addressId = $requestData['address_id'];
    $address = new Address(
      $userId,
      $requestData['house_no'],
      $requestData['street'],
      $requestData['zipcode'],
      $requestData['city_id']
    );
    $addressUpdated = $address->update($addressId, $userId);

    if ($addressUpdated == $addressId) {
      $user = new User($requestData['first_name'], $requestData['last_name'], $requestData['email']);
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
    // Send response with details of missing fields
    $response = [
      'status' => BAD_REQUEST_CODE,
      'message' => $missingFields,
      'data' => []
    ];
  }
}

echo json_encode($response);
?>
