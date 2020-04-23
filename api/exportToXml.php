<?php
require '../classes/User.php';

$user = new User();
$data = $user->fetchAllUsers();

if (!empty($data)) {
  $dom = new DOMDocument();
  $dom->encoding = 'utf-8';
  $dom->xmlVersion = '1.0';
  $dom->formatOutput = true;
  $root = $dom->createElement('Users');

  foreach ($data as $values) {
    $userNode = $dom->createElement('User');
    $attributeUserId = new DOMAttr('user_id', $values['user_id']);
		$userNode->setAttributeNode($attributeUserId);

    foreach ($values as $field => $value) {
      $childNode = $dom->createElement($field, $value);
  		$userNode->appendChild($childNode);
    }

    $root->appendChild($userNode);
    $dom->appendChild($root);
  }

  $dom->save("exports/data.xml");
}

header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename='.basename('exports/data.xml'));
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . filesize('exports/data.xml'));
readfile('exports/data.xml');
exit;
?>
