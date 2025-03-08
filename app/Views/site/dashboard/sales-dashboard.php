<style>
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
</style>

<div class="wrapper">
    <div class="content-wrapper">
        <div class="content">
            <div class="container py-4">

                <!-- Filters Section -->
                <div class="card p-4 shadow-sm">
                    <div class="md-center"><h5 class="mb-3"><i class="fas fa-filter"></i> Filter</h5></div>
                    <div class="row">
                        <!-- Left Side: Inputs -->
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="brandAmbassador">Brand Ambassador</label>
                                    <input type="text" class="form-control" id="brandAmbassador" placeholder="Enter name">
                                </div>
                                <div class="col-md-4">
                                    <label for="storeName">Store Name</label>
                                    <input type="text" class="form-control" id="storeName" placeholder="Enter store">
                                </div>
                                <div class="col-md-4">
                                    <label for="brand">Brand</label>
                                    <input type="text" class="form-control" id="brand" placeholder="Enter brand">
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <label>Sort By</label>
                                    <div class="d-flex">
                                        <select class="form-control w-75" id="sortBy">
                                            <option value="name">Name</option>
                                            <option value="date">Date</option>
                                        </select>
                                        <div class="ml-3">
                                            <input type="radio" name="sortOrder" value="asc" checked> Asc
                                            <input type="radio" name="sortOrder" value="desc"> Desc
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Side: Radio Filters & Refresh -->
                        <div class="col-md-4">
                            <label>Filter by Type</label>
                            <div class="btn-group btn-group-toggle d-flex" data-toggle="buttons">
                                <label class="btn btn-outline-primary active">
                                    <input type="radio" name="filterType" value="all" checked> All
                                </label>
                                <label class="btn btn-outline-primary">
                                    <input type="radio" name="filterType" value="outright"> Outright
                                </label>
                                <label class="btn btn-outline-primary">
                                    <input type="radio" name="filterType" value="consignment"> Consignment
                                </label>
                            </div>
                            <div class="mt-3 d-flex justify-content-between align-items-center">
                                <span><strong>Area / ASC Name:</strong> [Dynamic]</span>
                                <button class="btn btn-primary btn-sm" id="refreshButton"><i class="fas fa-sync-alt"></i> Refresh</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- DataTables Section -->
                <div class="row mt-3">
                    <div class="col-md-3">
                        <div class="card p-3 shadow-sm">
                            <div class="tbl-title-bg"><h5>SLOW MOVING SKU'S</h5></div>
                            <table id="dataTable1" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Brand Ambassador</th>
                                        <th>Store Name</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>John Doe</td>
                                        <td>Store A</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card p-3 shadow-sm">
                            <div class="tbl-title-bg"><h5>OVERSTOCK SKU'S</h5></div>
                            <table id="dataTable2" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Brand Ambassador</th>
                                        <th>Store Name</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Jane Smith</td>
                                        <td>Store B</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card p-3 shadow-sm">
                            <div class="tbl-title-bg"><h5>NPD SKU'S</h5></div>
                            <table id="dataTable3" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Brand Ambassador</th>
                                        <th>Store Name</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Mike Johnson</td>
                                        <td>Store C</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card p-3 shadow-sm">
                            <div class="tbl-title-bg"><h5>HERO SKU'S</h5></div>
                            <table id="dataTable4" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Brand Ambassador</th>
                                        <th>Store Name</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Alice Brown</td>
                                        <td>Store D</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
