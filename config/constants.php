<?php
// Response Codes
defined('BAD_REQUEST_CODE')            OR define('BAD_REQUEST_CODE', 400);
defined('PAGE_NOT_FOUND_CODE')         OR define('PAGE_NOT_FOUND_CODE', 404);
defined('SUCCESS_CODE')                OR define('SUCCESS_CODE', 200);
defined('SERVER_ERROR_CODE')           OR define('SERVER_ERROR_CODE', 500);

// Add request fields array
defined('ADD_REQUEST_FIELDS')
OR
define('ADD_REQUEST_FIELDS', [
  'first_name',
  'last_name',
  'email',
  'house_no',
  'street',
  'zipcode',
  'city_id'
]);

// Edit/Delete request fields array
defined('EDIT_REQUEST_FIELDS')
OR
define('EDIT_REQUEST_FIELDS', [
  'user_id',
  'address_id'
]);
?>
