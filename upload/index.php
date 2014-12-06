<?php 
//if($_SERVER['REQUEST_METHOD']=='POST')
//{
	//$_GLOBAL['str']="";
	
	/*function isfoor($obj)
	{
		global $str;
		foreach($obj as $k=>$v)
		 {
			if(is_array($v)){
				$str .=$k."=>".$v."{<br>";
				isfoor($v);
			}else{
				$str .=$k."=>".$v."<br>";
			}
		 }
		
	}
	global $str;
	isfoor($_SERVER);
	$str.="<br><br>";
	isfoor($_POST);
	$str.="<br><br>";
	isfoor($_FILES);
	$str.="<br><br>";*/
	move_uploaded_file($_FILES['file']['tmp_name'],$_FILES["file"]['name']);
	/*$str.='Filename: '.$_FILES["file"]['name'].'***<br>';
	$str.='Size: '.$_FILES["file"]['size'].'***<br>';
	$str.='Error: '.$_FILES["file"]['error'].'***<br>';
	$str.='Type: '.$_FILES["file"]['type'].'***<br>';*/
	
	//Always set content-type when sending HTML email
	/*$headers = "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
	
	mail("centraleffects@yahoo.com","demeter callback",$str,$headers);*/
//}
//echo 'hello world api<br>';

//print_r($_FILES);//echo print_r($_SERVER);
//print_r($_SERVER);
?>