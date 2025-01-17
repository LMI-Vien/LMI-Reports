    <header>
        <div class="container">
            <nav class="navbar navbar-expand-md">
                <div class="uiheaderright">
                    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                        <i class="fas fa-bars"></i>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarCollapse">
                        <div class="navbar-nav">
                            <!-- GET THE SITE MENU HERE -->
                            <div class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle active" id="dashboardMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-dashboard"></i> Dashboard
                                </a>
                                <div class="dropdown-menu" aria-labelledby="dashboardMenu">
                                    <a class="dropdown-item" href="#">Overview</a>
                                    <a class="dropdown-item" href="#">Analytics</a>
                                    <a class="dropdown-item" href="#">Reports</a>
                                </div>
                            </div>
                            
                            <div class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle" id="watsonsMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-dashboard"></i> Watsons Sell Through Report
                                </a>
                                <div class="dropdown-menu" aria-labelledby="watsonsMenu">
                                    <a class="dropdown-item" href="#">By Brand Overall</a>
                                    <a class="dropdown-item" href="#">By Brand Category</a>
                                    <a class="dropdown-item" href="#">By Brand SKU</a>
                                    <a class="dropdown-item" href="#">Report Overall Category</a>
                                </div>
                            </div>
                            
                            <div class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle" id="salesTargetMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-dashboard"></i> Sales Target
                                </a>
                                <div class="dropdown-menu" aria-labelledby="salesTargetMenu">
                                    <a class="dropdown-item" href="#">By Account Overall</a>
                                    <a class="dropdown-item" href="#">By Brand Overall</a>
                                    <a class="dropdown-item" href="#">By Brand Category</a>
                                    <a class="dropdown-item" href="#">Report</a>
                                    <a class="dropdown-item" href="#">Channel Account Sales Report</a>
                                </div>
                            </div>

                            <a href="#" class="nav-item nav-link"><i class="fa fa-dashboard"></i>BA</a>
                            <a href="#" class="nav-item nav-link"><i class="fa fa-dashboard"></i>ASC</a>
                        </div>

                    </div>
                </div>
                <div class="uiuserbox">
                    <div class="dropdown">
                      <button class="dropdown-toggle uiusertoggle" type="button" data-toggle="dropdown">
                          <div class="uiuser">
                              <div class="uiusername">
                                  <div class="uiusername">
                                    <div class="uiname">Hi, <span><?= esc(session()->get('sess_site_name')) ?></span></div>
                                    <div class="uiday"><span><?=date('l, F d, Y')?></span></div>
                                </div>
                            </div>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a href="<?php echo base_url('login/logout');?>" id="logout" ><i class="fas fa-sign-out-alt"></i>Log out</a></li>
                    </ul>
                    </div>
                </div> 
            </nav>
        </div>
    </header>   