<?php
namespace Config;

use CodeIgniter\Config\BaseConfig;

class Standard extends BaseConfig
{
    public $add_success = "<b>Success!</b> Record has been added.";
    public $save_success = "<b>Success!</b> Record has been saved.";
    public $update_success = "<b>Success!</b> Record has been updated.";
    public $session_timeout = "Session has been idle over its time limit. You will be logged off automatically.";
    public $delete_success = "<b>Success!</b> Record has been deleted.";
    public $activate_success = "<b>Success!</b> Record(s) have been activated.";
    public $deactivate_success = "<b>Success!</b> Record(s) have been deactivated.";
    public $save_draft_success = "<b>Success!</b> Record has been saved as draft.";
    public $sent_success = "<b>Success!</b> Record has been sent.";
    public $submitted_success = "<b>Success!</b> Record has been submitted.";
    public $cancelled_success = "<b>Success!</b> Record has been cancelled.";
    public $declined_success = "<b>Success!</b> Record has been declined.";
    public $package_success = "<b>Success!</b> Package has been installed.";
    public $publish_success = "<b>Success!</b> Record has been published.";
    public $unpublish_success = "<b>Success!</b> Record has been unpublished.";
    public $deleted_file_success = "<b>Success!</b> File(s) has been deleted.";
    public $export_success = "<b>Success!</b> Export completed!";
    public $download_success = "<b>Success!</b> Download completed!";
    public $no_data_exist = "<b>Error!</b> No files to download!";
    public $unblock_success = "<b>Success!</b> Record has been unblocked.";
    public $user_role_used = "<b>Error!</b> User Role is in used.";
    public $user_role_deactivated = "<b>Error!</b> User Role is deactivated or trashed.";
    public $value_used = "<b>Error!</b> Unable to set the record to Inactive/Trash since it is currently used.";
    public $value_trashed = "<b>Error!</b> Value is inactive/trashed.";
    public $scrape_success = "<b>Notice:</b> Article has been automatically scraped (for Facebook posting purposes).";
    
    
    //ALERT FAILED
    public $scrape_fail = "<b>Warning:</b> Article was not scraped.";
    public $failed_transaction = "An error occurred while processing the request. Please try again later.";
    public $no_file = "<b>Error!</b> File does not exists.";
    public $insert_failed = "<b>Error!</b> Failed to Insert Data.";
    public $update_failed = "<b>Error!</b> Failed to Update Data.";
    public $sent_failed = "<b>Error!</b> Failed to send.";
    public $product_delete_failed = "<b>Error!</b> Product still tagged to a Product Information or Site.";
    public $publish_failed = "<b>Error!</b> Record was not published.";
    public $delete_failed = "<b>Error!</b> Record was not published.";
    public $unpublish_failed = "<b>Error!</b> Record was not unpublished.";
    public $add_failed = "<b>Error!</b> Failed to Add Data.";
    public $inactive_modal_error = "Error: Unable to set the record to Inactive since it is currently used.";
    public $missing_input = "<b>Error!</b> Missing input please fill all required fields.";
    
    //VALIDATION
    public $data_exist = "The information already exists.";
    public $email_exist = "This email address is already registered.";
    public $mobile_exist = "This mobile number is already registered.";
    public $username_exist = "Username already exists.";
    public $hasUnder = "Meta has under links, Can't change to child type!";
    public $menu_hasUnder = "Menu has under links, Can't change to module type!";
    public $package_field_duplicate = "Required fields has duplicate values.";
    public $two_admin_exist = "The maximum Admin account that can be created is two.";
    public $email_format = "Invalid email address format.";
    public $username_min = "Minimum character count is 3.";
    public $site_logo = "No site logo found.";
    public $site_favicon = "No site favicon found.";
    public $greater_than_year = "Year entered is greater than current year.";
    public $invalid_url = "Please enter valid URL";
    public $invalid_age = "Please enter valid age";
    public $invalid_script = "Invalid script";
    public $product_used = "Product has a site already.";
    public $required_field = "This field is required.";
    public $existing_user_role_name= "Existing User Role name.";
    public $existing_user_name = "Existing User Name.";
    public $trashed_value = "Error: Value is inactive/trashed.";
    
