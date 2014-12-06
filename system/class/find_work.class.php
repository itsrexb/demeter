<?php
 /*
package: Centraleffects Framework
Author:  Marc Comia
Website: Centraleffects.com
Company: Centraleffects BPO
*/


class find_work extends Pages
{
	public function find_work()
	{
		$this->set('title','Find Work - '.SYS_NAME);
		$this->render('find_work');

		

	/*	$jobpost = $this->fetch("SELECT * FROM jobs_tb order by id desc");
		
		$this->set('jobspost', $jobpost);*/

		#to display unread msg
		$unread = $this->get_var("select count(is_read) from message_dashboard_tb where send_to = '".$this->current_userid()."' and is_read = 0 and is_trash = 0");
		$this->set('unreads', $unread);

	}

	public function postjob(){
		$this->set('title','Post a Job - '.SYS_NAME);
		$this->render('find_work_postjob');

		if($_SERVER['REQUEST_METHOD']=='POST'){

			if($this->insert('jobs_tb',array(
				"position_title" => $this->clean($_POST['ptitle']),
				"description" => $_POST['description'],
				"postedby_user_id" => $this->current_userid(),
				"date_added" => strtotime(date('Y-m-d h:i:s e')),
				"location" => $_POST['Location'],
				"rate" => $_POST['srate'],
				"is_hourly" => $_POST['sContract']))
			){

				$mail = new Skmail();
					//bawal ang negative opacity
					$r = $mail->send_mail(array(
							'subject'=>$_POST['ptitle'],
							'content'=> $_POST['description'],
							'to'=> array(
										array("name"=>$_SESSION['currentLogin']['fname'],"email"=> $_SESSION['currentLogin']['email'])
									),
							//we comment from to make admin sender.
							//'from' => array('name'=>$_SESSION['currentLogin']['firstname'],'email'=>$_SESSION['currentLogin']['email'])
								));
					if(!$r){
						echo'Error: '.$r;
					}else{
						
					}#else								
				$jobpost = $this->fetch("SELECT * FROM jobs_tb order by id desc");
				$this->set('jobspost', $jobpost);

					$this->set('msgAlert','<div class="alert alert-success"><strong>Success!</strong> Post Job</div>');
					$this->render('find_work');
			}else{
					$this->set('msgAlert','<div class="alert alert-danger"><strong>Oh snap!</strong> Please contact your Administrator.</div>');
					$this->render('find_work_postjob');
				 }#else	
		}
	}#jobpost


	public function repost(){
		$this->set('title','Re-Post a Job - '.SYS_NAME);
		$this->render('find_work_updatepost');

		#if true fetch many.
		$repost = $this->fetch("SELECT * FROM jobs_tb where postedby_user_id = '".$this->current_userid()."' and id='".(int)$_REQUEST['uri_data']['postid']."'",true);
		$this->set('reposts', $repost);

	}#repost

	public function deletepost()
	{
		$this->set('title','View Post - '.SYS_NAME);
		$this->render('find_work');

		// delete post
		// $sql = "Delete From jobs_tb Where id = '".$_POST['delpostid']."'";
		
		$sql = "Delete From jobs_tb Where id = '".(int)$_REQUEST['uri_data']['postid']."'";
		mysql_query($sql);
		
		//to display again the entire job post
		$jobpost = $this->fetch("SELECT * FROM jobs_tb order by id desc");
				$this->set('jobspost', $jobpost);
		
	}#deletepost



