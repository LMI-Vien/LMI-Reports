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
                        <div class="ml-auto p-3 rounded bg-light border shadow-sm small text-secondary" style="max-width: 550px;">
                            <div class="mb-2">
                                <i class="fas fa-database text-dark mr-1"></i> 
                                <strong>Source:</strong> <?= !empty($source) ? $source : 'N/A'; ?> - <?= !empty($source_date) ? $source_date : 'N/A'; ?>
                            </div>
                            <div>
                                <i class="fas fa-calendar-week text-dark mr-1"></i>
                                <strong>Current Week:</strong> 
                                <span id="currentWeek" class="text-dark font-weight-medium"></span>
                            </div>
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
                                        <th class="tbl-title-field">Jul</th><th class="tbl-title-field">Aug</th><th class="tbl-title-field">Sep</th><th class="tbl-title-field">Oct</th><th class="tbl-title-field">Nov</th><th class="tbl-title-field">Dec</th><th class="tbl-title-field">Total</th>
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
                                id="exportPdf"
                                onclick="handleAction('exportPdf')"
                            >
                                <i class="fas fa-file-export"></i> PDF
                            </button>
                            <button 
                                class="btn btn-success" 
                                id="exportExcel"
                                onclick="handleAction('exportExcel')"
                            >
                                <i class="fas fa-file-export"></i> Excel
                            </button>
                        </div>
                        <div class="ml-auto text-muted small" style="white-space: normal;">
                            <div class="row">
                                <div class="col-md-3 mb-2">
                                    <strong>Note:</strong><br>
                                    <?= !empty($foot_note) ? $foot_note : 'N/A'; ?>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <strong>Without BA/Vacant:</strong>
                                    <p>Achieved = (TY Sell Out / Target Sales) * 100%</p>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <strong>Outright/Consignment:</strong>
                                    <p>Achieved = (Sales Report / Target Sales) * 100%</p>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <strong>BA Type = ALL:</strong>
                                    <p>Achieved = ((TY Sell Out + Sales Report) / Target Sales) * 100%</p>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

    let brand_ambassadors = <?= json_encode($brand_ambassadors) ?>;
    let store_branch = <?= json_encode($store_branches) ?>;
    let brands = <?= json_encode($brands) ?>;
    let area = <?= json_encode($areas) ?>;
    let asc = <?= json_encode($asc) ?>;
    let brandLabel = <?= json_encode($brandLabel); ?>;

    brand_ambassadors.unshift(
        { id: "-6", name: "Non Ba" },
        { id: "-5", name: "Vacant" }
    )
    const start_time = new Date();
</script>
