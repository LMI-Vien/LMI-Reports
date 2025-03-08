    
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

        /* Sticky Footer */
        .main-footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            background-color: #f8f9fa;
            padding: 10px 0;
            border-top: 1px solid #dee2e6;
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

