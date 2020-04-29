<?php
require '../config/constants.php';
require '../classes/Tagtouser.php';

$response = [
  'status' => BAD_REQUEST_CODE,
  'message' => 'No records found',
  'data' => []
];

$tagToUser = new Tagtouser();
$data = $tagToUser->fetchTagsForFilter();

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

echo json_encode($response);
?>
