<?php 
$data['viewpost'] = $this->fetch("select a.*,(select firstname from user_tb where id =a.user_id) as firstname from project_tb a where id='".$data['request']['uri_data']['postid']."'",true);
$this->headers();  ?>
<div class="contentwrap">
	<div class="page-header">
		<!-- <h1>View job<small><small></h1> -->
	</div>
	<div class="row-fluid">

<div class="col-md-1">
	<?php /*if($data['viewpost']['postedby_user_id'] == $data['session']['currentLogin']['id']){ ?>
	<p>
		<a href="<?php echo BASE_URL;?>find-work/repost/postid/<?php echo $data['viewpost']['id']; ?>/">
			<label class="label label-info" style="cursor:pointer; font-size:12px">Modify Post</label>
		</a>
	</p>

	<p>
	
		<a onclick="if(confirm('Are you sure to delete this task?')==true){location.href='<?php echo BASE_URL;?>find-work/deletepost/postid/<?php echo $data['viewpost']['id']; ?>/';}">
			<label class="label label-danger" style="cursor:pointer; font-size:12px">Delete Post</label>
		</a>
<!-- 
onclick="

 if(confirm('Are you sure to delete this task?')==true){
  location.href='http://localhost/demeter/projects/view/companyid/5/projectview/3/deletetask/3/';
  }" -->

	</p>
	<?php }*/ ?>
</div>


	<div class="col-md-8 col-md-offset-1">
		<div class="panel panel-info">
			<div class="panel-heading">
				<h3 class="panel-title"><?php echo $data['viewpost']['name'];?></h3>
			</div>
		<div class="panel-body">
			<div class="col-md-11 col-md-offset-1" style="border-bottom:1px solid #B9BCC3;">
												
					

					<table class="table table-striped" style="width:500px;">
			 			<tr>
			 				<td><strong><?php 
			 				if($data['viewpost']['isfixed']  == 0){
			 					echo '<span class="">Hourly Rate</span>';
			 				}else{
			 					echo '<span class="">Fixed Rate</span>';
			 				}							 			
			 			 ?></strong></td>
			 			 <td><?php echo $data['viewpost']['total_price']; ?> <small>USD</small>
			 			 	<?php if($data['viewpost']['isnegotiable']=='1'){ echo'Negotiable';} ?>
			 			 </td>
			 			</tr>
			 			<tr>
			 				<td><strong>Duration</strong></td>
			 				<td><?php echo ucwords($data['viewpost']['duration']);?></td>
			 			</tr>
			 			<?php 
			 			if($data['viewpost']['isfixed']== 0 and $data['viewpost']['needed']<>""){
			 			?>
			 			<tr>
			 				<td><strong>Needed Manpower</strong></td>
			 				<td><?php echo ucwords($data['viewpost']['needed']);?></td>
			 			</tr>
			 			<?php
			 			}
			 			?>
			 			<tr>
			 				<td><strong>Country</strong></td>
			 				<td><?php echo ucwords($this->country($data['viewpost']['location']));?></td>
			 			</tr>
			 			<tr>
			 				<td><strong>Posted by</strong></td>
			 				<td><a class="label label-warning" href="<?php echo BASE_URL.'profile/sprofile/sid/'.$data['viewpost']['user_id'].'/';?>"><?php echo $data['viewpost']['firstname'];?></a> <small><?php echo $this->timeago($data['viewpost']['date_added']);?></small></td>
			 			</tr>
			 		</table>
			 		<h5 style="border-bottom:1px solid #B9BCC3;">Description :</h5>
					<div style="overflow:hidden">
						<h5>&nbsp;&nbsp;<?php echo nl2br(urldecode($data['viewpost']['description']));?></h5>
					</div>
					
					
			</div>

			<?php if(!empty($data['session'])){
					if($data['viewpost']['user_id']<>$this->current_userid()){
						?>
						<a href="#" Class="btn btn-success pull-right" data-toggle="modal" data-target="#myModal" style="margin-top:10px">Apply this Job</a>
						<?php
					}

			}else{?>
			<a href="<?php echo BASE_URL;?>login/" Class="btn btn-success pull-right" style="margin-top:10px">Login</a>
			
			<?php }?>


			<a href="<?php echo BASE_URL;?>find-work/" Class="btn btn-link pull-right" style="margin-top:10px">Cancel</a>

			<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			  <div class="modal-dialog">
			    <div class="modal-content" style="width:800px; margin-left:-100px; margin-top:100px">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			        <h4 class="modal-title" id="myModalLabel">Apply to this Job</h4>
			      </div>
			      <div class="modal-body">
			      	<form method="post" action="<?php echo BASE_URL;?>find-work/applysubmit/">
			      	
			      	<input type="hidden" name="project_id" value="<?php  echo $data['viewpost']['id'];?>">
			      	<input type="hidden" name="applicant_id" value="<?php  echo $this->current_userid();?>">
			      	<input type="hidden" name="user_id" value="<?php  echo $data['viewpost']['user_id'];?>">
			      	<input type="hidden" name="name" value="<?php echo $data['viewpost']['name'];?>">
			      
			      	<h5>Position : <?php echo $data['viewpost']['name'];?></h5>
			      	<h5>Include your Cover letter here</h5>
			      		
			    		<textarea name="coverletter" class="form-control" rows="10" style="overflow:hidden height:auto; resize:vertical">&#10;&#10;Greetings! &#10;&#10;I would like to apply for a <?php echo $data['viewpost']['name'];?> which is posted at <?php echo BASE_URL;?>find-work/viewpost/postid/<?php echo $_REQUEST['uri_data']['postid']; ?>/ &#10;&#10;Sincerly, &#10;<?php echo $this->get_var("select CONCAT(firstname,' ',lastname) from user_tb where id='".$this->current_userid()."'"); ?>
			    		</textarea>
			    	
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			        <button type="submit" class="btn btn-success">Submit</button>
			      </form>
			      </div>
			    </div><!-- modal-content -->
			  </div><!-- modal-dialog -->
			</div> <!-- modal -->
		
		</div><!-- panelbody -->
		</div><!-- paneldefualt -->

	</div><!-- col-md-8 col-md-offset-1 -->
	</div><!-- rowfluid -->



</div> <!-- Contentwrap -->
<div class="clearfix"></div>

<?php $this->footers();  ?>