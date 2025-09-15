<style>
    .nav-item .nav-link {
        padding: 8px 10px;
    }

    .nav-item .nav-link span {
        font-size: 10px;
        display: block;
    }

    .hide {
        display: none;
    }

    @media (min-width: 1200px) {
      .navbar-toggler {
        display: none;
      }
</style>

        <nav class="main-header navbar navbar-expand-lg navbar-light navbar-white">
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

        var menu_url = '<?=$combine_url = ltrim($_SERVER['REQUEST_URI'], '/');?>';
        var session_role = '<?= $session->sess_site_role?>';
        var session_user_name = '<?= $session->sess_site_name?>';

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
            localStorage.setItem('AdminLTE:Sidebar:Collapsed', true);
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

        function get_ba_asc_id(callback) {
            var url = "<?= site_url('dashboard/get-ba-asc-name'); ?>";
            $.post(url, { name: session_user_name }, function(response) {
                let res = response;
                if (res && res.status === 'success') {
                    callback(res.data); // pass { brandAmbassador, brandAmbassadorId, ascName, ascNameId, area, areaId }
                } else {
                    console.warn("No result found from get-ba-asc-name");
                    callback(null);
                }
            });
        }

        function user_role_editor() {
            var query = `site_menu.status >= 0 AND menu_url = '${menu_url}' AND role_id = '${session_role}'`;
            var url = "<?= base_url("cms/global_controller"); ?>";
            var data = {
                event: "list",
                select: `site_menu.id as menu_id, menu_url, menu_parent_id, menu_level ,status, role_id,
                        cms_site_menu_roles.menu_id as menu_roles_id,
                        menu_role_view,menu_role_generate,menu_role_export, menu_role_filter`,
                query: query,
                offset: offset,
                limit: 1,
                table: "site_menu",
                join: [
                    {
                        table: "cms_site_menu_roles",
                        query: "cms_site_menu_roles.menu_id = site_menu.id",
                        type: "left"
                    }
                ]
            };

            aJax.post(url, data, function(result) {
                let obj = is_json(result);
                if (!obj || obj.length === 0) return;

                $.each(obj, function(x, y) {
                    let role_view = y.menu_role_view;
                    let role_generate = y.menu_role_generate;
                    let role_export = y.menu_role_export;
                    let role_filter = y.menu_role_filter;

                    // Access control
                    if (role_view == 0 || (role_view == 0 && role_generate == 0 && role_export == 0 && role_filter == 0)) {
                        location.href = "<?= base_url('login/logout'); ?>";
                        return;
                    }


                    if (role_export == 0) {
                        $('#ExportPDF, #exportButton').remove();
                    }

                    if (role_filter == 0) {
                        $('#refreshButton').addClass('hide');
                        $('body').addClass('sidebar-collapse');
                        localStorage.setItem('AdminLTE:Sidebar:Collapsed', true);
                        localStorage.setItem('AdminLTE:Sidebar:Collapsed', 'true');
                        localStorage.setItem('AdminLTE:Sidebar:Open', 'false');
                        $('a.nav-link.bg-primary[data-widget="pushmenu"]').remove();

                        // Auto-fill filter fields if necessary
                        get_ba_asc_id(function(info) {
                            if (!info) return;
                            let url = menu_url;
                            let role = parseInt(session_role);
                            // Mapping logic per URL and role
                            if (url === 'store/sales-performance-per-ba') {
                                if (role === 7) {
                                    $("#brandAmbassador").val(info.brandAmbassador);
                                    $("#brandAmbassadorId").val(info.brandAmbassadorId);
                                } else if (role === 8) {
                                    $("#ascName").val(info.ascName);
                                    $("#ascNameId").val(info.ascNameId);
                                }
                                $("#month").val(1);
                                $("#monthTo").val(12);
                                $("#sourceDate").text($("#year option:selected").text() + " - " + $("#month option:selected").text() + " to " + $("#monthTo option:selected").text());
                                $("#refreshButton").click();

                            } else if (url === 'stocks/data-per-store') {
                                if (role === 7) {
                                    $("#brandAmbassador").val(info.brandAmbassador);
                                    $("#brandAmbassadorId").val(info.brandAmbassadorId);
                                } else if (role === 8) {
                                    $("#ascName").val(info.ascName);
                                    $("#ascNameId").val(info.ascNameId);
                                    $("#area").val(info.area);
                                    $("#areaId").val(info.areaId);
                                }
                                $("#inventoryStatus").val(['slowMoving', 'overStock', 'npd']).trigger("change");
                                $("#refreshButton").click();

                            } else if (url === 'store/sales-performance-per-month') {
                                if (role === 7) {
                                    $("#brandAmbassador").val(info.brandAmbassador);
                                    $("#brandAmbassadorId").val(info.brandAmbassadorId);
                                    $("#area").val(info.area);
                                    $("#areaId").val(info.areaId);
                                } else if (role === 8) {
                                    $("#ascName").val(info.ascName);
                                    $("#ascNameId").val(info.ascNameId);
                                    $("#area").val(info.area);
                                    $("#areaId").val(info.areaId);
                                }
                                $("#refreshButton").click();

                            } else if (url === 'store/sales-performance-per-area' && role === 8) {
                                $("#ascName").val(info.ascName);
                                $("#ascNameId").val(info.ascNameId);
                                $("#month").val(1);
                                $("#monthTo").val(12);
                                $("#refreshButton").click();
                                $('#sourceDate').text($("#year option:selected").text() + " - " + $("#month option:selected").text() + " to " + $("#monthTo option:selected").text());
                            } else if (url === 'store/sales-overall-growth' && role === 8) {
                                $("#ascName").val(info.ascName);
                                $("#ascNameId").val(info.ascNameId);
                                $("#month").val(1);
                                $("#monthTo").val(12);
                                $("#refreshButton").click();
                                $('#sourceDate').text($("#year option:selected").text() + " - " + $("#month option:selected").text() + " to " + $("#monthTo option:selected").text());
                            }
                        });
                    }

                    if (role_generate == 0) {
                        $('.main-sidebar').removeClass('sidebar-mini');
                        $('.main-sidebar').addClass('hide');
                        $('.main-header, .content-wrapper, .main-footer').css('margin-left', 0);

                        set_field_state('#area, #ascName, .btn-outline-light, #brands, #year, #month, #monthTo, #brandAmbassador, #inventoryStatus, #storeName, #itemLabel', 'view');
                    }
                });
            });
        }

        function set_field_state(selector, isReadOnly) {
            $(selector).prop({ readonly: isReadOnly, disabled: isReadOnly });
        }
    </script>