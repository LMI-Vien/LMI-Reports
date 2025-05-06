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
                                <label for="area" class="mb-2"><i class="fas fa-map-marker-alt mr-1"></i> Area</label>
                                <input type="text" class="form-control" id="area" placeholder="Please select...">
                                <input type="hidden" id="area_id">
                            </div>
                            <div class="form-group card-dark mb-3 p-2">
                                <label for="asc_name" class="mb-2"><i class="fas fa-user-tie mr-1"></i> Area Sales Coordinator</label>
                                <input type="text" class="form-control" id="asc_name" placeholder="Please select...">
                                <input type="hidden" id="asc_name_id">
                            </div>
                            <!-- Filter by Type -->
                            <div class="form-group card-dark mb-3 p-2">
                                <label class="mb-2"><i class="fas fa-tags mr-1"></i> BA Type</label>
                                <!-- <div class="btn-group btn-group-toggle d-flex flex-wrap" data-toggle="buttons"> -->
                                <div class="btn-group btn-group-toggle d-flex flex-wrap gap-2" data-toggle="buttons">
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
                            <!-- Brand -->
                            <div class="form-group card-dark mb-3 p-2">
                                <label for="brand" class="mb-2"><i class="fas fa-briefcase mr-1"></i> Item Brand</label>
                                <input type="text" class="form-control" id="brand" placeholder="Please select...">
                                <input type="hidden" id="brand_id">
                            </div>
                            <div class="form-group card-dark mb-3 p-2">
                                <label for="year" class="mb-2 form-label"><i class="fas fa-calendar-alt mr-1"></i> Year</label>
                                <input type="text" class="form-control" id="brand" placeholder="Please select">
                                <input type="hidden" id="brand_id">
                            </div>
                            <div class="form-group card-dark mb-3 p-2">
                                <label for="year" class="mb-2 form-label"><i class="fas fa-calendar-alt mr-1"></i> Month From</label>
                                <input type="text" class="form-control" id="brand" placeholder="Please select...">
                                <input type="hidden" id="brand_id">
                            </div>
                            <div class="form-group card-dark mb-3 p-2">
                                <label for="year" class="mb-2 form-label"><i class="fas fa-calendar-alt mr-1"></i> Month To</label>
                                <input type="text" class="form-control" id="brand" placeholder="Please select...">
                                <input type="hidden" id="brand_id">
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



