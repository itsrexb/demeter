<?php $this->headers();?>
<div class="page-header">
		  <h1>My Profile <small> Make your profile clear and attractive.</small></h1>

<?php echo $data['msg']; ?>
<?php echo $data['msgPwdSuccessChange']; ?>
<?php echo $data['msgPwdChange']; ?>
<?php echo $data['msgPwdConfirm']; ?>
	</div>
<div class="row-fluid">
		<div class="col-md-2" style="width:300px; margin-left:50px">
			<div class="panel panel-info">
				<div class="panel-heading">
					<h3 class="panel-title">My Profile Photo</h3>
				</div>
				<div class="panel-body">
				<div style="text-align:center">
					<?php if($data['profDetails']['image_filename']==""){ ?>
						<img class="img-round" src="<?php echo BASE_URL_PUBLIC; ?>images/defaultuser.jpg">
						<?php }else{ ?>
						<img class="img-round" src="<?php echo BASE_URL_PUBLIC; ?>images/profileimage/<?php echo $data['profDetails']['image_filename']; ?>" style="max-width:250px; height:auto; margin: 0px auto;">
				<?php } ?>
				</div>

				<div>
							<div class="form-group">
								<form method="post" action="<?php echo BASE_URL;?>profile/pupload/" enctype="multipart/form-data">
										<input type="hidden" name="MAX_FILE_SIZE" value="5000000" />  <!-- 5mb -->
										<input class="btn btn-info" type="file" name="imageFile" style="width:270px"/>
										<p class="help-block"><?php echo $data['msgupload']; ?></p>
									 <button class="btn btn-success" type="submit">Upload</button>
								</form>
							</div>
				</div>
				<div class="clearfix"></div> 
				</div> <!-- panelbody -->		
			</div> <!-- panelinfo -->
		</div> <!-- colmd2 offset1 -->

		<div class="col-md-offset-4" style="overflow:hidden; margin-left:360px; margin-top:-40px; margin-right:50px">
													<ul class="nav nav-tabs" style="background-color:#D9EDF7">
													  <li><a href="#profile" data-toggle="tab" class="fontStyle">Profile</a></li>
													  <li><a href="#skills" data-toggle="tab" class="fontStyle">Skills</a></li>
													  <li><a href="#experience" data-toggle="tab" class="fontStyle">Employement History</a></li>
													</ul>

