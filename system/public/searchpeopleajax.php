<div>
<?php if(empty($data['sfreelancer'])){
					echo '<div class="alert alert-warning">No matched criteria.</div>';
				}else{  
					foreach ($data['sfreelancer'] as $freelance) { ?>
					
						
						<div  class="col-md-12" style="border-bottom:1px solid #B9BCC3; padding:10px">
							<div class="col-md-2">
								<a href="<?php echo BASE_URL.'profile/sprofile/sid/'.$freelance['user_id'].'/'; ?>">
									<?php if($freelance['image_filename']==""){ ?>
									<img class="img-round" src="<?php echo BASE_URL_PUBLIC; ?>images/defaultuser.jpg" style="width:50px; height:auto; margin: 0px auto;">
									<?php }else{ ?>
									<img class="img-round" src="<?php echo BASE_URL_PUBLIC; ?>images/profileimage/<?php echo $freelance['image_filename']; ?>" style="width:50px; height:auto; margin: 0px auto;">
									<?php } ?>
								</a>
							</div>
							

							<div class="col-md-10">
								<div  style="margin-bottom:5px"><strong><?php echo $freelance['firstname'].' '.$freelance['lastname']; ?></strong></div>
								<div  style="margin-bottom:5px"><?php echo $this->country($freelance['country']); ?></div>
								<div style="color:#428bca;">
									<div><?php $avgstar = $this->fetch("SELECT avg(stars) as stars, count(*) as reviews 
										FROM `review_tb` where user_id='".$freelance['user_id']."'",true);

												for($x=1;$x<=(int)$avgstar['stars'];$x++){
										     			 								?>
										     			 								<span class="glyphicon glyphicon-star starreviewsmall red"></span>
										     			 								<?php
										     			 							}
										     			 							for($x=1;$x<=(5-(int)$avgstar['stars']); $x++){
										     			 								?>
										     			 								<span class="glyphicon glyphicon-star-empty starreviewsmall"></span>
										     			 								<?php
										     			 							}

										     	echo (int)$avgstar['reviews'];

											?> reviews</div>						
									<div style="margin-top:5px"><div class="label label-default">skills</div> <?php echo str_ireplace($data['request']['freelancer'], '<strong style="color:red"><em>'.$data['request']['freelancer'].'</em></strong>',$freelance['meta_value']);?></div>
								</div>

								
								<div style="margin-top:10px">
										<p>
											<a href="<?php echo BASE_URL;?>profile/sprofile/sid/<?php echo $freelance['user_id']?>/">
												<label class="label label-info" style="cursor:pointer; font-size:10px">See full profile</label>
											</a>

											<!-- <a href="<?php echo BASE_URL;?>find-work/repost/postid/<?php echo $data['viewpost']['id']; ?>/">
												<label class="label label-success" style="cursor:pointer; font-size:10px">Send message</label>
											</a> -->
											<?php if(!empty($_SESSION)){ ?>
												<a href="javascript:void(0)" 
												<?php if($data['ishourly']==""){ ?>
													onclick="invitethisfreelancer('<?php echo $freelance['user_id']?>','<?php echo $freelance['firstname'].' '.$freelance['lastname']; ?>')"
												<?php }else{?>
														onclick="invitethisfreelancers('<?php echo $freelance['user_id']?>','<?php echo $freelance['firstname'].' '.$freelance['lastname']; ?>')"
												<?php } ?>>
													<label class="label label-success" style="cursor:pointer; font-size:10px">Hire for this project</label>
												</a>
											<?php } ?>
										</p>

								</div>
							</div>
						</div>

					
							

				<?php } } ?>
</div>