<?php include 'header.php';  ?>
<div class="main">
    <h1>Ag-Grid with Grouping</h1>
    <div id="myGrid" style="height: 600px; width:600px;" class="ag-theme-alpine"></div>
</div>  
<script type="text/javascript" charset="utf-8">
    // specify the columns
    var columnDefs = [
      { field: "country", rowGroup: true, hide: true },
      { field: "state", rowGroup: true, hide: true },
      { field: "city" }
    ];

    // let the grid know which columns to use
    var gridOptions = {
      columnDefs: columnDefs,
      groupMultiAutoColumn: true,
      animateRows: true,
    };

  // lookup the container we want the Grid to use
  var eGridDiv = document.querySelector('#myGrid');

  // create the grid passing in the div to use together with the columns &amp; data we want to use
  new agGrid.Grid(eGridDiv, gridOptions);
  
  agGrid.simpleHttpRequest({url: 'db/dbConfig.php?p=test'}).then(function(data) {
    gridOptions.api.setRowData(data);
  });

</script>
<?php include 'footer.php'; ?>