    //ERRORS
    public $invalid_user_password = "Invalid username and password. Please try again.";
    public $invalid_password = "Incorrect password. Please try again.";
    
    //CUSTOM MESSAGE
    public $newsletter_subscribed = "Success!<br>You have subscribed to our newsletter.";
    public $newsletter_unsubscribed = "Thank you!<br>You have unsubscribed from our news and updates.";
    public $category_limit = "Maximum Category";
    public $package_empty = "Package builder is empty.";
    public $no_records = "No records to show.";
    //FORM VALIDATION
    //Note : Declare your custom dialog in your header if you are using javascript
    //Ex : var form_invalid_email = '<php dialog('form_invalid_email') >';
    public $form_empty = "This is a required field."; // do not remove, required in custom.js
    public $form_invalid_email = "Please enter a valid email address."; // do not remove, required in custom.js
    public $form_script = "Javascript and PHP Script are not allowed."; // do not remove, required in custom.js
    public $form_invalid_mobile_no = "Invalid mobile number. Required format : 09XXXXXXXXX"; // do not remove, required in custom.js
    public $form_nohtml = "HTML Tags are not allowed"; // do not remove, required in custom.js
    public $form_invalid_extension = "File type is not supported."; // do not remove, required in custom.js
    public $form_max_size = "Maximum file size exceeded"; // do not remove, required in custom.js
    public $form_invalid_captcha = "Invalid Captcha";
    public $form_invalid_value = "Invalid Value";  // do not remove, required in custom.js`
    public $form_invalid_year = "Please enter numeric values";
    public $special_characters = "Specified special character is not allowed.";
    public $date_invalid_period = "Period Date To should not be lesser than Period Date From.";
 
 
    public $confirm_add = array(
                                "message"  => "Are you sure you want to add this record?",
                                "confirm"  => "Add",
                                "cancel"   => "Cancel",
                            );
    
    public $confirm_update = array(
                                "message"  => "Are you sure you want to update this record?",
                                "confirm"  => "Update",
                                "cancel"   => "Cancel",
                            );
    
    public $confirm_delete = array(
                                "message"  => "Are you sure you want to delete this record?",
                                "confirm"  => "Delete",
                                "cancel"   => "Cancel",
                            );
    
    public $confirm_save = array(
                                "message"  => "Are you sure you want to save this record?",
                                "confirm"  => "Save",
                                "cancel"   => "Cancel",
                            );
    
    public $confirm_draft = array(
                                "message"  => "Are you sure you want to save this record as draft?",
                                "confirm"  => "Save as Draft",
                                "cancel"   => "Cancel",
                            );
    
    public $confirm_upload = array(
                                "message"  => "Are you sure you want to upload this file?",
                                "confirm"  => "Upload",
                                "cancel"   => "Cancel",
                            );
    
    public $confirm_activate = array(
                                "message"  => "Are you sure you want to activate this record?",
                                "confirm"  => "Activate",
                                "cancel"   => "Cancel",
                            );
    
    public $confirm_deactivate = array(
                                "message"  => "Are you sure you want to deactivate this record?",
                                "confirm"  => "Deactivate",
                                "cancel"   => "Cancel",
                            );
    
    public $confirm_send= array(
                                "message"  => "Are you sure you want to send this record?",
                                "confirm"  => "Send",
                                "cancel"   => "Cancel",
                            );

    public $confirm_approve= array(
                                "message"  => "Are you sure you want to approve this record?",
                                "confirm"  => "Yes",
                                "cancel"   => "No",
                            );
    public $confirm_send_approval= array(
                                "message"  => "Are you sure you want to send this for approval?",
                                "confirm"  => "Yes",
                                "cancel"   => "No",
                            );


    public $confirm_disapprove= array(
                                "message"  => "Are you sure you want to disapprove this record?",
                                "confirm"  => "Yes",
                                "cancel"   => "No",
                            );
    