<!-- Tab panes -->
<div class="tab-content">
				<div class="tab-pane active" id="profile">
							<div class="panel panel-info">
							 <div class="panel-body">
									<div class="col-md-4" style="margin-left:40px">
											<form role="form" id="profileForm" method="post" action="<?php echo BASE_URL;?>profile/pupadate/"> 
											
											<div class="form-group">
											 <label for="title">Title :</label>
											 <input type="text" class="form-control" disabled="disabled" id="title" name="title" style="width:250px" value="<?php echo $data['profDetails']['title']; ?>"/>
											</div>	

											<div class="form-group">
											 <label for="userid">Username ID :</label>
											 <input type="text" class="form-control" disabled="disabled" id="userid" name="userid" style="width:250px" value="<?php echo $data['profDetails']['username']; ?>"/>
											</div>
																		
											<div class="form-group">
											 <label for="email">Email Address :</label>
											 <input type="text" class="form-control" disabled="disabled" id="email" name="email" style="width:250px" value="<?php echo $data['profDetails']['email']; ?>"/>
											</div>
																			  		
											<div class="form-group">
											 <label for="fname">First Name:</label>
											 <input type="text" class="form-control" disabled="disabled" id="fname" name="fname" style="width:250px" value="<?php echo $data['profDetails']['firstname']; ?>"/>
											</div>

																			  		
											<div class="form-group">
											 <label for="lname">Last Name:</label>
											 <input type="text" class="form-control" disabled="disabled" id="lname" name="lname" style="width:250px" value="<?php echo $data['profDetails']['lastname']; ?>"/>
											 </div>

									</div> <!-- //coll-md-7 -->


									<div class="col-md-4" style="margin-left:-10px">			

											 <div class="form-group">
											 <label for="rate">Hourly rate:</label>
											 <input type="text" class="form-control" disabled="disabled" id="rate" name="rate" style="width:250px" value="<?php echo $data['profDetails']['rate']; ?>"/>
											</div>

											<div class="form-group">
												<label for="payPalEmail">PayPal Email Account:</label>
												<input type="text" class="form-control" disabled="disabled" id="payPalEmail" name="payPalEmail" style="width:250px" value="<?php echo $data['profDetails']['paypal_email']; ?>"/>
											</div>

											<div class="form-group">
												 <label for="country">Country</label>
												 <input type="text" class="form-control" disabled="disabled" id="country" name="country" style="width:250px" value="<?php if($data['profDetails']['country']<>""){ echo $this->country($data['profDetails']['country']); } ?>"/>
												 <select id="selcountry" name="selcountry" style="display:none; width:250px" class="form-control">
													<?php
														$country = $this->country();
														if(!empty($country)){
															foreach($country as $k=>$v){
																if($k==strtoupper($data['profDetails']['country'])){
																	echo'<option selected="selected" value="'.$k.'">'.$v.'</option>';
																}else{
																	echo'<option value="'.$k.'">'.$v.'</option>';
																}
															}
														}
													?>
												</select>
											</div>	
												 
												 <button type="submit" style="display:none; margin-bottom:20px" id="btnupdate" name="btnupdate" value="update" class="btn btn-success" > Update </button>
													
										</form><!-- profileform -->		

											<button id="btnEdit" class="btn btn-link" style="margin-left:110px" onclick="btnedit()" > Change your Profile </button>
																	
									</div><!--  colmd-5 -->


										<div class="col-md-4" style="margin-left:-10px">	
								
																	<form role="form" id="profileForm1" method="post" action="<?php echo BASE_URL;?>profile/pChangepass/">
													<div class="form-group">
															<label id="acctpwd" for="pwd">Account Password:</label>
															<input type="password" class="form-control" disabled="disabled" id="pwd" name="pwd" style="display:inline-block; width:250px" value="<?php echo $data['profDetails']['password']; ?>"/>
																						  	<!-- //change password// -->

														<a id="Pchangepass" style="display:inline-block; margin-left:120px" onclick="showPwdChanged()" style class="btn btn-link">change password</a>
																	<div id="changePwdHide" style="display:none"> <!-- changePwdHide is hidden -->
																				<p>Old password</p>
																				<input id="oldpassword" name="oldpassword" type="password" value="">
																				 <p>New password</p>
																				<input id="password" name="newPassword" type="password" value="">
																				<span id="result"></span>
																				<p></p>
																				<p>Confrim password</p>
																				<input id="confirmPassword" name="confirmPassword" type="password" value="">
																				<button type="submit" id="bntPasUpdate" name="bntPasUpdate" value="" class="btn btn-success"> Save </button>
																				<a class="AnchorStyle" href="<?php echo BASE_URL;?>profile/">Cancel</a>
																</div> <!-- changePwdHide -->
											</div> <!-- formgroup -->
								</form>
										</div><!--  colmd-5 -->


									</div> <!-- panelbody -->
									</div> <!-- pageinfo -->

				</div> <!-- profile //closetab -->  

				<div class="tab-pane" id="skills">
				<div class="panel panel-info">
					<div class="panel-body">
													<div class="col-md-12" style="overflow:hidden">
																	<?php echo $data['skillmsg']; ?>
																	<form method="post" action="<?php echo BASE_URL;?>profile/skupdate/"> 
																	<p id="pskillshow" style="height:auto; word-wrap:break-word;" class="form-control"><?php echo nl2br($data['skillshow']['meta_value']);?></p>
																	<textarea id="skilltxtArea" name="skilltxtArea" style="resize:vertical; display:none" class="form-control" rows="10"><?php echo $data['skillshow']['meta_value'];?></textarea>
												</div>
														<label>( Separate skills with comma )</label>
											<div>
																	<button id="btnskilludpate" type="submit" style="display:none" class="btn btn-success pull-right"> Update </button>
														</form>
																<button id="btnskill" class="btn btn-info pull-right" onclick="skill()"> Edit </button>
											</div>
													 
					</div><!-- panelbody -->
				</div><!-- panelinfo -->
				</div> <!-- skillclose -->

			<div class="tab-pane" id="experience">
			<div class="panel panel-info">
				<div class="panel-body">

						<div class="col-md-12" style="overflow:hidden">
									<?php echo $data['wrkxpmsg']; ?>
										<div id="workexp1">
																	<form role="form" method="post" action="<?php echo BASE_URL;?>profile/workupdate/">
													<div class="form-group">
																<label style="margin-top:10px; margin-bottom:20px"> Work Experience (optional)</label>
																<p id="pWorkshow" style="height:auto" class="form-control"><?php echo nl2br($data['workxperience']['meta_value']);?></p>
																<textarea id="wrkdescpt" name="wrkdescpt" style="resize:vertical; display:none" class="form-control" rows="15"><?php echo $data['workxperience']['meta_value'];?></textarea>
																<label style="font-style:italic; font-size:14px">(State your work experience separated by comma.)</label>
													</div>
																	 <button type="submit" id="btnwrkUpdate" name="btnwrkUpdate" class="btn btn-success pull-right" style="margin-right:15px; display:none">Save</button>
										<div class="clearfix"></div> 																	 

															</form>
											<button id="btnwrkxp" class="btn btn-info pull-right" onclick="wrkxp()" style="margin-left:40px"> Edit </button>
																							 
									</div> <!-- workexp1 -->
					</div> <!-- colmd12 -->

				</div> <!-- panelbody -->
			</div> <!-- panelinfo -->
			</div> <!-- experience -->

