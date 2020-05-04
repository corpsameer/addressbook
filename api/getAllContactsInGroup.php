<?php
require_once '../config/constants.php';
require_once '../classes/Contactgrouptocontactgroup.php';
require_once '../classes/Usertocontactgroup.php';
require_once '../classes/User.php';

// Default response for server error
$response = [
  'status' => SERVER_ERROR_CODE,
  'message' => 'Server error! Please try again',
  'data' => []
];

// Get data in request
$getData = $_GET;

// Check if contact group id is sent in get parameters of the request
if (isset($getData['contact_group_id'])) {
  $data = [];
  $user = new User();
  $userToContactGroup = new Usertocontactgroup();
  $contactGroupToContactGroup = new Contactgrouptocontactgroup();

  // Get list of child groups of the given group
  $childGroups = $contactGroupToContactGroup->fetchChildGroups($getData['contact_group_id']);

  // Get list of all users linked directly to the group and are not blocked in this group
  $directUsers = $userToContactGroup->fetchActiveUsersInGroup($getData['contact_group_id']);

  // Get list of all users linked to child groups and are not blocked
  $linkedUsers = $userToContactGroup->fetchActiveUsersInGroup($childGroups);

  // Get details of users directly linked to selected group
  $data['direct_users'] = $user->fetchUser($directUsers);

  // Get details of users linked to child groups
  $data['linked_users'] = $user->fetchUser($linkedUsers);

  $response = [
    'status' => SUCCESS_CODE,
    'message' => 'List of users linked',
    'data' => $data
  ];
} else {
  // If contact group id is not sent in get request
  $response = [
    'status' => BAD_REQUEST_CODE,
    'message' => 'Missing required data to complete request',
    'data' => []
  ];
}

echo json_encode($response);
?>
