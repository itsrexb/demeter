<?php $this->headers();  ?>
<div class="row">
<div class="col-md-8 col-md-offset-2" id="sBox">
<!-- <img src="<?php #echo BASE_URL_PUBLIC ?>images/demeter.gif" style="width:876px; height:400px; border: solid 3px;">	
 -->	
<?php echo $data['msg']; ?>
<div class="panel-body" style="float:left; margin-left:50px">
	<h2>Let's get started! </h2>
		<div id="employerSignup" style="margin-top:5em">
			<div style="float:left; margin-right:10px;">
			<a href="#" style="display:inline"><img class="display:inline" src="<?php echo BASE_URL_PUBLIC ?>images/EmployerImage.jpg"></a> 
			</div>
			<div style="margin-left:20px">
			<p>
				<h4>I need a freelancer</h4>
				<p>Find, hire, manage, and pay for help, on demand.</p>
			</p>
			<!-- <button class="btnlog" type="button" value="signup" class="btn btn-success" > Sigun up </button> -->
			</div>
		</div> <!-- /employerSignup -->

		<div id="employeeSignup" style="margin-top:5em">
			<div style="float:left; margin-right:10px;">
			<a href="#"><img src="<?php echo BASE_URL_PUBLIC ?>images/employeeImage.jpg"></a> 
			</div>
			<div style="margin-left:20px">
			<p>
				<h4>I need a job</h4>
				<p>Find work, earn money, and grow your career.
				</p>
			</p>
				
		   </div>
		</div> <!-- /employeeSignup -->	

	<ul style="margin-top:50px">
			<li><span class="glyphicon alert-success glyphicon-ok"> </span>&nbsp; NO FEES! 100% free for workers</li>
			<li><span class="glyphicon alert-success glyphicon-ok"> </span>&nbsp; Work with US, UK, Australian companies</li>
			<li><span class="glyphicon alert-success glyphicon-ok"> </span>&nbsp; Many different online jobs</li>
	</ul>	
</div>

<div class="col-md-4 col-lg-offset-2" style="float:left">
	<h2>Create a free Account</h2>
	
	<?php echo $data['warn']; ?>
	<div class="panel-body">
	<form id="signform" method="post" action="<?php echo BASE_URL;?>signup/sregister/">
		<div class="form-group">
			<label>Firstname</label>
	   		<input id="firstname" type="text" placeholder="First Name" value="<?php echo $data['request']['firstname']; ?>" name="firstname" onkeyup="this.value=this.value.replace(/[^a-zA-Z]/g,'');" required>
	    </div>
		<div class="form-group">
			<label>Lastname</label>
	   		<input id="lastname" type="text" placeholder="Last Name" value="<?php echo $data['request']['lastname']; ?>" name="lastname" onkeyup="this.value=this.value.replace(/[^a-zA-Z]/g,'');" required>
	    </div>
		<div class="form-group">
			<label>Username</label>
	   		<input id="username" type="text" placeholder="Username" value="<?php echo $data['request']['username']; ?>" name="username" required>
	    </div>
		<div class="form-group">
			<label>Email address</label>
	   		 <input id="emailaddress" type="email" class="select_styled" placeholder="Email Address" value="<?php echo $data['request']['emailaddress']; ?>" name="emailaddress" required>
	   		 <?php echo $data['warn1']; ?>
	    </div>
		<div class="form-group">
			<label>Confrim email</label>
	    	<input id="confirmEmail" type="email" class="select_styled" placeholder="Confrim Email Address" value="<?php echo $data['request']['confirmEmail']; ?>" name="confirmEmail" required>
	    </div>
		<div class="form-group">
			<label>Password</label>
	  		<input id="password" type="password" placeholder="Password" value="" name="password" style="margin-bottom:10px;" required>
	    	<span id="result"></span>
	    </div>
	    	<label>Birth Date</label>
	    <div class="form-group" style="margin-bottom:50px">
	  		<select class="selectOption" name="months" id="months" required>
               		<option selected disabled="disabled" value="0">Month</option>
                    <option  value="1">January</option>
                    <option value="2">Febuary</option>
                    <option value="3">March</option>
                    <option value="4">April</option>
                    <option value="5">May</option>
                    <option value="6">June</option>
                    <option value="7">July</option>
                    <option value="8">August</option>
                    <option value="9">September</option>
                    <option value="10">October</option>
                    <option value="11">November</option>
                    <option value="12">December</option>
                </select>

                <select class="selectOption" name="days" id="days" required>
					<option selected disabled="disabled" value"0">DD</option>
				</select>

				<select class="selectOption" name="years" id="years" required>
					<option selected disabled="disabled" value="0">YYYY</option>
					<?php
					for ($x =  date('Y'); $x >= 1950; $x--) {
					    echo  '<option value="'.$x.'"'.($x === $already_selected_value ? ' selected="selected"' : '').'>'.$x.'</option>';
					}
					?>

	    </div>

	    <div class="form-group">
	  		<input id="checkbox" type="checkbox" name="chckbox" style="margin-left: -208px; margin-top: 53px;" required>
	  			<a href="<?php echo BASE_URL;?>user-agreement/" class="btn btn-link" style=" margin-left: 4px; margin-top:42px;"> Terms and Agreement</a>
	    	
	    </div>
		
		<button type="submit" value="signup" style="margin-top: -40px;" class="btn btn-success"> Sign-up </button>
	</form>
		<div style=" margin-top:25px;">
			<a href="#" style="color: rgb(0, 147, 240)">Need to staff a large team? Contact us</a>
		</div>
	</div> <!-- panel-body -->
