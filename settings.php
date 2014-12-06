<?php
/*
package: Centraleffects Framework
Author: Rex Bengil
Website: Centraleffects.com
Company: Centraleffects BPO
-----------------------------------------------------------
		W A R N I N G !!!!
-----------------------------------------------------------
Modification of below information will need experienced 
person because below contains information that are needed 
across the site. Changing below with inappropriate information
will cause the site to not work properly and be messed up.
*/

#This will be the base url of your site like htttp://google.com/
#Do not forget to add trailing slash at the end.
define('BASE_URL','http://rex/demeter/');
	
#Do not forget to add trailing slash at the end.
define('ABS_PATH',$_SERVER['DOCUMENT_ROOT'].'/demeter/');	

#This folder contains system files
define('SYS_FOLDER', ABS_PATH.'system/');

#Class Folder, Do not change. Ask for guidance.
define('CLASS_FOLDER', SYS_FOLDER.'class/');

#public folder, This will contains styles and HTMLs, images,
#and including data that we are going to display
define('PUBLIC_FOLDER', SYS_FOLDER.'public/');

#For CSS/JS/IMG
define('BASE_URL_PUBLIC',BASE_URL.'system/public/');

#Public path for profile pictures
define('PROFILE_IMG',BASE_URL_PUBLIC.'images/profileimage/');

#Set the title or name of the system
define('SYS_NAME','Demeter Time Tracking');

#Set the version of the system
define('SYS_VERSION','1.0');

#Set Password Salt
define('SYS_SALT','ToGodBeTheGlory');

#Global configuration. This will contain the database account information that will be needed across the site.					
$GLOBALS['CFG']=array(
					
			'Database' => array(
						'host'=>'localhost',
						'databasename' =>'demeter',
						'username' =>'root',
						'password' =>''
						),
					
			/* For Sending email */
			'mail'=>array(		
				'gmail_username'	=> 'centraleffects@gmail.com',
				'gmail_password'	=> 'rexrex123',
				'from_name'			=> SYS_NAME,
				'from_email'		=> 'centraleffects@gmail.com',
				'use_SMTP'			=> true
			 ),
			 'paypal' =>array(
			 		'email'=>'centraleffects-merchant@yahoo.com',
			 		'username'=>'centraleffects-merchant_api1.yahoo.com',
			 		'password'=>'1392365472',
			 		'signature'=>'AiPC9BjkCyDFQXbSkoZcgqH3hpacA36H1m333SPjfAEPpH1vGfLGyhWh',
			 		'submit_url'=>'https://www.sandbox.paypal.com/cgi-bin/webscr',
			 		'commission'=>'0.05', /*This is for percentage deducted when payment is made by the employer */
			 		'masspay_url' =>'https://api-3t.sandbox.paypal.com/nvp'
			 	),
			 'start_payment_for_company'=>'5.00', /*This is in US dollars*/
			 'admin'=>array(
			 			'username'=>'admin',
			 			'password'=>'admin'

			 	)
	
	);
	
#Setting default Timezone to Asia/Manila
date_default_timezone_set("Asia/Manila"); 
	
	
#Error Reporting Level 
#More info on: http://php.net/manual/en/errorfunc.configuration.php
$errata = ini_get('error_reporting');
error_reporting($errata ^ E_NOTICE);
#error_reporting(1);
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
?>