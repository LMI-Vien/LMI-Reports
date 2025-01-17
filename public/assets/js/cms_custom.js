//return if json
function is_json(str) {
    try {
        return JSON.parse($.trim(str));
    } catch (e) {
        return $.trim(str)
    }
} 

//return if json
function is_text(str) {
    try {
        return JSON.parse($.trim(str));
    } catch (e) {
        return $.trim(str)
    }
} 


//strip_html tags

function strip_tags(str){
	return str.replace(/<\/?[^>]+(>|$)/g, "");
}

//element action
var element = {
	click : function(element, cb){
		$(document).on('click', element, cb);
	},
	change : function(element, cb){
		$(document).on('change', element, cb);
	},
	html : function(element, value){
		$(element).html(value);
	},
	append : function(element, value){
		$(element).append(value);
	},
	show : function(element){
		$(element).show();
	},
	hide : function(element){
		$(element).hide();
	},
	remove : function(element){
		$(element).remove();
	}
}

//jquery helper
var jquery = {
	event : function(event,element,cb) {
		$(document).on(event, element, cb);
	}
}


//ajax
var aJax = {
  	post : function(url,data,cb){
	    $.ajax({
	      async: true,
	      cache: false,
	      type: 'POST',
	      url:url,
	      data:data,
	      success: cb
	    });
	},
	get : function(url,cb){
    	$.ajax({
      		type: 'GET',
      		url:url,
      		success: cb
    	});
  	},
  	post_async : function(url,data,cb){
	    $.ajax({
	      async: false,
	      cache: false,
	      type: 'POST',
	      url:url,
	      data:data,
	      success: cb
	    });
	}
}

