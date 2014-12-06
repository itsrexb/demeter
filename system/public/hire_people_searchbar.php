
<form method="post" action="<?php echo BASE_URL;?>hire-people/searchfreelancer/">
    <div class="form-group">
		  	<input id="freelancer" placeholder="Search a freelancer through their skills" name="freelancer" class="form-control" type="search" value="<?php echo $_POST['freelancer']; ?>" style="width:750px; display:inline">
    <button type="submit" class="btn btn-info" type="button"> Search</button>
    </div>
</form>


		<div class="form-group">
			 <label for="country">Filter by Country: </label>
			 <select id="selcountry" name="selcountry" style=" width:100px">
			 	<option value="">-Countries-</option>
				<?php
					$discountry = $this->fetch("SELECT DISTINCT country FROM user_tb where country<>''");
					if(!empty($discountry)){
						foreach($discountry as $k){
							
							if($k==strtoupper($data['request']['uri_data']['selected'])){
								echo'<option selected="selected" value="'.$k['country'].'">'.$this->country($k['country']).'</option>';
							}else{
								echo'<option value="'.$k['country'].'">'.$this->country($k['country']).'</option>';
							}
						}
					}
				?>
			</select>
		</div>	


<script>
	$('#selcountry').on('change', function() {
		var selectedvar = $(this).find('option:selected').val();
	  location.href="<?php echo BASE_URL;?>hire-people/searchfreelancer/selected/"+$(this).find('option:selected').val()+"/";
	  $('#selcountry').val(selectedvar)

	});
</script>