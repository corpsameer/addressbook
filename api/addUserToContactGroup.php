<?php
require_once '../config/constants.php';
require_once '../classes/Contactgrouptocontactgroup.php';
require_once '../classes/Usertocontactgroup.php';

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

  foreach (ADD_USER_TO_GROUP_REQUEST_FIELDS as $field) {
    if (!in_array($field, $postFields)) {
      $missingFields .= $field . " cannot be empty<br>";
    }
  }

  // Process request if all mandatory fields are submitted
  if (empty($missingFields)) {
    $userToContactGroup = new Usertocontactgroup();
    $contactGroupToContactGroup = new Contactgrouptocontactgroup();
    $userId = $postData['user_id'];
    $contactGroupId = $postData['contact_group_id'];
    $message = "User is already linked to group";

    // Check if user is already directly linked to the group
    $isLinked = $userToContactGroup->checkLink($userId, $contactGroupId);
    $status = false;

    // If user is already directly linked to the group, check whether user is blocked in the group
    if ($isLinked) {
      $status = $userToContactGroup->checkBlocked($userId, $contactGroupId);
    }

    // Get all child groups of the contact group to check if user already exists in any of the child groups
    $childGroups = $contactGroupToContactGroup->fetchChildGroups($contactGroupId);

    // Check if user is already linked to any of the child groups
    $isLinkedToChildGroup = $userToContactGroup->checkLink($userId, $childGroups);

    // If user exists in any of the child groups, do not link user to the given group
    if ($isLinkedToChildGroup) {
      // If user is already linked to given group, delete the link so user is linked to given group through the child group
      if ($isLinked) {
        $userToContactGroup->deleteUser($userId, $contactGroupId);
      }

      $message = "User is already linked to group through child groups";
    } elseif ($isLinked && $status) {
      // If user is already linked to group and is blocked, unblock user
      $userToContactGroup->unblockUser($userId, $contactGroupId);
      $message = "User is linked to group successfully";
    } elseif (!$isLinked) {
      // If user is not linked directly or through child groups, link user to group directly
      $userToContactGroup->linkUserToGroup($userId, $contactGroupId);
      $message = "User is linked to group successfully";
    }

    // Get list of all parent groups of the given contact group
    $parentGroups = $contactGroupToContactGroup->fetchParentGroups($contactGroupId);

    // Delete direct link of user with all parent groups of the given contact group
    $userToContactGroup->deleteUser($userId, $parentGroups);

    $response = [
      'status' => SUCCESS_CODE,
      'message' => $message,
      'data' => [
        "user_id" => $userId,
        "contact_group_id" => $contactGroupId,
      ]
    ];
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
