<?php $this->headers(); 
	
	$searchkey = $data['request']['searchjobs'];

 ?>
	<div class="contentwrap">
			<div class="page-header">
				<h1 >Find Jobs <small>that suitable to your skills.</small></h1>
				<?php echo $data['msgAlert'];?>
			</div>

	   <div class="row-fluid">	
			   	<div class="col-md-8 col-md-offset-1">
										<?php include_once('find_work_searchbar.php');?>

					 </div><!-- /.col-lg-6 -->
	   			 <div class="col-md-8 col-md-offset-1">
				<h5>Search Result for "<?php echo $_POST['searchjobs'];?>"</h5>
			 	<?php
			 		if(!empty($data['searchjob'] )){	 	
						 		foreach($data['searchjob'] as $searchjob)
						 		 {
									 	?>
											 <div style="border-bottom:1px solid #B9BCC3; padding-bottom:10px">
											 		<div style="font-size:15px;">
											 		<a  href="<?php echo BASE_URL;?>find-work/viewpost/postid/<?php echo $searchjob['id']; ?>/" class="btn btn-link" style="margin-left:-14px; font-weight:bold;overflow:hidden">
											 			<?php echo str_ireplace($searchkey,'<strong style="color:red;font-style:italic">'.$searchkey."</strong>",$searchjob['position_title']);?>
											 		</a><small class="alert-success"><?php echo $this->timeago($searchjob['date_added']) ?></small>
											 		</div>
											 		<table class="table table-striped" style="width:200px;">
											 			<tr>
											 				<td><strong><?php 
											 				if($searchjob['is_hourly']  == 0){
											 					echo '<span class="">Hourly Rate</span>';
											 				}else{
											 					echo '<span class="">Fixed Rate</span>';
											 				}							 			
											 			 ?></strong></td>
											 			 <td><?php echo $searchjob['rate']; ?> <small>USD</small></td>
											 			</tr>
											 			<tr>
											 				<td><strong>Country</strong></td>
											 				<td><?php echo ucwords($searchjob['location']);?></td>
											 			</tr>
											 		</table>

											 		<div>
											 			<?php echo str_ireplace($searchkey,'<strong style="color:red;font-style:italic">'.$searchkey."</strong>",substr($searchjob['description'],0,500));?>
											 			<a href="<?php echo BASE_URL;?>find-work/viewpost/postid/<?php echo $searchjob['id']; ?>/" class="btn btn-link">see more..</a>
											 		</div>
											 	 	
											 	
											 </div>


									 	<?php 
						 	}
				}else{
					?><div class="alert alert-warning">No matched criteria.</div><?php
				}
			 	?>

			 </div><!-- /.col-lg-6 -->


	
	   </div><!-- rowfluid -->
	</div> <!-- Contentwrap -->
	<div class="clearfix"></div>	

<?php $this->footers();  ?>