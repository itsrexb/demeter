<div class="row-fluid contentwrap">
	<div class="row-fluid">
		<?php  if($data['view']['owner']==$this->current_userid()){?>
			<button class="btn btn-primary" data-toggle="modal" data-target="#createhourlyfreelancers">Create New Hourly Project</button>
		<?php } ?>
		<button class="btn btn-info" data-toggle="modal" data-target="#showhourlyfreelancers">Show Freelancers</button>

		<!-- Modal -->
		<div class="modal fade" id="showhourlyfreelancers" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		  <div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		        <h4 class="modal-title" id="myModalLabel">Freelancers at <?php echo  $data['view']['name']; ?></h4>
		      </div>
		      <div class="modal-body">
		        <?php
		        	if(!empty($data['hourlyemployees']))
							{
								foreach($data['hourlyemployees'] as $e)
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
													 	<div class="clearfix" style="margin-top:10px"></div>
													 	<form method="post" action="">
															<input type="hidden" name="einfo[employee_id]" value="<?php echo $e['employee_id']; ?>">
														
															<?php if($data['view']['owner'] == $this->current_userid()){ ?>
																
																	<p>Position:<br>
																		<input type="text" style="height:24px;" required name="einfo[position]" value="<?php echo $e['position']; ?>"><br>
																		Rate: <small>USD per hour</small><br>
																		<input type="text" style="height:24px;" name="einfo[rate]" value="<?php echo $e['rates']; ?>"><br>
																		<button type="submit"  class="btn btn-primary btn-xs" style="margin-top:5px;">Save changes</button>
																	</p>
															<?php } ?>

														</form>
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
		<div class="modal fade" id="createhourlyfreelancers" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		  <div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		        <h4 class="modal-title" id="myModalLabel">Create New Hourly Project</h4>
		      </div>
		      <div class="modal-body">
		      	<div style="width:100%">

				         <form method="post" action="" autocomplete="off">
				         	<div class="col-md-8">
								<h5>Project Name</h5>
								<p><input type="text" name="projectname"/><small>Ex.1: Create Company Website, Ex.2: I want PHP Developer</small></p>
								<h5>Description</h5>
								<p><textarea name="description" style="min-height:200px;"/></textarea><small>Desribe your project briefly and concise.</small></p>

								
							
								<!-- <h5>Who's responsible?</h5>
								<?php
								if(!empty($data['hourlyemployees'])){ ?>
									<p><input type="radio"  <?php if(!empty($data['hourlyemployees'])){  echo'checked="checked"';} ?> name="choosefreelancer" value='0'/> <span style="font-size:13px;">Choose from your current freelancer</span>
									<?php
									echo'<select name="responsible" class="form-control">';
									echo'<option></option>';
										foreach($data['hourlyemployees'] as $f)
										{

											echo'<option value="'.$f['id'].'">'.ucwords($f['firstname']).' '.ucwords($f['lastname']).(($this->current_userid()==$f['id'])?' (Me)':'').'</option>';
										}
									echo'</select></p>';
								}
								?> -->
								<script type="text/javascript">
									jQuery(function($){
										$.post('<?php echo BASE_URL;?>company/searchfreelancer/',{ q : $('#searchskilss').val(),ishourly:true},function(data){
											$('#searchskilssresults').html(data);
										});
										$('#searchfreelancerbuttons').click(function(){
											$(this).val('Searching....');
											$.post('<?php echo BASE_URL;?>company/searchfreelancer/',{ q : $('#searchskilss').val(),ishourly:true},function(data){
												$('#searchskilssresults').html(data);
												$('#searchfreelancerbuttons').val('Search');
											});
										});
									});
									function invitethisfreelancers(userid,firstname){
										$('#responsiblefreelancers').val(userid);
										$('#searchffnames').html(firstname);
										$('#hiddensearchffnames').show();
									}
								</script>
									<input type="hidden" name="ishourly" value="true">
									<h5 style="display:none"><input type="checkbox" id="isfixed" checked="checked" name="isfixed" value="0"> Is this a fixed project?</h5>
									<input type="radio"  style="display:none" name="choosefreelancer"  value='1' <?php if(empty($data['fixemployees'])){  echo'checked="checked"';} ?>/> <span style="font-size:13px;">earch freelancer from our database to invite for this project.</span><br>
									<small>Enter your desired skills for a freelancer</small>
									<p><input autocomplete="false" type="text" id="searchskilss" style="height: 31px;margin-right: 3px;outline: medium none;
    width: 237px;"><input type="button" class="btn btn-primary btn-sm"id="searchfreelancerbuttons" value="search"></p>
								</div>
								<div class="clearfix"></div>
								<div id="hiddensearchffnames" style="display:none; color:red; font-size:14px;">
									Invite <span id="searchffnames"></span> to this project
									<input type="hidden" name="responsiblefreelancer" id="responsiblefreelancers">
								</div>
								<div id="searchskilssresults" style="font-size:11px;max-height:300px; overflow:auto;"></div>
								<h5 style="color:red"><input type="checkbox" name="issearchable" id="issearchablev" value="1"> Make this project visible to job search and open for application.</h5>
								<script type="text/javascript">
								 jQuery(function($){
								 	$('#issearchablev').change(function(){
								 		if($(this).is(':checked')){
								 			$('#countryvv').show();
								 		}else{
								 			$('#countryvv').hide();
								 		}
								 	});
								 });
								</script>
								<div id="countryvv" style="display:none">
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
									<h5>Duration</h5>
									<p>
									 <input type="text" name="duration"><small>Specify project duration Ex. 2 months </small>
									</p>
									<h5>Hourly Rate($) <small>in USD</small></h5>
									<p ><input type="text" name="price" placeholder="0.00" style="width:100px;"/></p>
									<h5><input type="checkbox" name="isnegotiable" id="isnegotiable" value="1"> Is Rate Negotiable?</h5>
									<h5>How much manpower you need?</h5>
									<p><input type="text" name="needed"><small>Ex. 2 PHP Developer</small></p>
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
				 where company_id='".(int)$_REQUEST['uri_data']['id']."' and isFixed='0' order by id DESC");
	?>
	<script type="text/javascript">jQuery(function($){ $(".imgsssmallicon").tooltip(); })</script>
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
						<input type="checkbox" data-id="<?php echo $p['id']; ?>" checked  title="Tick to finish"  class="taskchkbx"> 
						<a href="<?php echo BASE_URL;?>projects/view/companyid/<?php echo $data['request']['uri_data']['id'];?>/projectview/<?php echo $p['id']; ?>/">
							<?php echo $p['name']; ?></a>
					</h3>
					<?php }else{
					?>
					<h3>
						<input type="checkbox" data-id="<?php echo $p['id']; ?>" title="Tick to finish" class="taskchkbx"> 
						<a href="<?php echo BASE_URL;?>projects/view/companyid/<?php echo $data['request']['uri_data']['id'];?>/projectview/<?php echo $p['id']; ?>/">
						<?php echo $p['name']; ?></a>
					</h3>
					<?php 
					} ?>
					<!-- <h3><input type="checkbox" data-id="<?php echo $t['id']; ?>" class="taskchkbx"> <?php echo $p['name'];?></h3> -->
					<!-- <h3><a href="<?php echo BASE_URL;?>projects/view/companyid/<?php echo $data['request']['uri_data']['id'];?>/projectview/<?php echo $p['id']; ?>/"><?php echo $p['name'];?></a></h3> -->
					<p class="mdescrptn"><?php echo nl2br($p['description']);?></p>
					<div class="row" style="margin-left:10px">
						<?php
						 $fr = $this->fetch("select * from project_user_tb a left join user_tb b on b.id = a.user_id where project_id='".$p['id']."'");
						 if(!empty($fr)){
						 	foreach($fr as $f){
							 	?>
							 	<div style="background:#000;width:30px;height:30px;overflow:hidden; float:left;margin-right:5px;margin-bottom:5px;">
							 		<a class="imgsssmallicon" data-toggle="tooltip" data-placement="left" title="<?php echo ucwords($f['firstname'].' '.$f['lastname']); ?>" target="_blank" href="<?php echo BASE_URL.'profile/sprofile/sid/'.$f['user_id'].'/'; ?>">
									<?php if($f['image_filename']==""){ ?>
									<img class="img-round" src="<?php echo BASE_URL_PUBLIC; ?>images/defaultuser.jpg" style="width:100%; height:auto; margin: 0px auto;">
									<?php }else{ ?>
									<img class="img-round" src="<?php echo BASE_URL_PUBLIC; ?>images/profileimage/<?php echo $f['image_filename']; ?>" style="width:100%; height:auto; margin: 0px auto;">
									<?php } ?>
								</a>
							 	</div>
							 	<?php
						 	}
						 }
						?>
						<div class="clearfix"></div>
						<span><a  data-toggle="modal" data-target="#assignfreelancetoproject<?php echo $p['id']; ?>" href="javascript:void(0)" class="btn btn-link btn-sm">Assign Freelancers</a>
					</div>
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
											if(!empty($data['hourlyemployees'])){ ?>
												<p>
												<?php
												echo'<select name="responsible" class="form-control">';
												echo'<option value="">Choose freelancer</option>';
													foreach($data['hourlyemployees'] as $f)
													{

														echo'<option value="'.$f['user_id'].'">'.ucwords($f['firstname']).' '.ucwords($f['lastname']).(($this->current_userid()==$f['user_id'])?' (Me)':'').'</option>';
													}
												echo'</select></p>';
											}
											?>
								      </div>
								      <div class="modal-footer">
								        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
								        <button type="submit" name="assignfreelancerstohourlyproject" value="true" class="btn btn-primary">Save changes</button>
								      </div>
								  	</form>
								    </div>
								  </div>
								</div><!--end of modal-->
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