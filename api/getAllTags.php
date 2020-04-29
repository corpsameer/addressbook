<?php
require '../config/constants.php';
require '../classes/Tag.php';

$response = [
  'status' => BAD_REQUEST_CODE,
  'message' => 'No records found',
  'data' => []
];

$tag = new Tag();
$data = $tag->fetchAllTags();

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
