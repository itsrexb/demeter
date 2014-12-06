<?php

 /*
package: Centraleffects Framework
Author:  Marc Comia
Website: Centraleffects.com
Company: Centraleffects BPO
*/


class Profile extends pages
{
	public function profile()
	{
		$this->set('title','Profile'.SYS_NAME);
		$this->render('profile');

		#to display unread msg
		$unread = $this->get_var("select count(is_read) from message_dashboard_tb where send_to = '".$this->current_userid()."' and is_read = 0 and is_trash = 0");
		$this->set('unreads', $unread);

		// $profileDetails =  $this->fetch("select * from user_tb where id = '".$this->current_userid()."'");
		// $this->set('profDetails',$profileDetails);

		// //if true one row will be fetch
		// $imageDisplay =  $this->fetch("select * from user_tb where id = '".$this->current_userid()."'",true);
		// $this->set('imageShow',$imageDisplay);
		// //fetch skills from different table you need to do <?php $data['var'][array][value]?
		// $skillsfetch =  $this->fetch("select * from user_meta_tb where user_id='".$this->current_userid()."'",true);
		// $this->set('skillshow',$skillsfetch);
		// #echo "testing".$this->pr($skillsfetch);

		$profileDetails = $this->fetch("select u.*,up.* from user_tb as u inner join user_password_tb as up on u.id = up.user_id
     	where u.id = '".$this->current_userid()."'", true);
		$this->set('profDetails',$profileDetails);

		$workxp = $this->fetch("select * from user_meta_tb where user_id='".$this->current_userid()."' and meta_key = 'work-experience'",true);
		$this->set('workxperience', $workxp);

		$skillsfetch =  $this->fetch("select * from user_meta_tb where user_id='".$this->current_userid()."' and meta_key = 'skills'",true);
					$this->set('skillshow',$skillsfetch);
	}#profile

	public function sprofile()
	{
		$this->set('title','Profile'.SYS_NAME);
		$this->render('profile_view');

		$sview = $this->fetch("select u.*,up.* from user_tb as u inner join user_password_tb as up on u.id = up.user_id
     	where u.id = '".(int)$_REQUEST['uri_data']['sid']."'", true);
		$this->set('sprofile',$sview);

		$sprofileskill =  $this->fetch("select * from user_meta_tb where user_id='".(int)$_REQUEST['uri_data']['sid']."' and meta_key = 'skills'",true);
				$this->set('sSkill',$sprofileskill);

		$sworkxp = $this->fetch("select * from user_meta_tb where user_id='".(int)$_REQUEST['uri_data']['sid']."' and meta_key = 'work-experience'",true);
		$this->set('sworkexp', $sworkxp);

		/*add reviews */
		if($_POST['reviewcontent']<>"")
		{
			 if($this->get_var("select count(*)
			 								from review_tb 
						  	 				where 
						  	 				reviewedby='".$this->current_userid()."' and
						  	 				user_id ='".$_REQUEST['uri_data']['sid']."'
						  	 				")<1){

				if($this->insert("review_tb",array(
						"reviewedby"=> $this->current_userid(),
						"user_id"=> (int)$_REQUEST['uri_data']['sid'],
						"comments"=>$_POST['reviewcontent'],
						"stars"=>(($_POST['starview']<>"")?(int)$_POST['starview']:$_POST['starview']),
						"date_added"=> strtotime(date('Y-m-d h:i:s e'))
					))){
					$this->set('msg','<div class="alert alert-success"><strong>Success!</strong> Your review has been added.</div>');
				}

			}


		}

	}#sprofile


	public function pupadate()
	{
		if($_POST['userid'] <> "" AND $_POST['fname'] <> "" AND $_POST['lname'] <> "")
		{
			$res = $this->update('user_tb',array(
				"firstname" => $this->clean($_POST['fname']),
				"lastname" => $this->clean($_POST['lname']),
				"username" => $this->clean($_POST['userid']),
				"title" => $this->clean($_POST['title']),
				"rate" => $this->clean($_POST['rate']),
				"paypal_email" => $this->clean($_POST['payPalEmail']),
				"country" => $_POST['selcountry']),array(
				"id" => $this->current_userid())
				);

			
			    // $this->update('user_password_tb',array(
			    // 	"password" => $this->hash_password($_POST['pwd'])),array(
			    // 	"user_id" => $this->current_userid())
			    // 	);

			if($res)
			{
				$this->set('msg','<div class="alert alert-success"><strong>Success!</strong> You succefully update your account. Start to work now!</div>');
					
				$profileDetails = $this->fetch("select u.*,up.* from user_tb as u inner join user_password_tb as up on u.id = up.user_id
										     	where u.id = '".$this->current_userid()."'", true);
				$this->set('profDetails',$profileDetails);
			}else{
				$this->set('msg','<div class="alert alert-danger"><strong>Oh Snap!</strong> Please review your information before to submit or Contact your System Administration.</div>');
				}
		}else{
				if(!empty($_POST['']))
				{
					$this->set('msg','<div class="alert alert-danger"><strong>Oh Snap!</strong> Make sure that your User Id is not empty, Please fill-up the Form correctly.</div>');
				}
			}

			$sql = "select u.* from user_tb where id='".$_SESSION["currentLogin"]['id']."'";

			$r= $this->fetch($sql,true);			

			if(!empty($r))
			{
				if(empty($_SESSION)){ session_start(); }
				$_SESSION["currentLogin"] = $r;
				
			}else{
				
			}
	}//pupdate

	public function pChangepass(){	

		$fetcholdpass = $this->get_var("select count(*) from user_password_tb where user_id ='".$this->current_userid()."' and password='".$this->hash_password($_POST['oldpassword'])."'");
		//$oldpassword = $this->hash_password($_POST['oldpwd']);
		if((int)$fetcholdpass==0){
			$this->set('msgPwdChange','<div class="alert alert-danger"><strong>Oh Snap!</strong> Incorrect password.</div>');
		}else{
				if($_POST['newPassword'] != $_POST['confirmPassword']){
					$this->set('msgPwdConfirm','<div class="alert alert-danger"><strong>Oh Snap!</strong> Your new password did not match.</div>');
				}else{	

						//check if the new password to update was their old password.
						//deny changing their password if password was already user before.
						$checknewpass = $this->get_var("select count(*) from user_password_tb where password='".$this->hash_password($_POST['newPassword'])."' and user_id = ".$this->current_userid()."'");

						if((int)$checknewpass>0){



							$this->set('msgPwdError','<div class="alert alert-danger"><strong>Sorry!</strong> You cannot use your old password. Please choose a new one.</div>');

						}else{
							//set all old password to inactive
							$this->update("user_password_tb",array("is_new"=>0),array("user_id"=>$this->current_userid()));
							//insert the new password.
							$result = $this->insert(
									"user_password_tb",
									array(
											"is_new"=>1,
											"password"=>$this->hash_password($_POST['newPassword']),
											"user_id"=>$this->current_userid()
										)
								);

							if($result){
								$this->set('msgPwdSuccessChange','<div class="alert alert-success"><strong>Congratulation!</strong> You successfully change your password.</div>');
							}else{
								$this->set('msgPwdError','<div class="alert alert-danger"><strong>Oh Snap!</strong> Please review your information before to submit or Contact your System Administrator.</div>');
							} //else
						}		
				} //else
		}		

	}//pPasswordChange
	public function pupload()
	{
		$imageName = $this->get_var("Select image_filename From user_tb where id ='".$this->current_userid()."'");
		// $shuffled = str_shuffle('abcdefghijklmnopqrstuvwxyz1234567890'); 
		// $filename = substr($shuffled,0,5).date('Ymdhis');
		$uploaddir = ABS_PATH."system/public/images/profileimage/";
		if(!is_dir($uploaddir)){ mkdir($uploaddir,0775); }
		$filetype="";
		switch($_FILES['imageFile']["type"])
		{
		 case "image/jpeg":
			 $filetype=".jpg";
			 break;
		 case "image/gif":
			 $filetype=".gif";
			 break;
		case "image/png":
			 $filetype=".png";
			 break;	 
		}
		$filename=substr(str_shuffle('abcdefghijklmnopqrstuvwxyz1234567890'),0,5).date('ymdhis').$filetype;
		if(!move_uploaded_file($_FILES['imageFile']['tmp_name'],$uploaddir.$filename)){
			 $this->set('msgupload','<div class="alert alert-danger"><strong>Oh Snap!</strong>.jpg /.gif /.png are required.</div>');
		}else{
			$update = $this->update('user_tb',array("image_filename" => $filename),array("id" => $this->current_userid())); //update
			#trim remove the space if trim(var,"abc") remove the abc letter		
			if(trim($imageName)<>""){
				if(file_exists(ABS_PATH."system/public/images/profileimage/".$imageName))
				{
					unlink(ABS_PATH."system/public/images/profileimage/".$imageName);		
				}
			}
			$profileDetails = $this->fetch("select u.*,up.* from user_tb as u inner join user_password_tb as up on u.id = up.user_id
	     	where u.id = '".$this->current_userid()."'", true);
			$this->set('profDetails',$profileDetails);	

			$this->set('msgupload','<div class="alert alert-success"><strong>Successfully uploaded!</strong></div>');
		}	

		// echo "id = ".$this->current_userid();
		// echo "<br/> image_filename =".$filename;
		// echo "<br>query =".$r;

		$sql = "select * from user_tb where id='".$_SESSION["currentLogin"]['id']."'";

			$r= $this->fetch($sql,true);			

			if(!empty($r))
			{
				if(empty($_SESSION)){ session_start(); }
				$_SESSION["currentLogin"] = $r;
				
			}else{
				
			}

	}//pUpload

	public function skupdate(){
		$s = $_POST['skilltxtArea'];
		if($_POST['skilltxtArea'] <> "")
		{
			$valSkill = $this->get_var("select count(*) from user_meta_tb where user_id = '".$this->current_userid()."' and meta_key ='skills' ");	
			if($valSkill > 0){
				if($this->update('user_meta_tb',array(
					 "meta_value" => $this->clean($_POST['skilltxtArea'])),array(
					 "user_id" => $this->current_userid(),
					 "meta_key" => 'skills')
					 )){
					$this->set('skillmsg','<div class="alert alert-success"><strong>Success!</strong> You have successfully update your skills. Start to work now!</div>');
					
					$skillsfetch =  $this->fetch("select * from user_meta_tb where user_id='".$this->current_userid()."' and meta_key = 'skills'",true);
					$this->set('skillshow',$skillsfetch);

				}
			}else{
				if($this->insert('user_meta_tb',array(
					 "meta_key" => 'skills',
					 "meta_value" => $this->clean($_POST['skilltxtArea']),
					 "user_id" => $this->current_userid())
				)){
					$skillsfetch =  $this->fetch("select * from user_meta_tb where user_id='".$this->current_userid()."' and meta_key = 'skills'",true);
					$this->set('skillshow',$skillsfetch);
					$this->set('skillmsg','<div class="alert alert-success"><strong>Success!</strong> Skills is successfully added. Start to work now!</div>');
 				}
			 }		
		}else{
			$this->set('skillmsg','<div class="alert alert-danger"><strong>Oh Snap!</strong>Skills is empty!...</div>');
		}

	}//skupdate function

	public function workupdate(){	

		if($_POST['wrkdescpt'] <> "")
		{
			$valworkxp = $this->get_var("select count(*) from user_meta_tb where user_id = '".$this->current_userid()."' and meta_key ='work-experience' ");	
			if($valworkxp > 0){
				if($this->update('user_meta_tb',array(
					 "meta_value" => $this->clean($_POST['wrkdescpt'])),array(
					 "user_id" => $this->current_userid(),
					 "meta_key" => 'work-experience')
					 )){
					$this->set('wrkxpmsg','<div class="alert alert-success"><strong>Success!</strong> You have successfully update your Work Experience. Start to work now!</div>');
					$workxp = $this->fetch("select * from user_meta_tb where user_id='".$this->current_userid()."' 						and meta_key = 'work-experience'",true);
					$this->set('workxperience', $workxp);
				}
			}else{
				if($this->insert('user_meta_tb',array(
					 "meta_key" => 'work-experience',
					 "meta_value" => $this->clean($_POST['wrkdescpt']),
					 "user_id" => $this->current_userid())
				)){
					$workxp = $this->fetch("select * from user_meta_tb where user_id='".$this->current_userid()."' and 						meta_key = 'work-experience'",true);
					$this->set('workxperience', $workxp);
		
					$this->set('wrkxpmsg','<div class="alert alert-success"><strong>Success!</strong> Work Experience is successfully added. Start to work now!</div>');
				}
			}
		}else{
			$this->set('wrkxpmsg','<div class="alert alert-danger"><strong>Oh Snap!</strong>Work Description is empty!...</div>');
		}

	} #workupdate


}

?>