    public $confirm_submit= array(
                                "message"  => "Are you sure you want to submit this record?",
                                "confirm"  => "Submit",
                                "cancel"   => "Cancel",
                            );
    
    public $confirm_cancel= array(
                                "message"  => "Are you sure you want to cancel?",
                                "confirm"  => "Yes",
                                "cancel"   => "No",
                            );
    
    public $confirm_publish= array(
                                "message"  => "Are you sure you want to publish this record?",
                                "confirm"  => "Publish",
                                "cancel"   => "Cancel",
                            );
    
    public $confirm_unpublish= array(
                                "message"  => "Are you sure you want to unpublish this record?",
                                "confirm"  => "Unpublish",
                                "cancel"   => "Cancel",
                            );
    
    public $package_install= array(
                                "message"  => "Are you sure you want to install this package?",
                                "confirm"  => "Install",
                                "cancel"   => "Cancel",
                            );
    
    public $confirm_export= array(
                                "message"  => "Are you sure  you want to extract this file?",
                                "confirm"  => "Export",
                                "cancel"   => "Cancel",
                            );
    
    public $confirm_edit= array(
                                "message"  => "Are you sure you want to edit this record?",
                                "confirm"  => "Yes",
                                "cancel"   => "Cancel",
                            );
    
    public $confirm_publish_meta= array(
                                "message"  => "Are you sure you want to publish this record? The records under this will also be published.",
                                "confirm"  => "Publish",
                                "cancel"   => "Cancel",
                            );
    
    public $confirm_unpublish_meta= array(
                                "message"  => "Are you sure you want to unpublish this record? The records under this will also be unpublished.",
                                "confirm"  => "Unpublish",
                                "cancel"   => "Cancel",
                            );
    
    public $confirm_delete_meta= array(
                                "message"  => "Are you sure you want to delete this record? The records under this will also be deleted.",
                                "confirm"  => "Delete",
                                "cancel"   => "Cancel",
                            );
    
    public $confirm_add_user_tagging= array(
                                "message"  => "Are you sure you want to add the following User/s?",
                                "confirm"  => "Yes",
                                "cancel"   => "Cancel",
                            );
    
    public $confirm_remove_user_tagging= array(
                                "message"  => "Are you sure you want to remove the following User/s?",
                                "confirm"  => "Yes",
                                "cancel"   => "Cancel",
                            );
    
    public $confirm_remove_single_user_tagging= array(
                                "message"  => "Are you sure you want to remove this User?",
                                "confirm"  => "Yes",
                                "cancel"   => "Cancel",
                            );
    
    public $confirm_site_status_update= array(
                                "message"  => "Are you sure you want to Update this record?",
                                "confirm"  => "Yes",
                                "cancel"   => "Cancel",
                            );
    public $confirm_add_category_tagging= array(
                                "message"  => "Are you sure you want to add the following Categories/s?",
                                "confirm"  => "Yes",
                                "cancel"   => "Cancel",
                            );
    
    public $confirm_remove_category_tagging= array(
                                "message"  => "Are you sure you want to remove the following Category/s?",
                                "confirm"  => "Yes",
                                "cancel"   => "Cancel",
                            );
    
    public $confirm_add_related_article_tagging= array(
                                "message"  => "Are you sure you want to save this record? ",
                                "confirm"  => "Yes",
                                "cancel"   => "No",
                            );
    
    public $confirm_remove_related_article_tagging= array(
                                "message"  => "Are you sure you want to delete this record? ",
                                "confirm"  => "Yes",
                                "cancel"   => "No",
                            );
                            
    public $confirm_add_related_product_tagging= array(
        "message"  => "Are you sure you want to add the following Product/s?",
        "confirm"  => "Yes",
        "cancel"   => "Cancel",
    );
    
    public $confirm_remove_related_product_tagging= array(
                                "message"  => "Are you sure you want to remove the following Product/s",
                                "confirm"  => "Yes",
                                "cancel"   => "Cancel",
                            );
    
    public $confirm_remove_single_related_product_tagging= array(
                                "message"  => "Are you sure you want to remove this Product?",
                                "confirm"  => "Yes",
                                "cancel"   => "Cancel",
                            );
                            
