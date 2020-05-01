<?php
require '../config/constants.php';
require '../classes/Contactgroup.php';

$response = [
  'status' => BAD_REQUEST_CODE,
  'message' => 'No records found',
  'data' => []
];

$contactGroup = new Contactgroup();
$data = $contactGroup->fetchAllContactGroups();

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
