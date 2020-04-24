<?php
require '../config/constants.php';
require '../classes/User.php';

$response = [
  'status' => BAD_REQUEST_CODE,
  'message' => 'No records found',
  'data' => []
];

$getData = $_GET;

if (isset($getData['user_id'])) {
  $user = new User();
  $data = $user->fetchUser($getData['user_id']);

  if (!empty($data)) {
    $response = [
      'status' => SUCCESS_CODE,
      'message' => 'Record found',
      'data' => $data
    ];
  }
} else {
  $response = [
    'status' => BAD_REQUEST_CODE,
    'message' => 'Missing required data to complete request',
    'data' => []
  ];
}

echo json_encode($response);
?>