    public $confirm_remove_single_category_tagging= array(
                                "message"  => "Are you sure you want to remove this Category?",
                                "confirm"  => "Yes",
                                "cancel"   => "Cancel",
                            );
    
    public $confirm_unblock= array(
                                "message"  => "Are you sure you want to Unblock this record?",
                                "confirm"  => "Unblock",
                                "cancel"   => "Cancel",
                            );
                            
    public $confirm_delete_file= array(
                                "message"  => "Are you sure you want to delete this file?",
                                "confirm"  => "Delete",
                                "cancel"   => "Cancel",
                            );
                            
    public $confirm_add_site_product_article_tagging= array(
                                "message"  => "Are you sure you want to add the following Product/s?",
                                "confirm"  => "Yes",
                                "cancel"   => "Cancel",
                            );
    
    public $confirm_remove_site_product_article_tagging= array(
                                "message"  => "Are you sure you want to remove the following Product/s?",
                                "confirm"  => "Yes",
                                "cancel"   => "Cancel",
                            );
    
                            
    
    public $confirm_remove_record= array(
                                "message"  => "Are you sure you want to remove the following Record/s?",
                                "confirm"  => "Yes",
                            );
    public $confirm_add_image= array(
                                "message"  => "Are you sure you want to add the Image/s?",
                                "confirm"  => "Yes",
                                "cancel"   => "Cancel",
                            );
    public $confirm_remove_image= array(
                                "message"  => "Are you sure you want to remove this Image/s?",
                                "confirm"  => "Yes",
                                "cancel"   => "Cancel",
                            );
    
    public $confirm_add_cause= array(
                                "message"  => "Are you sure you want to add Cause?",
                                "confirm"  => "Yes",
                                "cancel"   => "Cancel",
                            );
    
    public $confirm_remove_cause= array(
                                "message"  => "Are you sure you want to remove this Cause?",
                                "confirm"  => "Yes",
                                "cancel"   => "Cancel",
                            );
    
    public $confirm_add_media= array(
                                "message"  => "Are you sure you want to add Media?",
                                "confirm"  => "Yes",
                                "cancel"   => "Cancel",
                            );
                            
    public $confirm_remove_media= array(
                                "message"  => "Are you sure you want to remove this Media?",
                                "confirm"  => "Yes",
                                "cancel"   => "Cancel",
                            );
    
    public $confirm_add_ingredient_detail= array(
                                "message"  => "Are you sure you want to add Detail?",
                                "confirm"  => "Yes",
                                "cancel"   => "Cancel",
                            );
    
    public $confirm_add_prevention= array(
                                "message"  => "Are you sure you want to add Prevention?",
                                "confirm"  => "Yes",
                                "cancel"   => "Cancel",
                            );
    
    public $confirm_remove_ingredient_detail= array(
                                "message"  => "Are you sure you want to remove Detail?",
                                "confirm"  => "Yes",
                                "cancel"   => "Cancel",
                            );
                            
