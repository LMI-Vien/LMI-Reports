        <style>
            .nav-item .nav-link {
                padding: 8px 10px; /* Adjust padding to fit */
            }

            .nav-item .nav-link span {
                font-size: 10px; /* Reduce font size for date */
                display: block;
            }
        </style>

        <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
          <div class="container-fluid">

            <?php if (service('uri')->getSegment(1) !== 'dashboard'): ?>
              <ul class="navbar-nav d-flex align-items-center">
                <li class="nav-item">
                    <a class="nav-link bg-primary" data-widget="pushmenu" href="#" style="color: #FFF !important; border-radius: 5px;">
                        <i id="sidebarToggleIcon" class="fa-solid fa-arrow-right"></i>
                    </a>
                </li>
              </ul>
            <?php endif; ?>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse">
              <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarCollapse">
              <div id="navButton" class="mr-auto"></div>
              <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                  <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="fas fa-user"></i> Hi, <?= esc(session()->get('sess_site_name')) ?><br>
                    <span id="currentDateTime" class="small text-muted"></span>
                  </a>
                  <div class="dropdown-menu dropdown-menu-right">
                    <a id="logout" href="<?= base_url('login/logout') ?>" class="dropdown-item">
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
            $('body').removeClass('sidebar-mini');
            $('body').addClass('sidebar-mini-no-expand');
            updateDateTime();
            updateSidebarIcon();
              $(document).on('click', '[data-widget="pushmenu"]', function () {
                setTimeout(updateSidebarIcon, 300); 
              });
              $(window).on('resize', function () {
                setTimeout(updateSidebarIcon, 300);
              });
            get_menu_site();

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
                var url = "<?= site_url('cms/cms-preference/get-site-menu'); ?>"; 
                $.get(url, function(response) {
                    $("#navButton").append(response); 
                });
            }

        });

        function updateSidebarIcon() {
            const $body = $('body');
          if ($body.hasClass('sidebar-collapse') || $body.hasClass('sidebar-open')) {
            $('#sidebarToggleIcon')
              .removeClass('fa-arrow-left')
              .addClass('fa-arrow-right');
          } else {
            $('#sidebarToggleIcon')
              .removeClass('fa-arrow-right')
              .addClass('fa-arrow-left');
          }
        }

        function updateDateTime() {
            let now = new Date();
            let options = { weekday: 'long', month: 'long', day: 'numeric', year: 'numeric' };
            let formattedDate = now.toLocaleDateString('en-US', options);
            document.getElementById('currentDateTime').textContent = formattedDate;
        }

    </script>