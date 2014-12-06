<?php
 /*
package: Centraleffects Framework
Author: Rex Bengil
Website: Centraleffects.com
Company: Centraleffects BPO
*/

class  SKdatabase
{
	 public  $sql="";
	 public  $links;
	 
     #build a connection to our database server.
     function connect()
	 {
		global $CFG;
		$this->links=mysql_connect($CFG["Database"]["host"],$CFG["Database"]["username"],$CFG["Database"]["password"]) or die("Cannot connect to server. Please check your configurations.");
		mysql_select_db($CFG["Database"]["databasename"],$this->links) or die("Cannot connect to database server. Please check your configurations."); 
	 }
	
 	 #Execute query to database
	 function query($sql)
	 {
		$this->sql= $sql;
		$this->connect();
		
		$return = mysql_query($sql,$this->links);
		return  $return;

	 }
	 
	 #execute query and return ARRAY_A values
	 function fetch($sql,$isone=false)
	 {
	   $this->sql= $sql;
	   $aResult = array();
	   $this->connect();
	   $pResult = mysql_query($sql,$this->links);
	   if($pResult){
			if (mysql_num_rows($pResult) > 0) {
				while ($aRow = mysql_fetch_array($pResult)) {
					$aResult[] = $aRow;
				}
			} else {
				return false;
			}
			
			if($isone == true)
			{
				$aResult=$aResult[0];
			}
			
			return $aResult;
		
		}else{ return false; }
	 }
	 

	 #return only one variable
	 function get_var($sql)
	 {
		 $this->sql= $sql;
		 $r=$this->fetch($sql);
		 if(!$r)
		 {
			  return false;
		 }else
		 {
			return $r[0][0];
		 }
	 }
	 
	 #try to clean the submitted Data from user
	 #this is to prevent  XSS attack.
	 function clean($string,$allowhtml=false)
	 {
	   $hack=array("<script","</script>","<style","</style>","<html","</html>","<head","<?","?>","<link","<body","<META",
					"<!DOCTYPE","</head>","<title>","</title>","javascript:");
	   if($allowhtml==true){
	   }else{
	   	$string = strip_tags($string); //remove any HTML code
	   }
	   $string=preg_replace("/(mysql_query|\"|from|select|insert|delete|where|drop table|show tables|#|\*|--|\\\\)/",
				"", $string);
	   $string=addslashes(trim($string));
	   return $string;
	 }
	 
	 #Simple form to update a table values
	 # $table = STRING
	 # $values = ARRAY that corresponds to the table fields
	 # $conditions = ARRAY that corresponds to the primary key or any identifier
	 function update($table,$values,$condition)
	 {
		 $f="";
		 $c="";
		 if(is_array($values) and is_array($condition))
		 {
			 foreach($values as $k=>$v)
			 {
				 $f.=$k."='".$this->clean($v)."', ";
			 }
			 $f= substr($f,0,strlen($f)-2);
			 foreach($condition as $k=>$v)
			 {
				$c.=$k."='".$this->clean($v)."' and "; 
			 }
			 $c = substr($c,0,strlen($c)-4);
			$sql="update ".$table." set ".$f." where ".$c;
			$this->sql = $sql;
			 if($this->query($sql))
			 {
				 return true;
			 }else
			 {
				 return false;
			 }
		 }else
		 {
			 return false;
		 }
	 }
	 
	 #Simple form to update a table values
	 # $table = STRING
	 # $values = ARRAY that corresponds to the table fields
	 function insert($table,$values)
	 {
		 $f="";
		 if(is_array($values))
		 {
			 foreach($values as $k=>$v)
			 {
				 $f.=$k."='".$this->clean($v)."', ";
			 }
			 $f= substr($f,0,strlen($f)-2);
			 
			$sql="insert into ".$table." set ".$f;
			$this->sql = $sql;
			 if($this->query($sql))
			 {
				 return true;
			 }else
			 {
				 return false;
			 }
		 }else
		 {
			 return false;
		 }
	 }
	 
	 #return affted rows
	 function affected_rows()
	 {
		 return mysql_affected_rows();
	 }
	 
	 public function last_inserted_id()
	 {
	 	return mysql_insert_id();
	 }
	 
	 public function get_sql()
	 {
	   return $this->sql;
	 }
	 public function get_mysql_error()
	 {
	 	return mysql_errno($this->links).' : '.mysql_error($this->links);
	 }
	 public function numrows($sql)
	 {
	 	return mysql_num_rows($this->query($sql));
	 }

	 public function delete($table,$condition,$limit=""){
	 	$f="";
		 $c="";
		 if(is_array($condition))
		 {
			 
			 foreach($condition as $k=>$v)
			 {
				$c.=$k."='".$this->clean($v)."' and "; 
			 }
			 $c = substr($c,0,strlen($c)-4);
			$sql="delete from ".$table."  ".$f." where ".$c." ".(($limit<>"")?" LIMIT ".$limit:" LIMIT 1");
			$this->sql = $sql;
			 if($this->query($sql))
			 {
				 return true;
			 }else
			 {
				 return false;
			 }
		 }else
		 {
			 return false;
		 }
	 }
	
}#end of Class
?>