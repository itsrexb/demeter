<?php
/*
package: Centraleffects Framework
Author: Rex Bengil
Website: Centraleffects.com
Company: Centraleffects BPO
*/

class Skmail extends SKgeneral
{
	
		
	  #This function will send an email to user.
	 /*
		$args = array(
			'subject' =>'',   //
			'content' => ''	  //accepts HTML markup
			'to'	  => array(
							array(
								'name' => ''   //name of email recipient
								'email' => ''
							),
							array(
								'name' => ''   //name of email second recipient
								'email' => ''
							)
						},
			'from' => array(
					'name'=>'',
					'email'=>''
				
			)

	 */
	  public function process_mail($args)
	  {
		
			global $CFG;

			$mail = new PHPMailer();  // create a new object
			

			if($CFG["mail"]['use_SMTP']==true){
				$mail->Host       = "gmail.com";
				$mail->IsSMTP(); // enable SMTP
				$mail->SMTPDebug = 1;  // debugging: 1 = errors and messages, 2 = messages only
				$mail->SMTPAuth = true;  // authentication enabled
				$mail->SMTPSecure = 'tls'; // secure transfer enabled REQUIRED for Gmail
				$mail->Host = 'smtp.gmail.com'; // SMTP server
				$mail->Port = 465; 
				$mail->Username = $CFG["mail"]['gmail_username'];  
				$mail->Password = $CFG["mail"]['gmail_password'];    
			}else{
				$mail->IsMail();
			}

			 if(!empty($args["from"]))
			 {
			 	$mail->FromName = trim($args["from"]['name']);
				$mail->From = trim($args["from"]['email']);
			 }else{
			 	$mail->FromName = trim($CFG["mail"]['from_name']);
				$mail->From = trim($CFG["mail"]['from_email']);
			 }
			 

			 $mail->Subject = $args["subject"];
			 $mail->Body = $args["content"];

			if(!is_array($args["to"]))
			{
				return 'Mail error: Invalid Email Recipient';
			}else{

				foreach($args["to"] as $m)
				{
					$mail->AddAddress($m["email"],$m["name"]);
				}
			}

			if(!$mail->Send()) {
				return 'Mail error: '.$mail->ErrorInfo;
			} else {
				return true;
			}
	  }
	  

	  /*
		$args = array(
			'subject' =>'',   //
			'content' => ''	  //accepts HTML markup
			'to'	  => array(
							array(
								'name' => ''   //name of email recipient
								'email' => ''
							),
							array(
								'name' => ''   //name of email second recipient
								'email' => ''
							)
				)
		);*/
	  
	  public function send_mail($args)
	  {
	  	global $CFG;
			$content='<div style="text-align:left">
						'.$args["content"].'
				   <p><br><br>
					<div style="font-size:12px; 
					 font-family: lucida grande,tahoma,verdana,arial,sans-serif; color:#919191">
					  Regards,
					</div>
					<div style="font-size:12px; margin-top:10px;
					 font-family: lucida grande,tahoma,verdana,arial,sans-serif; color:#919191">
					 '.SYS_NAME.'
					</div>
					<div style="font-size:12px; margin-top:15px;
					 font-family: lucida grande,tahoma,verdana,arial,sans-serif; color:#919191">
					 '.$_SERVER['SERVER_NAME'].'
					</div>
					<div style="font-size:12px; margin-top:3px;
					 font-family: lucida grande,tahoma,verdana,arial,sans-serif; color:#919191">
					 '.$CFG["mail"]['from_email'].'
					</div>
					<br><br><br>
				  <div style="border:1px solid #B7B7B7; padding:5px; font-size:9px; 
				  font-family: lucida grande,tahoma,verdana,arial,sans-serif; color:#919191">
				   If you receive this in error  or you are not a person mention above, please ignore and delete this Email immediately
				  or forward this Email to the appropriate receipient.
				  </div>
				  <br>
				  </p>
				  </div>';
				 $args["content"] = $content;
		 
		 return $this->process_mail($args); #send mail
			  
	  }
	  
	
}//end of class