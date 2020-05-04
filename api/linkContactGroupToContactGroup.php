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

  foreach (ADD_GROUP_TO_GROUP_REQUEST_FIELDS as $field) {
    if (!in_array($field, $postFields)) {
      $missingFields .= $field . " cannot be empty<br>";
    }
  }

  // Process request if all mandatory fields are submitted
  if (empty($missingFields)) {
    $userToContactGroup = new Usertocontactgroup();
    $contactGroupToContactGroup = new Contactgrouptocontactgroup();
    $parentGroupId = $postData['parent_id'];
    $childGroupId = $postData['child_id'];
    $message = "";
    $isLinked = $contactGroupToContactGroup->isGroupLinked($parentGroupId, $childGroupId);
    $isReverseLink = $contactGroupToContactGroup->isGroupLinked($childGroupId, $parentGroupId);

    // Check if user is trying to link group to itself
    if ($parentGroupId == $childGroupId) {
      $message = "You cannot link contact group to itself";
    } elseif ($isLinked) { // Check if given parent group is already linked to given child group
      $message = "Group is already linked";
    } elseif ($isReverseLink) { // Check if given parent group is already linked as child group to given child group
      $message = "The selected child group is a parent group for this group. Reverse linking of groups is not allowed";
    } else {
      // Get all child groups where selected child group is a parent group
      $childGroups = $contactGroupToContactGroup->fetchChildGroups($childGroupId);

      // Get all parent groups where selected parent group is a child group
      $parentGroups = $contactGroupToContactGroup->fetchParentGroups($parentGroupId);

      // Add selected parent and child groups to parent and child groups array respectively
      $parentGroups[] = $parentGroupId;
      $childGroups[] = $childGroupId;

      // Traverse through all parent and child groups and link all parents to all child groups
      // After checking the conditions for reverse, self and already linking as above
      for ($i = 0; $i < count($parentGroups); $i++) {
        for ($k = 0; $k < count($childGroups); $k++) {
          // Check if parent group is already linked to child group
          $isLinked = $contactGroupToContactGroup->isGroupLinked($parentGroups[$i], $childGroups[$k]);

          // Check if child group is already linked as parent group to selected parent group
          $isReverseLink = $contactGroupToContactGroup->isGroupLinked($childGroups[$k], $parentGroups[$i]);

          // Link groups if not the case of self, reverse or already linking
          if (!$isLinked && !$isReverseLink && $parentGroups[$i] != $childGroups[$k]) {
            $contactGroupToContactGroup->linkGroups($parentGroups[$i], $childGroups[$k]);
          }
        }
      }

      // Get all distinct users in all child groups to remove direct link from all parent groups
      $childContacts = $userToContactGroup->fetchActiveUsersInGroup($childGroups);

      // Delete direct link of all child contacts from all parent groups
      $userToContactGroup->deleteUser($childContacts, $parentGroups);
      
      $message = "Groups linked successfully";
    }

    $response = [
      'status' => SUCCESS_CODE,
      'message' => $message,
      'data' => [
        "parent_id" => $parentGroupId,
        "child_id" => $childGroupId
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
