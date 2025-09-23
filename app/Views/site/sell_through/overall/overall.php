<?php
    $dir = dirname(__FILE__);
    $minify = new \App\Libraries\MinifyLib();

    echo $minify->css($dir . '/assets/custom.css', 'Store Custom CSS');
    echo $minify->js($dir . '/assets/function.js', 'App Functions JS');
?>

<?= view("site/sell_through/by_brand/by_brand_filter"); ?> 

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
                            <div class="mb-2">
                                <i class="fas fa-file-import text-dark mr-1"></i> 
                                <strong>CMS Most Recent Import:</strong> Week:  - 
                                <span id="mostRecentImportWeekRange"
                                    data-latest-week=""
                                    data-latest-year="">
                                </span>
                            </div>
                            <div>
                                <i class="fas fa-calendar-week text-dark mr-1"></i>
                                <strong>Current Week:</strong> 
                                <span id="currentWeek" class="text-dark font-weight-medium"></span>
                            </div>
                            <div class="mt-2">
                                <i class="fas fa-calendar-check text-dark mr-1"></i>
                                <strong>Generation Period:</strong>
                                <span id="generationPeriod" class="text-dark font-weight-medium"></span>
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
                        <div class="hide-div card">
                            <table id="table_slowMoving" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th 
                                            colspan="7"
                                            style="font-weight: bold; font-family: 'Poppins', sans-serif; text-align: center;"
                                            class="tbl-title-header"
                                        >
                                            SLOW MOVING SKU'S
                                        </th>
                                    </tr>
                                    <tr>
                                        <th class="tbl-title-field text-center">LMI/RGDI Code</th>
                                        <th class="tbl-title-field text-center">SKU</th>
                                        <th class="tbl-title-field text-center">SKU Name</th>
                                        <th class="tbl-title-field text-center">Item Class</th>
                                        <th class="tbl-title-field text-center">Total Qty</th>
                                        <th class="tbl-title-field text-center">Ave Sales Unit</th>
                                        <th class="tbl-title-field text-center">SWC</th>
                                    </tr>
                                </thead>
                                  <tbody>
                                      <tr>
                                          <td colspan="7" class="text-center py-4 text-muted">
                                          </td>
                                      </tr>
                                      <tr>
                                          <td colspan="7" class="text-center py-4 text-muted">
                                              No data available
                                          </td>
                                      </tr>
                                      <tr>
                                          <td colspan="7" class="text-center py-4 text-muted">
                                          </td>
                                      </tr>
                                  </tbody>
                            </table>
                        </div>

                        <div class="hide-div card">
                            <table id="table_overStock" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th 
                                            colspan="7"
                                            style="font-weight: bold; font-family: 'Poppins', sans-serif; text-align: center;"
                                            class="tbl-title-header"
                                        >
                                            OVERSTOCK SKU'S
                                        </th>
                                    </tr>
                                    <tr>
                                        <th class="tbl-title-field text-center">LMI/RGDI Code</th>
                                        <th class="tbl-title-field text-center">SKU</th>
                                        <th class="tbl-title-field text-center">SKU Name</th>
                                        <th class="tbl-title-field text-center">Item Class</th>
                                        <th class="tbl-title-field text-center">Total Qty</th>
                                        <th class="tbl-title-field text-center">Ave Sales Unit</th>
                                        <th class="tbl-title-field text-center">SWC</th>
                                    </tr>
                                </thead>
                                  <tbody>
                                      <tr>
                                          <td colspan="7" class="text-center py-4 text-muted">
                                          </td>
                                      </tr>
                                      <tr>
                                          <td colspan="7" class="text-center py-4 text-muted">
                                              No data available
                                          </td>
                                      </tr>
                                      <tr>
                                          <td colspan="7" class="text-center py-4 text-muted">
                                          </td>
                                      </tr>
                                  </tbody>
                            </table>
                        </div>

                        <div class="hide-div card">
                            <table id="table_npd" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th 
                                            colspan="7"
                                            style="font-weight: bold; font-family: 'Poppins', sans-serif; text-align: center;"
                                            class="tbl-title-header"
                                        >
                                            NPD SKU'S
                                        </th>
                                    </tr>
                                    <tr>
                                        <th class="tbl-title-field text-center">LMI/RGDI Code</th>
                                        <th class="tbl-title-field text-center">SKU</th>
                                        <th class="tbl-title-field text-center">SKU Name</th>
                                        <th class="tbl-title-field text-center">Item Class</th>
                                        <th class="tbl-title-field text-center">Total Qty</th>
                                        <th class="tbl-title-field text-center">Ave Sales Unit</th>
                                        <th class="tbl-title-field text-center">SWC</th>
                                    </tr>
                                </thead>
                                  <tbody>
                                      <tr>
                                          <td colspan="7" class="text-center py-4 text-muted">
                                          </td>
                                      </tr>
                                      <tr>
                                          <td colspan="7" class="text-center py-4 text-muted">
                                              No data available
                                          </td>
                                      </tr>
                                      <tr>
                                          <td colspan="7" class="text-center py-4 text-muted">
                                          </td>
                                      </tr>
                                  </tbody>
                            </table>
                        </div>

                        <div class="hide-div card">
                            <table id="table_hero" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th 
                                            colspan="6"
                                            style="font-weight: bold; font-family: 'Poppins', sans-serif; text-align: center;"
                                            class="tbl-title-header"
                                        >
                                            HERO SKU'S
                                        </th>
                                    </tr>
                                    <tr>
                                        <th class="tbl-title-field text-center">LMI/RGDI Code</th>
                                        <th class="tbl-title-field text-center">SKU</th>
                                        <th class="tbl-title-field text-center">SKU Name</th>
                                        <th class="tbl-title-field text-center">Item Class</th>
                                        <th class="tbl-title-field text-center">Ave Sales Unit</th>
                                        <th class="tbl-title-field text-center">SWC</th>
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
    let year = <?= json_encode($year); ?>;
    let months = <?= json_encode($months); ?>;
</script>
