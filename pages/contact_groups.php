<?php
require 'common/header.html';
require '../classes/User.php';
require '../classes/Contactgroup.php';

$user = new User();
$users = $user->fetchAllUsers();

$contactGroup = new Contactgroup();
$contactGroups = $contactGroup->fetchAllContactGroups();

?>

<div class="jumbotron text-uppercase text-center font-weight-bold font-size-2 font-helvetica-sans-serif">Contact Group Details</div>
<div class="container">
  <div class="row text-center">
    <button class="btn btn-primary" data-toggle="modal" data-target="#contactGroupInfoModal">Add Contact Group</button>
  </div>
  <div class="row mt-5">
    <div class="table-responsive">
      <table class="table table-hover table-bordered" data-smart-display="true" data-pagination="true" data-search="true" id="contactGroupsTable" data-toggle="table">
        <thead>
          <tr>
            <th data-field="num" data-sortable="true">Sl. No</th>
            <th data-field="actions" data-sortable="true">Action</th>
            <th data-field="contact_group_name" data-sortable="true">Contact Group Name</th>
            <th data-field="contact_group_description" data-sortable="true">Contact Group Description</th>
          </tr>
        </thead>
        <tbody id="contactGroupsTableBody">
        </tbody>
      </table>
    </div>
    <div class="col-md-12 text-center">
      <ul class="pagination"></ul>
    </div>
  </div>
</div>

<!-- Contact group info modal with form fields -->
<div id="contactGroupInfoModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Contact Group Details</h4>
      </div>
      <div class="modal-body">
        <p class="alert alert-info text-center"><strong>Please enter contact group details below</strong></p>
        <form class="form-horizontal" id="contactGroupDetailsForm">
          <div class="form-group">
            <label class="control-label col-sm-3" for="contact_group_name">Name:</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" name="contact_group_name" id="contact_group_name" placeholder="Enter contact group name" required />
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-3" for="contact_group_description">Description:</label>
            <div class="col-sm-8">
              <textarea class="form-control" name="contact_group_description" id="contact_group_description" placeholder="Enter contact group description" required></textarea>
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-offset-3 col-sm-8">
              <button type="submit" class="btn btn-success">Submit</button>
              <input type="hidden" id="contact_group_id" name="contact_group_id" value="0" />
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Add user to contact group modal with form fields -->
<div id="addUserToGroupModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add user to contact group</h4>
      </div>
      <div class="modal-body">
        <p class="alert alert-info text-center"><strong>Please select user to add to contact group</strong></p>
        <form class="form-horizontal" id="userToGroupDetailsForm">
          <div class="form-group">
            <label class="control-label col-sm-3" for="user_id">User:</label>
            <div class="col-sm-8">
              <select class="form-control select2" name="user_id" id="user_id" placeholder="Select user" required>
                <option value="">-- Select user --</option>
                <?php foreach ($users as $user): ?>
                  <option value=<?= $user['user_id']; ?>><?= $user['full_name']; ?> (<?= $user['email']; ?>)</option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-offset-3 col-sm-8">
              <button type="submit" class="btn btn-success">Submit</button>
              <input type="hidden" id="user_contact_group_id" name="user_contact_group_id" value="0" />
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Link contact group to contact group modal with form fields -->
<div id="addGroupToGroupModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Link contact group to contact group</h4>
      </div>
      <div class="modal-body">
        <p class="alert alert-info text-center"><strong>Please select contact group to link to contact group</strong></p>
        <form class="form-horizontal" id="groupToGroupDetailsForm">
          <div class="form-group">
            <label class="control-label col-sm-3" for="child_id">Contact group:</label>
            <div class="col-sm-8">
              <select class="form-control select2" name="child_id" id="child_id" placeholder="Select contact group" required>
                <option value="">-- Select contact group --</option>
                <?php foreach ($contactGroups as $contactGroup): ?>
                  <option value=<?= $contactGroup['contact_group_id']; ?>><?= $contactGroup['contact_group_name']; ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-offset-3 col-sm-8">
              <button type="submit" class="btn btn-success">Submit</button>
              <input type="hidden" id="parent_id" name="parent_id" value="0" />
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script src="/assets/javascript/bootstrap-table.min.js"></script>
<script src="/assets/javascript/select-2.min.js"></script>
<script src="/assets/javascript/contact-group.js"></script>
<script src="/assets/javascript/contact-group-to-contact-group.js"></script>
<script src="/assets/javascript/user-to-contact-group.js"></script>

<?php require 'common/footer.html'; ?>
