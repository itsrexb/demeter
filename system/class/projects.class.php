<?php
 /*
package: Centraleffects Framework
Author: Rex Bengil
Website: Centraleffects.com
Company: Centraleffects BPO
*/

class projects extends Pages
{
	public function projects()
	{
		$this->set('title','Projects - '.SYS_NAME);
		$this->render('projects');
		
		#to display unread msg
		$unread = $this->get_var("select count(is_read) from message_dashboard_tb where send_to = '".$this->current_userid()."' and is_read = 0 and is_trash = 0");
		$this->set('unreads', $unread);

		if($_REQUEST['subpage']<>"view"){
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
			
	}
	public function view()
	{
		$this->set('view',$this->fetch("select * from company_tb where id='".(int)$_REQUEST['uri_data']['companyid']."'",true));
		
		//create new projects
		if($_POST['createnewproject']<>"" and  $_POST['projectname']<>"")
		{
			if($this->get_var("select count(*) from project_tb where name='".$this->clean($_POST['projectname'])."'")==0)
			{
				if($this->insert("project_tb",array(
					"name"	=> $this->clean($_POST['projectname']),
					"description"	=> $this->clean($_POST['description']),
					"user_id"	=> $this->current_userid(),
					"company_id"	=> (int)$_REQUEST['uri_data']['companyid'],
					"isfixed"	=>(($_POST['isfixed']=="1")?1:0),
					"total_price" =>floatval($_POST['price']),
					"assignedto_userid"=>(($_POST['isfixed']=="1")?$_POST['responsible']:0),
					"total_payable_price"=>floatval($_POST['price'])
				
				))){
					$this->set('msg','<div class="alert alert-success"><strong>Success!</strong> You have just created a new project. Start adding task now!</div>');
				}else{
					$this->set('msg','<div class="alert alert-danger"><strong>Oh Snap!</strong> Please review your information before to submit or Contact your System Administration.</div>');
				}
				//save to database
			}else{
				$this->set('msg','<div class="alert alert-danger"><strong>Oh Snap!</strong> Adding more than once is prohibited.</div>');
			}
		}

		if($_REQUEST['uri_data']['projectview']==""){
			//get list of projects
			$this->set("projects",$this->fetch("select * from project_tb where company_id='".(int)$_REQUEST['uri_data']['companyid']."' order by id DESC"));
		}
		if($_REQUEST['uri_data']['projectview']<>""){
			//get details of selected project
			$this->set("projectview",$this->fetch("select * from project_tb where id='".(int)$_REQUEST['uri_data']['projectview']."' order by id DESC",true));
		}
		
		//Display attached freelancer to company
		$this->set("freelancer",$this->fetch("SELECT b.id,b.firstname,b.lastname,b.email 
			FROM `company_user` a left join user_tb b on b.id = a.user_id 
			WHERE a.company_id='".(int)$_REQUEST['uri_data']['companyid']."' and  a.email='' and a.isFixed='0'"));
		
		
		//create new milestone
		
		if($_POST['milestonename']<>"" and !isset($_POST['updatemilestone'])){
			if($this->get_var("select count(*) from milestone_tb where name='".$this->clean($_POST['milestonename'])."'")==0)
			{
				if($this->insert("milestone_tb",array(
					"project_id"	=> (int)$_REQUEST['uri_data']['projectview'],
					"name"	=> $this->clean($_POST['milestonename']),
					"description"	=> $this->clean($_POST['description']),
					"date_added" => date('Y-m-d h:i:s'),
					"addedby_user_id" => $this->current_userid(),
					"assigned_to_userid" => $this->clean($_POST['responsible']),
					'date_due'	=> date('Y-m-d h:i:s',strtotime($this->clean($_POST['duedate'])))
				))){
					$this->set('msg','<div class="alert alert-success"><strong>Success!</strong> You have just created a new milestone. Start adding task now!</div>');
				}else{
					$this->set('msg','<div class="alert alert-danger"><strong>Oh Snap!</strong> Please review your information before to submit or Contact your System Administration.</div>');
				}
				
			}else{
				$this->set('msg','<div class="alert alert-danger"><strong>Oh Snap!</strong> Adding more than once is prohibited.</div>');
			}
		}

		//only show this when editing milestone
		if($_REQUEST['uri_data']['editmilestone']<>""){
			$this->set("editmilestone",$this->fetch("select * from milestone_tb
						where id='".(int)$_REQUEST['uri_data']['editmilestone']."'",true));
		}
		
		//update milestone
		if(isset($_POST['updatemilestone']) and $_POST['milestonename']<>""){
			if($this->update("milestone_tb",array(
					"project_id"	=> (int)$_REQUEST['uri_data']['projectview'],
					"name"	=> $this->clean($_POST['milestonename']),
					"description"	=> $this->clean($_POST['description']),
					"date_added" => date('Y-m-d h:i:s'),
					"addedby_user_id" => $this->current_userid(),
					"assigned_to_userid" => $this->clean($_POST['responsible']),
					'date_due'	=> date('Y-m-d h:i:s',strtotime($this->clean($_POST['duedate'])))
				),array(
					"id"	=> (int)$_REQUEST['uri_data']['updatemilestone']
				))){
					$this->set('msg','<div class="alert alert-success"><strong>Success!</strong> You have just created a new milestone. Start adding task now!</div>');
				}else{
					$this->set('msg','<div class="alert alert-danger"><strong>Oh Snap!</strong> Please review your information before to submit or Contact your System Administration.</div>');
				}
				
		}
		
		//delete milestone
		if($_REQUEST['uri_data']['deletemilestone']<>"")
		{	
			if($this->query("delete from milestone_tb where id ='".(int)$_REQUEST['uri_data']['deletemilestone']."'")){
				if($this->affected_rows()>0){
					$this->set('msg','<div class="alert alert-warning"><strong>Success!</strong> You have just deleted 1 milestone.</div>');
				}
			}
		}
		//complete milestone
		if($_REQUEST['uri_data']['milestonecomplete']<>"")
		{
			if($this->update("milestone_tb",array(
				"is_completed"=>1,
				"date_completed"=>date('Y-m-d h:i:s')
				),array(
					"id"=>$_REQUEST['uri_data']['milestonecomplete']
				))){
				$this->set('msg','<div class="alert alert-success"><strong>Congrats!</strong> You have just completed 1 milestone.</div>');
			}
		}
		//uncomplete milestone
		if($_REQUEST['uri_data']['milestoneuncomplete']<>"")
		{
			if($this->update("milestone_tb",array(
				"is_completed"=>0,
				"date_completed"=>"0000-00-00 00:00:00"
				),array(
					"id"=>$_REQUEST['uri_data']['milestoneuncomplete']
				))){
				$this->set('msg','<div class="alert alert-warning"><strong>Oh Snap!</strong> Milestone status back to incomplete.</div>');
			}
		}
		
		//display list of milestone
		$milestone = $this->fetch("select a.*,
						(select CONCAT(firstname,' ',lastname) from user_tb where id=a.addedby_user_id) as author,
						(select CONCAT(firstname,' ',lastname) from user_tb where id=a.assigned_to_userid ) as responsible
						from milestone_tb a
						where a.project_id='".(int)$_REQUEST['uri_data']['projectview']."'
						order by a.date_due,is_completed ASC
						");
		$this->set("milestones",$milestone);

		
		//add task
		if($_POST['taskname']<>""){
			$data = array(
				"milestone_id"	=>$this->clean($_POST['taskmilestone']),
				"name"	=>$this->clean($_POST['taskname']),
				"description"	=>$this->clean($_POST['taskdescription']),
				"addedby_userid"	=>$this->current_userid(),
				"assignedto_userid"	=>$this->clean($_POST['responsible']),
				"project_id"=>(int)$_REQUEST['uri_data']['projectview'],
				"time_duration"=>$_POST['time_duration'],
				"start_date"	=>(($_POST['taskstartdate']<>"")?date('Y-m-d h:i:s',strtotime($this->clean($_POST['taskstartdate']))):'0000-00-00 00:00:00'),
				"date_due"	=>(($_POST['taskduedate']<>"")?date('Y-m-d h:i:s',strtotime($this->clean($_POST['taskduedate']))):'0000-00-00 00:00:00'));
			
			//save data to database
			if($_REQUEST['uri_data']['edittask']=="")
			{
				if($this->insert("task_tb",$data)){
					if($_POST['tasknotifyemail']<>""){
						//send email notification here
						
					}
					
					$this->set('msg','<div class="alert alert-success"><strong>Success!</strong> Task has been added.</div>');
				}else{
					$this->set('msg','<div class="alert alert-danger"><strong>Oh Snap!</strong> Please review your information before to submit or Contact your System Administration.</div>');
				}
			}else{
				if($this->update("task_tb",$data,array('id'=>(int)$_REQUEST['uri_data']['edittask']))){
					if($_POST['tasknotifyemail']<>""){
						//send email notification here
						
					}
					
					$this->set('msg','<div class="alert alert-success"><strong>Success!</strong> Task has been updated.</div>');
				}else{
					$this->set('msg','<div class="alert alert-danger"><strong>Oh Snap!</strong> Please review your information before to submit or Contact your System Administration.</div>');
				}
			
			}
		}
		
		
		if($_REQUEST['uri_data']['edittask']<>"" and $_REQUEST['uri_data']['update']=="")
		{
			$this->set('edittask',$this->fetch("select a.*,
				(select id from user_tb where id=a.assignedto_userid ) as responsible
				from task_tb a where a.id ='".(int)$_REQUEST['uri_data']['edittask']."'
			",true));
		}
		
		//complete task
		if($_REQUEST['uri_data']['taskcomplete']<>"")
		{
			if($this->update("task_tb",array(
				"is_done"=>1,
				"date_completed"=>date('Y-m-d h:i:s')
				),array(
					"id"=>$_REQUEST['uri_data']['taskcomplete']
				))){
				$this->set('msg','<div class="alert alert-success"><strong>Congrats!</strong> You have just completed a task.</div>');
			}
		}
		
		
		//uncomplete task
		if($_REQUEST['uri_data']['taskuncomplete']<>"")
		{
			if($this->update("task_tb",array(
				"is_done"=>0,
				"date_completed"=>"0000-00-00 00:00:00"
				),array(
					"id"=>$_REQUEST['uri_data']['taskuncomplete']
				))){
				$this->set('msg','<div class="alert alert-warning"><strong>Oh Snap!</strong> task status back to incomplete.</div>');
			}
		}
		
		//delete task
		if($_REQUEST['uri_data']['deletetask']<>"")
		{
			if($this->query("delete from task_tb where id ='".(int)$_REQUEST['uri_data']['deletetask']."'")){
				$this->set('msg','<div class="alert alert-success"><strong>Success!</strong> Task has been deleted.</div>');
			}
		}
		
		//display task.
		if(!empty($milestone)){
			$task = array();
			$mm = array();
			foreach($milestone as $m){
				$mm = $m;
				$mm['tasks'] = $this->fetch("select a.*,
				(select CONCAT(firstname,' ',lastname) from user_tb where id=a.addedby_userid) as author,
				(select CONCAT(firstname,' ',lastname) from user_tb where id=a.assignedto_userid ) as responsible
				from task_tb a where milestone_id='".$m['id']."' order by is_done ASC");
				$task[] =$mm;
			}
			$this->set("tasklist",$task);
		}else{
				$task = array();
				$mm = array();
				$mm['name'] = 'Default Milestone';
				$mm['tasks'] = $this->fetch("select a.*,
				(select CONCAT(firstname,' ',lastname) from user_tb where id=a.addedby_userid) as author,
				(select CONCAT(firstname,' ',lastname) from user_tb where id=a.assignedto_userid ) as responsible
				from task_tb a where milestone_id='0' and project_id='".(int)$_REQUEST['uri_data']['projectview']."' order by is_done ASC");
				$task[] =$mm;
				$this->set("tasklist",$task);
		}

		//add new message to our project
		if($_POST['createnewmessage']<>""){
			//prevent message from duplicates
			if($this->get_var("select count(*) from messages_tb where 
							subject='".$this->clean($_POST['subject'])."' AND
							content='".$this->clean($_POST['content'])."' AND
							createdby_user_id='".$this->current_userid()."' AND
							project_id = '".(int)$_REQUEST['uri_data']['projectview']."'
						")>0){
				$this->set('msg','<div class="alert alert-warning"><strong>Oh snap!</strong> Duplicate message is not allowed. Please write a new one.</div>');

			}else{

				if($this->insert('messages_tb',array(
						'project_id'	=> (int)$_REQUEST['uri_data']['projectview'],
						'subject'		=>$this->clean($_POST['subject']),
						'content'		=>$this->clean($_POST['content']),
						'createdby_user_id' => $this->current_userid(),
						'date_added'	=> strtotime(date('Y-m-d h:i:s e'))
					))){

					$this->set('msg','<div class="alert alert-success"><strong>Success!</strong> Your message has been published.</div>');
					
					$message_id = $this->last_inserted_id();
					
					if($message_id<>""){
						//add people  to this message
						if(is_array($_POST['people']))
						{
							foreach($_POST['people'] as $p){
								$this->insert('message_user_tb',array(
										'message_id' =>$message_id,
										'added_user_id'=>$p,
										'date_added'=>date('Y-m-d h:i:s')
									));
							}

							/*send notification to selected person*/
							$recvr = $this->fetch("select * from user_tb 
								where 
								id ='".$p."'",true);
								$emp =$this->fetch("select * from user_tb 
									where 
									id ='".$this->current_userid()."'",true); 
								 $mail = new Skmail();
								 $r=$mail->send_mail(array(
								 		'subject' =>$this->clean($_POST['subject']),
								 		'to'=> array(array('name'=>$recvr['firstname']. ' '.$recvr['lastname'],'email'=> $recvr['email'])),
								 		'content'=>'<p>'.$this->clean($_POST['content']).'</p>
								 					<p>Login with your '.SYS_NAME.' account at '.BASE_URL.' to start with this project.</p>
								 					' 
								 	));
								 if(!$r){
								 	$msg = $r;
								 }
						}

						$this->insert('message_user_tb',array(
										'message_id' =>$message_id,
										'added_user_id'=>$this->current_userid(),
										'date_added'=>date('Y-m-d h:i:s')
									));

					}
					
				}
			}
		}



		if($_SERVER['REQUEST_METHOD']=='POST' and $_POST['amount']<>""){
	  		if(floatval($_POST['amount'])<1){
	  			$this->set("msg",'<div class="alert alert-danger"><strong>Oh snap!</strong> Please provide valid amounts.</div>');
	  		}
	  	}

	  	//add offline logs to database
	  	if($_SERVER['REQUEST_METHOD']=='POST'){
	  		if($_POST['tasknotes']<>""){
			  		if($this->get_var("select count(*) from timelogs_tb
			  				where 
			  				log_date='".date('Y-m-d',strtotime($_POST['log_date']))."' and
			  				log_hour='".$_POST['log_hour']."' and
			  				log_minute='".$_POST['log_minute']."' and
			  				user_id ='".$this->current_userid()."'
			  			")<1){
				  		if($this->insert("timelogs_tb",array(
				  				"task_id"	=>$_POST['task_id'],
				  				"project_id" =>$_REQUEST['uri_data']['projectview'],
				  				"user_id"	=>$this->current_userid(),
				  				"log_date"	=>date('Y-m-d',strtotime($_POST['log_date'])),
				  				"log_hour"	=>$_POST['log_hour'],
				  				"log_minute"	=>$_POST['log_minute'],
				  				"date_added"	=>strtotime(date('y-m-d h:i:s e')),
				  				"is_offline"	=>1,
				  				"notes"	=> $_POST['tasknotes']

				  			))){
				  			$this->set("msg",'<div class="alert alert-success"><strong>Congratulations!</strong> Offline time has been added to your diary.</div>');
				  		}else{
				  			$this->set("msg",'<div class="alert alert-danger"><strong>Oh Snap!</strong> Error in adding offline time.</div>');
				  		}
		  		}else{
		  			if($this->update("timelogs_tb",array(
				  				"task_id"	=>$_POST['task_id'],
				  				"project_id" =>$_REQUEST['uri_data']['projectview'],
				  				"user_id"	=>$this->current_userid(),
				  				"log_date"	=>date('Y-m-d',strtotime($_POST['log_date'])),
				  				"log_hour"	=>$_POST['log_hour'],
				  				"log_minute"	=>$_POST['log_minute'],
				  				"date_added"	=>strtotime(date('y-m-d h:i:s e')),
				  				"is_offline"	=>1,
				  				"notes"	=> $_POST['tasknotes']

				  			),
		  					array(
		  						"log_date"=>date('Y-m-d',strtotime($_POST['log_date'])),
			  					"log_hour"=>$_POST['log_hour'],
			  					"log_minute"=>$_POST['log_minute'],
			  					"user_id"=>$this->current_userid()
		  						)
		  					)){
				  			$this->set("msg",'<div class="alert alert-success"><strong>Congratulations!</strong> Offline time has been updated.</div>');
				  		}else{
				  			$this->set("msg",'<div class="alert alert-danger"><strong>Oh Snap!</strong> Error in updating offline time.</div>');
				  		}
		  		}
		  	}
	  	}

	  	/*delete time log entry */
	  	if($_REQUEST['uri_data']['deleteentry']<>""){
	  		$entry = explode("a",$_REQUEST['uri_data']['deleteentry']);
	  		foreach($entry as $e){
	  			if($e<>""){
			  		if($this->delete("timelogs_tb",
			  				array('id'=>(int)$e)
			  				)){
			  			
			  		}
		  		}
	  		}
	  		if($this->affected_rows()>0){
	  			$this->set("msg",'<div class="alert alert-success"><strong>Congratulations!</strong> Offline time entry has been deleted.</div>');
	  		}
	  	}	  	
		
	}

	function setcompleted(){

		$this->update('task_tb',array('completed'=>$_POST['completed']),array('id'=>$_POST['id']));

		$this->render('ajaxmessages');
	}
	function savenotes(){
		$fname = $this->get_var("select firstname from user_tb where id='".$this->current_userid()."'");
		$this->query("update task_tb set notes = CONCAT('*".$fname.' : '.date('m/d/y h:i:s')."\n\n".$this->clean($_POST['notes']).":\n\n-------------------\n\n',notes) where id ='".(int)$_POST['id']."'");
		$this->render('ajaxmessages');
	}

	/*This is to return attached companies to user for apps */
	function appgetcompany(){

		//get companies attached to user
			$companies = $this->fetch("select cm.id,cm.name
				from company_user cu
				left join company_tb cm on cm.id = cu.company_id 
				where cu.user_id='".(int)$_REQUEST['uri_data']['userid']."'
			");
			
			$owncompanies =  $this->fetch("select id,name from company_tb where owner = '".(int)$_REQUEST['uri_data']['userid']."'");

			$str="";
			$id = array();
			if(!empty($companies)){
				foreach($companies as $c){
					$str.= $c['id'].'~'.$c['name'].'^';
					$id[] = $c['id'];
				}
			}

			if(!empty($owncompanies)){
				foreach($owncompanies as $c){
					if(!in_array($c['id'], $id)){
						$str.= $c['id'].'~'.$c['name'].'^';
						$id[] = $c['id'];
					}
					
				}
			}

			$str= substr($str,0,strlen($str)-1);

			$this->set('json',$str);

			$this->render('json');

	}
	/*This is return projects for a certain user */
	function appgetprojects(){

		$projects = $this->fetch("select * from project_tb where company_id='".(int)$_REQUEST['uri_data']['companyid']."' and isfixed='0' order by is_active DESC");

		$str="";
			$id = array();
			if(!empty($projects)){
				foreach($projects as $c){
					$str.= $c['id'].'~'.$c['name'].'^';
					$id[] = $c['id'];
				}
			}

			$str= substr($str,0,strlen($str)-1);

			$this->set('json',$str);

			$this->render('json');
	}

	function appgetmilestones(){
			$task = $this->fetch("select a.* from milestone_tb a where project_id='".(int)$_REQUEST['uri_data']['projectid']."' and is_completed='0'");
			$str="";
				$id = array();
				if(!empty($task)){
					foreach($task as $c){
						$str.= $c['id'].'~'.$c['name'].'^';
						$id[] = $c['id'];
					}
				}

				$str= substr($str,0,strlen($str)-1);

				$this->set('json',$str);

				$this->render('json');
		
	}
	function appgettasks(){

		$task = $this->fetch("select a.* from task_tb a where milestone_id='".(int)$_REQUEST['uri_data']['milestoneid']."' and is_done='0'");
		$str="";
			$id = array();
			if(!empty($task)){
				foreach($task as $c){
					$str.= $c['id'].'~'.$c['name'].'$'.$c['completed'].'^';
					$id[] = $c['id'];
				}
			}

			$str= substr($str,0,strlen($str)-1);

			$this->set('json',$str);

			$this->render('json');
	}

	function appgettaskscompletion(){
		$str = $this->get_var("select a.completed from task_tb a where id='".(int)$_REQUEST['uri_data']['taskid']."'");
		$this->set('json',$str);
		$this->render('json');
	}
	function appsetcompletion(){

		if($this->update("task_tb",
					array(
							"completed"=>$_POST['completion'],
							"is_done"=>(($_POST['isfinished']=="True")?1:0)
						),
					array(
							"id"=>$_POST['taskid']
						)
					)){
			$str = "Task Completion Status Updated!";
		}else{
			$str= "Error in completing your request. Please contact demeter support center";
		}

		$this->set('json',$str);
		$this->render('json');
	}

	function appsetnotes(){

		$fname = $this->get_var("select firstname from user_tb where id='".(int)$_POST['userid']."'");
		if($this->query("update task_tb set notes = CONCAT('*".$fname.' : '.date('m/d/y h:i:s')."\n\n".$this->clean($_POST['notes']).":\n\n-------------------\n\n',notes) where id ='".(int)$_POST['taskid']."'")){
			$str = "Your notes has been added!";
		}else{
			$str= "Error in completing your request. Please contact demeter support center";
		}

		$this->set('json',$str);
		$this->render('json');
	}

	function workdiarytimeslotinfo(){
		$timelogs = $this->fetch("select * from timelogs_tb 
							where 
							project_id='".$_POST['projectid']."' and
							log_minute ='".$_POST['logminute']."' and 
							log_hour='".$_POST['loghour']."' and 
							log_date='".(($_POST['logdate']<>"")?date('Y-m-d',strtotime($_POST['logdate'])):date('Y-m-d'))."' and
							user_id ='".$_POST['userid']."'

					",true);
		$this->set('json',json_encode($timelogs));
		$this->render('json');
	}

	function apptimelog(){
		$this->pr($_POST);
	 if($this->get_var("select count(*) from timelogs_tb
			  				where 
			  				log_date='".date('Y-m-d',strtotime($_POST['log_date']))."' and
			  				log_hour='".$_POST['log_hour']."' and
			  				log_minute='".$_POST['log_minute']."' and
			  				user_id ='".$_POST["user_id"]."'
			  			")>0)
	 {
	 	 $this->set('json',"");
	 }else{
			if($this->insert("timelogs_tb",array(
					"app_opentabs"	=> str_replace(",","<br>* ", $_POST["app_opentabs"]),
					"app_keystroke"=> $_POST["app_keystroke"],
					"app_mouseclick"=> $_POST["app_mouseclick"],
					"log_hour"=> $_POST["log_hour"],
					"log_date"=> $_POST["log_date"],
					"log_minute"=> $_POST["log_minute"],
					"task_id"=> $_POST["task_id"],
					"project_id"=> $_POST["project_id"],
					"user_id"=> $_POST["user_id"],
					"notes"=> $_POST["notes"],
					"is_offline"=> '0',
					"is_billed"=>'0',
					"date_added"=> strtotime(date('Y-m-d h:i:s e')),
					"screenshot_id"=> $_POST["screenshot_id"]
					)))
			{
				$this->set('json',$res);
			}else{
				$this->set('json',$res);
			}
		}
		$this->render('json');
	}
}
?>