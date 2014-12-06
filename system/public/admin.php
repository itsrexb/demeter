<?php $this->headers(); if(!empty($_SESSION["session"]["currentLogin"])){ $this->redirect('dashboard'); } ?>
<div class="row-fluid">
	<div class="col-md-8 col-md-offset-2" id="lBox">
		
		<div id="logindiv">
            <?php echo $data['msg']; ?>

                <div class="col-md-5 col-md-offset-4" style="margin-bottom:0px">
                 
                    <form  method="post" action="<?php echo BASE_URL;?>admin/adminlogin/">
                   
        				<center><h1 style="color:#666666">Administrator </h1> 
                           <!--  <p>A smarter, faster, better way to hire </p></center> -->

                        <div class="form-group">
        				<input type="text" class="form-control" name="login" id="login" placeholder="username or email address">
                        </div>

                        <div class="form-group">
        				<input type="password" class="form-control" name="pwd" id="pwd" placeholder="password">
        			    </div>

                        <span>   
                        <button class="btn btn-success" type="submit" style="margin-left:-176px" name="btnlog-in" value="Login in" class="btn btn-success" >Login</button>
                        <a href="<?php echo BASE_URL;?>login/forgotpwd/" style="color:#0093F0">Forgot password</a> 
                       </span>
                    
                    </form>  
                   
                </div> <!-- /colmdoffset4 -->
        </div>

	</div> <!-- /colmd8 offset2 -->
</div> <!-- /row -->

</div><!-- /container -->

<?php $this->footers();  ?>