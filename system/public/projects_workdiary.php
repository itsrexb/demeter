<style type="text/css">
	.scrnshthldr{ border:1px dashed #ccc; width:150px;height: 100px; margin-top: 10px;}
	.chkbxbtn{margin-top: 10px;}
	.chkbxbtn input{ margin-top: 1px;}
	.edittimelog{ cursor: pointer;}
</style>
<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL_PUBLIC; ?>js/jquery.datepick.package-4.1.0/jquery.datepick.css"> 
<script type="text/javascript" src="<?php echo BASE_URL_PUBLIC; ?>js/jquery.datepick.package-4.1.0/jquery.datepick.js"></script>
<script type="text/javascript">
	jQuery(document).ready(function(){
		$('#datepics').datepick();
		$('.edittimelog').click(function(){
			var t = $(this);
			$('#modalminute').html(t.attr('data-time'));
			$('#modalhour').html(t.attr('data-hour'));

			$('#log_minute').val(t.attr('data-time'));
			$('#log_hour').val(t.attr('data-hour'));

			//load info about this time slot

			$.ajax({
					type: "POST",
					url: '<?php echo BASE_URL; ?>projects/workdiarytimeslotinfo/',
					data: { 
						 isoffline : t.attr('data-offline'),
						 logdate : $('#log_date').val(),
						 loghour : t.attr('data-hour'),
						 logminute: t.attr('data-time'),
						 userid: '<?php echo (($data['request']['uri_data']['userlog']<>'')?$data['request']['uri_data']['userlog']:$this->current_userid()); ?>',
						 projectid: '<?php echo $data['request']['uri_data']['projectview']; ?>'
						},
					success: function(data){
						$('#tasknotes').val(data.notes);
						console.log(data.task_id);

						$('#task_id option[value='+data.task_id+']').attr('selected','selected');

						if(data.is_offline=='0'){
							 $('#modalsavechanges').hide();
							 $('#opentabs').html(data.app_opentabs.replace(new RegExp('<br>','g'),'<br><div style="border-bottom:1px solid #ccc"></div><br>* '));
							 $('#mouseclick').html(parseInt(data.app_mouseclick));
							 $('#keystroke').html(parseInt(data.app_keystroke));
							 $('#appevents').show();
						}else{
							$('#opentabs').html('');
							$('#opentabsh5').hide();
							$('#appevents').hide();
						}

					},
					dataType: 'json'
					});


			$('#addoffilemodal').modal('show');
		});	
		<?php 
		if($data['request']['uri_data']['workorder']<>""){
			?>
			$('a[href="#workdiary"]').tab('show');
			<?php
		}
		?>	
		$("#userlog").change(function(){
			location.href='<?php echo BASE_URL.'projects/view/companyid/'.$data['request']['uri_data']['companyid'].'/projectview/'.$data['request']['uri_data']['projectview'].'/workorder/true/userlog/'; ?>'+$(this).find('option:selected').val()+'/';
		});

		<?php
			/*do not show save button if viewing others diary*/
			if($data['request']['uri_data']['userlog']<>$this->current_userid()){
				?>
				$('#modalsavechanges').hide();
				<?php
			}
			if($data['request']['uri_data']['userlog']==""){
				?>
				$('#modalsavechanges').show();
				<?php
			}
			?>

			$("#deleteentry").click(function(){
				if(confirm('Are you sure to delete this entry?')){
					var entry = "";
					$(".chkbtninpt").each(function(){
						var a = $(this);
						if(a.is(':checked') && a.data('logdate')!=undefined){
							entry += a.data('id')+'a'; 
						}
						
					});
					location.href="<?php echo BASE_URL.'projects/view/companyid/'.$data['request']['uri_data']['companyid'].'/projectview/'.$data['request']['uri_data']['projectview'].'/workorder/true/userlog/'.(($data['request']['uri_data']['userlog']<>'')?$data['request']['uri_data']['userlog']:$this->current_userid()).'/';?>deleteentry/"+entry+"/";
				}
			});

			$('.tooltipss').tooltip();
	});
</script>
<div>
	<div class="col-md-3">
		<div id="datetimepicker" class="input-group">
			<form method="post" action="<?php echo BASE_URL.'projects/view/companyid/'.$data['request']['uri_data']['companyid'].'/projectview/'.$data['request']['uri_data']['projectview'].'/workorder/true/userlog/'.(($data['request']['uri_data']['userlog']<>'')?$data['request']['uri_data']['userlog']:$this->current_userid()).'/';?>">
				  <input id="datepics" type="text" style="width:150px;height:36px;border-left:1px solid #ccc;border-top:1px solid #ccc;border-bottom:1px solid #ccc;" name="datepics" class="form-control" placeholder="dd/mm/yyyy" value="<?php echo date('m/d/Y'); ?>"/>
				  <button type="submit" class="btn btn-primary" style="margin-left:0px;border-radius:0 5px 5px 0"> <i data-time-icon="icon-time" class="glyphicon glyphicon-list-alt" data-date-icon="icon-calendar" style="cursor:pointer;margin-left: 3px;margin-right: 2px;margin-top: 3px;"></i> Show Work Diary</button>
			</form>
		</div>
	</div>
	<div class="col-md-9">
		<div class="col-md-9">
			<div style="font-size:30px;margin-top:5px;text-align:center;" class="col-md-5"><?php echo (($_POST['datepics']<>"")?date('F j, Y',strtotime($_POST['datepics'])):date('F j, Y')); ?></div>
			<div class="col-md-7" style="text-align:center;">
				<select name="userlog"  id="userlog" class="form-control">
					<?php 
					if(!empty($data['freelancer'])){
						foreach($data['freelancer'] as $f){
							
							if($data['request']['uri_data']['userlog']<>""){
								if($f['id']==$data['request']['uri_data']['userlog']){
									?>
									<option value="<?php echo $f['id']; ?>" selected="selected">
										<?php echo $f['lastname'].', '.$f['firstname']; ?>
									</option>
									<?php
								}else{
									?>
									<option value="<?php echo $f['id']; ?>">
										<?php echo $f['lastname'].', '.$f['firstname']; ?>
									</option>
									<?php
								}
							}else{
								if($f['id']==$this->current_userid()){
									?>
									<option value="<?php echo $f['id']; ?>" selected="selected">
										<?php echo $f['lastname'].', '.$f['firstname']; ?>
									</option>
									<?php
								}else{
									?>
									<option value="<?php echo $f['id']; ?>">
										<?php echo $f['lastname'].', '.$f['firstname']; ?>
									</option>
									<?php
								}
							}
						}
					}
					?>
				</select>
			</div>
		</div>
		<div class="col-md-3">
			<button class="btn btn-warning" id="deleteentry" style="margin-left:10px;">Delete Entry</button>
		</div>
		<div class="clearfix"></div>
	</div>
	<div class="clearfix"></div>
</div>

<div class="clearfix"></div>
<table  class="table table-striped contentwrapper" style="width:95%;margin-top:10px;">
	<?php for($x=0; $x<=23; $x++){ $y= (($x<10)?'0'.$x:$x); 

				$timeslot = array(
						'10'=>array(),'20'=>array(),'30'=>array(),'40'=>array(),'50'=>array(),'60'=>array()
					);
				$timelogs = $this->fetch("select a.*,b.name as project_name from timelogs_tb a
							left join project_tb b on b.id = a.project_id
							where 
							a.log_hour='".$y."' and 
							a.log_date='".(($_POST['datepics']<>"")?date('Y-m-d',strtotime($_POST['datepics'])):date('Y-m-d'))."' and
							a.user_id ='".(($data['request']['uri_data']['userlog']<>"")?$data['request']['uri_data']['userlog']:$this->current_userid())."'

					");
				if(!empty($timelogs)){
					foreach($timelogs as $t){
						$timeslot[$t['log_minute']] = $t;
					}
				}

		?>
				<tr>
					<td style="width:200px;">
						<div class="mtitlehldr">
							<div class="mtitledayhldr" id="mtitledayhldr">
								<span><?php echo $y;?></span>
							</div>
						</div>
					</td>
					<?php
					foreach($timeslot as $k=>$v){
						if(is_array($v) and !empty($v)){
							?>
							<td>
								<div class="scrnshthldr">
									<?php if($v['screenshot_id']==""){
										?>
										<div style="margin: 30px auto auto; text-align: center; width: 100px;">NO SCREENSHOT</div>
										<?php
									}else{
										if(file_exists(ABS_PATH.'upload/'.$v['screenshot_id'].'.png')){
											?>
											<a href="<?php echo BASE_URL.'upload/'.$v['screenshot_id'].'.png'; ?>" target="_blank"><img style="width:150px; margin-top:7px" src="<?php echo BASE_URL.'upload/'.$v['screenshot_id'].'.png'; ?>"/></a>
											<?php
										}else{
											?>
											<div style="margin: 30px auto auto; text-align: center; width: 100px;">NO SCREENSHOT</div>
											<?php
										}
									}
									?>
								</div>
								<div class="chkbxbtn"><input type="checkbox" data-id="<?php echo $v['id']?>" data-logdate="<?php echo (($_POST['datepics']<>"")?date('Y-m-d',strtotime($_POST['datepics'])):date('Y-m-d')); ?>" data-hour="<?php echo $y;?>" data-minute="<?php echo $k; ?>" class="chkbtninpt"	<?php if($data['request']['uri_data']['projectview']<>$v['project_id']){ ?>disabled="disabled"<?php } ?>> 
									<?php echo $y;?>:<?php echo $k; ?> 
									<?php if($v['is_offline']=="1"){ 
										echo'<span class="label label-warning">Offline</span>';
									}else{
										echo'<span class="label label-info">Autotrack</span>';
									}
									?>
									<?php 
									if($data['request']['uri_data']['projectview']==$v['project_id']){
									?>
										<span 
											data-hour="<?php echo $y;?>" 
											data-time="<?php echo $k; ?>" 
											data-offline="<?php echo $v['is_offline']; ?>" 
											class="label label-primary edittimelog">info</span>
									<?php }else{
									?>
										<span class="label label-danger tooltipss" data-toggle="tooltip" data-placement="bottom" title="This is belongs to other project: (<?php echo $v['project_name']; ?>) ">info</span>
									<?php
									} ?>
								</div>
							</td>
							<?php
						}else{
							?>
							<td>
								<div class="scrnshthldr">
									<div style="margin: 45px auto auto; text-align: center; width: 100px;">NO TIME LOG</div>
								</div>
								<div class="chkbxbtn"><input disabled="disabled" type="checkbox" name="times[<?php echo $y;?>][<?php echo $k; ?>]" class="chkbtninpt"> 
									<?php echo $y;?>:<?php echo $k; ?> 
									<span 
										data-hour="<?php echo $y;?>" 
										data-time="<?php echo $k; ?>"
										class="label label-primary edittimelog">info</span>
								</div>
							</td>
							<?php
						}
					}
					?>
				</tr>
	<?php } ?>
</table>

<!-- Modal -->
<div class="clearfix"></div>
<div class="modal fade" id="addoffilemodal">
  <div class="modal-dialog">
    <div class="modal-content">
    	<form method="post" action="<?php echo BASE_URL.'projects/view/companyid/'.$data['request']['uri_data']['companyid'].'/projectview/'.$data['request']['uri_data']['projectview'].'/workorder/true/userlog/'.(($data['request']['uri_data']['userlog']<>'')?$data['request']['uri_data']['userlog']:$this->current_userid()).'/';?>">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	        <h4 class="modal-title" id="myModalLabel">Add Offline Time</h4>
	      </div>
	      <div class="modal-body">
	      		
	      		<h5><?php echo (($_POST['datepics']<>"")?date('F j, Y',strtotime($_POST['datepics'])):date('F j, Y')); ?> 
	      			<span id="modalhour">00</span>:<span id="modalminute">10</span></h5>
	      		<h5>Choose task to attach</h5>
	      		<p>
	      			<select name="task_id" id="task_id" style="width:90%">
		      			<?php
		      			if(!empty($data['tasklist'])){
		      				foreach($data['tasklist'] as $m){
		      					if(is_array($m['tasks'])){
		      						foreach($m['tasks'] as $t){
		      							if($t['is_done']=="1"){
		      								echo '<option value="'.$t['id'].'" style="text-decoration: line-through;">'.$t['name'].'</option>';
		      							}else{
		      								echo '<option value="'.$t['id'].'">'.$t['name'].'</option>';
		      							}
		      							
		      						}
		      					}
		      				}
		      			}
		      			?>
	      			</select>
	      		</p>
	      		<h5>Notes about this task</h5>
	      		<p>
	      			<input type="hidden" name="log_date" id="log_date" value="<?php echo (($_POST['datepics']<>"")?date('F j, Y',strtotime($_POST['datepics'])):date('F j, Y')); ?>">
	      			<input type="hidden" name="datepics"  value="<?php echo (($_POST['datepics']<>"")?date('F j, Y',strtotime($_POST['datepics'])):date('F j, Y')); ?>">
	      			<input type="hidden" name="log_hour" id="log_hour" value="">
	      			<input type="hidden" name="log_minute" id="log_minute" value="">
	      			<textarea name="tasknotes" id="tasknotes" required="required" style="width:100%;height:200px;"></textarea>
	      		</p>
	      		<h5 id="opentabsh5">Open Tabs</h5>
	      		<div id="opentabs" style="border:1px solid #ccc;padding:10px;"></div>
	      		<div id="appevents" style="margin-top: 12px; margin-bottom: 12px;"><span id="keystroke" class="label label-info"></span> <small>Keyboard Hits</small>  -  <span id="mouseclick" class="label label-success"></span> <small>Mouse Clicks</small></div>
	      		<div class="styled-notes"><strong>Note:</strong> Offline time is not encouraged.</div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	        <button type="submit" id="modalsavechanges" class="btn btn-primary">Save changes</button>
	      </div>
      	</form>
    </div>
  </div>
</div>