</div>
</div> <!-- /colsmoffset-2 -->
</div> <!-- /colmd8 -->
</div><!-- /row -->
</div><!--  /container -->

<script type="text/javascript">
	<?php
	if( $_REQUEST['uri_data']['agree'] == 'true' ){
		?> $('#checkbox').attr('checked', true); <?php
	}
	?>


$(document).ready(function() {
	  $(this).val( $(this).val().replace(/[^a-z]/g,'') );	
});

 	//allow only character from firstname input text
  

    //allow only character from lastname input text
//     // $(this).val( $(this).val().replace(/[^a-z]/g,'') );

//   $(document).ready(function(){
//   $('input:text[name="lastname"]').bind('keyup blur', function(){
//      $(this).val( $(this).val().replace(/[^a-z]/g,'') );
//     });
// });
// );
// );

var month1 = document.getElementById("months");
    
   month1.onchange = function ()
    {
        var month = month1.options[month1.selectedIndex].value;
        var daysArr = [];
        var daySelect = document.getElementById("days");
        if(month == 1 || month == 3 || month == 5 || month == 7 || month == 8 || month == 10 || month == 12)
            {
                for(var  i = 1; i <=31; i++){
                daysArr[i] = i;
                }
            }
        else if(month == 4 || month == 6 || month == 9 || month == 11)
            {
                for(var  i = 1;i<=30;i++){
                daysArr[i]=i;
                }
            }
        else if(month == 2)
            {
                for(var i = 1;i<=29;i++){
                daysArr[i]=i;
                }
            }
        else
            {}
        for(var i = 1;i < daysArr.length;i++) 
        {
        var myElement = document.createElement("option");
        myElement.innerHTML = daysArr[i];
        myElement.value = daysArr[i];
        daySelect.appendChild(myElement);
        }
                            
    };

        window.onload = function()
        {
            /*var year = document.getElementById("years");
            var d = new Date();
            var n = d.getFullYear(); 
            for(var i = n;i<=1940; i--)
            {
                var myElement = document.createElement("option")
                myElement.innerHTML = i;
                myElement.value = i;
                year.appendChild(myElement);
            }*/
                                                                                                                                                                                                                                                                                                    
                                                                                                        
        }

</script>	
<?php $this->footers();  ?>