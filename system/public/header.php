<?php
 $redirect_exception = array('hire-freelancers','login','signup','find_work','find_work_viewpost','user_agreement','admin');
 if(!in_array($this->current_page(),$redirect_exception) and empty($_SESSION)){
 	// $this->redirect('login');
 } 
?>

<!doctype html>
<!--[if lt IE 7 ]><html lang="en" class="no-js ie6"> <![endif]-->
<!--[if IE 7 ]><html lang="en" class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]><html lang="en" class="no-js ie8"> <![endif]-->
<!--[if IE 9 ]><html lang="en" class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html lang="en" class="no-js"> <!--<![endif]-->
<head>
<meta charset="utf-8">
<meta name="author" content="">
<meta name="keywords" content="">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title><?php echo $data['title']; ?></title>

<!-- main JS libs -->
<script src="<?php echo BASE_URL_PUBLIC; ?>js/libs/modernizr.min.js"></script>
<script src="<?php echo BASE_URL_PUBLIC; ?>js/libs/jquery-1.10.0.js"></script>
<script src="<?php echo BASE_URL_PUBLIC; ?>js/libs/jquery-ui.min.js"></script>
<script src="<?php echo BASE_URL_PUBLIC; ?>js/libs/bootstrap.min.js"></script>

<!-- Style CSS -->
<link href="<?php echo BASE_URL_PUBLIC; ?>css/bootstrap.css" media="screen" rel="stylesheet">
<link href="<?php echo BASE_URL_PUBLIC; ?>css/simplePagination.css" media="screen" rel="stylesheet">
<link href="<?php echo BASE_URL_PUBLIC; ?>style.css" media="screen" rel="stylesheet">

<!-- scripts -->

<script src="<?php echo BASE_URL_PUBLIC; ?>js/general.js"></script>
<script src="<?php echo BASE_URL_PUBLIC; ?>js/jquery.simplePagination.js"></script>

<!-- Include all needed stylesheets and scripts here -->
<!-- custom input -->
<script src="<?php echo BASE_URL_PUBLIC; ?>js/jquery.customInput.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL_PUBLIC; ?>js/custom.js"></script>
<!-- Placeholders -->
<script type="text/javascript" src="<?php echo BASE_URL_PUBLIC; ?>js/jquery.powerful-placeholder.min.js"></script>
<!-- Lightbox prettyPhoto -->
<link href="<?php echo BASE_URL_PUBLIC; ?>css/prettyPhoto.css" rel="stylesheet">
<script src="<?php echo BASE_URL_PUBLIC; ?>js/jquery.prettyPhoto.js"></script>
<!-- CarouFredSel  -->
<script src="<?php echo BASE_URL_PUBLIC; ?>js/jquery.carouFredSel-6.2.1-packed.js"></script>

<!-- Progress Bars -->
<script src="<?php echo BASE_URL_PUBLIC; ?>js/progressbar.js"></script>
<!-- Calendar -->
<script src="<?php echo BASE_URL_PUBLIC; ?>js/jquery-ui.multidatespicker.js"></script>
<!-- range sliders -->
<script src="<?php echo BASE_URL_PUBLIC; ?>js/jquery.slider.bundle.js"></script>
<script src="<?php echo BASE_URL_PUBLIC; ?>js/jquery.slider.js"></script>
<link rel="stylesheet" href="<?php echo BASE_URL_PUBLIC; ?>css/jslider.css">
<?php /*
<!-- Video Player -->
<link href="<?php echo BASE_URL_PUBLIC; ?>css/video-js.css" rel="stylesheet">
<script src="<?php echo BASE_URL_PUBLIC; ?>js/video.js"></script>
	
<!-- Scroll Bars -->
<script src="<?php echo BASE_URL_PUBLIC; ?>js/jquery.mousewheel.js"></script>
<script src="<?php echo BASE_URL_PUBLIC; ?>js/jquery.jscrollpane.min.js"></script>
	*/ ?>
<!--[if lt IE 9]><script src="<?php echo BASE_URL_PUBLIC; ?>js/respond.min.js"></script><![endif]-->
<!--[if gte IE 9]>
<style type="text/css">
    .gradient {filter: none !important;}
