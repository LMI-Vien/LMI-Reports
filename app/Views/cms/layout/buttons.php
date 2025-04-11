
<div class="box-header with-border">
<?php 
	if(isset($buttons)){
		foreach ($buttons as $key => $value) {
			switch ($value) {
				case 'add':
					echo '<a href="#" id="btn_add" class="btn_add btn-sm btn-success cms-btn" ><span class="fa fa fa-plus "></span> Add</a>';
					break;
				
				case 'update':
					echo '<a href="#" id="btn_update" class="btn_update btn-sm btn-primary cms-btn" ><span class="fa fa-floppy-o"></span> Update </a>';
					break;

				case 'save':
					echo '<a href="#" id="btn_save" class="btn_save btn-sm btn-default cms-btn"  ><span class="fa fa fa-floppy-o"></span> Save </a>';
					break;

				case 'close':
					echo '<a href="#" id="btn_close" class="btn_close btn-sm btn-default cms-btn" ><span class="fa fa fa-close"></span> Close </a>';
					break;
					
				case 'back':
					echo '<a href="#" id="btn_back" class="btn_close btn-sm btn-default cms-btn" ><span class="fa fa fa-arrow-left"></span> Back </a>';
					break;
				   
				case 'cancel':
					echo '<a href="#" id="btn_cancel" class="btn_cancel btn-sm btn-default cms-btn" ><span class="fa fa fa-times-circle"></span> Cancel </a>';
					break;

                case 'delete':
                    echo '<a href="#" id="btn_delete" class="btn_delete btn-sm btn-danger cms-btn" ><span class="fa fa-trash"></span> Delete </a>';
                    break;

				case 'sitemap':
					echo '<a href="#" id="btn_sitemap" path="" class="btn_sitemap btn-sm btn-default cms-btn"  ><span class="fa fa fa-map"></span> Generate Sitemap </a>';
					break;

				case 'reset':
					echo '<a href="#" id="btn_reset" path="" class="btn_reset btn-sm btn-default pull-right cms-btn"  ><span class="fa fa fa-refresh"></span> Reset </a>';
					break;

                case 'status':
                    echo '<select class="status pull-right"  title="status">
                            <option class="textholder"  selected disabled>STATUS</option>
                            <option value="1">Active</option>
                            <option value="">Inactive</option>
                        </select>';
                         
                    break;

				case 'search':
					echo '<div id="form_search" class="form-search">
							<div class="form-group has-feedback ">
						        <div class="input-group">
									<div class="input-group-prepend">
										<button id="search_button" class="input-group-text">
											<i class="fa fa-search"></i>
										</button>
									</div>
									<input 
										type="text" 
										class="form-control search-query" 
										id="search_query" 
										placeholder="Search..."
									>
								</div>
						      </div>
						</div>';
					break;

				case 'export':
                      echo '<a href="#" id="btn_export" class="btn_export btn-sm cms-btn btn-success" ><span class="fas fa-file-export"></span> Export </a>';
                      break;
                case 'import':
                      echo '<a href="#" id="btn_import" class="btn_import btn-sm btn-success cms-btn" ><span class="fas fa-file-export"></span> Import </a>';
                      break;
				case 'filter':
					  echo '<a href="#" id="btn_filter" class="btn_filter btn-sm btn-success cms-btn"><span class="fas fa-filter"></span> Filter</a>
								<div class="modal" id="filter_modal">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header">
												<h1 class="modal-title">
													<b></b>
												</h1>
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													<span>&times;</span>
												</button>
											</div>
											<div class="modal-body">
												<form id="form-modal">
													<div class="row">
														<div class="col-2">
															<label class="form-label">Status:</label>
														</div>
														<div class="col">
															<div class="m-2">
																<div class="form-check">
																	<input type="radio" id="active_f" name="status_f" class="form-check-input" value=1>
																	<label for="active_f" class="form-check-label">Active</label>
																</div>
																<div class="form-check">
																	<input type="radio" id="inactive_f" name="status_f" class="form-check-input" value=0>
																	<label for="inactive_f" class="form-check-label">Inactive</label>
																</div>
															</div>
														</div>
													</div>
													
													<div class="row mb-4">
														<div class="col-3">
															<label class="form-label">Creation Date:</label>
														</div>
														<div class="col">
															<label for="created_date_from" class="form-label">From:</label>
															<input type="date" id="created_date_from" class="form-control">
														</div>
														<div class="col">
															<label for="created_date_to" class="form-label">To:</label>
															<input type="date" id="created_date_to" class="form-control">
														</div>
													</div>
													
													<div class="row mb-4">
														<div class="col-3">
															<label class="form-label">Modified Date:</label>
														</div>
														<div class="col">
															<label for="modified_date_from" class="form-label">From:</label>
															<input type="date" id="modified_date_from" class="form-control">
														</div>
														<div class="col">
															<label for="modified_date_to" class="form-label">To:</label>
															<input type="date" id="modified_date_to" class="form-control">
														</div>
													</div>
													
													<div class="row">
														<div class="col-3">
															<label class="form-label">Order By:</label>
															<div class="m-2">
																<div class="form-check">
																	<input type="radio" id="asc" name="order" class="form-check-input" value="ASC">
																	<label for="asc" class="form-check-label">Ascending</label>
																</div>
																<div class="form-check">
																	<input type="radio" id="desc" name="order" class="form-check-input" value="DESC">
																	<label for="desc" class="form-check-label">Descending</label>
																</div>
															</div>
														</div>

														<div class="col">
															<label class="form-label">Column:</label>
															<div class="m-2">
																<div class="form-check">
																	<input type="radio" id="status_column" name="column" class="form-check-input" value="status">
																	<label for="status_column" class="form-check-label">Status</label>
																</div>
																<div class="form-check">
																	<input type="radio" id="creation_date_column" name="column" class="form-check-input" value="created_date">
																	<label for="creation_date_column" class="form-check-label">Creation Date</label>
																</div>
																<div class="form-check">
																	<input type="radio" id="modified_date_column" name="column" class="form-check-input" value="updated_date">
																	<label for="modified_date_column" class="form-check-label">Modified Date</label>
																</div>
															</div>
														</div>
													</div>

												</form>
											</div>
											<div class="modal-footer">
												<button id="button_f" class="btn save">Filter</button>
												<button id="clear_f" class="btn caution">Clear Filter</button>
											</div>
											
										</div>
									</div>
								</div>';
					  break;

                case 'date_range':
                      echo '<div class="form-group drange">
	                            <input type="text" class="range-date start-date form-control" placeholder="Date From" style="width: 95px;"  >
	                            <input type="text" class="range-date end-date form-control" placeholder="Date To" style="width: 95px;"   disabled>
	                            <button type="button" id="btn_filter" class="btn-default btn-filter btn-sm cms-btn"  ><i class="fa fa-filter"></i> Filter</button>
	                            <a href="#" path="" id="btn_reset" class="btn_reset btn-sm btn btn-default col-bday-4 cms-btn" ><span class="fa fa fa-refresh"></span> Reset </a>
                            </div>';
                      break;
                      
               case 'category':
                  echo '<a href="#" id="btn_category" class="btn_category btn-sm btn-default cms-btn"><span class="fa fa fa-plus "></span> Category</a>';
                  break;

                case 'fetch':
					echo '<a href="#" id="btn_fetch" class="btn_fetch btn-sm btn-default cms-btn" ><span class="fa fa fa-refresh"></span> Fetch </a>';
					break;

				case 'download':
					echo '<a id="btn_download" class="btn_download btn-sm btn-default cms-btn" ><span class="fa fa fa-download"></span> Download </a>';
				break;
				
				case 'back':
					echo '<a href="#" id="btn_back" class="btn_back btn-sm btn-default cms-btn" ><span class="fa fa fa-arrow-left"></span> Back </a>';
					break;

				case 'templates':
					echo '<a href="#" id="btn_templates" class="btn_add btn-sm btn-success cms-btn" ><span class="fa fa fa-plus "></span> Templates </a>';
					break;
					
				default:
					# code...
					break;
			}
		}
	}

