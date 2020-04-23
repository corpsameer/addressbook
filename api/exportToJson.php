<?php
require '../classes/User.php';

$user = new User();
$data = $user->fetchAllUsers();
$content = "No data.";

if (!empty($data)) {
  $content = json_encode($data);
}

$fileHandler = fopen("exports/data.json", "w");
fwrite($fileHandler, $content);
fclose($fileHandler);

header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename='.basename('exports/data.json'));
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . filesize('exports/data.json'));
readfile('exports/data.json');
exit;
?>
