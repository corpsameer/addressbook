<?php
require 'common/header.html';
require '../classes/City.php';

$city = new City();
$cities = $city->fetchAllCities();
?>

<body>
  <div class="jumbotron text-uppercase text-center font-weight-bold font-size-2 font-helvetica-sans-serif">Address Book Details</div>
  <div class="container">
    <div class="row text-center">
      <button class="btn btn-primary">Add User</button>
      <a href="/api/exportToJson.php" class="btn btn-primary">Export to JSON</a>
      <a href="/api/exportToXml.php" class="btn btn-primary">Export to XML</a>
      <a href="/api/exportToCsv.php" class="btn btn-primary">Export to CSV</a>
    </div>
    <div class="row mt-5">
      <div class="table-responsive">
        <table class="table table-hover table-bordered">
          <thead>
            <tr>
              <th>Row id</th>
              <th>Action</th>
              <th>Name</th>
              <th>First Name</th>
              <th>Email</th>
              <th>House No</th>
              <th>Street</th>
              <th>Zip Code</th>
              <th>City</th>
            </tr>
          </thead>
          <tbody id="addressBookTable">
          </tbody>
        </table>
      </div>
      <div class="col-md-12 text-center">
        <ul class="pagination pagination-lg pager" id="paging"></ul>
      </div>
    </div>
  </div>

  <script src="/assets/javascript/address-book.js"></script>
  <script src="/assets/javascript/pagination.js"></script>
</body>

<?php require 'common/footer.html'; ?>
