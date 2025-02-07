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
    public $value_used = "<b>Error!</b> Unable to set the record to Inactive since it is currently used.";
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
    
    public $civil_status    = array(
                                    'type'          => 'dropdown',
                                    'name'          => 'civil_status',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control',
                                    'id'            => 'civil_status',
                                    'required'      => true,
                                    'placeholder'   => 'Civil Status',
                                    'label'         => 'Civil Status',
                                    'list_value'    => array(
                                                        'Single'    => 'Single',
                                                        'Married'   => 'Married',
                                                        'Separated' => 'Separated',
                                                        'Divorced'  => 'Divorced',
                                                        'Widowed'   => 'Widowed',
                                                    ),
                                    
                                );
    
    public $gender          = array(
                                    'type'          => 'dropdown',
                                    'name'          => 'gender',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control',
                                    'id'            => 'gender',
                                    'required'      => true,
                                    'placeholder'   => 'Gender',
                                    'label'         => 'Gender',
                                    'list_value'    => array(
                                                        'Male'     => 'Male',
                                                        'Female'     => 'Female'
                                                    ),
                                    
                                );
    
    public $status          = array(
                                    'type'          => 'dropdown',
                                    'name'          => 'status',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control status_input',
                                    'id'            => 'status',
                                    'required'      => true,
                                    'label'         => 'Status',
                                    'list_value'    => array(
                                                        '1'     => 'Active',
                                                        '0'     => 'Inactive'
                                                    ),
                                );
    
    public $birthday       = array(
                                    'type'          => 'date',
                                    'name'          => 'birthday',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control',
                                    'id'            => 'birthday',
                                    'required'      => true,
                                    'placeholder'   => 'Birth Date',
                                    'label'         => 'Birthday',
                                    'yearRange'     => '-100:+0',
                                    'maxDate'       => '0',
                                    
                                );
    
    public $email_address   = array(
                                    'type'          => 'email',
                                    'name'          => 'email_address',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control',
                                    'id'            => 'email_address',
                                    'required'      => true,
                                    'maxlength'     => 150,
                                    'placeholder'   => '',
                                    'label'         => 'Email Address'
                                );
    
    public $password        = array(
                                    'type'          => 'password',
                                    'name'          => 'password',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control',
                                    'id'            => 'password',
                                    'maxlength'     => 40,
                                    'required'      => true,
                                    'validated'     => false,                                
                                    'placeholder'   => 'Password',
                                    'label'         => 'Password'
                                );
    
    public $home_address         = array(
                                    'type'          => 'ckeditor',
                                    'name'          => 'home_address',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control',
                                    'id'            => 'home_address',
                                    'required'      => true,
                                    'youtube'       => false,
                                    'filemanager'   => false,
                                    'maxlength'     => 500,
                                    'placeholder'   => 'House No. and Street Address',
                                    'label'         => 'House No. and Street Address',
                                    
                                );
    
    public $timepicker      = array(
                                    'type'          => 'timepicker',
                                    'name'          => 'timepicker',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control',
                                    'id'            => 'timepicker',
                                    'required'      => true,
                                    'placeholder'   => 'Time Picker',
                                    'label'         => 'Time Picker',
                                    
                                );
    
    public $image          = array(
                                    'type'          => 'filemanager',
                                    'name'          => 'image',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control prod_info_img_inputs',
                                    'id'            => 'image',
                                    'accept'        => 'jpg,gif,png,jpeg,webp',
                                    'max_size'      => '5',
                                    'required'      => true,
                                    'placeholder'   => 'Image',
                                    'label'         => 'Image',
                                    
                                );
    
    public $sas_image          = array(
                                    'type'          => 'filemanager',
                                    'name'          => 'sas_image',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control prod_info_img_inputs',
                                    'id'            => 'sas_image',
                                    'accept'        => 'jpg,png,jpeg,webp',
                                    'max_size'      => '5',
                                    'required'      => false,
                                    'placeholder'   => 'Image',
                                    'label'         => 'Image',
                                    
                                );
    public $sas_subtitle= array(
                                    'type'          => 'text',
                                    'name'          => 'sas_subtitle',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control',
                                    'id'            => 'sas_subtitle',
                                    'required'      => false,
                                    'maxlength'    => 255,
                                    'label'         => 'Subtitle'
                                );
    
    public $sas_image_desktop= array(
                                    'type'          => 'filemanager',
                                    'name'          => 'sas_image_desktop',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control',
                                    'id'            => 'sas_image_desktop',
                                    'accept'        => 'jpg,png,jpeg,webp',
                                    'max_size'      => '5',
                                    'required'      => false,
                                    'label'         => 'Image (Desktop)',
                                );
    public $sas_image_mobile= array(
                                    'type'          => 'filemanager',
                                    'name'          => 'sas_image_mobile',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control',
                                    'id'            => 'sas_image_mobile',
                                    'accept'        => 'jpg,png,jpeg,webp',
                                    'max_size'      => '5',
                                    'required'      => false,
                                    'label'         => 'Image (Mobile)',
                                );
    
    
    public $image_banner          = array(
                                    'type'          => 'filemanager',
                                    'name'          => 'image_banner',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control',
                                    'id'            => 'image_banner',
                                    'accept'        => 'jpg,gif,png,jpeg,webp',
                                    'max_size'      => '5',
                                    'required'      => true,
                                    'max_size'      => '5',
                                    'placeholder'   => 'Image Banner',
                                    'label'         => 'Image Banner',
                                );
    
    public $image_thumbnail         = array(
                                    'type'          => 'filemanager',
                                    'name'          => 'banner_thumbnail',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control',
                                    'id'            => 'banner_thumbnail',
                                    'accept'        => 'jpg,gif,png,jpeg,webp',
                                    'max_size'      => '5',
                                    'required'      => true,
                                    'placeholder'   => 'Image Thumbnail',
                                    'label'         => 'Image Thumbnail',
                                    
                                );
    
    public $date_start       = array(
                                    'type'          => 'date',
                                    'name'          => 'date_start',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control',
                                    'required'      => true,
                                    'id'            => 'date_start',
                                    'minDate'       => '0',
                                    'placeholder'   => 'Start Date',
                                    'label'         => 'Start Date',
                                    
                                );
    
    
    public $symptom_title      = array(
                                    'type'          => 'text',
                                    'name'          => 'symptom_title',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control',
                                    'id'            => 'symptom_title',
                                    'maxlength'     => 255,
                                    'required'      => true,
                                    'placeholder'   => '',
                                    'label'         => 'Symptom',
                                    'display'       => 1,
                                    'is_list'       => 1,
                                    'alignment'     => 1
                                );
    
    public $cause_title      = array(
                                    'type'          => 'text',
                                    'name'          => 'cause_title',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control',
                                    'id'            => 'cause_title',
                                    'maxlength'     => 255,
                                    'required'      => true,
                                    'placeholder'   => '',
                                    'label'         => 'Cause',
                                    'display'       => 1,
                                    'is_list'       => 1,
                                    'alignment'     => 1
                                );
    
                                
    public $prevention_title      = array(
                                    'type'          => 'text',
                                    'name'          => 'prevention_title',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control',
                                    'id'            => 'prevention_title',
                                    'maxlength'     => 255,
                                    'required'      => true,
                                    'placeholder'   => '',
                                    'label'         => 'Prevention',
                                    'display'       => 1,
                                    'is_list'       => 1,
                                    'alignment'     => 1
                                );
    
    
    
    public $date_end       = array(
                                    'type'          => 'date',
                                    'name'          => 'date_end',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control',
                                    'id'            => 'date_end',
                                    'required'      => true,
                                    'minDate'       => '0',
                                    'placeholder'   => 'End Date',
                                    'label'         => 'End Date',
                                    
                                );
    
    public $article_body         = array(
                                    'type'          => 'ckeditor',
                                    'name'          => 'article_body',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control',
                                    'id'            => 'article_body',
                                    'required'      => true,
                                    'placeholder'   => 'Article Body',
                                    'label'         => 'Article Body',
                                    
                                );
    
    public $article_thumbnail         = array(
                                    'type'          => 'filemanager',
                                    'name'          => 'article_thumbnail',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control',
                                    'id'            => 'article_thumbnail',
                                    'accept'        => 'jpg,gif,png,jpeg,webp',
                                    'max_size'      => '3',
                                    'required'      => true,
                                    'placeholder'   => 'Article Thumbnail',
                                    'label'         => 'Article Thumbnail',
                                    
                                );
    
    public $article_summary         = array(
                                    'type'          => 'ckeditor',
                                    'name'          => 'article_summary',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control',
                                    'id'            => 'article_summary',
                                    'required'      => false,
                                    'placeholder'   => 'Article Summary',
                                    'label'         => 'Article Summary',
                                    
                                );
    
    public $mobile_number      = array(
                                    'type'          => 'mobile_number',
                                    'name'          => 'mobile_number',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control',
                                    'id'            => 'mobile_number',
                                    'required'      => true,
                                    'placeholder'   => 'Mobile Number',
                                    'label'         => 'Mobile Number',
                                    'maxlength'     => 11,
                                    'note'          => 'Required Format : 09XXXXXXXXX',
                                );
    
    public $zip_code      = array(
                                    'type'          => 'text',
                                    'name'          => 'zip_code',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control',
                                    'id'            => 'zip_code',
                                    'maxlength'     => 5,
                                    'accept'        => '/[^0-9]/g',
                                    'placeholder'   => 'Zip Code',
                                    'label'         => 'Zip Code',
                                    
                                );
    
    
    public $youtube      = array(
                                    'type'          => 'youtube',
                                    'name'          => 'youtube',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control',
                                    'id'            => 'youtube',
                                    'required'      => true,
                                    'placeholder'   => 'Youtube Video',
                                    'label'         => 'Youtube Video',
                                    
                                );
    
    
    //STANDARD FOR HOME
    public $title      = array(
                                    'type'          => 'text',
                                    'name'          => 'title',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control',
                                    'id'            => 'title',
                                    'maxlength'     => 255,
                                    'required'      => true,
                                    'placeholder'   => '',
                                    'label'         => 'Title',
                                    'display'       => 1,
                                    'is_list'       => 1,
                                    'alignment'     => 1
                                );                               
    
    public $title_modal      = array(
                                    'type'          => 'text',
                                    'name'          => 'title_modal',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control',
                                    'id'            => 'title_modal',
                                    'maxlength'     => 255,
                                    'required'      => true,
                                    'placeholder'   => '',
                                    'label'         => 'Title',
                                    'display'       => 1,
                                    'is_list'       => 1,
                                    'alignment'     => 1
                                );
    
    public $text_description_req_false= array(
                                    'type'          => "textarea",
                                    'name'          => "text_description_req_false",
                                    'form-align'    => "horizontal",
                                    'class'         => "text_description_req_false form-control",
                                    'id'            => "text_description_req_false",
                                    'required'      => false,
                                    'maxlength'     => 600,
                                    'placeholder'   => "",
                                    'label'         => "Description"
                                );                        
    
    public $content_req_false= array(
                                    'type'          => 'ckeditor',
                                    'name'          => 'content_req_false',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control',
                                    'id'            => 'content_req_false',
                                    'required'      => false,
                                    'placeholder'   => '',
                                    'label'         => 'Content',
                                );
    
    public $description     = array(
                                    'type'          => 'ckeditor',
                                    'name'          => 'description',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control',
                                    'id'            => 'description',
                                    'required'      => true,
                                    'no_html'      => false,
                                    'filemanager'   => false,
                                    'youtube'       => false,
                                    'placeholder'   => '',
                                    'label'         => 'Description',
                                );
                                
    public $ingredient_description     = array(
                                    'type'          => 'ckeditor_modal',
                                    'name'          => 'ingredient_description',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control',
                                    'id'            => 'ingredient_description',
                                    'required'      => true,
                                    'no_html'       => false,
                                    'filemanager'   => false,
                                    'youtube'       => false,
                                    'placeholder'   => '',
                                    'label'         => 'Description',
                                );
    
    public $media_type_ingredient= array(
                                    'type'          => 'dropdown',
                                    'name'          => 'media_type_ingredient',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control video_type',
                                    'id'            => 'media_type_ingredient',
                                    'required'      => true,
                                    'placeholder'   => '',
                                    'label'         => 'Media Type',
                                    'list_value'    => array(
                                                        ''     => '',
                                                        '0'     => 'Upload Media',
                                                        '1'     => 'Youtube Video'
                                                    )
                                    );
    
    public $description_modal     = array(
                                    'type'          => 'ckeditor_modal',
                                    'name'          => 'description_modal',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control',
                                    'id'            => 'description_modal',
                                    'required'      => true,
                                    'no_html'      => false,
                                    'filemanager'   => false,
                                    'youtube'       => false,
                                    'placeholder'   => '',
                                    'label'         => 'Description',
                                );
    
    public $description_modal_prevention     = array(
                                    'type'          => 'ckeditor_modal',
                                    'name'          => 'description_modal_prevention',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control',
                                    'id'            => 'description_modal_prevention',
                                    'required'      => true,
                                    'no_html'      => false,
                                    'filemanager'   => false,
                                    'youtube'       => false,
                                    'placeholder'   => '',
                                    'label'         => 'Description',
                                );
    
    public $description_modal_edit     = array(
                                    'type'          => 'ckeditor_modal',
                                    'name'          => 'description_modal_edit',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control',
                                    'id'            => 'description_modal_edit',
                                    'required'      => true,
                                    'no_html'      => false,
                                    'filemanager'   => false,
                                    'youtube'       => false,
                                    'placeholder'   => '',
                                    'label'         => 'Description',
                                );
    
    public $description_modal_prevention_edit     = array(
                                    'type'          => 'ckeditor_modal',
                                    'name'          => 'description_modal_prevention_edit',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control',
                                    'id'            => 'description_modal_prevention_edit',
                                    'required'      => true,
                                    'no_html'      => false,
                                    'filemanager'   => false,
                                    'youtube'       => false,
                                    'placeholder'   => '',
                                    'label'         => 'Description',
                                );
    
    public $product_name   = array(
                                    'type'          => 'text',
                                    'name'          => 'product_name',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control product_info_inputs',
                                    'id'            => 'product_name',
                                    'required'      => true,
                                    'maxlength'     => 255,
                                    'placeholder'   => '',
                                    'label'         => 'Product Name'
                                );
    
    public $generic_name   = array(
                                    'type'          => 'ckeditor',
                                    'name'          => 'generic_name',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control product_info_inputs',
                                    'id'            => 'generic_name',
                                    'required'      => true,
                                    'placeholder'   => '',
                                    'label'         => 'Generic Name'
                                );
    
    public $product_description= array(
                                    'type'          => 'textarea',
                                    'name'          => 'brief_description',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control',
                                    'id'            => 'product_description',
                                    'required'      => true,
                                    'maxlength'     => 500,
                                    'placeholder'   => 'Product Description',
                                    'label'         => 'Product Description'
                                );
    
    public $product_image      = array(
                                    'type'          => 'filemanager',
                                    'name'          => 'product_image',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control',
                                    'id'            => 'product_image',
                                    'accept'        => 'jpg,gif,png,jpeg,webp',
                                    'max_size'      => '5',
                                    'required'      => true,
                                    'placeholder'   => 'Product Image',
                                    'label'         => 'Product Image',
                                    
                                );
    
    
    public $media_file_upload   = array(
                                    'type'          => 'filemanager',
                                    'name'          => 'media_file_upload',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control',
                                    'id'            => 'media_file_upload',
                                    'accept'        => 'jpg,gif,png,jpeg,webp,mkv,mov,mp4,ogv,webm,mp3,ogg,flac,wav',
                                    'max_size'      => '50',
                                    'required'      => true,
                                    'label'         => 'Media File Upload',
                                    
                                );  
    
    public $product_image_web      = array(
                                    'type'          => 'filemanager',
                                    'name'          => 'product_image_web',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control',
                                    'id'            => 'product_image_web',
                                    'accept'        => 'jpg,gif,png,jpeg,webp',
                                    'max_size'      => '5',
                                    'required'      => true,
                                    'label'         => 'Product Image (Web)',
                                );
    public $product_image_mobile      = array(
                                    'type'          => 'filemanager',
                                    'name'          => 'product_image_mobile',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control',
                                    'id'            => 'product_image_mobile',
                                    'accept'        => 'jpg,gif,png,jpeg,webp',
                                    'max_size'      => '5',
                                    'required'      => true,
                                    'label'         => 'Product Image (Mobile)',
                                );
    
    public $privacy_title      = array(
                                    'type'          => 'text',
                                    'name'          => 'privacy_title',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control',
                                    'id'            => 'privacy_title',
                                    'maxlength'     => 255,
                                    'required'      => true,
                                    'placeholder'   => 'Privacy Policy Title',
                                    'label'         => 'Privacy Policy Title',
                                    
                                );
    
    
    public $privacy_statement   = array(
                                    'type'          => 'ckeditor',
                                    'name'          => 'privacy_statement',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control',
                                    'id'            => 'privacy_statement',
                                    'required'      => true,
                                    'filemanager'   => false,
                                    'youtube'       => false,
                                    'placeholder'   => 'Privacy Policy Statement',
                                    'label'         => 'Privacy Policy Statement',
                                    
                                );
    
    public $terms_title      = array(
                                    'type'          => 'text',
                                    'name'          => 'terms_title',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control',
                                    'id'            => 'terms_title',
                                    'maxlength'     => 255,
                                    'required'      => true,
                                    'placeholder'   => 'Terms of Use - Title',
                                    'label'         => 'Title',
                                    
                                );
    
    
    public $terms_statement   = array(
                                    'type'          => 'ckeditor',
                                    'name'          => 'terms_statement',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control',
                                    'id'            => 'terms_statement',
                                    'required'      => true,
                                    'filemanager'   => false,
                                    'youtube'       => false,
                                    'placeholder'   => 'Terms of Use Statement',
                                    'label'         => 'Content',
                                    
                                );
    
    public $brief_description= array(
                                    'type'          => 'textarea',
                                    'name'          => 'brief_description',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control brief_description_input',
                                    'id'            => 'brief_description',
                                    'required'      => true,
                                    'no_html'       => true,
                                    'maxlength'     => 500,
                                    'placeholder'   => 'Brief Description',
                                    'label'         => 'Brief Description',
                                    
                                );
    
    public $question      = array(
                                    'type'          => 'ckeditor',
                                    'name'          => 'question',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control question_input',
                                    'id'            => 'question',
                                    'required'      => true,
                                    'maxlength'     => 255,
                                    'placeholder'   => 'Question',
                                    'label'         => 'Question'
                                );
    
    public $answer      = array(
                                    'type'          => 'ckeditor',
                                    'name'          => 'answer',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control answer_input',
                                    'id'            => 'answer',
                                    'required'      => true,
                                    'placeholder'   => 'Answer',
                                    'label'         => 'Answer',
                                    'youtube'       => false
                                );
    
    public $article_date_start       = array(
                                    'type'          => 'date',
                                    'name'          => 'article_date_start',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control',
                                    'id'            => 'article_date_start',
                                    'minDate'       => '0',
                                    'placeholder'   => 'Start Date',
                                    'label'         => 'Start Date',
                                    'note'          => 'Leave blank if no Expiration/Duration'
                                );
    
    
    public $article_date_end       = array(
                                    'type'          => 'date',
                                    'name'          => 'article_date_end',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control',
                                    'id'            => 'article_date_end',
                                    'minDate'       => '0',
                                    'placeholder'   => 'End Date',
                                    'label'         => 'End Date',
                                    'note'          => 'Leave blank if no Expiration/Duration'
                                );
    
    public $contact_inquiry= array(
                                    'type'          => 'textarea',
                                    'name'          => 'inquiry',
                                    'form-align'    => 'vertical',
                                    'class'         => 'form-control',
                                    'id'            => 'inquiry',
                                    'required'      => true,
                                    'placeholder'   => 'Inquiry',
                                    'label'         => 'Inquiry',
                                    
                                );
    
    public $contact_mobile_number      = array(
                                    'type'          => 'mobile_number',
                                    'name'          => 'mobile_number',
                                    'form-align'    => 'vertical',
                                    'class'         => 'form-control',
                                    'id'            => 'mobile_number',
                                    'required'      => true,
                                    'placeholder'   => 'Mobile Number',
                                    'label'         => 'Mobile Number',
                                    'maxlength'     => 11,
                                    'note'          => 'Required Format : 09XXXXXXXXX',
                                );
    public $contact_email_address   = array(
                                    'type'          => 'email',
                                    'name'          => 'email_address',
                                    'form-align'    => 'vertical',
                                    'class'         => 'form-control',
                                    'id'            => 'email_address',
                                    'required'      => true,
                                    'maxlength'     => 250,
                                    'placeholder'   => 'Email Address',
                                    'label'         => 'Email Address',
                                    
                                );
    
    public $contact_first_name      = array(
                                    'type'          => 'text',
                                    'name'          => 'first_name',
                                    'form-align'    => 'vertical',
                                    'class'         => 'form-control',
                                    'id'            => 'first_name',
                                    'maxlength'     => 250,
                                    'required'      => true,
                                    'alphaonly'     => true,
                                    'accept'        => '/[^a-zA-Z .,-]/g',
                                    'placeholder'   => 'First Name',
                                    'label'         => 'First Name',
                                    'align'         => 'vertical',
                                    
                                );
    
    public $contact_middle_name     = array(
                                    'type'          => 'text',
                                    'name'          => 'middle_name',
                                    'form-align'    => 'vertical',
                                    'class'         => 'form-control',
                                    'id'            => 'middle_name',
                                    'maxlength'     => 250,
                                    'required'      => true,
                                    'alphaonly'     => true,
                                    'placeholder'   => 'Middle Name',
                                    'label'         => 'Middle Name',
                                    
                                );
    
    public $contact_last_name       = array(
                                    'type'          => 'text',
                                    'name'          => 'last_name',
                                    'form-align'    => 'vertical',
                                    'class'         => 'form-control',
                                    'id'            => 'last_name',
                                    'maxlength'     => 250,
                                    'required'      => true,
                                    'alphaonly'     => true,
                                    'placeholder'   => 'Last Name',
                                    'label'         => 'Last Name',
                                    
                                );
    
    public $contact_captcha      = array(
                                    'type'          => 'captcha',
                                    'captcha'       => 'google',
                                    'site_key'      => '6Lf8i2cUAAAAACaKQohJ3nFyBCGHMmDVQBK4sjVK',
                                    'name'          => 'captcha',
                                    'form-align'    => 'vertical',
                                    'class'         => 'form-control',
                                    'id'            => 'captcha',
                                    'required'      => true,
                                    'maxlength'     => 8,
                                    'placeholder'   => 'Enter above text',
                                    'label'         => 'Captcha',
                                    
                                );
    
    
    
    public $sign_up_first_name      = array(
                                    'type'          => 'text',
                                    'name'          => 'first_name',
                                    'form-align'    => 'vertical',
                                    'class'         => 'form-control',
                                    'id'            => 'first_name',
                                    'maxlength'     => 250,
                                    'required'      => true,
                                    'alphaonly'     => true,
                                    'accept'        => '/[^a-zA-Z .,-]/g',
                                    'placeholder'   => 'First Name',
                                    'label'         => 'First Name',
                                    'align'         => 'vertical',
                                    
                                );
    
    public $sign_up_middle_name     = array(
                                    'type'          => 'text',
                                    'name'          => 'middle_name',
                                    'form-align'    => 'vertical',
                                    'class'         => 'form-control',
                                    'id'            => 'middle_name',
                                    'maxlength'     => 250,
                                    'required'      => true,
                                    'alphaonly'     => true,
                                    'placeholder'   => 'Middle Name',
                                    'label'         => 'Middle Name',
                                    
                                );
    
    public $sign_up_last_name       = array(
                                    'type'          => 'text',
                                    'name'          => 'last_name',
                                    'form-align'    => 'vertical',
                                    'class'         => 'form-control',
                                    'id'            => 'last_name',
                                    'maxlength'     => 250,
                                    'required'      => true,
                                    'alphaonly'     => true,
                                    'placeholder'   => 'Last Name',
                                    'label'         => 'Last Name',
                                    
                                );
    
    public $sign_up_civil_status    = array(
                                    'type'          => 'dropdown',
                                    'name'          => 'civil_status',
                                    'form-align'    => 'vertical',
                                    'class'         => 'form-control',
                                    'id'            => 'civil_status',
                                    'required'      => true,
                                    'placeholder'   => 'Civil Status',
                                    'label'         => 'Civil Status',
                                    'list_value'    => array(
                                                        'Single'    => 'Single',
                                                        'Married'   => 'Married',
                                                        'Separated' => 'Separated',
                                                        'Divorced'  => 'Divorced',
                                                        'Widowed'   => 'Widowed',
                                                    ),
                                    
                                );
    
    public $sign_up_gender          = array(
                                    'type'          => 'dropdown',
                                    'name'          => 'gender',
                                    'form-align'    => 'vertical',
                                    'class'         => 'form-control',
                                    'id'            => 'gender',
                                    'required'      => true,
                                    'placeholder'   => 'Gender',
                                    'label'         => 'Gender',
                                    'list_value'    => array(
                                                        'Male'     => 'Male',
                                                        'Female'     => 'Female'
                                                    ),
                                    
                                );
    
    public $sign_up_birthday       = array(
                                    'type'          => 'date',
                                    'name'          => 'birthday',
                                    'form-align'    => 'vertical',
                                    'class'         => 'form-control',
                                    'id'            => 'birthday',
                                    'required'      => true,
                                    'placeholder'   => 'Birth Date',
                                    'label'         => 'Birthday',
                                    'yearRange'     => '-100:+0',
                                    'maxDate'       => '0',
                                    
                                );
    
    public $sign_up_mobile_number      = array(
                                    'type'          => 'mobile_number',
                                    'name'          => 'mobile_number',
                                    'form-align'    => 'vertical',
                                    'class'         => 'form-control',
                                    'id'            => 'mobile_number',
                                    'required'      => true,
                                    'placeholder'   => 'Mobile Number',
                                    'label'         => 'Mobile Number',
                                    'maxlength'     => 11,
                                    'note'          => 'Required Format : 09XXXXXXXXX',
                                );
    
    public $sign_up_email_address   = array(
                                    'type'          => 'email',
                                    'name'          => 'email_address',
                                    'form-align'    => 'vertical',
                                    'class'         => 'form-control',
                                    'id'            => 'email_address',
                                    'required'      => true,
                                    'maxlength'     => 250,
                                    'placeholder'   => 'Email Address',
                                    'label'         => 'Email Address',
                                    
                                );
    
    public $sign_up_country    = array(
                                    'type'          => 'dropdown',
                                    'name'          => 'country',
                                    'form-align'    => 'vertical',
                                    'class'         => 'form-control',
                                    'id'            => 'country',
                                    'required'      => true,
                                    'placeholder'   => 'Country',
                                    'label'         => 'Country',
                                    'list_value'    => array(
                                                        'PH'    => 'Philippines',
                                                    ),
                                    
                                );
    
    public $sign_up_region    = array(
                                    'type'          => 'dropdown',
                                    'name'          => 'region',
                                    'form-align'    => 'vertical',
                                    'class'         => 'form-control',
                                    'id'            => 'region',
                                    'required'      => true,
                                    'placeholder'   => 'Region',
                                    'label'         => 'Region',
                                    'list_value'    => array(),
                                    
                                );
    
    public $sign_up_province    = array(
                                    'type'          => 'dropdown',
                                    'name'          => 'province',
                                    'form-align'    => 'vertical',
                                    'class'         => 'form-control',
                                    'id'            => 'province',
                                    'required'      => true,
                                    'placeholder'   => 'Province',
                                    'label'         => 'Province',
                                    'list_value'    => array(),
                                    
                                );
    
    public $sign_up_city    = array(
                                    'type'          => 'dropdown',
                                    'name'          => 'city',
                                    'form-align'    => 'vertical',
                                    'class'         => 'form-control',
                                    'id'            => 'city',
                                    'required'      => true,
                                    'placeholder'   => 'City',
                                    'label'         => 'City',
                                    'list_value'    => array(),
                                    
                                );
    
    public $sign_up_captcha  = array(
                                    'type'          => 'captcha',
                                    'name'          => 'captcha',
                                    'captcha'          => 'codeigniter',
                                    'form-align'    => 'vertical',
                                    'class'         => 'form-control',
                                    'id'            => 'captcha',
                                    'required'      => true,
                                    'maxlength'     => 8,
                                    'placeholder'   => 'Enter above text',
                                    'label'         => 'Captcha',
                                    
                                );
    
    public $video_type= array(
                                    'type'          => 'dropdown',
                                    'name'          => 'video_type',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control video_type',
                                    'id'            => 'video_type',
                                    'required'      => true,
                                    'placeholder'   => 'Video Type',
                                    'label'         => 'Video Type',
                                    'list_value'    => array(
                                                        ''     => '',
                                                        '0'     => 'Upload Video',
                                                        '1'     => 'Youtube Video'
                                                    ),              
                                );
    
    
    public $upload_video= array(
                                    'type'          => 'filemanager',
                                    'name'          => 'upload_video',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control',
                                    'id'            => 'upload_video',
                                    'accept'        => 'mp4',
                                    'max_size'      => '50',
                                    'required'      => true,
                                    'placeholder'   => 'Upload Video',
                                    'label'         => 'Upload Video'
                                );
    
    
    public $upload_thumbnail= array(
                                    'type'          => 'filemanager',
                                    'name'          => 'upload_thumbnail',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control',
                                    'id'            => 'upload_thumbnail',
                                    'accept'        => 'jpg,gif,png,jpeg,webp',
                                    'max_size'      => '5',
                                    'required'      => true,
                                    'placeholder'   => 'Upload Video Thumbnail',
                                    'label'         => 'Upload Video Thumbnail',
                                    
                                );
    
    public $banner_type= array(
                                    'type'          => 'radio',
                                    'name'          => 'banner_type',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'banner_type',
                                    'id'            => 'banner_type',
                                    'required'      => true,
                                    'placeholder'   => 'Upload Type',
                                    'label'         => 'Upload Type',
                                    'list_value'    => array(
                                                        '0'     => 'Image / Video Upload',
                                                        '1'     => 'Youtube Link',
    
                                                    ),
                                );
    
    public $image_video_banner          = array(
                                    'type'          => 'filemanager',
                                    'name'          => 'image_video',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control',
                                    'id'            => 'image_video',
                                    'accept'        => 'jpg,gif,png,jpeg,webp,mp4',
                                    'required'      => true,
                                    'placeholder'   => 'Image / Video Upload',
                                    'label'         => 'Image / Video Upload'
                                );
    
    
    
    /* Custom Config */
    
    
    public $banner          = array(
                                    'type'          => 'filemanager',
                                    'name'          => 'banner',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control ',
                                    'id'            => 'banner_img',
                                    'accept'        => 'jpg,gif,png,jpeg,webp,mp4',
                                    'required'      => true,
                                    'placeholder'   => 'Banner',
                                    'label'         => 'Banner',
    
                                );
    
    
    public $thumbnail         = array(
                                    'type'          => 'filemanager',
                                    'name'          => 'banner_thumbnail',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control',
                                    'id'            => 'banner_thumbnail',
                                    'accept'        => 'jpg,gif,png,jpeg,webp',
                                    'max_size'      => '5',
                                    'required'      => true,
                                    'placeholder'   => 'Image Thumbnail',
                                    'label'         => 'Image Thumbnail',
                                );
    
    public $url             = array(
                                    'type'          => 'text',
                                    'name'          => 'url',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control product_info_inputs',
                                    'id'            => 'url',
                                    'maxlength'     => 255,
                                    'required'      => true,
                                    'placeholder'   => 'URL',
                                    'label'         => 'URL',
                                    'accept'        => '/[^a-zA-Z0-9\u00f1\u00d1\-_~#@!$\();]/g',
                                );
    
    
    public $start           = array(
                                    'type'          => 'date',
                                    'name'          => 'date_start',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control start_input',
                                    'id'            => 'date_start',
                                    'minDate'       => '0',
                                    'required'      => true,
                                    'placeholder'   => '',
                                    'label'         => 'Start Date',
                                    
                                );
    
    public $end             = array(
                                    'type'          => 'date',
                                    'name'          => 'date_end',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control end_input',
                                    'id'            => 'date_end',
                                    'minDate'       => '0',
                                    'required'      => true,
                                    'placeholder'   => '',
                                    'label'         => 'End Date',
                                    
                                );
    
    public $event_date           = array(
                                    'type'          => 'date',
                                    'name'          => 'event_date',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control event_date_input',
                                    'id'            => 'event_date',
                                    'minDate'       => '0',
                                    'required'      => true,
                                    'placeholder'   => '',
                                    'label'         => 'Event Date',
                                    
                                );
    
    
    public $redirect_url     = array(
                                    'type'          => 'text',
                                    'name'          => 'redirect_url',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control redirect_url_input',
                                    'id'            => 'redirect_url',
                                    'placeholder'   => 'Redirect URL',
                                    'required'      => true,
                                    'label'         => 'Redirect URL',
                                    
                                );
    
    public $statement       = array(
    
                                    'type'          => 'ckeditor', 
                                    'name'          => 'statement',
                                    'form-align'    => 'horizontal', 
                                    'class'         => 'form-control statement_input', 
                                    'id'            => 'statement', 
                                    'filemanager'   => false, 
                                    'youtube'       => false, 
                                    'placeholder'   => '', 
                                    'label'         => 'Statement',
                                );
    
    public $name            = array(
                                    'type'          => 'text',
                                    'name'          => 'name',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control',
                                    'id'            => 'name',
                                    'maxlength'     => 255,
                                    'required'      => true,
                                    'accept'        => '/[^a-zA-Z0-9\u00f1\u00d1 \'#.,-]/g',
                                    'placeholder'   => '',
                                    'label'         => 'Name'
                                );
    
    public $ingredient_name            = array(
                                    'type'          => 'text',
                                    'name'          => 'ingredient_name',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control',
                                    'id'            => 'ingredient_name',
                                    'maxlength'     => 255,
                                    'required'      => true,
                                    'placeholder'   => '',
                                    'label'         => 'Name'
                                );
    
    public $ingredient_name_modal            = array(
                                    'type'          => 'text',
                                    'name'          => 'ingredient_name_modal',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control',
                                    'id'            => 'ingredient_name_modal',
                                    'maxlength'     => 255,
                                    'required'      => true,
                                    'placeholder'   => '',
                                    'label'         => 'Name'
                                );
    
    public $username        = array(
                                    'type'          => 'text',
                                    'name'          => 'username',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control',
                                    'id'            => 'username',
                                    'maxlength'     => 25,
                                    'required'      => true,
                                    'alphaonly'     => true,
                                    'placeholder'   => '',
                                    'label'         => 'Username'
                                );
    
    public $role            = array(
                                    'type'          => 'dropdown',
                                    'name'          => 'role',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control role',
                                    'id'            => 'role',
                                    'required'      => true,
                                    'placeholder'   => 'Role',
                                    'label'         => 'User Role',
                                    'list_value'    => array(
                                                        '0' => ''
                                                    )
                                );
    
    public $dd_user_sign_up        = array(
                                        'type'          => 'dropdown',
                                        'name'          => 'dd_user_sign_up',
                                        'form-align'    => 'horizontal',
                                        'class'         => 'form-control dd_user_sign_up',
                                        'id'            => 'dd_user_sign_up',
                                        'required'      => true,
                                        'placeholder'   => 'User Signup',
                                        'label'         => 'User Signup',
                                        'list_value'    => array(
                                                            '0'     => 'Disable',
                                                            '1'     => 'Enable'
                                                        )
                                    );
    
    public $dd_contact_us          = array(
                                        'type'          => 'dropdown',
                                        'name'          => 'dd_contact_us',
                                        'form-align'    => 'horizontal',
                                        'class'         => 'form-control dd_contact_us',
                                        'id'            => 'dd_contact_us',
                                        'required'      => true,
                                        'placeholder'   => 'Contact Us',
                                        'label'         => 'Contact Us',
                                        'list_value'    => array(
                                                            '0'     => 'Disable',
                                                            '1'     => 'Enable'
                                                        )
                                    );
    
    public $dd_notif_login          = array(
                                        'type'          => 'dropdown',
                                        'name'          => 'dd_notif_login',
                                        'form-align'    => 'horizontal',
                                        'class'         => 'form-control dd_notif_login',
                                        'id'            => 'dd_notif_login',
                                        'required'      => true,
                                        'placeholder'   => 'Login',
                                        'label'         => 'Login',
                                        'list_value'    => array(
                                                            '0'     => 'Disable',
                                                            '1'     => 'Enable'
                                                        )
                                    );
    
    public $dd_privacy_statement_option        = array(
                                        'type'          => 'dropdown',
                                        'name'          => 'dd_privacy_statement_option',
                                        'form-align'    => 'horizontal',
                                        'class'         => 'form-control dd_privacy_statement_option',
                                        'id'            => 'dd_privacy_statement_option',
                                        'required'      => true,
                                        'placeholder'   => 'Privacy Statement Option',
                                        'label'         => 'Privacy Statement Option',
                                        'list_value'    => array(
                                                            '0'     => 'Redirect Url',
                                                            '1'     => 'Page'
                                                        )
                                    );
    
    public $crs_host      = array(
                                    'type'          => 'text', 
                                    'name'          => 'crs_host', 
                                    'form-align'    => 'horizontal', 
                                    'class'         => 'form-control', 
                                    'id'            => 'crs_host', 
                                    'required'      => true, 
                                    'maxlength'     => 255, 
                                    'alphaonly'     => false, 
                                    'placeholder'   => 'Host', 
                                    'label'         => 'Host'
                                );
    
    public $crs_token      = array(
                                    'type'          => 'text', 
                                    'name'          => 'crs_token', 
                                    'form-align'    => 'horizontal', 
                                    'class'         => 'form-control', 
                                    'id'            => 'crs_token', 
                                    'required'      => true, 
                                    'maxlength'     => 255, 
                                    'alphaonly'     => false, 
                                    'placeholder'   => 'Token', 
                                    'label'         => 'Token'
                                );
    
    
    public $link_type       = array(
                                    'type'          => 'dropdown',
                                    'name'          => 'link_type',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control',
                                    'id'            => 'link_type',
                                    'required'      => true,
                                    'placeholder'   => 'Link Type',
                                    'label'         => 'Link Type',
                                    'list_value'    => array(
                                                        '1'     => 'Parent',
                                                        '2'     => 'Child'
                                                    )
                                );
    
    public $shop_url             = array(
                                    'type'          => 'text',
                                    'name'          => 'shop_url',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control',
                                    'id'            => 'shop_url',
                                    'required'      => false,
                                    'placeholder'   => '',
                                    'label'         => 'Shop URL'
                                );
    
    public $favicon_img          = array(
                                    'type'          => 'filemanager',
                                    'name'          => 'favicon_img',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control',
                                    'id'            => 'favicon_img',
                                    'accept'        => 'jpg,gif,png,jpeg,webp,ico',
                                    'required'      => true,
                                    'placeholder'   => '',
                                    'label'         => 'Favicon',
                                );
    
    public $brand_logo          = array(
                                    'type'          => 'filemanager',
                                    'name'          => 'brand_logo',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control',
                                    'id'            => 'brand_logo',
                                    'accept'        => 'jpg,gif,png,jpeg,webp',
                                    'max_size'      => '5',
                                    'required'      => true,
                                    'placeholder'   => '',
                                    'label'         => 'Brand Logo',
                                );
    
    public $logo          = array(
                                    'type'          => 'filemanager',
                                    'name'          => 'logo',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control',
                                    'id'            => 'logo',
                                    'accept'        => 'jpg,gif,png,jpeg,webp',
                                    'max_size'      => '5',
                                    'required'      => true,
                                    'placeholder'   => '',
                                    'label'         => 'Logo',
                                );
    
    public $google_analytics      = array(
                                    'type'          => 'text',
                                    'name'          => 'google_analytics',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control',
                                    'id'            => 'google_analytics',
                                    'required'      => false,
                                    'placeholder'   => '',
                                    'label'         => 'Google Analytics',
                                );
    
    public $gtm_header= array(
                                    'type'          => 'textarea',
                                    'name'          => 'gtm_header',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control',
                                    'id'            => 'gtm_header',
                                    'required'      => false,
                                    'placeholder'   => '',
                                    'label'         => 'Google Tag Manager(Header)'
                                );
    
    public $gtm_body= array(
                                    'type'          => 'textarea',
                                    'name'          => 'gtm_body',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control',
                                    'id'            => 'gtm_body',
                                    'required'      => false,
                                    'placeholder'   => '',
                                    'label'         => 'Google Tag Manager(Body)'
                                );
    
    public $facebook_pixel      = array(
                                    'type'          => 'text',
                                    'name'          => 'facebook_pixel',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control',
                                    'id'            => 'facebook_pixel',
                                    'required'      => false,
                                    'placeholder'   => '',
                                    'label'         => 'Facebook Pixel',
                                );
    
    public $fb_header= array(
                                    'type'          => 'textarea',
                                    'name'          => 'fb_header',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control',
                                    'id'            => 'fb_header',
                                    'required'      => false,
                                    'placeholder'   => '',
                                    'label'         => 'Facebook Pixel(Header)'
                                );
    
    public $fb_body= array(
                                    'type'          => 'textarea',
                                    'name'          => 'fb_body',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control',
                                    'id'            => 'fb_body',
                                    'required'      => false,
                                    'placeholder'   => '',
                                    'label'         => 'Facebook Pixel(Body)'
                                );
    
    public $facebook_site_info         = array(
                                    'type'          => 'text',
                                    'name'          => 'facebook_site_info',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control',
                                    'id'            => 'facebook_site_info',
                                    'required'      => true,
                                    'placeholder'   => '',
                                    'label'         => 'Facebook Link'
                                );
    
    public $twitter_site_info         = array(
                                    'type'          => 'text',
                                    'name'          => 'twitter_site_info',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control',
                                    'id'            => 'twitter_site_info',
                                    'required'      => true,
                                    'placeholder'   => '',
                                    'label'         => 'Twitter Link'
                                );
    
    public $instagram_site_info         = array(
                                    'type'          => 'text',
                                    'name'          => 'instagram_site_info',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control',
                                    'id'            => 'instagram_site_info',
                                    'required'      => true,
                                    'placeholder'   => '',
                                    'label'         => 'Instagram Link'
                                );
    
    public $pinterest_site_info         = array(
                                    'type'          => 'text',
                                    'name'          => 'pinterest_site_info',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control',
                                    'id'            => 'pinterest_site_info',
                                    'required'      => true,
                                    'placeholder'   => '',
                                    'label'         => 'Pinterest Link'
                                );
    
    public $linked_in_site_info         = array(
                                    'type'          => 'text',
                                    'name'          => 'linked_in_site_info',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control',
                                    'id'            => 'linked_in_site_info',
                                    'required'      => true,
                                    'placeholder'   => '',
                                    'label'         => 'LinkedIn Link'
                                );
    
    public $youtube_link_site_info      = array(
                                    'type'          => 'text',
                                    'name'          => 'youtube_link_site_info',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control',
                                    'id'            => 'youtube_link_site_info',
                                    'required'      => true,
                                    'placeholder'   => '',
                                    'label'         => 'Youtube Link'
                                );
    
    public $tumblr_site_info            = array(
                                    'type'          => 'text',
                                    'name'          => 'tumblr_site_info',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control',
                                    'id'            => 'tumblr_site_info',
                                    'required'      => true,
                                    'placeholder'   => '',
                                    'label'         => 'Tumblr Link'
                                );
    
    public $facebook         = array(
                                    'type'          => 'text',
                                    'name'          => 'facebook',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control social_links_input validateURL',
                                    'id'            => 'facebook',
                                    'required'      => false,
                                    'placeholder'   => '',
                                    'label'         => 'Facebook Link'
                                );
    
    public $twitter         = array(
                                    'type'          => 'text',
                                    'name'          => 'twitter',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control social_links_input validateURL',
                                    'id'            => 'twitter',
                                    'required'      => false,
                                    'placeholder'   => '',
                                    'label'         => 'Twitter Link'
                                );
    
    public $instagram         = array(
                                    'type'          => 'text',
                                    'name'          => 'instagram',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control social_links_input validateURL',
                                    'id'            => 'instagram',
                                    'required'      => false,
                                    'placeholder'   => '',
                                    'label'         => 'Instagram Link'
                                );
    
    public $pinterest         = array(
                                    'type'          => 'text',
                                    'name'          => 'pinterest',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control social_links_input validateURL',
                                    'id'            => 'pinterest',
                                    'required'      => false,
                                    'placeholder'   => '',
                                    'label'         => 'Pinterest Link'
                                );
    
    public $linked_in         = array(
                                    'type'          => 'text',
                                    'name'          => 'linked_in',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control social_links_input validateURL',
                                    'id'            => 'linked_in',
                                    'required'      => false,
                                    'placeholder'   => '',
                                    'label'         => 'LinkedIn Link'
                                );
    
    public $youtube_link      = array(
                                    'type'          => 'text',
                                    'name'          => 'youtube_link',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control social_links_input validateURL',
                                    'id'            => 'youtube_link',
                                    'required'      => false,
                                    'placeholder'   => '',
                                    'label'         => 'Youtube Link'
                                );
    
    public $tumblr            = array(
                                    'type'          => 'text',
                                    'name'          => 'tumblr',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control social_links_input validateURL',
                                    'id'            => 'tumblr',
                                    'required'      => false,
                                    'placeholder'   => '',
                                    'label'         => 'Tumblr Link'
                                );
    
    public $email_protocol    = array(
                                    'type'          => 'dropdown',
                                    'name'          => 'protocol',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control',
                                    'id'            => 'protocol',
                                    'required'      => false,
                                    'placeholder'   => '',
                                    'label'         => 'Protocol',
                                    'list_value'    => array(
                                                        'sendgrid' => 'Sendgrid',
                                                        'smtp'     => 'SMTP',
                                                        'sendmail'     => 'Sendmail'
                                                    )
                                );
    
    public $email_host        = array(
                                    'type'          => 'text',
                                    'name'          => 'host',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control',
                                    'id'            => 'host',
                                    'maxlength'     => 150,
                                    'required'      => true,
                                    'placeholder'   => '',
                                    'label'         => 'Host'
                                );
    
    public $email_user        = array(
                                    'type'          => 'text',
                                    'name'          => 'email',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control',
                                    'id'            => 'email',
                                    'maxlength'     => 150,
                                    'required'      => true,
                                    'placeholder'   => '',
                                    'label'         => 'Email'
                                );
    
    public $email_password    = array(
                                    'type'          => 'password',
                                    'name'          => 'email_password',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control',
                                    'id'            => 'email_password',
                                    'maxlength'     => 40,
                                    'required'      => true,
                                    'validated'     => false,
                                    'placeholder'   => '',
                                    'label'         => 'Password'
                                );
    
    public $email_port        = array(
                                    'type'          => 'text',
                                    'name'          => 'port',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control',
                                    'id'            => 'port',
                                    'maxlength'     => 5,
                                    'required'      => true,
                                    'accept'       =>  ' /[^0-9.]/g',
                                    'placeholder'   => '',
                                    'label'         => 'Port'
                                );
    
    public $email_default        = array(
                                    'type'          => 'text',
                                    'name'          => 'email_default',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control',
                                    'id'            => 'email_default',
                                    'maxlength'     => 150,
                                    'required'      => true,
                                    'placeholder'   => '',
                                    'label'         => 'Default Email'
                                );
    
    public $notification_status  = array(
                                    'type'          => 'dropdown',
                                    'name'          => 'notification_status',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control',
                                    'id'            => 'notification_status',
                                    'required'      => false,
                                    'placeholder'   => '',
                                    'label'         => 'Status',
                                    'list_value'    => array(
                                                        '1'     => 'Show',
                                                        '0'     => 'Hide'
                                                    )
                                );
    
    public $notification_position = array(
                                    'type'          => 'dropdown',
                                    'name'          => 'notification_position',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control',
                                    'id'            => 'notification_position',
                                    'required'      => false,
                                    'placeholder'   => '',
                                    'label'         => 'Position',
                                    'list_value'    => array(
                                                        'top'     => 'Top',
                                                        'bottom'  => 'Bottom'
                                                    )
                                );
    
    public $browser_display = array(
                                    'type'          => 'checkbox',
                                    'name'          => 'notification_browser',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'notification_browser',
                                    'id'            => 'browser_display',
                                    'label'         => 'Browser Display',
                                    'list_value'    => array(
                                                        'mozilla_firefox'   => 'Mozilla Firefox',
                                                        'google_chrome'     => 'Google Chrome',
                                                        'internet_explorer' => 'Internet Explorer',
                                                        'safari'            => 'Safari'
                                                    )
                                );
    
    public $notification_message= array(
                                    'type'          => 'textarea',
                                    'name'          => 'notification_message',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control',
                                    'id'            => 'notification_message',
                                    'maxlength'     => 500,
                                    'required'      => false,
                                    'placeholder'   => '',
                                    'label'         => 'Notification Message'
                                );
    
    
    public $cms_title      = array(
                                    'type'          => 'text',
                                    'name'          => 'cms_title',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control',
                                    'id'            => 'cms_title',
                                    'maxlength'     => 25,
                                    'required'      => true,
                                    'placeholder'   => 'CMS Title',
                                    'label'         => 'CMS Title',
                                );
    
    public $skin = array(
                                    'type'          => 'dropdown',
                                    'name'          => 'skin',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control',
                                    'id'            => 'skin',
                                    'required'      => true,
                                    'label'         => 'Skin',
                                    'list_value'    => array(
                                                        '_all-skins'     => '_all-skins',
                                                        'skin-black-light'  => 'skin-black-light',
                                                        'skin-black'  => 'skin-black',
                                                        'skin-blue-light'  => 'skin-blue-light',
                                                        'skin-blue'  => 'skin-blue',
                                                        'skin-green-light'  => 'skin-green-light',
                                                        'skin-green'  => 'skin-green',
                                                        'skin-purple-light'  => 'skin-purple-light',
                                                        'skin-purple'  => 'skin-purple',
                                                        'skin-red-light'  => 'skin-red-light',
                                                        'skin-red'  => 'skin-red',
                                                        'skin-yellow-light'  => 'skin-yellow-light',
                                                        'skin-yellow'  => 'skin-yellow'
                                                    )
                                );
    
    public $edit_header_label = array(
                                    'type'          => 'dropdown',
                                    'name'          => 'edit_header_label',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control',
                                    'id'            => 'edit_header_label',
                                    'required'      => true,
                                    'label'         => 'Edit Header Label',
                                    'list_value'    => array(
                                                        '1'  => 'Yes',
                                                        '0'  => 'No',
                                                    )
                                );
    
    public $ad_authentication = array(
                                    'type'          => 'dropdown',
                                    'name'          => 'ad_authentication',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control',
                                    'id'            => 'ad_authentication',
                                    'required'      => true,
                                    'label'         => 'AD Authentication',
                                    'list_value'    => array(
                                                        '0'  => 'No',
                                                        '1'  => 'Yes',
                                                        '2'  => 'Both',
                                                    )
                                );
    
    public $password_validated= array(
                                    'type'          => 'password',
                                    'name'          => 'password',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control',
                                    'id'            => 'password',
                                    'maxlength'     => 40,
                                    'required'      => true,
                                    'validated'     => true,
                                    'placeholder'   => '',
                                    'label'         => 'Password'
                                );
    
    public $navigation_position= array(
                                    'type'          => 'radio',
                                    'name'          => 'navigation_position',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'navigation_position',
                                    'id'            => 'navigation_position',
                                    'placeholder'   => 'Navigation Position',
                                    'label'         => 'Navigation Postion',
                                    'list_value'    => array(
                                                        'top'     => 'Top',
                                                        'left'    => 'Left',
                                                        'right'   => 'Right',
                                                    ),
                                );
    
    public $email_template_name= array(
                                    'type'          => 'text',
                                    'name'          => 'email_name',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control',
                                    'id'            => 'email_name',
                                    'maxlength'     => 50,
                                    'required'      => true,
                                    'placeholder'   => '',
                                    'label'         => 'Name',
                                );
                                
    public $email_template_message= array(
                                    'type'          => 'ckeditor_email',
                                    'name'          => 'email_message',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control',
                                    'id'            => 'email_message',
                                    'required'      => true,
                                    'placeholder'   => '',
                                    'label'         => 'Body',
                                );
                                
    public $email_template_status= array(
                                    'type'          => 'dropdown',
                                    'name'          => 'email_status',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control',
                                    'id'            => 'email_status',
                                    'required'      => true,
                                    'placeholder'   => 'Status',
                                    'label'         => 'Status',
                                    'list_value'    => array(
                                                        '1'    => 'Active',
                                                        '0'   => 'Inactive',
                                                    ),
                                );
    
    public $email_template_logo= array(
                                    'type'          => 'filemanager',
                                    'name'          => 'email_logo',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control',
                                    'id'            => 'email_logo',
                                    'accept'        => 'jpg,gif,png,jpeg,webp',
                                    'required'      => true,
                                    'placeholder'   => 'Logo',
                                    'label'         => 'Logo',
                                );	
    
    public $email_template_header= array(
                                    'type'          => 'text',
                                    'name'          => 'email_header',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control',
                                    'id'            => 'email_header',
                                    'required'      => true,
                                    'placeholder'   => 'Header',
                                    'label'         => 'Header',
                                );
    
    public $email_template_footer= array(
                                    'type'          => 'text',
                                    'name'          => 'email_footer',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control',
                                    'id'            => 'email_footer',
                                    'required'      => true,
                                    'placeholder'   => 'Footer',
                                    'label'         => 'Footer',
                                );
                                
    public $email_template_subject= array(
                                    'type'          => 'textarea',
                                    'name'          => 'email_subject',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control',
                                    'id'            => 'email_subject',
                                    'required'      => true,
                                    'placeholder'   => '',
                                    'label'         => 'Subject',
                                );	
                                
    public $email_template_color= array(
                                    'type'          => 'text',
                                    'name'          => 'email_color',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control',
                                    'id'            => 'email_color',
                                    'required'      => true,
                                    'placeholder'   => 'Color',
                                    'label'         => 'Color',
                                );
    
    public $sendgrid_from_email= array(
                                    'type'          => 'text',
                                    'name'          => 'sendgrid_from_email',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control',
                                    'id'            => 'sendgrid_from_email',
                                    'maxlength'     => 150,
                                    'required'      => true,
                                    'placeholder'   => 'From Email',
                                    'label'         => 'From Email',
                                );  
    
    public $sendgrid_from_name= array(
                                    'type'          => 'text',
                                    'name'          => 'sendgrid_from_name',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control',
                                    'id'            => 'sendgrid_from_name',
                                    'maxlength'     => 100,
                                    'required'      => true,
                                    'placeholder'   => 'From Name',
                                    'label'         => 'From Name'
                                );
    
    public $sendgrid_token= array(
                                    'type'          => 'text',
                                    'name'          => 'sendgrid_token',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control',
                                    'id'            => 'sendgrid_token',
                                    'maxlength'     => 500,
                                    'required'      => true,
                                    'placeholder'   => 'Token',
                                    'label'         => 'Token',
                                );
    
    public $disclaimer_title= array(
                                    'type'          => 'text',
                                    'name'          => 'disclaimer_title',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control',
                                    'id'            => 'disclaimer_title',
                                    'maxlength'     => 255,
                                    'required'      => true,
                                    'placeholder'   => 'Title',
                                    'label'         => 'Title',
                                );
    
    public $disclaimer_description= array(
                                    'type'          => 'ckeditor',
                                    'name'          => 'disclaimer_description',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control',
                                    'id'            => 'disclaimer_description',
                                    'required'      => true,
                                    'filemanager'   => false,
                                    'youtube'       => false,
                                    'placeholder'   => 'Description',
                                    'label'         => 'Description',
                                );
    
    public $media_type= array(
                                    'type'          => 'dropdown',
                                    'name'          => 'media_type',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control',
                                    'id'            => 'media_type',
                                    'required'      => true,
                                    'label'         => 'Media Type',
                                    'list_value'    => array(
                                                        'album'  => 'Album',
                                                        'image'  => 'Image',
                                                        'video'  => 'Video',
                                                    )
                                );
    
    public $media_image= array(
                                    'type'          => 'filemanager',
                                    'name'          => 'media_image',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control',
                                    'id'            => 'media_image',
                                    'accept'        => 'jpg,gif,png,jpeg,webp',
                                    'max_size'      => '15',
                                    'required'      => true,
                                    'placeholder'   => 'Image',
                                    'label'         => 'Image',    
                                );
    
    public $media_video= array(
                                    'type'          => 'filemanager',
                                    'name'          => 'media_video',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control',
                                    'id'            => 'media_video',
                                    'accept'        => 'mp4',
                                    'required'      => true,
                                    'placeholder'   => 'Upload Video',
                                    'label'         => 'Upload Video'
                                );				
    
     public $banner_thumbnail         = array(
                                    'type'          => 'filemanager',
                                    'name'          => 'banner_thumbnail',
                                    'form-align'    => 'horizontal',
                                    'class'         => 'form-control',
                                    'id'            => 'banner_thumbnail',
                                    'accept'        => 'jpg,gif,png,jpeg,webp',
                                    'max_size'      => '5',
                                    'required'      => true,
                                    'placeholder'   => 'Image Thumbnail',
                                    'label'         => 'Image Thumbnail',
                                    
                                );	
                                
    public $site_name      = array(
                                'type'          => 'text',
                                'name'          => 'site_name',
                                'form-align'    => 'horizontal',
                                'class'         => 'form-control',
                                'id'            => 'site_name',
                                'maxlength'     => 50,
                                'required'      => true,
                                'label'         => 'Site Name'
                                );
    
    public $site_details_site_name      = array(
                                'type'          => 'text',
                                'name'          => 'email_config_site_name',
                                'form-align'    => 'horizontal',
                                'class'         => 'form-control',
                                'id'            => 'email_config_site_name',
                                'required'      => false,
                                'disabled'      => 'disabled',
                                'placeholder'   => '',
                                'label'         => 'Site Name',
                            );
                                
    public $site_url      = array(
                                'type'          => 'text',
                                'name'          => 'site_url',
                                'form-align'    => 'horizontal',
                                'class'         => 'form-control',
                                'id'            => 'site_url',
                                'required'      => true,
                                'accept'        => '/[^a-zA-Z0-9\u00f1\u00d1 -._~:\/?#[\]@!$&\'()*+,;=]/g',
                                'placeholder'   => '',
                                'label'         => 'Site URL',
                            );
                                                        
    public $custom_package_name      = array(
                            'type'          => 'text',
                            'name'          => 'package_name',
                            'form-align'    => 'horizontal',
                            'class'         => 'form-control',
                            'id'            => 'package_name_id',
                            'required'      => true,
                            'accept'        => '/[^a-zA-Z0-9 ]/g',
                            'maxlength'    => 50,
                            'placeholder'   => '',
                            'label'         => 'Package Name',
                        );
    
    public $package_description      = array(
                            'type'          => 'textarea',
                            'name'          => 'description',
                            'form-align'    => 'horizontal',
                            'class'         => 'form-control',
                            'id'            => 'description',
                            'required'      => true,
                            'maxlength'    => 255,
                            'placeholder'   => '',
                            'label'         => 'Brief Description',
                        );                            
                        
    public $review= array(
                        'type'          => 'ckeditor',
                        'name'          => 'review',
                        'form-align'    => 'horizontal',
                        'class'         => 'form-control',
                        'id'            => 'review',
                        'required'      => true,
                        'placeholder'   => '',
                        'maxlength'     => 1000,
                        'label'         => 'Review',
                    );
                    
    public $review_ckeditor= array(
                        'type'          => 'ckeditor',
                        'name'          => 'review_ckeditor',
                        'form-align'    => 'horizontal',
                        'class'         => 'form-control',
                        'id'            => 'review_ckeditor',
                        'required'      => true,
                        'placeholder'   => '',
                        'maxlength'     => 1000,
                        'label'         => 'Review 2',
                    );     
                          
                              
    public $year       = array(                                            
                        'type'          => 'date',
                        'name'          => 'year',
                        'form-align'    => 'horizontal',
                        'class'         => 'form-control',
                        'id'            => 'year',
                        'required'      => true,
                        'placeholder'   => '',
                        'label'         => 'Year',
                        'yearRange'     => '-100:+0',
                        'maxDate'       => '0',
                        );
    
    public $package_content      = array(
                            'type'          => 'ckeditor',
                            'name'          => 'Content',
                            'form-align'    => 'horizontal',
                            'class'         => 'form-control',
                            'id'            => 'content',
                            'required'      => true,
                            'placeholder'   => '',
                            'label'         => 'Content',
                        );
    
    public $package_year       = array(
                            'type'          => 'date',
                            'name'          => 'year',
                            'form-align'    => 'horizontal',
                            'class'         => 'form-control',
                            'id'            => 'year',
                            'required'      => true,
                            'placeholder'   => '',
                            'label'         => 'Year',
                            'yearRange'     => '-100:+0',
                            'maxDate'       => '0',
                        );
       
    // Start Partner Store
    public $store_name      = array(
                            'type'          => 'text',
                            'name'          => 'store_name',
                            'form-align'    => 'horizontal',
                            'class'         => 'form-control',
                            'id'            => 'store_name',
                            'maxlength'     => 255,
                            'required'      => true,
                            'placeholder'   => 'Store Name',
                            'label'         => 'Store Name',
                        );
    public $partner_store_brief_description= array(
                            'type'          => 'textarea',
                            'name'          => 'partner_store_brief_description',
                            'form-align'    => 'horizontal',
                            'class'         => 'form-control',
                            'id'            => 'partner_store_brief_description',
                            'required'      => true,
                            'maxlength'     => 500,
                            'placeholder'   => 'Brief Description',
                            'label'         => 'Brief Description'
                        );
    public $store_image          = array(
                            'type'          => 'filemanager',
                            'name'          => 'store_image',
                            'form-align'    => 'horizontal',
                            'class'         => 'form-control',
                            'id'            => 'store_image',
                            'accept'        => 'jpg,gif,png,jpeg,webp',
                            'max_size'      => 5,  
                            'required'      => true,
                            'placeholder'   => 'Image',
                            'label'         => 'Image',
                        );
                         
    public $store_type    = array(
                            'type'          => 'dropdown',
                            'name'          => 'store_type',
                            'form-align'    => 'horizontal',
                            'class'         => 'form-control',
                            'id'            => 'store_type',
                            'required'      => true,
                            'placeholder'   => 'Store Type',
                            'label'         => 'Store Type',
                            'list_value'    => array(
                                                '0'   => 'Online',
                                                '1'   => 'Offline',
                                                '2'   => 'E-Commerce'
                                            ),
                        );
    public $store_link      = array(
                            'type'          => 'text',
                            'name'          => 'store_link',
                            'form-align'    => 'horizontal',
                            'class'         => 'form-control',
                            'id'            => 'store_link',
                            'required'      => true,
                            'placeholder'   => 'Store Link',
                            'label'         => 'Store Link',
                        );
    
    public $product_link      = array(
                            'type'          => 'text',
                            'name'          => 'product_link',
                            'form-align'    => 'horizontal',
                            'class'         => 'form-control',
                            'id'            => 'product_link',
                            'required'      => false,
                            'label'         => 'Product Link',
                        );
    // End Partner Store     
    // Start Foundation
    public $foundation_image_background          = array(
        'type'          => 'filemanager',
        'name'          => 'foundation_image_background',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'foundation_image_background',
        'accept'        => 'jpg,gif,png,jpeg,webp',
        'max_size'      => 5,  
        'required'      => true,
        'placeholder'   => 'Background Image',
        'label'         => 'Background Image',
    );
    // End Foundation
    // Start Online Partner Stores Section
    public $partner_store_section_background_image          = array(
                            'type'          => 'filemanager',
                            'name'          => 'partner_store_section_background_image',
                            'form-align'    => 'horizontal',
                            'class'         => 'form-control',
                            'id'            => 'partner_store_section_background_image',
                            'accept'        => 'jpg,gif,png,jpeg,webp',
                            'max_size'      => 5,  
                            'required'      => true,
                            'placeholder'   => 'Background Image',
                            'label'         => 'Background Image',
    );
    public $content         = array(
                            'type'          => 'ckeditor',
                            'name'          => 'content',
                            'form-align'    => 'horizontal',
                            'class'         => 'form-control',
                            'id'            => 'content',
                            'required'      => true,
                            'placeholder'   => 'Content',
                            'label'         => 'Content',
        
    );
    // End Online Partner Stores Section                     
    public $background_image          = array(
                            'type'          => 'filemanager',
                            'name'          => 'background_image',
                            'form-align'    => 'horizontal',
                            'class'         => 'form-control',
                            'id'            => 'background_image',
                            'accept'        => 'jpg,gif,png,jpeg,webp',
                            'max_size'      => '5',
                            'required'      => true,
                            'placeholder'   => '',
                            'label'         => 'Background Image',
                        );    
    
    public $age       = array(
                            'type'          => 'number',
                            'name'          => 'age',
                            'form-align'    => 'horizontal',
                            'class'         => 'form-control',
                            'id'            => 'age',
                            'min'           => 1,
                            'max'           => 999,
                            'maxlength'    => 3,
                            'required'      => true,
                            'accept'        => '/[^[0-9]*$]/g',
                            'placeholder'   => '',
                            'label'         => 'Age',
                        );
    
    public $line_of_work      = array(
                        'type'          => 'text',
                        'name'          => 'work',
                        'form-align'    => 'horizontal',
                        'class'         => 'form-control',
                        'id'            => 'work',
                        'required'      => true,
                        'maxlength'    => 255,
                        'placeholder'   => '',
                        'label'         => 'Line of Work',
                    );
    
    public $message= array(
                        'type'          => 'textarea',
                        'name'          => 'message',
                        'form-align'    => 'horizontal',
                        'class'         => 'form-control',
                        'id'            => 'message',
                        'required'      => true,
                        'placeholder'   => '',
                        'label'         => 'Message',
                    );
    public $position      = array(
                            'type'          => 'text',
                            'name'          => 'position',
                            'form-align'    => 'horizontal',
                            'class'         => 'form-control',
                            'id'            => 'position',
                            'maxlength'     => 255,
                            'required'      => true,
                            'alphaonly'     => true,
                            'accept'        => '/[^a-zA-Z .,-]/g',
                            'placeholder'   => '',
                            'label'         => 'Position',
                            'align'         => 'vertical',  
                        );
    
    public $leader_position = array(
    
                            'type'          => 'ckeditor',
                            'name'          => 'leader_position',
                            'form-align'    => 'horizontal',
                            'class'         => 'form-control',
                            'id'            => 'leader_position',
                            'required'      => true,
                            'placeholder'   => '',
                            'label'         => 'Position',
                    
                        );
    
    public $division      = array(
                            'type'          => 'text',
                            'name'          => 'division',
                            'form-align'    => 'horizontal',
                            'class'         => 'form-control',
                            'id'            => 'division',
                            'maxlength'     => 255,
                            'accept'        => '/[^a-zA-Z .,-]/g',
                            'placeholder'   => '',
                            'label'         => 'Division',
                            'align'         => 'vertical',  
                        );
    
    public $department      = array(
                            'type'          => 'text',
                            'name'          => 'department',
                            'form-align'    => 'horizontal',
                            'class'         => 'form-control',
                            'id'            => 'department',
                            'maxlength'     => 255,
                            'accept'        => '/[^a-zA-Z .,-]/g',
                            'placeholder'   => '',
                            'label'         => 'Department',
                            'align'         => 'vertical',  
                        );
    //ARTICLES CONFIG
    public $article_title      = array(
        'type'          => 'text',
        'name'          => 'article_title',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'article_title',
        'required'      => true,
        'maxlength'     => 255,
        'label'         => 'Title'
    );
    
    public $article_title2      = array(
        'type'          => 'text',
        'name'          => 'article_title2',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'article_title2',
        'required'      => false,
        'maxlength'     => 255,
        'label'         => 'Title 2'
    );
    
    public $article_description= array(
        'type'          => 'textarea',
        'name'          => 'article_description',
        'form-align'    => 'horizontal',
        'class'         => 'form-control meta_description_input',
        'id'            => 'article_description',
        'required'      => false,
        'maxlength'     => 255,
        'label'         => 'Brief Description'
    );
    
    public $article_description2= array(
        'type'          => 'textarea',
        'name'          => 'article_description2',
        'form-align'    => 'horizontal',
        'class'         => 'form-control meta_description_input',
        'id'            => 'article_description2',
        'required'      => false,
        'maxlength'     => 255,
        'label'         => 'Brief Description 2'
    );
    
    public $article_image_background         = array(
        'type'          => 'filemanager',
        'name'          => 'article_image_background',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'article_image_background',
        'accept'        => 'jpg,gif,png,jpeg,webp',
        'max_size'      => '5',
        'required'      => true,
        'placeholder'   => 'Article Thumbnail',
        'label'         => 'Image Background',
        
    );  
    
    public $article_image_banner         = array(
        'type'          => 'filemanager',
        'name'          => 'article_image_banner',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'article_image_banner',
        'accept'        => 'jpg,gif,png,jpeg,webp',
        'max_size'      => '5',
        'required'      => true,
        'label'         => 'Image Banner',
        
    );  
    
    public $article_image_thumbnail         = array(
        'type'          => 'filemanager',
        'name'          => 'article_image_thumbnail',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'article_image_thumbnail',
        'accept'        => 'jpg,gif,png,jpeg,webp',
        'max_size'      => '5',
        'required'      => true,
        'label'         => 'Image Thumbnail',
        
    );  
    
    public $article_source_links         = array(
        'type'          => 'ckeditor',
        'name'          => 'article_source_links',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'article_source_links',
        'required'      => true,
        'placeholder'   => 'Source Links', 
        'label'         => 'Source Links',
    );
    
    public $article_status          = array(
        'type'          => 'dropdown',
        'name'          => 'article_status',
        'form-align'    => 'horizontal',
        'class'         => 'form-control status_input',
        'id'            => 'article_status',
        'required'      => true,
        'placeholder'   => 'Status',
        'label'         => 'Status',
        'list_value'    => array(
                            '1'     => 'Active',
                            '0'     => 'Inactive'
                        )
    );
    
    public $article_meta_description      = array(
        'type'          => 'textarea',
        'name'          => 'article_meta_description',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'article_meta_description',
        'required'      => true,
        'maxlength'     => 255,
        'accept'        => '/[^a-zA-Z0-9 .,-]/g',
        'label'         => 'Meta Description'
    );
    
    public $article_meta_keyword      = array(
        'type'          => 'textarea',
        'name'          => 'article_meta_keyword',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'article_meta_keyword',
        'required'      => false,
        'maxlength'     => 255,
        'accept'        => '/[^a-zA-Z0-9 .,-]/g',
        'label'         => 'Meta Keyword'
    );
    
    public $article_facebook_share          = array(
        'type'          => 'dropdown',
        'name'          => 'article_facebook_share',
        'form-align'    => 'horizontal',
        'class'         => 'form-control status_input',
        'id'            => 'article_facebook_share',
        'required'      => false,
        'placeholder'   => 'Select...',
        'label'         => 'Facebook Share',
        'list_value'    => array(
                            '1'     => 'Enabled',
                            '0'     => 'Disabled'
                        )
    );
    
    public $article_twitter_share          = array(
        'type'          => 'dropdown',
        'name'          => 'article_twitter_share',
        'form-align'    => 'horizontal',
        'class'         => 'form-control status_input',
        'id'            => 'article_twitter_share',
        'required'      => false,
        'placeholder'   => 'Select...',
        'label'         => 'Twitter Share',
        'list_value'    => array(
                            '1'     => 'Enabled',
                            '0'     => 'Disabled'
                        )
    );
    
    
    public $article_instagram_share          = array(
        'type'          => 'dropdown',
        'name'          => 'article_instagram_share',
        'form-align'    => 'horizontal',
        'class'         => 'form-control status_input',
        'id'            => 'article_instagram_share',
        'required'      => false,
        'placeholder'   => 'Select...',
        'label'         => 'Instagram Share',
        'list_value'    => array(
                            '1'     => 'Enabled',
                            '0'     => 'Disabled'
                        )
    );
    
    
    public $article_pinterest_share          = array(
        'type'          => 'dropdown',
        'name'          => 'article_pinterest_share',
        'form-align'    => 'horizontal',
        'class'         => 'form-control status_input',
        'id'            => 'article_pinterest_share',
        'required'      => false,
        'placeholder'   => 'Select...',
        'label'         => 'Pinterest Share',
        'list_value'    => array(
                            '1'     => 'Enabled',
                            '0'     => 'Disabled'
                        )
    );
    
    
    public $article_linkein_share          = array(
        'type'          => 'dropdown',
        'name'          => 'article_linkein_share',
        'form-align'    => 'horizontal',
        'class'         => 'form-control status_input',
        'id'            => 'article_linkein_share',
        'required'      => false,
        'placeholder'   => 'Select...',
        'label'         => 'LinkedIn Share',
        'list_value'    => array(
                            '1'     => 'Enabled',
                            '0'     => 'Disabled'
                        )
    );
    
    
    public $article_tumblr_share          = array(
        'type'          => 'dropdown',
        'name'          => 'article_tumblr_share',
        'form-align'    => 'horizontal',
        'class'         => 'form-control status_input',
        'id'            => 'article_tumblr_share',
        'required'      => false,
        'placeholder'   => 'Select...',
        'label'         => 'Tumblr Share',
        'list_value'    => array(
                            '1'     => 'Enabled',
                            '0'     => 'Disabled'
                        )
    );
    
    public $article_review      = array(
        'type'          => 'text',
        'name'          => 'article_review',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'article_review',
        'required'      => false,
        'maxlength'     => 255,
        'label'         => 'Medically Reviewed By'
    );
                                                
    
    // BANNER CONFIG                    
    public $banner_title      = array(
        'type'          => 'text',
        'name'          => 'banner_title',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'banner_title',
        'required'      => true,
        'maxlength'     => 255,
        'label'         => 'Title'
    );
    
    public $banner_description= array(
        'type'          => 'textarea',
        'name'          => 'banner_description',
        'form-align'    => 'horizontal',
        'class'         => 'form-control meta_description_input',
        'id'            => 'banner_description',
        'required'      => true,
        'maxlength'     => 500,
        'label'         => 'Description'
    );
    
    
    public $banner_media_web= array(
        'type'          => 'filemanager',
        'name'          => 'banner_media_web',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'banner_media_web',
        'accept'        => 'jpg,png,jpeg,webp,mp4,gif',
        'max_size'      => '50',
        'required'      => true,
        'label'         => 'Banner Media (Web)',
    );
    
    
    
    public $banner_media_tablet= array(
        'type'          => 'filemanager',
        'name'          => 'banner_media_tablet',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'banner_media_tablet',
        'accept'        => 'jpg,png,jpeg,webp,mp4,gif',
        'max_size'      => '50',
        'label'         => 'Banner Media (Tablet)',
    );
    
    public $banner_media_mobile= array(
        'type'          => 'filemanager',
        'name'          => 'banner_media_mobile',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'banner_media_mobile',
        'accept'        => 'jpg,png,jpeg,webp,mp4,gif',
        'max_size'      => '50',
        'required'      => true,
        'label'         => 'Banner Media (Mobile)',
    );
    
    public $banner_logo= array(
        'type'          => 'filemanager',
        'name'          => 'banner_logo',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'banner_logo',
        'accept'        => 'jpg,png,jpeg,webp',
        'max_size'      => '5',
        'required'      => false,
        'label'         => 'Banner Logo',
    );
    
    
    public $banner_button_url     = array(
        'type'          => 'text',
        'name'          => 'banner_button_url',
        'form-align'    => 'horizontal',
        'class'         => 'form-control redirect_url_input',
        'id'            => 'banner_button_url',
        'label'         => 'Button Redirect URL',
    );
    
    public $banner_button_text = array(
        'type'          => 'text',
        'name'          => 'banner_button_text',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'banner_button_text',
        'maxlength'     => 50,
        'label'         => 'Button Text'
    );
    
    public $banner_navigation_text = array(
        'type'          => 'text',
        'name'          => 'banner_navigation_text',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'banner_navigation_text',
        'maxlength'     => 50,
        'label'         => 'Navigation Text'
    );
    
    public $banner_navigation_url     = array(
        'type'          => 'text',
        'name'          => 'banner_navigation_url',
        'form-align'    => 'horizontal',
        'class'         => 'form-control redirect_url_input',
        'id'            => 'banner_navigation_url',
        'label'         => 'Navigation Redirect URL',
    );
    
    
    public $banner_status          = array(
        'type'          => 'dropdown',
        'name'          => 'banner_status',
        'form-align'    => 'horizontal',
        'class'         => 'form-control status_input',
        'id'            => 'banner_status',
        'required'      => true,
        'placeholder'   => 'Status',
        'label'         => 'Status',
        'list_value'    => array(
                            '1'     => 'Active',
                            '0'     => 'Inactive'
                        )
    );
    
    //UNITED CREED
    //SECTION
    
    public $united_title      = array(
        'type'          => 'text',
        'name'          => 'united_title',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'united_title',
        'maxlength'     => 255,
        'required'      => true,
        'placeholder'   => 'Title',
        'label'         => 'Title',
        
    );
    
    public $united_brief_description= array(
        'type'          => 'textarea',
        'name'          => 'united_brief_description',
        'form-align'    => 'horizontal',
        'class'         => 'form-control brief_description_input',
        'id'            => 'united_brief_description',
        'required'      => true,
        'no_html'      => true,
        'maxlength'     => 500,
        'placeholder'   => 'Brief Description',
        'label'         => 'Brief Description',
        
    );
    
    public $united_description= array(
        'type'          => 'ckeditor',
        'name'          => 'united_description',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'united_description',
        'required'      => true,
        'placeholder'   => 'Content', 
        'label'         => 'Content',
    );
    
    public $united_content         = array(
        'type'          => 'ckeditor',
        'name'          => 'united_content',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'united_content',
        'required'      => true,
        'placeholder'   => 'Content', 
        'label'         => 'Content',
            
    );
    
    
    public $united_image_banner          = array(
        'type'          => 'filemanager',
        'name'          => 'united_image_banner',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'united_image_banner',
        'accept'        => 'jpg,gif,png,jpeg,webp',
        'max_size'      => '5',
        'required'      => true,
        'placeholder'   => 'Image Banner',
        'label'         => 'Image Banner',
    );
    
    public $united_image_background         = array(
        'type'          => 'filemanager',
        'name'          => 'united_image_background',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'united_image_background',
        'accept'        => 'jpg,gif,png,jpeg,webp',
        'max_size'      => '5',
        'required'      => true,
        'placeholder'   => 'Background Image',
        'label'         => 'Background Image',
        
    );
    
    public $united_image         = array(
        'type'          => 'filemanager',
        'name'          => 'united_image',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'united_image',
        'accept'        => 'jpg,gif,png,jpeg,webp',
        'max_size'      => '5',
        'required'      => true,
        'placeholder'   => 'Image',
        'label'         => 'Image',
        
    );
    
    
    public $united_status          = array(
        'type'          => 'dropdown',
        'name'          => 'united_status',
        'form-align'    => 'horizontal',
        'class'         => 'form-control status_input',
        'id'            => 'united_status',
        'required'      => true,
        'placeholder'   => 'Status',
        'label'         => 'Status',
        'list_value'    => array(
                            '1'     => 'Active',
                            '0'     => 'Inactive'
                        )
    );
    
    
    //Bayanihan programs config
    public $program_name      = array(
        'type'          => 'text',
        'name'          => 'program_name',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'program_name',
        'required'      => true,
        'maxlength'     => 255,
        'accept'        => '/[^a-zA-Z0-9 .,-]/g',
        'label'         => 'Program Name'
    );
    
    public $program_description= array(
        'type'          => 'textarea',
        'name'          => 'program_description',
        'form-align'    => 'horizontal',
        'class'         => 'form-control meta_description_input',
        'id'            => 'program_description',
        'required'      => true,
        'maxlength'     => 500,
        'label'         => 'Brief Description'
    );  
    
    public $program_content         = array(
        'type'          => 'ckeditor',
        'name'          => 'program_content',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'program_content',
        'required'      => true,
        'placeholder'   => 'Content', 
        'label'         => 'Content',
    );
    
    
    public $program_status          = array(
        'type'          => 'dropdown',
        'name'          => 'program_status',
        'form-align'    => 'horizontal',
        'class'         => 'form-control status_input',
        'id'            => 'program_status',
        'required'      => true,
        'placeholder'   => 'Status',
        'label'         => 'Status',
        'list_value'    => array(
                            '1'     => 'Active',
                            '0'     => 'Inactive'
                        )
    );
    
    public $program_banner          = array(
        'type'          => 'filemanager',
        'name'          => 'program_banner',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'program_banner',
        'accept'        => 'jpg,gif,png,jpeg,webp',
        'required'      => true,
        'placeholder'   => 'Banner Image',
        'label'         => 'Banner Image',
    );
    
    public $program_thumbnail         = array(
                'type'          => 'filemanager',
                'name'          => 'program_thumbnail',
                'form-align'    => 'horizontal',
                'class'         => 'form-control',
                'id'            => 'program_thumbnail',
                'accept'        => 'jpg,gif,png,jpeg,webp',
                'max_size'      => '5',
                'required'      => true,
                'placeholder'   => 'Thumbnail Image',
                'label'         => 'Thumbnail Image',
                
    );
    
        
    //Hiring Process
    //SECTION
    
    public $hiring_process_title      = array(
        'type'          => 'text',
        'name'          => 'hiring_process_title',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'hiring_process_title',
        'maxlength'     => 255,
        'required'      => true,
        'placeholder'   => 'Title',
        'label'         => 'Title',
        
    );
    
    public $hiring_process_brief_description= array(
        'type'          => 'textarea',
        'name'          => 'hiring_process_brief_description',
        'form-align'    => 'horizontal',
        'class'         => 'form-control brief_description_input',
        'id'            => 'hiring_process_brief_description',
        'required'      => true,
        'no_html'      => true,
        'maxlength'     => 500,
        'placeholder'   => 'Brief Description',
        'label'         => 'Brief Description',
        
    );
    
    public $hiring_process_content         = array(
        'type'          => 'ckeditor',
        'name'          => 'hiring_process_content',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'hiring_process_content',
        'required'      => true,
        'placeholder'   => 'Content', 
        'label'         => 'Content',
            
    );
    
    
    public $hiring_process_image_banner          = array(
        'type'          => 'filemanager',
        'name'          => 'hiring_process_image_banner',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'hiring_process_image_banner',
        'accept'        => 'jpg,gif,png,jpeg,webp',
        'max_size'      => '5',
        'required'      => true,
        'placeholder'   => 'Image Banner',
        'label'         => 'Image Banner',
    );
    
    public $hiring_process_image_background         = array(
        'type'          => 'filemanager',
        'name'          => 'hiring_process_image_background',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'hiring_process_image_background',
        'accept'        => 'jpg,gif,png,jpeg,webp',
        'max_size'      => '5',
        'required'      => true,
        'placeholder'   => 'Background Image',
        'label'         => 'Background Image',
        
    );
    
    public $hiring_process_description         = array(
        'type'          => 'ckeditor',
        'name'          => 'hiring_process_description',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'hiring_process_description',
        'required'      => true,
        'placeholder'   => 'Description', 
        'label'         => 'Description',
            
    );
    
    public $hiring_process_status          = array( 
        'type'          => 'dropdown',
        'name'          => 'hiring_process_status',
        'form-align'    => 'horizontal',
        'class'         => 'form-control status_input',
        'id'            => 'hiring_process_status',
        'required'      => true,
        'placeholder'   => 'Status',
        'label'         => 'Status',
        'list_value'    => array(
                            '1'     => 'Active',
                            '0'     => 'Inactive'
                        )
    );
    
    public $hiring_process_media_type= array(
        'type'          => 'dropdown',
        'name'          => 'hiring_process_media_type',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'hiring_process_media_type',
        'required'      => false,
        'label'         => 'Media Type',
        'list_value'    => array(
                            ''  => '',
                            '1'  => 'Upload Media Field',
                            '2'  => 'Youtube Media Field'
                        )
    );
    
    
    public $hiring_process_upload_media         = array(
        'type'          => 'filemanager',
        'name'          => 'hiring_process_upload_media',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'hiring_process_upload_media',
        'accept'        => 'jpg,gif,png,jpeg,webp,mp4',
        'max_size'      => '50',
        'required'      => false,
        'placeholder'   => 'Upload Media',
        'label'         => 'Upload Media',
        
    );
    
    public $hiring_process_youtube_link      = array(
        'type'          => 'youtube',
        'name'          => 'hiring_process_youtube_link',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'required'      => false,
        'id'            => 'hiring_process_youtube_link',
        'placeholder'   => 'Youtube Video',
        'label'         => 'Youtube Video',
    );
    
    public $stars= array(
        'type'          => 'dropdown',
        'name'          => 'stars',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'stars',
        'required'      => true,
        'label'         => 'Stars',
        'note'          => 'Maximum value is 5. Minumum value is 0.',
        'list_value'    => array(
                            ''  => '',
                            '0'  => '0',
                            '1'  => '1',
                            '2'  => '2',
                            '3'  => '3',
                            '4'  => '4',
                            '5'  => '5'  
                        )
    );
    
    
    public $category_type= array(
        'type'          => 'dropdown',
        'name'          => 'category_type',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'category_type',
        'placeholder'   => '',
        'label'         => 'Category Type',
        'list_value'    => array(
                            '1'     => 'Individual',
                            '2'    => 'Group',
                        ),
    );
    
    public $product_category= array(
        'type'          => 'text',
        'name'          => 'category',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'product_category',
        'required'      => true,
        'maxlength'    => 255,
        'placeholder'   => '',
        'label'         => 'Category'
    );
    
    public $text_description      = array(
        'type'          => 'textarea',
        'name'          => 'description',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'description',
        'required'      => true,
        'maxlength'    => 500,
        'placeholder'   => '',
        'label'         => 'Description'
    );
    
    public $terms_and_condition_title      = array(
        'type'          => 'text',
        'name'          => 'terms_and_condition_title',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'terms_and_condition_title',
        'maxlength'     => 255,
        'required'      => true,
        'placeholder'   => 'Terms and Conditions Title',
        'label'         => 'Terms & Conditions Title',
        
    );
    
    public $terms_and_condition_statement   = array(
        'type'          => 'ckeditor',
        'name'          => 'terms_and_condition_statement',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'terms_and_condition_statement',
        'required'      => true,
        'filemanager'   => false,
        'youtube'       => false,
        'placeholder'   => 'Terms and Condition Statement',
        'label'         => 'Terms & Conditions Statement',
        
    );
    
    public $subtitle= array(
        'type'          => 'text',
        'name'          => 'subtitle',
        'form-align'    => 'horizontal',
        'class'         => 'form-control product_info_inputs',
        'id'            => 'subtitle',
        'required'      => true,
        'maxlength'    => 255,
        'placeholder'   => '',
        'label'         => 'Subtitle'
    );
    
    public $promo_subtitle= array(
        'type'          => 'text',
        'name'          => 'promo_subtitle',
        'form-align'    => 'horizontal',
        'class'         => 'form-control product_info_inputs',
        'id'            => 'promo_subtitle',
        'required'      => false,
        'maxlength'    => 255,
        'label'         => 'Subtitle'
    );
    
    public $event_subtitle= array(
        'type'          => 'text',
        'name'          => 'event_subtitle',
        'form-align'    => 'horizontal',
        'class'         => 'form-control event_subtitle_inputs',
        'id'            => 'event_subtitle',
        'required'      => false,
        'maxlength'    => 255,
        'placeholder'   => '',
        'label'         => 'Subtitle'
    );
    
    public $promo_highlight          = array(
        'type'          => 'dropdown',
        'name'          => 'promo_highlight',
        'form-align'    => 'horizontal',
        'class'         => 'form-control promo_highlight_input',
        'id'            => 'promo_highlight',
        'required'      => false,
        'placeholder'   => '',
        'label'         => 'Highlight (Additional)',
        'list_value'    => array(
                            '0'     => 'No',
                            '1'     => 'Yes'
                        )
    );
    
       
    public $summary_content= array(
        'type'          => 'ckeditor',
        'name'          => 'summary_content',
        'form-align'    => 'horizontal',
        'class'         => 'form-control product_info_inputs',
        'id'            => 'summary_content',
        'required'      => true,
        'youtube'       => false,
        'filemanager'   => false,
        'label'         => 'Summary Content'
    );
    
    public $complete_content= array(
        'type'          => 'ckeditor',
        'name'          => 'complete_content',
        'form-align'    => 'horizontal',
        'class'         => 'form-control product_info_inputs',
        'id'            => 'complete_content',
        'required'      => true,
        'youtube'       => false,
        'filemanager'   => false,
        'label'         => 'Complete Content'
    );
    
    public $product_composition= array(
        'type'          => 'ckeditor',
        'name'          => 'product_composition',
        'form-align'    => 'horizontal',
        'class'         => 'form-control product_info_inputs',
        'id'            => 'product_composition',
        'required'      => true,
        'youtube'       => false,
        'filemanager'   => false,
        'label'         => 'Product Composition'
    );
    
    public $product_info_leaflet= array(
        'type'          => 'filemanager',
        'name'          => 'product_info_leaflet',
        'form-align'    => 'horizontal',
        'class'         => 'form-control product_info_inputs',
        'id'            => 'product_info_leaflet',
        'accept'        => 'pdf',
        'max_size'      => '20',
        'required'      => true,
        'placeholder'   => '',
        'label'         => 'Product Info Leaflet',   
    );
    
    public $caption      = array(
        'type'          => 'text',
        'name'          => 'caption',
        'form-align'    => 'horizontal',
        'class'         => 'form-control prod_info_img_inputs',
        'id'            => 'caption',
        'required'      => true,
        'maxlength'    => 50,
        'placeholder'   => '',
        'label'         => 'Caption'
    );
    
    public $price      = array(
        'type'          => 'text',
        'name'          => 'price',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'price',
        'required'      => false,
        'placeholder'   => '',
        'label'         => 'Price',
        'accept'       =>  ' /[^0-9.]/g' 
    );
    
    public $product_site_id    = array(
        'type'          => 'dropdown',
        'name'          => 'product_id',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'product_id',
        'required'      => true,
        'placeholder'   => 'Select',
        'label'         => 'Product',
        'list_value'    => array(
            0 => 'None'
        )
    );
    
    public $product_list          = array(
        'type'          => 'dropdown',
        'name'          => 'product_list',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'product_list',
        'required'      => true,
        'placeholder'   => '',
        'label'         => 'Product',
        'list_value'    => array(
                            0 => 'None'
                        )
    );
    
    public $product_list_variant          = array(
        'type'          => 'dropdown',
        'name'          => 'product_list_variant',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'product_list',
        'required'      => true,
        'placeholder'   => '',
        'label'         => 'Product',
        'list_value'    => array(
                            0 => ''
                        )
    );
    
    public $site_info_title      = array(
        'type'          => 'text',
        'name'          => 'title',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'title',
        'maxlength'     => 50,
        'required'      => true,
        'placeholder'   => '',
        'label'         => 'Title',
    );
    public $user_role_name            = array(
        'type'          => 'text',
        'name'          => 'name',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'name',
        'maxlength'     => 50,
        'required'      => true,
        'accept'        => '/[^a-zA-Z0-9\u00f1\u00d1 .,-\/\']/g',
        'placeholder'   => '',
        'label'         => 'Name'
    );
    
    public $caution_message= array(
        'type'          => 'textarea',
        'name'          => 'caution_message',
        'form-align'    => 'horizontal',
        'class'         => 'form-control caution_message_input',
        'id'            => 'caution_message',
        'required'      => true,
        'no_html'       => true,
        'maxlength'     => 500,
        'placeholder'   => '',
        'label'         => 'Caution Message',
        
    );
    
    public $main_message         = array(
        'type'          => 'ckeditor',
        'name'          => 'main_message',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'main_message',
        'required'      => true,
        'placeholder'   => '',
        'label'         => 'Main Message',
    
    );
    
    //Start Our Stories and Stories
    public $our_stories_subtitle_1      = array(
        'type'          => 'text',
        'name'          => 'our_stories_subtitle_1',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'our_stories_subtitle_1',
        'maxlength'     => 255,
        'required'      => true,
        'placeholder'   => 'Subtitle 1',
        'label'         => 'Subtitle 1',
    );
    public $our_stories_brief_description_1= array(
        'type'          => 'textarea',
        'name'          => 'our_stories_brief_description_1',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'our_stories_brief_description_1',
        'required'      => true,
        'no_html'       => true,
        'maxlength'     => 500,
        'placeholder'   => 'Brief Description 1',
        'label'         => 'Brief Description 1',
        
    );
    public $our_stories_content_1         = array(
        'type'          => 'ckeditor',
        'name'          => 'our_stories_content_1',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'our_stories_content_1',
        'required'      => true,
        'placeholder'   => 'Content 1',
        'label'         => 'Content 1',
    );
    public $our_stories_image_banner_1          = array(
        'type'          => 'filemanager',
        'name'          => 'our_stories_image_banner_1',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'our_stories_image_banner_1',
        'accept'        => 'jpg,gif,png,jpeg,webp',
        'max_size'      => '5',
        'required'      => true,
        'max_size'      => '5',
        'placeholder'   => 'Image Banner',
        'label'         => 'Image Banner',
    );
    public $our_stories_subtitle_2      = array(
        'type'          => 'text',
        'name'          => 'our_stories_subtitle_2',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'our_stories_subtitle_2',
        'maxlength'     => 255,
        'required'      => true,
        'placeholder'   => 'Subtitle 2',
        'label'         => 'Subtitle 2',
    );
    public $our_stories_brief_description_2= array(
        'type'          => 'textarea',
        'name'          => 'our_stories_brief_description_2',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'our_stories_brief_description_2',
        'required'      => true,
        'no_html'       => true,
        'maxlength'     => 500,
        'placeholder'   => 'Brief Description 2',
        'label'         => 'Brief Description 2',
        
    );
    public $our_stories_content_2         = array(
        'type'          => 'ckeditor',
        'name'          => 'our_stories_content_2',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'our_stories_content_2',
        'required'      => true,
        'placeholder'   => 'Content 2',
        'label'         => 'Content 2',
    );
    public $our_stories_image_banner_2          = array(
        'type'          => 'filemanager',
        'name'          => 'our_stories_image_banner_2',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'our_stories_image_banner_2',
        'accept'        => 'jpg,gif,png,jpeg,webp',
        'max_size'      => '5',
        'required'      => true,
        'max_size'      => '5',
        'placeholder'   => 'Image Banner 2',
        'label'         => 'Image Banner 2',
    );
    public $stories_type          = array(
        'type'          => 'dropdown',
        'name'          => 'stories_type',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'stories_type',
        'required'      => true, 
        'placeholder'   => 'Stories Type',
        'label'         => 'Stories Type',
        'list_value'    => array(
                            '1'     => 'For The Future',
                            '0'     => 'Humble Beginnings'
                        )
    );
    
    //End Our Stories and Stories
    
    public $is_microsite          = array(
        'type'          => 'dropdown',
        'name'          => 'is_microsite',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'is_microsite',
        'required'      => true,
        'placeholder'   => 'Microsite',
        'label'         => 'Microsite',
        'list_value'    => array(
                            '0'     => 'No',
                            '1'     => 'Yes'
                        )
    );
    
    public $prescription_drug          = array(
        'type'          => 'dropdown',
        'name'          => 'prescription_drug ',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'prescription_drug ',
        'required'      => true,
        'placeholder'   => '',
        'label'         => 'Prescription Drug',
        'list_value'    => array(
                            '0'     => 'No',
                            '1'     => 'Yes'
                        )
    );
    
    public $date_picker       = array(
        'type'          => 'date',
        'name'          => 'date_picker',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'date_picker',
        'required'      => true,
        'minDate'       => '0',
        'placeholder'   => 'Date',
        'label'         => 'Date',
    );    
    
    public $image_banner_web= array(
        'type'          => 'filemanager',
        'name'          => 'image_banner_web',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'image_banner_web',
        'accept'        => 'jpg,gif,png,jpeg,webp',
        'max_size'      => '20',
        'required'      => true,
        'label'         => 'Banner Image (Web)',
    );
    
    public $image_banner_mobile= array(
        'type'          => 'filemanager',
        'name'          => 'image_banner_mobile',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'image_banner_mobile',
        'accept'        => 'jpg,gif,png,jpeg,webp',
        'max_size'      => '20',
        'required'      => true,
        'label'         => 'Banner Image (Mobile)',
    );
    
    public $background_image_banner_web= array(
        'type'          => 'filemanager',
        'name'          => 'background_image_banner_web',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'background_image_banner_web',
        'accept'        => 'jpg,gif,png,jpeg,webp',
        'max_size'      => '20',
        'required'      => true,
        'label'         => 'Background Image (Web)',
    );
    
    public $background_image_banner_mobile= array(
        'type'          => 'filemanager',
        'name'          => 'background_image_banner_mobile',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'background_image_banner_mobile',
        'accept'        => 'jpg,gif,png,jpeg,webp',
        'max_size'      => '20',
        'required'      => true,
        'label'         => 'Background Image (Mobile)',
    );
    
    public $division_name      = array(
        'type'          => 'text',
        'name'          => 'division_name',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'division_name',
        'maxlength'     => 255,
        'placeholder'   => '',
        'required'      => true,
        'label'         => 'Division Name',
        'align'         => 'vertical',  
    );
    
    public $site_type    = array(
        'type'          => 'dropdown',
        'name'          => 'site_type',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'site_type',
        'required'      => true,
        'placeholder'   => 'Select',
        'label'         => 'Type',
        'list_value'    => array(
                            1 => 'Product',
                            2 => 'Division'
                        )
    );
    
    public $media_type_modal= array(
        'type'          => 'dropdown',
        'name'          => 'media_type_modal',
        'form-align'    => 'horizontal',
        'class'         => 'form-control video_type',
        'id'            => 'media_type_modal',
        'required'      => true,
        'placeholder'   => '',
        'label'         => 'Media Type',
        'list_value'    => array(
                            ''     => '',
                            '0'     => 'Upload Media',
                            '1'     => 'Youtube Video'
                        )                  
    );
    //Articles
    
    public $article_category          = array(
        'type'          => 'dropdown',
        'name'          => 'article_category',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'article_category',
        'required'      => true,
        'placeholder'   => 'Article Category',
        'label'         => 'Article Category'
    );
    
    public $article_type          = array(
        'type'          => 'dropdown',
        'name'          => 'article_type',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'article_type',
        'required'      => true,
        'placeholder'   => 'Article Type',
        'label'         => 'Article Type',
        'list_value'    => array(
                            '0'     => 'Normal',
                            '1'     => 'Question',
                            '2'     => 'Slideshow'
                        )
    );
    
    public $question_title      = array(
        'type'          => 'text',
        'name'          => 'question_title',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'question_title',
        'required'      => true,
        'maxlength'     => 255,
        'accept'        => '/~^[a-z0-9/()-]+$~i/',
        'label'         => 'Title'
    );
    
    public $question_field= array(
        'type'          => 'textarea',
        'name'          => 'question_field',
        'form-align'    => 'horizontal',
        'class'         => 'form-control meta_description_input',
        'id'            => 'question_field',
        'required'      => true,
        'maxlength'     => 500,
        'label'         => 'Question'
    );
    
    public $add_choice_title      = array(
        'type'          => 'text',
        'name'          => 'add_choice_title',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'add_choice_title',
        'required'      => true,
        'maxlength'     => 255,
        'accept'        => '/~^[a-z0-9/()-]+$~i/',
        'label'         => 'Add Choice'
    );
    
    public $question_description         = array(
        'type'          => 'ckeditor_modal',
        'name'          => 'question_description',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'question_description',
        'required'      => true,
        'placeholder'   => 'Description',
        'label'         => 'Description',
    );
    
    public $question_image_web         = array(
        'type'          => 'filemanager',
        'name'          => 'question_image_web',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'question_image_web',
        'accept'        => 'jpg,gif,png,jpeg,webp',
        'max_size'      => '5',
        'required'      => true,
        'placeholder'   => 'Image (Web)',
        'label'         => 'Image (Web)',
        
    );  
    
    public $question_image_mobile         = array(
        'type'          => 'filemanager',
        'name'          => 'question_image_mobile',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'question_image_mobile',
        'accept'        => 'jpg,gif,png,jpeg,webp',
        'max_size'      => '5',
        'required'      => true,
        'placeholder'   => 'Image (Mobile)',
        'label'         => 'Image (Mobile)',
        
    );  
    
    
    public $slideshow_title      = array(
        'type'          => 'text',
        'name'          => 'slideshow_title',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'slideshow_title',
        'required'      => false,
        'maxlength'     => 255,
        'accept'        => '/~^[a-z0-9/()-]+$~i/',
        'label'         => 'Title'
    );
    
    public $slideshow_description         = array(
        'type'          => 'ckeditor_modal',
        'name'          => 'slideshow_description',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'slideshow_description',
        'required'      => false,
        'placeholder'   => 'Description',
        'label'         => 'Description',
    );
    
    public $slideshow_image_web         = array(
        'type'          => 'filemanager',
        'name'          => 'slideshow_image_web',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'slideshow_image_web',
        'accept'        => 'jpg,gif,png,jpeg,webp',
        'max_size'      => '5',
        'required'      => true,
        'placeholder'   => 'Image (Web)',
        'label'         => 'Image (Web)',
        
    );  
    
    public $slideshow_image_mobile         = array(
        'type'          => 'filemanager',
        'name'          => 'slideshow_image_mobile',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'slideshow_image_mobile',
        'accept'        => 'jpg,gif,png,jpeg,webp',
        'max_size'      => '5',
        'required'      => true,
        'placeholder'   => 'Image (Mobile)',
        'label'         => 'Image (Mobile)',
        
    );  
    //End of Articles
    // ARTICLE CATEGORY CONFIG                    
    public $article_category_name      = array(
        'type'          => 'text',
        'name'          => 'article_category_name',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'article_category_name',
        'required'      => true,
        'maxlength'     => 255, 
        'label'         => 'Category Name'
    );
    
    public $article_category_description= array(
        'type'          => 'textarea',
        'name'          => 'article_category_description',
        'form-align'    => 'horizontal',
        'class'         => 'form-control meta_description_input',
        'id'            => 'article_category_description',
        'required'      => true,
        'maxlength'     => 500,
        'label'         => 'Description'
    );
    
    
    public $image_web= array(
        'type'          => 'filemanager',
        'name'          => 'image_web',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'image_web',
        'accept'        => 'jpg,gif,png,jpeg,webp',
        'max_size'      => '5',
        'required'      => true,
        'label'         => 'Image (Web)',
    );
    
    public $image_mobile= array(
        'type'          => 'filemanager',
        'name'          => 'image_mobile',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'image_mobile',
        'accept'        => 'jpg,gif,png,jpeg,webp',
        'max_size'      => '5',
        'required'      => true,
        'label'         => 'Image (Mobile)',
    );
    
    
    public $image_web_ingredient          = array(
        'type'          => 'filemanager',
        'name'          => 'image_web_ingredient',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'image_web_ingredient',
        'accept'        => 'jpg,gif,png,jpeg,webp',
        'max_size'      => '5',
        'required'      => true,
        'placeholder'   => '',
        'label'         => 'Image (Web)',
    );
    
    public $image_mobile_ingredient          = array(
        'type'          => 'filemanager',
        'name'          => 'image_mobile_ingredient',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'image_mobile_ingredient',
        'accept'        => 'jpg,gif,png,jpeg,webp',
        'max_size'      => '5',
        'required'      => true,
        'placeholder'   => '',
        'label'         => 'Image (Mobile)',
    );
    
    public $image_web_cause          = array(
        'type'          => 'filemanager',
        'name'          => 'image_web_cause',
        'form-align'    => 'horizontal',
        'class'         => 'form-control prod_info_img_inputs',
        'id'            => 'image_web_cause',
        'accept'        => 'jpg,gif,png,jpeg,webp',
        'max_size'      => '5',
        'required'      => true,
        'placeholder'   => '',
        'label'         => 'Image (Web)',
    );
    
    public $image_mobile_cause          = array(
        'type'          => 'filemanager',
        'name'          => 'image_mobile_cause',
        'form-align'    => 'horizontal',
        'class'         => 'form-control prod_info_img_inputs',
        'id'            => 'image_mobile_cause',
        'accept'        => 'jpg,gif,png,jpeg,webp',
        'max_size'      => '5',
        'required'      => true,
        'placeholder'   => '',
        'label'         => 'Image (Mobile)',
    );
    
    public $image_web_prevention          = array(
        'type'          => 'filemanager',
        'name'          => 'image_web_prevention',
        'form-align'    => 'horizontal',
        'class'         => 'form-control prod_info_img_inputs',
        'id'            => 'image_web_prevention',
        'accept'        => 'jpg,gif,png,jpeg,webp',
        'max_size'      => '5',
        'required'      => true,
        'placeholder'   => '',
        'label'         => 'Image (Web)',
    );
    
    public $image_mobile_prevention          = array(
        'type'          => 'filemanager',
        'name'          => 'image_mobile_prevention',
        'form-align'    => 'horizontal',
        'class'         => 'form-control prod_info_img_inputs',
        'id'            => 'image_mobile_prevention',
        'accept'        => 'jpg,gif,png,jpeg,webp',
        'max_size'      => '5',
        'required'      => true,
        'placeholder'   => '',
        'label'         => 'Image (Mobile)',
    );
    
    public $media_table          = array(
        'type'          => 'table',
        'name'          => 'media_table',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'media_table',
        'label'         => 'Media',
        'table-headers' => ["Title", "Description"]
    );
    
    public $detail_table          = array(
        'type'          => 'table',
        'name'          => 'detail_table',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'detail_table',
        'label'         => 'Other Detail',
        'table-headers' => ["Title", "Description"]
    );
    
    public $causes_table          = array(
        'type'          => 'table',
        'name'          => 'causes_table',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'causes_table',
        'label'         => 'Causes',
        'table-headers' => ["Title", "Description"]
    );
    
    public $prevention_table          = array(
        'type'          => 'table',
        'name'          => 'prevention_table',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'prevention_table',
        'label'         => 'Prevention',
        'table-headers' => ["Title", "Description"]
    );
    
    public $division_id          = array(
        'type'          => 'dropdown',
        'name'          => 'division_id',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'division_id',
        'required'      => true,    
        'placeholder'   => 'Select',
        'label'         => 'Division',
        'list_value'    => array(
                            '0'  => 'None'
                        )
    );
    
    public $title_vertical      = array(
        'type'          => 'text',
        'name'          => 'title_vertical',
        'form-align'    => 'vertical',
        'class'         => 'form-control',
        'id'            => 'title_vertical',
        'maxlength'     => 255,
        'required'      => true,
        'placeholder'   => 'Title',
        'label'         => 'Title',
        'display'       => 1,
        'is_list'       => 1,
        'alignment'     => 1
    );
    
    public $content_vertical         = array(
        'type'          => 'ckeditor',
        'name'          => 'content_vertical',
        'form-align'    => 'vertical',
        'class'         => 'form-control',
        'id'            => 'content_vertical',
        'required'      => true,
        'placeholder'   => 'Content',
        'label'         => 'Content',
        'maxlength'     => 50
    );
    
    public $illness      = array(
        'type'          => 'text',
        'name'          => 'illness',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'illness',
        'required'      => true,
        'maxlength'    => 50,
        'placeholder'   => '',
        'label'         => 'Illness'
    );
    
    public $body_part          = array(
        'type'          => 'dropdown',
        'name'          => 'body_part',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'body_part',
        'required'      => true,
        'placeholder'   => '',
        'label'         => 'Body Part',
        'list_value'    => array(
                            'head'      => 'Head or Brain',
                            'eyes'      => 'Eye',
                            'ears'      => 'Ear',
                            'nose'      => 'Nose',
                            'mouth'     => 'Mouth or Teeth',
                            'neck'      => 'Neck or Back',
                            'chest'     => 'Chest',
                            'abdomen'   => 'Abdomen',
                            'genitals'  => 'Genitals and Urinary',
                            'armlegs'   => 'Arm or Leg',
                            'skin'      => 'Skin',
                            'baby'      => 'Baby Symptoms',
                            'other'     => 'Other Symptoms',
    
                        )
    );
    
    public $template_table          = array(
        'type'          => 'table_template',
        'name'          => 'template_table',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'template_table',
        'label'         => 'Template',
        'table-headers' => ["Page", "Desktop Layout", "Mobile Layout", "Display Name"]
    );
    
    public $type    = array(
        'type'          => 'dropdown',
        'name'          => 'type',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'type',
        'required'      => true,
        'disabled'      => 'disabled',
        'placeholder'   => '',
        'label'         => 'Type',
        'list_value'    => array(
                            0    => 'Corporate',
                            1   => 'Brand'
        ),
    );
    
    public $latitude      = array(
        'type'          => 'text',
        'name'          => 'latitude',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'latitude',
        'required'      => false,
        'placeholder'   => '',
        'label'         => 'Latitude(Y)',
        'accept'       =>  ' /[^0-9.]/g' 
    );
    
    public $longitude      = array(
        'type'          => 'text',
        'name'          => 'longitude',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'longitude',
        'required'      => false,
        'placeholder'   => '',
        'label'         => 'Longitude(X)',
        'accept'       =>  ' /[^0-9.]/g' 
    );
    
    public $color= array(
        'type'          => 'input-color',
        'name'          => 'color',
        'form-align'    => 'horizontal',
        'class'         => 'form-control product_info_inputs',
        'id'            => 'color',
        'required'      => true,
        'maxlength'     => 7,
        'placeholder'   => '',
        'label'         => 'Color'
    );
    
    public $where_to_buy_color= array(
        'type'          => 'input-color',
        'name'          => 'where_to_buy_color',
        'form-align'    => 'horizontal',
        'class'         => 'form-control product_info_inputs',
        'id'            => 'where_to_buy_color',
        'required'      => false,
        'maxlength'     => 7,
        'placeholder'   => '',
        'label'         => 'Where To Buy Color'
    );
    
    public $leader_message         = array(
        'type'          => 'ckeditor',
        'name'          => 'message',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'message',
        'required'      => true,
        'placeholder'   => '',
        'label'         => 'Message',
    );
    
    public $sponsor      = array(
        'type'          => 'text',
        'name'          => 'sponsors',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'sponsors',
        'required'      => true,
        'maxlength'    => 255,
        'placeholder'   => '',
        'label'         => 'Sponsor'
        
    );
    
    public $contact_details_title      = array(
        'type'          => 'text',
        'name'          => 'title',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'title',
        'maxlength'     => 50,
        'required'      => true,
        'placeholder'   => '',
        'label'         => 'Title'
    );
    
    public $image_desktop= array(
        'type'          => 'filemanager',
        'name'          => 'image_web',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'image_web',
        'accept'        => 'jpg,gif,png,jpeg,webp',
        'max_size'      => '5',
        'required'      => true,
        'label'         => 'Image (Desktop)',
    );
    
    public $promo_image_desktop= array(
        'type'          => 'filemanager',
        'name'          => 'promo_image_desktop',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'promo_image_desktop',
        'accept'        => 'jpg,png,jpeg,webp',
        'max_size'      => '5',
        'required'      => false,
        'label'         => 'Image (Desktop)',
    );
    public $promo_image_mobile= array(
        'type'          => 'filemanager',
        'name'          => 'promo_image_mobile',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'promo_image_mobile',
        'accept'        => 'jpg,png,jpeg,webp',
        'max_size'      => '5',
        'required'      => false,
        'label'         => 'Image (Mobile)',
    );
    public $event_image_desktop= array(
        'type'          => 'filemanager',
        'name'          => 'event_image_desktop',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'event_image_desktop',
        'accept'        => 'jpg,png,jpeg,webp',
        'max_size'      => '5',
        'required'      => false,
        'label'         => 'Image (Desktop)',
    );
    
    public $event_image_mobile= array(
        'type'          => 'filemanager',
        'name'          => 'event_image_mobile',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'event_image_mobile',
        'accept'        => 'jpg,png,jpeg,webp',
        'max_size'      => '5',
        'required'      => false,
        'label'         => 'Image (Mobile)',
    );
    
    public $landline      = array(
        'type'          => 'text',
        'name'          => 'landline',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'landline',
        'maxlength'     => 50,
        'label'         => 'Landline'
    );
    
    public $toll_fee      = array(
        'type'          => 'text',
        'name'          => 'toll_fee',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'toll_fee',
        'maxlength'     => 50,
        'label'         => 'Provincial Toll-Free'
    );
    
    public $contact_detail_email   = array(
        'type'          => 'email',
        'name'          => 'contact_detail_email',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'contact_detail_email',
        'maxlength'     => 100,
        'placeholder'   => '',
        'label'         => 'Email'
    );
    
    public $contact_detail_sms   = array(
        'type'          => 'text',
        'name'          => 'contact_detail_sms',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'contact_detail_sms',
        'maxlength'     => 100,
        'placeholder'   => '',
        'label'         => 'SMS'
    );
    
    public $contact_us_facebook         = array(
        'type'          => 'text',
        'name'          => 'contact_us_facebook',
        'form-align'    => 'horizontal',
        'class'         => 'form-control validateURL',
        'id'            => 'contact_us_facebook',
        'required'      => false,
        'placeholder'   => '',
        'label'         => 'Facebook'
    );
    
    public $contact_us_viber         = array(
        'type'          => 'text',
        'name'          => 'contact_us_viber',
        'form-align'    => 'horizontal',
        'class'         => 'form-control validateURL',
        'id'            => 'contact_us_viber',
        'required'      => false,
        'placeholder'   => '',
        'label'         => 'Viber'
    );
    
    public $contact_us_whatsapp         = array(
        'type'          => 'text',
        'name'          => 'contact_us_whatsapp',
        'form-align'    => 'horizontal',
        'class'         => 'form-control validateURL',
        'id'            => 'contact_us_whatsapp',
        'required'      => false,
        'placeholder'   => '',
        'label'         => 'WhatsApp'
    );
    
    public $availability_sched      = array(
        'type'          => 'textarea',
        'name'          => 'availability_sched',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'availability_sched',
        'maxlength'     => 255,
        'placeholder'   => '',
        'label'         => 'Availability Schedule',
    );
    
    public $adverse_button_text      = array(
        'type'          => 'textarea',
        'name'          => 'adverse_button_text',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'adverse_button_text',
        'maxlength'     => 500,
        'placeholder'   => '',
        'label'         => 'Adverse Report Button Text',
    );
    
    public $contact_details_message         = array(
        'type'          => 'ckeditor',
        'name'          => 'contact_details_message',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'contact_details_message',
        'placeholder'   => '',
        'label'         => 'Message',
        
    );
    
    public $contact_details_description= array(
        'type'          => 'textarea',
        'name'          => 'contact_details_description',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'contact_details_description',
        'required'      => false,
        'no_html'       => true,
        'maxlength'     => 255,
        'placeholder'   => '',
        'label'         => 'Description',
        
    );
    
    public $email_to= array(
        'type'          => 'text',
        'name'          => 'email_to',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'email_to',
        'required'      => true,
        'no_html'       => true,
        'placeholder'   => '',
        'label'         => 'TO',
        'data-role'     => 'tagsinput',
        'data-email-type' => 'email_to'
    );
    
    public $email_cc= array(
        'type'          => 'text',
        'name'          => 'email_cc',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'email_cc',
        'required'      => false,
        'no_html'       => true,
        'placeholder'   => '',
        'label'         => 'CC',
        'data-role'     => 'tagsinput',
        'data-email-type' => 'email_cc'
    );
    
    public $email_bcc= array(
        'type'          => 'text',
        'name'          => 'email_bcc',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'email_bcc',
        'required'      => false,
        'no_html'       => true,
        'placeholder'   => '',
        'label'         => 'BCC',
        'data-role'     => 'tagsinput',
        'data-email-type' => 'email_bcc'
    );
    
    public $brief_description_150= array(
        'type'          => 'textarea',
        'name'          => 'brief_description',
        'form-align'    => 'horizontal',
        'class'         => 'form-control brief_description_input',
        'id'            => 'brief_description',
        'required'      => true,
        'no_html'       => true,
        'maxlength'     => 150,
        'placeholder'   => 'Brief Description',
        'label'         => 'Brief Description',
        
    );
    
    public $brief_description_255= array(
        'type'          => 'textarea',
        'name'          => 'brief_description_255',
        'form-align'    => 'horizontal',
        'class'         => 'form-control brief_description_input',
        'id'            => 'brief_description_255',
        'required'      => false,
        'no_html'       => true,
        'maxlength'     => 150,
        'placeholder'   => '',
        'label'         => 'Brief Description',
    );
    
    
    
    public $company_banner_content      = array(
        'type'          => 'ckeditor',
        'name'          => 'company_banner_content',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'company_banner_content',
        'placeholder'   => '',
        'label'         => 'Banner Content',
    );
    
    
    public $company_banner_title      = array(
        'type'          => 'text',
        'name'          => 'company_banner_title',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'company_banner_title',
        'required'      => true,
        'maxlength'     => 255,
        'label'         => 'Banner Title'
    );
    
    public $ckeditor_brief_description     = array(
        'type'          => 'ckeditor',
        'name'          => 'brief_description',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'brief_description',
        'required'      => true,
        'no_html'      => false,
        'filemanager'   => false,
        'youtube'       => false,
        'placeholder'   => '',
        'label'         => 'Brief Description',
    );
    
    
    public $ckeditor_description     = array(
        'type'          => 'ckeditor',
        'name'          => 'ckeditor_description',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'ckeditor_description',
        'required'      => false,
        'no_html'      => false,
        'filemanager'   => false,
        'youtube'       => false,
        'placeholder'   => '',
        'label'         => 'Description',
    );
    
    
    public $address         = array(
        'type'          => 'ckeditor',
        'name'          => 'address',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'address',
        'required'      => true,
        'youtube'       => false,
        'filemanager'   => false,
        'maxlength'     => 250,
        'placeholder'   => '',
        'label'         => 'Company Address'
    );
    
    public $content_2 = array(
        'type'          => 'ckeditor',
        'name'          => 'content_2',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'content_2',
        'required'      => false,
        'placeholder'   => 'Content',
        'label'         => '2nd Content',
    );
    
    public $content_req_false_2= array(
        'type'          => 'ckeditor',
        'name'          => 'content_req_false_2',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'content_req_false_2',
        'required'      => false,
        'placeholder'   => 'Content',
        'label'         => 'Content 2',
    );
    
    public $description_req_false= array(
        'type'          => 'ckeditor',
        'name'          => 'description_req_false',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'description_req_false',
        'required'      => false,
        'no_html'      => false,
        'filemanager'   => false,
        'youtube'       => false,
        'placeholder'   => '',
        'label'         => 'Description',
    );
    
    public $text_description_req_false_2= array(
        'type'          => 'textarea',
        'name'          => 'text_description_req_false_2',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'text_description_req_false_2',
        'required'      => false,
        'maxlength'     => 500,
        'placeholder'   => '',
        'label'         => 'Description 2'
    );
    
    public $icon    = array(
        'type'          => 'filemanager',
        'name'          => 'icon',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'icon',
        'accept'        => 'jpg,gif,png,jpeg,webp',
        'max_size'      => '5',
        'required'      => true,
        'label'         => 'Icon'
    );
    
    public $icon_2    = array(
        'type'          => 'filemanager',
        'name'          => 'icon_2',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'icon_2',
        'accept'        => 'jpg,gif,png,jpeg,webp',
        'max_size'      => '5',
        'required'      => true,
        'label'         => 'Icon 2'
    );
    
    public $content_web         = array(
        'type'          => 'ckeditor',
        'name'          => 'content_web',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'content_web',
        'required'      => true,
        'placeholder'   => 'HTML Codes Here...',
        'label'         => 'Content(Web)'
    );
    
    public $content_mobile         = array(
        'type'          => 'ckeditor',
        'name'          => 'content_mobile',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'content_mobile',
        'required'      => false,
        'placeholder'   => 'HTML Codes Here...',
        'label'         => 'Content(Mobile)'
    );
    
    public $css_file= array(
        'type'          => 'filemanager',
        'name'          => 'css_file',
        'form-align'    => 'horizontal',
        'class'         => 'form-control prod_info_img_inputs',
        'id'            => 'css_file',
        'accept'        => 'css',
        'max_size'      => '5',
        'required'      => true,
        'placeholder'   => '',
        'label'         => 'Additional CSS',
        
    );
    
    public $image_background_web= array(
        'type'          => 'filemanager',
        'name'          => 'image_background_web',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'image_background_web',
        'accept'        => 'jpg,gif,png,jpeg,webp',
        'max_size'      => '5',
        'required'      => true,
        'label'         => 'Background Image (Web)',
    );
    
    public $image_background_web_2= array(
        'type'          => 'filemanager',
        'name'          => 'image_background_web_2',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'image_background_web_2',
        'accept'        => 'jpg,gif,png,jpeg,webp',
        'max_size'      => '5',
        'required'      => true,
        'label'         => 'Background Image (Web) 2',
    );
    
    public $image_background_mobile= array(
        'type'          => 'filemanager',
        'name'          => 'image_background_mobile',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'image_background_mobile',
        'accept'        => 'jpg,gif,png,jpeg,webp',
        'max_size'      => '5',
        'required'      => true,
        'label'         => 'Background Image (Mobile)',
    );
    
    public $image_background_mobile_2= array(
        'type'          => 'filemanager',
        'name'          => 'image_background_mobile_2',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'image_background_mobile_2',
        'accept'        => 'jpg,gif,png,jpeg,webp',
        'max_size'      => '5',
        'required'      => true,
        'label'         => 'Background Image (Mobile) 2',
    );
    
    public $target_customer_title      = array(
        'type'          => 'text',
        'name'          => 'title',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'title',
        'maxlength'     => 50,
        'required'      => true,
        'placeholder'   => '',
        'label'         => 'Title',
    );
    
    public $adverse_title      = array(
        'type'          => 'text',
        'name'          => 'adverse_title',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'adverse_title',
        'maxlength'     => 50,
        'required'      => true,
        'placeholder'   => '',
        'label'         => 'Title',
    );
    
    public $target_customer_description     = array( // jeb
        'type'          => 'ckeditor',
        'name'          => 'description',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'description',
        'required'      => false,
        'no_html'      => false,
        'label'         => 'Description',
        'maxlength'     => 500
    );
    
    public $target_customer_content = array(
        'type'          => 'ckeditor',
        'name'          => 'content',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'content',
        'required'      => false,
        'placeholder'   => '',
        'label'         => 'Content'
    );
    
    public $target_customer_icon = array(
        'type'          => 'filemanager',
        'name'          => 'icon',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'icon',
        'accept'        => 'jpg,png,jpeg,webp',
        'max_size'      => '5',
        'required'      => true,
        'label'         => 'Icon',
    );
    
    public $target_customer_section_description      = array(
        'type'          => 'textarea',
        'name'          => 'description',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'description',
        'maxlength'     => 500,
        'placeholder'   => '',
        'label'         => 'Description',
        'required'      => false
    );
    
    public $pil_link= array(
        'type'          => 'filemanager',
        'name'          => 'pil_link',
        'form-align'    => 'horizontal',
        'class'         => 'form-control product_info_inputs',
        'id'            => 'pil_link',
        'accept'        => 'pdf',
        'max_size'      => '20',
        'required'      => false,
        'placeholder'   => '',
        'label'         => 'PIL Link',   
    );
    
    public $site_layout= array(
        'type'          => 'dropdown',
        'name'          => 'site_layout',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'site_layout',
        'required'      => true,
        'label'         => 'Layout',
        'list_value'    => array(
                            0   => 'Corporate Layout',
                            1   => 'Brand Layout'
        ),
    );
    
    public $page_title= array(
        'type'          => 'dropdown',
        'name'          => 'page_title',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'page_title',
        'required'      => true,
        'label'         => 'Page Title',
        'list_value'    => array('0' => 'Select')
    );
    
    public $page_desktop_layout= array(
        'type'          => 'dropdown',
        'name'          => 'page_desktop_layout',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'page_desktop_layout',
        'required'      => true,
        'label'         => 'Desktop Layout',
        'list_value'    => array('0' => 'Default')
    );
    
    public $page_mobile_layout= array(
        'type'          => 'dropdown',
        'name'          => 'page_mobile_layout',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'page_mobile_layout',
        'required'      => true,
        'label'         => ' Mobile Layout',
        'list_value'    => array('0' => 'Default')
    );
    
    public $page_additional_css= array(
        'type'          => 'dropdown',
        'name'          => 'page_additional_css',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'page_additional_css',
        'required'      => true,
        'label'         => ' Additional CSS',
        'list_value'    => array('0' => 'Default')
    );
    
    public $display_name            = array(
        'type'          => 'text',
        'name'          => 'display_name',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'display_name',
        'maxlength'     => 100,
        'required'      => true,
        'placeholder'   => '',
        'label'         => 'Display Name'
    );
    
    public $adverse_description      = array(
        'type'          => 'textarea',
        'name'          => 'adverse_description',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'adverse_description',
        'maxlength'     => 500,
        'required'      => false,
        'placeholder'   => '',
        'label'         => 'Description',
        
    );
    
    public $company_name            = array(
        'type'          => 'text',
        'name'          => 'company_name',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'company_name',
        'maxlength'     => 255,
        'required'      => true,
        'accept'        => '/[^a-zA-Z0-9\u00f1\u00d1 \'.,-]/g',
        'placeholder'   => '',
        'label'         => 'Company Name'
    );
    
    //FORTI-D 
    public $subtitle_req_false= array(
        'type'          => 'text',
        'name'          => 'subtitle_req_false',
        'form-align'    => 'horizontal',
        'class'         => 'form-control product_info_inputs',
        'id'            => 'subtitle_req_false',
        'required'      => false,
        'maxlength'     => 255,
        'placeholder'   => '',
        'label'         => 'Subtitle'
    );
    
    public $image_web_req_false= array(
        'type'          => 'filemanager',
        'name'          => 'image_web_req_false',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'image_web_req_false',
        'accept'        => 'jpg,png,jpeg,webp',
        'max_size'      => '5',
        'required'      => false,
        'label'         => 'Image (desktop)',
    );
    
    public $image_mobile_req_false= array(
        'type'          => 'filemanager',
        'name'          => 'image_mobile_req_false',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'image_mobile_req_false',
        'accept'        => 'jpg,png,jpeg,webp',
        'max_size'      => '5',
        'required'      => false,
        'label'         => 'Image (Mobile)',
    );
    
    public $image_desktop_req_false= array(
        'type'          => 'filemanager',
        'name'          => 'image_desktop_req_false',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'image_desktop_req_false',
        'accept'        => 'jpg,png,jpeg,webp',
        'max_size'      => '5',
        'required'      => false,
        'label'         => 'Image (Desktop)',
    );
    
    public $image_req_false          = array(
        'type'          => 'filemanager',
        'name'          => 'image_req_false',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'image_req_false',
        'accept'        => 'jpg,png,jpeg,webp',
        'max_size'      => '5',
        'required'      => false,
        'placeholder'   => 'Image',
        'label'         => 'Image', 
    );
    
    public $image_1_req_false          = array(
        'type'          => 'filemanager',
        'name'          => 'image_1_req_false',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'image_1_req_false',
        'accept'        => 'jpg,png,jpeg,webp',
        'max_size'      => '5',
        'required'      => false,
        'placeholder'   => '',
        'label'         => 'Image 1',
        
    );
    
    public $image_2_req_false          = array(
        'type'          => 'filemanager',
        'name'          => 'image_2_req_false',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'image_2_req_false',
        'accept'        => 'jpg,png,jpeg,webp',
        'max_size'      => '5',
        'required'      => false,
        'placeholder'   => '',
        'label'         => 'Image 2',
        
    );
    
    public $text_description_1_req_false= array(
        'type'          => 'textarea',
        'name'          => 'text_description_1_req_false',
        'form-align'    => 'horizontal',
        'class'         => 'form-control meta_description_input',
        'id'            => 'text_description_1_req_false',
        'required'      => false,
        'maxlength'     => 600,
        'label'         => 'Description 1'
    );
    
    public $text_description_2_req_false= array(
        'type'          => 'textarea',
        'name'          => 'text_description_2_req_false',
        'form-align'    => 'horizontal',
        'class'         => 'form-control meta_description_input',
        'id'            => 'text_description_2_req_false',
        'required'      => false,
        'maxlength'     => 500,
        'label'         => 'Description 2'
    );
    
    public $text_link_req_false      = array(
        'type'          => 'text',
        'name'          => 'text_link_req_false',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'text_link_req_false',
        'required'      => false,
        'label'         => 'Link',
    );
    
    public $media_file_upload_req_false   = array(
        'type'          => 'filemanager',
        'name'          => 'media_file_upload_req_false',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'media_file_upload_req_false',
        'accept'        => 'jpg,gif,png,jpeg,webp,mkv,mov,mp4,ogv,webm,ogg,flac,wav',
        'max_size'      => '50',
        'required'      => false,
        'label'         => 'Media',
    ); 
    
    public $the_vital_vitamin_description_ckeditor= array(
        'type'          => 'ckeditor',
        'name'          => 'the_vital_vitamin_description_ckeditor',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'the_vital_vitamin_description_ckeditor',
        'required'      => false,
        'required'      => false,
        'filemanager'   => false,
        'youtube'       => false,
        'label'         => 'Description',
    );
    
    //FORTI-D end
    public $media_video_file_upload_req_false   = array(
        'type'          => 'filemanager',
        'name'          => 'media_video_file_upload_req_false',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'media_video_file_upload_req_false',
        'accept'        => 'mkv,mov,mp4,ogv,webm',
        'youtube'       => false,
        'max_size'      => '50',
        'required'      => false,
        'label'         => 'Media'
    );
    //About Solmux fields
    
    public $media= array(
        'type'          => 'filemanager',
        'name'          => 'media',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'media',
        'accept'        => 'mp4,mov,jpg,gif,png,jpeg,webp',
        'max_size'      => '50',
        'required'      => true,
        'placeholder'   => '',
        'label'         => 'Media'
    );
    
    //Neozep
    public $media_type_mabilis= array( 
        'type'          => 'dropdown',
        'name'          => 'media_type_mabilis',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'media_type_mabilis',
        'required'      => true,
        'label'         => 'Media Type',
        'list_value'    => array(
                            '0'  => 'Upload Media',
                            '1'  => 'Youtube',
                        )
    );
    
    public $description_req_false_text= array(
        'type'          => 'textarea',
        'name'          => 'description_req_false_text',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'description_req_false_text',
        'maxlength'     => 500,
        'required'      => false,
        'no_html'      => false,
        'filemanager'   => false,
        'youtube'       => false,   
        'placeholder'   => '',
        'label'         => 'Description',
    );
    
    public $survey_link_req= array(
        'type'          => 'text',
        'name'          => 'survey_link_req',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'survey_link_req',
        'required'      => true,
        'placeholder'   => '',
        'label'         => 'Survey Link'
    );
    
    //Decolgen
    public $tagline   = array(
        'type'          => 'text',
        'name'          => 'tagline',
        'form-align'    => 'horizontal',
        'class'         => 'form-control product_info_inputs',
        'id'            => 'tagline',
        'required'      => false,
        'maxlength'     => 255,
        'placeholder'   => '',
        'label'         => 'Tagline'
    );
    
    public $generic_name_false_decolgen   = array(
        'type'          => 'ckeditor',
        'name'          => 'generic_name_false_decolgen',
        'form-align'    => 'horizontal',
        'class'         => 'form-control product_info_inputs',
        'id'            => 'generic_name_false_decolgen',
        'required'      => false,
        'placeholder'   => '',
        'label'         => 'Generic Name'
    );
    
    public $product_name_false   = array(
        'type'          => 'text',
        'name'          => 'product_name_false',
        'form-align'    => 'horizontal',
        'class'         => 'form-control product_info_inputs',
        'id'            => 'product_name_false',
        'required'      => false,
        'maxlength'     => 255,
        'placeholder'   => '',
        'label'         => 'Product Name'
    );
    
    public $symptoms_persist   = array(
        'type'          => 'text',
        'name'          => 'symptoms_persist',
        'form-align'    => 'horizontal',
        'class'         => 'form-control product_info_inputs',
        'id'            => 'symptoms_persist',
        'required'      => false,
        'maxlength'     => 255,
        'placeholder'   => '',
        'label'         => 'Symptoms Persist'
    );
    
    public $time_decolgen   = array(
        'type'          => 'text',
        'name'          => 'time_decolgen',
        'form-align'    => 'horizontal',
        'class'         => 'form-control product_info_inputs',
        'id'            => 'time_decolgen',
        'required'      => false,
        'maxlength'     => 255,
        'placeholder'   => '',
        'label'         => 'Time'
    );
    
    public $content_false = array(
        'type'          => 'ckeditor',
        'name'          => 'content_false',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'content_false',
        'required'      => false,
        'placeholder'   => '',
        'label'         => 'Content'
    );
    
    public $image_decolgen          = array(
        'type'          => 'filemanager',
        'name'          => 'image_decolgen',
        'form-align'    => 'horizontal',
        'class'         => 'form-control prod_info_img_inputs',
        'id'            => 'image_decolgen',
        'accept'        => 'jpg,png,jpeg,webp',
        'max_size'      => '5',
        'required'      => false,
        'label'         => 'Decolgen Image',
    );
    
    public $icon_decolgen    = array(
        'type'          => 'filemanager',
        'name'          => 'icon_decolgen',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'icon_decolgen',
        'accept'        => 'jpg,png,jpeg,webp',
        'max_size'      => '5',
        'required'      => false,
        'label'         => 'Icon'
    );
    
    public $decolgen_content= array(
        'type'          => 'textarea',
        'name'          => 'decolgen_content',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'decolgen_content',
        'maxlength'     => 500,
        'required'      => false,
        'no_html'      => false,
        'filemanager'   => false,
        'youtube'       => false,
        'placeholder'   => '',
        'label'         => 'Decolgen Content',
    );
    
    public $competitor_image          = array(
        'type'          => 'filemanager',
        'name'          => 'competitor_image',
        'form-align'    => 'horizontal',
        'class'         => 'form-control prod_info_img_inputs',
        'id'            => 'competitor_image',
        'accept'        => 'jpg,png,jpeg,webp',
        'max_size'      => '5',
        'required'      => false,
        'label'         => 'Competitor Image',
    );
    
    public $competitor_content= array(
        'type'          => 'textarea',
        'name'          => 'competitor_content',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'competitor_content',
        'maxlength'     => 500,
        'required'      => false,
        'no_html'       => false,
        'filemanager'   => false,
        'youtube'       => false,
        'placeholder'   => '',
        'label'         => 'Competitor Content',
    );
    
    public $content_text_false         = array(
        'type'          => 'ckeditor',
        'name'          => 'content_text_false',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'content_text_false',
        'required'      => false,
        'youtube'       => false,
        'filemanager'   => false,
        'placeholder'   => '',
        'label'         => 'Content',
        
    );
    
    public $pil_link_decolgen= array(
        'type'          => 'text',
        'name'          => 'pil_link_decolgen',
        'form-align'    => 'horizontal',
        'class'         => 'form-control product_info_inputs',
        'id'            => 'pil_link_decolgen',
        'accept'        => 'pdf',
        'maxlength'     => 255,
        'required'      => true,
        'placeholder'   => '',
        'label'         => 'PIL Button Label',   
    );
    
    public $page_url             = array(
        'type'          => 'text',
        'name'          => 'url',
        'form-align'    => 'horizontal',
        'class'         => 'form-control product_info_inputs',
        'id'            => 'url',
        'maxlength'     => 100,
        'required'      => false,
        'placeholder'   => 'Leave blank if About and Faq page title is selected',
        'label'         => 'URL'
    );
    
    public $icon_req_false    = array(
        'type'          => 'filemanager',
        'name'          => 'icon_req_false',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'icon_req_false',
        'accept'        => 'jpg,gif,png,jpeg,webp',
        'max_size'      => '5',
        'required'      => false,
        'label'         => 'Icon'
    );
    
    public $text_media_req_false= array(
        'type'          => 'dropdown',
        'name'          => 'text_media_req_false',
        'form-align'    => 'horizontal',
        'class'         => 'form-control video_type',
        'id'            => 'text_media_req_false',
        'required'      => false,
        'placeholder'   => 'Media Type',
        'label'         => 'Media Type',
        'list_value'    => array(
                            '-1'     => '',
                            '0'     => 'Upload File',
                            '1'     => 'Youtube Video'
                        ),              
    );
    
    public $media_req_false    = array(
        'type'          => 'filemanager',
        'name'          => 'media_req_false',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'media_req_false',
        'accept'        => 'jpg,gif,png,jpeg,webp',
        'max_size'      => '5',
        'required'      => false,
        'label'         => 'Media'
    );
    
    public $tag_name_req_false      = array(
        'type'          => 'text',
        'name'          => 'tag_name_req_false',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'tag_name_req_false',
        'maxlength'     => 255,
        'required'      => false,
        'placeholder'   => '',
        'label'         => 'Tag Name',
    );
    
    public $featured_article        = array(
        'type'          => 'dropdown',
        'name'          => 'featured_article',
        'form-align'    => 'horizontal',
        'class'         => 'form-control featured_article',
        'id'            => 'featured_article',
        'required'      => true,
        'placeholder'   => '',
        'label'         => 'Featured Article',
        'list_value'    => array(
                            '1'     => 'Yes',
                            '0'     => 'No'
                        )
    );
    
    public $featured        = array(
        'type'          => 'dropdown',
        'name'          => 'featured',
        'form-align'    => 'horizontal',
        'class'         => 'form-control featured',
        'id'            => 'featured',
        'required'      => false,
        'placeholder'   => '',
        'label'         => 'Featured',
        'list_value'    => array(
                            '0'     => 'No',
                            '1'     => 'Yes'
                        )
    );
    
    public $featured_order        = array(
        'type'          => 'text',
        'name'          => 'featured_order',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'featured_order',
        'accept'        => '/[^[0-9]*$]/g',
        'required'      => false,
        'label'         => 'Featured Order'
    );
    
    public $reference_url             = array(
        'type'          => 'text',
        'name'          => 'reference_url',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'reference_url',
        'maxlength'     => 255,
        'required'      => false,
        'placeholder'   => 'Url Reference',
        'label'         => 'Url Reference'
    );
    
    public $advocacy_title= array(
        'type'          => 'text',
        'name'          => 'advocacy_title',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'advocacy_title',
        'required'      => true,
        'maxlength'     => 255,
        'placeholder'   => '',
        'label'         => 'Title'
    );
    
    public $advocacy_subtitle= array(
        'type'          => 'text',
        'name'          => 'advocacy_subtitle',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'advocacy_subtitle',
        'required'      => false,
        'maxlength'    => 255,
        'placeholder'   => '',
        'label'         => 'Sutbtitle'
    );
    
    public $advocacy_description= array(
        'type'          => 'textarea',
        'name'          => 'advocacy_description',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'advocacy_description',
        'required'      => false,
        'maxlength'     => 500,
        'label'         => 'Description'
    );
    
    public $advocacy_icon_desktop    = array(
        'type'          => 'filemanager',
        'name'          => 'advocacy_icon_desktop',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'advocacy_icon_desktop',
        'accept'        => 'jpg,gif,png,jpeg,webp',
        'max_size'      => '5',
        'required'      => false,
        'label'         => 'Icon (desktop)'
    );
    
    public $advocacy_icon_mobile    = array(
        'type'          => 'filemanager',
        'name'          => 'advocacy_icon_mobile',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'advocacy_icon_mobile',
        'accept'        => 'jpg,gif,png,jpeg,webp',
        'max_size'      => '5',
        'required'      => false,
        'label'         => 'Icon (mobile)'
    );
    
    public $advocacy_icon    = array(
        'type'          => 'filemanager',
        'name'          => 'advocacy_icon',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'advocacy_icon',
        'accept'        => 'jpg,gif,png,jpeg,webp',
        'max_size'      => '5',
        'required'      => false,
        'label'         => 'Icon'
    );
    
    public $advocacy_image_desktop    = array(
        'type'          => 'filemanager',
        'name'          => 'advocacy_image_desktop',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'advocacy_image_desktop',
        'accept'        => 'jpg,gif,png,jpeg,webp',
        'max_size'      => '5',
        'required'      => false,
        'label'         => 'Image (desktop)'
    );
    
    public $advocacy_image_mobile    = array(
        'type'          => 'filemanager',
        'name'          => 'advocacy_image_mobile',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'advocacy_image_mobile',
        'accept'        => 'jpg,gif,png,jpeg,webp',
        'max_size'      => '5',
        'required'      => false,
        'label'         => 'Image (mobile)'
    );
    
    public $advocacy_content         = array(
        'type'          => 'ckeditor',
        'name'          => 'advocacy_content',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'advocacy_content',
        'required'      => false,
        'placeholder'   => 'Content',
        'label'         => 'Content',
    
    );
    
    public $advocacy_slideshow_table          = array(
        'type'          => 'table',
        'name'          => 'advocacy_slideshow_table',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'advocacy_slideshow_table',
        'label'         => 'Gallery',
        'table-headers' => ["Image"]
    );
    
    public $advocacy_related_program_table          = array(
        'type'          => 'table',
        'name'          => 'advocacy_related_program_table',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'advocacy_related_program_table',
        'label'         => 'Related Program',
        'table-headers' => ["Title"]
    );
    
    public $related_program_title= array(
        'type'          => 'text',
        'name'          => 'related_program_title',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'related_program_title',
        'required'      => true,
        'maxlength'     => 255,
        'placeholder'   => '',
        'label'         => 'Title'
    );
    
    public $related_program_subtitle= array(
        'type'          => 'text',
        'name'          => 'related_program_subtitle',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'related_program_subtitle',
        'required'      => false,
        'maxlength'     => 255,
        'placeholder'   => '',
        'label'         => 'Sutbtitle'
    );
    
    public $related_program_description= array(
        'type'          => 'textarea',
        'name'          => 'related_program_description',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'related_program_description',
        'required'      => false,
        'maxlength'     => 500,
        'label'         => 'Description'
    );
    
    public $related_program_image_desktop    = array(
        'type'          => 'filemanager',
        'name'          => 'related_program_image_desktop',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'related_program_image_desktop',
        'accept'        => 'jpg,gif,png,jpeg,webp',
        'max_size'      => '5',
        'required'      => false,
        'label'         => 'Image (desktop)'
    );
    
    public $related_program_image_mobile    = array(
        'type'          => 'filemanager',
        'name'          => 'related_program_image_mobile',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'related_program_image_mobile',
        'accept'        => 'jpg,gif,png,jpeg,webp',
        'max_size'      => '5',
        'required'      => false,
        'label'         => 'Image (mobile)'
    );
    
    public $related_program_content         = array(
        'type'          => 'ckeditor',
        'name'          => 'related_program_content',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'related_program_content',
        'required'      => false,
        'placeholder'   => 'Content',
        'label'         => 'Content',
    
    );
    
    public $product_banner_status = array(
        'type'          => 'dropdown',
        'name'          => 'product_banner_status',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'product_banner_status',
        'required'      => false,
        'label'         => 'Inherit Banner from Product',
        'list_value'    => array(
                            '0'  => 'No',
                            '1'  => 'Yes',
                        )
    );
    
    public $image_web_not_required= array(
        'type'          => 'filemanager',
        'name'          => 'image_web',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'image_web',
        'accept'        => 'jpg,gif,png,jpeg,webp',
        'max_size'      => '5',
        'required'      => false,
        'label'         => 'Image (Web)',
    );
    
    public $image_mobile_not_required= array(
        'type'          => 'filemanager',
        'name'          => 'image_mobile',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'image_mobile',
        'accept'        => 'jpg,gif,png,jpeg,webp',
        'max_size'      => '5',
        'required'      => false,
        'label'         => 'Image (Mobile)',
    );
    
    public $title_maxlength      = array(
        'type'          => 'text',
        'name'          => 'title_maxlength',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'title_maxlength',
        'maxlength'     => 50,
        'required'      => true,
        'placeholder'   => '',
        'label'         => 'Title',
        'display'       => 1,
        'is_list'       => 1,
        'alignment'     => 1
    );     
    
    public $image_thumbnail_req_false         = array(
        'type'          => 'filemanager',
        'name'          => 'image_thumbnail_req_false',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'image_thumbnail_req_false',
        'accept'        => 'jpg,gif,png,jpeg,webp',
        'max_size'      => '5',
        'required'      => false,
        'placeholder'   => '',
        'label'         => 'Image Thumbnail',
    );
    
    public $advocacy_video_type= array(
        'type'          => 'dropdown',
        'name'          => 'advocacy_video_type',
        'form-align'    => 'horizontal',
        'class'         => 'form-control advocacy_video_type',
        'id'            => 'advocacy_video_type',
        'required'      => false,
        'placeholder'   => 'Video Type',
        'label'         => 'Video Type',
        'list_value'    => array(
                            ''     => '',
                            '0'     => 'Upload Video',
                            '1'     => 'Youtube Video'
                        ),              
    );
    
    public $twitter_url= array(
        'type'          => 'text',
        'name'          => 'twitter_url',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'twitter_url',
        'required'      => false,
        'placeholder'   => '',
        'label'         => 'Twitter URL'
    );
    
    public $facebook_url= array(
        'type'          => 'text',
        'name'          => 'facebook_url',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'facebook_url',
        'required'      => false,
        'placeholder'   => '',
        'label'         => 'Facebook URL'
    );
    
    // For Causes List and Preventions List CMS
    public $title_not_required      = array(
        'type'          => 'text',
        'name'          => 'title_not_required',
        'form-align'    => 'horizontal',
        'class'         => 'form-control title_not_required',
        'id'            => 'title_not_required',
        'maxlength'     => 255,
        'required'      => false,
        'placeholder'   => '',
        'label'         => 'Title',
        'display'       => 1,
        'is_list'       => 1,
        'alignment'     => 1
    );       
    
    public $site_route_text      = array(
        'type'          => 'text',
        'name'          => 'site_route',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'site_route_text',
        'maxlength'     => 255,
        'placeholder'   => '',
        'label'         => 'Route',
        'required'      => true,
        'display'       => 1,
        'is_list'       => 1
    );     
    
    public $site_controller_text      = array(
        'type'          => 'text',
        'name'          => 'site_controller_text',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'site_controller_text',
        'maxlength'     => 255,
        'placeholder'   => '',
        'label'         => 'Controller',
        'required'      => true,
        'display'       => 1,
        'is_list'       => 1
    ); 
    public $title_req_false= array(
        'type'          => 'text',
        'name'          => 'title_req_false',
        'form-align'    => 'horizontal',
        'class'         => 'form-control product_info_inputs',
        'id'            => 'title_req_false',
        'required'      => false,
        'maxlength'     => 255,
        'placeholder'   => '',
        'label'         => 'Title'
    );
    
    //MEdia file Upload
    public $media_type_upload= array( 
        'type'          => 'dropdown',
        'name'          => 'media_type_upload',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'media_type',
        'required'      => true,
        'label'         => 'Media Type',
        'list_value'    => array(
                            '0'  => 'Upload Media',
                            '1'  => 'Youtube',
                        )
    );
    
    public $background_image_web_req_false= array(
        'type'          => 'filemanager',
        'name'          => 'background_image_web_req_false',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'background_image_web_req_false',
        'accept'        => 'jpg,gif,png,jpeg,webp',
        'max_size'      => '5',
        'required'      => false,
        'label'         => 'Background Image (Web)',
    );
    
    public $background_image_mobile_req_false= array(
        'type'          => 'filemanager',
        'name'          => 'background_image_mobile_req_false',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'background_image_mobile_req_false',
        'accept'        => 'jpg,gif,png,jpeg,webp',
        'max_size'      => '5',
        'required'      => false,
        'label'         => 'Background Image (Mobile)',
    );
       
    public $covid_title= array(
        'type'          => 'text',
        'name'          => 'covid_title',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'covid_title',
        'required'      => true,
        'maxlength'    => 255,
        'placeholder'   => '',
        'label'         => 'Title'
    );
    
    public $covid_gallery= array(
        'type'          => 'text',
        'name'          => 'covid_gallery',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'covid_gallery',
        'required'      => false,
        'maxlength'    => 255,
        'placeholder'   => '',
        'label'         => 'Gallery Title'
    );
    
    public $covid_description= array(
        'type'          => 'textarea',
        'name'          => 'covid_description',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'covid_description',
        'required'      => false,
        'maxlength'     => 500,
        'label'         => 'Description'
    );
    
    public $covid_content         = array(
        'type'          => 'ckeditor',
        'name'          => 'covid_content',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'covid_content',
        'required'      => false,
        'placeholder'   => 'Content',
        'label'         => 'Content',
    
    );
    
    public $covid_image_desktop    = array(
        'type'          => 'filemanager',
        'name'          => 'covid_image_desktop',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'covid_image_desktop',
        'accept'        => 'jpg,png,jpeg,webp',
        'max_size'      => '5',
        'required'      => false,
        'label'         => 'Image (desktop)'
    );
    
    public $covid_image_mobile    = array(
        'type'          => 'filemanager',
        'name'          => 'covid_image_mobile',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'covid_image_mobile',
        'accept'        => 'jpg,png,jpeg,webp',
        'max_size'      => '5',
        'required'      => false,
        'label'         => 'Image (mobile)'
    );
    
    public $covid_description_gallery= array(
        'type'          => 'textarea',
        'name'          => 'covid_description',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'covid_description',
        'required'      => true,
        'maxlength'     => 500,
        'label'         => 'Description'
    );
    
    public $covid_content_gallery         = array(
        'type'          => 'ckeditor',
        'name'          => 'covid_content_gallery',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'covid_content_gallery',
        'required'      => false,
        'placeholder'   => 'Content',
        'label'         => 'Content',
    
    );
    
    public $covid_image_gallery    = array(
        'type'          => 'filemanager',
        'name'          => 'covid_image_desktop',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'covid_image_desktop',
        'accept'        => 'jpg,png,jpeg,webp',
        'max_size'      => '5',
        'required'      => false,
        'label'         => 'Image'
    );
    
    public $covid_media   = array(
        'type'          => 'filemanager',
        'name'          => 'covid_media_file_upload',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'covid_media_file_upload',
        'accept'        => 'mkv,mp4,avi',
        'max_size'      => '50',
        'required'      => false,
        'label'         => 'Media' 
    );  
    
    public $announcement_title= array(
        'type'          => 'text',
        'name'          => 'announcement_title',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'announcement_title',
        'required'      => true,
        'maxlength'    => 255,
        'placeholder'   => '',
        'label'         => 'Title'
    );
    
    public $announcement_content         = array(
        'type'          => 'ckeditor',
        'name'          => 'announcement_content',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'announcement_content',
        'required'      => false,
        'placeholder'   => 'Content',
        'label'         => 'Content',
    
    );
    
    public $announcement_subtitle= array(
        'type'          => 'text',
        'name'          => 'announcement_subtitle',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'announcement_subtitle',
        'required'      => false,
        'maxlength'    => 255,
        'placeholder'   => '',
        'label'         => 'Subtitle'
    );
    
    public $announcement_description= array(
        'type'          => 'textarea',
        'name'          => 'announcement_description',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'announcement_description',
        'required'      => false,
        'maxlength'     => 500,
        'label'         => 'Description'
    );
    
    public $announcement_image_desktop    = array(
        'type'          => 'filemanager',
        'name'          => 'announcement_image_desktop',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'announcement_image_desktop',
        'accept'        => 'jpg,gif,png,jpeg,webp',
        'max_size'      => '5',
        'required'      => false,
        'label'         => 'Image (desktop)'
    );
    
    public $announcement_image_mobile    = array(
        'type'          => 'filemanager',
        'name'          => 'announcement_image_mobile',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'announcement_image_mobile',
        'accept'        => 'jpg,gif,png,jpeg,webp',
        'max_size'      => '5',
        'required'      => false,
        'label'         => 'Image (mobile)'
    );
    
    public $announcement_title_editor      = array(
        'type'          => 'ckeditor',
        'name'          => 'announcement_title_editor',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'announcement_title_editor',
        'required'      => true,
        'maxlength'     => 255,
        'placeholder'   => '',
        'label'         => 'Title'
    );
    
    public $announcement_content_editor      = array(
        'type'          => 'ckeditor',
        'name'          => 'announcement_content_editor',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'announcement_content_editor',
        'required'      => true,
        'placeholder'   => '',
        'label'         => 'Content',
        'youtube'       => false
    );
    
    public $announcement_date       = array(
        'type'          => 'date',
        'name'          => 'announcement_date',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'required'      => true,
        'id'            => 'announcement_date',
        'minDate'       => '0',
        'placeholder'   => '',
        'label'         => 'Announcement Date'
    );
    // Social Post for Covid-19 page
    public $age_req_false       = array(
        'type'          => 'number',
        'name'          => 'age_req_false',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'age_req_false',
        'min'           => 1,
        'max'           => 999,
        'maxlength'    => 3,
        'required'      => false,
        'accept'        => '/[^[0-9]*$]/g',
        'placeholder'   => '',
        'label'         => 'Age',
    );
    
    public $post_link= array(
        'type'          => 'textarea',
        'name'          => 'post_link',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'post_link',
        'required'      => true,
        'placeholder'   => '',
        'maxlength'     => 500,
        'label'         => 'Post Link',
    );
    
    public $review_req_false= array(
        'type'          => 'textarea',
        'name'          => 'review_req_false',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'review_req_false',
        'required'      => false,
        'placeholder'   => '',
        'maxlength'     => 1000,
        'label'         => 'Review',
    );
    
    public $background_image_req_false          = array(
        'type'          => 'filemanager',
        'name'          => 'background_image_req_false',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'background_image_req_false',
        'accept'        => 'jpg,png,jpeg,webp',
        'required'      => false,
        'placeholder'   => '',
        'label'         => 'Background Image',
    );   
    
    public $stars_req_false= array(
        'type'          => 'dropdown',
        'name'          => 'stars_req_false',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'stars_req_false',
        'required'      => false,
        'label'         => 'Stars',
        'note'          => 'Maximum value is 5. Minumum value is 0.',
        'list_value'    => array(
                            '0'  => '0',
                            '1'  => '1',
                            '2'  => '2',
                            '3'  => '3',
                            '4'  => '4',
                            '5'  => '5'  
                        )
    );
    
    public $home_button_url = array(
        'type'          => 'text',
        'name'          => 'home_button_url',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'home_button_url',
        'maxlength'     => 250,
        'label'         => 'Button URL'
    );
     
    public $covid_image          = array(
        'type'          => 'filemanager',
        'name'          => 'covid_image',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'covid_image',
        'accept'        => 'jpg,png,jpeg,webp',
        'max_size'      => '5',
        'required'      => false,
        'placeholder'   => '',
        'label'         => 'Image',   
    );
    
    public $covid_thumbnail         = array(
        'type'          => 'filemanager',
        'name'          => 'covid_thumbnail',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'covid_thumbnail',
        'accept'        => 'jpg,png,jpeg,webp',
        'max_size'      => '5',
        'required'      => false,
        'placeholder'   => '',
        'label'         => 'Thumbnail',
    );
    
    public $covid_description_req= array(
        'type'          => 'textarea',
        'name'          => 'covid_description_req',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'covid_description_req',
        'required'      => true,
        'maxlength'     => 500,
        'label'         => 'Description'
    );
    
    public $pil_link_r= array(
        'type'          => 'filemanager',
        'name'          => 'pil_link_r',
        'form-align'    => 'horizontal',
        'class'         => 'form-control product_info_inputs',
        'id'            => 'pil_link_r',
        'accept'        => 'pdf',
        'max_size'      => '20',
        'required'      => true,
        'placeholder'   => '',
        'label'         => 'PIL Link',
    );
    
    public $saf_image          = array(
        'type'          => 'filemanager',
        'name'          => 'saf_image',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'saf_image',
        'accept'        => 'jpg,png,jpeg,webp',
        'max_size'      => '5',
        'required'      => false,
        'placeholder'   => '',
        'label'         => 'Image',   
    );
    
    public $symptom_comparison_title      = array(
        'type'          => 'text',
        'name'          => 'symptom_comparison_title',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'symptom_comparison_title',
        'required'      => true,
        'maxlength'     => 255,
        'placeholder'   => '',
        'label'         => 'Title'
    );
    
    public $symptom_comparison_description      = array(
        'type'          => 'textarea',
        'name'          => 'symptom_comparison_description',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'symptom_comparison_description',
        'required'      => false,
        'maxlength'     => 500,
        'placeholder'   => '',
        'label'         => 'Description'
    );
    
    public $symptom_comparison_content      = array(
        'type'          => 'ckeditor',
        'name'          => 'symptom_comparison_content',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'symptom_comparison_content',
        'required'      => false,
        'placeholder'   => '',
        'label'         => 'Content',
        'youtube'       => false
    );
    
    public $symptom_comparison_image          = array(
        'type'          => 'filemanager',
        'name'          => 'symptom_comparison_image',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'symptom_comparison_image',
        'accept'        => 'jpg,png,jpeg,webp',
        'max_size'      => '5',
        'required'      => false,
        'placeholder'   => '',
        'label'         => 'Image',   
    );
    
    public $scs_title      = array(
        'type'          => 'text',
        'name'          => 'scs_title',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'scs_title',
        'required'      => true,
        'maxlength'     => 255,
        'placeholder'   => '',
        'label'         => 'Title'
    );
    
    public $scs_subtitle      = array(
        'type'          => 'text',
        'name'          => 'scs_subtitle',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'scs_subtitle',
        'required'      => false,
        'maxlength'     => 255,
        'placeholder'   => '',
        'label'         => 'Subtitle'
    );
    
    public $scs_description      = array(
        'type'          => 'ckeditor',
        'name'          => 'scs_description',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'scs_description',
        'required'      => false,
        'maxlength'     => 500,
        'placeholder'   => '',
        'label'         => 'Description'
    );
    
    public $scs_content      = array(
        'type'          => 'ckeditor',
        'name'          => 'scs_content',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'scs_content',
        'required'      => false,
        'placeholder'   => '',
        'label'         => 'Content',
        'youtube'       => false
    );
    
    public $scs_image_desktop          = array(
        'type'          => 'filemanager',
        'name'          => 'scs_image_desktop',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'scs_image_desktop',
        'accept'        => 'jpg,png,jpeg,webp',
        'max_size'      => '5',
        'required'      => false,
        'placeholder'   => '',
        'label'         => 'Image (desktop)',   
    );
    
    public $scs_image_mobile          = array(
        'type'          => 'filemanager',
        'name'          => 'scs_image_mobile',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'scs_image_mobile',
        'accept'        => 'jpg,png,jpeg,webp',
        'max_size'      => '5',
        'required'      => false,
        'placeholder'   => '',
        'label'         => 'Image (mobile)',   
    );
    
    public $scs_bg_image_desktop          = array(
        'type'          => 'filemanager',
        'name'          => 'scs_bg_image_desktop',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'scs_bg_image_desktop',
        'accept'        => 'jpg,png,jpeg,webp',
        'max_size'      => '5',
        'required'      => false,
        'placeholder'   => '',
        'label'         => 'Background Image (desktop)',   
    );
    
    public $scs_bg_image_mobile          = array(
        'type'          => 'filemanager',
        'name'          => 'scs_bg_image_mobile',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'scs_bg_image_mobile',
        'accept'        => 'jpg,png,jpeg,webp',
        'max_size'      => '5',
        'required'      => false,
        'placeholder'   => '',
        'label'         => 'Background Image (mobile)',   
    );
    
    public $sc_title      = array(
        'type'          => 'text',
        'name'          => 'sc_title',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'sc_title',
        'required'      => true,
        'maxlength'     => 255,
        'label'         => 'Title'
    );
    
    public $sc_description= array(
        'type'          => 'textarea',
        'name'          => 'sc_description',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'sc_description',
        'required'      => false,
        'maxlength'     => 500,
        'label'         => 'Description'
    );
    
    public $sc_content         = array(
        'type'          => 'ckeditor',
        'name'          => 'sc_content',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'sc_content',
        'required'      => false,
        'placeholder'   => '',
        'label'         => 'Content',
        
    );
    
    public $sc_category          = array(
        'type'          => 'dropdown',
        'name'          => 'sc_category',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'sc_category',
        'required'      => false,
        'placeholder'   => '',
        'label'         => 'Symptom Category',
        'note'          => 'Leave blank if no Symptom Category.'
    );
    
    public $sc_image         = array(
        'type'          => 'filemanager',
        'name'          => 'sc_image',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'sc_image',
        'accept'        => 'jpg,png,jpeg,webp',
        'max_size'      => '5',
        'required'      => false,
        'label'         => 'Image',
        
    );  
    
    public $benefits_content      = array(
        'type'          => 'ckeditor',
        'name'          => 'benefits_content',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'benefits_content',
        'required'      => false,
        'placeholder'   => '',
        'label'         => 'Content',
        'youtube'       => false
    );
    
    public $social_network    = array(
        'type'          => 'dropdown',
        'name'          => 'social_network',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'social_network',
        'required'      => false,
        'placeholder'   => '',
        'label'         => 'Social Network',
        'list_value'    => array(
                            ''           => 'None',
                            'facebook'   => 'Facebook',
                            'instagram'  => 'Instagram',
                            'twitter'    => 'Twitter'
                        )                           
    );
    
    public $social_platform    = array(
        'type'          => 'dropdown',
        'name'          => 'social_platform',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'social_platform',
        'required'      => false,
        'placeholder'   => '',
        'label'         => 'Social Platform',
        'list_value'    => array(
                            ''           => 'None',
                            'facebook'   => 'Facebook',
                            'instagram'  => 'Instagram',
                            'twitter'    => 'Twitter',
                            'youtube'    => 'Youtube'
                        )                           
    );
    
    public $platform_page= array(
        'type'          => 'text',
        'name'          => 'platform_page',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'platform_page',
        'required'      => false,
        'maxlength'    => 255,
        'placeholder'   => '',
        'label'         => 'Platform Page'
    );
    
    public $social_post_title      = array(
        'type'          => 'text',
        'name'          => 'social_post_title',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'social_post_title',
        'maxlength'     => 255,
        'required'      => false,
        'placeholder'   => '',
        'label'         => 'Title',
    );
    
    public $social_post_description= array(
        'type'          => "textarea",
        'name'          => "social_post_description",
        'form-align'    => "horizontal",
        'class'         => "social_post_description form-control",
        'id'            => "social_post_description",
        'required'      => false,
        'maxlength'     => 500,
        'placeholder'   => "",
        'label'         => "Description"
    );
    public $social_post_image          = array(
        'type'          => 'filemanager',
        'name'          => 'social_post_image',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'social_post_image',
        'accept'        => 'jpg,png,jpeg,webp',
        'max_size'      => '5',
        'required'      => true,
        'placeholder'   => '',
        'label'         => 'Image', 
    );        
    
    public $covid_slideshow_table          = array(
        'type'          => 'table',
        'name'          => 'covid_slideshow_table',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'covid_slideshow_table',
        'label'         => 'Gallery',
        'table-headers' => ["Image"]
    );
    
    
    public $covid_youtube_link      = array(
        'type'          => 'text',
        'name'          => 'covid_youtube_link',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'covid_youtube_link',
        'required'      => false,
        'placeholder'   => '',
        'label'         => 'Youtube Link'
    );
    
    public $first_learn_more_button_text = array(
        'type'          => 'text',
        'name'          => 'first_learn_more_button_text',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'first_learn_more_button_text',
        'maxlength'     => 255,
        'label'         => 'Learn More 1 Button Label'
    );
    
    public $first_learn_more_button_url = array(
        'type'          => 'text',
        'name'          => 'first_learn_more_button_url',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'first_learn_more_button_url',
        'maxlength'     => 255,
        'label'         => 'Learn More 1 Link'
    );
    
    public $second_learn_more_button_text = array(
        'type'          => 'text',
        'name'          => 'second_learn_more_button_text',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'second_learn_more_button_text',
        'maxlength'     => 255,
        'label'         => 'Learn More 2 Button Label'
    );
    
    public $second_learn_more_button_url = array(
        'type'          => 'text',
        'name'          => 'second_learn_more_button_url',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'second_learn_more_button_url',
        'maxlength'     => 255,
        'label'         => 'Learn More 2 Link'
    );
    
    // === START OF PROMO SECTION FIELDS ===
    public $promo_section_title= array(
        'type'          => 'text',
        'name'          => 'promo_section_title',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'promo_section_title',
        'maxlength'     => 255,
        'required'      => true,
        'placeholder'   => '',
        'label'         => 'Title'
    );    
    
    public $promo_section_subtitle= array(
        'type'          => 'text',
        'name'          => 'promo_section_subtitle',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'promo_section_subtitle',
        'maxlength'     => 255,
        'required'      => false,
        'placeholder'   => '',
        'label'         => 'Subtitle'
    );
    
    public $promo_section_description= array(
        'type'          => 'textarea',
        'name'          => 'promo_section_description',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'promo_section_description',
        'maxlength'     => 500,
        'required'      => false,
        'placeholder'   => '',
        'label'         => 'Description'
    );
    
    public $promo_section_content= array(
        'type'          => 'ckeditor',
        'name'          => 'promo_section_content',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'promo_section_content',
        'required'      => false,
        'youtube'       => false,
        'placeholder'   => '',
        'label'         => 'Content'
    );
    
    public $promo_section_logo_image= array(
        'type'          => 'filemanager',
        'name'          => 'promo_section_logo_image',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'promo_section_logo_image',
        'accept'        => 'jpg,jpeg,png,webp',
        'max_size'      => '5',
        'required'      => false,
        'placeholder'   => '',
        'label'         => 'Logo Image'
    );    
    
    public $promo_section_product_image= array(
        'type'          => 'filemanager',
        'name'          => 'promo_section_product_image',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'promo_section_product_image',
        'accept'        => 'jpg,jpeg,png,webp',
        'max_size'      => '5',
        'required'      => false,
        'placeholder'   => '',
        'label'         => 'Product Image'
    );  
    
    public $promo_section_icon_image= array(
        'type'          => 'filemanager',
        'name'          => 'promo_section_icon_image',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'promo_section_icon_image',
        'accept'        => 'jpg,jpeg,png,webp',
        'max_size'      => '5',
        'required'      => false,
        'placeholder'   => '',
        'label'         => 'Icon Image'
    );   
    
    public $promo_section_background_image= array(
        'type'          => 'filemanager',
        'name'          => 'promo_section_background_image',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'promo_section_background_image',
        'accept'        => 'jpg,jpeg,png,webp',
        'max_size'      => '5',
        'required'      => false,
        'placeholder'   => '',
        'label'         => 'Background Image'
    );
    
    public $promo_section_button_label= array(
        'type'          => 'text',
        'name'          => 'promo_section_button_label',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'promo_section_button_label',
        'maxlength'     => 50,
        'required'      => false,
        'placeholder'   => '',
        'label'         => 'Button Label'
    );
    
    public $promo_section_button_url= array(
        'type'          => 'text',
        'name'          => 'promo_section_button_url',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'promo_section_button_url',
        'maxlength'     => 255,
        'required'      => false,
        'placeholder'   => '',
        'label'         => 'Button URL'
    );
    
    public $promo_section_button_url_behavior= array(
        'type'          => 'dropdown',
        'name'          => 'promo_section_button_url_behavior',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'promo_section_button_url_behavior',
        'required'      => true,
        'placeholder'   => '',
        'label'         => 'Button URL Behavior',
        'list_value'    => array(
                            '0'   => 'Same Tab',
                            '1'   => 'New Tab',
                            '2'   => 'Pop-up'
                        )                           
    );
    // === END OF PROMO SECTION FIELDS ===
    
    // === START OF PROMO BARCODE FIELDS ===
    public $promo_barcode_is_default= array(
        'type'          => 'dropdown',
        'name'          => 'promo_barcode_is_default',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'promo_barcode_is_default',
        'required'      => true,
        'placeholder'   => '',
        'label'         => 'Set as default',
        'list_value'    => array(
                            '0'   => 'No',
                            '1'   => 'Yes',
                            '2'   => 'WTB',
                        )
    );
    
    public $promo_barcode_title= array(
        'type'          => 'text',
        'name'          => 'promo_barcode_title',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'promo_barcode_title',
        'maxlength'     => 150,
        'required'      => true,
        'placeholder'   => '',
        'label'         => 'Title'
    );   
    
    public $promo_barcode_source= array(
        'type'          => 'text',
        'name'          => 'promo_barcode_source',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'promo_barcode_source',
        'maxlength'     => 150,
        'required'      => true,
        'placeholder'   => '',
        'label'         => 'Source'
    );   
    
    public $promo_barcode_media= array(
        'type'          => 'text',
        'name'          => 'promo_barcode_media',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'promo_barcode_media',
        'maxlength'     => 150,
        'required'      => true,
        'placeholder'   => '',
        'label'         => 'Media'
    );  
    
    public $promo_barcode_subbrand= array(
        'type'          => 'text',
        'name'          => 'promo_barcode_subbrand',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'promo_barcode_subbrand',
        'maxlength'     => 150,
        'required'      => true,
        'placeholder'   => '',
        'label'         => 'Sub Brand'
    );  
    
    public $promo_barcode_image= array(
        'type'          => 'filemanager',
        'name'          => 'promo_barcode_image',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'promo_barcode_image',
        'accept'        => 'jpg,jpeg,png,webp',
        'max_size'      => '5',
        'required'      => true,
        'note'          => 'Required image size is 630x464.',
        'placeholder'   => '',
        'label'         => 'Barcode'
        
    );
    
    public $promo_barcode_content_id= array(
        'type'          => 'dropdown',
        'name'          => 'promo_barcode_content_id',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'promo_barcode_content_id',
        'required'      => true,
        'placeholder'   => '',
        'label'         => 'Promo Content',
        'list_value'    => array()
    );
    
    public $promo_barcode_period_from= array(
        'type'          => 'date',
        'name'          => 'promo_barcode_period_from',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'promo_barcode_period_from',
        'minDate'       => '0',
        'placeholder'   => 'Promo Period From',
        'label'         => 'Promo Period From',
        'note'          => 'Leave blank if no promo period.'
    );
    
    public $promo_barcode_period_to= array(
        'type'          => 'date',
        'name'          => 'promo_barcode_period_to',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'promo_barcode_period_to',
        'minDate'       => '0',
        'placeholder'   => 'Promo Period To',
        'label'         => 'Promo Period To',
        'note'          => 'Leave blank if no promo period.'
    );
    // === END OF PROMO BARCODE FIELDS ===
    
    // === START OF PROMO LIST FIELDS ===
    public $promo_list_title= array(
        'type'          => 'text',
        'name'          => 'promo_list_title',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'promo_list_title',
        'maxlength'     => 150,
        'required'      => false,
        'placeholder'   => '',
        'label'         => 'Title'
    );
    
    public $promo_list_subtitle= array(
        'type'          => 'text',
        'name'          => 'promo_list_subtitle',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'promo_list_subtitle',
        'maxlength'     => 255,
        'required'      => false,
        'placeholder'   => '',
        'label'         => 'Subtitle'
    );
    
    public $promo_list_description= array(
        'type'          => 'ckeditor',
        'name'          => 'promo_list_description',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'promo_list_description',
        'required'      => false,
        'youtube'       => false,
        'placeholder'   => '',
        'label'         => 'Description'
    );
    
    public $promo_list_content= array(
        'type'          => 'ckeditor',
        'name'          => 'promo_list_content',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'promo_list_content',
        'required'      => false,
        'youtube'       => false,
        'placeholder'   => '',
        'label'         => 'Content'
    );
    
    public $promo_list_content_link= array(
        'type'          => 'text',
        'name'          => 'promo_list_content_link',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'promo_list_content_link',
        'required'      => false,
        'placeholder'   => '',
        'label'         => 'Content Link'
    );
    
    public $promo_list_strip_title= array(
        'type'          => 'text',
        'name'          => 'promo_list_strip_title',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'promo_list_strip_title',
        'maxlength'     => 150,
        'required'      => false,
        'placeholder'   => '',
        'label'         => 'Strip Title'
    );
    
    public $promo_list_strip_description= array(
        'type'          => 'ckeditor',
        'name'          => 'promo_list_strip_description',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'promo_list_strip_description',
        'required'      => false,
        'youtube'       => false,
        'placeholder'   => '',
        'label'         => 'Strip Description'
    );
    
    // === END OF PROMO LIST FIELDS ===
    
    public $appier_product_id= array(
        'type'          => 'text',
        'name'          => 'appier_product_id',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'appier_product_id',
        'label'         => 'Product ID'
    );
    
    public $article_signup_ad= array(
        'type'          => 'filemanager',
        'name'          => 'article_signup_ad',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'article_signup_ad',
        'accept'        => 'jpg,png,jpeg,webp,gif',
        'max_size'      => '5',
        'required'      => false,
        'label'         => 'Signup Ad',    
    );
    
    
    public $article_signup_ad_url = array(
        'type'          => 'text',
        'name'          => 'article_signup_ad_url',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'article_signup_ad_url',
        'maxlength'     => 255,
        'label'         => 'Article Signup Ad URL'
    );
    
    
    public $article_signup_ad_behavior= array(
        'type'          => 'dropdown',
        'name'          => 'article_signup_ad_behavior',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'article_signup_ad_behavior',
        'required'      => false,
        'placeholder'   => '',
        'label'         => 'Signup Ad Behavior',
        'list_value'    => array(
                            '0' => 'New Tab',
                            '1' => 'Same Tab',
                            '2' => 'Popup'
                        )                           
    );
    
    
    public $pc_signup_ad= array(
        'type'          => 'filemanager',
        'name'          => 'pc_signup_ad',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'pc_signup_ad',
        'accept'        => 'jpg,png,jpeg,webp,gif',
        'max_size'      => '5',
        'required'      => false,
        'label'         => 'Product Category Signup Ad',    
    );
    
    
    public $pc_signup_ad_url = array(
        'type'          => 'text',
        'name'          => 'pc_signup_ad_url',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'pc_signup_ad_url',
        'maxlength'     => 255,
        'label'         => 'Product Category Signup Ad URL'
    );
    
    
    public $pc_signup_ad_behavior= array(
        'type'          => 'dropdown',
        'name'          => 'pc_signup_ad_behavior',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'pc_signup_ad_behavior',
        'required'      => false,
        'placeholder'   => '',
        'label'         => 'Product Category Signup Ad Behavior',
        'list_value'    => array(
                            '0' => 'New Tab',
                            '1' => 'Same Tab',
                            '2' => 'Popup'
                        )                           
    );
    
    
    public $pv_signup_ad= array(
        'type'          => 'filemanager',
        'name'          => 'pv_signup_ad',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'pv_signup_ad',
        'accept'        => 'jpg,png,jpeg,webp,gif',
        'max_size'      => '5',
        'required'      => false,
        'label'         => 'Product Variant Signup Ad',    
    );
    
    
    public $pv_signup_ad_url = array(
        'type'          => 'text',
        'name'          => 'pv_signup_ad_url',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'pv_signup_ad_url',
        'maxlength'     => 255,
        'label'         => 'Product Variant Signup Ad URL'
    );
    
    
    public $pv_signup_ad_behavior= array(
        'type'          => 'dropdown',
        'name'          => 'pv_signup_ad_behavior',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'pv_signup_ad_behavior',
        'required'      => false,
        'placeholder'   => '',
        'label'         => 'Product Variant Signup Ad Behavior',
        'list_value'    => array(
                            '0' => 'New Tab',
                            '1' => 'Same Tab',
                            '2' => 'Popup'
                        )                           
    );
    
    
    public $sua_title = array(
        'type'          => 'text',
        'name'          => 'sua_title',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'sua_title',
        'maxlength'     => 255,
        'label'         => 'Title'
    );
    
    public $sua_subtitle = array(
        'type'          => 'text',
        'name'          => 'sua_subtitle',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'sua_subtitle',
        'maxlength'     => 255,
        'label'         => 'Subtitle'
    );
    
    public $sua_description         = array(
        'type'          => 'ckeditor_modal',
        'name'          => 'sua_description',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'sua_description',
        'placeholder'   => 'Description',
        'label'         => 'Description',
    );
    
    
    public $sua_content= array(
        'type'          => 'textarea',
        'name'          => 'sua_content',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'sua_content',
        'required'      => false,
        'maxlength'     => 500,
        'placeholder'   => '',
        'label'         => 'Content',
    );
    
    public $sua_url = array(
        'type'          => 'text',
        'name'          => 'sua_url',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'sua_url',
        'maxlength'     => 255,
        'label'         => 'Signup Ad URL'
    );
    
    public $sua_behavior= array(
        'type'          => 'dropdown',
        'name'          => 'sua_behavior',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'sua_behavior',
        'required'      => false,
        'placeholder'   => '',
        'label'         => 'Signup Ad Behavior',
        'list_value'    => array(
                            '0' => 'New Tab',
                            '1' => 'Same Tab',
                            '2' => 'Popup'
                        )                           
    );
    
    public $sua_image= array(
        'type'          => 'filemanager',
        'name'          => 'sua_image',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'sua_image',
        'accept'        => 'jpg,png,jpeg,gif',
        'max_size'      => '5',
        'required'      => false,
        'label'         => 'Signup Ad Image',    
    );
    
    public $sua_image_mobile= array(
        'type'          => 'filemanager',
        'name'          => 'sua_image_mobile',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'sua_image_mobile',
        'accept'        => 'jpg,png,jpeg,gif',
        'max_size'      => '5',
        'required'      => false,
        'label'         => 'Signup Ad Image (Mobile)',    
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
    
    //platform url
    public $platform_url = array(
        'type'          => 'text',
        'name'          => 'platform_url',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'platform_url',
        'maxlength'     => 255,
        'label'         => 'Platform URL'
    );
    
    public $page_name_url= array(
        'type'          => 'text',
        'name'          => 'page_name_url',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'page_name_url',
        'maxlength'     => 150,
        'required'      => false,
        'placeholder'   => '',
        'label'         => 'Page Name URL'
    );
    
    public $area_limited= array(
        'type'          => 'dropdown',
        'name'          => 'area_limited_id',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'area_limited_id',
        'required'      => false,
        'placeholder'   => '',
        'label'         => 'Area Limited',
        'list_value'    => array(
            '0'   => 'No',
            '1'   => 'Yes'
        )
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
    
    public $comparator_content= array(
        'type'          => 'ckeditor',
        'name'          => 'comparator_content',
        'form-align'    => 'horizontal',
        'class'         => 'form-control product_info_inputs',
        'id'            => 'comparator_content',
        'required'      => false,
        'youtube'       => false,
        'filemanager'   => false,
        'label'         => 'Comparator Content'
    );
    
    public $promo_type= array (
        'type' => 'dropdown',
        'name' => 'promo_type',
        'form-align' => 'horizontal',
        'class' => 'form-control',
        'id' => 'promo_type',
        'required' => false,
        'label' => 'Promo Type',
        'list_value' => array(
                            '0' => 'Brand',
                            '1' => 'Barcode'
                        ),
    );
    
    public $generic_name_false= array (
        'type' => 'ckeditor',
        'name' => 'generic_name_false',
        'form-align' => 'horizontal',
        'class' => 'form-control',
        'id' => 'generic_name_false',
        'required' => false,
        'placeholder' => '',
        'label' => 'Generic Name'
    );
    
    public $compare_details= array (
        'type' => 'ckeditor',
        'name' => 'compare_details',
        'form-align' => 'horizontal',
        'class' => 'form-control',
        'id' => 'compare_details',
        'required' => false,
        'placeholder' => '',
        'label' => 'Compare Details'
    );
    
    public $product_url = array (
        'type' => 'text',
        'name' => 'product_url',
        'form-align' => 'horizontal',
        'class' => 'form-control',
        'id' => 'product_url',
        'maxlength' => 150,
        'label' => 'Product URL'
    );
    
    public $promo_list_lazada_link= array(
        'type'          => 'text',
        'name'          => 'promo_list_lazada_link',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'promo_list_lazada_link',
        'required'      => false,
        'placeholder'   => '',
        'label'         => 'Lazada Link'
    );
    
    public $promo_list_shopee_link= array(
        'type'          => 'text',
        'name'          => 'promo_list_shopee_link',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'promo_list_shopee_link',
        'required'      => false,
        'placeholder'   => '',
        'label'         => 'Shopee Link'
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
    
    public $ad_type= array(
        'type'          => 'dropdown',
        'name'          => 'ad_type',
        'form-align'    => 'horizontal',
        'class'         => 'form-control ad_type',
        'id'            => 'ad_type',
        'required'      => true,
        'placeholder'   => 'Ad Type',
        'label'         => 'Ad Type',
        'list_value'    => array(
                            '0'     => 'Site Modal Ads',
                            '1'     => 'Pop-up Ads'
                        ), 
    );
    
    public $ad_trigger_type= array(
        'type'          => 'dropdown',
        'name'          => 'ad_trigger_type',
        'form-align'    => 'horizontal',
        'class'         => 'form-control ad_trigger_type',
        'id'            => 'ad_trigger_type',
        'required'      => true,
        'placeholder'   => 'Trigger Type',
        'label'         => 'Trigger Type',
        'list_value'    => array(
                            '0'     => 'On-Load',
                            '1'     => 'Delayed Time'
                        ), 
    );
    
    public $ad_time_interval= array(
        'type'          => 'text',
        'name'          => 'ad_time_interval',
        'form-align'    => 'horizontal',
        'class'         => 'form-control ad_time_interval',
        'id'            => 'ad_time_interval',
        'required'      => true,
        'accept'        => '/[^0-9]/g',
        'placeholder'   => 'Time Interval (Seconds)',
        'label'         => 'Time Interval',
    );
    
    public $ad_position= array(
        'type'          => 'dropdown',
        'name'          => 'ads_position',
        'form-align'    => 'horizontal',
        'class'         => 'form-control ads_position',
        'id'            => 'ads_position',
        'required'      => true,
        'label'         => 'Ad Position',
        'list_value'    => array(
                            '0'     => 'Top Left',
                            '1'     => 'Top Right',
                            '2'     => 'Bottom Left',
                            '3'     => 'Bottom Right',
                        ),
    );
    
    public $tiktok_site_info         = array(
        'type'          => 'text',
        'name'          => 'tiktok_site_info',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'tiktok_site_info',
        'required'      => true,
        'placeholder'   => '',
        'label'         => 'Tiktok Link'
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
    
    // START - Appebon Kid Layout update
    public $background_image_mobile= array(
        'type'          => 'filemanager',
        'name'          => 'background_image_mobile',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'background_image_mobile',
        'accept'        => 'jpg,gif,png,jpeg,webp',
        'required'      => true,
        'placeholder'   => '',
        'label'         => 'Background Image Mobile',
    );   
    // END - Appebon Kid Layout update
    
    // START - Hemarate FA Layout Update
    public $target_customer_category= array(
        'type'          => 'dropdown',
        'name'          => 'target_customer_category',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'target_customer_category',
        'required'      => false,
        'placeholder'   => '',
        'label'         => 'Target Customer Category'
    );

    // START - Balitang Unilab Page
    public $top_stories = array(
        'type'          => 'dropdown',
        'name'          => 'top_stories',
        'form-align'    => 'horizontal',
        'class'         => 'form-control top_stories',
        'id'            => 'top_stories',
        'required'      => false,
        'placeholder'   => '',
        'label'         => 'Top Story',
        'list_value'    => array(
            '1'     => 'Yes',
            '0'     => 'No',
            )
    );
    public $top_story_thumbnail_req_false = array(
        'type'          => 'filemanager',
        'name'          => 'top_story_thumbnail_req_false',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'top_story_thumbnail_req_false',
        'accept'        => 'jpg,gif,png,jpeg,webp',
        'max_size'      => '5',
        'required'      => false,
        'placeholder'   => 'Top Story Image Thumbnail',
        'label'         => 'Top Story Image Thumbnail',
        
    );
    public $published_date = array(
        'type'          => 'date',
        'name'          => 'published_date',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'required'      => true,
        'id'            => 'published_date',
        'minDate'       => '0',
        'placeholder'   => 'Published Date',
        'label'         => 'Published Date',
        
    );
    public $post_link_req_false = array(
        'type'          => 'text',
        'name'          => 'post_link_req_false',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'post_link_req_false',
        'required'      => false,
        'placeholder'   => '',
        'maxlength'     => 500,
        'label'         => 'Post Link',
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
    // END - Balitang Unilab Page
        
    // START - Partner Store
    public $internal_store = array(
        'type'          => 'dropdown',
        'name'          => 'internal_store',
        'form-align'    => 'horizontal',
        'class'         => 'form-control',
        'id'            => 'internal_store',
        'required'      => false,
        'placeholder'   => 'Internal Store',
        'label'         => 'Internal Store',
        'list_value'    => array(
            '0'   => 'No',
            '1'   => 'Yes',
        ),
    );
    // END - Partner Store

}
?>
