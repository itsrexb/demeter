<?php $this->headers();  ?>
<div class="row-fluid contentwrap">
	<div class="page-header">
		  <h1>Messages <small>start the talk and collaborate with team.</small></h1>
		  <?php echo $data['msgAlert']; ?>
	</div>
	<div class="row-fluid">
		<div class="col-md-2"><?php include_once('messages_sidebar.php'); ?></div>
		<div class="col-md-10">
			<!-- body -->
			
					<div class="panel panel-default" style="border-radius:5px">
							<div class="panel-heading">
					    		<h3 class="panel-title">Inbox message</h3>
							</div>
							<?php if($data['unreads'] > 0 or $data['countreadsmsg'] > 0 ){
								echo"<p style='margin-left:28px'>
									<input type='checkbox' id='selectallcheckbox' style='margin-top:10px'/>&nbsp;
									<em>check all</em> &nbsp;&nbsp;&nbsp;|  <button class='btn btn-link' id='deletemsg'>Move to archive</button>
								</p>";
							}else{

							}
							?>
					  <div class="panel-body">
										<!-- ##### already read message ####### -->		
										<table class="table contentwrap listpmmessages">
										<?php
											if($data['msgread'] <> ""){
												 foreach ($data['msgread'] as $msgreads) {
										?>

										<tr style="cursor:pointer;" class="<?php if($msgreads['is_read']=='1'){ echo 'read'; }else{ echo 'unread'; } ?>">

										    <td style="width:150px">
											  	<input type="checkbox" class="myCheckbox" name="myCheckbox" value="<?php echo $msgreads['id'];?>">

											  	<a href="<?php echo BASE_URL;?>profile/sprofile/sid/<?php echo $msgreads['sender_user_id']?>/">

											  	<?php if($msgreads['image_filename']=="")
											  			{ ?>
														   <img class="img-round" src="<?php echo BASE_URL_PUBLIC; ?>images/defaultuser.jpg" style="width:25px; height:25px; vertical-align:text-top">
												<?php }else
														{ ?>
															<img class="img-round" src="<?php echo BASE_URL_PUBLIC; ?>images/profileimage/<?php echo $msgreads['image_filename']; ?>" style="width:25px; height:25px; vertical-align:text-top;">
												<?php } ?>

													</a>

														<a style='vertical-align:text-middle; margin-left:10px;' href="<?php echo BASE_URL; ?>messages/viewmessage/msgid/<?php echo  $msgreads['id']; ?>/"><?php echo $msgreads['firstname']; ?></a>
											</td>
											<td>
												<?php 
												      if($msgreads['subject'] == ""){
												      	echo'<a href="'.BASE_URL.'messages/viewmessage/msgid/'.$msgreads['id'].'">
															 '.substr($msgreads['content'],0,255).' <a/>';
												  			
												  	    }else
												  	    echo'<a href="'.BASE_URL.'messages/viewmessage/msgid/'.$msgreads['id'].'">
															 '.$msgreads['subject'].' <a/>';
												  		
												  ?>
										
											</td>
											<td style="width:150px">
												<?php
												 echo $this->timeago($msgreads['date_sent']); ?>
											</td>
												
										</tr>
												<?php }}else{

												} ?>
										</table>

					  </div><!-- panelbody -->
				</div><!-- paneldefualt -->

				

			<!-- end of body -->
		</div>

		<div class="clearfix"></div>
	</div>
</div>


<script type="text/javascript">
$(function(){
 
    // add multiple select / deselect functionality
    $('#selectallcheckbox').click(function(){
    						// if all checkbox are selected, check the selectall checkbox
   						    // and viceversa
							if($(this).is(':checked')){
								$('.myCheckbox').each(function(){
									$(this).prop('checked','true');
								});
							
							}else{
								$('.myCheckbox').each(function(){
									$(this).removeAttr('checked');
								});
							}
						});
    $('.myCheckbox').change(function(){
    	if(!$(this).is(':checked')){
    		$('#selectallcheckbox').removeAttr('checked');
    	}
    });
    $('#deletemsg').click(function(){
    	var selected=[];



    	$('.myCheckbox').each(function(){
			if($(this).is(':checked')){
				//selected= selected + $(this).val() + ',';
				selected.push($(this).val());
			}
		});
		
		//perform ajax here
		$.post("<?php echo BASE_URL; ?>messages/archivemsg/",{ids:selected},function(data){
			alert('Your selected messages are now in your archives!');
			$('.myCheckbox').each(function(){
				if($(this).is(':checked')){
					$(this).parent('td').parent('tr').remove();
				}
			});
		});
    });
});




/*$('#selectall-location_offered').click(function () {
				      $('.location_offered').prop('checked', this.checked);
				  });
				  $('.location_offered').change(function () {
				      var check = ($('.location_offered').filter(":checked").length == $('.location_offered').length);
				      $('#selectall-location_offered').prop("checked", check);*/
</script>





<?php 
#echo $this->pr($data);
$this->footers();  ?>