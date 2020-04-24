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

// Get data in POST variable
$postData = $_POST;

// Get all the fields submitted through post request
$postFields = array_keys($postData);

// Check if form data is empty
if (empty($postData)) {
  $response = [
    'status' => BAD_REQUEST_CODE,
    'message' => 'No data submitted',
    'data' => []
  ];
} else {
  // Get list of mandatory fields not submitted in the request
  $missingFields = "";

  foreach (ADD_REQUEST_FIELDS as $field) {
    if (!in_array($field, $postFields)) {
      $missingFields .= $field . " cannot be empty<br>";
    }
  }

  // Process request if all mandatory fields are submitted
  if (empty($missingFields)) {
    $user = new User($postData['first_name'], $postData['last_name'], $postData['email']);
    $userId = $user->add();

    if ($userId) {
      $address = new Address(
        $userId,
        $postData['house_no'],
        $postData['street'],
        $postData['zipcode'],
        $postData['city_id']
      );
      $addressId = $address->add();

      if ($addressId) {
        $data = [
          'user_id' => $userId,
          'address_id' => $addressId
        ];
        $response = [
          'status' => SUCCESS_CODE,
          'message' => 'User added successfully',
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