//validation
var validate = {
	email_address : function(email){
		var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
		return pattern.test(email);
	},
	required: function(element){
		var counter = 0;
		$(".validate_error_message").remove();
		var error_message = "<span class='validate_error_message' style='color: red;'>This field is required<br></span>"
	    $(element).each(function(){
	    	if($(this).val() != null){
	    		var input = $(this).val().trim();
	          	if (input.length == 0) {
	          		$(this).css('border-color','red');
	          		$(error_message).insertAfter(this);
	            	counter++;
	          	}else{
	            	$(this).css('border-color','#ccc');
	              $(this).next(".validate_error_message").remove();       	
	          	}
	    	} else {
	    		$(this).css('border-color','red');
	    		$(error_message).insertAfter(this);
	    	}
	          
				});

				//alpha only
				$(".alphaonly").each(function(){
					var str = $(this).val();
					if(/^[a-zA-Z -]*$/.test(str) == false) {
							counter++;
							$(this).css('border-color','red');
	          	$("<span class='validate_error_message' style='color: red;'>This field only required only Letters.<br></span>").insertAfter(this);
					}
				});


				///email validator
				$(".email").each(function(){
					var email = $(this).val();
					var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
					if(!pattern.test(email)){
						counter++;
						$(this).css('border-color','red');
	          $("<span class='validate_error_message' style='color: red;'>Please enter a valid email address.<br></span>").insertAfter(this);
					
					}
				});
	    return counter;
	},
	all: function(){
		var element = ".required_input";
		var counter = 0;
		$(".validate_error_message").remove();
		var error_message = "<span class='validate_error_message' style='color: red;'>This field is required<br></span>"
	    $(element).each(function(){
	    	if($(this).val() != null){
	    		var input = $(this).val().trim();
	          	if (input.length == 0) {
	          		$(this).css('border-color','red');
	          		$(error_message).insertAfter(this);
	            	counter++;
	          	}else{
	            	$(this).css('border-color','#ccc');
	              $(this).next(".validate_error_message").remove();       	
	          	}
	    	} else {
	    		$(this).css('border-color','red');
	    		$(error_message).insertAfter(this);
	    	}
	          
				});

				//alpha only
				$(".alphaonly").each(function(){
					var str = $(this).val();
					if(/^[a-zA-Z -]*$/.test(str) == false) {
							counter++;
							$(this).css('border-color','red');
	          	$("<span class='validate_error_message' style='color: red;'>This field only required only Letters.<br></span>").insertAfter(this);
					}
				});


				///email validator
				$(".email").each(function(){
					var email = $(this).val();
					var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
					if(!pattern.test(email)){
						counter++;
						$(this).css('border-color','red');
	          $("<span class='validate_error_message' style='color: red;'>Please enter a valid email address.<br></span>").insertAfter(this);
					
					}
				});
		if(counter == 0){
			return true;
		} else {
			return false;
		}
	},
	standard: function(element_id){
		
		var element = element_id ? `#${element_id} ` : '';
		element += '.required_input';
		var counter = 0;
		$(this).css('border-color','#ccc');
		$(".validate_error_message").remove();
		var error_message = "<span class='validate_error_message' style='color: red;'>"+form_empty_error+"<br></span>"
	    $(element).each(function(){
	    	var type = $(this).attr("type");
			if(type != "ckeditor"){
		    	if($(this).val() != null){
		    		var input = $(this).val().trim();
		          	if (input.length == 0) {
		          		$(this).css('border-color','red');
		          		$(error_message).insertAfter(this);
		            	counter++;
		          	}else{
		            	$(this).css('border-color','#ccc');
		              	$(this).next(".validate_error_message").remove();       	
		          	}
		    	} else {
		    		$(this).css('border-color','red');
		    		$(error_message).insertAfter(this);
		    	}
		    }
		});

		//alpha only
		
	    if ($(element).hasClass("alphaonly")) {
			$(".alphaonly").each(function(){
				var str = $(this).val();
				if(/^[a-zA-Z -]*$/.test(str) == false) {
					counter++;
					$(this).css('border-color','red');
	  				$("<span class='validate_error_message' style='color: red;'>This field only required only Letters.<br></span>").insertAfter(this);
				}
			});
	    }



		//validate script tags

		$(".form-control").each(function(){
			if($(this).val().trim().indexOf("<script") != -1){
				counter++;
				$(this).css('border-color','red');
				$("<span class='validate_error_message' style='color: red;'>"+form_script+"<br></span>").insertAfter(this);
			}

			if($(this).val().trim().indexOf("< script") != -1){
				counter++;
				$(this).css('border-color','red');
				$("<span class='validate_error_message' style='color: red;'>"+form_script+"<br></span>").insertAfter(this);
			}


			if($(this).val().trim().indexOf("<?php") != -1){
				counter++;
				$(this).css('border-color','red');
				$("<span class='validate_error_message' style='color: red;'>"+form_script+"<br></span>").insertAfter(this);
			}

			if($(this).val().trim().indexOf("<?=") != -1){
				counter++;
				$(this).css('border-color','red');
				$("<span class='validate_error_message' style='color: red;'>"+form_script+"<br></span>").insertAfter(this);
			}
		});

		//strip tags
		if ($(element).hasClass("no_html")){
			$(".no_html").each(function(){
				var type = $(this).attr("type");
				if(type != "ckeditor"){
					if(/<\/?[^>]*>/.test($(this).val().trim())){
						counter++;
						$(this).css('border-color','red');
						$("<span class='validate_error_message' style='color: red;'>"+form_nohtml+"<br></span>").insertAfter(this);
					}
				}
			});
		}

		//test mobile number
		if ($(element).hasClass("mobile_number")){
			$(".mobile_number").each(function(){
				var number = $(this).val();
				if(/^09\d{9}$/.test(number) === false){
					counter++;
					$(this).css('border-color','red');
					$("<span class='validate_error_message' style='color: red;'>"+form_invalid_mobile_no+"<br></span>").insertAfter(this);
				
				}
			});
		}

		//captcha
		if ($(element).hasClass("captcha_ci")){
			$(".captcha_ci").each(function(){
				var captcha_val = $(this).attr("cpt-val");
				var input_val = sha1($(this).val().trim());
				if($(this).val().trim() != ""){
					if(captcha_val != input_val){
						counter++;
						$(this).css('border-color','red');
						$("<span class='validate_error_message' style='color: red;'>"+form_invalid_captcha+"<br></span>").insertAfter(this);
					}
				}
				
			});
		}

		if ($(".g-recaptcha")[0]){
		    if(grecaptcha.getResponse().length == 0){
		    	$(".g-recaptcha").css('border-color','red');
				$("<span class='validate_error_message' style='color: red;'>"+form_invalid_captcha+"<br></span>").insertAfter(".g-recaptcha");
		    }
		}


		///filemanger extension filter validator
		if ($(element).hasClass("ext_filter")){
			$(".ext_filter").each(function(){
				if($(this).val() != ""){
					var value = $(this).val().split('.').pop();
					var accept = $(this).attr("accept");
					var extension = accept.split(',');
					if(!is_in_array(value,extension)){
						counter++;
						$(this).css('border-color','red');
						$("<span class='validate_error_message' style='color: red;'>"+form_invalid_extension+"<br></span>").insertAfter(this);
					}
				}
			});
		}

		///filemanger extension filter validator
		if ($(element).hasClass("size_filter")){
			$(".size_filter").each(function(){
				if($(this).val() != ""){
					var value = $(this).val();
					var this_element = $(this);
					var max = parseInt($(this).attr("max_size"));
					$.ajax(base_url + value, {
					    type: 'HEAD',
					    async: false,
					    success: function(d,r,xhr) {
					       	fileSize = xhr.getResponseHeader('Content-Length');
					       	var totalSizeMB = fileSize / Math.pow(1024,2)
					      	if(max < totalSizeMB){
					      		counter++;
								$(this_element).css('border-color','red');
								$("<span class='validate_error_message' style='color: red;'>"+form_max_size+"<br></span>").insertAfter(this_element);		
							}
					    }
					});
				}
			});
		}


		///email validator
		if ($(element).hasClass("size_filter")){
			$(".email").each(function(){
				if($(this).val() != ""){
					var email = $(this).val();
					var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
					if(!pattern.test(email)){
						counter++;
						$(this).css('border-color','red');
		      			$("<span class='validate_error_message' style='color: red;'>"+form_invalid_email+"<br></span>").insertAfter(this);
					}
				}
			});
		}


		//ckeditor

		if ($(element).hasClass("ckeditor_input")){
			$('.required_input').each(function(){
				var type = $(this).attr("type");
				var id = $(this).attr("id");
				$(".cke_editor_" + id).css('border-color','#ccc');
				if(type == "ckeditor"){
					var editor = CKEDITOR.instances[id].getData();
					if(editor.trim().length == 0){
						counter++;
						$(".cke_editor_" + id).css('border-color','red');
						$("<span class='validate_error_message' style='color: red;'>"+form_empty_error+"<br></span>").insertAfter(".cke_editor_" + id);
					}
				}
			});
		}


		$('.ckeditor_input').each(function(){
			var id = $(this).attr("id");
			var editor = html_decode(CKEDITOR.instances[id].getData());
			if(editor.trim().indexOf("<script") != -1){
				counter++;
				$(".cke_editor_" + id).css('border-color','red');
				$("<span class='validate_error_message' style='color: red;'>"+form_script+"<br></span>").insertAfter(".cke_editor_" + id);
			}

			if(editor.trim().indexOf("< script") != -1){
				counter++;
				$(".cke_editor_" + id).css('border-color','red');
				$("<span class='validate_error_message' style='color: red;'>"+form_script+"<br></span>").insertAfter(".cke_editor_" + id);
			}


			if(editor.trim().indexOf("<?php") != -1){
				counter++;
				$(".cke_editor_" + id).css('border-color','red');
				$("<span class='validate_error_message' style='color: red;'>"+form_script+"<br></span>").insertAfter(".cke_editor_" + id);
			}

			if(editor.trim().indexOf("<?=") != -1){
				counter++;
				$(".cke_editor_" + id).css('border-color','red');
				$("<span class='validate_error_message' style='color: red;'>"+form_script+"<br></span>").insertAfter(".cke_editor_" + id);
			}	
		});

		$('.password_checkbox').each(function(){
			var id = $(this).attr("id");
			if(!$(this).is(':checked')) {
				counter++;
				$("."+id+"").css('color','red');
			}else{
				$("."+id+"").css('color','#333');
			}
		});
		
		if(counter == 0){
			return true;
		} else {
			return false;
		}
	}
}

