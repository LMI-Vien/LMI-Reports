<aside class="main-sidebar sidebar-dark-yellow elevation-4">
<!-- Brand -->
<a href="<?= base_url() ?>" class="brand-link d-flex align-items-center" style="height: 56px; text-decoration: none !important;">

  <img src="<?= base_url('assets/img/lmi_logo.png') ?>" alt="Logo" style="height: 32px; margin-left: 10px; margin-right: 10px;">
  
  <span class="brand-text font-weight-light full-title">LifeStrong SFA</span>
</a>


<!-- Sidebar Content -->
<div class="sidebar">
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" role="menu" data-accordion="false">

<!-- Filter Section -->
<li class="nav-item filter-hover">

    <div class="filter-content">
        <div>
            <div style="margin-left: -5px;">
                <div class="form-group">
                     <h6 class="text-white mt-3 mb-2"><i class="fas fa-filter mr-2" style="color: #ffc107;"></i>FILTERS</h6>
                </div>
                <div class="form-group">
                    <label for="brand_ambassadors">Area</label>
                    <input type="text" class="form-control" id="area" placeholder="Please select...">
                    <input type="hidden" id="area_id">
                </div>
                <div class="form-group">
                    <label for="brand_ambassadors">Area Sales Coordinator</label>
                    <input type="text" class="form-control" id="asc_name" placeholder="Please select...">
                    <input type="hidden" id="asc_name_id">
                </div>
                <!-- Filter by Type -->
                <div class="form-group">
                <label>BA Type</label>
                    <div class="btn-group btn-group-toggle d-flex flex-wrap" data-toggle="buttons">
                      <label class="btn btn-outline-light btn-sm active">
                        <input type="radio" name="filterType" value="3" checked> All
                      </label>
                      <label class="btn btn-outline-light btn-sm">
                        <input type="radio" name="filterType" value="1"> Outright
                      </label>
                      <label class="btn btn-outline-light btn-sm">
                        <input type="radio" name="filterType" value="0"> Consignment
                      </label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="brand_ambassadors">Brand Ambassador</label>
                    <input type="text" class="form-control" id="brand_ambassadors" placeholder="Please select...">
                    <input type="hidden" id="ba_id">
                </div>
                <!-- Store Name -->
                <div class="form-group">
                    <label for="store_branch">Store Name</label>
                    <input type="text" class="form-control" id="store_branch" placeholder="Please select...">
                    <input type="hidden" id="store_id">
                </div>
                <div class="form-group">
                    <label for="store_branch">Brand Label Type</label>
                    <input type="text" class="form-control" id="store_branch" placeholder="Please select...">
                    <input type="hidden" id="store_id">
                </div>
                <!-- Brand -->
                <div class="form-group">
                    <label for="brand">Item Brand</label>
                    <input type="text" class="form-control" id="brand" placeholder="Please select...">
                    <input type="hidden" id="brand_id">
                </div>
                <div class="form-group">
                    <label for="brand">Year</label>
                    <input type="text" class="form-control" id="brand" placeholder="Please select...">
                    <input type="hidden" id="brand_id">
                </div>
                <div class="form-group">
                    <label for="brand">Month From</label>
                    <input type="text" class="form-control" id="brand" placeholder="Please select...">
                    <input type="hidden" id="brand_id">
                </div>
                <div class="form-group">
                    <label for="brand">Month To</label>
                    <input type="text" class="form-control" id="brand" placeholder="Please select...">
                    <input type="hidden" id="brand_id">
                </div>
                <!-- Buttons -->
                <div class="form-group">
                  <div class="row">
                    <!-- Row 1: Refresh + Clear -->
                    <div class="col-6 mb-2">
                      <button class="btn btn-primary btn-block btn-sm"
                              id="ExportPDF"
                              data-title="Step 5: Exporting the Report (PDF)"
                              data-intro="Paki palitan to haha"
                              data-step="10"
                              onclick="handleAction('export_pdf')">
                        <i class="fas fa-file-export"></i> PDF
                      </button>                      
                    </div>
                    <div class="col-6 mb-2">
                      <button type="button" class="btn btn-primary btn-block btn-sm" id="refreshButton">
                        <i class="fas fa-sync-alt"></i> Refresh
                      </button>
                    </div>

                    <!-- Row 2: PDF + Excel -->
                    <div class="col-6 mb-2">
                      <button class="btn btn-success btn-block btn-sm"
                              id="exportButton"
                              data-title="Step 6: Exporting the Report (Excel)"
                              data-intro="Once satisfied with the report:<br><br>Click the Export button.<br>Choose between PDF or Excel format.<br>The file will be generated and downloaded to your device.<br><br><small>Tip: Use PDF for sharing and Excel for further data analysis.</small><br><br>Click Next"
                              data-step="11"
                              onclick="handleAction('export_excel')">
                        <i class="fas fa-file-export"></i> Excel
                      </button>
                    </div>
                    <div class="col-6 mb-2">
                        <button type="button" class="btn btn-secondary btn-block btn-sm" id="clearButton">
                           <i class="fas fa-sync-alt"></i> Clear
                        </button>
                    </div>
                  </div>
                </div>

            </div>
        </div>
    </div>
</li>
</ul>
</nav>
</div>

</aside>


