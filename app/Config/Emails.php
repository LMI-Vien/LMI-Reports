<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Emails extends BaseConfig
{
		public $useragent        = "PHPMailer";
		public $protocol         = "sendgrid";
		public $mailpath         = "/usr/sbin/sendmail";
		public $smtp_host        = "smtp.gmail.com";
		public $smtp_user        = "";
		public $default_email    = "";
		public $smtp_pass        = "";
		public $smtp_port        = 465;
		public $smtp_timeout     = 300;
		public $smtp_crypto      = "ssl";
		public $smtp_debug       = 3; 
		public $debug_output     = "";
		public $smtp_auto_tls    = true;
		public $smtp_conn_options = array("ssl" => array("verify_peer"=> false,"verify_peer_name" => false,"allow_self_signed" => true)); 
		public $wordwrap         = true;
		public $wrapchars        = 76;
		public $mailtype         = "html";
		public $charset          = "iso-8859-1";
		public $validate         = true;
		public $priority         = 3;
		public $crlf             = "\n";
		public $newline          = "\r\n";
		public $bcc_batch_mode   = false;
		public $bcc_batch_size   = 200;
		public $encoding         = "8bit";
		public $dkim_domain      = "";
		public $dkim_private     = "";
		public $dkim_private_string = "";
		public $dkim_selector    = "";
		public $dkim_passphrase  = ""; 
		public $dkim_identity    = "";
}
