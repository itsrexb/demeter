<?php $this->headers();?>

<div class="row-fluid contentwrap">
	<div class="page-header">
		  <h1>Profile <small> Hello <?php echo $data['sprofile']['firstname']; ?></small></h1>
	</div>
	

<div class="col-md-6 col-md-offset-3" style="overflow:hidden">
			<?php echo $data['msg']; ?>
			<div class="row-fluid">								
					<div class="col-md-12">
							<div class="col-md-9">
								<table class="table table-striped" style="width:90%">
										<tr>
											<td><strong>User ID</strong></td>
											<td><?php echo $data['sprofile']['username']; ?></td>
										</tr>
										<tr>
											<td><strong>Full Name</strong></td>
											<td><?php echo $data['sprofile']['firstname']; ?>   <?php echo $data['sprofile']['lastname']; ?> </td>
										</tr>
										<tr>
											<td><strong>Title</strong></td>
											<td><?php echo $data['sprofile']['title']; ?></td>
										</tr>
										<tr>
											<td><strong>Rate</strong></td>
											<td><?php echo $data['sprofile']['rate']; ?> <small>USD</small></td>
										</tr>
										<tr>
											<td><strong>Reviews</strong></td>
											<td><?php $avgstar = $this->fetch("SELECT avg(stars) as stars, count(*) as reviews FROM `review_tb` where user_id='".$data['request']['uri_data']['sid']."'",true);

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
										     	echo'<br>';
										     	echo (int)$avgstar['reviews'];

											?> reviews</td>
										</tr>
									</table>	
							</div>
							<div style="text-align:center" class="col-md-3 pull-right">
									<?php if($data['sprofile']['image_filename']==""){ ?>
									<img class="img-circle" src="<?php echo BASE_URL_PUBLIC; ?>images/defaultuser.jpg" style="width:150px; height:150px; margin: 0px auto;">
								 <?php }else{ ?>
									<img class="img-circle" src="<?php echo BASE_URL_PUBLIC; ?>images/profileimage/<?php echo $data['sprofile']['image_filename']; ?>" style="width:150px; height:150px; margin: 0px auto;">
								<?php } ?>
							</div>
							<div class="clearfix"></div>

							<div class="panel panel-info">
							  <div class="panel-heading">
							    <h3 class="panel-title"><span class="glyphicon glyphicon-tag"></span> Skills</h3>
							  </div>
							  <div class="panel-body">
							    <p style="word-wrap:break-word;"> <?php echo ucwords(nl2br($data['sSkill']['meta_value']));?></p>	
							  </div>
							</div>		

							<div class="panel panel-info">
							  <div class="panel-heading">
							    <h3 class="panel-title"><span class="glyphicon glyphicon-book"></span> Work Experience</h3>
							  </div>
							  <div class="panel-body">

								    <p style="word-wrap:break-word;"><?php echo nl2br($data['sworkexp']['meta_value']);?></p>
									
							  		<?php
							  		$companies = $this->fetch("select cm.*,cu.position,cu.date_joined,cu.is_active 
											from company_user cu
											left join company_tb cm on cm.id = cu.company_id 
											where cu.user_id='".$data['request']['uri_data']['sid']."'
											and cm.name<>''
										");
							  		if(!empty($companies)){
							  			?>
							  				<h6><span class="glyphicon glyphicon-info-sign"></span> Work Experience through <?php echo SYS_NAME;?></h6>
							  			<?php
							  			echo '<ul class="list-group">';
							  			foreach($companies as $c){
							  				?>
							  				<li class="list-group-item">
							  					<div><strong><?php echo $c['name'];?></strong> 
							  						<small>owned by <a href="<?php echo BASE_URL.'profile/sprofile/sid/'.$c['owner'].'/'; ?>"><?php echo $this->get_var("select concat(firstname,' ',lastname)  from user_tb where id='".$c['owner']."'");?>
							  								</a>
							  						</small></div>
							  					<div style="margin-top:5px;font-size:11px;">
							  					 <?php if($c['position']<>""){ echo'Worked as <strong>'.$c['position'].'</strong>'; } ?> started on <?php echo date('F j, Y',strtotime($c['date_joined']))?></div>
							  					 <?php
							  					 	//display projects
									  				$projects = $this->fetch("select * from project_tb
									  				 where 
									  				 company_id ='".$c['id']."'
									  				 and assignedto_userid ='".$data['request']['uri_data']['sid']."'
									  				 ");
									  				if(!empty($projects)){
									  					?>
									  					<div style="margin-left:10px;margin-top:10px;">
									  						<div style="font-size:12px;font-weight:bold">Projects:</div>
									  					<?php
									  					foreach($projects as $pr){
									  						?>
									  							<div style="font-size:11px;margin-left:10px;margin-bottom:5px;"><?php echo ucwords($pr['name']); ?></div>
									  						<?php
									  					}
									  					?></div><?php
									  				}
									  			?>
							  				</li>
							  				<?php
							  			}
							  			echo'</ul>';

							  			

							  		}
							  		?>


							  </div>
							</div>	

							<div class="clearfix"></div>			

							<div class="panel panel-info">
							  <div class="panel-heading">
							    <h3 class="panel-title"><span class="glyphicon glyphicon-envelope"></span> Reviews</h3>
							  </div>
						  	<div class="panel-body">
						     	<script type="text/javascript">
						     		jQuery(document).ready(function($){
						     				$('.starreview').click(function(){
						     						var val = $(this).data('val');
						     						$('#starview').val(val);
						     						$('.starreview').removeClass('red');
						     						 $('.starreview').each(function(){
						     						 		if(parseInt($(this).data('val'))<=parseInt(val)){
						     						 				$(this).addClass('red');
						     						 		}
						     						 });
						     				});
						     		})
						     	</script>

						  		<?php 
						  	 if(($this->get_var("select count(*) 
						  	 				from review_tb
						  	 				where 
						  	 				reviewedby='".$this->current_userid()."' and
						  	 				user_id ='".$data['request']['uri_data']['sid']."'
						  	 				")<1)  
						  	 				 and 
						  	 				 !empty($_SESSION)
						  	 				 and $data['request']['uri_data']['sid']<>$this->current_userid()
						  	 				){
						  	 					?>
							  		 <form method="post" action="">
							  		 			 <div>
											     	 <textarea required="required" name="reviewcontent" style="height: 147px;outline: medium none;width: 100%;"></textarea>
											     </div>
											     <div style="margin-bottom:30px">
										  		 			<div class="col-md-6">
													     			 <span class="glyphicon glyphicon-star starreview" data-val="1"></span>
													     			 <span class="glyphicon glyphicon-star starreview" data-val="2"></span>
													     			 <span class="glyphicon glyphicon-star starreview" data-val="3"></span>
													     			 <span class="glyphicon glyphicon-star starreview" data-val="4"></span>
													     			 <span class="glyphicon glyphicon-star starreview" data-val="5"></span>
													     			 <input type="hidden" name="starview" value="" id="starview">
													     		</div>
													     		<div class="col-md-6" style="margin-top:10px;text-align:right">
												     					<?php if($_SESSION['currentLogin']['image_filename']==""){ ?>
																								<img class="img-circle" style="width: 15px; margin: 0px auto;" src="<?php echo BASE_URL_PUBLIC; ?>images/defaultuser.jpg">
																							 <?php }else{ ?>
																								<img  src="<?php echo BASE_URL_PUBLIC; ?>images/profileimage/<?php echo $_SESSION['currentLogin']['image_filename']; ?>" style="width: 15px; margin: 0px auto;">
																							<?php } ?>
													     			<button type="submit" style="margin-top: -15px;" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-ok-sign"></i>Add my review</button>
													     		</div>
													     		<div class="clearfix"></div>
													  </div>
													  <div style="margin-bottom:20px;"></div>
						 				 </form>
						 			<?php } ?>
						 						<div class="clearfix"></div>
									     	<?php
									     		$reviews = $this->fetch("select a.*,b.firstname,b.lastname,b.image_filename from review_tb a
									     									left join user_tb b on b.id = a.reviewedby
									     									 where a.user_id='".$data['request']['uri_data']['sid']."'");
									     		if(!empty($reviews)){
									     			 foreach($reviews as $r){
									     			 		?>
									     			 		<div >
										     			 			<div class="col-md-2" style="text-align:center">
										     			 					<a href="<?php echo BASE_URL.'profile/sprofile/sid/'.$r['reviewedby'].'/'; ?>">
											     			 					<?php if($r['image_filename']==""){ ?>
																						<img class="img-circle" src="<?php echo BASE_URL_PUBLIC; ?>images/defaultuser.jpg">
																					 <?php }else{ ?>
																						<img  src="<?php echo BASE_URL_PUBLIC; ?>images/profileimage/<?php echo $r['image_filename']; ?>" style="width: 60px; margin: 0px auto;">
																					<?php } ?>
																				</a>
										     			 			</div>
										     			 			<div class="col-md-10">
										     			 					<div>
										     			 						<?php echo '<strong>'.ucwords($r['firstname'].' '.$r['lastname']).'</strong>, <small>'.$this->timeago($r['date_added']).'</small>'; ?>
										     			 					</div>
										     			 					<div>
										     			 							<?php 
										     			 							for($x=1;$x<=(int)$r['stars'];$x++){
										     			 								?>
										     			 								<span class="glyphicon glyphicon-star starreviewsmall red"></span>
										     			 								<?php
										     			 							}
										     			 							for($x=1;$x<=(5-(int)$r['stars']); $x++){
										     			 								?>
										     			 								<span class="glyphicon glyphicon-star-empty starreviewsmall"></span>
										     			 								<?php
										     			 							}
										     			 							?>
										     			 					</div>
										     			 					<div class="styled-notes" style="margin-top:10px;">
										     			 						<?php echo nl2br($r['comments']); ?>
										     			 					</div>
										     			 			</div>
										     			 				<div class="clearfix"></div>
										     			 				<div style="margin-bottom:20px;"></div>
									     			 		</div>
									     			 		<?php
									     			 }
									     		}else{
									     			?>
									     			<div style="margin-top:20px" class="alert alert-warning">
									     					<strong>Horrah!</strong> Make your first review today.
									     			</div>
									     			<?php
									     		}
									     	?>
					 		 </div>
					 		</div>
					</div>
				<div class="clearfix"></div>															
			</div>										

	</div>
	<div class="clearfix"></div>
</div> <!-- row fluid -->
<?php 
// echo $this->pr($data);
$this->footers();  ?>