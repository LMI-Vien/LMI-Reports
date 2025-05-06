<?php
    $dir = dirname(__FILE__);
    $minify = new \App\Libraries\MinifyLib();

    echo $minify->css($dir . '/assets/custom.css', 'Store Custom CSS');
    echo $minify->js($dir . '/assets/function.js', 'App Functions JS');
?>

<?= view("site/store/perf-per-month/sales_performance_per_month_filter"); ?> 

<div class="wrapper">
    <div class="content-wrapper">
        <div class="content">
            <div class="container-fluid py-4">

                <!-- Filters Section -->
                <?php if (isset($breadcrumb)): ?>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb bg-transparent px-0 mb-0">
                                <li class="breadcrumb-item">
                                    <a href="<?= base_url() ?>">
                                        <i class="fas fa-home"></i>
                                    </a>
                                </li>
                                <?php 
                                    $last = end($breadcrumb);
                                    foreach ($breadcrumb as $label => $url): 
                                        if ($url != ''):
                                ?>
                                    <li class="breadcrumb-item">
                                        <?= $label ?>
                                    </li>
                                <?php else: ?>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        <?= $label ?>
                                    </li>
                                <?php 
                                        endif;
                                    endforeach; 
                                ?>
                            </ol>
                        </nav>
                        <!-- Right side content -->
                        <div class="ml-auto text-muted small" style="white-space: nowrap;">
                            <strong>Source:</strong> <?= !empty($source) ? $source : 'N/A'; ?> - <?= !empty($source_date) ? $source_date : 'N/A'; ?>

                        </div>
                    </div>
                <?php endif; ?>

                <div class="card p-4 shadow-lg text-center text-muted table-empty">
                  <i class="fas fa-filter mr-2"></i> Please select a filter
                </div>
                    <!-- DataTables Section -->
                
                <div class="hide-div data-graph">
                    <div class="card p-4 shadow-sm" id="data-graph">
                        <div class="text-center">
                            <h5 class="mb-3"><i class="fas fa-chart-bar"></i></h5>
                        </div>

                        <div class="mb-3" style="overflow-x: auto; padding: 0px;">
                            <div id="chartContainer" class="d-flex flex-row"></div>
                        </div>
                        <!-- Data Table -->
                        <div class="table-responsive mt-4">
                            <div class="mb-3" style="overflow-x: auto; height: 450px; padding: 0px;">
                            <table class="table table-bordered text-center">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="tbl-title-field"></th>
                                        <th class="tbl-title-field">Jan</th><th class="tbl-title-field">Feb</th><th class="tbl-title-field">Mar</th><th class="tbl-title-field">Apr</th><th class="tbl-title-field">May</th><th class="tbl-title-field">Jun</th>
                                        <th class="tbl-title-field">Jul</th><th class="tbl-title-field">Aug</th><th class="tbl-title-field">Sep</th><th class="tbl-title-field">Oct</th><th class="tbl-title-field">Nov</th><th class="tbl-title-field">Dec</th>
                                    </tr>
                                </thead>
                                <tbody class="asc-dashboard-body">
                                </tbody>
                            </table>
                            </div>
                        </div>
                    </div>
                        <div class="d-flex justify-content-end mt-3">
                            <button 
                                class="btn btn-primary mr-2" 
                                id="ExportPDF"
                                onclick="handleAction('export_pdf')"
                            >
                                <i class="fas fa-file-export"></i> PDF
                            </button>
                            <button 
                                class="btn btn-success" 
                                id="exportButton"
                                onclick="handleAction('export_excel')"
                            >
                                <i class="fas fa-file-export"></i> Excel
                            </button>
                        </div>
                    <div class="ml-auto text-muted small" style="white-space: nowrap;">
                        <strong>Note:</strong> <?= !empty($foot_note) ? $foot_note : 'N/A'; ?>
                    </div>
                </div>
                <div class="hide-div">
                    <div id="table-skus" style="overflow-x: auto; padding: 0px;">
                    <div class="row mt-12">
                        <div class="d-flex flex-row">
                            <div class="col-md-6">
                                <div class="card p-6 shadow-sm">
                                    <table id="slowMovingTable" class="table table-bordered" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th 
                                                    colspan="5"
                                                    style="font-weight: bold; font-family: 'Poppins', sans-serif; text-align: center;"
                                                    class="tbl-title-header"
                                                >
                                                    SLOW MOVING SKU'S
                                                </th>
                                            </tr>
                                            <tr>
                                                <th class="tbl-title-field">SKU</th>
                                                <th class="tbl-title-field">SOH Qty</th>
                                                <th class="tbl-title-field">Qty (W1)</th>
                                                <th class="tbl-title-field">Qty (W2)</th>
                                                <th class="tbl-title-field">Qty (W3)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td colspan="5">No data available</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card p-6 shadow-sm">
                                    <table id="overstockTable" class="table table-bordered" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th 
                                                    colspan="5"
                                                    style="font-weight: bold; font-family: 'Poppins', sans-serif; text-align: center;"
                                                    class="tbl-title-header"
                                                >OVERSTOCK SKU'S</th>
                                            </tr>
                                            <tr>
                                                <th class="tbl-title-field">SKU</th>
                                                <th class="tbl-title-field">SOH Qty</th>
                                                <th class="tbl-title-field">Qty (W1)</th>
                                                <th class="tbl-title-field">Qty (W2)</th>
                                                <th class="tbl-title-field">Qty (W3)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td colspan="5">No data available</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card p-6 shadow-sm">
                                    <table id="npdTable" class="table table-bordered" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th 
                                                    colspan="5"
                                                    style="font-weight: bold; font-family: 'Poppins', sans-serif; text-align: center;"
                                                    class="tbl-title-header"
                                                >NPD SKU'S</th>
                                            </tr>
                                            <tr>
                                                <th class="tbl-title-field">SKU</th>
                                                <th class="tbl-title-field">SOH Qty</th>
                                                <th class="tbl-title-field">Qty (W1)</th>
                                                <th class="tbl-title-field">Qty (W2)</th>
                                                <th class="tbl-title-field">Qty (W3)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td colspan="5">No data available</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card p-6 shadow-sm">
                                    <table id="heroTable" class="table table-bordered" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th 
                                                    colspan="1"
                                                    style="font-weight: bold; font-family: 'Poppins', sans-serif; text-align: center;"
                                                    class="tbl-title-header"
                                                >HERO SKU'S</th>
                                            </tr>
                                            <tr>
                                                <th class="tbl-title-field">SKU</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td colspan="5">No data available</td>
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
        </div>
    </div>
</div>

<script>

    let asc = <?= json_encode($asc); ?>;
    let area = <?= json_encode($area); ?>;
    let brand = <?= json_encode($brand); ?>;
    let store_branch = <?= json_encode($store_branch); ?>;
    let brand_ambassador = <?= json_encode($brand_ambassador); ?>;

</script>
