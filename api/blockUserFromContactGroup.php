<?php
require_once '../config/constants.php';
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

  foreach (ADD_USER_TO_GROUP_REQUEST_FIELDS as $field) {
    if (!in_array($field, $requestFields)) {
      $missingFields .= $field . " cannot be empty<br>";
    }
  }

  // Process request if all mandatory fields are submitted
  if (empty($missingFields)) {
    $userToContactGroup = new Usertocontactgroup();

    // Instead of deleting user from the group, we block user from group
    // This will enable us to not show user in this group even if it is present in any child groups
    $isBlocked = $userToContactGroup->blockUser($requestData['user_id'], $requestData['contact_group_id']);

    if ($isBlocked) {
      $response = [
        'status' => SUCCESS_CODE,
        'message' => "User deleted from group",
        'data' => []
      ];
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
