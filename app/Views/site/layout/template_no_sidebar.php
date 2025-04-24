    
	<?php 
		$uri = current_url(true); 
	?>
	<?= view("site/layout/header", $meta); ?>
	<body class="hold-transition layout-top-nav">
	    <div class="wrapper">
			<?= view("site/layout/navigation"); ?>	
			<?= view($content); ?> 
		
			<?= view("site/layout/footer"); ?>
		<div>
    <script>
        // Enable Bootstrap 4 multi-level dropdowns
        $(document).ready(function () {
            $('.dropdown-submenu a.dropdown-toggle').on("click", function(e) {
                var $submenu = $(this).next(".dropdown-menu");
                $submenu.toggleClass('show');
                
                // Close other open submenus
                $(this).parents('.dropdown-submenu').siblings().find('.dropdown-menu').removeClass('show');

                e.stopPropagation();
            });

            $('.dropdown').on("hidden.bs.dropdown", function () {
                $('.dropdown-menu.show').removeClass('show');
            });
        });
    </script>

    <style>

        .main-header {
          position: sticky;
          top: 0;
          z-index: 1030;
          background-color: #fff; /* Or use your theme color */
          box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Optional visual polish */
        }
        /* Custom styling for multi-level dropdown */
        .dropdown-submenu {
            position: relative;
        }

        .dropdown-submenu .dropdown-menu {
            top: 0;
            left: 100%;
            margin-top: -1px;
        }

        /* Make content fill the page */
        .content-wrapper {
            min-height: calc(100vh - 100px); /* Adjust based on header/footer height */
            display: flex;
            flex-direction: column;
            justify-content: center;
            text-align: center;
        }

    </style>
    </body>
</html>

<?php if(!empty($js)) : ?>
    <?php foreach($js as $path) : ?>
        <script defer type="text/javascript" src="<?= base_url() . $path; ?>?v=1"></script>
    <?php endforeach; ?>
<?php endif; ?>
<script type="text/javascript">
	var base_url = "<?= base_url();?>";
</script>

