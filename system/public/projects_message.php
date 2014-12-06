<?php if($data['request']['uri_data']['createmessage']=="") { ?>
	<a href="<?php echo BASE_URL; ?>projects/view/companyid/<?php echo $data['request']['uri_data']['companyid'];?>/projectview/<?php echo $data['request']['uri_data']['projectview'];?>/createmessage/true/" class="btn btn-success">Create New Message</a>
<?php } 
if($data['request']['uri_data']['messages']=="true")
	{
		?>
		<script type="text/javascript">
			jQuery(document).ready(function($){ 
						$('a[href="#messages"]').tab('show');
			});
		</script>
		<?php
	}
?>
<?php
	if($data['request']['uri_data']['createmessage']<>"true")
	{
		?>	
			<script type="text/javascript">
				$ = jQuery.noConflict();
				jQuery(document).ready(function($){ 
					listmessage('<?php echo $data['request']['uri_data']['projectview']; ?>');
				});
				function viewmessage(id){
					$('#listmessages').html('Loading content..');
					$.get('<?php echo BASE_URL; ?>ajaxmessage/viewmessage/id/'+id+'/',function(data){
						$('#listmessages').html(data);
					});
				}
				function comment(id,msg,obj,hldr){
					if(msg.val().length>0){
						obj.val('Saving...');
						$.post('<?php echo BASE_URL; ?>ajaxmessage/savecomment/',{ id:id,msg:msg.val() },function(data){
							obj.val('Reply');
							alert('You reply has been published.');
							msg.val('');
							hldr.html(data);
						});
					}
				}
				function listmessage(id){
					$('#listmessages').html('Loading content..');
					$.get('<?php echo BASE_URL; ?>ajaxmessage/listmessage/projectid/'+id+'/',function(data){
						$('#listmessages').html(data);
					});
				}
			</script>
			<div id="listmessages" style="margin-top:10px;margin-left:10px;"></div>
		<?php
	}else{
		?>
		<script type="text/javascript">
			jQuery(document).ready(function($){ 
						$('a[href="#messages"]').tab('show');
					
					$('#chkbxanyone').click(function(){
							if($(this).is(':checked')){
								$('.people').each(function(){
									$(this).prop('checked','true');
								});
							}else{
								$('.people').each(function(){
									$(this).removeAttr('checked');
								});
							}
						});
					
				});
		</script>
		<form method="post" action="">
			<div style="width:600px" class="contentwrap">
				<h2>Create New Message <a  href="<?php echo BASE_URL; ?>projects/view/companyid/<?php echo $data['request']['uri_data']['companyid'];?>/projectview/<?php echo $data['request']['uri_data']['projectview'];?>/messages/true/" class="btn btn-link">Cancel</a></h2>
				<p><span class="help-block">Subject</span><input type="text" name="subject" required maxlength="255"/></p>
				<p><span class="help-block">Message</span><textarea name="content" style="height:200px;" required></textarea></p>
				<div class="contentwrap">
					Who can see this message?
					<div style="margin-top:10px;margin-left:10px;">
						<div style="margin-bottom:5px;"><input type="checkbox" name="people" id="chkbxanyone"  style="margin-top:-2px;"> Anyone</div>
						<?php
						if(!empty($data['freelancer'])){

							//add owner
							$owner = $this->fetch("select * from user_tb where id='".$data['view']['owner']."'",true);
							?>
								<div style="margin-bottom:5px;"><input type="checkbox" name="people[]" class="people" value="<?php echo $owner['id']; ?>" style="margin-top:-2px;"> <?php echo ucwords($owner['firstname'].' '.$owner['lastname']);?></div>
							<?php
							foreach($data['freelancer'] as $f){
								?>
								<div style="margin-bottom:5px;"><input type="checkbox" name="people[]" class="people" value="<?php echo $f['id']; ?>" style="margin-top:-2px;"> <?php echo ucwords($f['firstname'].' '.$f['lastname']);?></div>
								<?php
							}

						}
						?>
					</div>
				</div>
				<p>
					<input type="submit" name="createnewmessage" value="Post Message" class="btn btn-primary">
					<a  href="<?php echo BASE_URL; ?>projects/view/companyid/<?php echo $data['request']['uri_data']['companyid'];?>/projectview/<?php echo $data['request']['uri_data']['projectview'];?>/messages/true/" class="btn btn-link">Cancel</a>
				</p>
			</div>
		</form>
		<?php
	}	
?>