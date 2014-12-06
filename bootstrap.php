<?php
/*
package: Centraleffects Framework
Author: Rex Bengil
Website: Centraleffects.com
Company: Centraleffects BPO
*/
session_start();
include_once("settings.php");

#check if the system folder exist
if(!is_dir(SYS_FOLDER)){ die('Are you kidding me? I cannot find the system folder.');}

include_once(CLASS_FOLDER.'database.sys.class.php');
include_once(CLASS_FOLDER.'phpmailer.sys.class.php');
include_once(CLASS_FOLDER.'general.sys.class.php');
include_once(CLASS_FOLDER.'pages.sys.class.php');
include_once(CLASS_FOLDER.'bootstrap.sys.class.php');
include_once(CLASS_FOLDER.'skmail.sys.class.php');


$boot = new bootstrap($_REQUEST["page"],$_REQUEST["subpage"],$_REQUEST["uri"]);
if($boot->handleRequest())
 {
 	$newClass = $boot->initiateClass();
	$subpage=$boot->get_subpage();
	if($subpage<>""){
		if(method_exists($newClass,$subpage))
				{
					$newClass->$subpage(); 
				}
		
	}
	//$newClass->check_page_permission();
	$newClass->display();
	 
	
 }else
 {
 	$boot->display404();
	exit(0);
 }


?>