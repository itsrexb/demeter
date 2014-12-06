<script type="text/javascript">
	jQuery(document).ready(function($){
		$('#isfixed').change(function(){
			if($(this).is(':checked')){
				$('.isf').show();
			}else{
				$('.isf').hide().find('input[type=text]').val('');
			}
		});
		if($('#isfixed').is(':checked')){
				$('.isf').show();
			}else{
				$('.isf').hide().find('input[type=text]').val('');
			}
	});
</script>
<div class="contentwrap">
	<div style="width:500px;">
		<form method="post" action="">
			<h2>Create new project and get started.</h2>
			<h5>Project Name</h5>
			<p><input type="text" name="projectname"/></p>
			<h5>Description</h5>
			<p><textarea name="description"/></textarea></p>
			<h5><input type="checkbox" id="isfixed" name="isfixed" value="1"> Is this a fixed project?</h5>
			<p></p>
			<h5 style="display:none" class="isf">Price($) <small>in USD</small></h5>
			<p style="display:none" class="isf"><input type="text" name="price" placeholder="0.00"/></p>
			<div style="display:none" class="isf">
				<h5>Who's responsible?</h5>
				<p>
					<?php
					if(!empty($data['freelancer'])){
						echo'<select name="responsible">';
							foreach($data['freelancer'] as $f)
							{
								echo'<option value="'.$f['id'].'">'.ucwords($f['firstname']).' '.ucwords($f['lastname']).(($this->current_userid()==$f['id'])?' (Me)':'').'</option>';
							}
						echo'</select>';
					}else{
					 echo'<div class="alert alert-danger">Please add freelancer to your company to assign a milestone.</div>';
					}
					?>
				</p>
			</div>
			<p>
				<input type="submit" name="createnewproject" class="btn btn-primary" value="Create and Save Project"/>
			</p>
		</form>
	</div>
</div>