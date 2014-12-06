<script>
	function createmlstone(){
	
	}
	jQuery(document).ready(function($){
		$( "#duedate" ).datepicker({ minDate:0}).change(function(){
			var m ='',d = $(this).val().split('/');
			switch(d[0])
			{
				case '01': m="January"; break; case '02': m="February"; break; case '03': m="March"; break;
				case '04': m="April"; break; case '05': m="May"; break; case '06': m="June"; break;
				case '07': m="July"; break; case '08': m="August"; break; case '09': m="September"; break;
				case '10': m="October"; break; case '11': m="November"; break; case '12': m="December"; break;
			}
			$('#mtitlemonth').html(m);
			$('#mtitledayhldr span').html(d[1]);
		});
		$( "#duedate2" ).datepicker({ minDate:0}).change(function(){
			var m ='',d = $(this).val().split('/');
			switch(d[0])
			{
				case '01': m="January"; break; case '02': m="February"; break; case '03': m="March"; break;
				case '04': m="April"; break; case '05': m="May"; break; case '06': m="June"; break;
				case '07': m="July"; break; case '08': m="August"; break; case '09': m="September"; break;
				case '10': m="October"; break; case '11': m="November"; break; case '12': m="December"; break;
			}
			$('#mtitlemonth2').html(m);
			$('#mtitledayhldr2 span').html(d[1]);
		});
		$('.milstnchkbx').change(function(){
			var id=$(this).data('id');
			if($(this).is(':checked')){
				location.href='<?php echo BASE_URL; ?>projects/view/companyid/<?php echo $data['request']['uri_data']['companyid'];?>/projectview/<?php echo $data['request']['uri_data']['projectview'];?>/milestonecomplete/'+id+'/';
			}else{
				location.href='<?php echo BASE_URL; ?>projects/view/companyid/<?php echo $data['request']['uri_data']['companyid'];?>/projectview/<?php echo $data['request']['uri_data']['projectview'];?>/milestoneuncomplete/'+id+'/';
			}
		})
	});
