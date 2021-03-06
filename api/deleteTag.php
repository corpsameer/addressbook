<?php
require_once '../config/constants.php';
require_once '../classes/Tag.php';
require_once '../classes/Tagtouser.php';

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

  foreach (EDIT_TAG_REQUEST_FIELDS as $field) {
    if (!in_array($field, $requestFields)) {
      $missingFields .= $field . " cannot be empty<br>";
    }
  }

  // Process request if all mandatory fields are submitted
  if (empty($missingFields)) {
    $tagId = $requestData['tag_id'];
    $tagToUser = new Tagtouser();
    $tagToUserDeleted = $tagToUser->deleteTagFromUsers($tagId);

    if ($tagToUserDeleted) {
      $tag = new Tag();
      $tagDeleted = $tag->delete($tagId);

      if ($tagDeleted) {
        $data = [
          'tag_id' => $tagId
        ];
        $response = [
          'status' => SUCCESS_CODE,
          'message' => 'Tag deleted successfully',
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