//modals
var modal = {
	success : function(message){
		html = '<center><i class="text-success fa fa-5x fa-check-circle"></i><br><h2>'+message+'</h2></center>';
		// bootbox.alert({
		// 	closeButton: false,
		// 		message: html,
		// 		callback: function(){
		// 			location.reload()
		// 		}
		// });
	},
	standard_confirm : function(message,btn,cb){
		// bootbox.confirm({
		//    	message: message,
		//    	buttons: {
		// 	   	confirm: {
		// 		   label: btn,
		// 		   className: 'btn-primary'
		// 	   	},
		// 	   	cancel: {
		// 		   label: 'Cancel',
		// 		   className: 'btn-default'
		// 	   	}
		//    	},
		//    	callback: cb
		// });
	},
	confirm : function(message,cb){
		// bootbox.confirm({
		//    	message: message,
		//    	buttons: {
		// 	   	confirm: {
		// 		   label: 'Yes',
		// 		   className: 'btn-primary'
		// 	   	},
		// 	   	cancel: {
		// 		   label: 'No',
		// 		   className: 'btn-default'
		// 	   	}
		//    	},
		//    	callback: cb
		// });
	},
	alert : function(message, cb){
		// bootbox.alert({
		//     message: message,
		//     callback: cb
		// });
	},
	show : function(message, size, cb){
		// bootbox.alert({
		//     message: message,
		//     size: size,
		//     callback: cb
		// });
	},
	input : function(message,type, cb){
		// bootbox.prompt({
		//     title: message,
		//     inputType: type,
		//     callback: cb
		// });
	},
	custom : function(modal, action){
		$(modal).modal(action);
	},
	loading : function(isloading){
		if(isloading){
			// bootbox.dialog({ 
			// 	message: '<center><i class="fa fa-spinner fa-spin" style="font-size:54px"></i><h2>Loading...</h2></center>', 
			// 	closeButton: false 
			// });
		} else {
			$('.bootbox').modal('hide');
		}
	}
}


