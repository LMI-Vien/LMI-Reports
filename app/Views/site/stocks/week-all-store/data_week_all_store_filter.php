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
                  <label for="itemClass" class="mb-2">
                    <i class="fas fa-cubes mr-1"></i> Item Class
                  </label>
                  <select id="itemClass" name="itemClass[]" class="form-control select2" multiple>
                  </select>
                </div>

                <div class="form-group card-dark mb-3 p-2">
                  <label for="itemLabelCat" class="mb-2">
                    <i class="fas fa-tags mr-1"></i> Item Category
                  </label>
                  <input type="text" class="form-control" id="itemLabelCat" placeholder="Please select...">
                  <input type="hidden" id="itemLabelCatId">
                </div>

                <div class="form-group card-dark mb-3 p-2">
                  <label for="inventoryStatus" class="mb-2">
                    <i class="fas fa-warehouse mr-1"></i> Inventory Status
                  </label>
                  <select id="inventoryStatus" name="inventoryStatus[]" class="form-control select2" multiple>
                    <option value="slowMoving" title="Items that are not selling quickly">Slow Moving</option>
                    <option value="overStock" title="Items with excessive stock levels">Overstocks</option>
                    <option value="npd" title="New product development items">NPD</option>
                    <option value="hero" title="Top-selling or flagship products">Hero</option>
                  </select>
                </div>
                <div class="form-group card-dark mb-3 p-2">
                  <label for="year" class="mb-2 form-label"><i class="fas fa-calendar-alt mr-1"></i> Year</label>
                  <select id="year" class="form-select">
                  </select>
                </div>

                <div class="form-group card-dark mb-3 p-2">
                  <label for="week_from" class="mb-2"><i class="fas fa-calendar-alt mr-1"></i> Week From</label>
                  <select id="week_from" class="form-select" onfocus="updateWeeks('week_from')">
                  </select>
                </div>

                <div class="form-group card-dark mb-3 p-2">
                <label for="week_to" class="mb-2"><i class="fas fa-calendar-alt mr-1"></i> Week To</label>
                  <select id="week_to" class="form-select" onfocus="updateWeeks('week_to')">
                  </select>
                </div>

                <div class="form-group card-dark mb-3 p-2">
                  <label for="dataSource" class="mb-2"><i class="fas fa-database mr-1"></i> Data Source</label>
                  <select id="dataSource" class="form-select">
                    <option value="2">VMI (Sell Out)</option>
                    <option value="3">WEEK on WEEK Sales (Sell In)</option>
                  </select>
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