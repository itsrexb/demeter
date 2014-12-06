<?php

 /*

package: Centraleffects Framework

Author: Marc Comia

Website: Centraleffects.com

Company: Centraleffects BPO

*/



class login extends Pages

{
	public function login()
	{
		//$this->redirect('login');
		$this->set('title','Login - '.SYS_NAME);
		$this->render('login');
	}

	public function loginsuccess(){

		if($_POST['email'] <>"" or $_POST['password'] <> ""){
			$sql = "select u.*, p.password from user_tb as u 
								inner join user_password_tb as p
								on u.id=p.user_id 
								where 
								(	u.email='".$this->clean($_POST['email'])."'  OR
									u.username='".$this->clean($_POST['email'])."' ) AND
								p.password='".$this->hash_password($_POST['password'])."' AND
								p.is_new = '1'
								";

			$r= $this->fetch($sql,true);			

			if(!empty($r))
			{
				if(empty($_SESSION)){ session_start(); }
				$_SESSION["currentLogin"] = $r;
				$this->isvalid=true;	
				if(!empty($_SESSION["currentLogin"])){
					$this->redirect("profile/");
				}
				else{
					$this->set('msg','<div class="alert alert-danger"><strong>Oh Snap!</strong> Invalid Login.</div>');
				}	
			}else{
				$this->set('msg','<div class="alert alert-danger"><strong>Oh Snap!</strong> Invalid Login.</div>');
			}
		}else{
			$this->set('msg','<div class="alert alert-danger"><strong>Oh Snap!</strong> Username and Password is incorrect.</div>');
		}
	}#loginsuccess


	public function forgotpwd(){
		$this->set('title','Forgot Paswword - '.SYS_NAME);
		$this->render('login_forgotPassword');
	}

	public function validatefpassword(){

		if(isset($_POST['submit']))
		{

			  require_once(PUBLIC_FOLDER.'recaptchalib.php');
			  $privatekey = "6Lc3X-4SAAAAAG4KsrUHr8sfcq920tNwIpbtmoyN ";
			  $resp = recaptcha_check_answer ($privatekey,
			                                $_SERVER["REMOTE_ADDR"],
			                                $_POST["recaptcha_challenge_field"],
			                                $_POST["recaptcha_response_field"]);

			  if (!$resp->is_valid)
			   {
				$this->set('msg','<div class="alert alert-warning"><strong>Hola!</strong> The reCaptcha wasnt correct, Go back and try it again!</div>');
			   }else
			    {
				$valemail = $this->get_var("SELECT email FROM user_tb where email ='".$_POST['email']."' and username = '".$_POST['uname']."'", true);	

					  	if($valemail != $_POST['email'])
					    {
							   $this->set('msg','<div class="alert alert-danger"><strong>Oh Snap!</strong> Email Address does not Exist!.</div>');
					  	}else{

							$pwd = 	$this->fetch("SELECT u.id, u.firstname, p.password
										from user_tb as u inner join user_password_tb as p 
								  		on u.id = p.user_id where u.email = '".$_POST['email']."'",ture);

							$newpassword = substr(str_shuffle('abcdefghijklmnopqrstuvwxyz1234567890'),0,8);
									  		echo "id ".$pwd['id'];
									  		echo "newpassword". $newpassword;

								if($this->update('user_password_tb',array(
												"is_new" => 0),array(
	  											"user_id" => $pwd['id'])))
									  		{
									  			$this->insert('user_password_tb',array(	
									  				"password"=> $this->hash_password($newpassword),
									  				"user_id" => $pwd['id'],
									  				"is_new" => 1));	

						 								$mail = new Skmail();
														#bawal ang negative opacity
														$r = $mail->send_mail(array(
																	'subject'=>'Forgot Passowrd',
																	'content'=>'<p>HI '.$_POST['email'].'
																	</p>	
																		<p><h1>Your Account is</h1></p>
																		<p>Username: '.$_POST['uname'].'</p>
																		<p>password: '.$newpassword.'</p>
																		<p> Find work now!. </p>',

																		'to'=> array(
																					array('name'=>$pwd['firstname'].' '.$pwd['lastname'],'email'=> $_POST['email'])
																					) ,

																		#we comment from to make admin sender.
																		'from' => array('name'=>'Demeter Time-Tracking','email'=>'centraleffects@hotmail.com')
																		));

																		if(!$r){
																			echo'Error: '.$r;
																		}else{
																			$this->set('msg','<div class="alert alert-success"><strong>Success!</strong> Your new password is sent to your email '.$_POST["email"].'. Please check your Inbox or Spam Folder and Start to work now!</div>');
																		     }#else

									  		}else{
									  			$this->set('msg','<div class="alert alert-danger"><strong>Opps!</strong> Please contact your Administrator!</div>');
											}

					  	}#else
				}#else
		}  	

	}#validatefpassword



	function applogin(){


		$sql = "select  u.id, u.firstname, u.lastname, u.username, u.email, u.image_filename from user_tb as u 

								inner join user_password_tb as p

								on u.id=p.user_id 

								where 

								(	u.email='".$this->clean($_REQUEST['uri_data']['email'])."'  OR

									u.username='".$this->clean($_REQUEST['uri_data']['email'])."' ) AND

								p.password='".$this->hash_password($_REQUEST['uri_data']['password'])."' AND

								p.is_new = '1'

								";

			$r= $this->fetch($sql,true);

	

			if(empty($r))

			{

				$this->set('json',"false");

			}else{



				//return user info

				$str = $r['firstname']."^";

				$str .= $r['lastname']."^";

				$str .= $r['username']."^";

				$str .= $r['email']."^";

				$str .= PROFILE_IMG.$r['image_filename']."^";

				$str .= $r['id'];



				$this->set('json',$str);

			}



		$this->render('json');

	}







}

?>