<?php 
	$data['jobspost'] = $this->fetch("select * from project_tb where isSearchable='1' and is_active='1' order by id DESC");
	$this->headers();  ?>
	<div class="contentwrap">
			<div class="page-header">
				<h1 >Find Jobs <small> that suitable to your skills.</small></h1>
				<?php echo $data['msgAlert'];?>
			</div>


	   <div class="row-fluid">	
		
			<div class="col-md-8 col-md-offset-1">
				<?php include_once('find_work_searchbar.php');?>

			 </div><!-- /.col-lg-6 -->

			 <div class="col-md-8 col-md-offset-1">
				<h3><span class="glyphicon glyphicon-info-sign alert-warning"></span> Recommended Jobs <small>that matches your skills</small></h3>
			 	<?php if(!empty($data['jobspost']))
			 	{		 	

			 		//get current user skills meta
					$skills = explode(',',$this->get_user_meta($this->current_userid(),"skills",true));
					//remove spaces
					$skillset = array();
					if(!empty($skills)){
						foreach($skills as $s){
							$skillset[]= strtolower(trim($s));
							$replace[] =  '<strong style="color:red"><em>'.trim($s).'</em></strong>';
						}
					}
					$pattern = implode('|', $skillset);

			 		foreach($data['jobspost'] as $postjob)
			 		 {
			 		 	if( preg_match('/'.$pattern.'/i', $postjob['description']) || 
			 		 		preg_match('/'.$pattern.'/i', $postjob['name'])){
						?>
							<div  style="border-bottom:1px solid #B9BCC3; padding-bottom:10px">
								 		<div>
								 		<a href="<?php echo BASE_URL;?>find-work/viewpost/postid/<?php echo $postjob['id']; ?>/" class="btn btn-link" style="margin-left:-14px; overflow:hidden"><strong><?php echo str_ireplace($skillset,$replace,$postjob['name']);?></strong></a>
								 		<small class="alert-success"><?php echo $this->timeago($postjob['date_added']) ?></small>
								 		</div>
								 		
								 		<table class="table table-striped" style="width:500px;">
								 			<tr>
								 				<td><strong><?php 
								 				if($postjob['isfixed']  == 0){
								 					echo '<span class="">Hourly Rate</span>';
								 				}else{
								 					echo '<span class="">Fixed Rate</span>';
								 				}							 			
								 			 ?></strong></td>
								 			 <td><?php echo $postjob['total_price']; ?> <small>USD</small>
								 			 	<?php if($postjob['isnegotiable']=='1'){ echo'Negotiable';} ?>
								 			 </td>
								 			</tr>
								 			<tr>
								 				<td><strong>Duration</strong></td>
								 				<td><?php echo ucwords($postjob['duration']);?></td>
								 			</tr>
								 			<?php 
								 			if($postjob['isfixed']== 0 and $postjob['needed']<>""){
								 			?>
								 			<tr>
								 				<td><strong>Needed Manpower</strong></td>
								 				<td><?php echo ucwords($postjob['needed']);?></td>
								 			</tr>
								 			<?php
								 			}
								 			?>
								 			<tr>
								 				<td><strong>Country</strong></td>
								 				<td><?php echo ucwords($this->country($postjob['location']));?></td>
								 			</tr>
								 		</table>
								 		<div style="overflow:hidden">
								 			<?php echo str_ireplace($skillset,$replace,nl2br(substr($postjob['description'],0,600)));?>
								 			<a href="<?php echo BASE_URL;?>find-work/viewpost/postid/<?php echo $postjob['id']; ?>/" class="btn btn-link">see more..</a>
								 		</div>	
								 </div>
				<?php 
							}//end of preg_match
			 			}//end of foreach

			 			 if(!empty($skills)){
						 			?>
						 			<h3>Other Jobs</h3>
						 			<?php
						 			foreach($data['jobspost'] as $postjob)
								 		 {
								 		 	if( !preg_match('/'.$pattern.'/i', $postjob['description']) and 
								 		 		!preg_match('/'.$pattern.'/i', $postjob['name'])){
											?>
												<div  style="border-bottom:1px solid #B9BCC3; padding-bottom:10px">
													 		<div>
													 		<a href="<?php echo BASE_URL;?>find-work/viewpost/postid/<?php echo $postjob['id']; ?>/" class="btn btn-link" style="margin-left:-14px; overflow:hidden"><strong><?php echo str_ireplace($skillset,$replace,$postjob['name']);?></strong></a>
													 		<small class="alert-success"><?php echo $this->timeago($postjob['date_added']) ?></small>
													 		</div>
													 		
													 		<table class="table table-striped" style="width:200px;">
													 			<tr>
													 				<td><strong><?php 
													 				if($postjob['isfixed']  == 0){
													 					echo '<span class="">Hourly Rate</span>';
													 				}else{
													 					echo '<span class="">Fixed Rate</span>';
													 				}							 			
													 			 ?></strong></td>
													 			 <td><?php echo $postjob['total_price']; ?> <small>USD</small></td>
													 			</tr>
													 			<tr>
													 				<td><strong>Country</strong></td>
													 				<td><?php echo ucwords($this->country($postjob['location']));?></td>
													 			</tr>
													 		</table>
													 		<div style="overflow:hidden">
													 			<?php echo str_ireplace($skillset,$replace,nl2br(substr($postjob['description'],0,600)));?>
													 			<a href="<?php echo BASE_URL;?>find-work/viewpost/postid/<?php echo $postjob['id']; ?>/" class="btn btn-link">see more..</a>
													 		</div>	
													 </div>
									<?php 
												}//end of preg_match
								 			}//end of foreach
								}//if skills not empty

			 	
			 	}//notempty
			 	else{
			 		echo "No jobs available";
			 	}
			 	?>

			 </div><!-- /.col-lg-6 -->
			

		<div class="clearfix"></div>	
		</div><!-- rowfluid -->
	</div> <!-- Contentwrap -->



<?php $this->footers();  ?>