function check_unique(element)
{
	var values = {};
	var countUnique = 0;
	var checks = $(element);
	checks.removeClass("error");

	checks.each(function(i, elem)
	{
		if(elem.value in values) {
			$(elem).css('border-color','red');
			$(elem).next().html("Please enter a Unique Value.");
			$(elem).next().show();
			$(values[elem.value]).css('border-color','red');
			$(values[elem.value]).next().html("Please enter a Unique Value.");
			$(values[elem.value]).next().show();
		} else {
			values[elem.value] = elem;
			++countUnique;
		}
	});

	if(countUnique == checks.size()) {
		return 0;
	} else {
		return 1;
	}
}

var pagination = {
	generate : function(total_page, element){
			var htm = '<div class="clearfix"></div>';
			htm += '<br><center><div class="btn-group">';
			htm += '  <button type="button" class="btn btn-default first-page">First</button>';
			htm += '  <button type="button" class="btn btn-default prev-page">Prev</button>';
			htm += '  <div class="btn-group dropup">';
		//	htm += '    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">';
		//	htm += '      <span class="pager_no">Page 1</span>';
			htm += '      <span class="glyphicon glyphicon-menu-down"></span>';
			htm += '    </button>';
			htm += '    <ul class="dropdown-menu" style="max-height: 200px; overflow: auto"">';
			for(var x =1; x<=total_page; x++){
				var pgno = x;
				htm += '    <li><a style="margin-left: 0px;" class="pg_no" href="#" data-value='+pgno+'>Page '+pgno+'</a></li>';
			}
			htm += '    </ul>';
			htm += '  </div>';
			htm += '  <button type="button" class="btn btn-default next-page">Next</button>';
			htm += '  <button type="button" class="btn btn-default last-page">Last</button>';
			htm += '</div></center>';
			//htm += '<div><span class="">Page 1</span>';
			htm += '<select class="form-control pager_number input-sm hidden" style="width: 70px;">';
			for(var x =1; x<=total_page; x++){
				var pgno = x;
				htm += "<option value='" + pgno + "'>" + pgno + "</option>";
			}
			htm += '</select></div>';
			$(element).html(htm);
	},
	onchange : function(cb){
		$(document).on('change','.pager_number', cb);
	}
}

