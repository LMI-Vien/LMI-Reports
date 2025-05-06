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

                        <div class="ml-auto text-muted small" style="white-space: nowrap;">
                            <strong>Source:</strong> <?= !empty($source) ? $source : 'N/A'; ?> - <?= !empty($source_date) ? $source_date : 'N/A'; ?>

                        </div>
                    </div>
                <?php endif; ?>

                <div class="row mt-4">
                    <div class="col-md-12">
                      <div class="card p-4 shadow-lg text-center text-muted table-empty">
                          <i class="fas fa-filter mr-2"></i> Please select a filter
                      </div>
                        <div class="hide-div">
                        <div class="hide-div">
                            <table id="table_slowMoving" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th 
                                            colspan="3"
                                            style="font-weight: bold; font-family: 'Poppins', sans-serif; text-align: center;"
                                            class="tbl-title-header"
                                        >
                                            SLOW MOVING SKU'S
                                        </th>
                                    </tr>
                                    <tr>
                                        <th class="tbl-title-field">LMI/RGDI Code</th>
                                        <th class="tbl-title-field">SKU Name</th>
                                        <th class="tbl-title-field">Quantity</th>
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

                        <div class="hide-div">
                            <table id="table_overStock" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th 
                                            colspan="3"
                                            style="font-weight: bold; font-family: 'Poppins', sans-serif; text-align: center;"
                                            class="tbl-title-header"
                                        >
                                            OVERSTOCK SKU'S
                                        </th>
                                    </tr>
                                    <tr>
                                        <th class="tbl-title-field">LMI/RGDI Code</th>
                                        <th class="tbl-title-field">SKU Name</th>
                                        <th class="tbl-title-field">Quantity</th>
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

                        <div class="hide-div">
                            <table id="table_npd" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th 
                                            colspan="3"
                                            style="font-weight: bold; font-family: 'Poppins', sans-serif; text-align: center;"
                                            class="tbl-title-header"
                                        >
                                            NPD SKU'S
                                        </th>
                                    </tr>
                                    <tr>
                                        <th class="tbl-title-field">LMI/RGDI Code</th>
                                        <th class="tbl-title-field">SKU Name</th>
                                        <th class="tbl-title-field">Quantity</th>
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

                        <div class="hide-div">
                            <table id="table_hero" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th 
                                            colspan="2"
                                            style="font-weight: bold; font-family: 'Poppins', sans-serif; text-align: center;"
                                            class="tbl-title-header"
                                        >
                                            HERO SKU'S
                                        </th>
                                    </tr>
                                    <tr>
                                        <th class="tbl-title-field">LMI/RGDI Code</th>
                                        <th class="tbl-title-field">SKU Name</th>
                                    </tr>
                                </thead>
                                  <tbody>
                                      <tr>
                                          <td colspan="2" class="text-center py-4 text-muted">
                                          </td>
                                      </tr>
                                      <tr>
                                          <td colspan="2" class="text-center py-4 text-muted">
                                              No data available
                                          </td>
                                      </tr>
                                      <tr>
                                          <td colspan="2" class="text-center py-4 text-muted">
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

    let brand_ambassadors = <?= json_encode($brand_ambassador) ?>;
    let store_branch = <?= json_encode($store_branch) ?>;
    let brands = <?= json_encode($brands) ?>;

    function startTutorial() {
        introJs().start();
    }

    function startTutorial() {
        localStorage.setItem("TutorialMessage", "true");
        $('#popup_modal').modal('hide');
        introJs().start();
    }

    function closeTutorial() {
        localStorage.setItem("TutorialMessage", "false");
        $('#popup_modal').modal('hide');
    }

    $(document).ready(function() {
        // localStorage.setItem("TutorialMessage", "false");
        // localStorage.setItem("TutorialMessage", "true");

        if (localStorage.getItem("TutorialMessage") === "true") {
            $('#popup_modal').modal('show');
        } else {
            $('#popup_modal').modal('hide');
        }

        const tutorialSteps = [
            {
                id: 'step1',
                title: '<b>Welcome to the Dashboard Tutorial!</b>',
                intro: `This tutorial will guide you step by step on how to effectively navigate and utilize the features of this dashboard.
                Whether you're a new user or just need a quick refresher, you'll find this guide helpful for getting the most out of the tools available.`
            },
            {
                id: 'step2',
                title: '<b>Understanding the Filters Panel</b>',
                intro: `The Filters Panel is your control center for customizing the data shown on the dashboard.
                It lets you apply specific criteria to focus on what’s most relevant to you.<br><br>
                Here are two important buttons you'll find in the filters section:`
            },
            {
                id: 'step3',
                title: 'Clear Filters',
                intro: `This button resets all the filter selections back to their default state.
                Use this when you want to start fresh or remove all applied filters at once.
                It’s especially helpful if you've applied multiple filters and want to quickly go back to the original view.`
            },
            {
                id: 'step4',
                title: 'Refresh',
                intro: `After selecting or modifying your filters, click the Refresh button to update the dashboard.
                This action fetches the latest data that matches your filter settings and updates the tables accordingly.
                Make sure to hit Refresh after making changes, or your filters won't take effect.`
            },
            {
                id: 'step5',
                title: '<strong>REMINDER !!!</strong>',
                intro: `Always double-check your filters before hitting Refresh to ensure you’re pulling the correct data.`
            },
            {
                id: 'step6',
                title: '<b>Data Tables</b>',
                intro: `After the filters, you’ll find tables that update after you click the refresh button based on your selected filters.
                These tables present key metrics, trends, and detailed breakdowns in an organized and easy-to-read format.  
                Each column is sortable, and you may be able to export the data or drill down into specific rows for more insights.`
            },
            {
                id: 'step7',
                title: '<strong>Table Buttons</strong>',
                intro: `Each data table includes a set of buttons that give you quick access to additional actions. 
                These may include options to export data, copy table contents, or adjust the view. 
                Familiarizing yourself with these buttons helps you work more efficiently with the data presented.`
            },
            {
                id: 'ExportPDF',
                title: 'Export as PDF',
                intro: `Click this button to generate a PDF version of the current table view. 
                It’s a convenient way to save or share a snapshot of your data for reporting, documentation, or printing purposes. 
                The export will reflect any filters or sorting you’ve applied.`
            },
            {
                id: 'exportButton',
                title: 'Export as Excel',
                intro: `Use this button to export the table data to an Excel (.xlsx) file. 
                This is useful for performing deeper analysis, building reports, or keeping a local backup of your filtered results. 
                Like the PDF export, it respects the current filters and sorting selections.`
            }
        ];

        tutorialSteps.forEach((step, index) => {
            $(`#${step.id}`).attr({
                'data-title': step.title,
                'data-intro': step.intro,
                'data-step': (index + 1).toString()
            });
        });
    })

</script>
