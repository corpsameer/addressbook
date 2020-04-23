<?php
require '../classes/User.php';

$user = new User();
$data = $user->fetchAllUsers();

if (!empty($data)) {
  $fileHandler = fopen("exports/data.csv", "w");
  $header = [
    'User id',
    'Full name',
    'First name',
    'Last name',
    'Email',
    'Created at',
    'Address id',
    'Address user id',
    'House no',
    'Street',
    'Zipcode',
    'Address city id',
    'City id',
    'City name'
  ];
  fputcsv($fileHandler, $header);

  foreach ($data as $line) {
    fputcsv($fileHandler, $line);
  }

  fclose($fileHandler);
}

header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename='.basename('exports/data.csv'));
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . filesize('exports/data.csv'));
readfile('exports/data.csv');
exit;
?>
