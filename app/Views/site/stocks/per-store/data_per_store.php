<?php
    $dir = dirname(__FILE__);
    $minify = new \App\Libraries\MinifyLib();

    echo $minify->css($dir . '/assets/custom.css', 'Store Custom CSS');
    echo $minify->js($dir . '/assets/function.js', 'App Functions JS');
?>

<?= view("site/stocks/per-store/data_per_store_filter"); ?> 

<div class="wrapper">
    <div class="content-wrapper"
        id="step6" 
    >
        <div class="content">
            <div class="container-fluid py-4">
                <!-- Filters Section -->
                <?php if (isset($breadcrumb)): ?>
                    <div class="d-flex justify-content-between align-items-center mb-2"
                    id="step1" 
                    >
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
                        <div class="ml-auto p-3 rounded bg-light border shadow-sm small text-secondary" style="max-width: 550px;">
                            <div class="mb-2">
                                <i class="fas fa-database text-dark mr-1"></i> 
                                <strong>Source:</strong> <?= !empty($source) ? $source : 'N/A'; ?> - <?= !empty($source_date) ? $source_date : 'N/A'; ?>
                            </div>
                            <div class="mb-2">
                                <i class="fas fa-file-import text-dark mr-1"></i> 
                                <strong>Most Recent Import:</strong> Week: <?= !empty($latestWeek) ? $latestWeek : 'N/A'; ?> - 
                                <span id="mostRecentImportWeekRange"
                                    data-latest-week="<?= (int) $latestWeek ?>">
                                </span>
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
                        <div class="hide-div card">
                            <table id="table_slowMoving" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th 
                                            colspan="4"
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
                                        <th class="tbl-title-field text-center">Total Qty</th>
                                    </tr>
                                </thead>
                                  <tbody>
                                      <tr>
                                          <td colspan="4" class="text-center py-4 text-muted">
                                          </td>
                                      </tr>
                                      <tr>
                                          <td colspan="4" class="text-center py-4 text-muted">
                                              No data available
                                          </td>
                                      </tr>
                                      <tr>
                                          <td colspan="4" class="text-center py-4 text-muted">
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
                                            colspan="4"
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
                                        <th class="tbl-title-field text-center">Total Qty</th>
                                    </tr>
                                </thead>
                                  <tbody>
                                      <tr>
                                          <td colspan="4" class="text-center py-4 text-muted">
                                          </td>
                                      </tr>
                                      <tr>
                                          <td colspan="4" class="text-center py-4 text-muted">
                                              No data available
                                          </td>
                                      </tr>
                                      <tr>
                                          <td colspan="4" class="text-center py-4 text-muted">
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
                                            colspan="4"
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
                                        <th class="tbl-title-field text-center">Total Qty</th>
                                    </tr>
                                </thead>
                                  <tbody>
                                      <tr>
                                          <td colspan="4" class="text-center py-4 text-muted">
                                          </td>
                                      </tr>
                                      <tr>
                                          <td colspan="4" class="text-center py-4 text-muted">
                                              No data available
                                          </td>
                                      </tr>
                                      <tr>
                                          <td colspan="4" class="text-center py-4 text-muted">
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
                                            colspan="3"
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

        <!-- Tutorial Floating Modal -->
        <div class="modal fade" id="popup_modal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-sm"> 
                <div class="modal-content">
                    <!-- Header -->
                    <div class="modal-header">
                        <h5 class="modal-title"><b>Welcome to the BA Dashboard</b></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeTutorial()">
                            <span>&times;</span>
                        </button>
                    </div>
                    <!-- Body -->
                    <div class="modal-body text-center">
                        <p>Would you like to start the tutorial?</p>
                    </div>
                    <!-- Footer -->
                    <div class="modal-footer d-flex justify-content-between">
                        <button type="button" class="btn btn-primary" id="start_tutorial" onclick="startTutorial()" >Yes, Start</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="closeTutorial()" >No, Thanks</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intro.js/minified/introjs.min.css">
<script src="https://cdn.jsdelivr.net/npm/intro.js/minified/intro.min.js"></script>
<script>

    let brand_ambassadors = <?= json_encode($brand_ambassadors) ?>;
    let store_branch = <?= json_encode($store_branches) ?>;
    let brands = <?= json_encode($brands) ?>;
    let area = <?= json_encode($areas) ?>;
    let asc = <?= json_encode($asc) ?>;
    let calendarWeek = '<?= $date; ?>';
    brand_ambassadors.unshift(
        { id: "-6", name: "Non Ba" },
        { id: "-5", name: "Vacant" }
    )
</script>
