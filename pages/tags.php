<?php
require 'common/header.html';
require '../classes/Tag.php';
?>

<div class="jumbotron text-uppercase text-center font-weight-bold font-size-2 font-helvetica-sans-serif">Tag Details</div>
<div class="container">
  <div class="row text-center">
    <button class="btn btn-primary" data-toggle="modal" data-target="#tagInfoModal">Add Tag</button>
  </div>
  <div class="row mt-5">
    <div class="table-responsive">
      <table class="table table-hover table-bordered" data-smart-display="true" data-pagination="true" data-search="true" id="tagsTable" data-toggle="table">
        <thead>
          <tr>
            <th data-field="num" data-sortable="true">Sl. No</th>
            <th data-field="actions" data-sortable="true">Action</th>
            <th data-field="tag_name" data-sortable="true">Tag Name</th>
            <th data-field="tag_description" data-sortable="true">Tag Description</th>
          </tr>
        </thead>
        <tbody id="tagsTableBody">
        </tbody>
      </table>
    </div>
    <div class="col-md-12 text-center">
      <ul class="pagination"></ul>
    </div>
  </div>
</div>

<!-- Tag info modal with form fields -->
<div id="tagInfoModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Tag Details</h4>
      </div>
      <div class="modal-body">
        <p class="alert alert-info text-center"><strong>Please enter tag details below</strong></p>
        <form class="form-horizontal" id="tagDetailsForm">
          <div class="form-group">
            <label class="control-label col-sm-3" for="tag_name">Name:</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" name="tag_name" id="tag_name" placeholder="Enter tag name" required />
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-3" for="tag_description">Description:</label>
            <div class="col-sm-8">
              <textarea class="form-control" name="tag_description" id="tag_description" placeholder="Enter tag description" required></textarea>
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-offset-3 col-sm-8">
              <button type="submit" class="btn btn-success">Submit</button>
              <input type="hidden" id="tag_id" name="tag_id" value="0" />
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
<script src="/assets/javascript/tags.js"></script>

<?php require 'common/footer.html'; ?>
