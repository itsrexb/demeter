<?php $this->headers();  ?>
<div class="row-fluid contentwrap">
	<div class="page-header">
		  <h1>Messages <small>start the talk and collaborate with team.</small></h1>
		  <?php echo $data['msgAlert']; ?>
	</div>
	<div class="row-fluid">
		<div class="col-md-2"><?php include_once('messages_sidebar.php'); ?></div>
		<div class="col-md-9">
			<!-- body -->
			<div class="panel panel-default">
				<div class="panel-heading">
				    <h3 class="panel-title"><?php echo $data['viewmessages']['subject']; ?></h3>
				</div>
			  <div class="panel-body" style="overflow:hidden">
			    
			  		<table class="table">
					<tr>
					   <td>
						 	<p>
						 		<?php echo $data['viewmessages']['firstname'];?><br>
						 		<?php echo $data['viewmessages']['email']; ?><br>
						 	</p>
						    <hr>
							<p>
								
								<?php echo $data['viewmessages']['content'];?>
								
							</p>
							<p class="pull-left"><?php echo $this->timeago($data['viewmessages']['date_sent']); ?></p>
		               </td>
					</tr>
					
								
					</table>

					<hr>
					<div><button id="btn-reply" class="btn btn-link">Reply</button></div>

			  </div><!-- panelbody -->
			</div><!-- paneldefault -->

			<div id="reply-div" style="display:none">
				<form action="<?php echo BASE_URL;?>messages/replymsg/sendto/
					<?php echo $data['viewmessages']['0']; ?>/" method="post">
					
				<div>
					<input hidden type="text" name="subject" value="<?php echo $data['viewmessages']['subject']; ?>">
				</div>
				<div>
					<textarea name="content" placeholder="Type your message here..."></textarea>
				</div>
				<div class="pull-right">
					 <button class="btn btn-success">Send</button>
				</div>
				</form>
			</div>
			


			<!-- end of body -->
		</div><!-- colmd9 -->

		<div class="clearfix"></div>
	</div><!-- rowfluid -->
</div>
<script type="text/javascript">
$(document).ready(function(){
	$("#btn-reply").click(function(){
		$("#reply-div").slideToggle("fast");
	});
});
</script>


<?php 
#echo $this->pr($data);
$this->footers();  ?>