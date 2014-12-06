<?php 	$this->isloggedin();
		$this->headers();  ?>
	<div class="contentwrap">
			<div class="page-header">
				<h1 >Hire people <small> That helps you in your project.</small></h1>
				<?php echo $data['msgAlert'];?>
			</div>

	<?php 
		if($_POST['processhire']<>""){

			//hire this freelancer
			$project = $this->fetch("select * from project_tb where id='".$_POST['project']."'",true);
			$freelancer = $this->fetch("select * from user_tb where id='".$data['request']['uri_data']['freelancer']."'",true);

			/*add this selected user to this company*/
							if($this->get_var("select count(*) from company_user where
										company_id ='".$project['company_id']."' AND
										user_id ='".$freelancer['id']."' AND
										isFixed ='".(($project['isfixed']=="1")?1:0)."' 
									")<1){
								$this->insert("company_user",array(
										"user_id"=>(int)$freelancer['id'],
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
											user_id='".$freelancer['id']."'"
										)==0){
								if($this->insert("project_user_tb",
											array("project_id"=>$project['id'],"user_id"=>$freelancer['id']))){
									
								}
							}
						}else{

							/*Assign freelancer to fix project*/
							$this->update("project_tb",
											array('assignedto_userid'=>$freelancer['id']),
											array('id'=>$project['id'])
										);
						}


						 $mail2 = new Skmail();
						 $r=$mail2->send_mail(array(
						 		'subject' =>'You have been added to a project in '.SYS_NAME,
						 		'to'=> array(array("name"=>$project['firstname'],"email"=> $project['email'])),
						 		'content'=>'<p>Hello '.$project['firstname'].',</p>
						 					<p>You have been invited to start a project by '.$_SESSION['currentLogin']['firstname']. ' '.$_SESSION['currentLogin']['lastname'].'</p>
						 					<p>Below are the details:</p>
						 					<p>'.$this->clean($project['name']).'</p>
						 					<p>'.$this->clean($project['description']).'</p>
						 					<p>Login with your '.SYS_NAME.' account at '.BASE_URL.' to start with this project.</p>
						 					' 
						 	));
						 if(!$r){
						 	$msg = $r;
						 }

			?>
			 <div class="alert alert-success"><strong>Horrah!</strong> You have hired <?php echo $freelancer['firstname'].' '.$freelancer['lastname']; ?> successfully. Notifications are now being sent.</div>
			 <?php

		}
		if($data['request']['uri_data']['freelancer']<>"" and $_POST['processhire']==""){

			$fr = $this->fetch("select * from user_tb where id='".$data['request']['uri_data']['freelancer']."'",true);
			?>
				<script type="text/javascript">
					jQuery(function($){
						$('#hirefreelancernow').modal('show');
					});
				</script>
				<!-- Modal -->
				<div class="modal fade" id="hirefreelancernow" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				  <div class="modal-dialog">
				    <div class="modal-content">
				      <div class="modal-header">
				        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				        <h4 class="modal-title" id="myModalLabel">Hire <?php echo ucwords($fr['firstname'].' '.$fr['lastname']); ?></h4>
				      </div>
				      <form method="post" action="">
					      <div class="modal-body">
					         <h5>What projects you want to offer to <?php echo ucwords($fr['firstname']); ?>?</h5>
					         <?php
					         	$p = $this->fetch("select * from project_tb where user_id='".$this->current_userid()."' and is_active='1'");
					         	if(!empty($p)){
					         		echo'<select name="project" class="form-control">';
					         		foreach($p as $a){
					         			echo'<option value="'.$a['id'].'">'.$a['name'].'</option>';
					         		}
					         		echo'</select>';

					         	}
					         ?>
					      </div>
					      <div class="modal-footer">
					        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					        <button type="submit" name="processhire" value="true" class="btn btn-primary">Hire</button>
					      </div>
				  	  </form>
				    </div>
				  </div>
				</div>
			<?php

		}
		?>
	   <div class="row-fluid">	
		
			<div class="col-md-8 col-md-offset-1">
				<?php include_once('hire_people_searchbar.php');?>
			 </div><!-- /.col-lg-8 -->

			 <div class="col-md-8 col-md-offset-1">
				<?php if(empty($data['sfreelancer'])){
					echo '<div class="alert alert-warning">No matched criteria.</div>';
				}else{  
					foreach ($data['sfreelancer'] as $freelance) { ?>
					
						
						<div  class="col-md-12" style="border-bottom:1px solid #B9BCC3; padding:10px">
							<div class="col-md-1">
								<a href="<?php echo BASE_URL.'profile/sprofile/sid/'.$freelance['user_id'].'/'; ?>">
									<?php if($freelance['image_filename']==""){ ?>
									<img class="img-round" src="<?php echo BASE_URL_PUBLIC; ?>images/defaultuser.jpg" style="width:50px; height:auto; margin: 0px auto;">
									<?php }else{ ?>
									<img class="img-round" src="<?php echo BASE_URL_PUBLIC; ?>images/profileimage/<?php echo $freelance['image_filename']; ?>" style="width:50px; height:auto; margin: 0px auto;">
									<?php } ?>
								</a>
							</div>
							

							<div class="col-md-11">
								<div  style="margin-bottom:5px"><strong><?php echo $freelance['firstname'] ?></strong></div>
								<div  style="margin-bottom:5px"><?php if($freelance['country']<>""){ echo $this->country($freelance['country']); }?></div>
								<div style="color:#428bca;">
									<div><?php $avgstar = $this->fetch("SELECT avg(stars) as stars, count(*) as reviews 
										FROM `review_tb` where user_id='".$freelance['user_id']."'",true);

												for($x=1;$x<=(int)$avgstar['stars'];$x++){
										     			 								?>
										     			 								<span class="glyphicon glyphicon-star starreviewsmall red"></span>
										     			 								<?php
										     			 							}
										     			 							for($x=1;$x<=(5-(int)$avgstar['stars']); $x++){
										     			 								?>
										     			 								<span class="glyphicon glyphicon-star-empty starreviewsmall"></span>
										     			 								<?php
										     			 							}

										     	echo (int)$avgstar['reviews'];

											?> reviews</div>						
									<div style="margin-top:5px"><div class="label label-default">skills</div> <?php echo str_ireplace($data['request']['freelancer'], '<strong style="color:red"><em>'.$data['request']['freelancer'].'</em></strong>',$freelance['meta_value']);?></div>
								</div>

								
								<div style="margin-top:10px">
										<p>
											<a href="<?php echo BASE_URL;?>profile/sprofile/sid/<?php echo $freelance['user_id']?>/">
												<label class="label label-info" style="cursor:pointer; font-size:10px">See full profile</label>
											</a>

											<!-- <a href="<?php echo BASE_URL;?>find-work/repost/postid/<?php echo $data['viewpost']['id']; ?>/">
												<label class="label label-success" style="cursor:pointer; font-size:10px">Send message</label>
											</a> -->
											<?php if(!empty($_SESSION)){ 
												if($this->get_var("select count(*) 
													from project_tb where user_id='".$this->current_userid()."' and is_active='1'")>0){
											?>
												<!-- <a href="#" data-toggle="modal" data-target="#myModal<?php echo $freelance['user_id'];?>" >
													<label class="label label-success" style="cursor:pointer; font-size:10px">Send message</label>
												</a> -->
												<a href="<?php echo BASE_URL.'hire-people/invite/freelancer/'.$freelance['user_id'].'/'; ?>">
													<label class="label label-success" style="cursor:pointer; font-size:10px">Hire</label>
												</a>
											<?php } } ?>
										</p>


										<div class="modal fade" id="myModal<?php echo $freelance['user_id'];?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
										  <div class="modal-dialog">
										    <div class="modal-content" style="width:800px; margin-left:-100px; margin-top:100px">
										      <div class="modal-header">
										        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
										        <h4 class="modal-title" id="myModalLabel">Message</h4>
										      </div>
										      <div class="modal-body">
										      	<form method="post" action="<?php echo BASE_URL;?>hire-people/pmfreelance/">
										      	
										      	<input type="hidden" name="email" value="<?php  echo $freelance['email'];?>">
										      	<input type="hidden" name="userid" value="<?php  echo $freelance['user_id'];?>">
										      	<input type="hidden" name="fname" value="<?php  echo $freelance['firstname'];?>">

										      	<h5>To : <?php echo $freelance['firstname'];?></h5>
										      	<h5>Subject: <input type="text" class="form-control" name="freelancrsubject"></h5>
										      		
										    		<textarea name="content" class="form-control" rows="10" style="overflow:hidden height:auto; resize:vertical">Greeting! Would you like to join our team?</textarea>
										    	
										      </div>
										      <div class="modal-footer">
										        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
										        <button type="submit" class="btn btn-success">Send</button>
										      </form>
										      </div>
										    </div><!-- modal-content -->
										  </div><!-- modal-dialog -->
										</div> <!-- modal -->


								</div>
							</div>
						</div>

					
							

				<?php } } ?>
			 	
			 </div><!-- /.col-lg-8 -->
			

		<div class="clearfix"></div>	
		</div><!-- rowfluid -->
	</div> <!-- Contentwrap -->



<?php $this->footers();  ?>