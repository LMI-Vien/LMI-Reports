<style>
.main-sidebar {
  background-color: #301311;
}

<?php
    //get url for db table checking on user role
    $url =  "http://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
    $escaped_url = htmlspecialchars( $url, ENT_QUOTES, 'UTF-8' );
    $urls = explode('/', $escaped_url);
    $remove_base_url = array_splice($urls,4);
    $limit_url = count($remove_base_url);
    $combine_url ="";
    if($limit_url >= 3 ){
        if($remove_base_url[1] == 'cms_menu' || $remove_base_url[1] == 'site_menu' || $remove_base_url[1] == 'preference' || $remove_base_url[1] == 'documentation'){
            $combine_url = $remove_base_url[0].'/'.$remove_base_url[1].'/'.$remove_base_url[2];
            if($remove_base_url[2] == 'menu_add' || $remove_base_url[2] == 'menu_update'){
                $set_last_index = 'menu';
                $combine_url = $remove_base_url[0].'/'.$remove_base_url[1].'/'.$set_last_index;
            }
        }else{
            $combine_url = $remove_base_url[0].'/'.$remove_base_url[1];
        }
    }else{
        $combine_url = implode("/",$remove_base_url);
    }
?>

</style>
<nav class="main-header navbar navbar-expand navbar-white elevation-2">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-burger">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
  </ul>

  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
    <!-- Messages Dropdown Menu -->
    <li class="nav-signout">
      <a class="nav-link logout-btn" href="<?= base_url('cms/login/sign_out');?>">
        <i class="fa fa-sign-out-alt mr-2"></i> Sign Out 
      </a>
    </li>
  </ul>
</nav>

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-yellow elevation-4">
  <!-- Brand Logo -->
  <a href="<?= base_url('cms/home')?>" class="brand-link">
    <img src="<?= base_url();?>assets/img/lmi_logo_box.png" alt="AdminLTE Logo" class="brand-image" style="opacity: .8">
    <span class="brand-text font-weight-light logo-lg">SFA</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column sidebar-menu" data-widget="treeview" role="menu">
      </ul>
    </nav>
    </div>
</aside>


<script>
var menu_url = 'cms/'+'<?=$combine_url;?>';
console.log(menu_url);

$(document).ready(function () {
    $(".logout-btn").on("click", function(e) {
        e.preventDefault();

        var logoutUrl = $(this).attr("href"); // Get the logout URL

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
                localStorage.removeItem('activeSubMenu');
                localStorage.removeItem('activeMenu');
                window.location.href = logoutUrl;
            }
        });
    });

    aJax.get("<?= base_url('cms/cms_preference/get_title');?>",function(data) {
      $('.logo-lg').html(data);
    })

    aJax.get(base_url + 'cms/cms_preference/get_menu', function (data) {
        var obj = is_json(data);
        $('.sidebar-menu').html(obj);
        initializeMenu();
    });

    function initializeMenu() {
  
        var activeMenu = localStorage.getItem('activeMenu');
        var activeSubMenu = localStorage.getItem('activeSubMenu');

        if (activeMenu) {
             
            var $activeItem = $('.nav-item[data-id="' + activeMenu + '"]');
            if ($activeItem.length > 0) {
                $activeItem.addClass('menu-open active');
                $activeItem.children('.nav-link-main').addClass('active');
                $activeItem.children('.nav-treeview').slideDown(); // Ensure submenu opens
            }
        }

        if (activeSubMenu) {

            var $activeSubItem = $('.nav-item[data-id="' + activeSubMenu + '"]');
            if ($activeSubItem.length > 0) {

                $activeSubItem.children('a').addClass('active');
                $activeSubItem.closest('.has-treeview').addClass('menu-open active');
                $activeSubItem.closest('.nav-treeview').slideDown(); // Ensure submenu is visible
            }
        }

        $('.nav-item > a').on('click', function (e) {
            var $menuItem = $(this).parent();
            var $submenu = $menuItem.children('.nav-treeview');

            if ($submenu.length > 0) {
                e.preventDefault(); 
                
                $('.nav-link').removeClass('active');
                if ($menuItem.hasClass('menu-open')) {
                } else {
                    $('.nav-item.menu-open')
                        .not($menuItem.parents('.nav-item'))
                        .removeClass('menu-open active')
                        .children('.nav-treeview')
                        .slideUp();
                    localStorage.setItem('activeMenu', $menuItem.attr('data-id'));
                }
            } else {
                $('.nav-item a.active').removeClass('active');
                $(this).addClass('menu-open active');
                localStorage.setItem('activeMenu', $menuItem.attr('data-id'));
                localStorage.removeItem('activeSubMenu');
            }
        });

        $('.nav-treeview a').on('click', function () {
            var $subMenuItem = $(this).parent();
            $('.nav-item a.active').removeClass('active');
            $(this).addClass('active');
            var $parentMenu = $subMenuItem.closest('.has-treeview');
            $parentMenu.addClass('menu-open active');
            $subMenuItem.closest('.nav-treeview').slideDown();
            localStorage.setItem('activeSubMenu', $subMenuItem.attr('data-id'));
            localStorage.setItem('activeMenu', $parentMenu.attr('data-id'));
        });
    }
});

