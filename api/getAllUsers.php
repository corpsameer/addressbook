<?php
require '../config/constants.php';
require '../classes/User.php';

$response = [
  'status' => BAD_REQUEST_CODE,
  'message' => 'No records found',
  'data' => []
];

$user = new User();
$data = $user->fetchAllUsers();

if (!empty($data)) {
  $response = [
    'status' => SUCCESS_CODE,
    'message' => 'Records found',
    'data' => $data
  ];
}

echo json_encode($response);
?>