    public $confirm_remove_prevention= array(
                                "message"  => "Are you sure you want to remove this Prevention?",
                                "confirm"  => "Yes",
                                "cancel"   => "Cancel",
                            );
    /*
    |--------------------------------------------------------------------------
    | Input Standards
    |--------------------------------------------------------------------------
    |
    |   $config = array(
    |        'type'         => (string),        // text, email, dropdown, radio, textarea, filemanager, ckeditor, timepicker, date, mobile_number, youtube, captcha, table
    |        'name'         => (string),        // element name
    |        'form-align'   => (string),        // vertical, horizontal : default is vertical
    |        'id'           => (string),        // element id
    |        'max'          => (int),           // max length
    |        'required'     => (boolean),       // if input is required
    |        'alphaonly'    => (boolean),       // if input requires alpha only A-Z
    |        'class'        => (string),        // adding custom class
    |        'placeholder'  => (string),        // input placeholder
    |        'label'        => (string),        // input label text
    |        'accept'       => (string),        // accepted characters *for TYPE:TEXT only ex : /[^a-zA-Z .,-]/g
    |        'rows'         => (int),           // no of rows for TYPE: TEXTAREA only
    |        'note'         => (string),        // input note
    |        'minDate'      => (date),          // minimum date for TYPE: DATE format(mm-dd-yyyy)
    |        'maxDate'      => (date),          // minimum date for TYPE: DATE format(mm-dd-yyyy)
    |        'yearRange'    => (date : date),   // minimum date range for TYPE: DATE : ex. '2013 : 2018'
    |        'list_value'   => (array()),       // array list of values for TYPE: DROPDOWN & RADIO only
    |        'youtube'      => (boolean),       // include youtube for CKEditor Only *True Default
    |        'filemanager'  => (boolean),       // include filemanger for CKEditor Only *True Default
    |        'source'       => (boolean),       // include source for CKEditor Only *True Default
    |        'list_style'   => (boolean),       // include list style for CKEditor Only *True Default
    |        'no_html'      => (boolean),       // if HTML TAg not allowed for text and textarea type only
    |        'accept'       => (string),        // a comma separated file type for filemanager only. ex. jpg,gif,png,jpeg,webp
    |        'max_size'     => (int)            // maximum file size to accept in MB for filemanager only
    |        'preview'      => (boolean)        // display video preview for youtube only, default is true
    |        'captcha'      => (string)         // captcha option if : codeigniter or google
    |        'site_key'     => (string)         // for google recaptcha : site key (required)
    |        'table-headers'=> (array)          // for headers to be generated in table
    |   );
    |
    | you can add your custom input
    |
    |
    | Note : To validate all inputs generated by this function
    |
    |   Sample Code :
    |
    |   <?php
    |       //to display
    |       $inputs = ['first_name','middle_name',];
    |       inputs($inputs);
    |   ?>
    |
    |   <script>
    |       $('.btn_save').on('click', function(){
    |           if(validate.standard()){
    |               //your code here
    |           }
    |       });
    |   </script>
    */
    
    public $separator     = array(
                                    'type'          => 'separator',
                                    'id'            => 'separator'
                                );
    
    public $captcha      = array(
                                    'type'          => 'captcha',
                                    'name'          => 'captcha',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control',
                                    'id'            => 'captcha',
                                    'required'      => true,
                                    'maxlength'     => 8,
                                    'placeholder'   => 'Enter above text',
                                    'label'         => 'Captcha',
                                    
                                );
    
    
    public $meta_title      = array(
                                    'type'          => 'text',
                                    'name'          => 'meta_title',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control',
                                    'id'            => 'meta_title',
                                    'required'      => false,
                                    'maxlength'     => 100,
                                    'alphaonly'     => true,
                                    'placeholder'   => 'Meta Title',
                                    'label'         => 'Meta Title'
                                );
    
    public $meta_description= array(
                                    'type'          => 'textarea',
                                    'name'          => 'meta_description',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control meta_description_input',
                                    'id'            => 'meta_description',
                                    'required'      => false,
                                    'maxlength'     => 255,
                                    'placeholder'   => 'Meta Description',
                                    'label'         => 'Meta Description'
                                );
    
    public $meta_keyword= array(
                                    'type'          => 'textarea',
                                    'name'          => 'meta_keyword',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control meta_keyword_input',
                                    'id'            => 'meta_keyword',
                                    'required'      => false,
                                    'placeholder'   => 'Meta Keyword',
                                    'label'         => 'Meta Keywords'
                                );
    
    public $meta_image= array(
                                    'type'          => 'filemanager',
                                    'name'          => 'meta_img',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control',
                                    'id'            => 'meta_img',
                                    'accept'        => 'jpg,png,jpeg,webp',
                                    'max_size'      => '5',
                                    'required'      => false,
                                    'placeholder'   => 'Meta Image',
                                    'label'         => 'Meta Image',
                                );
    
    public $asc_ref      = array(
                                    'type'          => 'textarea',
                                    'name'          => 'asc_ref',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control',
                                    'id'            => 'asc_ref',
                                    'maxlength'     => 50,
                                    'required'      => true,                              
                                    'placeholder'   => '',
                                    'label'         => 'ASC Ref Code'
                                );
    
