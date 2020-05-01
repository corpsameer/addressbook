<?php
require_once '../config/constants.php';
require_once '../classes/Contactgroup.php';

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

  foreach (ADD_CONTACT_GROUP_REQUEST_FIELDS as $field) {
    if (!in_array($field, $postFields)) {
      $missingFields .= $field . " cannot be empty<br>";
    }
  }

  // Process request if all mandatory fields are submitted
  if (empty($missingFields)) {
    $contactGroup = new Contactgroup($postData['contact_group_name'], $postData['contact_group_description']);
    $contactGroupId = $contactGroup->add();

    if ($contactGroupId) {
      $data = [
        'contact_group_id' => $contactGroupId
      ];
      $response = [
        'status' => SUCCESS_CODE,
        'message' => 'Contact group added successfully',
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
