<?php
require '../config/constants.php';
require '../classes/Contactgroup.php';

$response = [
  'status' => BAD_REQUEST_CODE,
  'message' => 'No records found',
  'data' => []
];

$getData = $_GET;

if (isset($getData['contact_group_id'])) {
  $contactGroup = new Contactgroup();
  $data = $contactGroup->fetchContactGroup($getData['contact_group_id']);

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
