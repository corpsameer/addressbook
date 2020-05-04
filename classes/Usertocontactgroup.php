<?php
require '../models/usertocontactgroup_model.php';

class Usertocontactgroup {
  /**
  * @property int $id User to contact group id
  */
  private $id;

  /**
  * @property int $userId User id
  */
  private $userId;

  /**
  * @property int $contactGroupId Contact group id
  */
  private $contactGroupId;

  /**
  * @property int $isBlocked Status of user in the group
  */
  private $isBlocked;

  /**
  * @property object $userToContactGroup User to contact group table model
  */
  private $userToContactGroup;

  /**
  * Constructor
  *
  * @param int $userId User id
  * @param int $contactGroupId Contact group id
  */
  public function __construct($userId = "", $contactGroupId = "") {
    $this->userId = $userId;
    $this->contactGroupId = $contactGroupId;
    $this->isBlocked = 0;
    $this->userToContactGroup = new Usertocontactgroupmodel();
  }

  /**
  * Check if given user is linked to given contact group
  *
  * @param int $userId User id
  * @param int|array $contactGroupId Contact group id
  *
  * @return boolean
  */
  public function checkLink($userId, $contactGroupId) {
    $response = $this->userToContactGroup->isUserLinkedToGroup($userId, $contactGroupId);

    return $response;
  }

  /**
  * Link user to contact group
  *
  * @param int $userId User id
  * @param int $contactGroupId Contact group id
  *
  * @return boolean
  */
  public function linkUserToGroup($userId, $contactGroupId) {
    $response = $this->userToContactGroup->insertUserToGroupLink($userId, $contactGroupId);

    return $response;
  }

  /**
  * Check if given user is blocked from given contact group
  *
  * @param int $userId User id
  * @param int $contactGroupId Contact group id
  *
  * @return boolean
  */
  public function checkBlocked($userId, $contactGroupId) {
    $response = $this->userToContactGroup->isUserBlockedFromGroup($userId, $contactGroupId);

    return $response;
  }

  /**
  * Block given user from given contact group
  *
  * @param int $userId User id
  * @param int $contactGroupId Contact group id
  *
  * @return boolean
  */
  public function blockUser($userId, $contactGroupId) {
    $response = $this->userToContactGroup->blockUserFromGroup($userId, $contactGroupId);

    return $response;
  }

  /**
  * Unblock given user from given contact group
  *
  * @param int $userId User id
  * @param int $contactGroupId Contact group id
  *
  * @return boolean
  */
  public function unblockUser($userId, $contactGroupId) {
    $response = $this->userToContactGroup->unblockUserFromGroup($userId, $contactGroupId);

    return $response;
  }

  /**
  * Delete given user from given contact group
  *
  * @param int|array $userId User id
  * @param int|array $contactGroupId Contact group id
  *
  * @return boolean
  */
  public function deleteUser($userId, $contactGroupId) {
    $response = $this->userToContactGroup->deleteUserFromGroup($userId, $contactGroupId);

    return $response;
  }

  /**
  * Delete all users from given contact group
  *
  * @param int $contactGroupId Contact group id
  *
  * @return boolean
  */
  public function deleteAllUsersInGroup($contactGroupId) {
    $response = $this->userToContactGroup->deleteAllUsersFromGroup($contactGroupId);

    return $response;
  }

  /**
  * Delete given user from all contact group
  *
  * @param int $userId User id
  *
  * @return boolean
  */
  public function deleteUserInAllGroups($userId) {
    $response = $this->userToContactGroup->deleteUserFromAllGroups($userId);

    return $response;
  }

  /**
  * Get all active users in given group
  *
  * @param int|array $contactGroupId Contact group id
  * @param string|array $blockedUsers Users that are blocked and are not to be selected
  *
  * @return array
  */
  public function fetchActiveUsersInGroup($contactGroupId, $blockedUsers = "") {
    $response = $this->userToContactGroup->getActiveUsersInGroup($contactGroupId, $blockedUsers);

    return $response;
  }

  /**
  * Get all blocked users in given group
  *
  * @param int|array $contactGroupId Contact group id
  *
  * @return array
  */
  public function fetchBlockedUsersInGroup($contactGroupId) {
    $response = $this->userToContactGroup->getBlockedUsersInGroup($contactGroupId);

    return $response;
  }
}
