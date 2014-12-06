    
<?php if(!empty($data['session'])){
?>
	<!-- <a href="<?php echo BASE_URL;?>find-work/postjob/" class="btn btn-link">Post a Job</a> -->

<?php
}else{}
?>
    
	

			<form method="post" action="<?php echo BASE_URL;?>find-work/jobsearch/">
			    <div class="form-group">
		     	<input id="searchjobs" placeholder="Search a Job" name="searchjobs" class="form-control" type="search" value="<?php echo $_POST['searchjobs']; ?>" style="width:700px; display:inline" required>
			    <button type="submit" class="btn btn-info" type="button"> Search</button>
			    </div>
			</form>