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
    $response = [
      'status' => BAD_REQUEST_CODE,
      'message' => 'Missing Fields',
      'data' => $missingFields
    ];
  }
}

echo json_encode($response);
?>