?>

<a href="#" data-status=1  class="status_action btn_status btn-sm btn-success cms-btn btn_publish"><span class="fa fa-check"></span> Publish </a>
<a href="#" data-status=0 class="status_action btn_status btn-sm btn-success cms-btn btn_unpublish" ><span class="fa fa-ban"></span> Unpublish </a>
<a href="#" data-status=-2 class="status_action btn_status btn-sm btn-default delete cms-btn btn_trash" ><span class="fa fa-trash"></span> Trash </a>
</div>

<style type="text/css">
	.drange{
	    display: inline-block;
	    position: relative;
	}

	.form-search{
	    position: absolute;
	    right:6em;
	}

	.range-date.start-date {
	    width: 90px;
	    display: inline-block;
		height: 31px;
		border-radius: 7px;
	}

	.range-date.end-date {
	    width: 90px;
	    display: inline-block;
	    height: 31px;
		border-radius: 7px;
	}

	.menu-tips{
		padding: 10px;
		font-size: 13px;
		width: 260px;
		background: #fff;
		color: #444;
		font-family: 'Montserrat';
		text-align: center;
	}

	.menu-tips {
	  	top: 100%;
	}

	.menu-tips::before {
		content: " ";
		position: absolute;
		border-width: 10px;
		border-style: solid;
	}

	.menu-tips::before {
	    bottom: 100%;
	    border-color: transparent transparent white transparent;
	}

	.cms-btn{
		width: 90px;
	}

	.btn-filter, .btn_reset{
		margin-bottom: 4px;
	}

	.input-group-glue {
		width: 0;
		display: table-cell;
	}

	.input-group-glue + .form-control {
		border-left: none;
	}

	.btn_sitemap{
		width: 130px;
	}

    .form-horizontal .has-feedback .form-control-feedback {
        right: 5px;
        top: -2px;
    }
    .cms-btn {

        border-radius:10px;
        width: 112px !important;
        padding: 8px;
        min-width: 85px;
        max-height: 30px;
        line-height: 0.5;
        /* background-color: #1439a6; */
        /* color: #000000 !important; */
        border-radius: 10px;
        margin-right: 5px;
        box-shadow: 6px 6px 15px rgba(0, 0, 0, 0.5);
    }

    .cms-btn:focus  {
        color: #000000 !important ; 
        background-color: #8c8f8c !important ; 
        border: 0px solid #339933 !important ; 
    }
    .cms-btn:hover {
        /* color: #000000 !important ;  */
        /* background-color: #8c8f8c !important ;  */
        border: 0px solid #339933 !important ; 
    }
	#filter_modal .modal-dialog {
		text-align: left;
		max-width: 550px;
	}

	#filter_modal .modal-body {
		padding: 25px;
	}
	#filter_modal .row {
		margin-top: 0px !important;
		margin-bottom: 30px !important;
	}
	.row.mb-4 {
		margin-bottom: 50px !important;
	}
	#form_search {
		margin-right: -95px !important;
	}

</style>

<script type="text/javascript">
	$('.status_action').hide();
 
    $(document).on('click', '#btn_close', function(){   
        <?php 
            $url =  "http://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
            $escaped_url = htmlspecialchars( $url, ENT_QUOTES, 'UTF-8' );

            $urls = explode('/', $escaped_url);
            array_pop($urls);
        ?>
        window.location.href = "<?= implode('/', $urls);?>";
    });

    $(function() {
		$('[data-toggle="tooltip"]').tooltip();   
	});
    
	// $('.start-date').materialDatePicker({
    // 	time : false,
    // 	weekStart : 0
    // }).on('change', function(e, date){
    // 	$('.end-date').val($('.start-date').val()).prop('disabled', false);
    // 	$('.end-date').materialDatePicker({
    // 		time : false,
    // 		weekStart : 0
    // 	});
    // 	$('.end-date').materialDatePicker('setMinDate', date);
    // });
    

    $(document).on('cut copy paste input', '.start-date, .end-date', function(e) {
        e.preventDefault();
    });

    $(document).on('click', '#btn_reset', function(){
    	$('.start-date').val('');
    	$('.end-date').val('').prop('disabled', true);
    	$('#search_query').val('');
    });

</script>
