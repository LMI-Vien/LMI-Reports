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
              <div style="text-align: center;">
                <h6 class="text-white mt-3 mb-2"><i class="fas fa-filter mr-2" style="color: #ffc107;"></i>FILTERS</h6>
              </div>

              <div class="form-group">
                <label for="itemClass">Item Class</label>
                <select id="itemClass" name="itemClass[]" class="form-control select2" multiple>
                  <input type="hidden" id="itemClassId">
                </select>
              </div>

              <div class="form-group">
                <label for="itemLabel">Item Category</label>
                <input type="text" class="form-control" id="itemLabel" placeholder="Please select...">
                <input type="hidden" id="itemLabelId">
              </div>

              <div class="form-group">
                <label for="inventoryStatus">Inventory Status</label>
                <select id="inventoryStatus" name="inventoryStatus[]" class="form-control select2" multiple>
                  <option value="slowMoving">Slow Moving</option>
                  <option value="overStock">Overstocks</option>
                  <option value="npd">NPD</option>
                  <option value="hero">Hero</option>
                </select>
              </div>

              <div class="form-group">
                <label for="vendorName">Vendor Name</label>
                <input type="text" class="form-control" id="vendorName" placeholder="Please select...">
                <input type="hidden" id="vendorNameId">
              </div>

              <!-- Buttons -->
              <div class="form-group">
                <div class="row">
                  <div class="col-6 mb-2">
                    <button type="button" class="btn btn-secondary btn-block btn-sm" id="clearButton">
                      <i class="fas fa-sync-alt"></i> Clear
                    </button>
                  </div>
                  <div class="col-6 mb-2">
                    <button type="button" class="btn btn-primary btn-block btn-sm" id="refreshButton">
                      <i class="fas fa-sync-alt"></i> Refresh
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
