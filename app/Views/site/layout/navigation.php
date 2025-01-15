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
                            <a href="#" class="nav-item nav-link active"><i class="fas fa-briefcase"></i>Report 1</a>
                            <a href="#" class="nav-item nav-link"><i class="fas fa-briefcase"></i>Report 2</a>
                            <a href="#" class="nav-item nav-link"><i class="fas fa-briefcase"></i>Report 3</a>
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