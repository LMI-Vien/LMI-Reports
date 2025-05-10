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
            user_role_editor()
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

        var menu_url = '<?=$combine_url = ltrim($_SERVER['REQUEST_URI'], '/');?>';
        var session_role = '<?= $session->sess_role?>';

        function user_role_editor() {
          var query = "site_menu.status >= 0 AND menu_url = '"+menu_url+"' AND role_id = '"+session_role+"'"; 
          var url = "<?= base_url("cms/global_controller");?>";
          var data = {
              event : "list",
              select : `site_menu.id as menu_id, 
                        menu_url, menu_parent_id, menu_level ,status, role_id,
                        cms_site_menu_roles.menu_id as menu_roles_id,
                        menu_role_view,menu_role_generate,menu_role_export, menu_role_filter`,
              query : query,
              offset : offset,
              limit : 1,
              table : "site_menu",
              join : [
                  {
                      table: "cms_site_menu_roles",
                      query: "cms_site_menu_roles.menu_id = site_menu.id",
                      type: "left"
                  }
              ]            
              
            }   
          aJax.post(url,data, function(result){
              obj = is_json(result);
              if(obj.length > 0){
                $.each(obj,function(x,y){
                      var role_view = y.menu_role_view;
                      var role_generate = y.menu_role_generate;
                      var role_export = y.menu_role_export;
                      var role_filter = y.menu_role_filter;

                      if(role_view == 0 && role_generate == 0 && role_export == 0 && role_filter == 0){
                          location.href = "<?= base_url();?>";
                      }

                      if (role_view == 0) {
                        location.href = "<?= base_url();?>";
                      }

                      if (role_generate == 0) {
                        $('#refreshButton').remove();
                        $('#clearButton').remove();
                      }

                      if (role_export == 0) {
                        $('#ExportPDF').remove();
                        $('#exportButton').remove();
                      }

                      if (role_filter == 0) {
                        $('body').addClass('sidebar-collapse');
                        $('a.nav-link.bg-primary[data-widget="pushmenu"]').remove();
                      }
                });
              }
          });
        }
    </script>