</div><!--colmd7-->
</div> <!-- tabcontent -->
<div class="clearfix"></div>
</div> <!-- row fluid -->
</div><!-- /container -->


<script type="text/javascript">

	function showPwdChanged(){
		$("#changePwdHide").show();
		$("#pwd").hide();
		$("#acctpwd").hide();
		$("#Pchangepass").hide();acctpwd
	}



  	function btnedit(){
	 $(document).click(function(){
		$("#userid").removeAttr("disabled");
		// $("#pwd").removeAttr("disabled"); 
		$("#email").removeAttr("disabled");
		$("#title").removeAttr("disabled");
		$("#rate").removeAttr("disabled");
		$("#fname").removeAttr("disabled");
		$("#lname").removeAttr("disabled");
		$("#payPalEmail").removeAttr("disabled");
		$("#selcountry").show();
		$("#country").hide();
		$("#btnupdate").show();
		$("#btnEdit").hide();   
		    	 	

		 //else {
		// 	$("userid").attr("disabled", "disabled"); 
		// 	$("email").attr("disabled", "disabled");
		// }
		});

	}	



    function skill(){
		$(document).click(function(){
			$("#pskillshow").hide();
			// $("#skilltxtArea").removeAttr("disabled"); 
			$("#skilltxtArea").show(); 
			$("#btnskilludpate").show();
			$("#btnskill").hide();  
			});
		}



	function wrkxp(){
		$(document).click(function(){
			$("#pWorkshow").hide();
			// $("#wrkdescpt").removeAttr("disabled"); 
			$("#wrkdescpt").show();
			$("#btnwrkUpdate").show();
			$("#btnwrkxp").hide();  
			});

		}//workxp


// validate if input box is a string
$(document).ready(function(){
	  $("#rate").change(function(){
	    // alert("The text has been changed.");
	    var EnteredValue = $.trim($("#rate").val());
		var TestValue = EnteredValue.replace(" ", "");
		if(isNaN(TestValue) == true){
			alert("Hourly Rate format is:  00.00");
			return
		}

	  });
});

</script>

<?php 
// echo $this->pr($data);
$this->footers();  ?>