	public function modifiedpost(){
		$this->set('title','Post a Job - '.SYS_NAME);
		$this->render('find_work_updatepost');

		
		if($_SERVER['REQUEST_METHOD']=='POST'){

			if($this->update('jobs_tb',array(
				"position_title" => $this->clean($_POST['ptitle']),
				"description" => $_POST['description'],				
				"date_added" => strtotime(date('Y-m-d h:i:s e')),
				"location" => $_POST['Location'],
				"rate" => $_POST['srate'],
				"is_hourly" => $_POST['sContract']),array(
				"id" => $_POST['id']))
				){

				$mail = new Skmail();
					//bawal ang negative opacity
					$r = $mail->send_mail(array(
							'subject'=>'Modefied Post Job '.$_POST['ptitle'],
							'content'=> $_POST['description'],
							'to'=> array(
										array("name"=>$_SESSION['currentLogin']['fname'],"email"=> $_SESSION['currentLogin']['email'])
									),
							//we comment from to make admin sender.
							//'from' => array('name'=>$_SESSION['currentLogin']['firstname'],'email'=>$_SESSION['currentLogin']['email'])
								));
					if(!$r){
						echo'Error: '.$r;
					}else{
						
					}#else								
				$jobpost = $this->fetch("SELECT * FROM jobs_tb order by id desc");
				$this->set('jobspost', $jobpost);

					$this->set('msgAlert','<div class="alert alert-success"><strong>Success!</strong> Update Post Job</div>');
					$this->render('find_work');
			}else{
					$this->set('msgAlert','<div class="alert alert-danger"><strong>Oh snap!</strong> Please contact your Administrator.</div>');
					$this->render('find_work_postjob');
				 }#else	
		}
		echo"empty";
	}#updatepost


	
	public function viewpost()
	{
		$this->set('title','View Post - '.SYS_NAME);
		$this->render('find_work_viewpost');

		/*//$postview = $this->fetch("select u.firstname, u.email, j.position_title, j.id, j.postedby_user_id, j.description, j.date_added, j.rate, j.location
								 from user_tb as u inner join jobs_tb as j on u.id = j.postedby_user_id
								 where j.id = '".(int)$_REQUEST['uri_data']['postid']."'",ture);
		//$this->set('viewpost', $postview);*/
	}#submitpost


	public function applysubmit(){
		$this->set('title','post a Job - '.SYS_NAME);
		$this->render('find_work');
		
		$sendto = $this->fetch("select * from user_tb where id ='".$_POST['user_id']."'",true);

		if(!empty($_POST['coverletter']))
		{

			/*$true = $this->insert(' message_dashboard_tb',array(
						 "subject" => "Applying for".$_POST['ptitle'],
						 "content" => $_POST['coverletter'],
						 "sender_user_id" => $this->current_userid(),
						 "send_to" => $sendto['id'],
						 "is_read" => "0",
						 "is_trash" => "0",
						 "date_sent" => strtotime(date('Y-m-d h:i:s e'))

					));*/
			$true = $this->insert('applicants',array(
					"user_id"=>$_POST['user_id'],
					"applicant_id"=>$_POST['applicant_id'],
					"project_id"=>$_POST['project_id'],
					"message"=>$_POST['coverletter'],
					"date_added"=>strtotime(date('Y-m-d h:i:s e'))
				));

			if($true){
					$mail = new Skmail();
					//bawal ang negative opacity
					$mail->send_mail(array(
							'subject'=>'Applying for'.' '.$_POST['name'],
							'content'=> $_POST['coverletter'],
							'to'=> array(
										array("name"=>$sendto['firstname'],"email"=> $sendto['email'])
									),
							//we comment from to make admin sender.
							'from' => array('name'=>$_SESSION['currentLogin']['firstname'],'email'=>$_SESSION['currentLogin']['email'])
								));
					$this->set('msgAlert','<div class="alert alert-success"><strong>Great!</strong> We are in the process of reviewing the qualifications of all candidates for this position and we will contact you should your skills match the required qualifications. .</div>');
					$this->render('find_work');
			}

		}else{
			$this->set('msgAlert','<div class="alert alert-danger"><strong>Ooops!</strong> Cover letter is empty.</div>');
			$this->render('find_work');
		}

	}

	public function jobsearch()
	{
		$this->set('title','View Post - '.SYS_NAME);
		$this->render('find_work_search');
		$jobs = $this->clean($_POST['searchjobs']);

		$jobsearch = $this->fetch("SELECT * FROM jobs_tb 
						WHERE lower(position_title) LIKE '%".strtolower($this->clean($_POST['searchjobs']))."%' OR lower(description) 
						like '%".strtolower($this->clean($_POST['searchjobs']))."%' OR lower(location) Like '%".strtolower($this->clean($_POST['searchjobs']))."%'");
		$this->set('searchjob', $jobsearch);
		
	}

}#class
?>