<div class="row-fluid contentwrap">
	<div class="row-fluid">
		<?php  if($data['view']['owner']==$this->current_userid()){?>
			<button class="btn btn-primary" data-toggle="modal" data-target="#createnewfixproject">Create New Fixed Project</button>
		<?php } ?>

		<button class="btn btn-info" data-toggle="modal" data-target="#showfixfreelancers">Show Freelancers</button>

		<!-- Modal -->
		<div class="modal fade" id="showfixfreelancers" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		  <div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		        <h4 class="modal-title" id="myModalLabel">Freelancers at <?php echo  $data['view']['name']; ?></h4>
		      </div>
		      <div class="modal-body">
		        <?php
		        	if(!empty($data['fixemployees']))
							{
								foreach($data['fixemployees'] as $e)
								{
									//if($e['id']<>""){
											?>
											<div class="displayemp">
												<div class="col-md-3">
													<a style="hover:opacity:0.8;" href="<?php echo BASE_URL.'profile/sprofile/sid/'.$e['user_id'].'/'; ?>">
														<?php if($e['image_filename']<>""){ ?>	
															<div style="height: 90px;overflow: hidden;text-align: center;width: 91px;">
																<img style="height: auto;hover:opacity:0.8;margin: 0 auto;max-width: 80px;width: 100%;" src="<?php echo BASE_URL_PUBLIC; ?>images/profileimage/<?php echo $e['image_filename']; ?>">
															</div>
														<?php }else{ ?>
															<div style="height: 90px;overflow: hidden;text-align: center;width: 91px;">
																<img style="max-width:80px;" src="<?php echo BASE_URL_PUBLIC;?>images/defaultuser.jpg" class="img-circle">
															</div>
														<?php } ?>
													</a>
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
													 	
													 	<!-- <a href="javascript:void(0)"  data-toggle="modal" data-target="#myModal<?php echo $e['id']; ?>" class="label label-info">
													 		<span class="glyphicon glyphicon-user"> Info
													 	</a> -->
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
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		      </div>
		    </div>
		  </div>
		</div>

		<!-- Modal -->
		<div class="modal fade" id="createnewfixproject" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		  <div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		        <h4 class="modal-title" id="myModalLabel">Create New Fixed Project</h4>
		      </div>
		      <div class="modal-body">
		      	<div style="width:100%">
				         <form method="post" action="" autocomplete="off">
				         	<div class="col-md-8">
								<h5>Project Name</h5>
								<p><input type="text" name="projectname"/><small>Ex.1: Create Company Website, Ex.2: I want PHP Developer</small></p>
								<h5>Description</h5>
								<p><textarea name="description" style="min-height:200px;"/></textarea><small>Desribe your project briefly and concise.</small></p>
								<h5  class="isf">Price($) <small>in USD</small></h5>
								<p  class="isf"><input type="text" name="price" placeholder="0.00" style="width:100px;"/></p>
							
								<h5>Who's responsible?</h5>
								<?php
								if(!empty($data['fixemployees'])){ ?>
									<p><input type="radio"  <?php if(!empty($data['fixemployees'])){  echo'checked="checked"';} ?> name="choosefreelancer" value='0'/> <span style="font-size:13px;">Choose from your current freelancer</span>
									<?php
									echo'<select name="responsible" class="form-control">';
									echo'<option></option>';
										foreach($data['fixemployees'] as $f)
										{

											echo'<option value="'.$f['user_id'].'">'.ucwords($f['firstname']).' '.ucwords($f['lastname']).(($this->current_userid()==$f['user_id'])?' (Me)':'').'</option>';
										}
									echo'</select></p>';
								}
								?>
								<script type="text/javascript">
									jQuery(function($){
										$.post('<?php echo BASE_URL;?>company/searchfreelancer/',{ q : $('#searchskilss').val()},function(data){
											$('#searchskilssresult').html(data);
										});
										$('#searchfreelancerbutton').click(function(){
											$(this).val('Searching....');
											$.post('<?php echo BASE_URL;?>company/searchfreelancer/',{ q : $('#searchskilss').val()},function(data){
												$('#searchskilssresult').html(data);
												$('#searchfreelancerbutton').val('Search');
											});
										});
									});
									function invitethisfreelancer(userid,firstname){
										$('#responsiblefreelancer').val(userid);
										$('#searchffname').html(firstname);
										$('#hiddensearchffname').show();
									}
								</script>
									<h5 style="display:none"><input type="checkbox" id="isfixed" checked="checked" name="isfixed" value="1"> Is this a fixed project?</h5>
									<p><input type="radio" name="choosefreelancer"  value='1' <?php if(empty($data['fixemployees'])){  echo'checked="checked"';} ?>/> <span style="font-size:13px;">Search freelancer from our database to invite for this project.</span><br><small>Enter your desired skills for a freelancer</small><br><input autocomplete="false" type="text" id="searchskilss" style="height: 31px;margin-right: 3px;outline: medium none;
    width: 237px;"><input type="button" class="btn btn-primary btn-sm"id="searchfreelancerbutton" value="search"></p>
								</div>
								<div class="clearfix"></div>
								<div id="hiddensearchffname" style="display:none; color:red; font-size:14px;margin-bottom:10px;">
									Invite <span id="searchffname"></span> to this project
									<input type="hidden" name="responsiblefreelancer" id="responsiblefreelancer">
								</div>
								<div id="searchskilssresult" style="font-size:11px;max-height:300px; overflow:auto;"></div>
								<h5 style="color:red"><input type="checkbox" name="issearchable" id="issearchable" value="1"> Make this project visible to job search and open for application.</h5>
								<script type="text/javascript">
								 jQuery(function($){
								 	$('#issearchable').change(function(){
								 		if($(this).is(':checked')){
								 			$('#countryv').show();
								 		}else{
								 			$('#countryv').hide();
								 		}
								 	});
								 });
								</script>
								<div id="countryv" style="display:none">
									<h5>Country Location</h5>
									<p><select id="selcountry" name="location" class="form-control">
										<option value="">---Choose---</option>
													<?php
														$country = $this->country();
														if(!empty($country)){
															foreach($country as $k=>$v){
																if($k==strtoupper($data['profDetails']['country'])){
																	echo'<option selected="selected" value="'.$k.'">'.$v.'</option>';
																}else{
																	echo'<option value="'.$k.'">'.$v.'</option>';
																}
															}
														}
													?>
												</select></p>
									<h5><input type="checkbox" name="isnegotiable" id="isnegotiable" value="1"> Is Price Negotiable?</h5>
									<h5>Duration</h5>
									<p>
									 <input type="text" name="duration"><small>Specify project duration Ex. 2 months </small>
									</p>
									<h5>Desired Skills</h5>
									<p>
									 <textarea name="desiredskills"></textarea><small>separated by a comma(,) e.g PHP,CSS,HTML</small>
									</p>
								</div>
							
				      </div>
				      <div class="modal-footer">
				        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				        <button type="submit" class="btn btn-primary" value="true" name="createnewproject">Save changes</button>
				      </div>
				      </form>
				    </div>
			</div> <!-- -->
		  </div>
		</div>
	</div>
	<!--  THIS IS FOR THE LISTING -->
	<?php 
		$data["projects"] = $this->fetch("select * from project_tb
				 where company_id='".(int)$_REQUEST['uri_data']['id']."' and isFixed='1' order by id DESC");
	?>
	<div class="row" style="margin-top:10px;font-size:12px;">
		<?php
		if(!empty($data["projects"])){
			echo'<ul class="list-group">';
			foreach($data["projects"] as $p)
			{
				?>
				<li class="list-group-item">
					<div class="col-md-7">
						<?php if($p['is_active']=='0'){ ?>
						<h3 style="text-decoration:line-through">
							<input type="checkbox" data-id="<?php echo $p['id']; ?>" checked  title="Tick to finish"  class="taskchkbx"> <?php echo $p['name']; ?>
						</h3>
						<?php }else{
						?>
						<h3>
							<input type="checkbox" data-id="<?php echo $p['id']; ?>" title="Tick to finish" class="taskchkbx"> <?php echo $p['name']; ?>
						</h3>
						<?php 
						} ?>
					<!-- <h3><input type="checkbox" data-id="<?php echo $t['id']; ?>" class="taskchkbx"> <?php echo $p['name'];?></h3> -->
					<?php if($p['isfixed']=="1"){ ?>
						<p><label class="label label-success"><span class="glyphicon glyphicon-usd"></span> Fixed Price: <?php echo $p['total_price']; ?></label></p>
						<p>
							<?php 
							$img= $this->get_var("select image_filename from user_tb where id='".$p['assignedto_userid']."'");
							?>
							<div style="width:30px;height:30px;overflow:hidden;margin-right:5px;margin-bottom:5px;">
								<a class="imgsssmallicon" data-toggle="tooltip" data-placement="left" title="<?php echo $this->get_var("select CONCAT(firstname,' ',lastname) from user_tb where id='".$p['assignedto_userid']."'"); ?>" 
									<?php if($p['assignedto_userid']<>0){ ?>  target="_blank"
									href="<?php echo BASE_URL.'profile/sprofile/sid/'.$p['assignedto_userid'].'/'; ?>"
									<?php }else{ echo'href="javascript:void(0)"'; } ?>
									>
										<?php if($img==""){ ?>
										<img class="img-round" src="<?php echo BASE_URL_PUBLIC; ?>images/defaultuser.jpg" style="width:100%; height:auto; margin: 0px auto;">
										<?php }else{ ?>
										<img class="img-round" src="<?php echo BASE_URL_PUBLIC; ?>images/profileimage/<?php echo $img; ?>" style="width:100%; height:auto; margin: 0px auto;">
										<?php } ?>
									</a>
							</div>
							<?php 
							  if($p['assignedto_userid']<>"0"){
								echo $this->get_var("select CONCAT(firstname,' ',lastname) from user_tb where id='".$p['assignedto_userid']."'");?> <em>is responsible.</em><a  data-toggle="modal" data-target="#assignfreelancetoproject<?php echo $p['id']; ?>" href="javascript:void(0)" class="btn btn-link btn-sm">Change</a></span>
							<?php }else{
							?><span style="color:red">No one is responsible. <a  data-toggle="modal" data-target="#assignfreelancetoproject<?php echo $p['id']; ?>" href="javascript:void(0)" class="btn btn-link btn-sm">Assign Now</a></span>
							<?php
							}?>
								<!-- Modal -->
								<div class="modal fade" id="assignfreelancetoproject<?php echo $p['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
								  <div class="modal-dialog">
								    <div class="modal-content">
								      <div class="modal-header">
								        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								        <h4 class="modal-title" id="myModalLabel">Assign Freelancer to <?php echo $p['name']; ?> project</h4>
								      </div>
								      <form method="post" action="">
								      <div class="modal-body">
								         	<input type="hidden" name="projectid" value="<?php echo $p['id']; ?>">
											<h5>Who's responsible?</h5>
											<?php
											if(!empty($data['fixemployees'])){ ?>
												<p>
												<?php
												echo'<select name="responsible" class="form-control">';
												echo'<option value="">Choose freelancer</option>';
													foreach($data['fixemployees'] as $f)
													{

														echo'<option value="'.$f['user_id'].'">'.ucwords($f['firstname']).' '.ucwords($f['lastname']).(($this->current_userid()==$f['user_id'])?' (Me)':'').'</option>';
													}
												echo'</select></p>';
											}
											?>
								      </div>
								      <div class="modal-footer">
								        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
								        <button type="submit" name="changeassignee" value="true" class="btn btn-primary">Save changes</button>
								      </div>
								  	</form>
								    </div>
								  </div>
								</div>

							
						</p>
					<?php } ?>
					<p class="mdescrptn"><?php echo nl2br($p['description']);?></p>

					</div>
					<div class="col-md-4" style="margin-left:10px;">
							<div class="contentwrapper">
									<div class="panel panel-success">
										<?php if($p['assignedto_userid']==$this->current_userid()){ ?>
										<div class="panel-heading">
											<h3 class="panel-title">Get paid now. <small>Contact your Employer and receive your hard works.</small></h3>
										</div>
										<?php } ?>
										<div class="panel-body">
											<div>Total Contract Price: $<?php echo $p['total_price']; ?></div>
											<?php

											if($p['assignedto_userid']==$this->current_userid()){
												?>
												<div>Amount Receivable: <?php echo (($p['total_payable_price']>=0)?'$'.$p['total_payable_price']:'<label class="label label-success">Paid</label>'); ?></div>
												<?php
											}
											//get company owner
											$owner = $this->get_var("select b.owner from project_tb a
																	left join company_tb b on a.company_id = b.id
																	where a.id = '".$p['id']."'");
											if($owner == $this->current_userid() and $p['assignedto_userid']<>"0"){
												?>
												<div>Amount Payables: <?php echo (($p['total_payable_price']>=0)?'$'.$p['total_payable_price']:'<label class="label label-success">Paid</label>'); ?></div>
												<?php if($p['total_payable_price']>0){ ?>
														<div class="panel panel-default">
														  <div class="panel-heading">Process payment now</div>
														  <div class="panel-body">
														  	<?php
														  	if($_SERVER['REQUEST_METHOD']=='POST' and $_POST['amount']<>""){
														  		if(floatval($_POST['amount'])<1){
														  			?>
														  			<div class="alert alert-danger"><strong>Oh snap!</strong> Please provide valid amounts.</div>
														  			<?php
														  		}else{
														  			global $CFG;

														  			$a= number_format( number_format($_POST['amount']) + ((number_format($_POST['amount']) * 0.029) + 0.30) + (number_format($_POST['amount']) * number_format($CFG['paypal']['commission'],2)),2);
														  			?>
														  			<script type="text/javascript">
														  			 jQuery(document).ready(function($){
														  			 	$('#frm').submit();
														  			 });
														  			</script>
														  			<form method="post" id="frm" action="<?php echo $CFG['paypal']['submit_url']; ?>">
															  			<input type="hidden" name="custom" value="_paybilling_$<?php echo $this->current_userid().'$'.$p['id'].'$'.$p['assignedto_userid'].'$'.$_POST['amount']; ?>">
															  			<input type="hidden" name="on1" value="">
															  			<input type="hidden" name="business" value="<?php echo $CFG['paypal']['email']; ?>"> 
														                <input type="hidden" name="item_name" value="Payment for <?php echo $p['name']; ?>"> 
														                
														                <input type="hidden" name="amount" value="<?php echo $a; ?>"> 
														                <input type="hidden" name="return" value="<?php echo BASE_URL.'company/paypal-success/redirect/thank-you/'; ?>">
														                <input type="hidden" name="cmd" value="_xclick">
														                <input type="hidden" name="quantity" value="1">
														                <input type="hidden" name="cancel_return" value="<?php echo BASE_URL.'company/view/id/'.$data['view']['id'].'/'; ?>" />
															        </form>
														  			<?php
														  		}
														  	}
														  	?>
														  	<script type="text/javascript">
														  		jQuery(function($){
														  			$('.amount').keyup(function(){
														  				var b = $(this);
														  				var a = parseFloat(b.val());
														  				var paypalfee = (( a * 0.029) + 0.30).toFixed(2);

														  				<?php global $CFG; ?>
																		var commisionrate = <?php echo $CFG['paypal']['commission']; ?>;
																		var commision = (a * parseFloat(commisionrate)).toFixed(2);
																		var totalfee = (parseFloat(a) + parseFloat(paypalfee) + parseFloat(commision)).toFixed(2);

																		b.parent('div').parent('form').find('.paypalfee').html('Paypal Transaction Fee : '+paypalfee);
																		b.parent('div').parent('form').find('.demeterfee').html('Demeter Transaction Fee : '+commision);
																		b.parent('div').parent('form').find('.totalfee').html('Total Amount : '+totalfee);
														  			});
														  		});
														  	</script>
														  	<form method="post" action="" autocomplete="off">
															    <div>Enter amount to pay:</div>
															    <div class="input-group" style="margin-bottom:5px;border-bottom:1px solid #ccc;border-right:1px solid #ccc;"><span class="input-group-addon" style="border-bottom:0px solid #ccc;">$</span><input type="text" name="amount" class="amount form-control"> <small><strong> Note:</strong> This transaction is non-refundable. </small></div>
															    <div class="clearfix"></div>
															    <div style="margin-top:10px;" class="paypalfee"></div>
							   									<div style="margin-top:10px;margin-bottom:10px" class="demeterfee"></div>
							   									<div style="margin-bottom:10px; font-size:15px;" class="totalfee"></div>
															    <p><button class="btn btn-primary"><i class="glyphicon glyphicon-ok"></i> Pay Now</button></p>
															</form>
														  </div>
														</div>
														<?php
												}
											}

											?>
										</div>
									</div>
								</div>
					</div>
					<div class="clearfix"></div>
				</li>
				<?php
			}
			echo'</ul>';
		}
		?>
	</div>
</div>