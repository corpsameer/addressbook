/**
 * Show modal having list of groups that can be added to selected contact group
 *
 */
function linkGroupToContactGroup(contactGroupId) {
  $('#parent_id').val(contactGroupId);
  $('#addGroupToGroupModal').modal('show');
}

/**
 * Submit contact group to contact group details form
 *
 * Checks if contactGroupId field value is 0 or not
 * If values is not 0, sends a post request to link new group to the contact group
 *
 */
$('#groupToGroupDetailsForm').submit(function(e) {
  e.preventDefault();
  var parentId = $('#parent_id').val();
  var childId = $('#child_id').val();

  if (parentId !== 0) {
    data = {
      parent_id: parentId,
      child_id: childId
    };

    // Post request to link new group to contact group
    $.post("/api/linkContactGroupToContactGroup.php", data, (response) => {
      response = JSON.parse(response);
      alert(response.message);
    });
  }
});

/**
 * Clear form fields when link group to contact group modal is closed
 *
 */
$('#addGroupToGroupModal').on('hidden.bs.modal', function (e) {
  $('#child_id').val('').trigger('change');
});