$('.brand-link').on('click', function (e) {
    
    $('.has-treeview').removeClass('menu-open active');
    localStorage.removeItem('activeSubMenu');
    localStorage.removeItem('activeMenu');
});


  $(window).on('load', function() { 
    user_role_editor();
  });

  function user_role_editor() {
    console.log('asdasdasd');
    var user_role = '<?= $session->sess_role?>';
    var query = "cms_menu.status >= 0 AND menu_url = '"+menu_url+"' AND role_id = '"+user_role+"'"; 
    var url = "<?= base_url("cms/global_controller");?>";
    var data = {
        event : "list",
        select : "cms_menu.id as menu_id, menu_url,menu_parent_id,menu_level ,status, role_id,cms_menu_roles.menu_id as menu_roles_id,menu_role_read,menu_role_write,menu_role_delete",
        query : query,
        offset : offset,
        limit : 1,
        table : "cms_menu",
        // order : {
        //     field : "ba.updated_date",
        //     order : "desc" 
        // },
        join : [
            {
                table: "cms_menu_roles",
                query: "cms_menu_roles.menu_id = cms_menu.id",
                type: "left"
            }
        ]            
        

    }    
    aJax.post(url,data, function(result){
        obj = (is_json(result))
        console.log(obj);
        if(obj.length > 0){
           $.each(obj,function(x,y){
                var role_read = y.menu_role_read;
                var role_write = y.menu_role_write;
                var role_delete = y.menu_role_delete;

                if(role_read == 0 && role_delete == 0 && role_write == 0){
                    location.href = "<?= base_url('cms');?>";
                }

                if (role_delete == 0) {
                  $('.btn_trash').remove();
                  $('#btn_delete').remove();
                }

                if (role_write == 0 && role_delete == 0) {
                  $('.btn_add').remove();
                  $('.btn_update').remove();
                  $('.btn_save').remove();
                  $("body :input").prop("disabled", true);
                  $("a.edit").addClass('disabled');
                  $("tbody tr").removeClass('ui-sortable-handle');
                  $('tbody').removeClass('ui-sortable');
                  $('table').removeClass('sorted_table');

                  if ($("table td:nth-child(2)").has("span.move-menu").length > 0) {
                    $('tbody').sortable('disable');
                    $("table th:first-child,td:nth-child(2)").remove();
                  }
                  if ($("table td:nth-child(2)").has("input.select").length > 0) {
                    $("table th:first-child,td:nth-child(2)").remove();
                  }
                  if ($('table td:last-child').has(".edit").length > 0) {
                    $('table th:last-child,td:last-child').remove();
                  }
                } else if (role_write == 0 && role_delete == 1) {
                  $('.btn_add').remove();
                  $('.box-header a[data-status="1"]').remove();
                  $('.box-header a[data-status="0"]').remove();
                  $('.btn_update').remove();
                  $('.btn_save').remove();
                  $('.btn_add_folder').remove();
                  $('.btn_upload').remove();
                  $('.btn_sitemap').remove();
                  $("body :input").prop("disabled", true);
                  $("body :button").prop("disabled", false);
                  $("body #search_query").prop("disabled", false);
                  $("a.edit").addClass('disabled');
                  $("tbody tr").removeClass('ui-sortable-handle');
                  $('tbody').removeClass('ui-sortable');
                  $('table').removeClass('sorted_table');

                  if ($("table td:first-child").has("input.select").length > 0) {
                    $("th :input").removeAttr('disabled');
                    $(".select").removeAttr('disabled');
                  }
                  if ($("table td:nth-child(2)").has("span.move-menu").length > 0) {
                    $('tbody').sortable('disable');
                    $("table th:first-child,td:nth-child(2)").remove();
                  } 
                  if ($("table td:nth-child(2)").has("input.select").length > 0) {
                    $("th :input").removeAttr('disabled');
                    $(".select").removeAttr('disabled');
                  } 
                  if ($('table td:last-child').has(".edit").length > 0) {
                    $('table th:last-child').hide();
                    $('table td:last-child').hide();
                  }
                }
           });
        }
    });

    // AJAX.config.base_url("<?= base_url();?>");
    // AJAX.select.select("cms_menu.id as menu_id, menu_url,menu_parent_id,menu_level ,status, role_id,cms_menu_roles.menu_id as menu_roles_id,menu_role_read,menu_role_write,menu_role_delete");
    // AJAX.select.table("cms_menu");
    // AJAX.select.join.left("cms_menu_roles", "cms_menu_roles.menu_id", "cms_menu.id");
    // AJAX.select.exec(function(result) {
    //   var result = JSON.parse(result);

    // });
  }

</script>
