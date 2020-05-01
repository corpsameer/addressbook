<?php
require '../config/constants.php';
require '../classes/User.php';

$response = [
  'status' => BAD_REQUEST_CODE,
  'message' => 'No records found',
  'data' => []
];
$getData = $_GET;

if (isset($getData['tag_id'])) {
  $user = new User();
  $data = $user->fetchAllUsers($getData['tag_id']);

  if (!empty($data)) {
    $response = [
      'status' => SUCCESS_CODE,
      'message' => 'Records found',
      'data' => $data
    ];
  } else {
    $response = [
      'status' => SUCCESS_CODE,
      'message' => 'No Records found',
      'data' => []
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
