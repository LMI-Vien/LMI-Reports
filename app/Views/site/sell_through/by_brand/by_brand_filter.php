<style>
  #additionalFiltersPanel {
    position: fixed;
    top: 80px; /* below navbar */
    left: -490px; /* hidden initially */
    width: 470px;
    background-color: #301311 !important;
    /*color: #fff;*/
    border-radius: 5px;
    z-index: 1051;
    box-shadow: 2px 2px 10px rgba(0,0,0,0.3);
    transition: left 0.3s ease;
    max-height: 90vh; /* optional max height */
    overflow-y: auto;
  }

  #additionalFiltersPanel.open {
    left: 260px; /* reveals the panel just next to sidebar (default sidebar width = 250px) */
  }

  #additionalFiltersPanel label {
    /*color: #fff;*/
    font-weight: 500;
  }

  #additionalFiltersPanel select,
  #additionalFiltersPanel .form-control {
  background-color: #fff;
    /*color: #fff;*/
    border: 1px solid #6c757d;
  }

  #additionalFiltersPanel .btn {
    color: white;
  }

@media (max-width: 767.98px) {
  #additionalFiltersPanel {
    width: 67vw;
    left: -67vw;
    top: 56px; /* Adjust if you have a mobile navbar */
    height: calc(100vh - 56px);
    max-height: none;
    border-radius: 0;
  }

  #additionalFiltersPanel.open {
    left: 0;
  }
}
</style>
<aside class="main-sidebar sidebar-dark-yellow elevation-4">
  <!-- Brand -->
  <a href="<?= base_url() ?>" class="brand-link d-flex align-items-center" style="height: 56px; text-decoration: none !important;">
    <img src="<?= base_url('assets/img/lmi_logo.png') ?>" alt="Logo" style="height: 32px; margin-left: 10px; margin-right: 10px;">
    <span class="brand-text font-weight-light full-title">LifeStrong SFA</span>
  </a>

  <!-- Sidebar Content -->
  <div class="sidebar">
    <nav>
    <!-- <nav class="mt-2"> -->
      <ul class="nav nav-pills nav-sidebar flex-column" role="menu" data-accordion="false">

        <!-- Filter Section -->
        <li class="nav-item filter-hover">
          <div class="filter-content">
            <div>
              <div style="text-align: center;">
                <h6 class="text-white mb-3"><i class="fas fa-filter mr-2" style="color: #ffc107;"></i>FILTERS</h6>
              </div>

              <div class="form-group card-dark mb-3 p-2">
                <label for="dataSource" class="mb-2"><i class="fas fa-database mr-1"></i> Data Source</label>
                <select id="dataSource" class="form-select">
                  <option value="2">Scanned Data</option>
                  <option value="3">WEEK on WEEK Sales (Sell Out)</option>
                  <option value="4">Winsight</option>
                </select>
              </div>

              <!-- Qty / Amount -->
              <div class="form-group card-dark mb-3 p-2">
                <label class="mb-2">
                  <i class="fas fa-chart-bar mr-1"></i> Measure
                </label>
                <div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="measure" id="measureQty" value="qty" checked>
                    <label class="form-check-label" for="measureQty">Qty</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="measure" id="measureAmount" value="amount">
                    <label class="form-check-label" for="measureAmount">Amount</label>
                  </div>
                </div>
              </div>

              <div class="form-group text-center">
                <button id="toggleAdditionalFilters" type="button" class="btn btn-sm btn-outline-warning w-100">
                  <i class="fas fa-angle-double-right mr-1"></i> More Filters
                </button>
              </div>

              <!-- <div id="additionalFilters" style="display: none;"> -->
              <div id="additionalFiltersPanel" class="card">
                <div class="filter-header d-flex justify-content-between align-items-center p-2 text-white">
                  <h6 class="mb-0"><i class="fas fa-sliders-h mr-2"></i> Additional Filters</h6>
                  <button id="closeAdditionalFilters" class="btn btn-sm btn-outline-light">
                    <i class="fas fa-times"></i>
                  </button>
                </div>

                <div class="filter-body text-white p-3">
                  <div class="row">
                    <!-- Year -->
                    <div class="col-12 col-md-6 mb-3">
                      <div class="form-group card-dark mb-3 p-2">
                        <label for="year"><i class="fas fa-calendar-alt mr-1"></i> Year</label>
                        <select class="form-control" id="year">
                          <?php if ($year): foreach ($year as $value): ?>
                            <option value="<?= $value['year'] ?>"><?= $value['year'] ?></option>
                          <?php endforeach; endif; ?>
                        </select>
                      </div>
                    </div>

                    <!-- Quarter -->
                    <div class="col-12 col-md-6 mb-3">
                      <div class="form-group card-dark mb-3 p-2">
                        <label for="quarter"><i class="fas fa-calendar-alt mr-1"></i> Quarter</label>
                        <select class="form-control" id="quarter">
                          <option value="">Please select...</option>
                          <option value="1">First</option>
                          <option value="2">Second</option>
                          <option value="3">Third</option>
                          <option value="4">Fourth</option>
                        </select>
                      </div>
                    </div>

                    <!-- Month From -->
                    <div class="col-12 col-md-6 mb-3">
                      <div class="form-group card-dark mb-3 p-2">
                        <label for="monthFrom"><i class="fas fa-calendar-alt mr-1"></i> Month From</label>
                        <select class="form-control" id="monthFrom">
                          <option value="">Please select...</option>
                          <?php if ($months): foreach ($months as $value): ?>
                            <option value="<?= $value['id'] ?>"><?= $value['month'] ?></option>
                          <?php endforeach; endif; ?>
                        </select>
                      </div>
                    </div>

                    <!-- Month To -->
                    <div class="col-12 col-md-6 mb-3">
                      <div class="form-group card-dark mb-3 p-2">
                        <label for="monthTo"><i class="fas fa-calendar-alt mr-1"></i> Month To</label>
                        <select class="form-control" id="monthTo">
                          <option value="">Please select...</option>
                          <?php if ($months): foreach ($months as $value): ?>
                            <option value="<?= $value['id'] ?>"><?= $value['month'] ?></option>
                          <?php endforeach; endif; ?>
                        </select>
                      </div>
                    </div>

                    <!-- YTD -->
                    <div class="col-12 col-md-6 mb-3">
                      <div class="form-group card-dark mb-3 p-2">
                        <label><i class="fas fa-chart-bar mr-1"></i> YTD  </label>
                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="ytd" id="ytdYes" value="yes" checked>
                          <label class="form-check-label" for="ytdYes">Yes</label>
                        </div>
                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="ytd" id="ytdNo" value="no">
                          <label class="form-check-label" for="ytdNo">No</label>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>  

              <div class="form-group card-dark mb-3 p-2">
                  <label for="brand" class="mb-2"><i class="fas fa-briefcase mr-1"></i> Brand</label>
                  <select id="brands" name="brands[]" class="form-control select2" multiple>
                      <?php foreach ($brands as $key => $value) {
                          echo '<option value="' . htmlspecialchars($value['id']) . '">' . htmlspecialchars($value['brand_description']) . '</option>';
                      } ?>
                  </select>
              </div>

              <div class="form-group card-dark mb-3 p-2">
                  <label for="itemLabel" class="mb-2"><i class="fas fa-briefcase mr-1"></i> Choose Label Type</label>
                      <select id="itemLabel" name="itemLabel[]" class="form-control select2" multiple>
                          <?php foreach ($brandLabel as $key => $value) {
                              echo '<option value="' . htmlspecialchars($value['id']) . '">' . htmlspecialchars($value['label']) . '</option>';
                          } ?>
                      </select>
              </div>

              <div class="form-group card-dark mb-3 p-2">
                  <label for="itemLabel" class="mb-2"><i class="fas fa-briefcase mr-1"></i> Choose Sales Group</label>
                      <select id="itemLabel" name="itemLabel[]" class="form-control select2" multiple>
                          <?php foreach ($brandLabel as $key => $value) {
                              echo '<option value="' . htmlspecialchars($value['id']) . '">' . htmlspecialchars($value['label']) . '</option>';
                          } ?>
                      </select>
              </div>

              <div class="form-group card-dark mb-3 p-2">
                  <label class="mb-2"><i class="fas fa-tags mr-1"></i> BA Type</label>
                  <!-- <div class="btn-group btn-group-toggle d-flex flex-wrap" data-toggle="buttons"> -->
                  <div class="btn-group btn-group-toggle d-flex flex-wrap gap-2" data-toggle="buttons">
                      <label class="btn btn-outline-light btn-sm active main_all">
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

              <!-- Buttons -->
              <div class="form-group">
                <div class="row g-2">
                  <div class="col-12 col-md-6">
                    <button type="button" class="btn btn-secondary w-100 btn-sm" id="clearButton">
                      <i class="fas fa-sync-alt"></i> Clear
                    </button>
                  </div>
                  <div class="col-12 col-md-6" style="margin-bottom: 60px;">
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
