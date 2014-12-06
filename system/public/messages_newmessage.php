<?php $this->headers();  ?>
<div class="row-fluid contentwrap">
	<div class="page-header">
		  <h1>Messages <small>start the talk and collaborate with team.</small></h1>
		  <?php echo $data['msgAlert']; ?>
	</div>
	<div class="row-fluid">
		<div class="col-md-2 col-md-offset-0"><?php include_once('messages_sidebar.php'); ?></div>
		<div class="col-md-9">
			<!-- body -->
				


				<div class="panel panel-default">
				  <div class="panel-heading">
				    <h3 class="panel-title">Create new message</h3>
				  </div>
				  <div class="panel-body">
				   		<div class="col-md-10" style="margin-left:20px">
						
						<div class="form-group">
							<form method="post" action="<?php echo BASE_URL;?>messages/msgInsert/">	
							<div style="padding:10px"> <!-- border:2px solid; border-radius:10px; box-shadow: 1px 3px 5px #888888; style div -->
								<div class="form-group">
								<label for="to">To </label>
								<input name="to" required type="text" placeholder="jonh.doe@domain.com" maxlength="80" class="form-control" class="newmsgstyle" style="width:280px">
								</div><!-- formgroup -->
								
								<div class="form-group">
								<label for="subject">Subject </label>
								<input name="subject" type="text" maxlength="80" class="form-control" class="newmsgstyle">
								</div><!-- formgroup -->
								
								<div class="form-group">
								<label for="message">Message </label>
								<textarea name="message" class="form-control" rows="10" class="newmsgstyle1" style="resize:vertical; width:600px"></textarea>
								<p>avoid spamming of message</p>
								</div><!-- formgroup -->
								
								<button class="btn btn-success">Send</button> <a class="AnchorStyle" href="<?php echo BASE_URL;?>messages/">Cancel</a>
							</div><!-- formgroup -->
							</form>
						</div>
				</div><!-- colmd4 -->
				  </div>
				</div>	


				
				<!-- end of body -->
			</div>
			<div class="clearfix"></div>
		</div>
</div>

<script src="//tinymce.cachefly.net/4.0/tinymce.min.js"></script>
<script>
	 tinymce.init({selector:'textarea'});
</script>
<?php 
// echo $this->pr($data);
$this->footers();  ?>