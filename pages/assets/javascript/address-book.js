/**
 * Load data in address book table on page load
 */
$(document).ready(function(){
  getAdressTableData();
});

/**
 * Object containing list of fields in user details form
 */
var fields = {
  user_id: $('#user_id'),
  address_id: $('#address_id'),
  first_name: $('#first_name'),
  last_name: $('#last_name'),
  email: $('#email'),
  house_no: $('#house_no'),
  street: $('#street'),
  zipcode: $('#zipcode'),
  city_id: $('#city_id')
};

/**
 * Get data of all the users and show in address book table if request is successful
 * Show error message in case of any error
 */
function getAdressTableData() {
  var table = $('#addressBookTable');
  var tableBody = $('#addressBookTableBody');

  // Get request to get data of all users
  $.get("/api/getAllUsers.php", (response) => {
    response = JSON.parse(response);

    if (response.status === 200) {
      var rows = [];
      var data = response.data;

      for(var i = 0; i < data.length; i++) {
        // Create edit and delete action icons for actions column in adres book table
        var action = '<a href="javascript:addTagToUser(' + data[i]['user_id'] + ')" title="Add tag">';
        action += '<i class="fa fa-plus" style="color:#005b96;"></i></a>'
        action += '<a href="javascript:editUser(' + data[i]['user_id'] +', ' + data[i]['address_id'] + ')" title="Edit user">';
        action += '<i class="fa fa-pencil-alt" style="color:#15F541;"></i></a>'
        action += '<a href="javascript:deleteUser(' + data[i]['user_id'] +', ' + data[i]['address_id'] + ')" title="Delete user">'
        action += '<i class="fa fa-trash" style="color:#DE4949;"></i></a>';

        // Get user tags
        var tags = [];
        var userTags = '';
        $.ajax({
          url: "/api/getUserTags.php?user_id=" + data[i]['user_id'],
          type: 'GET',
          async: false,
          success:  (response) => {
            response = JSON.parse(response);

            if (response.status === 200) {
              tags = response.data;
            }
          }
        });

        for (var k = 0; k < tags.length; k++) {
          userTags += '<h5><span class="label label-success">' + tags[k]['tag_name'];
          userTags += '<a href="javascript:deleteUserTag(' + tags[k]['tag_to_user_id'] + ')" title="Delete">'
          userTags += '<i class="fa fa-times" aria-hidden="true" style="color:#DE4949;"></i></a>'
          userTags += '</span></h5>';
        }

        // Push each usr data to rows to be displayed in address book table
        rows.push({
          num: i + 1,
          actions: action,
          tags: userTags,
          full_name: data[i]['full_name'],
          first_name: data[i]['first_name'],
          email: data[i]['email'],
          house_no: data[i]['house_no'],
          street: data[i]['street'],
          zipcode: data[i]['zipcode'],
          city_name: data[i]['city_name'],
        });
      }

      table.bootstrapTable('load', rows);
    } else {
      alert(response.message);
    }
  });
}

/**
 * Delete request to delete user and corresponding address
 *
 * @param {int} userId - User id of user to be deleted
 * @param {int} addressId - Address id to be deleted which is associated with the user
 */
function deleteUser(userId, addressId) {
  if (confirm("Are you sure you want to delete this user?")) {
    // Delete request to delete user and address
    $.ajax({
      url: '/api/deleteUser.php?' + $.param({user_id: userId, address_id : addressId}),
      type: 'DELETE',
      success: function(response){
        response = JSON.parse(response);
        alert(response.message);
        getAdressTableData();
      }
    });
  }
}

/**
 * Delete request to delete tag linked to user
 *
 * @param {int} tagToUserId - Tag to user id of tag to user link
 */
function deleteUserTag(tagToUserId) {
  if (confirm("Are you sure you want to delete this tag from user?")) {
    // Delete request to delete user tag
    $.ajax({
      url: '/api/deleteTagFromUser.php?' + $.param({tag_to_user_id: tagToUserId}),
      type: 'DELETE',
      success: function(response){
        response = JSON.parse(response);
        alert(response.message);
        getAdressTableData();
      }
    });
  }
}

