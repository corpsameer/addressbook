/**
 * Show modal having list of users that can be added to selected contact group
 *
 */
function addUserToContactGroup(contactGroupId) {
  $('#user_contact_group_id').val(contactGroupId);
  $('#addUserToGroupModal').modal('show');
}

/**
 * Submit user to contact group details form
 *
 * Checks if contactGroupId field value is 0 or not
 * If values is not 0, sends a post request to add new user to the group
 *
 */
$('#userToGroupDetailsForm').submit(function(e) {
  e.preventDefault();
  var contactGroupId = $('#user_contact_group_id').val();
  var userId = $('#user_id').val();

  if (contactGroupId !== 0) {
    data = {
      contact_group_id: contactGroupId,
      user_id: userId
    };

    // Post request to add new user to contact group
    $.post("/api/addUserToContactGroup.php", data, (response) => {
      response = JSON.parse(response);
      alert(response.message);
    });
  }
});

/**
 * Clear form fields when add user to contact group modal is closed
 *
 */
$('#addUserToGroupModal').on('hidden.bs.modal', function (e) {
  $('#user_id').val('').trigger('change');
});
