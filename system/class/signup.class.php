<?php
 /*
package: Centraleffects Framework
Author:  Marc Comia
Website: Centraleffects.com
Company: Centraleffects BPO
*/


class Signup extends pages

{
	public function signup()
	{
		$this->set('title', 'Signup - '.  SYS_NAME );
		$this->render('signup');

	} // function		

	public function sregister(){
	
			$fname = $_POST['firstname'];
			$lname = $_POST['lastname'];
			$uname = $_POST['username'];
			$email = $_POST['emailaddress'];
			$cofrmEmail = $_POST['confirmEmail'];
			$pwd =$_POST['password'];

		

if($email != $cofrmEmail){
			$this->set('warn','<div class="alert alert-warning"><strong>Oops!</strong> There is a problem with your email address.</div>');
			$this->set('warn1','<div class="alert alert-danger"><strong>Warning!</strong> Email do not match. Please try again.</div>');
}else{ 	
		$year = date('Y') - $_POST['years'];

		if($year < 18){
			$this->set('warn','<div class="alert alert-danger"><strong>Sorry!</strong> <small>You must be 18 and above to be qualified.</small></div>');
	    }else
	    {	
			//echo $this->pr($_POST);
			if($fname <> "" and $lname <> "" and $uname <> "" and $email <> "" and $pwd <> "")
			{
				if((strlen($pwd) < 6))
				{
					$this->set('warn','<div class="alert alert-warning"><strong>Oops!</strong> Please choose a more secure password. It should be longer than 6 characters, unique to you, and difficult for others to guess.</div>');
				}else
				{

					$confirmcode = substr(str_shuffle("ABCDEFGHIJKLMNOPQSTUVWXYZqwertyuioplkjhgfdsazxcvbnm1234567890"),0,15);
					$res = $this->insert("user_tb",array(
							"firstname"	=> $this->clean($fname),
							"lastname"	=> $this->clean($lname),
							"username"	=> $this->clean($uname),
							"email"	=> $this->clean($email),
							"confirm_code" =>$confirmcode
							) //array
							); //insert																								

							$row = $this->get_var("select id from user_tb where email = '".$email."'");
							$getID = $row;

							$this->insert("user_password_tb",array(
							"user_id" => $getID, 
							"password" => $this->hash_password($pwd), 
							"is_new" => "1"));
												
					if($res)
					{
						$this->set('msg','<div class="alert alert-success"><strong>Success!</strong> You have just created a new account and check your email. Start to work now!</div>');

						$mail = new Skmail();
						#bawal ang negative opacity

						$r = $mail->send_mail(array(
							'subject'=>'Demeter Registration',
							'content'=>'<p>Hello! '.$fname.',
										<br><br>
										Thank you for registering to Demeter! Your username and password is indicated below.
										<br>
										<p><strong>Account Details</strong>
										<br>
										 Username: '.$uname.' or '.$email.'
										<br>
										 password: '.$pwd.'
										<br><br>
										Please confirm you email by click <a href="'.BASE_URL.'signup/confirm/code/'.$confirmcode.'/">here</a>
										<br><br>
										Copy the URL below and paste it in your address bar if the link above does not work.<br>
										'.BASE_URL.'signup/confirm/code/'.$confirmcode.'/
										</p>',																
							'to'=> array(array('name'=>$fname. $lname,'email'=> $email)
										) //,
										#we comment from to make admin sender.
										// 'from' => array('name'=>'rexx','email'=>'centraleffects@hotmail.com')
											));
							if(!$r){
								echo'Error: '.$r;
							}else{
								#echo'Single mail sent!';
							}#else
					}else{
						$this->set('msg','<div class="alert alert-danger"><strong>Oh Snap!</strong> There is an existing account associated with your Email or Username.</div>');
					}#else

				}#else
			}else{					
				$this->set('msg','<div class="alert alert-danger"><strong>Oh Snap!</strong> Please fill-up the Form correctly.</div>');
			}#else

		}#agevalidation												 

	} //elsetop emailconfirm
}//sregister


	function confirm(){

		if($this->update("user_tb",array(

				"confirm_code"=>"",

				"isconfirmed"=>1

			),array(

				"confirm_code"=>$confirmcode

			)))

		{

			$this->set('msg','<div class="alert alert-success"><strong>Congratulations!</strong> You are now a confirmed freelancer.</div>');

		}



	}

} //class

?>