var offset = 1;
$(document).on('change','.pager_number', function() {
	var page_number = parseInt($(this).val());
	offset = page_number
	$('.pager_no').html("Page " + numeral(page_number).format('0,0'));
});

$(document).on('click','.first-page', function() {
	var page_number = parseInt($('.page_number').val());
	if(page_number!=first()){
		offset = first();
		$('.pager_number').val($('.pager_number option:first').val()).change();;
		$('.pager_no').html("Page " + numeral(first()).format('0,0'));
	}
});


$(document).on('click','.prev-page', function() {
	var page_number = parseInt($('.pager_number').val());
	var prev = page_number -1;
	if(page_number!=first()){
		offset = prev;
		$('.pager_number').val(prev).change();;
		$('.pager_no').html("Page " + numeral(prev).format('0,0'));
	}
});


$(document).on('click','.next-page', function() {
	var page_number = parseInt($('.pager_number').val());
	var next = page_number +1;
	if(page_number!=last()){
		offset = next;
		$('.pager_number').val(next).change();;
		$('.pager_no').html("Page " + numeral(next).format('0,0') );
	}
});


$(document).on('click','.last-page', function() {
	var page_number = parseInt($('.page-number').val());
	if(page_number!=last()){
		offset = last();
		$('.pager_number').val($('.pager_number option:last').val()).change();
		$('.pager_no').html("Page " + numeral(last()).format('0,0'));
	}
});

function first(){
	return parseInt($('.pager_number option:first').val());
}

function last(){
	return parseInt($('.pager_number option:last').val());
}

$(document).on('click', '.pg_no', function(e){
    e.preventDefault();
    var page_no = $(this).attr("data-value");
    $('.pager_number').val(page_no).change()
});

$(document).on('change', '.selectall', function(){
	var del = 0;
	if(this.checked) { 
		$('.select').each(function() { 
		this.checked = true;  
		$('.btn_status').show();         
		});
	}else{
		$('.select').each(function() { 
		$('.btn_status').hide();
		this.checked = false;                 
		});         
	}
});


$(document).on('change', '.selectallpackages', function(){
	var del = 0;
	if(this.checked) { 
		$('.select').each(function() { 
			this.checked = true;  
			$('.btn_status_packages').show();         
		});
	}else{
		$('.select').each(function() { 
			$('.btn_status_packages').hide();
			this.checked = false;                 
		});         
	}
});


$(document).on('change', '.select', function(){
	var del = 0;
	var x = 0;
	$('.select').each(function() {  
		var ischecked =  $(this).is(":checked");
		if (this.checked==true) { x++; } 
		if (x > 0 ) {
			$('.btn_status').show();
		} else {
			$('.btn_status').hide();
			$('.selectall').attr('checked', true);
		}
	});
});


$(document).on('change', '.select-display', function(){
	if (this.checked==true) { 
	 	$(this).val(1);
	} else {
		$(this).val(0);
	}
});


