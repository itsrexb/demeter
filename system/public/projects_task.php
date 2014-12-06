<script>
	jQuery(document).ready(function($){
		$( "#taskduedate" ).datepicker({ minDate:0});
		$( "#taskstartdate" ).datepicker({ minDate:0});
		$('.taskchkbx').click(function(){
			var id=$(this).data('id');
			if($(this).is(':checked')){
				location.href='<?php echo BASE_URL; ?>projects/view/companyid/<?php echo $data['request']['uri_data']['companyid'];?>/projectview/<?php echo $data['request']['uri_data']['projectview'];?>/taskcomplete/'+id+'/';
			}else{
				location.href='<?php echo BASE_URL; ?>projects/view/companyid/<?php echo $data['request']['uri_data']['companyid'];?>/projectview/<?php echo $data['request']['uri_data']['projectview'];?>/taskuncomplete/'+id+'/';
			}
		});
	});
</script>
<div class="row-fluid">
	<?php // if(!empty($data['milestones'])){ 

				//check for active milestone
			/*	$active=0;
				foreach($data['milestones'] as $m)
				{
					if($m['is_completed']=='0'){
						$active += 1;
					}
				}
				if($active>0){*/
					?>
					<div><button class="btn btn-success" data-toggle="modal" data-target="#newtaskmodal">Create New Task</button></div>
				<?php /*}else{
					?>
					<div class="alert alert-danger">All of your milestone were completed already. Please add a new one or change its status to add more task.</div>
					<?php
				} */ ?>
	<?php /*}else{
		?>
		<div class="alert alert-warning">Please create a milestone to start adding a task.</div>
		<?php
	}*/ ?>
	<!-- Modal -->
	<div class="modal fade" id="newtaskmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h4 class="modal-title" id="myModalLabel">Create New Task</h4>
		  </div>
		  <div class="modal-body">
			<form method="post" action="">
					<div class="contentwrap">
						<p><input type="text" name="taskname" required placeholder="What's need to be done?"/></p>
						<h5>Attach to Milestone</h5>
						<p>
							<?php
							if(!empty($data['milestones']))
								{	
									echo'<select name="taskmilestone">';
										echo'<option value=""></option>';
										foreach($data['milestones'] as $m)
										{
											if($m['is_completed']=='0'){
												echo'<option value="'.$m['id'].'">'.$m['name'].'</option>';
											}
										}
									echo'</select>';
								}else{
									echo'<select name="taskmilestone">';
										echo'<option value="0">Default</option>';
									echo'</select>';
								}
							?>
						</p>
						<div>
							<ul class="nav nav-tabs">
							  <li class="first active"><a href="#twhowhen" data-toggle="tab">Who &amp; When</a></li>
							  <li><a href="#tdescription" data-toggle="tab">Description</a></li>
							</ul>

							<!-- Tab panes -->
							<div class="tab-content" style="border-bottom:1px solid #ccc;border-left:1px solid #ccc;border-right:1px solid #ccc;border-top:none;min-height:200px;">
							  <div class="tab-pane active" id="twhowhen">
									<div style="padding:20px;">
										<div class="col-md-6">
											<h5>Who should do this?</h5>
											<p>
												<?php
														if(!empty($data['freelancer'])){
															echo'<select name="responsible">';
																echo'<option value=""></option>';
																foreach($data['freelancer'] as $f)
																{
																	echo'<option value="'.$f['id'].'" '.(($f['id']==$data['editmilestone']['assigned_to_userid'])?'selected':'').'>'.ucwords($f['firstname']).' '.ucwords($f['lastname']).(($this->current_userid()==$f['id'])?' (Me)':'').'</option>';
																}
															echo'</select>';
														}else{
														 echo'<div class="alert alert-danger">Please add freelancer to your company to assign a milestone.</div>';
														}
														?>
											</p>
											<!-- <p><input type="checkbox" id="tasknotifyemail" value="1" name="tasknotifyemail"> Notify by email?</p> -->
											<h5>Estimated Time Duration(optional)</h5>
											<p><input type="text" style="width:80px;" value="<?php echo $data['edittask']['time_duration']; ?>" name="time_duration"><br><small>hh:mm</small></p>
										</div>
										<div class="col-md-3">
											<h5>Start date (optional)</h5>
											<p><input type="text" id="taskstartdate" name="taskstartdate"></p>
										</div>
										<div class="col-md-3" style="padding-left:10px;">
											<h5>Due date (optional)</h5>
											<p><input type="text" id="taskduedate" name="taskduedate"></p>
										</div>
										<div class="clearfix"></div>
									</div>
							  </div>
							  <div class="tab-pane" id="tdescription">
								<div style="padding:20px;">
									<textarea name="taskdescription" style="min-height:200px;"></textarea>
								</div>
							  </div>
							</div>
						</div>
					</div>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			<input type="submit" class="btn btn-success" value="Add this task">
		  </div>
		  </form>
		</div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
	
	<?php
	//edit a task
	if(!empty($data['edittask'])){
		?>
			<!-- Modal -->
				<script>
					jQuery(document).ready(function($){ 
						$('a[href="#tasks"]').tab('show');
						$('#updatetaskmodal').modal('show');
						$( "#taskstartdate2" ).datepicker({ minDate:0});
						$( "#taskduedate2" ).datepicker({ minDate:0});
					});
				</script>
				<div class="modal fade" id="updatetaskmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				  <div class="modal-dialog">
					<div class="modal-content">
					  <div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="myModalLabel">Update Task</h4>
					  </div>
					  <div class="modal-body">
						<form method="post" action="<?php echo BASE_URL; ?>projects/view/companyid/<?php echo $data['request']['uri_data']['companyid'];?>/projectview/<?php echo $data['request']['uri_data']['projectview'];?>/edittask/<?php echo $data['request']['uri_data']['edittask'];?>/update/true/">
								<div class="contentwrap">
									<p><input type="text" name="taskname" required placeholder="What's need to be done?" value="<?php echo $data['edittask']['name']; ?>"/></p>
									<h5>Attach to Milestone</h5>
									<p>
										<?php
										if(!empty($data['milestones']))
											{	
												echo'<select name="taskmilestone">';
													echo'<option value=""></option>';
													foreach($data['milestones'] as $m)
													{
														if($data['edittask']['milestone_id']==$m['id']){
															echo'<option value="'.$m['id'].'" selected="selected">'.$m['name'].'</option>';
														}else{
															echo'<option value="'.$m['id'].'">'.$m['name'].'</option>';
														}
													}
												echo'</select>';
											}else{
											 ?>
											 <input type="hidden" name="taskmilestone" value=""/>
											 <div class="alert alert-warning">No milestone. Please create a new one.</div>
											 <?php
											}
										?>
									</p>
									<div>
										<ul class="nav nav-tabs">
										  <li class="first active"><a href="#twhowhen2" data-toggle="tab">Who &amp; When</a></li>
										  <li><a href="#tdescription2" data-toggle="tab">Description</a></li>
										</ul>

										<!-- Tab panes -->
										<div class="tab-content" style="border-bottom:1px solid #ccc;border-left:1px solid #ccc;border-right:1px solid #ccc;border-top:none;min-height:200px;">
										  <div class="tab-pane active" id="twhowhen2">
												<div style="padding:20px;">
													<div class="col-md-6">
														<h5>Who should do this?</h5>
														<p>
															<?php
																	if(!empty($data['freelancer'])){
																		echo'<select name="responsible">';
																			echo'<option value=""></option>';
																			foreach($data['freelancer'] as $f)
																			{
																				echo'<option value="'.$f['id'].'" '.(($f['id']==$data['edittask']['assignedto_userid'])?'selected':'').'>'.ucwords($f['firstname']).' '.ucwords($f['lastname']).(($this->current_userid()==$f['id'])?' (Me)':'').'</option>';
																			}
																		echo'</select>';
																	}else{
																	 echo'<div class="alert alert-danger">Please add freelancer to your company to assign a milestone.</div>';
																	}
																	?>
														</p>
														<!-- <p><input type="checkbox" id="tasknotifyemail" value="1" name="tasknotifyemail"> Notify by email?</p> -->
														<h5>Estimated Time Duration(optional)</h5>
														<p><input type="text" style="width:80px;" value="<?php echo $data['edittask']['time_duration']; ?>" name="time_duration"><br><small>hh:mm</small></p>
													</div>
													<div class="col-md-3">
														<h5>Start date (optional)</h5>
														<p><input type="text" id="taskstartdate2" name="taskstartdate" value="<?=(($data['edittask']['start_date']<>"")?date('m/d/Y',strtotime($data['edittask']['start_date'])):'')?>"></p>
													</div>
													<div class="col-md-3" style="padding-left:10px;">
														<h5>Due date (optional)</h5>
														<p><input type="text" id="taskduedate2" name="taskduedate"  value="<?=(($data['edittask']['date_due']<>"")?date('m/d/Y',strtotime($data['edittask']['date_due'])):'')?>"></p>
													</div>
													<div class="clearfix"></div>
												</div>
										  </div>
										  <div class="tab-pane" id="tdescription2">
											<div style="padding:20px;">
												<textarea name="taskdescription" style="min-height:200px;"><?php echo $data['edittask']['description'];?></textarea>
											</div>
										  </div>
										</div>
									</div>
								</div>
					  </div>
					  <div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
						<input type="submit" class="btn btn-success" name="updatetask" value="Update & Save this task">
					  </div>
					  </form>
					</div><!-- /.modal-content -->
				  </div><!-- /.modal-dialog -->
				</div><!-- /.modal -->
		
		<?php
	
	}
	?>
	
	<script type="text/javascript">
		jQuery(document).ready(function($){
			$('.tcompleted').change(function(){
				
				var d = $(this).find(':selected').val();
				$(this).parent('div').find('.completed').html(d);
			});
		});
		function readyupdate(obj){
			$(obj).parent('div').find('select').show();
			$(obj).parent('div').find('.label').show();
		}
		function setcomplete(obj){
			$(obj).html('Saving...');
			$.post('<?php echo BASE_URL; ?>projects/setcompleted/',{ id: $(obj).attr('rel'), completed: $(obj).parent('div').find(':selected').val() },function(data){
							$(obj).parent('div').find('select').hide();
							$(obj).parent('div').find('.label').hide();
							$(obj).html('Update');
					});

			
		}
		function addNotes(obj){
			$('#addn'+$(obj).attr('rel')).show();
		}
		function SaveNotes(obj){
			$(obj).html('<span class="glyphicon glyphicon-floppy-save"></span> Saving...');
			$.post('<?php echo BASE_URL; ?>projects/savenotes/',
					{ 	
						id: $(obj).attr('rel'), 
						notes: $(obj).parent('p').parent('div').find('textarea').val() 
					},
					function(data){
							window.location.reload();
							$('#addn'+$(obj).attr('rel')).hide();
							$(obj).html('<span class="glyphicon glyphicon-floppy-save"></span> Save Notes');
					});
		}
	</script>
	<!-- task list -->
	<div class="row-fluid contentwrap">
		<?php

			if(!empty($data['tasklist'])){
				foreach($data['tasklist'] as $d){
					?>
					<div class="panel panel-default">
					  <div class="panel-heading">
						<?php if($d['is_completed']=="1"){?>
							<h3 class="panel-title" style="text-decoration:line-through"><?php echo $d['name'];?></h3>
						<?php }else{ ?>
							<h3 class="panel-title"><?php echo $d['name'];?></h3>
						<?php } ?>
					  </div>
					  <div class="panel-body">
						<?php
							if(!empty($d['tasks'])){
								echo'<ul class="list-group">';
									foreach($d['tasks'] as $t)
									{
									?>
									<li class="list-group-item">
										<div class="col-md-2">
											<div class="mtitlehldr">
												<div class="mtitlemonth"><?php echo date('F',strtotime($t['date_due']));?></div>
												<div class="mtitledayhldr">
													<div><span><?php echo date('d',strtotime($t['date_due']));?></span></div>
													<div><span style="font-size:14px;margin-bottom:10px"><?php echo date('l',strtotime($t['date_due']));?></span></div>
													<div class="clearfix"></div>
												</div>
												<div class="clearfix"></div>
											</div>
										</div>
										<div class="col-md-9">
											<?php if($t['is_done']=='1'){ ?>
												<h3 title="Created by <?php echo ucwords($t['author']); ?>" style="text-decoration:line-through">
													<input type="checkbox" data-id="<?php echo $t['id']; ?>" checked  class="taskchkbx"> <?php echo $t['name']; ?>
												</h3>
												<?php }else{
												?>
												<h3 title="Created by <?php echo ucwords($t['author']); ?>">
													<input type="checkbox" data-id="<?php echo $t['id']; ?>" class="taskchkbx"> <?php echo $t['name']; ?>
												</h3>
												<?php 
												} ?>
												<div class="taskcompleted"><?php if($t['time_duration']<>""){?><small style="color:#47A447;margin-right:15px;">Est. Time Duration: <strong><?php echo $t['time_duration']; } ?></strong></small><span class="completed"><?php echo $t['completed']; ?></span>% Completed. 
														<a href="javascript:void(0)" onclick="readyupdate(jQuery(this))" title="Click to Change" style="font-weight:normal;font-style:italic;">change</a>
														<select class="tcompleted"  id="completed" style="border: medium none;margin-top: -5px;display:none">
															<option value="0">0%</option>
															<option value="10">10%</option>
															<option value="20">20%</option>
															<option value="30">30%</option>
															<option value="40">40%</option>
															<option value="50">50%</option>
															<option value="60">60%</option>
															<option value="70">70%</option>
															<option value="80">80%</option>
															<option value="90">90%</option>
														</select>
														<a href="javascript:void(0)" onclick="setcomplete(jQuery(this))" rel="<?php echo $t['id']; ?>" class="label label-primary"  style="display:none;border: medium none;margin-left: 5px;margin-top: -5px;outline: medium none;">Update</a>
												</div>
												<div class="mdescrptn"><?php echo nl2br($t['description']); ?></div>
												<div style="margin:10px 10px;">
													<?php if($t['responsible']<>""){ ?>
														<span><?php echo ucwords($t['responsible']); ?> is responsible.</span>
													<?php }else{ ?>
														<span>Assigned to anyone.</span>
													<?php } ?>
												</div>
													<div style="margin-bottom:20px;">
														<?php
															if($t['addedby_userid']==$this->current_userid())
															{
															?>
																<a href="javascript:void(0)" class="label label-warning"
																onclick="if(confirm('Are you sure to delete this task?')==true){ location.href='<?php echo BASE_URL; ?>projects/view/companyid/<?php echo $data['request']['uri_data']['companyid'];?>/projectview/<?php echo $data['request']['uri_data']['projectview'];?>/deletetask/<?php echo $t['id'];?>/';}"
																><span class="glyphicon glyphicon-remove"></span> Delete</a> 
																<a href="<?php echo BASE_URL; ?>projects/view/companyid/<?php echo $data['request']['uri_data']['companyid'];?>/projectview/<?php echo $data['request']['uri_data']['projectview'];?>/edittask/<?php echo $t['id'];?>/" class="label label-info">
																	<span class="glyphicon glyphicon-edit"></span> Edit Task
																</a> 
															<?php
															}?>
														<a href="javascript:void(0)" class="label label-success" rel="<?php echo $t['id'];?>" onclick="addNotes(jQuery(this))" style="margin-left:5px;">
															<span class="glyphicon glyphicon-info-sign"></span> Add Notes
														</a>
													</div>
													
												
												<div class="clearfix"></div>
													<div class="mnotes" style="display:none" id="addn<?php echo $t['id'];?>">
														<p><textarea style="width:600px;height:250px;"></textarea></p>
														<p><a href="javascript:void(0)" rel="<?php echo $t['id'];?>" onclick="SaveNotes(jQuery(this))" class="label label-primary" style="margin-top:10px;">
																<span class="glyphicon glyphicon-floppy-save"></span> Save Notes</a>
														</p>
													</div>
												<div class="clearfix"></div>
												<?php if($t['notes']<>""){  ?>
													<div class="mnotes">
														<h4>Notes</h4>
														<p id="mnotes<?php echo $t['id'];?>"><?php echo nl2br($t['notes']); ?></p>	
													</div>
												<?php } ?>
											</div>
											<div class="clearfix"></div>
									</li>
									<?php
									}
								echo'</ul>';
							}else{
								?>
								<div class="alert alert-warning"><strong>Horrah!</strong> Add your first task.</div>
								<?php
							}
						?>
					  </div>
					</div>
					<?php
				}
			}
		?>
	</div>
	<!-- /task list -->
	
</div>