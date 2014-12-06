<?php
 /*
package: Centraleffects Framework
Author:  Marc Comia
Website: Centraleffects.com
Company: Centraleffects BPO

*/

class hire_people extends Pages
{
	public function hire_people()
	{
		$this->set('title','Hire people- '.SYS_NAME);
		$this->render('hire_people');

		#to display unread msg
		$unread = $this->get_var("select count(is_read) from message_dashboard_tb where send_to = '".$this->current_userid()."' and is_read = 0 and is_trash = 0");
		$this->set('unreads', $unread);

		$freelancer = $this->fetch("SELECT u.*, umeta.* FROM user_meta_tb umeta inner join user_tb u on umeta.user_id = u.id 
			where meta_key = 'skills' group by u.id order by RAND()");
		$this->set('freelancer', $freelancer);


	}#public hirpeople
	

	public function searchfreelancer()
	{
		$this->set('title','Search  Freelancer- '.SYS_NAME);
		$this->render('hire_people_search');

		if($_REQUEST['uri_data']['selected']<>''){
			$sfreelance = $this->fetch("SELECT 	u.*, umeta.* 
								 	 FROM 
								   		user_meta_tb umeta inner join user_tb u on umeta.user_id = u.id 
									  where 
								  	   u.country = '".$_REQUEST['uri_data']['selected']."' and umeta.meta_key = 'skills'
									   order by (select avg(stars) from review_tb where user_id=u.id) DESC");
		
		$this->set('sfreelancer', $sfreelance);

		}else{$sfreelance = $this->fetch("SELECT 
										u.*, umeta.*
								   FROM 
								   		user_meta_tb umeta inner join user_tb u on umeta.user_id = u.id 
								   WHERE 
									   (umeta.meta_key = 'skills' and lower(umeta.meta_value) LIKE '%".strtolower($_POST['freelancer'])."%') 
									   order by (select avg(stars) from review_tb where user_id=u.id) DESC");
		
		$this->set('sfreelancer', $sfreelance);
		}
		
	}#searchfreelancer

	public function filterbycountry()
	{
		$this->set('title','Search  Freelancer- '.SYS_NAME);
		$this->render('hire_people_search');
			
		
		$filter = $this->fetch("SELECT DISTINCT country FROM user_tb");	
			
		$this->set('cfilter', $filter);
		
		
	}#searchfreelancer

	public function pmfreelance(){
		$this->set('title','Hire Freelancer - '.SYS_NAME);
		$this->render('hire_people_search');
		
		

		if(!empty($_POST['content']))
		{

			$true = $this->insert(' message_dashboard_tb',array(
						 "subject" => $_POST['freelancrsubject'],
						 "content" => $_POST['content'],
						 "sender_user_id" => $this->current_userid(),
						 "send_to" => $_POST['userid'],
						 "is_read" => "0",
						 "is_trash" => "0",
						 "date_sent" => strtotime(date('Y-m-d h:i:s e'))

					));
			if($true){
					$mail = new Skmail();
					//bawal ang negative opacity
					$mail->send_mail(array(
							'subject'=> $_POST['freelancrsubject'],
							'content'=> $_POST['content'],
							'to'=> array(
										array("name"=>$_POST['fname'],"email"=> $_POST['email'])
									),
							//we comment from to make admin sender.
							'from' => array('name'=>$_SESSION['currentLogin']['firstname'],'email'=>$_SESSION['currentLogin']['email'])
								));
					$this->set('msgAlert','<div class="alert alert-success"><strong>Successfully!</strong> sent .</div>');
					$this->render('hire_people');
			}

		}else{
			$this->set('msgAlert','<div class="alert alert-danger"><strong>Ooops!</strong> Cover letter is empty.</div>');
			$this->render('hire_people');
		}

	}

}#class hire_people
?>