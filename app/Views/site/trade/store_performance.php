<style>
/*    .content{
        margin-bottom: 35px;
    }*/
    .content-wrapper, .content {
        margin-top: 0 !important;
        padding-top: 0 !important;
        padding-bottom: 30px;
    }

  footer {
      position: fixed;
      bottom: 0;
      width: 100%;
      background: #f8f9fa;
      padding: 10px;
      text-align: center;
      box-shadow: 0 -2px 5px rgba(0,0,0,0.1);
  }

    .md-center {
        padding: 5px;
        font-family: 'Courier New', Courier, monospace;
        font-size: large;
        background-color: #fdb92a;
        color: #333333;
        border: 1px solid #ffffff;
        border-radius: 10px;
    }

    th {
        color: #fff;
        background-color: #301311 !important;
    }
    .tbl-title-bg{
        color: #fff;
        border-radius: 5px;
        background-color: #143996 !important;
    }
    #previewButton{
      background-color: #143996 !important;
    }
    th:nth-child(1), td:nth-child(1) { width: 10%; } 
    th:nth-child(2), td:nth-child(2) { width: 20%; }
    th:nth-child(3), td:nth-child(3) { width: 20%; }
    th:nth-child(4), td:nth-child(4) { width: 15%; }
    th:nth-child(5), td:nth-child(5) { width: 15%; }
    th:nth-child(6), td:nth-child(6) { width: 15%; }
    th:nth-child(7), td:nth-child(7) { width: 20%; }
</style>

<div class="wrapper">
    <div class="content-wrapper">
        <div class="content">
            <div class="container-fluid py-4">

                <!-- Filters Section -->
            <div class="card p-4 shadow-sm">
                <div class="text-center md-center">
                    <h5 class="mb-3"><i class="fas fa-filter"></i> Filter</h5>
                </div>
                <div class="row">
                    <!-- Left Side: Inputs -->
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="storeName">Month/Start</label>
                                <input type="text" class="form-control" id="storeName" placeholder="Enter area">
                            </div>
                            <div class="col-md-3">
                                <label for="brand">Month/End</label>
                                <input type="text" class="form-control" id="brand" placeholder="Enter brand">
                            </div>
                            <div class="col-md-3">
                                <label for="year">Year</label>
                                <select class="form-control" id="year">
                                    <option value="2025">2025</option>
                                    <option value="2024">2024</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for=""></label>
                                <button class="btn btn-primary btn-sm w-100" id="refreshButton" style="margin-top: 10px;">
                                    <i class="fas fa-sync-alt"></i> Refresh
                                </button>
                            </div>
                        </div>

                    </div>
             
                </div>
            </div>

                <!-- DataTables Section -->
                <div class="card mt-4 p-4 shadow-sm">
                    <div class="tbl-title-bg"><h5>OVERALL BA SALES TARGET</h5></div>

                    <table id="dataTable4" class="table table-bordered table-responsive">
                        <thead>
                            <tr>
                                <th>Rank</th>
                                <th>Store Code</th>
                                <th>Location Description</th>
                                <th>LY Sell Out</th>
                                <th>TY Sell Out</th>
                                <th>% Sell Through</th>
                                <th>Contribution</th>

                            </tr>
                        </thead>
                        <tbody>
                            <tr><td>Alice Brown</td><td>Store D1</td><td>Store D1</td><td>Store D1</td><td>Store D1</td><td>Store D1</td><td>Store D1</td></tr>
                            <tr><td>Alice Brown</td><td>Store D2</td><td>Store D2</td><td>Store D2</td><td>Store D2</td><td>Store D2</td><td>Store D2</td></tr>
                            <tr><td>Alice Brown</td><td>Store D3</td><td>Store D3</td><td>Store D3</td><td>Store D3</td><td>Store D3</td><td>Store D3</td></tr>
                            <tr><td>Alice Brown</td><td>Store D4</td><td>Store D4</td><td>Store D4</td><td>Store D4</td><td>Store D4</td><td>Store D4</td></tr>
                            <tr><td>Alice Brown</td><td>Store D5</td><td>Store D5</td><td>Store D5</td><td>Store D5</td><td>Store D5</td><td>Store D5</td></tr>
                            <tr><td>Alice Brown</td><td>Store D6</td><td>Store D6</td><td>Store D6</td><td>Store D6</td><td>Store D6</td><td>Store D6</td></tr>
                            <tr><td>Alice Brown</td><td>Store D7</td><td>Store D7</td><td>Store D7</td><td>Store D7</td><td>Store D7</td><td>Store D7</td></tr>
                            <tr><td>Alice Brown</td><td>Store D8</td><td>Store D8</td><td>Store D8</td><td>Store D8</td><td>Store D8</td><td>Store D8</td></tr>
                            <tr><td>Alice Brown</td><td>Store D9</td><td>Store D9</td><td>Store D9</td><td>Store D9</td><td>Store D9</td><td>Store D9</td></tr>
                            <tr><td>Alice Brown</td><td>Store D10</td><td>Store D10</td><td>Store D10</td><td>Store D10</td><td>Store D10</td><td>Store D10</td></tr>
                            <tr><td>Alice Brown</td><td>Store D10</td><td>Store D10</td><td>Store D10</td><td>Store D10</td><td>Store D10</td><td>Store D10</td></tr>
                            <tr><td>Alice Brown</td><td>Store D10</td><td>Store D10</td><td>Store D10</td><td>Store D10</td><td>Store D10</td><td>Store D10</td></tr>
                            <tr><td>Alice Brown</td><td>Store D10</td><td>Store D10</td><td>Store D10</td><td>Store D10</td><td>Store D10</td><td>Store D10</td></tr>
                        </tbody>
                    </table>
                </div>


                <!-- Buttons -->
                <div class="d-flex justify-content-end mt-3">
                    <button class="btn btn-info mr-2" id="previewButton"><i class="fas fa-eye"></i> Preview</button>
                    <button class="btn btn-success" id="exportButton"><i class="fas fa-file-export"></i> Export</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- DataTables and Script -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        let tables = ['#dataTable1', '#dataTable2', '#dataTable3', '#dataTable4'];

        tables.forEach(id => {
            $(id).DataTable({
                paging: true,
                searching: false,
                ordering: true,
                info: true,
                lengthChange: false     // Hide "Show Entries" dropdown
            });
        });

        $('#refreshButton').click(function() {
            alert('Refreshing data...');
            tables.forEach(id => $(id).DataTable().ajax.reload(null, false));
        });

        $('#previewButton').click(function() {
            alert('Preview feature coming soon!');
        });

        $('#exportButton').click(function() {
            alert('Export feature coming soon!');
        });
    });
</script>
