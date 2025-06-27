<?php
    $dir = dirname(__FILE__);
    $minify = new \App\Libraries\MinifyLib();

    echo $minify->css($dir . '/assets/custom.css', 'Store Custom CSS');
    echo $minify->js($dir . '/assets/function.js', 'App Functions JS');
?>

<?= view("site/store/perf-per-area/sales_performance_per_area_filter"); ?> 

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
                <!-- DataTables Section -->
                <div class="card p-4 shadow-lg text-center text-muted table-empty">
                  <i class="fas fa-filter mr-2"></i> Please select a filter
                </div>
                <div class="col-md-12">
                    <div class="card mt-4 p-4 shadow-sm hide-div">
                        <div class="mb-3" style="overflow-x: auto; height: 450px; padding: 0px;">
                            <table id="info_for_asc" class="table table-bordered table-responsive" style="width: 100% !important;">
                                <thead>
                                    <tr>
                                        <th 
                                            colspan="10"
                                            style="font-weight: bold; font-family: 'Poppins', sans-serif; text-align: center;"
                                            class="tbl-title-header"
                                        >
                                            Store Sales Performance per Area
                                        </th>
                                    </tr>
                                    <tr>
                                        <th class="tbl-title-field text-center">Rank</th>
                                        <th class="tbl-title-field text-center">Area</th>
                                        <th class="tbl-title-field text-center">Area Sales Coordinator</th>
                                        <th class="tbl-title-field text-center">LY Scan Data</th>
                                        <th class="tbl-title-field text-center">Actual Sales Report</th>
                                        <th class="tbl-title-field text-center">Target</th>
                                        <th class="tbl-title-field text-center">% Achieved 
                                            <span class="tooltip-text">
                                                FORMULA:
                                                <br>
                                                Actual Sales Report / Target * 100 
                                            </span>
                                        </th>
                                        </th>
                                        <th class="tbl-title-field text-center">% Growth
                                            <span class="tooltip-text">
                                                FORMULA:
                                                <br>
                                                Actual Sales Report / LY Scan Data * 100
                                            </span>
                                        </th>
                                        <th class="tbl-title-field text-center">Balance To Target
                                            <span class="tooltip-text">
                                                FORMULA:
                                                <br>
                                                Target - Actual Sales Report
                                            </span>
                                        </th>
                                        <th class="tbl-title-field text-center">Target Per Remaining Days
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
                                              <td colspan="10" class="text-center py-4 text-muted">
                                              </td>
                                          </tr>
                                          <tr>
                                              <td colspan="10" class="text-center py-4 text-muted">
                                                  No data available
                                              </td>
                                          </tr>
                                          <tr>
                                              <td colspan="10" class="text-center py-4 text-muted">
                                              </td>
                                          </tr>
                                      </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-end mt-3">
                            <button 
                                class="btn btn-primary mr-2" 
                                id="ExportPDF"
                                onclick="handleAction('exportPdf')"
                            >
                                <i class="fas fa-file-export"></i> PDF
                            </button>
                            <button 
                                class="btn btn-success" 
                                id="exportButton"
                                onclick="handleAction('exportExcel')"
                            >
                                <i class="fas fa-file-export"></i> Excel
                            </button>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>

<script>
    var base_url = "<?= base_url(); ?>";
    let store_branch = <?= json_encode($store_branches) ?>;
    let brands = <?= json_encode($brands) ?>;
    let area = <?= json_encode($areas) ?>;
    let asc = <?= json_encode($asc) ?>;
    let year = <?= json_encode($year); ?>;
    let months = <?= json_encode($months); ?>;
    const start_time = new Date();  
</script>
