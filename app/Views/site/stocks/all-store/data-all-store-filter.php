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
            <div class="p-2">

              <h6 class="text-white mb-3"><i class="fas fa-filter mr-2" style="color: #ffc107;"></i>FILTERS</h6>

                <div class="form-group">
                  <label for="ItemClass">Item Class</label>
                  <select id="ItemClass" name="ItemClass[]" class="form-control select2" multiple>
                    <option value="slowMoving">A</option>
                    <option value="overStock">Au</option>
                    <option value="npd">Bu</option>
                    <option value="hero">C</option>
                  </select>
                </div>

                <div class="form-group">
                    <label for="item_classi">Item Category</label>
                    <input type="text" class="form-control" id="item_classi" placeholder="Please select...">
                    <input type="hidden" id="item_classi_id">
                </div>

                <div class="form-group">
                  <label for="inventoryStatus">Inventory Status</label>
                  <select id="inventoryStatus" name="InventoryStatus[]" class="form-control select2" multiple>
                    <option value="slowMoving">Slow Moving</option>
                    <option value="overStock">Overstocks</option>
                    <option value="npd">NPD</option>
                    <option value="hero">Hero</option>
                  </select>
                </div>

                <div class="form-group">
                    <label for="item_classi">Vendor Name</label>
                    <input type="text" class="form-control" id="vendor_name" placeholder="Please select...">
                    <input type="hidden" id="vendor_name_id">
                </div>



              <!-- Buttons -->
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
        </li>

      </ul>
    </nav>
  </div>
</aside>
