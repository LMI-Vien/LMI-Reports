<style>
    .card {
        border-radius: 12px !important;
        background: #ffffff;
        transition: transform 0.3s ease-in-out;
        border: 1px solid grey;
        padding: 15px;
    }

    table {
        border-collapse: collapse;
        border: 1px solid #ddd;
        background-color: #fff;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    
    th, td {
        padding: 12px;
        border: 1px solid #ddd;
        text-align: center;
    }

    thead {
        color: white;
        text-align: center;
        position: sticky;
        top: 0;
        z-index: 100;
        color: #fff;
        background-color: #301311;
    }

    tbody tr th {
        position: sticky;
        top: 50px;
        z-index: 90;
        color: #fff;
        background: linear-gradient(to right, #143996, #007bff);
        color: white;
    }
    
    tbody tr:nth-child(even) {
        background-color: #f9f9f9;
    }
    
    tbody tr:hover {
        background-color: #f1f1f1;
        cursor: pointer;
    }
    
    .table-responsive {
        max-height: 500px;
        overflow-x: auto;
        overflow-y: auto;
        display: block;
        white-space: nowrap;
    }

    .md-center {
        color: white;
        font-weight: bold;
        font-family: 'Poppins', sans-serif;
        font-size: 1.6rem;
        text-align: center;
        background: linear-gradient(90deg, #fdb92a, #ff9800);
        border: none;
        border-radius: 12px;
        padding: 15px;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
    }

    label {
        font-weight: 600;
        font-size: 0.95rem;
        color: #333;
        margin-bottom: 5px;
    }

    input.form-control {
        background: #f9f9f9;
        border: 1px solid #ccc;
        border-radius: 8px;
        padding: 8px 12px;
        font-size: 0.95rem;
    }

    input.form-control:focus {
        border-color: #ff9800;
        box-shadow: 0px 0px 5px rgba(255, 152, 0, 0.5);
        background: #fff;
    }

    /* Title Styling */
    .tbl-title-field {
        /* background: linear-gradient(to right, #007bff, #143996); */
        background: linear-gradient(to right, #143996, #007bff);
        color: white !important;
        text-align: center;
        padding: 10px;
        font-size: 18px;
        font-weight: bold;
    }

    .tbl-title-header {
        border-radius: 8px 8px 0px 0px !important;
    }
    
    @media (max-width: 768px) {
        th, td {
            font-size: 14px;
            padding: 8px;
        }
    }
</style>

<div class="wrapper">
    <div class="content-wrapper">
        <div class="content">
            <div class="container-fluid py-4">
                <div class="container mt-4">
                    <div class="card">
                        <div class="md-center text-center p-2 col">
                            <span class="my-auto">Information for Area Sales Coordinator (Preview)</span>
                        </div>

                        <!-- <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="store_name">Store Name</label>
                                    <input type="text" class="form-control" id="store_name" readonly>
                                </div>
                                <div class="col-md-3">
                                    <label for="area">Area</label>
                                    <input type="text" class="form-control" id="area" readonly>
                                </div>
                                <div class="col-md-3">
                                    <label for="month_year">Month</label>
                                    <input type="text" class="form-control" id="month" readonly>
                                </div>
                                <div class="col-md-3">
                                    <label for="month_year">Year</label>
                                    <input type="text" class="form-control" id="year" readonly>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-md-6"></div>
                                    <div class="col-md-6 text-right pr-2">
                                        <small id="date-generated"></small>
                                    </div>
                                </div>
                                
                            </div>

                            <div class="row mt-3 align-items-center">
                                
                                <div class="col-md-3"></div>
                                
                            </div>
                        </div> -->

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="store">Store</label>
                                    <input type="text" class="form-control" id="store_name" value="<?= ($store_branch_name == 0) ? 'ANY' : $store_branch_name; ?>" readonly>
                                </div>
                                <div class="col-md-3">
                                    <label for="area">Area</label>
                                    <input type="text" class="form-control" id="area" value="<?= ($area_name == 0) ? 'ANY' : $area_name; ?>" readonly>
                                </div>
                                <div class="col-md-3">
                                    <label for="month">Month</label>
                                    <input type="text" class="form-control" id="month" value="<?= ($month_name == 0) ? 'ANY' : $month_name; ?>" readonly>
                                </div>
                                <div class="col-md-3">
                                    <label for="year">Year</label>
                                    <input type="text" class="form-control" id="year" value="<?= ($year_name == 0) ? 'ANY' : $year_name; ?>" readonly>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-6"></div>
                                <div class="col-md-6 text-right pr-2">
                                    <small id="date-generated"></small>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="card">
                        <div class="table-responsive">
                            <table id="info_for_asc" class="table">
                                <thead>
                                    <tr>
                                        <th 
                                            colspan="8"
                                            style="font-weight: bold; font-family: 'Poppins', sans-serif; text-align: center;"
                                            class="tbl-title-header"
                                        >
                                            SUMMARY
                                        </th>
                                    </tr>
                                    <tr>
                                        <th class="tbl-title-field">Rank</th>
                                        <th class="tbl-title-field">Area</th>
                                        <th class="tbl-title-field">Area Sales Coordinator</th>
                                        <th class="tbl-title-field">Actual Sales Report</th>
                                        <th class="tbl-title-field">Target</th>
                                        <th class="tbl-title-field">% Achieved</th>
                                        <th class="tbl-title-field">Balance To Target</th>
                                        <th class="tbl-title-field">Target per Remaining days</th>

                                    </tr>
                                </thead>
                                <tbody>
                                        <tr>
                                            <td colspan="8"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="8" style="text-align: center;">No data available</td>
                                        </tr>
                                        <tr>
                                            <td colspan="8"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="8"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="8"></td>
                                        </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
    var segment = "<?=$uri->getSegment(3);?>";
    var params = segment.split("-");

    $(document).ready(function() {
        // populate header
        populateHeaderData();

        // populate table
        populateTable();
       
    });

    //clear the session on page close
    $(window).on("beforeunload", function() {
        $.ajax({
            url: "<?= base_url('trade-dashboard/clear-filter-session/asc_preview_filters'); ?>",
            type: "POST",
            async: false 
        });
    });
    //clear the session on click other pages
    $(document).on("click", "a", function() {
        $.post("<?= base_url('trade-dashboard/clear-filter-session/asc_preview_filters'); ?>");
    });

    function populateHeaderData() {
        let date = new Date();
        let formattedDate = date.toLocaleDateString("en-US", { 
            year: "numeric", 
            month: "short", 
            day: "numeric",
            hour:"2-digit",
            minute:"2-digit",
            second:"2-digit",
            hour12:true
        });
        $('#date-generated').text(`Date Generated: ${formattedDate}`);
    }

    // function populateTable() {
    //     console.log("Fetching data...", params);
    //     let selectedStore = '<?= ($store_branch_val == 0) ? NULL : $store_branch_val; ?>';
    //     let selectedArea = '<?= ($area_val == 0) ? NULL : $area_val; ?>';
    //     let selectedMonth = '<?= ($month_val == 0) ? NULL : $month_val; ?>';
    //     let selectedYear = '<?= ($year_val == 0) ? NULL : $year_val; ?>';
    //     let selectedSortField = '<?= ($sort_field == 0) ? NULL : $sort_field; ?>';
    //     let selectedSortOrder = '<?= ($sort_order == 0) ? NULL : $sort_order; ?>';

    //     fetchTradeDashboardData({
    //         selectedStore, 
    //         selectedArea, 
    //         selectedMonth, 
    //         selectedYear, 
    //         selectedSortField, 
    //         selectedSortOrder,
    //         length: 10,
    //         start: 0,
    //         onSuccess: function(data) {
    //             let html = '';

    //             data.forEach((value) => {
    //                 html += `<tr>
    //                     <td>${value.rank}</td>
    //                     <td>${value.area}</td>
    //                     <td>${value.asc_names}</td>
    //                     <td>${value.actual_sales}</td>
    //                     <td>${value.target_sales}</td>
    //                     <td>${value.percent_ach ?? ""}</td>
    //                     <td>${value.balance_to_target}</td>
    //                     <td>${value.target_per_remaining_days}</td>
    //                 </tr>`;
    //             });

    //             $(`#info_for_asc tbody`).html(html);
    //         },
    //         onError: function(error) {
    //             alert("Error:", error);
    //         }
    //     });
    // }

    function populateTable() {

        let selectedStore = '<?= ($store_branch_val == 0) ? NULL : $store_branch_val; ?>';
        let selectedArea = '<?= ($area_val == 0) ? NULL : $area_val; ?>';
        let selectedMonth = '<?= ($month_val == 0) ? NULL : $month_val; ?>';
        let selectedYear = '<?= ($year_val == 0) ? NULL : $year_val; ?>';
        let selectedSortField = '<?= ($sort_field == 0) ? NULL : $sort_field; ?>';
        let selectedSortOrder = '<?= ($sort_order == 0) ? NULL : $sort_order; ?>';

        if ($.fn.DataTable.isDataTable('#info_for_asc')) {
            let existingTable = $('#info_for_asc').DataTable();
            existingTable.clear().destroy();
        }

        let table = $('#info_for_asc').DataTable({
            paging: true,
            searching: false,
            ordering: true,
            info: true,
            lengthChange: false,
            colReorder: true, 
            ajax: {
                url: base_url + 'trade-dashboard/trade-info-asc',
                type: 'GET',
                data: function(d) {
                    d.sort_field = selectedSortField;
                    d.sort = selectedSortOrder;
                    d.year = selectedYear === "0" ? null : selectedYear;
                    d.month = selectedMonth === "0" ? null : selectedMonth;
                    d.area = selectedArea === "0" ? null : selectedArea;
                    d.store = selectedStore === "0" ? null : selectedStore;
                    d.limit = d.length;
                    d.offset = d.start;
                },
                dataSrc: function(json) {
                    json
                    return json.data.length ? json.data : [];
                }
            },
            columns: [
                { data: 'rank' },
                { data: 'area' },
                { data: 'asc_names' },
                { data: 'actual_sales' },
                { data: 'target_sales' },
                { data: 'percent_ach' },
                { data: 'balance_to_target' },
                { data: 'target_per_remaining_days' }
            ].filter(Boolean),
            pagingType: "full_numbers",
            pageLength: 10,
            processing: true,
            serverSide: true,
            searching: false,
            lengthChange: false
        });
    }

    // function fetchTradeDashboardData({ 
    //     baseUrl, 
    //     selectedStore = null, 
    //     selectedArea = null, 
    //     selectedMonth = null, 
    //     selectedYear = null, 
    //     selectedSortField = null, 
    //     selectedSortOrder = null,
    //     length, 
    //     start, 
    //     onSuccess, 
    //     onError 
    // }) {
    //     let allData = [];

    //     function fetchData(offset) {
    //         $.ajax({
    //             url: base_url + 'trade-dashboard/trade-info-asc',
    //             type: 'GET',
    //             data: {
    //                 store : selectedStore === "0" ? null : selectedStore,
    //                 area : selectedArea === "0" ? null : selectedArea,
    //                 month : selectedMonth === "0" ? null : selectedMonth,
    //                 year : selectedYear === "0" ? null : selectedYear,
    //                 sort_field : selectedSortField,
    //                 sort : selectedSortOrder,
    //                 limit: length,
    //                 offset: offset
    //             },
    //             success: function(response) {

    //                 if (response.data && response.data.length) {
    //                     allData = allData.concat(response.data);

    //                     if (response.data.length === length) {
    //                         fetchData(offset + length);
    //                     } else {
    //                         if (onSuccess) onSuccess(allData);
    //                     }
    //                 } else {
    //                     if (onSuccess) onSuccess(allData);
    //                 }
    //             },
    //             error: function(error) {
    //                 if (onError) onError(error);
    //             }
    //         });
    //     }

    //     fetchData(start);
    // }

    

</script>