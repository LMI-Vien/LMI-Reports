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
    max-height: 90vh; 
    overflow-y: auto;
  }

  #additionalFiltersPanel.open {
    left: 260px;
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
    top: 56px; 
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

  <div class="sidebar">
    <nav>
 
      <ul class="nav nav-pills nav-sidebar flex-column" role="menu" data-accordion="false">

        <li class="nav-item filter-hover">
          <div class="filter-content">
            <div>
              <div style="text-align: center;">
                <h6 class="text-white mb-3"><i class="fas fa-filter mr-2" style="color: #ffc107;"></i>FILTERS</h6>
              </div>

              <div class="form-group text-center">
                <button id="toggleAdditionalFilters" type="button" class="btn btn-sm btn-outline-warning w-100">
                  <i class="fas fa-angle-double-right mr-1"></i> More Filters
                </button>
              </div>

              <div id="additionalFiltersPanel" class="card">
                <div class="filter-header d-flex justify-content-between align-items-center p-2 text-white">
                  <h6 class="mb-0"><i class="fas fa-sliders-h mr-2"></i> Additional Filters</h6>
                  <button id="closeAdditionalFilters" class="btn btn-sm btn-outline-light">
                    <i class="fas fa-times"></i>
                  </button>
                </div>

                <div class="filter-body text-white p-3">
                  <div class="row">

                    <div class="col-12 col-md-12 mb-3">
                      <div class="form-group card-dark mb-3 p-2">
                        <label for="year"><i class="fas fa-calendar-alt mr-1"></i> Year</label>
                        <select class="form-control" id="year">
                          <option value="">Please select...</option>
                          <?php if ($year): foreach ($year as $value): ?>
                            <option value="<?= $value['year'] ?>" data-year="<?= $value['id'] ?>"><?= $value['year'] ?></option>
                          <?php endforeach; endif; ?>
                        </select>
                      </div>
                    </div>

                    <div class="col-12 card-dark mb-3 p-2">
                      <h6 class="text-warning mb-3"><i class="fas fa-database mr-1"></i> Scanned Data Pre Period</h6>
                      <div class="row">
                        <div class="col-12 col-md-6 mb-3">
                          <label for="monthFromPre"><i class="fas fa-calendar-alt mr-1"></i> Month From</label>
                          <select class="form-control" id="monthFromPre">
                            <option value="">Please select...</option>
                            <?php if ($months): foreach ($months as $value): ?>
                              <option value="<?= $value['id'] ?>"><?= $value['month'] ?></option>
                            <?php endforeach; endif; ?>
                          </select>
                        </div>
                        <div class="col-12 col-md-6 mb-3">
                          <label for="monthToPre"><i class="fas fa-calendar-alt mr-1"></i> Month To</label>
                          <select class="form-control" id="monthToPre">
                            <option value="">Please select...</option>
                            <?php if ($months): foreach ($months as $value): ?>
                              <option value="<?= $value['id'] ?>"><?= $value['month'] ?></option>
                            <?php endforeach; endif; ?>
                          </select>
                        </div>
                      </div>
                    
                      <h6 class="text-warning mb-3"><i class="fas fa-database mr-1"></i> Scanned Data Post Period</h6>
                      <div class="row">
                        <div class="col-12 col-md-6 mb-3">
                          <label for="monthFromPost"><i class="fas fa-calendar-alt mr-1"></i> Month From</label>
                          <select class="form-control" id="monthFromPost">
                            <option value="">Please select...</option>
                            <?php if ($months): foreach ($months as $value): ?>
                              <option value="<?= $value['id'] ?>"><?= $value['month'] ?></option>
                            <?php endforeach; endif; ?>
                          </select>
                        </div>
                        <div class="col-12 col-md-6 mb-3">
                          <label for="monthToPost"><i class="fas fa-calendar-alt mr-1"></i> Month To</label>
                          <select class="form-control" id="monthToPost">
                            <option value="">Please select...</option>
                            <?php if ($months): foreach ($months as $value): ?>
                              <option value="<?= $value['id'] ?>"><?= $value['month'] ?></option>
                            <?php endforeach; endif; ?>
                          </select>
                        </div>
                      </div>
                    </div>

                    <div class="col-12 card-dark mb-3 p-2">
                      <h6 class="text-warning mb-3"><i class="fas fa-clipboard-list mr-1"></i> VMI Pre Period</h6>
                      <div class="row">
                        <div class="col-12 col-md-6 mb-3">
                          <label for="weekfromPre" class="mb-2"><i class="fas fa-calendar-week mr-1"></i> Week From</label>
                          <select id="weekfromPre" class="form-select" onfocus="updateWeeks('weekfromPre')"></select>
                        </div>
                        <div class="col-12 col-md-6 mb-3">
                          <label for="weektoPre" class="mb-2"><i class="fas fa-calendar-week mr-1"></i> Week To</label>
                          <select id="weektoPre" class="form-select" onfocus="updateWeeks('weektoPre')"></select>
                        </div>
                      </div>

                      <h6 class="text-warning mb-3"><i class="fas fa-clipboard-list mr-1"></i> VMI Post Period</h6>
                      <div class="row">
                        <div class="col-12 col-md-6 mb-3">
                          <label for="weekfromPost" class="mb-2"><i class="fas fa-calendar-week mr-1"></i> Week From</label>
                          <select id="weekfromPost" class="form-select" onfocus="updateWeeks('weekfromPost')"></select>
                        </div>
                        <div class="col-12 col-md-6 mb-3">
                          <label for="weektoPost" class="mb-2"><i class="fas fa-calendar-week mr-1"></i> Week To</label>
                          <select id="weektoPost" class="form-select" onfocus="updateWeeks('weektoPost')"></select>
                        </div>
                      </div>
                    </div>


                  </div>
                </div>
              </div> 

              <div class="form-group card-dark mb-3 p-2">
                  <label for="itmCode" class="mb-2"><i class="fas fa-briefcase mr-1"></i> SKU</label>
                  <select id="itmCode" name="itmCode[]" class="form-control select2" multiple>
                      <?php foreach ($sku_item as $key => $value) {
                          echo '<option value="' . htmlspecialchars($value['itmcde']) . '">' . htmlspecialchars($value['itmcde']) . '</option>';
                      } ?>
                  </select>
              </div>

            <div class="form-group card-dark mb-3 p-2">
                <label for="variantName" class="mb-2"><i class="fas fa-store mr-1"></i> Variant</label>
                    <select id="variantName" name="variantName" class="form-control select2">
                        <option value="">Please select...</option>
                        <?php foreach ($variants as $key => $value) {
                            echo '<option value="' . htmlspecialchars($value['item_name']) . '">' . htmlspecialchars($value['item_name']) . '</option>';
                        } ?>
                    </select>
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
                <label for="storeName" class="mb-2"><i class="fas fa-store mr-1"></i> Store Name</label>
                      <select id="storeName" name="storeName[]" class="form-control select2" multiple>
                          <?php foreach ($stores as $key => $value) {
                              echo '<option value="' . htmlspecialchars($value['store_code']) . '">' . htmlspecialchars($value['store_name']) . '</option>';
                          } ?>
                      </select>
            </div>

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
