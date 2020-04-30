<?php
require '../config/constants.php';
require '../classes/Tag.php';

$response = [
  'status' => BAD_REQUEST_CODE,
  'message' => 'No records found',
  'data' => []
];

$getData = $_GET;

if (isset($getData['tag_id'])) {
  $tag = new Tag();
  $data = $tag->fetchTag($getData['tag_id']);

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
