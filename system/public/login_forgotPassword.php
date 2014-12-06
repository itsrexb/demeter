
<?php $this->headers();?>
<div class="row-fluid contentwrap"></div>
<div class="page-header">
		  <h1>Forgot password<small> Secure your password and stay longer with us!.</small></h1>
		  <?php echo $data['msg']; ?>
</div>
	<div class="col-md-6 col-md-offset-3">



	  <form method="post" action="<?php echo BASE_URL;?>login/validatefpassword/">
        <div class="form-group">
        <label for="email">Your Email Address</label>
	    <input id="email" type="text" value="" name="email" required>
	    </div>

	     <div class="form-group">
        <label for="uname">Your Username</label>
	    <input id="uname" type="text" value="" name="uname" required>
	    </div>

        <?php
          #To display recaptcha image
          require_once('recaptchalib.php');
          $publickey = "6Lc3X-4SAAAAAD9NC1wDBeunRhw5e-FazhQSdZN7"; // you got this from the signup page
          echo recaptcha_get_html($publickey);
        ?>
        <p></p>
        <button class="btn btn-success" name="submit">Submit</button>
      </form>

	</div>









</div> <!-- rowfluidcontentwrap -->



<?php $this->footers();  ?>