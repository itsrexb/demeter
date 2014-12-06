<?php
/*
package: Centraleffects Framework
Author: Rex Bengil
Website: Centraleffects.com
Company: Centraleffects BPO
*/

class bootstrap extends SKgeneral
{
		
	function bootstrap($getpage,$subpage='',$request_uri='')
	{
		#We should replace - to _ to have naming compatability
		$getpage = str_replace('-','_',$getpage);
		$subpage = str_replace('-','_',$subpage);
		$this->requestedpage  =  $getpage;
		$this->subpage= $subpage ;
		if(trim($subpage)==""){ $this->subpage =""; }
		
		#This will handle the query string of the page
		$request_uri=explode("/",$request_uri);
		$b=1;
		$z=array();
		$temp="";
		for($a=0;$a<count($request_uri);$a++)
		{
			if($b==1){ $temp=$request_uri[$a]; }
			if($b==2){ $z[$temp]=$request_uri[$a]; $b=0;}
			$b++;
		}
		if((count($request_uri)%2)==1){ $z[$request_uri[($a-1)]] =""; }
		$uri = $_SERVER['REQUEST_URI'];
		$uri = explode('?',$uri);
		$uri = explode('&',$uri[1]);
		if(!empty($uri))
		{
			foreach($uri as $u)
			{
				$u=explode('=',$u);
				$z[$u[0]]=$u[1];
			}
		}
		if(!empty($z)){
			$_REQUEST["uri_data"]=$z; #return a new value
			$this->request_uri=$z;
		}
		#call handler of request
		$this->handleRequest();
		
	}
	
	public function handleRequest()
	{
		if($this->requestedpage==""){ 
				// if($this->checkLogin()==false)
				// {
					// $this->requestedpage = 'login';
					// $this->redirect('welcome');
					// $this->requestedpage = 'index';
				// }else
				// {
					$this->requestedpage = 'index';
				//}
		 }
		$file=CLASS_FOLDER.$this->requestedpage.'.class.php';
		if(!file_exists($file))
		{
			return false;
		}else
		{
			return true;
		}
		
	}
	
	public function initiateClass()
	{
		$newClass = NULL;
		$cls=CLASS_FOLDER.$this->requestedpage.'.class.php';
		include_once($cls);
		$newClass = new $this->requestedpage();		
		return $newClass;
	}
	
	public function check_subpage()
	{
		return $this->enable_subpage;
	}
	

}
?>