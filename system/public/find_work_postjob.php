<?php $this->headers();  ?>

<div class="contentwrap">
			<div class="page-header">
				<h1 >Post a job<small> Find the right freelancer for your needs.</small></h1>
				
				<span><?php echo $data['msgAlert'];?></span>
			</div>
	   <div class="row-fluid">	
			
		  <div class="col-md-6 col-md-offset-3">

		     <form class="form-horizontal" method="post" acion="<?php echo BASE_URL;?>find-work/postjob/">

		     	<div class="form-group">
		     	<label for="ptitle">Project Title :</label>
		     	<input id="ptitle" name="ptitle" type="text" value="" style="width:400px" required>
			    <p class="btn btn-link" style="margin-left:150px">(<em>Note: Freelancer will search your Project Title.</em>)</p>
			    </div>

			    <div class="form-group">
		     	<label for="description">Description :</label>
			    <textarea id="description" name="description" rows="10" style="resize:vertical; width:600px" required> </textarea>
			    </div>

			    <div class="form-group">
		     	<label for="Location">Location :  &nbsp;&nbsp;&nbsp; </label>
			    <textarea id="Location" name="Location" rows="3" style="resize:vertical; width:600px" required> </textarea>
			    </div>


			    <div class="form-group">
		     	<label for="srate">Set Rate : &nbsp;&nbsp; </label>
			    <input id="srate" name="srate" type="text" value="" placeholder="$ 0.00" style="width:300px" required>
			   </div>

			    <div class="form-group"  style="border-bottom:1px solid #B9BCC3; padding-bottom:50px">
		     	<label for="sContract">Set Contract :&nbsp;</label>
			    <select name="sContract" required >
			    		<option value="" sselected>-choose rate-</option>
			    		<option value="0">Hourly Rate</option>
			    		<option value="1">Fixed Rate</option>
			    </select>
			    </div>
			    <br>
			    <div class="pull-right">
			    	
			    	<button class="btn btn-success">Submit Post Job</button>
			    
			    	
			    </div>
				 
		     </form>
		     	<a href="<?php echo BASE_URL;?>find-work/" class="btn btn-link pull-right">Cancel</a>

		  </div>
			


		<div class="clearfix"></div>
			
	
		</div><!-- rowfluid -->
	</div> <!-- Contentwrap -->


<script type="text/javascript">
// validate if input box is a string
$(document).ready(function(){
	  $("#srate").change(function(){
	    // alert("The text has been changed.");
	    var EnteredValue = $.trim($("#srate").val());
		var TestValue = EnteredValue.replace(" ", "");
		if(isNaN(TestValue) == true){
			alert("format is $ 00.0");
		}

	  });
});

</script>
<?php $this->footers();  ?>