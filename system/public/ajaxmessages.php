<div class="contentwrap">
	
	<?php
	if(!empty($data['messages'])){
		echo'<table class="table">';
		foreach($data['messages'] as $m){
			echo'<tr>
					<td style="width:60px;text-align:center">
						<div class="img-thumbnail" title="'.ucwords($m['firstname'].' '.$m['lastname']).'">
							<a href="'.BASE_URL.'profile/view/id/'.$m['user_id'].'/">
							'.(($m['image_filename']<>'')?'<img style="max-width:40px" src="'.PROFILE_IMG.$m['image_filename'].'">':'<img src="'.BASE_URL_PUBLIC.'images/defaultuser.jpg" style="max-width:40px">').'
							</a>
						</div>
					</td>
					<td>
						<div><a href="javascript:void(0)" onclick="viewmessage(\''.$m['id'].'\')"><strong>'.$m['subject'].'</strong></a></div>
						<div>'.substr(strip_tags($m['subject']),0,250).'</div>
					</td>
				</tr>';
		}
		echo'</table>';
	}

	//view messages
	if(!empty($data['viewmessage'])){
		  ?>
		  <script type="text/javascript">
		  	jQuery(document).ready(function($){ 
		  		$('#replyholder').html('Loading replies...');
		  		$.get('<?php echo BASE_URL; ?>ajaxmessage/getreply/id/<?php echo $data['viewmessage']['id']; ?>/',function(data){
		  			$('#replyholder').html(data);
		  		});
		  	});
		  </script>
		  <?php
		echo'<table class="table">';
			echo'<tr>
					<td style="width:60px;text-align:center">
						<div class="img-thumbnail" title="'.ucwords($data['viewmessage']['firstname'].' '.$data['viewmessage']['lastname']).'">
							<a href="'.BASE_URL.'profile/view/id/'.$data['viewmessage']['user_id'].'/">
							'.(($data['viewmessage']['image_filename']<>'')?'<img style="max-width:40px" src="'.PROFILE_IMG.$data['viewmessage']['image_filename'].'">':'<img src="'.BASE_URL_PUBLIC.'images/defaultuser.jpg" style="max-width:40px" >').'
							</a>
						</div>
					</td>
					<td>
						<div><strong>'.$data['viewmessage']['subject'].'</strong></div>
						<div style="margin-bottom:10px;font-size: 11px;font-style: italic;">Published by <strong>'.ucwords($data['viewmessage']['firstname'].' '.$data['viewmessage']['lastname']).'</strong>, '.$this->timeago($data['viewmessage']['date_added']).'</div>
						<div style="background: none repeat scroll 0 0 #EFEFEF;margin:5px;padding: 5px;">'.nl2br($data['viewmessage']['content']).'</div>
						<div style=" border-top: 1px solid #CCCCCC;margin-top: 14px;padding-left: 15px;padding-top: 10px;">
							<div id="replyholder"></div>
							<table>
								<tr>
									<td style="width:25px">
										<p style="margin-top: -11px;position: absolute;" class="img-thumbnail" title="'.ucwords($data['session']['currentLogin']['firstname'].' '.$data['session']['currentLogin']['lastname']).'><a href="'.BASE_URL.'profile/view/id/'.$data['session']['currentLogin']['id'].'/">
										'.(($data['session']['currentLogin']['image_filename']<>'')?'<img style="max-width:25px" src="'.PROFILE_IMG.$data['session']['currentLogin']['image_filename'].'">':'<img src="'.BASE_URL_PUBLIC.'images/defaultuser.jpg" style="max-width:25px" >').'
										</a></p>
									</td>
									<td>
										<div style="margin-left: 15px;">
											<p><textarea id="comment"></textarea></p>
											<p>
												<input type="button" class="btn btn-primary btn-sm" value="Reply" onclick="comment(\''.$data['viewmessage']['id'].'\',jQuery(\'#comment\'),jQuery(this),jQuery(\'#replyholder\'))"/>
												<input type="button" class="btn btn-link btn-sm" onclick="listmessage(\''.$data['viewmessage']['project_id'].'\')" value="Back"/> 
											</p>
										</div>
									</td>
								</tr>
							</table>
						</div>
					</td>
				</tr>';
		echo'</table>';

	}

	//display comments
	if(!empty($data['commentlist']))
	{
		
		foreach($data['commentlist'] as $c){
			echo'<div style="border-bottom: 1px solid #CCCCCC;clear: both;margin-bottom: 24px;margin-left: -21px;min-height: 70px;width: 80%;">';
				echo'<table>';
				echo'	<tr>
							<td style="width:25px">
								<p style="margin-top: -11px;position: absolute;" class="img-thumbnail" title="'.ucwords($c['firstname'].' '.$c['lastname']).'><a href="'.BASE_URL.'profile/view/id/'.$c['user_id'].'/">
								'.(($c['image_filename']<>'')?'<img style="max-width:25px" src="'.PROFILE_IMG.$c['image_filename'].'">':'<img src="'.BASE_URL_PUBLIC.'images/defaultuser.jpg" style="max-width:25px" >').'
								</a></p>
							</td>
							<td>
								<div style="margin-left: 15px;">
									<div style="font-size:11px;"><strong>'.ucwords($c['firstname'].' '.$c['lastname']).'</strong> wrote '.$this->timeago($c['date_added']).':</div>
									<div style="background: none repeat scroll 0 0 #EFEFEF;margin:5px;padding: 5px;">'.nl2br($c['content']).'</div>
								</div>
							</td>
						</tr>
					';
				echo'</table>';
			echo'</div>';
		}
		
	}
	?>
	
</div>