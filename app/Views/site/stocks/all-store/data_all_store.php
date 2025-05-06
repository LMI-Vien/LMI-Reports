<?php
    $dir = dirname(__FILE__);
    $minify = new \App\Libraries\MinifyLib();

    echo $minify->css($dir . '/assets/custom.css', 'Store Custom CSS');
    echo $minify->js($dir . '/assets/function.js', 'App Functions JS');
?>

<?= view("site/stocks/all-store/data_all_store_filter"); ?> 

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
                <!-- filter-->
                <!-- DataTables Section -->
                <div class="row mt-4"><!-- use mt-4 or define mt-12 in custom CSS -->
                    <div class="col-md-12">
                        <div class="card p-4 shadow-lg text-center text-muted table-empty">
                          <i class="fas fa-filter mr-2"></i> Please select a filter
                        </div>

                        <div class="card mt-4 p-4 shadow-sm hide-div">
                            <table id="table_data_all_store" class="table table-bordered table-responsive">
                                <thead>
                                    <tr>
                                        <th 
                                            colspan="6"
                                            style="font-weight: bold; font-family: 'Poppins', sans-serif; text-align: center;"
                                            class="tbl-title-header"
                                        >
                                            <?= $pageName;?>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th class="tbl-title-field">SKU</th>
                                        <th class="tbl-title-field">SKU Name</th>
                                        <th class="tbl-title-field">Item Class</th>
                                        <th class="tbl-title-field">Total Qty</th>
                                        <th class="tbl-title-field">Ave Sales Unit</th>
                                        <th class="tbl-title-field">SWC</th>
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
    </div>
</div>

<script>

    let ba = <?= json_encode($brandAmbassador); ?>;
    let area = <?= json_encode($area); ?>;
    let brand = <?= json_encode($brand); ?>;
    let store = <?= json_encode($store_branch); ?>;
    let itemClassi = <?= json_encode($itemClassi); ?>;
    let company = <?= json_encode($company); ?>;
    let brandLabel = <?= json_encode($brandLabel); ?>;

</script>
