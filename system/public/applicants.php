<?php	$this->headers();  ?>
<div class="contentwrap">
	<div class="page-header">
		<h1>Review Applicants<small> that matches your needs.</small></h1>
		<?php 
			echo $data['msg'];
				if($_SERVER['REQUEST_METHOD']=='POST'){
					if($_POST['hirethisfreelancer']<>""){

						//hire this freelancer
						$project = $this->fetch("select * from project_tb where id='".$_POST['project_id']."'",true);

							/*add this selected user to this company*/
							if($this->get_var("select count(*) from company_user where
										company_id ='".$project['company_id']."' AND
										user_id ='".$_POST['applicant_user_id']."' AND
										isFixed ='".(($project['isfixed']=="1")?1:0)."' 
									")<1){
								$this->insert("company_user",array(
										"user_id"=>(int)$_POST['applicant_user_id'],
										"company_id"=>(int)$project['company_id'],
										"is_active"=>1,
										"isFixed"=>(($project['isfixed']=="1")?1:0)
									));
							}
							

						/*Assign freelancer to hourly project */
						if($project['isfixed']=="0"){
							if($this->get_var("select count(*) from project_user_tb 
										where 
											project_id='".$project['id']."' AND
											user_id='".$_POST['applicant_user_id']."'"
										)==0){
								if($this->insert("project_user_tb",
											array("project_id"=>$project['id'],"user_id"=>$_POST['applicant_user_id']))){
									
								}
							}
						}else{

							/*Assign freelancer to fix project*/
							$this->update("project_tb",
											array('assignedto_userid'=>$_POST['applicant_user_id']),
											array('id'=>$project['id'])
										);
						}
						


						$this->update('applicants',array("date_responded"=>strtotime(date('Y-m-d h:i:s e'))),array("id"=>$_POST['applicant_id']));

						/* remove from applications */
						$mail = new Skmail();

						$mail->send_mail(array(
								'subject'=>'Re: Applying for'.' '.$_POST['name'],
								'content'=> '<p>Hi '.$_POST['applicant_name'],', <br> 
											Congratulations! You are hired with your application.</p>
											<p><em>'.str_replace('\n','\n->',$_POST['message']).'<em></p>
											<p>To check this out, Login your '.SYS_NAME.' account at '.BASE_URL.'</p>',
								'to'=> array(
											array("name"=>$_POST['applicant_name'],"email"=> $_POST['applicant_email'])
										),
								'from' => array('name'=>$_SESSION['currentLogin']['firstname'],'email'=>$_SESSION['currentLogin']['email'])
									));

						 $mail2 = new Skmail();
						 $r=$mail2->send_mail(array(
						 		'subject' =>'You have been added to a project in '.SYS_NAME,
						 		'to'=> array(array("name"=>$_POST['applicant_name'],"email"=> $_POST['applicant_email'])),
						 		'content'=>'<p>Hello '.$_POST['applicant_name'].',</p>
						 					<p>You have been invited to start a project by '.$_SESSION['currentLogin']['firstname']. ' '.$_SESSION['currentLogin']['lastname'].'</p>
						 					<p>Below are the details:</p>
						 					<p>'.$this->clean($project['name']).'</p>
						 					<p>'.$this->clean($project['description']).'</p>
						 					<p>Login with your '.SYS_NAME.' account at '.BASE_URL.' to start with this project.</p>
						 					' 
						 	));

						 $this->insert('message_dashboard_tb',array(
								 "subject" => 'Re: Applying for'.' '.$_POST['name'],
								 "content" => '<p>Hi '.$_POST['applicant_name'],', <br> 
											Congratulations! You are hired with your application.</p>
											<p><em>'.str_replace('\n','\n->',$_POST['message']).'<em></p>
											<p>To check this out, Login your '.SYS_NAME.' account at '.BASE_URL.'</p>',
								 "sender_user_id" => $this->current_userid(),
								 "send_to" => $_POST['applicant_user_id'],
								 "is_read" => "0",
								 "is_trash" => "0",
								 "date_sent" => strtotime(date('Y-m-d h:i:s e'))

							));

						 $this->insert('message_dashboard_tb',array(
								 "subject" => 'You have been added to a project in '.SYS_NAME,
								 "content" => '<p>Hello '.$_POST['applicant_name'].',</p>
						 					<p>You have been invited to start a project by '.$_SESSION['currentLogin']['firstname']. ' '.$_SESSION['currentLogin']['lastname'].'</p>
						 					<p>Below are the details:</p>
						 					<p>'.$this->clean($project['name']).'</p>
						 					<p>'.$this->clean($project['description']).'</p>
						 					<p>Login with your '.SYS_NAME.' account at '.BASE_URL.' to start with this project.</p>
						 					' ,
								 "sender_user_id" => $this->current_userid(),
								 "send_to" => $_POST['applicant_user_id'],
								 "is_read" => "0",
								 "is_trash" => "0",
								 "date_sent" => strtotime(date('Y-m-d h:i:s e'))

							));

						 if(!$r){
						 	$msg = $r;
						 }

						 ?>
						 <div class="alert alert-success"><strong>Horrah!</strong> You have hired <?php echo $_POST['applicant_name']; ?> successfully. Notifications are now being sent.</div>
						 <?php
					}

				}
				
				if($data['request']['uri_data']['ignorefree']<>""){
					$this->update('applicants',array("date_responded"=>strtotime(date('Y-m-d h:i:s e'))),
					array("id"=>$data['request']['uri_data']['appid']));
				
				}
				
		?>
	</div>
	<div class="row contentwrap">
		
		<div class="panel-group" id="accordion">
			<?php 

				$apps = $this->fetch('select a.id as app_id,b.*,a.project_id,a.date_added as appdateadded,a.message,a.date_responded
								from applicants a left join user_tb b on b.id = a.applicant_id where date_responded = 0 order by a.id DESC');

				if(!empty($apps)){
					foreach($apps as $a){
						$p = $this->fetch("Select * from project_tb where id='".$a['project_id']."'",true);
						?>
						  <div class="panel <?php if($a['date_responded']<>'0'){ ?>panel-default<?php }else{ ?>panel-info<?php } ?>">
						    <div class="panel-heading">
						      <h4 class="panel-title">
						        <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $a['app_id']; ?>">
						          	<div class="col-md-1" style="width:30px;height:30px;overflow:hidden;margin-right:5px;margin-bottom:5px;">										<?php $img=$a['image_filename']; if($img==""){ ?>
										<img class="img-round" src="<?php echo BASE_URL_PUBLIC; ?>images/defaultuser.jpg" style="width:100%; height:auto; margin: 0px auto;">
										<?php }else{ ?>
										<img class="img-round" src="<?php echo BASE_URL_PUBLIC; ?>images/profileimage/<?php echo $img; ?>" style="width:100%; height:auto; margin: 0px auto;">
										<?php } ?>
									</div>
									<div class="col-md-11">
											<div>
												<span><?php echo ucwords($a['firstname'].' '.$a['lastname']); ?> 
												<small>Applied for <?php echo $p['name'];?></small>
												</span>
											</div>
											<div><small  style="font-size:10px;"><?php echo $this->timeago($a['appdateadded']); ?></small></div>
									</div>
									<div class="clearfix"></div>
						        </a>
						      </h4>
						    </div>
						    <div id="collapse<?php echo $a['app_id']; ?>" class="panel-collapse collapse">
						      <div class="panel-body">
						        	<div><p><?php echo nl2br($a['message']); ?></p></div>
						        	<div style="margin-top:20px">
						        		<form method="post" action="">
						        			<input type="hidden" name="project_id" value="<?php echo $p['id']; ?>">
						        			<input type="hidden" name="applicant_id" value="<?php echo $a['app_id']; ?>">
						        			<input type="hidden" name="applicant_user_id" value="<?php echo $a['id']; ?>">
						        			<input type="hidden" name="applicant_email" value="<?php echo $a['email']; ?>">
						        			<input type="hidden" name="applicant_name" value="<?php echo ucwords($a['firstname'].' '.$a['lastname']); ?>">
						        			<input type="hidden" name="message" value="<?php echo $a['message']; ?>">
						        			<input type="hidden" name="name" value="<?php echo $p['name']; ?>">
											
											<a target="_blank" href="<?php echo BASE_URL; ?>profile/sprofile/sid/<?php echo $a['id']; ?>/" class="btn btn-success btn-sm">View Profile</a> 
						        			<a  href="<?php echo BASE_URL; ?>applicants/ignore/ignorefree/<?php echo $a['id']; ?>/appid/<?php echo $a['app_id']; ?>/" class="btn btn-danger btn-sm">Ignore</a>
											<?php 
											$project = $this->fetch("select * from project_tb where id='".$p['id']."'",true);

											if($a['date_responded']=='0'){ 
												if((int)$project['needed'] > (int)$this->get_var("select count(*) 
													from project_user_tb where project_id='".$p['id']."'")){
												?>
												<button type="submit" name="hirethisfreelancer" value="true" class="btn btn-primary btn-sm">Hire this Freelancer</button>
												<?php 
												}else{
													if((int)$project['isfixed']==0){
														echo'Needed Manpower has been filled already.';
													}else{
														?>
														<button type="submit" name="hirethisfreelancer" value="true" class="btn btn-primary btn-sm">Hire this Freelancer</button>
														<?php 
													}
												}
											}else{
						        				echo 'Responded: <span class="label label-success"> '.$this->timeago($a['date_responded']).'</span>';
						        			} ?>
						        		</form>
						        	</div>
						      </div>
						    </div>
						  </div>
				  <?php 
			  			}
					}else{
					?>
					<div class="alert alert-info">No Applicants at this time.</div>
					<?php
					} ?>

		</div>

	</div>
</div>
<?php	$this->footers();  ?>