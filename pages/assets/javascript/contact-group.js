/**
 * Apply select2 to dropdowns with search functionality
 */
$('.select2').select2();

/**
 * Load data in contact group table on page load
 */
$(document).ready(function(){
  getContactGroupTableData();
});

/**
 * Object containing list of fields in contact group details form
 */
var fields = {
  contact_group_id: $('#contact_group_id'),
  contact_group_name: $('#contact_group_name'),
  contact_group_description: $('#contact_group_description')
};

/**
 * Get data of all the contact groups and show in contact group table if request is successful
 * Show error message in case of any error
 */
function getContactGroupTableData() {
  var table = $('#contactGroupsTable');
  var tableBody = $('#contactGroupsTableBody');

  // Get request to get data of all users
  $.get("/api/getAllContactGroups.php", (response) => {
    response = JSON.parse(response);

    if (response.status === 200) {
      var rows = [];
      var data = response.data;

      for(var i = 0; i < data.length; i++) {
        // Create edit and delete action icons for actions column in contact group table
        var action = '<a href="javascript:addUserToContactGroup(' + data[i]['contact_group_id'] + ')" title="Add user">';
        action += '<i class="fa fa-plus" style="color:#005b96;"></i></a>';
        action += '<a href="javascript:linkGroupToContactGroup(' + data[i]['contact_group_id'] + ')" title="Link group">';
        action += '<i class="fa fa-link" style="color:#585858;"></i></a>';
        action += '<a href="javascript:editContactGroup(' + data[i]['contact_group_id'] + ')" title="Edit contact group">';
        action += '<i class="fa fa-pencil-alt" style="color:#15F541;"></i></a>';
        action += '<a href="javascript:deleteContactGroup(' + data[i]['contact_group_id'] + ')" title="Delete contact group">'
        action += '<i class="fa fa-trash" style="color:#DE4949;"></i></a>';

        // Push each usr data to rows to be displayed in address book table
        rows.push({
          num: i + 1,
          actions: action,
          contact_group_name: data[i]['contact_group_name'],
          contact_group_description: data[i]['contact_group_description'],
        });
      }

      table.bootstrapTable('load', rows);
    } else {
      alert(response.message);
    }
  });
}
/**
 * Delete request to delete contact group
 *
 * @param {int} contactGroupId - Contact group id of contact group to be deleted
 */
function deleteContactGroup(contactGroupId) {
  if (confirm("Are you sure you want to delete this contact group?")) {
    // Delete request to delete user and address
    $.ajax({
      url: '/api/deleteContactGroup.php?' + $.param({contact_group_id: contactGroupId}),
      type: 'DELETE',
      success: function(response){
        response = JSON.parse(response);
        alert(response.message);
        getContactGroupTableData();
      }
    });
  }
}

/**
 * Show modal having contact group details form with data of selected contact group
 *
 * Sends a get request to get data of the selected contact group
 * If request is successful, populate contact group data in contact group details form
 * If there is any error in the request, show corresponding error message
 *
 * @param {int} contactGroupId - Contact group id of contact group to be edited
 */
function editContactGroup(contactGroupId) {
  // Get request to get data of the contact group
  $.get("/api/getContactGroup.php?contact_group_id=" + contactGroupId, (response) => {
    response = JSON.parse(response);

    if (response.status === 200) {
      data = response.data;
      fields.contact_group_id.val(data.contact_group_id);
      fields.contact_group_name.val(data.contact_group_name);
      fields.contact_group_description.val(data.contact_group_description);
      $('#contactGroupInfoModal').modal('show');
    } else {
      alert(response.message);
    }
  });
}

/**
 * Submit contact group details form
 *
 * Checks if contactGroupId field value is 0 or not
 * If value is 0, sends a post request to add new contact group
 * Else sends a put request to update contact group
 *
 */
$('#contactGroupDetailsForm').submit(function(e){
  e.preventDefault();
  var contactGroupId = fields.contact_group_id.val();

  data = {
    contact_group_name: fields.contact_group_name.val(),
    contact_group_description: fields.contact_group_description.val()
  };

  if (contactGroupId != 0) {
    data.contact_group_id = contactGroupId;

    // Put request to update contact group details
    if (confirm("Are you sure you want to edit this contact group?")) {
      $.ajax({
        url: '/api/editContactGroup.php?' + $.param(data),
        type: 'PUT',
        success: function(response){
          response = JSON.parse(response);
          alert(response.message);
          getContactGroupTableData();
        }
      });
    }
  } else {
    // Post request to add new contact group
    $.post("/api/addContactGroup.php", data, (response) => {
      response = JSON.parse(response);
      alert(response.message);

      if (response.status === 200) {
        clearContactGroupDetailsForm();
        getContactGroupTableData();
      }
    });
  }
});

/**
 * Clear form fields when tag info modal is closed
 *
 */
$('#contactGroupInfoModal').on('hidden.bs.modal', function (e) {
  clearContactGroupDetailsForm();
});

/**
 * Clear form fields of tag details form
 *
 */
function clearContactGroupDetailsForm() {
  $('#contactGroupDetailsForm')
    .find("input,select,textarea")
       .val('')
       .end();
}
