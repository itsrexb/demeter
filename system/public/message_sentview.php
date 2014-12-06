<?php $this->headers();  ?>
<div class="row-fluid contentwrap">
	<div class="page-header">
		  <h1>Messages <small>start the talk and collaborate with team.</small></h1>
		  
	</div>
	<div class="row-fluid">
		<div class="col-md-2"><?php include_once('messages_sidebar.php'); ?></div>
		<div class="col-md-9">
			<!-- body -->
			<div class="panel panel-default">
				<div class="panel-heading">
				    <h3 class="panel-title"><?php echo $data['viewSentMessages']['subject']; ?></h3>
				</div>
			  <div class="panel-body">
			    
			  		<table class="">
					<tr>
					   <td>
						 	<p><?php echo $data['viewSentMessages']['firstname'];?><br>
						 	<?php echo $data['viewSentMessages']['email']; ?><br>
						 	</p>
						    <hr>
							<p><?php echo $data['viewSentMessages']['content']; ?></p>
							<p class="pull-left"><?php echo $this->timeago($data['viewSentMessages']['date_sent']); ?></p>
		               </td>
					</tr>
					
								
					</table>

				 </div><!-- panelbody -->
			</div><!-- paneldefault -->

			<!-- end of body -->
		</div>

		<div class="clearfix"></div>
	</div>
</div>



<?php 
#echo $this->pr($data);
$this->footers();  ?>