</style>
<![endif]-->
</head>
<body>
	<div class="body_wrap">
		 <div class="toppanel">
			<div class="toppanel_content gradient">
				<?php if(!$this->current_userid()){ ?>
					<div class="row">
					  <div class="col-md-9">
							<div class="row">
								<div class="col-md-4">
									<a href="<?php echo BASE_URL; ?>"><h2>Demeter</h2></a>	
								</div>
								<div class="col-md-8" style="margin-top:18px">
									<ul class="nav nav-pills">
									<li class="<?=(($this->current_page()=="index")?'active':'')?>"><a href="<?php echo BASE_URL;?>">Home</a></li>
									   <li class="<?=(($this->current_page()=="hire_people")?'active':'')?>"><a href="<?php echo BASE_URL;?>hire-people/">Hire People</a></li>
									  <li class="<?=(($this->current_page()=="find_work")?'active':'')?>"><a href="<?php echo BASE_URL;?>find-work/">Job Posting</a></li>
									  <!--  <li><a href="<?php echo BASE_URL;?>how-it-works/">How It Works</a></li> -->
									  <li><a href="<?php echo BASE_URL;?>apppublish.zip">Download App</a></li>
									</ul>
								</div>
							</div>	
					  </div>
					  <div class="col-md-3" style="margin-top:18px">
							<a href="<?php echo BASE_URL;?>login/" class="btn btn-link">Login</a> 
							<a href="<?php echo BASE_URL;?>signup/" class="btn btn-info">Sign up</a> 
					  </div>
					</div>
				<?php }else{ /* for logged in users */
				?>
					<div class="row">
					  <div class="col-md-9">
							<div class="row">
								<div class="col-md-4">
									<a href="<?php echo BASE_URL; ?>"><h2>Demeter</h2></a>	
								</div>
								<div class="col-md-8" style="margin-top:18px">
									<ul class="nav nav-pills">
									 <!--  <li class="<?=(($this->current_page()=="dashboard")?'active':'')?>"><a href="<?php echo BASE_URL;?>dashboard/">Home</a></li> -->
									  <li class="<?=(($this->current_page()=="profile")?'active':'')?>"><a href="<?php echo BASE_URL;?>profile/">Profile</a></li>
									  <li class="<?=(($this->current_page()=="messages")?'active':'')?>">
									  	<a href="<?php echo BASE_URL;?>messages/">Messages<?php if($data['unreads'] > 0){?>
									  		<span class="badge alert-success"><?php echo $data['unreads'];?></span></a>
									  		<?php }else{ ?>
									  		<span style="display:none"class="badge alert-success"><?php echo $data['unreads'];?></span></a>
									  		<?php } ?>	
									  </li>
									  <li class="<?=(($this->current_page()=="company")?'active':'')?>"><a href="<?php echo BASE_URL;?>company/">Company</a></li>
									  <!-- <li class="<?=(($this->current_page()=="projects")?'active':'')?>"><a href="<?php echo BASE_URL;?>projects/">Projects</a></li> -->
									  <li class="<?=(($this->current_page()=="find_work")?'active':'')?>"><a href="<?php echo BASE_URL;?>find-work/">Job Posting</a></li>
									  <li class="<?=(($this->current_page()=="hire_people")?'active':'')?>"><a href="<?php echo BASE_URL;?>hire-people/">Hire People</a></li>
									  <li class="<?=(($this->current_page()=="earnings")?'active':'')?>"><a href="<?php echo BASE_URL;?>earnings/">Earnings</a></li>
									  <?php if($this->get_var("select count(*) from applicants where user_id='".$this->current_userid()."'")>0){?>
									  	<li class="<?=(($this->current_page()=="applicants")?'active':'')?>"><a href="<?php echo BASE_URL;?>applicants/">Applicants</a></li>
									  <?php } ?>

									</ul>
								</div>
							</div>	
					  </div>
					  <div class="col-md-3" style="margin-top:15px">
										
								<span class="pull-right" style="margin-right:100px; margin-top: -8px;">	
										<a href="<?php echo BASE_URL;?>profile/">
										<?php if($_SESSION['currentLogin']['image_filename']==""){ ?>	
													<img class="img-circle" src="<?php echo BASE_URL_PUBLIC; ?>images/defaultuser.jpg" style="width:30px; height:30px; margin: 0px auto;">
										 <?php }else{ ?>
													<img class="img-circle" src="<?php echo BASE_URL_PUBLIC; ?>images/profileimage/<?php echo $_SESSION['currentLogin']['image_filename']; ?>" style="width:60px; height:60px; margin: 0px auto;">
										<?php } ?>
										</a>
								</span>									

								<span style="margin-left:-16px; margin-top: -40px; text-align:center">
									<?php
										$name = $this->get_var("select firstname from user_tb where id = '".$this->current_userid()."'");
										echo $name;
									?> 
									&nbsp;/&nbsp; <a href="<?php echo BASE_URL;?>logout/">Logout</a>
								</span>
							
					  </div>
					</div>
				<?php
				}
				?>
			</div>
		 </div>
        <!-- <div class="container"> -->
        <?php 
        	if(empty($_SESSION)){ session_start();}
        	if($_SESSION['currentLogin']['email']<>""){
	        	if($this->get_var("select count(*) from company_user where (email='".$_SESSION['currentLogin']['email']."' or user_id='".$this->current_userid()."') and is_active='0'")>0){
	        		$company = $this->fetch("select  
	        						a.id as invite_id,
	        						b.id as company_id,
	        						b.name
	        						from company_user a
	        						left join company_tb b on a.company_id = b.id
	        						where a.email='".$_SESSION['currentLogin']['email']."' 
	        						or a.user_id='".$this->current_userid()."'
	        						");
	        		
	        		if(!empty($company))
	        		{
	        			foreach($company as $c){
		        			
	        				$this->update("company_user",array(
	        						"user_id"=>$this->current_userid(),
	        						"email"	=>'',
	        						'is_active'=>1
	        						),array('id'=>$c['invite_id']));

		        			?>
			        		<div class="alert alert-success contentwrap">
			        			<strong>Congratulations!</strong> You are hired with company: <strong><?php echo $c['name']; ?></strong> 
			        		</div>
			        		<?php
		        		}
	        		}
	        	}
	        	
	        }
	        if($data['request']['uri_data']['redirect']<>""){
	        	?>
        		<div class="alert alert-success contentwrap">
        			<strong>Thank you!</strong> Your payment has been recieved and will be processed. 
        		</div>
        		<?php

	        }

        ?>
        