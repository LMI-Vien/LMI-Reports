<?php
    $dir = dirname(__FILE__);
    $minify = new \App\Libraries\MinifyLib();

    echo $minify->css($dir . '/assets/custom.css', 'Store Custom CSS');
    echo $minify->js($dir . '/assets/function.js', 'App Functions JS');
?>

<?= view("site/store/perf-per-ba/sales_performance_per_ba_filter"); ?> 

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
                <!-- DataTables Section -->

                <div class="card p-4 shadow-lg text-center text-muted table-empty">
                  <i class="fas fa-filter mr-2"></i> Please select a filter
                </div>
                <div class="card mt-4 p-4 shadow-sm hide-div">
                    <div class="form-group">
                        <button class="btn btn-secondary" id="toggleColumnsButton"><i class="fas fa-columns"></i> Toggle Columns</button>
                    </div>

                    <div class="sortable row text-center p-2" id="columnToggleContainer" class="mb-3" style="color: black;background-color: rgb(108 117 125);border-radius: 10px;margin: 10px;">
                        <strong class="col">Select Columns:</strong>
                    </div>
                    <div class="mb-3" style="overflow-x: auto; height: 450px; padding: 0px;">
                                <!-- added min-width so the table header would not get compressed using width : x% -->
                        <table id="overall_ba_sales_tbl" class="table table-bordered"> 
                            <thead>
                                <tr>
                                    <th colspan="14"
                                        style="font-weight: bold; font-family: 'Poppins', sans-serif; text-align: center;"
                                        class="tbl-title-header"
                                    >
                                        Store Sales Performance per Brand Ambassador
                                    </th>
                                </tr>                          
                                <tr>
                                    <th class="tbl-title-field text-center">Rank</th>
                                    <th class="tbl-title-field text-center">Area</th>
                                    <th class="tbl-title-field text-center">Store Code / Store Name</th>
                                    <th class="tbl-title-field sort text-center">Brand Ambassador</th>
                                    <th class="tbl-title-field sort text-center">Deployed Date</th>
                                    <th class="tbl-title-field sort text-center">Brand Handle</th>
                                    <th class="tbl-title-field sort text-center">LY Scanned Data</th>
                                    <th class="tbl-title-field text-center">Actual Sales Report</th>
                                    <th class="tbl-title-field text-center">Target</th>
                                    <th class="tbl-title-field text-center">% Achieved 
                                        <span class="tooltip-text">
                                            FORMULA:
                                            <br>
                                            Actual Sales Report / Target * 100 
                                        </span>
                                    </th>
                                    <th class="tbl-title-field sort text-center">% Growth 
                                        <span class="tooltip-text togglegrowth">
                                            FORMULA:
                                            <br>
                                            Actual Sales Report / LY Scan Data * 100
                                        </span>
                                    </th>
                                    <th class="tbl-title-field text-center">Balance To Target Per Month 
                                        <span class="tooltip-text">
                                            FORMULA:
                                            <br>
                                            Target - Actual Sales Report
                                        </span>
                                    </th>
                                    <th class="tbl-title-field text-center">Possible Incentives</th>
                                    <th class="tbl-title-field text-center">Balance to Target per Day 
                                        <span class="tooltip-text">
                                            FORMULA:
                                            <br>
                                            Balance to Target / remaining days in a month
                                        </span>
                                    </th>

                                </tr>
                            </thead>
                                  <tbody>
                                      <tr>
                                          <td colspan="14" class="text-center py-4 text-muted">
                                          </td>
                                      </tr>
                                      <tr>
                                          <td colspan="14" class="text-center py-4 text-muted">
                                              No data available
                                          </td>
                                      </tr>
                                      <tr>
                                          <td colspan="14" class="text-center py-4 text-muted">
                                          </td>
                                      </tr>
                                  </tbody>
                        </table>
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
    let year = <?= json_encode($year); ?>;
    let months = <?= json_encode($months); ?>;
</script>
