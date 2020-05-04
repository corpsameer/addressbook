<?php
require '../models/contactgrouptocontactgroup_model.php';

class Contactgrouptocontactgroup {
  /**
  * @property int $id Contact group to contact group id
  */
  private $id;

  /**
  * @property int $parentGroupId Contact group id of parent group
  */
  private $parentGroupId;

  /**
  * @property int $childGroupId Contact group id of child group
  */
  private $childGroupId;

  /**
  * @property object $contactGroupToContactGroup Contact group to contact group table model
  */
  private $contactGroupToContactGroup;

  /**
  * Constructor
  *
  * @param int $parentGroupId Contact group id of parent group
  * @param int $linkedGroupId Contact group id of linked group
  */
  public function __construct($parentGroupId = "", $childGroupId = "") {
    $this->parentGroupId = $parentGroupId;
    $this->childGroupId = $childGroupId;
    $this->contactGroupToContactGroup = new Contactgrouptocontactgroupmodel();
  }

  /**
  * Check if parent group is already linked to child group
  *
  * @param int $parentGroupId Contact group id of parent group
  * @param int $childGroupId Contact group id of child group
  *
  * @return boolean
  */
  public function isGroupLinked($parentGroupId, $childGroupId) {
    $response = $this->contactGroupToContactGroup->checkGroupLink($parentGroupId, $childGroupId);

    return $response;
  }

  /**
  * Link parent group to all child groups
  *
  * @param int $parentGroupId Contact group id of parent group
  * @param int $childGroupId Contact group id of child group
  *
  * @return boolean
  */
  public function linkGroups($parentGroupId, $childGroupId) {
    $response = $this->contactGroupToContactGroup->insertGroupLink($parentGroupId, $childGroupId);

    return $response;
  }

  /**
  * Unlink the given group from all its parent groups
  *
  * @param int $childGroupId Contact group id of child group
  *
  * @return boolean
  */
  public function unlinkParentGroups($childGroupId) {
    $response = $this->contactGroupToContactGroup->deleteParentGroups($childGroupId);

    return $response;
  }

  /**
  * Unlink the given group from all its child groups
  *
  * @param int $parentGroupId Contact group id of parent group
  *
  * @return boolean
  */
  public function unlinkChildGroups($parentGroupId) {
    $response = $this->contactGroupToContactGroup->deleteChildGroups($parentGroupId);

    return $response;
  }

  /**
  * Get all parent groups of given group
  *
  * @param int $childGroupId Contact group id of child group
  *
  * @return array
  */
  public function fetchParentGroups($childGroupId) {
    $response = $this->contactGroupToContactGroup->getParentGroups($childGroupId);

    return $response;
  }

  /**
  * Get all child groups of given group
  *
  * @param int $parentGroupId Contact group id of parent group
  *
  * @return array
  */
  public function fetchChildGroups($parentGroupId) {
    $response = $this->contactGroupToContactGroup->getChildGroups($parentGroupId);

    return $response;
  }
}
