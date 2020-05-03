<?php
// Response Codes
defined('BAD_REQUEST_CODE')            OR define('BAD_REQUEST_CODE', 400);
defined('PAGE_NOT_FOUND_CODE')         OR define('PAGE_NOT_FOUND_CODE', 404);
defined('SUCCESS_CODE')                OR define('SUCCESS_CODE', 200);
defined('SERVER_ERROR_CODE')           OR define('SERVER_ERROR_CODE', 500);

// Blocked user from groups status
defined('STATUS_BLOCKED')              OR define('STATUS_BLOCKED', 1);
defined('STATUS_NOT_BLOCKED')          OR define('STATUS_NOT_BLOCKED', 0);

// Add request fields array
defined('ADD_USER_REQUEST_FIELDS')
OR
define('ADD_USER_REQUEST_FIELDS', [
  'first_name',
  'last_name',
  'email',
  'house_no',
  'street',
  'zipcode',
  'city_id'
]);

// Edit/Delete request fields array
defined('EDIT_USER_REQUEST_FIELDS')
OR
define('EDIT_USER_REQUEST_FIELDS', [
  'user_id',
  'address_id'
]);

// Add tag request fields array
defined('ADD_TAG_REQUEST_FIELDS')
OR
define('ADD_TAG_REQUEST_FIELDS', [
  'tag_name',
  'tag_description'
]);

// Edit/Delete tag request fields array
defined('EDIT_TAG_REQUEST_FIELDS')
OR
define('EDIT_TAG_REQUEST_FIELDS', [
  'tag_id'
]);

// Add tag to user request fields array
defined('ADD_TAG_TO_USER_REQUEST_FIELDS')
OR
define('ADD_TAG_TO_USER_REQUEST_FIELDS', [
  'tag_id',
  'user_id'
]);

// Edit/Delete tag to user request fields array
defined('EDIT_TAG_TO_USER_REQUEST_FIELDS')
OR
define('EDIT_TAG_TO_USER_REQUEST_FIELDS', [
  'tag_to_user_id'
]);

// Add contact group request fields array
defined('ADD_CONTACT_GROUP_REQUEST_FIELDS')
OR
define('ADD_CONTACT_GROUP_REQUEST_FIELDS', [
  'contact_group_name',
  'contact_group_description'
]);

// Edit contact group request fields array
defined('EDIT_CONTACT_GROUP_REQUEST_FIELDS')
OR
define('EDIT_CONTACT_GROUP_REQUEST_FIELDS', [
  'contact_group_id'
]);
?>
