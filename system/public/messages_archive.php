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
			
				<div class="panel panel-default">
					<div class="panel-heading">
				    		<h3 class="panel-title">Archives message</h3>
					</div>
							<?php if($data['archives'] > 0 ){
								echo"<p style='margin-left:28px'>
									<input type='checkbox' id='selectallcheckbox' style='margin-top:10px'/>&nbsp;
									<em>check all</em> &nbsp;&nbsp;&nbsp;|  <button class='btn btn-link' id='deletemsg'>Delete message</button>
								</p>";
							}else{

							}
							?>
				  <div class="panel-body">
				   		
							<!-- ##### already read message ####### -->		
							<table class="table contentwrap listpmmessages">
							<?php
								if($data['msgtrash'] <> ""){
									 foreach ($data['msgtrash'] as $msgTrash) {
							?>

							<tr style="cursor:pointer;">

							    <td style="width:150px">
								  	<input type="checkbox" class="myCheckbox" name="myCheckbox" value="<?php echo $msgTrash['id'];?>">
								  	<?php if($msgTrash['image_filename']=="")
								  			{ ?>
											   <img class="img-round" src="<?php echo BASE_URL_PUBLIC; ?>images/defaultuser.jpg" style="width:25px; height:25px; vertical-align:text-top">
									<?php }else
											{ ?>
												<img class="img-round" src="<?php echo BASE_URL_PUBLIC; ?>images/profileimage/<?php echo $msgTrash['image_filename']; ?>" style="width:25px; height:25px; vertical-align:text-top;">
									<?php } ?>
											<a style='vertical-align:text-middle;' href="<?php echo BASE_URL; ?>messages/viewmessage/msgid/<?php echo  $msgTrash['id']; ?>/"><?php echo $msgTrash['firstname']; ?></a>
								</td>
								<td>
									<?php 
									      if($msgTrash['subject'] == ""){
									      	echo'<a href="'.BASE_URL.'messages/viewmessage/msgid/'.$msgTrash['id'].'">
												 '.substr($msgTrash['content'],0,255).' <a/>';
									  			
									  	    }else
									  	    echo'<a href="'.BASE_URL.'messages/viewmessage/msgid/'.$msgTrash['id'].'">
												 '.$msgTrash['subject'].' <a/>';
									  		
									  ?>
							
								</td>
								<td style="width:150px">
									<?php
									 echo $this->timeago($msgTrash['date_sent']); ?>
								</td>
									
							</tr>
									<?php }}else{

									} ?>
							</table>
				  </div>
				</div>

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
		$.post("<?php echo BASE_URL; ?>messages/deletemsg/",{ids:selected},function(data){
			if(confirm('Do you want to delete?')== true){
				$('.myCheckbox').each(function(){
					if($(this).is(':checked')){
						$(this).parent('td').parent('tr').remove();
					}
				});
			}
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