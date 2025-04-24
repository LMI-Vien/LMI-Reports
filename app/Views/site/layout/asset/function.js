
var date_now = new Date("<?= date('Y-m-d H:i:s');?>"); /* getting current date and time */
var base_url = "<?= base_url();?>"; /* getting base url */


/* Start your code here */
$(document).ready(function () {
    $('#sidebarCollapse-left').on('click', function () {
         $('#sidebar-left').toggleClass('active');
    });

    $('#sidebarCollapse-right').on('click', function () {
         $('#sidebar-right').toggleClass('active');
    });

    if (registered_browsers.indexOf(current_browser) != -1) {
    	$('#notificationModal').modal('show');
    } else {
    	$('#notificationModal').modal('hide');
    }

	$('.close-notif').click(function(){
		$('#notificationModal').modal('hide');
	});
 });


