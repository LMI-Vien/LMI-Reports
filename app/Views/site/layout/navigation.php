<style>
    #dynamic-menu .nav-item.dropdown {
        position: relative;
        cursor: pointer;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 200px;
        transition: all 0.3s ease-in-out;
    }

    #dynamic-menu .nav-item.dropdown.expanded {
        overflow: visible;
        max-width: unset;
        background: white;
        border: 2px solid black;
        border-radius: 5px;
        padding: 5px;
    }

    #dynamic-menu .nav-item.dropdown .dropdown-menu {
        display: none;
        position: absolute;
        top: 100%;
        left: 0;
        background: white;
        border: 2px solid black;
        padding: 5px;
        box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.2);
        z-index: 10;
    }

    #dynamic-menu .nav-item.dropdown.show .dropdown-menu {
        display: block;
    }
</style>

    <header>
        <div class="container">
            <div class="navbar-wrapper">
                <nav class="navbar navbar-expand-md">
                    <div class="uiheaderright">
                        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                            <i class="fas fa-bars"></i>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarCollapse">
                            <div class="navbar-nav">
                                <!-- GET THE SITE MENU HERE -->
                                <!-- <div class="nav-item dropdown">
                                    <a href="#" class="nav-link dropdown-toggle" id="dashboardMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-dashboard"></i> Dashboard
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="dashboardMenu">
                                        <a class="dropdown-item" href="#">Overview</a>
                                        <a class="dropdown-item" href="#">Analytics</a>
                                        <a class="dropdown-item" href="#">Reports</a>
                                    </div>
                                </div> -->
                                
                                <!-- <div class="nav-item dropdown">
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

                                <div class="nav-item dropdown">
                                    <a href="#" class="nav-link dropdown-toggle" id="BrandAmbassador" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-dashboard"></i>BA
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="BrandAmbassador">
                                        <a class="dropdown-item" href="#">Qty of Slow Moving SKU</a>
                                        <a class="dropdown-item" href="#">Overstock SKU</a>
                                        <a class="dropdown-item" href="#">NPD</a>
                                        <a class="dropdown-item" href="#">Hero SKU</a>
                                    </div>
                                </div>

                                <div class="nav-item dropdown">
                                    <a href="#" class="nav-link dropdown-toggle" id="AreaSalesCoor" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-dashboard"></i>ASC
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="AreaSalesCoor">
                                        <a class="dropdown-item" href="#">BA Sales Report Slow Moving SKU</a>
                                        <a class="dropdown-item" href="#">Overstock SKU</a>
                                        <a class="dropdown-item" href="#">NPD</a>
                                        <a class="dropdown-item" href="#">Hero SKU</a>
                                    </div>
                                </div>

                                <div class="nav-item dropdown">
                                    <a href="#" class="nav-link dropdown-toggle" id="ATMM" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-dashboard"></i>ATMM
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="ATMM">
                                        <a class="dropdown-item" href="#">Store Search Engine</a>
                                        <a class="dropdown-item" href="#">Trade Report Info for KAM</a>
                                        <a class="dropdown-item" href="#">Top Performing Watsons Store</a>
                                        <a class="dropdown-item" href="#">Trade Report on ASC</a>
                                        <a class="dropdown-item" href="#">Trade Report on BA</a>
                                    </div>
                                </div>

                                <div class="nav-item dropdown">
                                    <a href="#" class="nav-link dropdown-toggle" id="KAMM" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-dashboard"></i>KAM & Management
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="KAMM">
                                        <a class="dropdown-item" href="#">Store Search Engine</a>
                                        <a class="dropdown-item" href="#">Trade Report Info for KAM</a>
                                        <a class="dropdown-item" href="#">Top Performing Watsons Store</a>
                                        <a class="dropdown-item" href="#">Trade Report on ASC</a>
                                        <a class="dropdown-item" href="#">Trade Report on BA</a>
                                    </div>
                                </div> -->

                                <ul class="navbar-nav">
                                    <div id="dynamic-menu"></div>
                                </ul>

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
        </div>
    </header>


<script>
    $(document).ready(function () {
        $(".dropdown-item").on("click", function (e) {
            e.preventDefault(); 

            $(".dropdown-item").removeClass("active");

            $(this).addClass("active");
            
            $(".nav-link").removeClass("active");

            const parentMenu = $(this).closest(".dropdown").find(".nav-link");
            parentMenu.addClass("active");
        });

        // logout confirmation
        $("#logout").on("click", function(e) {
            e.preventDefault();

            var logoutUrl = $(this).attr("href");

            Swal.fire({
                title: "Are you sure?",
                text: "You will be logged out of your session.",
                icon: "warning",
                showCancelButton: true,
                allowOutsideClick: false,
                allowEscapeKey: false,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, log me out!",
                cancelButtonText: "Cancel"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = logoutUrl;
                }
            });
        });

        // dynamic menu site
        function get_menu_site() {
            var url = "<?= site_url('cms/cms_preference/get_site_menu'); ?>"; 
            $.get(url, function(response) {
                $("#dynamic-menu").html(response); 
            });
        }

        get_menu_site();

        $("#dynamic-menu").on("click", ".nav-item.dropdown", function (e) {
            e.stopPropagation();

            var $this = $(this);
            
            if ($this.hasClass("show")) {
                $this.removeClass("show expanded"); 
                $this.find(".dropdown-menu").removeClass("show");
            } else {
                $(".nav-item.dropdown").removeClass("show expanded"); 
                $(".dropdown-menu").removeClass("show"); 

                $this.addClass("show expanded"); 
                $this.find(".dropdown-menu").addClass("show");
            }
        });

        $(document).on("click", function () {
            $(".nav-item.dropdown").removeClass("show expanded");
            $(".dropdown-menu").removeClass("show");
        });

    });
    
</script>