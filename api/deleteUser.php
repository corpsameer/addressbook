<?php
require_once '../config/constants.php';
require_once '../classes/User.php';
require_once '../classes/Address.php';
require_once '../classes/Tagtouser.php';
require_once '../classes/Usertocontactgroup.php';

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

  foreach (EDIT_USER_REQUEST_FIELDS as $field) {
    if (!in_array($field, $requestFields)) {
      $missingFields .= $field . " cannot be empty<br>";
    }
  }

  // Process request if all mandatory fields are submitted
  if (empty($missingFields)) {
    $userId = $requestData['user_id'];
    $addressId = $requestData['address_id'];

    $address = new Address();
    $addressDeleted = $address->delete($addressId, $userId);

    if ($addressDeleted) {
      // Delete all tags linked to user
      $tagToUser = new Tagtouser();
      $tagsToUserDeleted = $tagToUser->deleteAllTagsFromUser($userId);

      // Delete all contact groups linked to user
      $userToContactGroup = new Usertocontactgroup();
      $userToContactGroupDeleted = $userToContactGroup->deleteUserInAllGroups($userId);

      // Delete user
      $user = new User();
      $userDeleted = $user->delete($userId);

      if ($tagsToUserDeleted && $userToContactGroupDeleted && $userDeleted) {
        $data = [
          'user_id' => $userId,
          'address_id' => $addressId
        ];
        $response = [
          'status' => SUCCESS_CODE,
          'message' => 'User deleted successfully',
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