</script>
<div class="row-fluid">
	<div><button class="btn btn-success" data-toggle="modal" data-target="#myModal">Create New Milestone</button></div>
	<!-- Modal -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h4 class="modal-title" id="myModalLabel">Create New Milestone</h4>
		  </div>
		  <div class="modal-body">
			<h2>Milestones</h2>
			<form method="post" action="">
					<div class="contentwrap">
						 <div class="col-md-3">
							<div class="mtitlehldr">
								<div class="mtitlemonth" id="mtitlemonth"><?php echo date('F');?></div>
								<div class="mtitledayhldr" id="mtitledayhldr">
									<span><?php echo date('d');?></span>
								</div>
							</div>
						 </div>
						 <div class="col-md-9" style="padding-left:10px;">
								<h5>Give it a name</h5>
								<p>
									<input type="text" name="milestonename"/>
								</p>
								<h5>Description</h5>
								<p>
									<textarea name="description"></textarea>
								</p>
								<div class="col-md-6">
									<h5>When is it due?</h5>
									<p>
										<input type="text" name="duedate" id="duedate" style="width:100px;"/>
									</p>
								</div>
								<div class="col-md-6">
									<h5>Who's responsible?</h5>
									<p>
										<?php
										if(!empty($data['freelancer'])){
											echo'<select name="responsible">';
												foreach($data['freelancer'] as $f)
												{
													echo'<option value="'.$f['id'].'">'.ucwords($f['firstname']).' '.ucwords($f['lastname']).(($this->current_userid()==$f['id'])?' (Me)':'').'</option>';
												}
											echo'</select>';
										}else{
										 echo'<div class="alert alert-danger">Please add freelancer to your company to assign a milestone.</div>';
										}
										?>
									</p>
								</div>
								<div class="clearfix"></div>
						 </div>
						 <div class="clearfix"></div>
					</div>
			
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			<button type="submit" class="btn btn-success">Save changes</button>
		  </div>
		  </form>
		</div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
	<?php if($data['request']['uri_data']['editmilestone']<>""){ ?>
			<!-- Modal -->
				<script>
					jQuery(document).ready(function($){ 
						$('a[href="#milestone"]').tab('show');
						$('#milestoneedit').modal('show');
					});
				</script>
				<div class="modal fade" id="milestoneedit" role="dialog" aria-labelledby="msmyModalLabel" aria-hidden="true">
				  <div class="modal-dialog">
					<div class="modal-content">
					  <div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="msmyModalLabel">Update Milestone Details</h4>
					  </div>
					  <div class="modal-body">
						<form method="post" action="<?php echo BASE_URL; ?>projects/view/companyid/<?php echo $data['request']['uri_data']['companyid'];?>/projectview/<?php echo $data['request']['uri_data']['projectview'];?>/updatemilestone/<?php echo $data['request']['uri_data']['editmilestone'];?>/">
								<div class="contentwrap">
									 <div class="col-md-3">
										<div class="mtitlehldr">
											<div class="mtitlemonth" id="mtitlemonth2"><?php echo date('F'); ?></div>
											<div class="mtitledayhldr" id="mtitledayhldr2">
												<span><?php echo date('d');?></span>
											</div>
										</div>
									 </div>
									 <div class="col-md-9" style="padding-left:10px;">
											<h5>Give it a name</h5>
											<p>
												<input type="text" name="milestonename" value="<?php echo $data['editmilestone']['name']; ?>"/>
											</p>
											<h5>Description</h5>
											<p>
												<textarea name="description"><?php echo $data['editmilestone']['description']; ?></textarea>
											</p>
											<div class="col-md-6">
												<h5>When is it due?</h5>
												<p>
													<input type="text" name="duedate" value="<?php echo date('m/d/Y',strtotime($data['editmilestone']['date_due'])); ?>" id="duedate2" style="width:100px;"/>
												</p>
											</div>
											<div class="col-md-6">
												<h5>Who's responsible?</h5>
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
											</div>
											<div class="clearfix"></div>
									 </div>
									 <div class="clearfix"></div>
								</div>
						
					  </div>
					  <div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button type="button" class="btn btn-warning" onclick="if(confirm('Are you sure to delete this milestone?')==true){ location.href='<?php echo BASE_URL; ?>projects/view/companyid/<?php echo $data['request']['uri_data']['companyid'];?>/projectview/<?php echo $data['request']['uri_data']['projectview'];?>/deletemilestone/<?php echo $data['request']['uri_data']['editmilestone'];?>/'; }">Delete</button>
						<button type="submit" name="updatemilestone" class="btn btn-success">Save changes</button>
					  </div>
					  </form>
					</div><!-- /.modal-content -->
				  </div><!-- /.modal-dialog -->
				</div><!-- /.modal -->
	<?php } ?>
	<div class="panel panel-default" style="margin-top:10px;">
		<div class="clearfix"></div>
	  <div class="panel-body">
		<?php
			if(!empty($data['milestones']))
			{
				echo'<ul class="list-group">';
					foreach($data['milestones'] as $m)
					{
					
						echo'<li class="list-group-item">';
						?>
							<div class="col-md-2">
								<div class="mtitlehldr">
									<div class="mtitlemonth"><?php echo date('F',strtotime($m['date_due']));?></div>
									<div class="mtitledayhldr">
										<div><span><?php echo date('d',strtotime($m['date_due']));?></span></div>
										<div><span style="font-size:14px;margin-bottom:10px"><?php echo date('l',strtotime($m['date_due']));?></span></div>
										<div class="clearfix"></div>
									</div>
									<div class="clearfix"></div>
								</div>
							</div>
							<div class="col-md-9">
								<?php if($m['is_completed']=='1'){ ?>
								<h3 title="Created by <?php echo ucwords($m['author']); ?>" style="text-decoration:line-through">
									<input type="checkbox" data-id="<?php echo $m['id']; ?>" checked  class="milstnchkbx"> <?php echo $m['name']; ?>
								</h3>
								<?php }else{
								?>
								<h3 title="Created by <?php echo ucwords($m['author']); ?>">
									<input type="checkbox" data-id="<?php echo $m['id']; ?>" class="milstnchkbx"> <?php echo $m['name']; ?>
								</h3>
								<?php 
								} ?>
								<div class="mdescrptn"><?php echo nl2br($m['description']); ?></div>
								<div style="margin:10px 10px;">
									<span><?php echo ucwords($m['author']); ?> is responsible.</span>
								</div>
								<?php
									if($m['addedby_user_id']==$this->current_userid())
									{
									?>
									<div style="margin-bottom:20px;">
										<a href="<?php echo BASE_URL; ?>projects/view/companyid/<?php echo $data['request']['uri_data']['companyid'];?>/projectview/<?php echo $data['request']['uri_data']['projectview'];?>/editmilestone/<?php echo $m['id'];?>/" class="label label-info">
											<span class="glyphicon glyphicon-edit"></span> Edit Milestone
										</a>
									</div>
									<?php
									}
								?>
								<div class="clearfix"></div>
							</div>
							<div class="clearfix"></div>
						<?php
						echo'</li>';
					}
				echo'</ul>';
			}else{
				echo'<div class="alert alert-info"><strong>Heads up!</strong> Start creating milestone now.</div>';
			}
		?>
	  </div>
	</div>
</div>