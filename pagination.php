<?php include 'header.php';  ?>
<div class="main">
    <h1>Ag-Grid with Server side pagination</h1>
    <div>
        <button onclick="onBtnExport()">Export CSV</button>
    </div>
    <br />
    <div id="myGrid" style="height: 520px; width:600px;" class="ag-theme-alpine"></div>
    
</div>  
<script type="text/javascript" charset="utf-8">
    var gridOptions = {
        columnDefs: [
          { field: 'country' },
          { field: 'state' },
          { field: 'city' }
        ],
        defaultColDef: {
          flex: 1,
          minWidth: 90,
          resizable: true,
          sortable: true,
        },
        rowModelType: 'serverSide',
        serverSideStoreType: 'partial',
        pagination: true,
        paginationPageSize: 10,
        cacheBlockSize: 10,
        animateRows: true,
    };
    
    function onBtnExport() {
        gridOptions.api.exportDataAsCsv();
    }

    // setup the grid after the page has finished loading
    document.addEventListener('DOMContentLoaded', function () {
        var gridDiv = document.querySelector('#myGrid');
        new agGrid.Grid(gridDiv, gridOptions);
        var datasource = new ServerSideDatasource();
        gridOptions.api.setServerSideDatasource(datasource);
    });

    function ServerSideDatasource() {
        return {
            getRows: async function (params) {
                //console.log("params.request", params.request);
                const responseData =  await fetch('db/dbConfig.php?p=pagination', {
                        method: "POST", // *GET, POST, PUT, DELETE, etc.
                        mode: "same-origin", // no-cors, *cors, same-origin
                        cache: 'no-cache', // *default, no-cache, reload, force-cache, only-if-cached
                        credentials: "same-origin", // include, *same-origin, omit
                        headers: {
                            "Content-Type": "application/json",  // sent request
                            "Accept":       "application/json"   // expected data sent back
                        },
                        redirect: 'follow', // manual, *follow, error
                        referrerPolicy: 'no-referrer', // no-referrer, *no-referrer-when-downgrade, origin, origin-when-cross-origin, same-origin, strict-origin, strict-origin-when-cross-origin, unsafe-url
                        body: JSON.stringify(params.request) // body data type must match "Content-Type" header
                    },
                ).then(async function(data){
                    if (data.status === 200) {
                        let finalData = await data.json();
                        return finalData;
                    }
                });
                
                function getLastRowIndex(request, results) {
                    if (!results || results.length === 0) {
                      return null;
                    }

                    var currentLastRow = request.startRow + results.length;

                    return currentLastRow <= request.endRow ? currentLastRow : -1;
                };
                
                var response = {
                    success: true,
                    rows: responseData,
                    lastRow: getLastRowIndex(params.request, responseData),
                };
                //console.log("response => ", response);
                setTimeout(function () {
                    if (response.success) {
                        // call the success callback
                        params.success({
                          rowData: response.rows,
                          rowCount: response.lastRow,
                        });
                    } else {
                        // inform the grid request failed
                        params.fail();
                    }
                }, 200);
            }
        };
    }
</script>
<?php include 'footer.php'; ?>
