<?php $this->headers();  ?>
<div class="row-fluid">
<div class="page-header">
 
</div><!-- pageheader -->
<div class="col-md-10 col-md-offset-1" style="margin-top:-30px">
<div class="panel panel-info">
<div class="panel-heading">
	<h1>Messages <small>Send Personal Message</small></h1>
</div>
<div class="panel-body">
<div class="col-md-1 col-md-offset-2">
	<div class="form-group">
	<!-- <div style="padding:10px">  border:2px solid; border-radius:10px; box-shadow: 1px 3px 5px #888888; style div -->
		<a href="<?php echo BASE_URL;?>messages/newmessages/"><button class="btn btn-success">New Message</button> </a>
	</div><!-- formgroup -->
	<div class="form-group">
		<ul class="nav nav-pills nav-stacked">
			<li><a href="<?php echo BASE_URL;?>messages/"> Inbox</a></li>
			<li><a href="#"> Sent</a></li>
		</ul>
	</div><!-- formgroup -->
	</div><!-- col-md-1 col-md-offset-2 -->

<div class="col-md-6" style="margin-left:20px">
	
	<div class="form-group">
		
	<div style="padding:10px"> <!-- border:2px solid; border-radius:10px; box-shadow: 1px 3px 5px #888888; style div -->
		<div class="form-group">
		<label>To </label>
		<input type="text" maxlength="80" class="form-control" style="border:3px solid; color: #D2D2CD">
		</div><!-- formgroup -->
		<div class="form-group">
		<label>Subject </label>
		</div><!-- formgroup -->
		<div class="form-group">
		<input type="text" maxlength="80" class="form-control" style="border:3px solid; color: #D2D2CD">
		</div><!-- formgroup -->
		<div class="form-group">
		<label>Message </label>
		<textarea class="form-control" rows="10" maxlegnth="150" style="border: 3px solid #D2D2CD; color: #D2D2CD; resize:vertical">150 character only</textarea>
		</div><!-- formgroup -->
		<button class="btn btn-success">Send</button> <a class="AnchorStyleSkill" href="<?php echo BASE_URL;?>messages/">Cancel</a>
	</div><!-- formgroup -->

</div><!-- colmd6 -->

</div><!-- panelbody -->
</div><!-- panelinfo -->



</div> <!-- rowfluid -->

</div><!--  /container -->
<div class="clearfix"></div>
<?php $this->footers();  ?>