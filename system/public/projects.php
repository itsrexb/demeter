<?php $this->headers();  ?>
	<script type="text/javascript">
		jQuery(document).ready(function(){
			<?php if($data['request']['uri_data']['workdiary']<>""){ ?> 
				
				/*$('a[href="#workdiary"]').click(function(e){
					e.prevenDefault();
					location.href="<?php echo BASE_URL.'projects/view/companyid/'.$data['request']['uri_data']['companyid'].'/projectview/'.$data['request']['uri_data']['projectview'].'/workdiary/true/'; ?>#workdiary";
				});*/
			<?Php } ?>
		});
	</script>
	<div class="row-fluid contentwrap">
		<div class="page-header">
		  <h1><?php if(!empty($data['view'])){ echo '<span class="alert-success" style="padding:3px;">'.ucwords($data['view']['name']).'</span> - ';}?>Projects <small>accomplish goals and target at given time.</small></h1>
		</div>
		<?php echo $data['msg']; ?>
		<div class="row-fluid">
				<?php 
				if(empty($data['view']) and empty($data['edit'])){
						if(!empty($data['own_companies']))
							{
								//display own companies
								foreach($data['own_companies'] as $c){
									?>
									<div class="companyv" onclick="javascript:location.href='<?php echo BASE_URL;?>projects/view/companyid/<?php echo $c['id'];?>/'">
										<div>
											<img src="<?php echo BASE_URL_PUBLIC;?>images/companydefault.jpg" class="img-circle">
										</div>
										<div>
											<strong><?php echo $c['name']; ?></strong><br>
											<span>Owner</span>
										</div>
										<div class="clearfix"></div>
									</div>
									<?php
								}
							}
							if(!empty($data['companies']))
							{
								//display attached companies
								foreach($data['companies'] as $c){
									if($c['owner']<>$this->current_userid()){
										?>
										<div class="companyv" onclick="javascript:location.href='<?php echo BASE_URL;?>projects/view/companyid/<?php echo $c['id'];?>/'">
											<div>
												<img src="<?php echo BASE_URL_PUBLIC;?>images/companydefault.jpg" class="img-circle">
											</div>
											<div>
												<strong><?php echo $c['name']; ?></strong><br>
												<span><?php echo $c['position']; ?></span>
											</div>
										</div>
										<?php
									}
								}
							}

							if(empty($data['companies']) and empty($data['own_companies']))
							{
								?>
								<div class="alert alert-warning">To start creating your first project, please create a company or wait until someone invited you in their company.</div>
								<?php
							}
				}
				if(!empty($data['view']) and $data['request']['uri_data']['projectview']==""){
							?>
					<div>
						<!-- Nav tabs -->
						<ul class="nav nav-tabs">
						  <li class="first active"><a href="#activeprojects" data-toggle="tab">Active Projects</a></li>
						  <li><a href="#newproject" data-toggle="tab">Create New Project</a></li>
						</ul>

						<!-- Tab panes -->
						<div class="tab-content">
						  <div class="tab-pane active" id="activeprojects"><?php include_once("active_project.php");?></div>
						  <div class="tab-pane" id="newproject"><?php include_once("create_new_project.php");?></div>
						</div>
					</div>
				<?php } 
				if($data['request']['uri_data']['projectview']<>""){
				?>
				  <h1><?php echo $data['projectview']['name'];?></h1>
				  <div>
						<!-- Nav tabs -->
						<ul class="nav nav-tabs">
						  <!-- <li><a href="#overview" data-toggle="tab">Overview</a></li> -->
						  <li class="first active"><a href="#tasks" data-toggle="tab">Tasks</a></li>
						  <li><a href="#messages" data-toggle="tab">Messages</a></li>
						  <li><a href="#milestone" id="tmilestone" data-toggle="tab">Milestone</a></li>
						  <li><a href="#workdiary" data-toggle="tab">Work Diary</a></li>
						  <li><a href="#billing" data-toggle="tab">Billing</a></li>
						</ul>

						<!-- Tab panes -->
						<div class="tab-content">
						  <!-- <div class="tab-pane" id="overview"><div class="contentwrap">overview</div></div> -->
						  <div class="tab-pane active" id="tasks">
								<div class="contentwrap"><?php include_once("projects_task.php");?></div></div>
						  <div class="tab-pane" id="messages"><div class="contentwrap"><?php include_once('projects_message.php'); ?></div></div>
						  <div class="tab-pane" id="milestone">
								<div class="contentwrap"><?php include_once('projects_milestone.php');?></div></div>
						  <div class="tab-pane" id="workdiary"><div class="contentwrap"><?php include_once('projects_workdiary.php'); ?></div></div>
						  <div class="tab-pane" id="billing"><div class="contentwrap"><?php include_once('projects_billing.php');?></div></div>
						</div>
					</div>
				<?php
				}
				?>
		</div>
	</div>
<?php $this->footers();  ?>