    public $first_name      = array(
                                    'type'          => 'text',
                                    'name'          => 'first_name',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control',
                                    'id'            => 'first_name',
                                    'maxlength'     => 255,
                                    'required'      => true,
                                    'accept'        => '/[^a-zA-Z ’\'.,-]/g',
                                    'placeholder'   => '',
                                    'label'         => 'First Name',
                                    'align'         => 'vertical',
                                    
                                );
    
    public $middle_name     = array(
                                    'type'          => 'text',
                                    'name'          => 'middle_name',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control',
                                    'id'            => 'middle_name',
                                    'maxlength'     => 255,
                                    'required'      => true,
                                    'accept'        => '/[^a-zA-Z ’\'.,-]/g',
                                    'placeholder'   => 'Middle Name',
                                    'label'         => 'Middle Name',
                                    
                                );
    
    public $last_name       = array(
                                    'type'          => 'text',
                                    'name'          => 'last_name',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control',
                                    'id'            => 'last_name',
                                    'maxlength'     => 255,
                                    'required'      => true,
                                    'accept'        => '/[^a-zA-Z ’\'.,-]/g',
                                    'placeholder'   => '',
                                    'label'         => 'Last Name',
                                    
                                );
    
    public $suffix_name     = array(
                                    'type'          => 'text',
                                    'name'          => 'suffix_name',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control',
                                    'id'            => 'suffix_name',
                                    'maxlength'     => 10,
                                    'required'      => false,
                                    'alphaonly'     => true,
                                    'placeholder'   => 'Suffix',
                                    'label'         => 'Suffix',
                                    
                                );

    //platform
    public $si_platform = array(
        'type'          => 'text',
        'name'          => 'si_platform',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'si_platform',
        'maxlength'     => 255,
        'label'         => 'Platform'
    );
    
    //platform icon
    public $platform_image  = array(
        'type'          => 'filemanager',
        'name'          => 'platform_image',
        'form-align'    => 'horizontal',
        'class'         => 'form-control prod_info_img_inputs',
        'id'            => 'platform_image',
        'accept'        => 'jpg,gif,png,jpeg,webp',
        'max_size'      => '5',
        'required'      => true,
        'placeholder'   => 'Image',
        'label'         => 'Image',
        
    );
    
    public $area= array(
        'type'          => 'ckeditor',
        'name'          => 'area_id',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'required'      => true,
        'youtube'       => false,
        'id'            => 'area_id',
        'placeholder'   => '',
        'label'         => 'Area'
    );
    
    public $start_false= array(
        'type'          => 'date',
        'name'          => 'start_false',
        'form-align'    => 'horizontal',
        'class'         => 'form-control start_input',
        'id'            => 'start_false',
        'minDate'       => '0',
        'required'      => false,
        'placeholder'   => '',
        'label'         => 'Start Date',
        
    );
    
    public $end_false= array(
        'type'          => 'date',
        'name'          => 'end_false',
        'form-align'    => 'horizontal',
        'class'         => 'form-control end_input',
        'id'            => 'end_false',
        'minDate'       => '0',
        'required'      => false,
        'placeholder'   => '',
        'label'         => 'End Date',
        
    );
    
    public $url_false= array(
        'type'          => 'text',
        'name'          => 'url_false',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'url_false',
        'maxlength'     => 255,
        'required'      => false,
        'placeholder'   => 'URL',
        'label'         => 'URL',
    );
    
    public $chatbot      = array(
        'type'          => 'text',
        'name'          => 'chatbot',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'chatbot',
        'required'      => false,
        'placeholder'   => '',
        'label'         => 'Chatbot',
    );
    
    public $chatbot_body= array(
        'type'          => 'textarea',
        'name'          => 'chatbot_body',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'chatbot_body',
        'required'      => false,
        'placeholder'   => '',
        'label'         => 'Chatbot(Body)'
    );
    
    public $benefits_category_description= array(
        'type'          => 'textarea',
        'name'          => 'benefits_category_description',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'benefits_category_description',
        'maxlength'     => 255,
        'placeholder'   => 'Description',
        'label'         => 'Description',
    );
    
