<?php
require_once '../config/constants.php';
require_once '../classes/Contactgroup.php';

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

  foreach (ADD_CONTACT_GROUP_REQUEST_FIELDS as $field) {
    if (!in_array($field, $requestFields)) {
      $missingFields .= $field . " cannot be empty<br>";
    }
  }

  foreach (EDIT_CONTACT_GROUP_REQUEST_FIELDS as $field) {
    if (!in_array($field, $requestFields)) {
      $missingFields .= $field . " cannot be empty<br>";
    }
  }

  // Process request if all mandatory fields are submitted
  if (empty($missingFields)) {
    $contactGroupId = $requestData['contact_group_id'];
    $contactGroup = new Contactgroup($requestData['contact_group_name'], $requestData['contact_group_description']);
    $contactGroupUpdated = $contactGroup->update($contactGroupId);

    if ($contactGroupUpdated == $contactGroupId) {
      $data = [
        'contact_group_id' => $contactGroupId
      ];
      $response = [
        'status' => SUCCESS_CODE,
        'message' => 'Contact group updated successfully',
        'data' => $data
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
