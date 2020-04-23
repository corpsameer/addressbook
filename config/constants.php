<?php
// Response Codes
defined('BAD_REQUEST_CODE')            OR define('BAD_REQUEST_CODE', 400);
defined('PAGE_NOT_FOUND_CODE')         OR define('PAGE_NOT_FOUND_CODE', 404);
defined('SUCCESS_CODE')                OR define('SUCCESS_CODE', 200);
defined('SERVER_ERROR_CODE')           OR define('SERVER_ERROR_CODE', 500);

// Add post fields array
defined('ADD_POST_FIELDS')
OR
define('ADD_POST_FIELDS', [
  'first_name',
  'last_name',
  'email',
  'house_no',
  'street',
  'zipcode',
  'city_id'
]);

// Edit post fields array
defined('EDIT_POST_FIELDS')
OR
define('EDIT_POST_FIELDS', [
  'user_id',
  'address_id'
]);
?>
