$(document).ready(function(){
  getAdressTableData();

  function getAdressTableData() {

  }
  
  $('#addressBookTable').pageTable({pagerSelector:'#paging',showPrevNext:true,hidePageNumbers:false,perPage:10});
});
