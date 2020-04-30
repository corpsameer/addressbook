<?php
require 'common/header.html';
require '../classes/City.php';

$city = new City();
$cities = $city->fetchAllCities();
?>

  <div class="jumbotron text-uppercase text-center font-weight-bold font-size-2 font-helvetica-sans-serif">Address Book Details</div>
  <div class="container">
    <div class="row text-center hidden-xs">
      <button class="btn btn-primary" data-toggle="modal" data-target="#userInfoModal">Add User</button>
      <a href="/api/exportToJson.php" class="btn btn-primary">Export to JSON</a>
      <a href="/api/exportToXml.php" class="btn btn-primary">Export to XML</a>
      <a href="/api/exportToCsv.php" class="btn btn-primary">Export to CSV</a>
    </div>
    <div class="row text-center hidden-sm hidden-md hidden-lg">
      <button class="btn btn-primary col-xs-offset-2 col-xs-4" data-toggle="modal" data-target="#userInfoModal">Add User</button>
      <a href="/api/exportToJson.php" class="btn btn-primary col-xs-offset-1 col-xs-4">Export to JSON</a>
      <a href="/api/exportToXml.php" class="btn btn-primary col-xs-offset-2 col-xs-4 mt-5">Export to XML</a>
      <a href="/api/exportToCsv.php" class="btn btn-primary col-xs-offset-1 col-xs-4 mt-5">Export to CSV</a>
    </div>
    <div class="row mt-5">
      <div class="table-responsive">
        <table class="table table-hover table-bordered" data-smart-display="true" data-pagination="true" data-search="true" id="addressBookTable" data-toggle="table">
          <thead>
            <tr>
              <th data-field="num" data-sortable="true">Sl. No</th>
              <th data-field="actions" data-sortable="true">Action</th>
              <th data-field="full_name" data-sortable="true">Name</th>
              <th data-field="first_name" data-sortable="true">First Name</th>
              <th data-field="email" data-sortable="true">Email</th>
              <th data-field="house_no" data-sortable="true">House No</th>
              <th data-field="street" data-sortable="true">Street</th>
              <th data-field="zipcode" data-sortable="true">Zip Code</th>
              <th data-field="city_name" data-sortable="true">City</th>
            </tr>
          </thead>
          <tbody id="addressBookTableBody">
          </tbody>
        </table>
      </div>
      <div class="col-md-12 text-center">
        <ul class="pagination pagination-lg pager" id="paging"></ul>
      </div>
    </div>
  </div>

  <!-- User info modal with form fields -->
  <div id="userInfoModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">User Details</h4>
        </div>
        <div class="modal-body">
          <p class="alert alert-info text-center"><strong>Please enter user details below</strong></p>
          <form class="form-horizontal" id="userDetailsForm">
            <div class="form-group">
              <label class="control-label col-sm-3" for="first_name">First name:</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" name="first_name" id="first_name" placeholder="Enter first name" required />
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-3" for="last_name">Last name:</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Enter last name" required />
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-3" for="email">Email:</label>
              <div class="col-sm-8">
                <input type="email" class="form-control" name="email" id="email" placeholder="Enter email" required />
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-3" for="house_no">House number:</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" name="house_no" id="house_no" placeholder="Enter house number" required />
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-3" for="street">Street:</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" name="street" id="street" placeholder="Enter street" required />
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-3" for="zipcode">Zipcode:</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" name="zipcode" id="zipcode" placeholder="Enter zipcode" required />
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-3" for="city_id">City:</label>
              <div class="col-sm-8">
                <select class="form-control" name="city_id" id="city_id" placeholder="Select city" required>
                  <option value="">-- Select city --</option>
                  <?php foreach ($cities as $city): ?>
                    <option value=<?= $city['city_id']; ?>><?= $city['city_name']; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-offset-3 col-sm-8">
                <button type="submit" class="btn btn-success">Submit</button>
                <input type="hidden" id="user_id" name="user_id" value="0" />
                <input type="hidden" id="address_id" name="address_id" value="0" />
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
  <script src="/assets/javascript/address-book.js"></script>

<?php require 'common/footer.html'; ?>
