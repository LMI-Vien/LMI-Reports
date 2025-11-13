<?php
    $dir = dirname(__FILE__);
    $minify = new \App\Libraries\MinifyLib();

    echo $minify->css($dir . '/assets/custom.css', 'Store Custom CSS');
    echo $minify->js($dir . '/assets/function.js', 'App Functions JS');
?>

<?= view("site/promo_analysis/promo_table/promo_table_filter"); ?> 

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
                                <strong>Source:</strong><span id="source"> <?= !empty($source) ? $source : 'N/A'; ?></span> - <?= !empty($source_date) ? $source_date : 'N/A'; ?>
                            </div>
                            <div>
                                <i class="fas fa-calendar-week text-dark mr-1"></i>
                                <strong>Current Week:</strong> 
                                <span id="currentWeek" class="text-dark font-weight-medium"></span>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="row mt-4">
                    <div class="col-md-12">

                        <div class="card p-4 shadow-lg text-center text-muted table-empty">
                          <i class="fas fa-filter mr-2"></i> Please select a filter
                        </div>

                        <div class="card mt-4 p-4 shadow-sm hide-div">
                            <div id="tableContainer" class="mb-3">
                                <table id="PromoAnalysis" class="table table-bordered" style="width: 100% !important;">
                                    

                                    <colgroup>
                                        <col style="width:10%;">
                                        <col style="width:20%;">
                                        <col style="width:10%;">
                                        <col style="width:10%;">
                                        <col style="width:15%;">
                                        <col style="width:10%;">
                                        <col style="width:10%;">
                                        <col style="width:15%;">
                                    </colgroup>
                                    <thead>
                                        <tr>

                                            <th 
                                                colspan="2"
                                                style="font-weight: bold; font-family: 'Poppins', sans-serif; text-align: center; background-color: #301311 !important;"
                                                class="static-header"
                                            >
                                            PROMO TABLE
                                            </th>
                                            <th 
                                                colspan="3"
                                                style="font-weight: bold; font-family: 'Poppins', sans-serif; text-align: center; background-color: #ffc107 !important; color: #000000 !important;"
                                                class="static-header"
                                            >
                                                AVERAGE DAILY VOLUME (ADV)
                                            </th>
                                            <th 
                                                colspan="3"
                                                style="font-weight: bold; font-family: 'Poppins', sans-serif; text-align: center; background-color: #ffc107 !important; color: #000000 !important;"
                                                class="static-header"
                                            >
                                                AVERAGE DAILY SALES (ADS)
                                            </th>
                                        </tr>
                                        <tr>
                                            <th class="tbl-title-field text-center">SKU</th>
                                            <th class="tbl-title-field text-center">VARIANT</th>
                                            <th class="tbl-title-field text-center">PRE <span class="preWeekDays"> </span> <span class="preWeek">(W)</span></th>
                                            <th class="tbl-title-field text-center">POST <span class="postWeekDays"> </span> <span class="postWeek">(W)</span></th>
                                            <th class="tbl-title-field text-center">POST <span class="postWeekDays"> </span> vs PRE <span class="preWeekDays"> </span>
                                                <span class="tooltip-text">
                                                    FORMULA:
                                                    <br>
                                                    (ADV POST – ADV PRE / ADV PRE) * 100    
                                                </span>
                                            </th>
                                            <th class="tbl-title-field text-center">PRE <span class="preMonthDays"> </span> <span class="preMonth">(M)</span></th>
                                            <th class="tbl-title-field text-center">POST <span class="postMonthDays"> </span> <span class="postMonth">(M)</span></th>
                                            <th class="tbl-title-field text-center">POST <span class="postMonthDays"> </span> vs PRE <span class="preMonthDays"> </span>
                                                <span class="tooltip-text">
                                                    FORMULA:
                                                    <br>
                                                    (ADS POST – ADS PRE / ADS PRE) * 100
                                                </span>
                                            </th>
                                        </tr>
                                    </thead>
                                      <tbody>
                                          <tr>
                                              <td colspan="8" class="text-center py-4 text-muted">
                                              </td>
                                          </tr>
                                          <tr>
                                              <td colspan="8" class="text-center py-4 text-muted">
                                                  No data available
                                              </td>
                                          </tr>
                                          <tr>
                                              <td colspan="8" class="text-center py-4 text-muted">
                                              </td>
                                          </tr>
                                      </tbody>
                                        <tfoot>
                                        <tr>
                                          <th colspan="2" style="text-align:right">Total:</th>
                                          <th></th>
                                          <th></th>
                                          <th></th>
                                          <th></th>
                                          <th></th>
                                          <th></th>
                                        </tr>
                                      </tfoot>
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
    </div>
</div>

<script>
    let year = <?= json_encode($year); ?>;
    let months = <?= json_encode($months); ?>;
</script>
