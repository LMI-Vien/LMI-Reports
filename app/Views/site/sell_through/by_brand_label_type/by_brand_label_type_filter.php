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
                <label for="dataSource" class="mb-2">
                  <i class="fas fa-database mr-1"></i> Data Source
                </label>
                <select id="dataSource" name="dataSource" class="form-control">
                  <option value="">-- Select Data Source --</option>
                  <option value="sales">Sales</option>
                  <option value="inventory">Inventory</option>
                  <option value="returns">Returns</option>
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

              <div class="form-group card-dark mb-3 p-2">
                  <label for="year" class="mb-2 form-label"><i class="fas fa-calendar-alt mr-1"></i> Year</label>
                  <select class="form-control" id="year">
                      <?php
                          if($year){
                              foreach ($year as $value) {
                                  echo "<option value=".$value['year'].">".$value['year']."</option>";
                              }                                                
                          }
                      ?>
                  </select>
              </div>

              <div class="form-group card-dark mb-3 p-2">
                  <label for="month" class="mb-2 form-label"><i class="fas fa-calendar-alt mr-1"></i> Quarter</label>
                  <select class="form-control" id="month">
                      <option value="">Please select..</option>
                      <?php
                          if($months){
                              foreach ($months as $value) {
                                  echo "<option value=".$value['id'].">".$value['month']."</option>";
                              }                                                
                          }
                      ?>
                  </select>
              </div>

              <div class="form-group card-dark mb-3 p-2">
                  <label for="month" class="mb-2 form-label"><i class="fas fa-calendar-alt mr-1"></i> Month From</label>
                  <select class="form-control" id="month">
                      <option value="">Please select..</option>
                      <?php
                          if($months){
                              foreach ($months as $value) {
                                  echo "<option value=".$value['id'].">".$value['month']."</option>";
                              }                                                
                          }
                      ?>
                  </select>
              </div>

              <div class="form-group card-dark mb-3 p-2">
                  <label for="monthTo" class="mb-2 form-label"><i class="fas fa-calendar-alt mr-1"></i> Month To</label>
                  <select class="form-control" id="monthTo">
                      <option value="">Please select..</option>
                      <?php
                          if($months){
                              foreach ($months as $value) {
                                  echo "<option value=".$value['id'].">".$value['month']."</option>";
                              }                                                
                          }
                      ?>
                  </select>
              </div>

              <div class="form-group card-dark mb-3 p-2">
                <label class="mb-2">
                  <i class="fas fa-chart-bar mr-1"></i> YTD
                </label>
                <div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="measure" id="measureQty" value="qty" checked>
                    <label class="form-check-label" for="measureQty">Yes</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="measure" id="measureAmount" value="amount">
                    <label class="form-check-label" for="measureAmount">No</label>
                  </div>
                </div>
              </div>

              <div class="form-group card-dark mb-3 p-2">
                  <label for="brand" class="mb-2"><i class="fas fa-briefcase mr-1"></i> Item Brand</label>
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
