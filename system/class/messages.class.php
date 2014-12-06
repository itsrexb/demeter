<?php
 /*
package: Centraleffects Framework
Author:  Marc Comia
Website: Centraleffects.com
Company: Centraleffects BPO
*/

class messages extends Pages
{	
	public function messages(){
		$this->set('title','Message - '.SYS_NAME);
		$this->render('messages');

		if($_REQUEST['subpage'] <> 'viewmessage'){
			#count how many unread messages
			$unread = $this->get_var("select count(is_read) from message_dashboard_tb where send_to = '".$this->current_userid()."' and is_read = 0 and is_trash = 0");
			$this->set('unreads', $unread);

			#count how many read messages
			$countreadmsg = $this->get_var("select count(is_read) from message_dashboard_tb where send_to = '".$this->current_userid()."' and is_read = 1 and is_trash = 0 ");
			$this->set('countreadsmsg', $countreadmsg);
		
		}

		#count how archive msg
		$archive = $this->get_var("select count(is_trash) from message_dashboard_tb where send_to = '".$this->current_userid()."' and is_archive = 1");
		$this->set('archives', $archive);

		#count how many trash msg
		$trashmsg = $this->get_var("select count(is_trash) from message_dashboard_tb where send_to = '".$this->current_userid()."' and is_trash = 1");
		$this->set('trash', $trashmsg);
		
		#count how many sent msg
		$sentmsg = $this->get_var("select count(sender_user_id) from message_dashboard_tb where sender_user_id = '".$this->current_userid()."'");
		$this->set('msgsent', $sentmsg);

		// FETCHING ALL THE trash MESSAGE, SENDER AND DISPLAY IN trash
		$msgtrashed = $this->fetch("select u.*, m.* from user_tb as u inner join message_dashboard_tb as m on u.id = m.sender_user_id 
			where m.send_to = '".$this->current_userid()."' and m.is_trash = 1 order by m.id desc");
		$this->set('msgtrash', $msgtrashed);

		#FETCHING ALL THE MESSAGE ALREADY READ BY THE RECEPIENT AND unread msg DISPLAY IN INBOX
		$readmsg = $this->fetch("select u.*, m.* from user_tb as u inner join message_dashboard_tb as m on u.id = m.sender_user_id 
			where m.send_to = '".$this->current_userid()."' and m.is_trash = 0 order by m.id desc");
		$this->set('msgread', $readmsg);


		#FETCHING HOW MANY SENT MESSAGE OF A USER
		$sentMsgDisplayed = $this->fetch("select u.*, m.* from user_tb as u inner join message_dashboard_tb as m on u.id = m.sender_user_id 
			where m.sender_user_id  = '".$this->current_userid()."' order by m.id desc");
		$this->set('sentMsg', $sentMsgDisplayed);
			
	}#messages


	public function newmessages(){
		$this->set('title','New Message - '.SYS_NAME);
		$this->render('messages_newmessage');
	}#newmessages


	public function messagestrash(){
		$this->set('title','Archive Message - '.SYS_NAME);
		$this->render('messages_archive');		
	}#messagestrash

	public function inbox(){
		$this->set('title','Inbox Message - '.SYS_NAME);
		$this->render('messages_inbox');
	}#inbox

	public function messagesent(){
		$this->set('title','New Message - '.SYS_NAME);
		$this->render('message_sent');
	}#sentitem

	public function viewmessage(){
		$this->set('title','View Message - '.SYS_NAME);
		$this->render('message_view');

		$viewmsg = $this->fetch("select u.*, m.* from user_tb as u inner join message_dashboard_tb as m on u.id = 									 m.sender_user_id 
								 where m.id = '".(int)$_REQUEST['uri_data']['msgid']."'",ture);
		$this->set('viewmessages', $viewmsg);

		if(!empty($_REQUEST['uri_data']['msgid'])){

			$this->update('message_dashboard_tb',array(
				  "is_read" => 1),array("id" => (int)$_REQUEST['uri_data']['msgid']));

			 #count how many unread messages
			$unread = $this->get_var("select count(is_read) from message_dashboard_tb where send_to = '".$this->current_userid()."' and is_read = 0 ");
			$this->set('unreads', $unread);
		}
	
	}#viewmessage

	public function sentviewmessage(){
		$this->set('title','Sent items Message - '.SYS_NAME);
		$this->render('message_sentview');

		$viewmsg = $this->fetch("select u.*, m.* from user_tb as u inner join message_dashboard_tb as m on u.id = 									 m.sender_user_id 
								 where m.id = '".(int)$_REQUEST['uri_data']['msgid']."'",ture);
		$this->set('viewSentMessages', $viewmsg);

		
	
	}#viewmessage

	
	public function msgInsert(){
				
		$recepient = $_POST['to'];
		$subject = $_POST['subject'];
		$msgContent = $_POST['message'];
		$date = strtotime(date('Y-m-d h:i:s e'));
		
		if($recepient <> ""){

		#getting the user id using email address of the user
		$sendto = $this->fetch("select * from user_tb where email ='".$recepient."'",true);

				#if there is no error in storing then it will add the parent message id
				if($this->insert('message_dashboard_tb',array(
								"subject" => $subject,
								"content" => $msgContent,
								"sender_user_id" => $this->current_userid(),
								"send_to" => $sendto['id'],
								"is_read" => "0",
								"is_trash" => "0",
								"date_sent" => $date
							))
					)
				{

					$mail = new Skmail();
					//bawal ang negative opacity
					$r = $mail->send_mail(array(
							'subject'=>$subject,
							'content'=> $msgContent,
							'to'=> array(
										array("name"=>$sendto['firstname'],"email"=> $sendto['email'])
									),
							//we comment from to make admin sender.
							'from' => array('name'=>$_SESSION['currentLogin']['firstname'],'email'=>$_SESSION['currentLogin']['email'])
								));
					if(!$r){
						echo'Error: '.$r;
					}else{
						$this->set('msgAlert','<div class="alert alert-success"><strong>Success!</strong> Message has been sent!</div>');
						$this->render('messages');

					}#else								
			
				}else{
					$this->set('msgAlert','<div class="alert alert-danger"><strong>Oh snap!</strong> Please contact your Administrator.</div>');
					$this->render('messages_newmessage');
				}#else	

		}else{
			$this->set('msgAlert','<div class="alert alert-warning"><strong>Hola!</strong> Please put recepient and subject before sending a message.</div>');
			$this->render('messages_newmessage');
		}

		#count how many unread messages
		$unread = $this->get_var("select count(is_read) from message_dashboard_tb where send_to = '".$this->current_userid()."' and is_read = 0 ");
		$this->set('unreads', $unread);

		#count how many sent msg
		$sentMsgDisplayed = $this->fetch("select u.*, m.* from user_tb as u inner join message_dashboard_tb as m on u.id = m.sender_user_id 
		where m.sender_user_id  = '".$this->current_userid()."' order by date_sent ASC");
		$this->set('sentMsg', $sentMsgDisplayed);

	}#msgInsert

	public function replymsg()
	{
		$recepientid = $_REQUEST['uri_data']['sendto'];
		$subject = $_POST['subject'];
		$msgContent = $_POST['content'];
		$date = strtotime(date('Y-m-d h:i:s e'));

		if($this->insert('message_dashboard_tb',array(
			"send_to" => $recepientid,
			"subject" => $subject,
			"content" => $msgContent,
			"date_sent" => $date,
			"sender_user_id" => $this->current_userid()))
		)
		{
			$this->set('msgAlert','<div class="alert alert-success"><strong>Success!</strong> Message has been sent!</div>');
					$this->render('messages');

			$sentMsgDisplayed = $this->fetch("select u.*, m.* from user_tb as u inner join message_dashboard_tb as m on u.id = m.sender_user_id 
							where m.sender_user_id  = '".$this->current_userid()."' order by date_sent ASC");
					$this->set('sentMsg', $sentMsgDisplayed);			
			
			$unread = $this->get_var("select count(is_read) from message_dashboard_tb where send_to = '".$this->current_userid()."' and is_read = 0 and is_trash = 0");
			$this->set('unreads', $unread);
		}else{

				$this->set('msgAlert','<div class="alert alert-danger"><strong>Oh snap!</strong> Please contact your Administrator.</div>');
				$this->render('messages');
		}
	}#replymsg
	
	public function archivemsg()
	{

		if(is_array($_POST['ids'])){
			foreach($_POST['ids'] as $p){
				
				//update message to set as trash
				$this->update("message_dashboard_tb",array(
					"is_trash" => 1,
					"is_read" =>1,
					"is_trash" => 1,
					"is_archive" =>1) ,array(
					"id" => (int)$p)); 
			}
		}	
		$readmsg = $this->fetch("select u.*, m.* from user_tb as u inner join message_dashboard_tb as m on u.id = m.sender_user_id 
		where m.send_to = '".$this->current_userid()."' and m.is_trash = 0 order by m.id desc");
		$this->set('msgread', $readmsg);
		$this->render('messages_inbox_ajax');
	}

	public function deletemsg()
	{

		if(is_array($_POST['ids'])){
			foreach($_POST['ids'] as $p){
				
				//update message to set as trash
				$this->query("delete from message_dashboard_tb where is_trash = 1 and  id='".(int)$p."'");	

				
			}
			$trashmsg = $this->get_var("select count(is_trash) from message_dashboard_tb where send_to = '".$this->current_userid()."' and is_trash = 1");
				$this->set('trash', $trashmsg);
		}	

		$this->render('messages_inbox_ajax');
	}


	public function sentitemdelete()
	{

		if(is_array($_POST['ids'])){
			foreach($_POST['ids'] as $p){
				
				//update message to set as trash
				$this->query("delete from message_dashboard_tb where id='".(int)$p."'");	

				
			}
			$sentMsgDisplayed = $this->fetch("select u.*, m.* from user_tb as u inner join message_dashboard_tb as m on u.id = m.sender_user_id 
			where m.sender_user_id  = '".$this->current_userid()."' order by m.id desc");
			$this->set('sentMsg', $sentMsgDisplayed);
		}	

		$this->render('messages_sent');
	}


	
}#class
?>