var MD5 = function(s){function L(k,d){return(k<<d)|(k>>>(32-d))}function K(G,k){var I,d,F,H,x;F=(G&2147483648);H=(k&2147483648);I=(G&1073741824);d=(k&1073741824);x=(G&1073741823)+(k&1073741823);if(I&d){return(x^2147483648^F^H)}if(I|d){if(x&1073741824){return(x^3221225472^F^H)}else{return(x^1073741824^F^H)}}else{return(x^F^H)}}function r(d,F,k){return(d&F)|((~d)&k)}function q(d,F,k){return(d&k)|(F&(~k))}function p(d,F,k){return(d^F^k)}function n(d,F,k){return(F^(d|(~k)))}function u(G,F,aa,Z,k,H,I){G=K(G,K(K(r(F,aa,Z),k),I));return K(L(G,H),F)}function f(G,F,aa,Z,k,H,I){G=K(G,K(K(q(F,aa,Z),k),I));return K(L(G,H),F)}function D(G,F,aa,Z,k,H,I){G=K(G,K(K(p(F,aa,Z),k),I));return K(L(G,H),F)}function t(G,F,aa,Z,k,H,I){G=K(G,K(K(n(F,aa,Z),k),I));return K(L(G,H),F)}function e(G){var Z;var F=G.length;var x=F+8;var k=(x-(x%64))/64;var I=(k+1)*16;var aa=Array(I-1);var d=0;var H=0;while(H<F){Z=(H-(H%4))/4;d=(H%4)*8;aa[Z]=(aa[Z]| (G.charCodeAt(H)<<d));H++}Z=(H-(H%4))/4;d=(H%4)*8;aa[Z]=aa[Z]|(128<<d);aa[I-2]=F<<3;aa[I-1]=F>>>29;return aa}function B(x){var k="",F="",G,d;for(d=0;d<=3;d++){G=(x>>>(d*8))&255;F="0"+G.toString(16);k=k+F.substr(F.length-2,2)}return k}function J(k){k=k.replace(/rn/g,"n");var d="";for(var F=0;F<k.length;F++){var x=k.charCodeAt(F);if(x<128){d+=String.fromCharCode(x)}else{if((x>127)&&(x<2048)){d+=String.fromCharCode((x>>6)|192);d+=String.fromCharCode((x&63)|128)}else{d+=String.fromCharCode((x>>12)|224);d+=String.fromCharCode(((x>>6)&63)|128);d+=String.fromCharCode((x&63)|128)}}}return d}var C=Array();var P,h,E,v,g,Y,X,W,V;var S=7,Q=12,N=17,M=22;var A=5,z=9,y=14,w=20;var o=4,m=11,l=16,j=23;var U=6,T=10,R=15,O=21;s=J(s);C=e(s);Y=1732584193;X=4023233417;W=2562383102;V=271733878;for(P=0;P<C.length;P+=16){h=Y;E=X;v=W;g=V;Y=u(Y,X,W,V,C[P+0],S,3614090360);V=u(V,Y,X,W,C[P+1],Q,3905402710);W=u(W,V,Y,X,C[P+2],N,606105819);X=u(X,W,V,Y,C[P+3],M,3250441966);Y=u(Y,X,W,V,C[P+4],S,4118548399);V=u(V,Y,X,W,C[P+5],Q,1200080426);W=u(W,V,Y,X,C[P+6],N,2821735955);X=u(X,W,V,Y,C[P+7],M,4249261313);Y=u(Y,X,W,V,C[P+8],S,1770035416);V=u(V,Y,X,W,C[P+9],Q,2336552879);W=u(W,V,Y,X,C[P+10],N,4294925233);X=u(X,W,V,Y,C[P+11],M,2304563134);Y=u(Y,X,W,V,C[P+12],S,1804603682);V=u(V,Y,X,W,C[P+13],Q,4254626195);W=u(W,V,Y,X,C[P+14],N,2792965006);X=u(X,W,V,Y,C[P+15],M,1236535329);Y=f(Y,X,W,V,C[P+1],A,4129170786);V=f(V,Y,X,W,C[P+6],z,3225465664);W=f(W,V,Y,X,C[P+11],y,643717713);X=f(X,W,V,Y,C[P+0],w,3921069994);Y=f(Y,X,W,V,C[P+5],A,3593408605);V=f(V,Y,X,W,C[P+10],z,38016083);W=f(W,V,Y,X,C[P+15],y,3634488961);X=f(X,W,V,Y,C[P+4],w,3889429448);Y=f(Y,X,W,V,C[P+9],A,568446438);V=f(V,Y,X,W,C[P+14],z,3275163606);W=f(W,V,Y,X,C[P+3],y,4107603335);X=f(X,W,V,Y,C[P+8],w,1163531501);Y=f(Y,X,W,V,C[P+13],A,2850285829);V=f(V,Y,X,W,C[P+2],z,4243563512);W=f(W,V,Y,X,C[P+7],y,1735328473);X=f(X,W,V,Y,C[P+12],w,2368359562);Y=D(Y,X,W,V,C[P+5],o,4294588738);V=D(V,Y,X,W,C[P+8],m,2272392833);W=D(W,V,Y,X,C[P+11],l,1839030562);X=D(X,W,V,Y,C[P+14],j,4259657740);Y=D(Y,X,W,V,C[P+1],o,2763975236);V=D(V,Y,X,W,C[P+4],m,1272893353);W=D(W,V,Y,X,C[P+7],l,4139469664);X=D(X,W,V,Y,C[P+10],j,3200236656);Y=D(Y,X,W,V,C[P+13],o,681279174);V=D(V,Y,X,W,C[P+0],m,3936430074);W=D(W,V,Y,X,C[P+3],l,3572445317);X=D(X,W,V,Y,C[P+6],j,76029189);Y=D(Y,X,W,V,C[P+9],o,3654602809);V=D(V,Y,X,W,C[P+12],m,3873151461);W=D(W,V,Y,X,C[P+15],l,530742520);X=D(X,W,V,Y,C[P+2],j,3299628645);Y=t(Y,X,W,V,C[P+0],U,4096336452);V=t(V,Y,X,W,C[P+7],T,1126891415);W=t(W,V,Y,X,C[P+14],R,2878612391);X=t(X,W,V,Y,C[P+5],O,4237533241);Y=t(Y,X,W,V,C[P+12],U,1700485571);V=t(V,Y,X,W,C[P+3],T,2399980690);W=t(W,V,Y,X,C[P+10],R,4293915773);X=t(X,W,V,Y,C[P+1],O,2240044497);Y=t(Y,X,W,V,C[P+8],U,1873313359);V=t(V,Y,X,W,C[P+15],T,4264355552);W=t(W,V,Y,X,C[P+6],R,2734768916);X=t(X,W,V,Y,C[P+13],O,1309151649);Y=t(Y,X,W,V,C[P+4],U,4149444226);V=t(V,Y,X,W,C[P+11],T,3174756917);W=t(W,V,Y,X,C[P+2],R,718787259);X=t(X,W,V,Y,C[P+9],O,3951481745);Y=K(Y,h);X=K(X,E);W=K(W,v);V=K(V,g)}var i=B(Y)+B(X)+B(W)+B(V);return i.toLowerCase()};