/**
 * Show modal having user details form with data of selected user
 *
 * Sends a get request to get data of the selected user
 * If request is successful, populate user data in user details form
 * If there is any error in the request, show corresponding error message
 *
 * @param {int} userId - User id of user to be edited
 * @param {int} addressId - Address id to be edited which is associated with the user
 */
function editUser(userId, addressId) {
  // Get request to get data of the user
  $.get("/api/getUser.php?user_id=" + userId, (response) => {
    response = JSON.parse(response);

    if (response.status === 200) {
      data = response.data;
      fields.user_id.val(data.user_id);
      fields.address_id.val(data.address_id);
      fields.first_name.val(data.first_name);
      fields.last_name.val(data.last_name);
      fields.email.val(data.email);
      fields.house_no.val(data.house_no);
      fields.street.val(data.street);
      fields.zipcode.val(data.zipcode);
      fields.city_id.val(data.city_id);
      $('#userInfoModal').modal('show');
    } else {
      alert(response.message);
    }
  });
}

/**
 * Show modal having list of tags that can be added to selected user
 *
 */
function addTagToUser(userId) {
  $('#tag_user_id').val(userId);
  $('#addUserTagModal').modal('show');
}

/**
 * submit user details form
 *
 * Checks if userId and addressId fields value is 0 or not
 * If values are 0, sends a post request to add new user and corresponding address
 * Else sends a put request to update user and corresponding address details
 *
 */
$('#userDetailsForm').submit(function(e) {
  e.preventDefault();
  var userId = fields.user_id.val();
  var addressId = fields.address_id.val();

  data = {
    first_name: fields.first_name.val(),
    last_name: fields.last_name.val(),
    email: fields.email.val(),
    house_no: fields.house_no.val(),
    street: fields.street.val(),
    zipcode: fields.zipcode.val(),
    city_id: fields.city_id.val(),
  };

  if (userId != 0 && addressId != 0) {
    data.user_id = userId;
    data.address_id = addressId;

    // Put request to update user details
    if (confirm("Are you sure you want to edit this user?")) {
      $.ajax({
        url: '/api/editUser.php?' + $.param(data),
        type: 'PUT',
        success: function(response){
          response = JSON.parse(response);
          alert(response.message);
          getAdressTableData();
        }
      });
    }
  } else {
    // Post request to add new user
    $.post("/api/addUser.php", data, (response) => {
      response = JSON.parse(response);
      alert(response.message);

      if (response.status === 200) {
        clearUserDetailsForm();
        getAdressTableData();
      }
    });
  }
});

$('#userTagDetailsForm').submit(function(e) {
  e.preventDefault();
  var userId = $('#tag_user_id').val();
  var tagId = $('#tag_id').val();

  if (userId !== 0) {
    data = {
      user_id: userId,
      tag_id: tagId
    };

    // Post request to add new tag to user
    $.post("/api/addTagToUser.php", data, (response) => {
      response = JSON.parse(response);
      alert(response.message);

      if (response.status === 200) {
        clearUserTagDetailsForm();
        getAdressTableData();
      }
    });
  }
});

/**
 * Clear form fields when user info modal is closed
 *
 */
$('#userInfoModal').on('hidden.bs.modal', function (e) {
  clearUserDetailsForm();
});

/**
 * Clear form fields of user details form
 *
 */
function clearUserDetailsForm() {
  $('#userDetailsForm')
    .find("input,select")
       .val('')
       .end();
}

/**
 * Clear form fields when add tag to user modal is closed
 *
 */
$('#addUserTagModal').on('hidden.bs.modal', function (e) {
  clearUserTagDetailsForm();
});

/**
 * Clear form fields of add user tag details form
 *
 */
function clearUserTagDetailsForm() {
  $('#userTagDetailsForm')
    .find("input,select")
       .val('')
       .end();
}
