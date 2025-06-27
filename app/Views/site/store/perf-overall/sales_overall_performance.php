<?php
    $dir = dirname(__FILE__);
    $minify = new \App\Libraries\MinifyLib();

    echo $minify->css($dir . '/assets/custom.css', 'Store Custom CSS');
    echo $minify->js($dir . '/assets/function.js', 'App Functions JS');
?>

<?= view("site/store/perf-overall/sales_overall_performance_filter"); ?> 

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

                <div class="card mt-4 p-4 shadow-sm hide-div">
                    <div class="mb-3" style="overflow-x: auto; height: 450px; padding: 0px;">
                        <table id="top_performing_stores" class="table table-bordered" style="width: 100% !important;">
                            <thead>
                                <tr>
                                    <th 
                                        colspan="6"
                                        style="font-weight: bold; font-family: 'Poppins', sans-serif; text-align: center;"
                                        class="static-header"
                                    >
                                        OVERALL STORES SALES PERFORMANCE
                                    </th>
                                </tr>
                                <tr>
                                    <th class="tbl-title-field text-center">Rank</th>
                                    <th class="tbl-title-field text-center">Store Code / Store Name</th>
                                    <th class="tbl-title-field text-center">LY Sell Out</th>
                                    <th class="tbl-title-field text-center">TY Sell Out</th>
                                    <th class="tbl-title-field text-center">% Growth 
                                        <span class="tooltip-text">
                                            FORMULA:
                                            <br>
                                            (TY total gross sales - LY total gross sale) / LY total gross sales * 100
                                        </span>
                                    </th>
                                    <th class="tbl-title-field text-center">Share of Business
                                        <span class="tooltip-text">
                                            FORMULA:
                                            <br>
                                            (Store TY Sell Out / Sum of Total TY Sell Out) * 100 %
                                        </span>
                                    </th>
                                </tr>
                            </thead>
                              <tbody>
                                  <tr>
                                      <td colspan="6" class="text-center py-4 text-muted">
                                      </td>
                                  </tr>
                                  <tr>
                                      <td colspan="6" class="text-center py-4 text-muted">
                                          No data available
                                      </td>
                                  </tr>
                                  <tr>
                                      <td colspan="6" class="text-center py-4 text-muted">
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
                            id="exportExcel"
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

<script>
    let brand_ambassadors = <?= json_encode($brand_ambassadors) ?>;
    let store_branch = <?= json_encode($store_branches) ?>;
    let brands = <?= json_encode($brands) ?>;
    let area = <?= json_encode($areas) ?>;
    let asc = <?= json_encode($asc) ?>;
    let brandLabel = <?= json_encode($brandLabel); ?>;
    let year = <?= json_encode($year); ?>;
    let months = <?= json_encode($months); ?>;
    brand_ambassadors.unshift(
        { id: "-6", name: "Non Ba" },
        { id: "-5", name: "Vacant" }
    )
    const start_time = new Date();  
</script>