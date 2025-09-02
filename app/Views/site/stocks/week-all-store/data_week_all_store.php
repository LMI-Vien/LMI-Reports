<?php
    $dir = dirname(__FILE__);
    $minify = new \App\Libraries\MinifyLib();

    echo $minify->css($dir . '/assets/custom.css', 'Store Custom CSS');
    echo $minify->js($dir . '/assets/function.js', 'App Functions JS');
?>

<?= view("site/stocks/week-all-store/data_week_all_store_filter"); ?> 

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
                                <strong>Source:</strong> <?= !empty($source) ? $source : 'N/A'; ?>
                            </div>
                            <div class="mb-2">
                                <i class="fas fa-file-import text-dark mr-1"></i> 
                                <strong>Most Recent Import VMI:</strong> Week: <?= !empty($latestWeek) ? $latestWeek : 'N/A'; ?>
                                <span id="mostRecentImportWeekRange"
                                    data-latest-week="<?= (int) $latestWeek ?>">
                                </span>
                            </div>
                            <div class="mb-2">
                                <i class="fas fa-file-import text-dark mr-1"></i> 
                                <strong>Most Recent Import Week by Week:</strong> Year: <?= !empty($latestMonthWeekByWeek) ? $latestMonthWeekByWeek : 'N/A'; ?> - <?= !empty($latestYearWeekByWeek) ? $latestYearWeekByWeek : 'N/A'; ?>
                            </div>
                            <div>
                                <i class="fas fa-calendar-week text-dark mr-1"></i>
                                <strong>Current Week:</strong> 
                                <span id="currentWeek" class="text-dark font-weight-medium"></span>
                            </div>
                            <div class="mt-2">
                                <i class="fas fa-calendar-check text-dark mr-1"></i>
                                <strong>Filtered Date:</strong>
                                <span id="filteredDate" class="text-dark font-weight-medium"></span>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="row mt-4">
                    <div class="col-md-12">
                      <div class="card p-4 shadow-lg text-center text-muted table-empty">
                          <i class="fas fa-filter mr-2"></i> Please select a filter
                      </div>
                        <div class="hide-div">
                        <div class="hide-div card" style="overflow-x: auto; height: 650px; padding: 0px;">
                            <table id="table_slowMoving" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th 
                                            colspan="3"
                                            style="font-weight: bold; font-family: 'Poppins', sans-serif; text-align: center;"
                                            class="tbl-title-header"
                                            id="table_slowMoving_TH"
                                        >
                                            SLOW MOVING SKU'S
                                        </th>
                                    </tr>
                                     <tr id="table_slowMoving_headers">
                                        <th class="tbl-title-field text-center">SKU Code</th>
                                        <th class="tbl-title-field text-center">SKU Description</th>
                                        <th class="tbl-title-field text-center">LMI/RGDI Code</th>
                                    </tr>
                                </thead>
                                  <tbody>
                                      <tr>
                                          <td colspan="3" class="text-center py-4 text-muted">
                                          </td>
                                      </tr>
                                      <tr>
                                          <td colspan="3" class="text-center py-4 text-muted">
                                              No data available
                                          </td>
                                      </tr>
                                      <tr>
                                          <td colspan="3" class="text-center py-4 text-muted">
                                          </td>
                                      </tr>
                                  </tbody>
                            </table>
                        </div>

                        <div class="hide-div card" style="overflow-x: auto; height: 650px; padding: 0px;">
                            <table id="table_overStock" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th 
                                            colspan="3"
                                            style="font-weight: bold; font-family: 'Poppins', sans-serif; text-align: center;"
                                            class="tbl-title-header"
                                            id="table_overStock_TH"
                                        >
                                            OVERSTOCK SKU'S
                                        </th>
                                    </tr>
                                    <tr id="table_overStock_headers">
                                        <th class="tbl-title-field text-center">SKU Code</th>
                                        <th class="tbl-title-field text-center">SKU Description</th>
                                        <th class="tbl-title-field text-center">LMI/RGDI Code</th>
                                    </tr>
                                </thead>
                                  <tbody>
                                      <tr>
                                          <td colspan="3" class="text-center py-4 text-muted">
                                          </td>
                                      </tr>
                                      <tr>
                                          <td colspan="3" class="text-center py-4 text-muted">
                                              No data available
                                          </td>
                                      </tr>
                                      <tr>
                                          <td colspan="3" class="text-center py-4 text-muted">
                                          </td>
                                      </tr>
                                  </tbody>
                            </table>
                        </div>

                        <div class="hide-div card" style="overflow-x: auto; height: 650px; padding: 0px;">
                            <table id="table_npd" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th 
                                            colspan="3"
                                            style="font-weight: bold; font-family: 'Poppins', sans-serif; text-align: center;"
                                            class="tbl-title-header"
                                            id="table_npd_TH"
                                        >
                                            NPD SKU'S
                                        </th>
                                    </tr>
                                    <tr id="table_npd_headers">
                                        <th class="tbl-title-field text-center">SKU Code</th>
                                        <th class="tbl-title-field text-center">SKU Description</th>
                                        <th class="tbl-title-field text-center">LMI/RGDI Code</th>
                                    </tr>
                                </thead>
                                  <tbody>
                                      <tr>
                                          <td colspan="3" class="text-center py-4 text-muted">
                                          </td>
                                      </tr>
                                      <tr>
                                          <td colspan="3" class="text-center py-4 text-muted">
                                              No data available
                                          </td>
                                      </tr>
                                      <tr>
                                          <td colspan="3" class="text-center py-4 text-muted">
                                          </td>
                                      </tr>
                                  </tbody>
                            </table>
                        </div>

                        <div class="hide-div card" style="overflow-x: auto; height: 650px; padding: 0px;">
                            <table id="table_hero" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th 
                                            colspan="3"
                                            style="font-weight: bold; font-family: 'Poppins', sans-serif; text-align: center;"
                                            class="tbl-title-header"
                                        >
                                            HERO SKU'S
                                        </th>
                                    </tr>
                                    <tr id="table_hero_headers">
                                        <th class="tbl-title-field text-center">SKU Code</th>
                                        <th class="tbl-title-field text-center">SKU Description</th>
                                        <th class="tbl-title-field text-center">LMI/RGDI Code</th>
                                    </tr>
                                </thead>
                                  <tbody>
                                      <tr>
                                          <td colspan="3" class="text-center py-4 text-muted">
                                          </td>
                                      </tr>
                                      <tr>
                                          <td colspan="3" class="text-center py-4 text-muted">
                                              No data available
                                          </td>
                                      </tr>
                                      <tr>
                                          <td colspan="3" class="text-center py-4 text-muted">
                                          </td>
                                      </tr>
                                  </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-end mt-3" id="step7">
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
</div>

<script>
    let traccItemClassi = <?= json_encode($traccItemClassi); ?>;
    let itemClassi = <?= json_encode($itemClassi); ?>;
    const start_time = new Date();
</script>
