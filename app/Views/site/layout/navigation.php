        <style>
            .nav-item .nav-link {
                padding: 8px 10px; /* Adjust padding to fit */
            }

            .nav-item .nav-link span {
                font-size: 10px; /* Reduce font size for date */
                display: block;
            }
        </style>

        <!-- Main Header (Top Navigation) -->
        <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
            <div class="container-fluid"> <!-- Changed container to container-fluid -->
                <!-- Brand Logo -->
                <a href="<?= base_url();?>" class="navbar-brand">
                    <i class="fas fa-home"></i>
                </a>

                <!-- Navbar Toggle Button (for mobile) -->
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div id="navButton" class="mr-auto">

                    </div>
                    <!-- Right Navbar Links -->
                    <ul class="navbar-nav">
                        <!-- Notifications Dropdown -->
        <!--                 <li class="nav-item dropdown">
                            <a class="nav-link" data-toggle="dropdown" href="#">
                                <i class="fas fa-bell"></i>
                                <span class="badge badge-warning navbar-badge">3</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                                <span class="dropdown-header">3 Notifications</span>
                                <div class="dropdown-divider"></div>
                                <a href="#" class="dropdown-item">
                                    <i class="fas fa-envelope mr-2"></i> 1 new message
                                </a>
                                <a href="#" class="dropdown-item">
                                    <i class="fas fa-users mr-2"></i> 2 friend requests
                                </a>
                            </div>
                        </li> -->

                        <!-- User Profile Dropdown -->
                        <li class="nav-item dropdown">
                            <a class="nav-link" data-toggle="dropdown" href="#">
                                <i class="fas fa-user"></i> Hi, <?= esc(session()->get('sess_site_name')) ?><br>
                                <span id="currentDateTime" class="small text-muted"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right">
                                <a id="logout" href="<?= base_url('login/logout')?>" class="dropdown-item">
                                    <i class="fas fa-sign-out-alt mr-2"></i> Logout
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <script>

    $(document).ready(function () {
        get_menu_site();
        // $(".dropdown-item").on("click", function (e) {
        //     e.preventDefault(); 

        //     $(".dropdown-item").removeClass("active");

        //     $(this).addClass("active");
            
        //     $(".nav-link").removeClass("active");

        //     const parentMenu = $(this).closest(".dropdown").find(".nav-link");
        //     parentMenu.addClass("active");
        // });

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
                $("#navButton").append(response); 
            });
        }

       // get_menu_site();

        // $("#dynamic-menu").on("click", ".nav-item.dropdown", function (e) {
        //     e.stopPropagation();

        //     var $this = $(this);
            
        //     if ($this.hasClass("show")) {
        //         $this.removeClass("show expanded"); 
        //         $this.find(".dropdown-menu").removeClass("show");
        //     } else {
        //         $(".nav-item.dropdown").removeClass("show expanded"); 
        //         $(".dropdown-menu").removeClass("show"); 

        //         $this.addClass("show expanded"); 
        //         $this.find(".dropdown-menu").addClass("show");
        //     }
        // });

        // $(document).on("click", function () {
        //     $(".nav-item.dropdown").removeClass("show expanded");
        //     $(".dropdown-menu").removeClass("show");
        // });

    });
            function updateDateTime() {
                let now = new Date();
                let options = { weekday: 'long', month: 'long', day: 'numeric', year: 'numeric' };
                let formattedDate = now.toLocaleDateString('en-US', options);
                document.getElementById('currentDateTime').textContent = formattedDate;
            }

            // Update time on page load
            updateDateTime();
        </script>