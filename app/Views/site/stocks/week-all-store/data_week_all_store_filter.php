<aside class="main-sidebar sidebar-dark-yellow elevation-4">
  <!-- Brand -->
  <a href="<?= base_url() ?>" class="brand-link d-flex align-items-center" style="height: 56px; text-decoration: none !important;">
    <img src="<?= base_url('assets/img/lmi_logo.png') ?>" alt="Logo" style="height: 32px; margin-left: 10px; margin-right: 10px;">
    <span class="brand-text font-weight-light full-title">LifeStrong SFA</span>
  </a>

  <!-- Sidebar Content -->
  <div class="sidebar">
    <nav>
      <ul class="nav nav-pills nav-sidebar flex-column" role="menu" data-accordion="false">

        <!-- Filter Section -->
        <li class="nav-item filter-hover">
          <div class="filter-content">
            <div>
                <div style="text-align: center;">
                  <h6 class="text-white mb-2"><i class="fas fa-filter mr-2" style="color: #ffc107;"></i>FILTERS</h6>
                </div>
                <div class="form-group card-dark mb-3 p-2">
                  <label for="ItemClass" class="mb-2">
                    <i class="fas fa-cubes mr-1"></i> Item Class
                  </label>
                  <select id="ItemClass" name="ItemClass[]" class="form-control select2" multiple>
                    <option value="slowMoving">A</option>
                    <option value="overStock">Au</option>
                    <option value="npd">Bu</option>
                    <option value="hero">C</option>
                  </select>
                </div>

                <div class="form-group card-dark mb-3 p-2">
                  <label for="item_classi" class="mb-2">
                    <i class="fas fa-tags mr-1"></i> Item Category
                  </label>
                  <input type="text" class="form-control" id="item_classi" placeholder="Please select...">
                  <input type="hidden" id="item_classi_id">
                </div>

                <div class="form-group card-dark mb-3 p-2">
                  <label for="inventoryStatus" class="mb-2">
                    <i class="fas fa-warehouse mr-1"></i> Inventory Status
                  </label>
                  <select id="inventoryStatus" name="InventoryStatus[]" class="form-control select2" multiple>
                    <option value="slowMoving">Slow Moving</option>
                    <option value="overStock">Overstocks</option>
                    <option value="npd">NPD</option>
                    <option value="hero">Hero</option>
                  </select>
                </div>

                <div class="form-group card-dark mb-3 p-2">
                  <label for="year" class="mb-2 form-label"><i class="fas fa-calendar-alt mr-1"></i> Year</label>
                  <select id="year" class="form-select">
                  </select>
                  <input type="hidden" id="year">
                </div>

                <div class="form-group card-dark mb-3 p-2">
                  <label for="week_from" class="mb-2"><i class="fas fa-calendar-alt mr-1"></i> Week From</label>
                  <select id="week_from" class="form-select" onfocus="updateWeeks('week_from')">
                  </select>
                  <input type="hidden" id="vendor_name_id">
                </div>

                <div class="form-group card-dark mb-3 p-2">
                <label for="week_to" class="mb-2"><i class="fas fa-calendar-alt mr-1"></i> Week To</label>
                  <select id="week_to" class="form-select" onfocus="updateWeeks('week_to')">
                  </select>
                  <input type="hidden" id="vendor_name_id">
                </div>

                <div class="form-group card-dark mb-3 p-2">
                  <label for="data_source" class="mb-2"><i class="fas fa-database mr-1"></i> Data Source</label>
                  <input type="text" class="form-control" id="vendor_name" placeholder="Please select...">
                  <input type="hidden" id="vendor_name_id">
                </div>

                <!-- Buttons -->
                <div class="form-group">
                    <div class="row g-2">
                    <div class="col-12 col-md-6">
                        <button type="button" class="btn btn-secondary w-100 btn-sm" id="clearButton">
                        <i class="fas fa-sync-alt"></i> Clear
                        </button>
                    </div>
                    <div class="col-12 col-md-6">
                        <button type="button" class="btn btn-primary w-100 btn-sm" id="refreshButton">
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

<script>
  let years = <?php echo json_encode($year); ?>;
  
  $(document).ready(function() {
    // look at app\Views\site\stocks\week-all-store\assets\function.js
    populateDropdown('year', years, 'year', 'id')
  })
</script>