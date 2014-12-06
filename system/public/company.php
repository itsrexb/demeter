<?php $this->isloggedin(); $this->headers();  ?>
<script>
	jQuery(document).ready(function($){
		$('.taskchkbx').click(function(){
			var id=$(this).data('id');
			if($(this).is(':checked')){
				location.href='<?php echo BASE_URL; ?>company/view/id/<?php echo $data['request']['uri_data']['id'];?>/projectcomplete/'+id+'/';
			}else{
				location.href='<?php echo BASE_URL; ?>company/view/id/<?php echo $data['request']['uri_data']['id'];?>/projectuncomplete/'+id+'/';
			}
		});
	});
</script>
<div class="row-fluid contentwrap">
	<div class="page-header">
	  <h1>Companies <small>manage your company or invite people</small></h1>
	</div>
	<div class="row-fluid">
		<?php 
			echo $data['msg'];
			
			/*complete project */
			if($data['request']['uri_data']['projectcomplete']<>""){
				if($this->update("project_tb",array('is_active'=>0),array('id'=>$data['request']['uri_data']['projectcomplete'])))
				{

						$project = $this->fetch("select * from project_tb where id ='".$data['request']['uri_data']['projectcomplete']."'",true);

						if($this->current_userid() <> $project['user_id']){
							$this->insert('message_dashboard_tb',array(
								 "subject" => "Project Completed",
								 "content" => $_SESSION['currentLogin']['firstname']." has already completed ".$project['name'],
								 "sender_user_id" => $this->current_userid(),
								 "send_to" => $project['user_id'],
								 "is_read" => "0",
								 "is_trash" => "0",
								 "date_sent" => strtotime(date('Y-m-d h:i:s e'))

							));

						}

					?>
					<div class="alert alert-success">
							<strong><span class="glyphicon glyphicon-exclamation-sign"></span> Horrah!</strong>
							You have successfully completed the project.
					</div>
					<?php
				}
			}

			if($data['request']['uri_data']['projectuncomplete']<>""){
				if($this->update("project_tb",array('is_active'=>1),array('id'=>$data['request']['uri_data']['projectuncomplete'])))
				{
					?>
					<div class="alert alert-warning">
							<strong><span class="glyphicon glyphicon-exclamation-sign"></span> Horrah!</strong>
							You have changed the project status back to active or incomplete.
					</div>
					<?php
				}
			}

			if($data['request']['uri_data']['id']<>""){
					/* check freelancers if there rates and position has not been filled-up*/
					$checkemp = $this->fetch("select a.*,a.id as employee_id,a.rate as rates,
						b.firstname,b.lastname,b.image_filename
						from company_user a 
						left join user_tb b on b.id = a.user_id 
						where 
						a.company_id='".(int)$data['request']['uri_data']['id']."' AND
						a.isFixed='0' AND (a.rate='' OR a.position='')
						");
					if(!empty($checkemp)){
						?>
						<div class="alert alert-danger">
							<strong><span class="glyphicon glyphicon-exclamation-sign"></span> Heads up!</strong>
							Company owner  must fill the rate and position for the following hourly freelancer:
							<div style="margin-left:26px;margin-top: 10px;">
								<?php 
								foreach($checkemp as $f){
									?>
										<div style="width:30px;background:#000;height:30px;overflow:hidden;float:left;margin-right:5px;margin-bottom:5px;">
										 		<a class="imgsssmallicon" data-toggle="tooltip" data-placement="right" title="<?php echo ucwords($f['firstname'].' '.$f['lastname']); ?>" target="_blank" href="<?php echo BASE_URL.'profile/sprofile/sid/'.$f['user_id'].'/'; ?>">
												<?php if($f['image_filename']==""){ ?>
												<img class="img-round" src="<?php echo BASE_URL_PUBLIC; ?>images/defaultuser.jpg" style="width:100%; height:auto; margin: 0px auto;">
												<?php }else{ ?>
												<img class="img-round" src="<?php echo BASE_URL_PUBLIC; ?>images/profileimage/<?php echo $f['image_filename']; ?>" style="width:100%; height:auto; margin: 0px auto;">
												<?php } ?>
											</a>
										 </div>	
									<?php
								}
								?> 
								<div class="clearfix"></div>
							</div>
						</div>
						<?php
					}
			}/*end if $data['request']['uri_data']['id'] is not empty*/
			$haspaid = $this->get_user_meta($this->current_userid(),"_paycompany_",true);
				if($haspaid=="")
				{
					global $CFG;
					?>
					<div class="panel panel-success col-md-3" style="margin-left:10px;">
						 <div class="panel-heading">
							<h3 class="panel-title">Start your company now.<br> <small class="alert-danger">Pay only $<?php echo $CFG['start_payment_for_company']; ?> to create one or more.</small></h3>
						  </div>
						  <div class="panel-body">
						  		<form method="post" action="<?php echo $CFG['paypal']['submit_url']; ?>">
						  			<input type="hidden" name="custom" value="_paycompany_$<?php echo $this->current_userid(); ?>">
						  			<input type="hidden" name="on1" value="">
						  			<input type="hidden" name="business" value="<?php echo $CFG['paypal']['email']; ?>"> 
					                <input type="hidden" name="item_name" value="Payment for creating a company with <?php echo SYS_NAME; ?>"> 
					                
					                <input type="hidden" name="amount" value="<?php echo $CFG['start_payment_for_company']; ?>"> 
					                <input type="hidden" name="return" value="<?php echo BASE_URL.'company/paypal-success/redirect/thank-you/'; ?>">
					                <input type="hidden" name="cmd" value="_xclick">
					                <input type="hidden" name="quantity" value="1">
					                <input type="hidden" name="cancel_return" value="<?php echo BASE_URL.'company/'; ?>" />
					                
							  		<h4>
							  			Amount to pay : $<?php echo $CFG['start_payment_for_company']; ?>
							  		</h4>
							  		<div class="mdescrptn" style="margin-bottom:15px;">
							  			<strong>Note:</strong>	This is a non-refundable transaction.
							  		</div>
							  		<p>
							  			<button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-ok-sign"></i>Pay Now via paypal</button>
							  		</p>
						  		</form>
						  </div>
					</div>
					<?php
				}else{
					if(empty($data['own_companies']))
					{
					?>
						<div class="alert alert-danger"><strong>Heads up!</strong> Sign-up for your own company now and start to invite people.</div>
					<?php }else{ ?>
						
					<?php } ?>
				<?php } 
				if($haspaid<>""){
				?>
				<div class="btn btn-primary clearfix"  data-toggle="modal" data-target="#signupnewcompanymodal" style="margin-left:10px;margin-bottom:10px;">Sign-up New Company</div><br>
				<div class="modal fade" id="signupnewcompanymodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					  <div class="modal-dialog">
					    <div class="modal-content">
					      <div class="modal-header">
					        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					        <h4 class="modal-title" id="myModalLabel">Signup your company now.</h4>
					        </div>
      					<div class="modal-body">
											<form method="post" action="">
												<h5>Company Name</h5>
												<p>
													<input type="text" name="company" required><small></small>
												</p>
												<h5>Website URL</h5>
												<p>
													<input type="text" name="url" required><small>Give us the URL that tells more about your business.</small>
												</p>
												<h5>Email</h5>
												<p>
													<input type="text" name="email" required>
												</p>
												<h5>Telephone</h5>
												<p>
													<input type="text" name="telephone" required><small>Specify phone number to discuss business matters.</small>
												</p>
												<h5>Address</h5>
												<p>
													<textarea name="address" required></textarea><small>Tell us the valid address of your company.</small>
												</p>
								</div>
						      <div class="modal-footer">
						        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						        <button type="submit" class="btn btn-primary">Save changes</button>
						      </div>
						      </form>
						    </div><!-- /.modal-content -->
						  </div><!-- /.modal-dialog -->
						</div><!-- /.modal -->
				<?php } ?>
				<div class="panel panel-info" style="margin-left:10px;">
				  <div class="panel-heading">
					<h3 class="panel-title">
						<?php if(!empty($data['view']) or !empty($data['edit'])){
							if(!empty($data['view'])){ echo $data['view']['name']; }
							if(!empty($data['edit'])){ echo $data['edit']['name']; }
						}else{
							echo'Companies';
						}
						if(!empty($data['view']) or !empty($data['edit'])){ ?>
							<a href="<?php echo BASE_URL;?>company/" class="label label-info">
							<span class="glyphicon glyphicon-arrow-left"></span> Back to List</a>
						<?php } ?>
						
					</h3>
				  </div>
				  <div class="panel-body">
						<?php  
						if(empty($data['view']) and empty($data['edit'])){
							if(!empty($data['own_companies']))
							{
								//display own companies
								foreach($data['own_companies'] as $c){
									?>
									<div class="companyv" onclick="javascript:location.href='<?php echo BASE_URL;?>company/view/id/<?php echo $c['id'];?>/'">
										<div>
											<img src="<?php echo BASE_URL_PUBLIC;?>images/companydefault.jpg" class="img-circle">
										</div>
										<div>
											<strong><?php echo $c['name']; ?></strong><br><br>
											<span class="label label-info">Owner</span>
										</div>
										<div class="clearfix"></div>
									</div>
									<?php
								}
							}
							if(!empty($data['companies']))
							{
								//display attached companies
								foreach($data['companies'] as $c){
									if($c['owner']<>$this->current_userid() and $c['name']<>""){
										?>
										<div class="companyv" onclick="javascript:location.href='<?php echo BASE_URL;?>company/view/id/<?php echo $c['id'];?>/'">
											<div>
												<img src="<?php echo BASE_URL_PUBLIC;?>images/companydefault.jpg" class="img-circle">
											</div>
											<div>
												<strong><?php echo $c['name']; ?></strong><br><br>
												<span class="label label-success"><?php echo $c['position']; ?></span>
											</div>
										</div>
										<?php
									}
								}
							}
							if(empty($data['companies']) and empty($data['own_companies'])){
								?>
								<div class="alert alert-success">
									<strong>Heads up!</strong> You don't have any company attached in your profile.
								</div>
								<?php
							}
					}
					if(!empty($data['edit'])){
						?>
							<div id="addnewcompany" class="panel panel-warning">
							  <div class="panel-heading">
								<h3 class="panel-title">Modify Company Details</h3>
							  </div>
							  <div class="panel-body">
									<form method="post" action="">
										<h5>Company Name</h5>
										<p>
											<input type="text" name="company" required value="<?php echo $data['edit']['name']; ?>" required>
										</p>
										<h5>Website URL</h5>
										<p>
											<input type="text" name="url" value="<?php echo $data['edit']['url']; ?>" required><small>Give us the URL that tells more about your business.</small>
										</p>
										<h5>Email</h5>
										<p>
											<input type="text" name="email" required value="<?php echo $data['edit']['email']; ?>" required>
										</p>
										<h5>Telephone</h5>
										<p>
											<input type="text" name="telephone"  value="<?php echo $data['edit']['telephone']; ?>"  required><small>Specify phone number to discuss business matters.</small>
										</p>
										<h5>Address</h5>
										<p>
											<textarea name="address"  value="<?php echo $data['edit']['address']; ?>" required></textarea><small>Tell us the valid address of your company.</small>
										</p>
										<!-- <h5>Company Logo</h5>
										<p>
											<input type="file" name="logo">
										</p> -->
										<p>
											<input type="submit" name="update" value="Save &amp; Update Details" class="btn btn-primary">
										</p>
									</form>
							  </div>
							</div>
						<?php
					}
					if(!empty($data['view'])){
						?>
						<div class="col-md-2">
							<table class="table table-striped">
								<tr>
									<td colspan="2"><img src="<?php echo BASE_URL_PUBLIC;?>images/companydefault.jpg" class="img-circle"></td>
								</tr>
								<tr>
									<td><strong>Company:</strong><br><?php echo $data['view']['name'] ?></td>
								</tr>
								<tr>
									<td><strong>Website URL:</strong><br><?php echo $data['view']['url'] ?></td>
								</tr>
								<tr>
									<td><strong>Email:</strong><br><?php echo $data['view']['email'] ?></td>
								</tr>
								<tr>
									<td><strong>Telephone:</strong><br><?php echo $data['view']['telephone'] ?></td>
								</tr>
								<tr>
									<td><strong>Address:</strong><br><?php echo $data['view']['address'] ?></td>
								</tr>
							</table>
							<?php 
							if($data['view']['owner'] == $this->current_userid())
							{
							?>
								<div style="margin-top:10px;margin-bottom:10px;">
									<!-- <a href="javascript:void(0)" onclick="if(confirm('Are you sure to remove this company?')){ location.href='<?php echo BASE_URL;?>company/view/id/<?php echo $data['request']['uri_data']['id'];?>/removecompany/<?php echo $data['request']['uri_data']['id'];?>/'; }" class="label label-danger"><span class="glyphicon glyphicon-remove"></span> Remove</a> -->
								
								<a href="<?php echo BASE_URL;?>company/edit/id/<?php echo $data['request']['uri_data']['id'];?>/" class="label label-primary"><span class="glyphicon glyphicon-edit"></span> Modify Details</a>
								</div>
									<div class="clearfix"></div>
							<?php } ?>
						</div>
						<div class="col-md-10" style="padding-left:10px;">
							<?php 
							if($data['view']['owner'] == $this->current_userid())
							{ /*
							?>
								<form method="post" action="">
									<h5>Enter email to invite<h5>
									<p>
										<input type="text" name="invite" required>
									<p>
									<p>
										<input type="submit" name="submit" value="Invite Now" class="btn btn-primary">
									</p>
								</form>
							<?php
								*/
							}
							if(!empty($data['employees']))
							{
								foreach($data['employees'] as $e)
								{
									//if($e['id']<>""){
											?>
											<div class="displayemp">
												<div class="col-md-3">
													<?php if($e['image_filename']<>""){ ?>	
														<div style="height: 90px;overflow: hidden;text-align: center;width: 91px;">
															<img style="height: auto;margin: 0 auto;max-width: 80px;width: 100%;" src="<?php echo BASE_URL_PUBLIC; ?>images/profileimage/<?php echo $e['image_filename']; ?>">
														</div>
													<?php }else{ ?>
														<div style="height: 90px;overflow: hidden;text-align: center;width: 91px;">
															<img style="max-width:80px;" src="<?php echo BASE_URL_PUBLIC;?>images/defaultuser.jpg" class="img-circle">
														</div>
													<?php } ?>
												</div>
												<div  class="col-md-9" style="padding-left:39px;font-size:12px">
													<div style="margin-top:10px; margin-bottom:10px;font-weight:bold;"><?php 
													if($e['firstname']<>"" or $e['lastname']<>""){
														echo $e['firstname'].' '.$e['lastname']; 
													}else{
														echo $e['email'];
													}
													 ?></div>
													 <div style="margin-top:10px;">
													 	<?php if($data['view']['owner'] == $this->current_userid()){ ?>
													 		<a href="javascript:void(0)" onclick="if(confirm('Are you sure to remove this user?')){ location.href='<?php echo BASE_URL;?>company/view/id/<?php echo $data['request']['uri_data']['id'];?>/removeuser/<?php echo $e['id']; ?>/'; }" class="label label-danger"><span class="glyphicon glyphicon-remove"></span> Remove</a>
													 	
													 	<a href="javascript:void(0)"  data-toggle="modal" data-target="#myModal<?php echo $e['id']; ?>" class="label label-info">
													 		<span class="glyphicon glyphicon-user"> Info
													 	</a>
													 	<?php }else{ ?>
																<div><?php echo $e['position']; ?></div>
																<div><small>USD <?php echo $e['rates']; ?> per hour</small></div>

														<?php } ?>

													 	<div class="modal fade" id="myModal<?php echo $e['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
														  <div class="modal-dialog">
														    <div class="modal-content">
														      <div class="modal-header">
														        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
														        <h4 class="modal-title" id="myModalLabel">
														        	<?php
														        		if($e['firstname']<>"" or $e['lastname']<>""){
																			echo $e['firstname'].' '.$e['lastname']; 
																		}else{
																			echo $e['email'];
																		}
														        	?>
														        </h4>
														      </div>
														      <div class="modal-body">
														        <div class="col-md-3">
																	<?php if($e['image_filename']<>""){ ?>	
																		<div style="height: 90px;overflow: hidden;text-align: center;width: 91px;">
																			<img style="height: auto;margin: 0 auto;max-width: 80px;width: 100%;" src="<?php echo BASE_URL_PUBLIC; ?>images/profileimage/<?php echo $e['image_filename']; ?>">
																		</div>
																	<?php }else{ ?>
																		<div style="height: 90px;overflow: hidden;text-align: center;width: 91px;">
																			<img style="max-width:80px;" src="<?php echo BASE_URL_PUBLIC;?>images/defaultuser.jpg" class="img-circle">
																		</div>
																	<?php } ?>
																</div>
																<form method="post" action="">
																	<input type="hidden" name="einfo[employee_id]" value="<?php echo $e['employee_id']; ?>">
																<div class="col-md-9">
																	<?php if($data['view']['owner'] == $this->current_userid()){ ?>
																		<table class="table table-striped">
																			<tr>
																				<td>Position:</td>
																				<td><input type="text" required name="einfo[position]" value="<?php echo $e['position']; ?>"></td>
																			</tr>
																			<tr>
																				<td>Rate: <small>USD per hour</small></td>
																				<td><input type="text" name="einfo[rate]" value="<?php echo $e['rates']; ?>"></td>
																			</tr>
																		</table>
																	<?php } ?>

																</div>
																<div class="clearfix"></div>
														      </div>
														      <div class="modal-footer">
														        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
														        <?php if($data['view']['owner'] == $this->current_userid()){ ?>
														        	<button type="submit"  class="btn btn-primary">Save changes</button>
														        <?php } ?>
														      </div>
														 	 </form>
														    </div>
														  </div>
														</div>

													 </div>
													 <?php
													//}
													?>
												</div>
											</div>
											<?php
											//}
								}
							}
							?>
							<div class="clearfix"></div>

							<div class="panel panel-primary">
							  <div class="panel-heading">
							    <h3 class="panel-title">Projects</h3>
							  </div>
							  <div class="panel-body">
							    	<ul class="nav nav-tabs" id="myTabsprojects">
									  <li class="active"><a href="#fixedprice" data-toggle="tab">Fixed Price</a></li>
									  <li><a href="#hourlyrate" data-toggle="tab">Hourly Rate</a></li>
									</ul>

									<div class="tab-content">
									  <div class="tab-pane active" id="fixedprice"><?php include_once("fixedprice.php"); ?></div>
									  <div class="tab-pane" id="hourlyrate"><?php include_once("hourlyrate.php"); ?></div>
									</div>
							  </div>
							</div>
						</div>
						<div class="clearfix"></div>

						<?php
					}
						?>
						
				  </div>
				</div>
		
			<div class="clearfix"></div>
	</div>
</div>
<?php $this->footers();  ?>