    public $benefits_category= array(
        'type'          => 'dropdown',
        'name'          => 'benefits_category',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'benefits_category',
        'placeholder'   => '',
        'label'         => 'Category',
        'list_value'    => array(
            '0'     => '',
        ),
    );
    
    public $cookie_notification_status  = array(
        'type'          => 'dropdown',
        'name'          => 'cookie_notification_status',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'cookie_notification_status',
        'required'      => false,
        'placeholder'   => '',
        'label'         => 'Status',
        'list_value'    => array(
                            '1' => 'Show',
                            '0' => 'Hide'
                        )
    );
    
    public $cookie_notification_position = array(
        'type'          => 'dropdown',
        'name'          => 'cookie_notification_position',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'cookie_notification_position',
        'required'      => false,
        'placeholder'   => '',
        'label'         => 'Position',
        'list_value'    => array(
                            'top'       => 'Top',
                            'bottom'    => 'Bottom'
                        )
    );
    
    public $cookie_notification_message= array(
        'type'          => 'ckeditor',
        'name'          => 'cookie_notification_message',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'cookie_notification_message',
        'required'      => false,
        'placeholder'   => '',
        'label'         => 'Notification Message'
    );
    
    // START - URL Pixel List
    public $pixel_url= array(
        'type'          => 'text',
        'name'          => 'pixel_url',
        'form-align'    => 'horizontal',
        'class'         => 'form-control redirect_url_input',
        'id'            => 'pixel_url',
        'required'      => true,
        'placeholder'   => 'URL',
        'label'         => 'URL',
    );
    
    public $pixel_content= array(
        'type'          => 'textarea',
        'name'          => 'pixel_content',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'pixel_content',
        'required'      => true,
        'placeholder'   => '',
        'label'         => 'Pixel Content'
    );
    // END - URL Pixel List
    
    // START - Dark Page
    public $dark_page_image= array(
        'type'          => 'filemanager',
        'name'          => 'dark_page_image',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'dark_page_image',
        'accept'        => 'jpg,gif,png,jpeg,webp',
        'required'      => true,
        'placeholder'   => '',
        'label'         => 'Background Image',
    ); 
    
    public $dark_page_image_link= array(
        'type'          => 'text',
        'name'          => 'dark_page_image_link',
        'form-align'    => 'horizontal',
        'class'         => 'form-control product_info_inputs',
        'id'            => 'dark_page_image_link',
        'maxlength'     => 255,
        'required'      => true,
        'placeholder'   => 'Image Link',
        'label'         => 'Image Link',
    );
    
    // END - Dark Page
    
    // START - Pop-Up Survey
    
    public $image_link= array(
        'type'          => 'text',
        'name'          => 'image_link',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'image_link',
        'maxlength'     => 255,
        'required'      => false,
        'accept'        => '/[^a-zA-Z0-9\u00f1\u00d1 -._~:\/?#[\]@!$&\'()*+,;=]/g',
        'label'         => 'Image URL'
    );
    

    public $category_url= array(
        'type'          => 'text',
        'name'          => 'category_url',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'category_url',
        'maxlength'     => 255,
        'required'      => true,
        'placeholder'   => '',
        'label'         => 'Category URL',
        'accept'        => '/[^a-zA-Z0-9\u00f1\u00d1\-_~#@!$\();]/g',
    );
    

    public $author = array(
        'type'          => 'text',
        'name'          => 'author',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'author',
        'maxlength'     => 500,
        'required'      => false,
        'accept'        => '/[^a-zA-Z0-9\u00f1\u00d1 \'.,-]/g',
        'placeholder'   => '',
        'label'         => 'Publisher'
    );
    public $image_banner_req_false = array(
        'type'          => 'filemanager',
        'name'          => 'image_banner_req_false',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'image_banner_req_false',
        'accept'        => 'jpg,gif,png,jpeg,webp',
        'max_size'      => '5',
        'required'      => false,
        'placeholder'   => '',
        'label'         => 'Image Banner',
    );


}
?>