//sha1 convert
function sha1(msg) {
	function rotate_left(n,s) {
		var t4 = ( n<<s ) | (n>>>(32-s));
		return t4;
	};
	function lsb_hex(val) {
		var str="";
		var i;
		var vh;
		var vl;
		for( i=0; i<=6; i+=2 ) {
			vh = (val>>>(i*4+4))&0x0f;
			vl = (val>>>(i*4))&0x0f;
			str += vh.toString(16) + vl.toString(16);
		}
		return str;
	};
	function cvt_hex(val) {
		var str="";
		var i;
		var v;
		for( i=7; i>=0; i-- ) {
			v = (val>>>(i*4))&0x0f;
			str += v.toString(16);
		}
		return str;
  	};
	function Utf8_encode(string) {
			string = string.replace(/\r\n/g,"\n");
			var utftext = "";
			for (var n = 0; n < string.length; n++) {
				var c = string.charCodeAt(n);
			if (c < 128) {
				utftext += String.fromCharCode(c);
			}
			else if((c > 127) && (c < 2048)) {
				utftext += String.fromCharCode((c >> 6) | 192);
				utftext += String.fromCharCode((c & 63) | 128);
			}
			else {
				utftext += String.fromCharCode((c >> 12) | 224);
				utftext += String.fromCharCode(((c >> 6) & 63) | 128);
				utftext += String.fromCharCode((c & 63) | 128);
			}
			}
		return utftext;
	};
	var blockstart;
	var i, j;
	var W = new Array(80);
	var H0 = 0x67452301;
	var H1 = 0xEFCDAB89;
	var H2 = 0x98BADCFE;
	var H3 = 0x10325476;
	var H4 = 0xC3D2E1F0;
	var A, B, C, D, E;
	var temp;
	msg = Utf8_encode(msg);
	var msg_len = msg.length;
	var word_array = new Array();
	for( i=0; i<msg_len-3; i+=4 ) {
		j = msg.charCodeAt(i)<<24 | msg.charCodeAt(i+1)<<16 |
		msg.charCodeAt(i+2)<<8 | msg.charCodeAt(i+3);
		word_array.push( j );
	}
	switch( msg_len % 4 ) {
		case 0:
			i = 0x080000000;
			break;
		case 1:
			i = msg.charCodeAt(msg_len-1)<<24 | 0x0800000;
			break;
		case 2:
			i = msg.charCodeAt(msg_len-2)<<24 | msg.charCodeAt(msg_len-1)<<16 | 0x08000;
			break;
		case 3:
			i = msg.charCodeAt(msg_len-3)<<24 | msg.charCodeAt(msg_len-2)<<16 | msg.charCodeAt(msg_len-1)<<8  | 0x80;
			break;
	}
	word_array.push( i );
	while( (word_array.length % 16) != 14 ) word_array.push( 0 );
	word_array.push( msg_len>>>29 );
	word_array.push( (msg_len<<3)&0x0ffffffff );
	for ( blockstart=0; blockstart<word_array.length; blockstart+=16 ) {
		for( i=0; i<16; i++ ) W[i] = word_array[blockstart+i];
		for( i=16; i<=79; i++ ) W[i] = rotate_left(W[i-3] ^ W[i-8] ^ W[i-14] ^ W[i-16], 1);
		A = H0;
		B = H1;
		C = H2;
		D = H3;
		E = H4;
		for( i= 0; i<=19; i++ ) {
		temp = (rotate_left(A,5) + ((B&C) | (~B&D)) + E + W[i] + 0x5A827999) & 0x0ffffffff;
		E = D;
		D = C;
		C = rotate_left(B,30);
		B = A;
		A = temp;
		}
		for( i=20; i<=39; i++ ) {
		temp = (rotate_left(A,5) + (B ^ C ^ D) + E + W[i] + 0x6ED9EBA1) & 0x0ffffffff;
		E = D;
		D = C;
		C = rotate_left(B,30);
		B = A;
		A = temp;
		}
		for( i=40; i<=59; i++ ) {
		temp = (rotate_left(A,5) + ((B&C) | (B&D) | (C&D)) + E + W[i] + 0x8F1BBCDC) & 0x0ffffffff;
		E = D;
		D = C;
		C = rotate_left(B,30);
		B = A;
		A = temp;
		}
		for( i=60; i<=79; i++ ) {
		temp = (rotate_left(A,5) + (B ^ C ^ D) + E + W[i] + 0xCA62C1D6) & 0x0ffffffff;
		E = D;
		D = C;
		C = rotate_left(B,30);
		B = A;
		A = temp;
		}
		H0 = (H0 + A) & 0x0ffffffff;
		H1 = (H1 + B) & 0x0ffffffff;
		H2 = (H2 + C) & 0x0ffffffff;
		H3 = (H3 + D) & 0x0ffffffff;
		H4 = (H4 + E) & 0x0ffffffff;
	}
	var temp = cvt_hex(H0) + cvt_hex(H1) + cvt_hex(H2) + cvt_hex(H3) + cvt_hex(H4);

	return temp.toLowerCase();
}

