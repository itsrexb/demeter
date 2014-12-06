<?php
 /*
package: Centraleffects Framework
Author: Rex Bengil
Website: Centraleffects.com
Company: Centraleffects BPO
*/

class company extends Pages
{
	public function company()
	{
		$this->set('title','Company - '.SYS_NAME);
		$this->render('company');
		
		#to display unread msg
		$unread = $this->get_var("select count(is_read) from message_dashboard_tb where send_to = '".$this->current_userid()."' and is_read = 0 and is_trash = 0");
		$this->set('unreads', $unread);
		

		if($_POST['company']<>"" and !isset($_POST['update'])){
			if($this->get_var("select count(*) from company_tb where name = '".$this->clean($_POST['company'])."'",true)==0){
				$filename = "";
				
				$res = $this->insert('company_tb',array(
					"name" => $this->clean($_POST['company']),
					"url" => $this->clean($_POST['url']),
					"owner" => $this->current_userid(),
					"email" => $this->clean($_POST['email']),
					"telephone" => $this->clean($_POST['telephone']),
					"address" => $this->clean($_POST['address']),
					"logo" => $filename,
					"date_added" => date('Y-m-d h:i:s')
				));
				if($res){
					$this->set('msg','<div class="alert alert-success"><strong>Success!</strong> You can now start inviting people in your company.</div>');

				}else{
					$this->set('msg','<div class="alert alert-danger"><strong>Error!</strong> Please review your submitted company info.</div>');
				}
			}
			
		}
		//do not execute this during remove to prevent multiple queries to our database
		if($_REQUEST['subpage']<>"remove"){
			//get companies attached to user
			$companies = $this->fetch("select cm.*,cu.position,cu.date_joined,cu.is_active 
				from company_user cu
				left join company_tb cm on cm.id = cu.company_id 
				where cu.user_id='".$this->current_userid()."'
				and cm.name<>''
			");
			
			$owncompanies =  $this->fetch("select * from company_tb where owner = '".$this->current_userid()."'");
			
			$this->set('companies',$companies);
			$this->set('own_companies',$owncompanies);
		}
		
	}
	public function view()
	{
		$this->set('view',$this->fetch("select * from company_tb where id='".(int)$_REQUEST['uri_data']['id']."'",true));
		if($_POST["invite"]<>""){
			if($this->get_var("select email from user_tb where id='".$this->current_userid()."'")<>$_POST["invite"]){
			//select from user
			$u = $this->fetch("select id,firstname from user_tb where email ='".$this->clean($_POST["invite"])."'",true);
			
			$f = $this->get_var("select count(*) from company_user 
						where 
						(email ='".$this->clean($_POST["invite"])."'
						".(($u["id"]<>'')?"
						or
						user_id='".$u["id"]."'
						":"")."
						)
						and
						company_id='".(int)$_REQUEST['uri_data']['id']."'
						");

			if($f==0){
				if(empty($u)){
				
					//send email here for invites
					$res = $this->insert("company_user",array(
						"company_id" =>(int)$_REQUEST['uri_data']['id'],
						"email"=>$this->clean($_POST["invite"]),
						"is_active"=>0
					));
					if($res){
						$this->set('msg','<div class="alert alert-success"><strong>Success!</strong> Your invitation to '.$this->clean($_POST["invite"]).' has been sent.</div>');
						
						$mail = new Skmail();
								#bawal ang negative opacity
								$r = $mail->send_mail(array(
											'subject'=>'You are invited to join '.SYS_NAME,
											'content'=>'<p>Hi '.$_POST['invite'].',
											</p>	
												<p>visit '.BASE_URL.' for more details.</p>',

												'to'=> array(
															array('name'=>$_POST['invite'],'email'=> $_POST['invite'])
															) ,

												#we comment from to make admin sender.
												'from' => array('name'=>'Demeter Time-Tracking','email'=>'rex@centraleffects.com')
												));

					}
				}else{
					$res = $this->insert("company_user",array(
						"company_id" =>(int)$_REQUEST['uri_data']['id'],
						"user_id"=>$u["id"],
						"is_active"=>0
					));
					$this->set('msg','<div class="alert alert-success"><strong>Success!</strong> Your invitation to '.$u["firstname"].' has been sent.</div>');
				}
			}else{
				$this->set('msg','<div class="alert alert-danger"><strong>Oh Snap!</strong> Adding more than once is prohibited.</div>');
			}

			}else{
				$this->set('msg','<div class="alert alert-danger"><strong>Oh Snap!</strong> You cannot invite yourself.</div>');
			}

		}
		
		//remove user from company
		if($_REQUEST['uri_data']['removeuser']<>"")
		{
			if($this->query("delete from company_user where id='".(int)$_REQUEST['uri_data']['removeuser']."'")){
				if($this->affected_rows()){
					$this->set('msg','<div class="alert alert-success"><strong>Success!</strong> You have removed 1 user from your company.</div>');
				}
			}
		}
		
		//remove company
		if($_REQUEST['uri_data']['removecompany']<>"")
		{
			echo'sdasdad';
			$this->redirect('company/remove/id/'.$_REQUEST['uri_data']['removecompany'].'/');
		}
		
		//update employee info of a company
		if(!empty($_POST['einfo'])){
			if($this->update("company_user",array(
					"position"	=> $_POST['einfo']['position'],
					"rate" =>$_POST['einfo']['rate']
				),array(
					"id"=>$_POST['einfo']['employee_id']
				))){
					$this->set('msg','<div class="alert alert-success"><strong>Success!</strong> Employee details for this company updated.</div>');
			}else{
				$this->set('msg','<div class="alert alert-danger"><strong>Error!</strong> Please review your submitted company info.</div>');
			}

		}


		//create new projects
		if($_POST['createnewproject']<>"" and  $_POST['projectname']<>"")
		{
			if($this->get_var("select count(*) from project_tb where name='".$this->clean($_POST['projectname'])."'")==0)
			{
				if($_POST['issearchable']=="1"){ $description=$_POST['description'].'<p> Desired Skills: <br>'.$_POST['desiredskills'].'</p>'; }
				else{ $description=$_POST['description'];}
				
				if($this->insert("project_tb",array(
					"name"	=> $this->clean($_POST['projectname']),
					"description"	=> $this->clean($description,true),
					"user_id"	=> $this->current_userid(),
					"company_id"	=> (int)$_REQUEST['uri_data']['id'],
					"isfixed"	=>(($_POST['isfixed']=="1")?1:0),
					"total_price" =>floatval($_POST['price']),
					"assignedto_userid"=>(($_POST['isfixed']=="1")?(($_POST['responsible']<>"")?$_POST['responsible']:$_POST['responsiblefreelancer']):0),
					"total_payable_price"=>floatval($_POST['price']),
					"isSearchable"=>(($_POST['issearchable']=="1")?1:0),
					"location"=>$_POST['location'],
					"isnegotiable"=>$_POST['isnegotiable'],
					"duration"=>$_POST['duration'],
					"needed"=>$_POST['needed'],
					"date_added"=>strtotime(date('Y-m-d h:i:s e'))
				
				))){
					
					/*  send email to freelancer */

					if($_POST['responsiblefreelancer']<>""){
						/*add this selected user to this company*/
						if($this->get_var("select count(*) from company_user where
									company_id ='".(int)$_REQUEST['uri_data']['id']."' AND
									user_id ='".(int)$_POST['responsiblefreelancer']."' AND
									isFixed ='".(($_POST['isfixed']=="1")?1:0)."' 
								")<1){
							$this->insert("company_user",array(
									"user_id"=>(int)$_POST['responsiblefreelancer'],
									"company_id"=>(int)$_REQUEST['uri_data']['id'],
									"is_active"=>1,
									"isFixed"=>(($_POST['isfixed']=="1")?1:0)
								));
						}
					}
					if($_POST['responsiblefreelancer']<>""){ $id=$_POST['responsiblefreelancer']; }
					if($_POST['responsible']<>""){ $id=$_POST['responsible']; }
					$recvr = $this->fetch("select * from user_tb 
						where 
						id ='".$id."'",true);
					$emp =$this->fetch("select * from user_tb 
						where 
						id ='".$this->current_userid()."'",true); 
					if($_POST['responsiblefreelancer']<>"" || $_POST['responsible']<>""){
					 $mail = new Skmail();
					 $r=$mail->send_mail(array(
					 		'subject' =>'You have been invited to start a project',
					 		'to'=> array(array('name'=>$recvr['firstname']. ' '.$recvr['lastname'],'email'=> $recvr['email'])),
					 		'content'=>'<p>Hello '.$recvr['firstname'].',</p>
					 					<p>You have been invited to start a project by '.$_SESSION['currentLogin']['firstname']. ' '.$_SESSION['currentLogin']['lastname'].'</p>
					 					<p>Below are the details:</p>
					 					<p>'.$this->clean($_POST['description']).'</p>
					 					<p>Login with your '.SYS_NAME.' account at '.BASE_URL.' to start with this project.</p>
					 					' 
					 	));

					 //send to message board
					 $this->insert('message_dashboard_tb',array(
								 "subject" => 'You have been invited to start a project',
								 "content" =>'<p>Hello '.$recvr['firstname'].',</p>
					 					<p>You have been invited to start a project by '.$_SESSION['currentLogin']['firstname']. ' '.$_SESSION['currentLogin']['lastname'].'</p>
					 					<p>Below are the details:</p>
					 					<p>'.$this->clean($_POST['description']).'</p>
					 					<p>Login with your '.SYS_NAME.' account at '.BASE_URL.' to start with this project.</p>
					 					' ,
								 "sender_user_id" => $this->current_userid(),
								 "send_to" => $id,
								 "is_read" => "0",
								 "is_trash" => "0",
								 "date_sent" => strtotime(date('Y-m-d h:i:s e'))

							));

					 if(!$r){
					 	$msg = $r;
					 }
					}

					$msg .='<div class="alert alert-success"><strong>Success!</strong> You have just created a new project. Start adding task now!</div>';
					$this->set('msg',$msg);
				}else{
					$this->set('msg','<div class="alert alert-danger"><strong>Oh Snap!</strong> Please review your information before to submit or Contact your System Administration.</div>');
				}
				//save to database
			}else{
				$this->set('msg','<div class="alert alert-danger"><strong>Oh Snap!</strong> Adding more than once is prohibited.</div>');
			}
		}

		//display attached user to this company
		$this->set("fixemployees",$this->fetch("select a.*,a.id as employee_id,a.rate as rates,
				b.firstname,b.lastname,b.image_filename
				from company_user a 
				left join user_tb b on b.id = a.user_id 
				where 
				a.company_id='".(int)$_REQUEST['uri_data']['id']."' AND
				a.isFixed='1'
				"));

		$this->set("hourlyemployees",$this->fetch("select a.*,a.id as employee_id,a.rate as rates,
				b.firstname,b.lastname,b.image_filename
				from company_user a 
				left join user_tb b on b.id = a.user_id 
				where 
				a.company_id='".(int)$_REQUEST['uri_data']['id']."' AND
				a.isFixed='0'
				"));
		
		if($_POST['changeassignee']<>""){
			if($this->update('project_tb',array('assignedto_userid'=>$_POST['responsible']),array('id'=>$_POST['projectid']))){
				$this->set('msg','<div class="alert alert-success"><strong>Horrah!</strong> You have updated successfully your project.</div>');
			}else{
					$this->set('msg','<div class="alert alert-danger"><strong>Oh Snap!</strong> Please review your information before to submit or Contact your System Administration.</div>');
				}
		}

		/*Assign freelancer to hourly project */
		if($_POST['assignfreelancerstohourlyproject']<>""){
			if($this->get_var("select count(*) from project_user_tb 
						where 
							project_id='".$_POST['projectid']."' AND
							user_id='".$_POST['responsible']."'"
						)==0){
				if($this->insert("project_user_tb",
							array("project_id"=>$_POST['projectid'],"user_id"=>$_POST['responsible']))){
					$this->set('msg','<div class="alert alert-success"><strong>Horrah!</strong> You have updated successfully your project.</div>');
				}else{
						$this->set('msg','<div class="alert alert-danger"><strong>Oh Snap!</strong> Please review your information before to submit or Contact your System Administration.</div>');
					}
			}
		}		
	}
	public function edit()
	{
		if($_POST['company']<>""){
			$filename = "";
					
			$res = $this->update('company_tb',array(
				"name" => $this->clean($_POST['company']),
				"url" => $this->clean($_POST['url']),
				"owner" => $this->current_userid(),
				"email" => $this->clean($_POST['email']),
				"telephone" => $this->clean($_POST['telephone']),
				"address" => $this->clean($_POST['address']),
				"logo" => $filename,
				"date_added" => date('Y-m-d h:i:s')
			),array(
				"id"=>(int)$_REQUEST['uri_data']['id']
			));
			if($res){
				if($this->affected_rows()){
					$this->set('msg','<div class="alert alert-success"><strong>Success!</strong> Company details updated.</div>');
				}
			}else{
				$this->set('msg','<div class="alert alert-danger"><strong>Error!</strong> Please review your submitted company info.</div>');
			}
		}
		
		$this->set('edit',$this->fetch("select * from company_tb where id='".(int)$_REQUEST['uri_data']['id']."'",true));
	}
	public function remove()
	{
		if($this->query("delete from company_tb where id='".(int)$_REQUEST['uri_data']['id']."'")){
				if($this->affected_rows()){
					$this->set('msg','<div class="alert alert-success"><strong>Success!</strong> You have removed 1 company from your list.</div>');
				}
			}
		//get companies attached to user
		$companies = $this->fetch("select cm.*,cu.position,cu.date_joined,cu.is_active 
			from company_user cu
			left join company_tb cm on cm.id = cu.company_id 
			where cu.user_id='".$this->current_userid()."'
		");
		
		$owncompanies =  $this->fetch("select * from company_tb where owner = '".$this->current_userid()."'");
		
		$this->set('companies',$companies);
		$this->set('own_companies',$owncompanies);

	}

	public function searchfreelancer(){
		$sfreelance = $this->fetch("SELECT 
										u.*, umeta.*
								   FROM 
								   		user_meta_tb umeta inner join user_tb u on umeta.user_id = u.id 
								   WHERE 
									   (umeta.meta_key = 'skills' and lower(umeta.meta_value) LIKE '%".strtolower($_POST['q'])."%') 
									   order by (select avg(stars) from review_tb where user_id=u.id) DESC");

		$this->set('sfreelancer', $sfreelance);
		$this->set('ishourly',$_POST['ishourly']);
		$this->render('searchpeopleajax');
	}
}
?>