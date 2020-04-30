/**
 * Load data in tags table on page load
 */
$(document).ready(function(){
  getTagTableData();
});

/**
 * Object containing list of fields in tag details form
 */
var fields = {
  tag_id: $('#tag_id'),
  tag_name: $('#tag_name'),
  tag_description: $('#tag_description')
};

/**
 * Get data of all the tags and show in tag table if request is successful
 * Show error message in case of any error
 */
function getTagTableData() {
  var table = $('#tagsTable');
  var tableBody = $('#tagsTableBody');

  // Get request to get data of all users
  $.get("/api/getAllTags.php", (response) => {
    response = JSON.parse(response);

    if (response.status === 200) {
      var rows = [];
      var data = response.data;

      for(var i = 0; i < data.length; i++) {
        // Create edit and delete action icons for actions column in adres book table
        var action = '<a href="javascript:editTag(' + data[i]['tag_id'] + ')" title="Edit">';
        action += '<i class="fa fa-pencil-alt" style="color:#15F541;"></i></a>'
        action += '<a href="javascript:deleteTag(' + data[i]['tag_id'] + ')" title="Delete">'
        action += '<i class="fa fa-trash" style="color:#DE4949;"></i></a>';

        // Push each usr data to rows to be displayed in address book table
        rows.push({
          num: i + 1,
          actions: action,
          tag_name: data[i]['tag_name'],
          tag_description: data[i]['tag_description'],
        });
      }

      table.bootstrapTable('load', rows);
    } else {
      alert(response.message);
    }
  });
}

/**
 * Delete request to delete tag
 *
 * @param {int} tagId - Tag id of tag to be deleted
 */
function deleteTag(tagId) {
  if (confirm("Are you sure you want to delete this tag?")) {
    // Delete request to delete user and address
    $.ajax({
      url: '/api/deleteTag.php?' + $.param({tag_id: tagId}),
      type: 'DELETE',
      success: function(response){
        response = JSON.parse(response);
        alert(response.message);
        getTagTableData();
      }
    });
  }
}

/**
 * Show modal having tag details form with data of selected tag
 *
 * Sends a get request to get data of the selected tag
 * If request is successful, populate tag data in tag details form
 * If there is any error in the request, show corresponding error message
 *
 * @param {int} tagId - Tag id of tag to be edited
 */
function editTag(tagId) {
  // Get request to get data of the tag
  $.get("/api/getTag.php?tag_id=" + tagId, (response) => {
    response = JSON.parse(response);

    if (response.status === 200) {
      data = response.data;
      fields.tag_id.val(data.tag_id);
      fields.tag_name.val(data.tag_name);
      fields.tag_description.val(data.tag_description);
      $('#tagInfoModal').modal('show');
    } else {
      alert(response.message);
    }
  });
}

/**
 * Submit tag details form
 *
 * Checks if tagId field value is 0 or not
 * If value is 0, sends a post request to add new tag
 * Else sends a put request to update tag
 *
 */
$('#tagDetailsForm').submit(function(e){
  e.preventDefault();
  var tagId = fields.tag_id.val();

  data = {
    tag_name: fields.tag_name.val(),
    tag_description: fields.tag_description.val()
  };

  if (tagId != 0) {
    data.tag_id = tagId;

    // Put request to update tag details
    if (confirm("Are you sure you want to edit this tag?")) {
      $.ajax({
        url: '/api/editTag.php?' + $.param(data),
        type: 'PUT',
        success: function(response){
          response = JSON.parse(response);
          alert(response.message);
          getTagTableData();
        }
      });
    }
  } else {
    // Post request to add new tag
    $.post("/api/addTag.php", data, (response) => {
      response = JSON.parse(response);
      alert(response.message);

      if (response.status === 200) {
        clearTagDetailsForm();
        getTagTableData();
      }
    });
  }
});

/**
 * Clear form fields when tag info modal is closed
 *
 */
$('#tagInfoModal').on('hidden.bs.modal', function (e) {
  clearTagDetailsForm();
});

/**
 * Clear form fields of tag details form
 *
 */
function clearTagDetailsForm() {
  $('#tagDetailsForm')
    .find("input,select,textarea")
       .val('')
       .end();
}
