<?php
require 'common/header.html';
require 'common/footer.html';
?>

<body>
  <div class="jumbotron text-uppercase text-center font-weight-bold font-size-2 font-helvetica-sans-serif">Address Book Details</div>
  <div class="container">
    <div class="row text-center">
      <a class="btn btn-primary btn-xl">Add User</a>
      <a class="btn btn-primary btn-xl">Export to JSON</a>
      <a class="btn btn-primary btn-xl">Export to XML</a>
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
