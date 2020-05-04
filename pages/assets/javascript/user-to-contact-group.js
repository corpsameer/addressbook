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

/**
 * Show modal having list of users that are liked to group directly or through child group
 *
 * @param {int} contactGroupId - Contact group id
 * @param {string} contactGroupName - Contact group name
 *
 */
function viewUsersInContactGroup(contactGroupId, contactGroupName) {
  var directUsersTable = $('#directUsersTable');
  var linkedUsersTable = $('#linkedUsersTable');
  $('#groupName').html(contactGroupName);

  // Get request to get data of all users linked directly or through child groups
  $.get("/api/getAllUsersInGroup.php?contact_group_id=" + contactGroupId, (response) => {
    response = JSON.parse(response);

    if (response.status === 200) {
      var directRows = [];
      var linkedRows = [];
      var directUsers = response.data['direct_users'];
      var linkedUsers = response.data['linked_users'];

      // Prepare rows to show list of users directly linked to the group
      for(var i = 0; i < directUsers.length; i++) {
        // Create delete user from group icon
        var action = '<a href="javascript:blockUserFromGroup(' + directUsers[i]['user_id'] +', ' + contactGroupId + ')" title="Delete user">';
        action += '<i class="fa fa-trash" style="color:#DE4949;"></i></a>';

        directRows.push({
          num: i + 1,
          actions: action,
          full_name: directUsers[i]['full_name'],
          email: directUsers[i]['email'],
          city: directUsers[i]['city_name'],
        });
      }

      // Prepare rows to show list of users linked to the group through child groups
      for(var i = 0; i < linkedUsers.length; i++) {
        // Create delete user from group icon
        var action = '<a href="javascript:blockUserFromGroup(' + linkedUsers[i]['user_id'] +', ' + contactGroupId + ', \'' + contactGroupName + '\')" title="Delete user">';
        action += '<i class="fa fa-trash" style="color:#DE4949;"></i></a>';

        linkedRows.push({
          num: i + 1,
          actions: action,
          full_name: linkedUsers[i]['full_name'],
          email: linkedUsers[i]['email'],
          city: linkedUsers[i]['city_name'],
        });
      }

      // Load data in table
      directUsersTable.bootstrapTable('load', directRows);
      linkedUsersTable.bootstrapTable('load', linkedRows);

      // Show modal with user data
      $('#viewUsersInGroupModal').modal('show');
    } else {
      alert(response.message);
    }
  });
}

/**
 * Show modal having list of users that are liked to group directly or through child group
 *
 * @param {int} userId - User id
 * @param {int} contactGroupId - Contact group id
 * @param {string} contactGroupName - Contact group name
 *
 */
function blockUserFromGroup(userId, contactGroupId, contactGroupName) {
  if (confirm("Are you sure you want to delete this user from " + contactGroupName + " group?")) {
    data = {
      user_id: userId,
      contact_group_id: contactGroupId
    };

    $.ajax({
      url: '/api/blockUserFromContactGroup.php?' + $.param(data),
      type: 'PUT',
      success: function(response){
        response = JSON.parse(response);
        alert(response.message);
        viewUsersInContactGroup(contactGroupId, contactGroupName);
      }
    });
  }
}
