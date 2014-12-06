<?php
if($data['projectview']['isfixed']=='1'){
//for fixed projects
	?>
<div class="contentwrapper">
	<div class="panel panel-success">
		<?php if($data['projectview']['assignedto_userid']==$this->current_userid()){ ?>
		<div class="panel-heading">
			<h3 class="panel-title">Get paid now. <small>Contact your Employer and receive your hard works.</small></h3>
		</div>
		<?php } ?>
		<div class="panel-body">
			<h5>Total Contract Price: $<?php echo $data['projectview']['total_price']; ?></h5>
			<?php

			if($data['projectview']['assignedto_userid']==$this->current_userid()){
				?>
				<h5>Amount Receivable: <?php echo (($data['projectview']['total_payable_price']>=0)?'$'.$data['projectview']['total_payable_price']:'<label class="label label-success">Paid</label>'); ?></h5>
				<?php
			}
			//get company owner
			$owner = $this->get_var("select b.owner from project_tb a
									left join company_tb b on a.company_id = b.id
									where a.id = '".$data['projectview']['id']."'");
			if($owner == $this->current_userid()){
				?>
				<h5>Amount Payables: <?php echo (($data['projectview']['total_payable_price']>=0)?'$'.$data['projectview']['total_payable_price']:'<label class="label label-success">Paid</label>'); ?></h5>
				<?php if($data['projectview']['total_payable_price']>0){ ?>
						<div class="panel panel-default col-md-4">
						  <div class="panel-heading">Process payment now</div>
						  <div class="panel-body">
						  	<?php
						  	if($_SERVER['REQUEST_METHOD']=='POST' and $_POST['amount']<>""){
						  		if(floatval($_POST['amount'])<1){
						  			?>
						  			<div class="alert alert-danger"><strong>Oh snap!</strong> Please provide valid amounts.</div>
						  			<?php
						  		}else{
						  			global $CFG;
						  			?>
						  			<script type="text/javascript">
						  			 jQuery(document).ready(function($){
						  			 	$('#frm').submit();
						  			 });
						  			</script>
						  			<form method="post" id="frm" action="<?php echo $CFG['paypal']['submit_url']; ?>">
							  			<input type="hidden" name="custom" value="_paybilling_$<?php echo $this->current_userid().'$'.$data['projectview']['id'].'$'.$data['projectview']['assignedto_userid'].'$'.$_POST['amount']; ?>">
							  			<input type="hidden" name="on1" value="">
							  			<input type="hidden" name="business" value="<?php echo $CFG['paypal']['email']; ?>"> 
						                <input type="hidden" name="item_name" value="Payment for <?php echo $data['projectview']['name']; ?>"> 
						                
						                <input type="hidden" name="amount" value="<?php echo $_POST['amount']; ?>"> 
						                <input type="hidden" name="return" value="<?php echo BASE_URL.'projects/paypal-success/redirect/thank-you/'; ?>">
						                <input type="hidden" name="cmd" value="_xclick">
						                <input type="hidden" name="quantity" value="1">
						                <input type="hidden" name="cancel_return" value="<?php echo BASE_URL.'projects/view/companyid/'.$data['view']['id'].'/projectview/'.$data['projectview']['id'].'/'; ?>" />
							        </form>
						  			<?php
						  		}
						  	}
						  	?>
						  	<form method="post" action="">
							    <h5>Enter amount to pay:</h5>
							    <div class="input-group" style="margin-bottom:15px;"><span class="input-group-addon">$</span><input type="text" name="amount" class="form-control"></div>
							    <div class="styled-notes" style="margin-bottom:15px;"><strong>Note:</strong> This transaction is non-refundable. </div>
							    <p><button class="btn btn-primary"><i class="glyphicon glyphicon-ok"></i> Pay Now</button></p>
							</form>
						  </div>
						</div>
						<?php
				}
			}

			?>
		</div>
	</div>
</div>
	<?php
}else{

	?>
	<div <?php if($data['view']['owner']==$this->current_userid()){ echo'class="col-md-9"'; }?>>
	<table class="table table-striped" style="width:95%">
		<thead>
			<th><strong>Date</strong></th>
			<th><strong>Who</strong></th>
			<th><strong>Description</strong></th>
			<th><strong>Hrs &amp; Mins</strong></th>
		</thead>
	<?php
	/*This is for hourly rates */
	if(!empty($data['freelancer'])){
		$total_hours = 0; $total_minutes = 0;
		$forbilling = array();
		$x=1;
		foreach($data['freelancer'] as $f){
				
			$timelogs = $this->fetch("
							select
								a.*, 
								CONCAT( 
										GROUP_CONCAT(DISTINCT(b.name) SEPARATOR ','),
										',',
										GROUP_CONCAT(DISTINCT(a.notes) SEPARATOR ',') 
									)
									as allnotes,
								Count(log_minute) as total_time  
							from timelogs_tb a
							left join task_tb b on b.id = a.task_id
							where 
								a.user_id ='".(int)$f['id']."' AND
								a.project_id ='".(int)$data['request']['uri_data']['projectview']."' AND
								a.is_billed = '0'
								group by log_date
								order by log_date ASC
							");
			if(!empty($timelogs)){

				$forbilling[$x]['freelancer'] = $f;
				
				$bill_minutes=0;$bill_hour=0;
				$ff=1;

				foreach($timelogs as $t){
					if($ff==1){
						$forbilling[$x]['from'] = date('d/m/Y',strtotime($t['log_date']));
					}
					$forbilling[$x]['to'] = date('d/m/Y',strtotime($t['log_date']));

					?>
					<tr>
						<td><?php echo date('d/m/Y',strtotime($t['log_date'])); ?></td>
						<td><?php echo ucwords($f['firstname']." ".$f['lastname']); ?></td>
						<td><?php echo '*'.str_replace(',','<br>*',$t['allnotes']); ?></td>
						<td><?php 
							$time = explode('.',number_format((((int)$t['total_time']*10)/60),2));
							$hr  = $time[0];
							$min = number_format(60 * ((int)$time[1]/100));

							$total_hours +=$hr; $total_minutes+=$min;
							$bill_hour +=$hr; $bill_minutes +=$min;

							echo $hr.' hrs '.$min.' mins'; 



						?></td>
					</tr>
					<?php
					$ff++;
				}

				$forbilling[$x]['last_id'] = $this->get_var("
							select
								a.id
							from timelogs_tb a
							left join task_tb b on b.id = a.task_id
							where 
								a.user_id ='".(int)$f['id']."' AND
								a.project_id ='".(int)$data['request']['uri_data']['projectview']."' AND
								a.is_billed = '0'
								order by a.id DESC
							");

				
				$tm = explode('.',number_format(($bill_minutes/60),2));
				$forbilling[$x]['total_hours'] = (int)$bill_hour + (int)$tm[0];
				$forbilling[$x]['total_minutes'] = number_format(60 * ((int)$tm[1]/100));


				
			}
			$x++;
		}

		?>
		<tfoot>
			<td></td>
			<td></td>
			<td style="text-align:right"><strong>Total Billable Time:</strong> </td>
			<td>
				<?php 

					$tm = explode('.',number_format(((int)$total_minutes/60),2));
					$total_hours += $tm[0];
					$total_minutes = number_format(60 * ((int)$tm[1]/100));
					echo $total_hours.' hrs '.$total_minutes.' mins'; 
				?>
			</td>
		</tfoot>
		<?php

	}

	echo'</table></div>';

	/* add billing here. Display only for owner */
	if($data['view']['owner']==$this->current_userid()){
		//$forbilling
		//$this->pr($forbilling);
		?>
		<script type="text/javascript">
			jQuery(document).ready(function(){
				$('#payfreelancer').change(function(){
					var d = $(this).find("option:selected");
					var totaltime =d.data('totalhours') + ':' + d.data('totalminutes');
					var rate = d.data('rate');
					var totalamount = parseInt(d.data('totalhours')) * rate;
					var ratepermin = rate/60;
					var perminute = parseInt(d.data('totalminutes')) * ratepermin;
					perminute = perminute.toFixed(2).split('.');
					totalamount += parseInt(perminute[0]);

					/*multiply with paypal transaction fee: 2.9% + $0.30 USD */
					var paypaltransactionfee = ((parseFloat(totalamount+'.'+perminute[1]) * 0.029) + 0.30).toFixed(2);
					<?php global $CFG; ?>
					var commisionrate = <?php echo $CFG['paypal']['commission']; ?>;
					var commissionamount = (parseFloat(totalamount+'.'+perminute[1]) * parseFloat(commisionrate)).toFixed(2);

					var totalgrossamount = (parseFloat(paypaltransactionfee) + parseFloat(totalamount+'.'+perminute[1]) + parseFloat(commissionamount)).toFixed(2);

					$('#payablerate').html(d.data('rate'));
					$('#payabletime').html(totaltime);
					$('#payableamount').html(totalamount+'.'+perminute[1]);
					$('#paypaltransactionfee').html(paypaltransactionfee);
					$('#totalgrossamount').html(totalgrossamount);
					$('#comissionamount').html(commissionamount);
					<?php /* 
							custom format: keyword,company_owner_userid,project_id,user_id_of_freelancer_topay,last_id
						*/?>
					$('#custom').val('_paybillinghourly_$<?php echo $this->current_userid().'$'.$data['projectview']['id'].'$'; ?>'+d.val()+'$'+d.data('lastid')+'$'+totalamount+'.'+perminute[1]);
					$('#item_name').val('<?php echo $data['view']['name']; ?> Payroll from '+d.data('billdate'));
					$('#amount').val(totalgrossamount);

				});
				$('#payfreelancer').trigger('change');
			});
		</script>
		<?php if(!empty($forbilling)){ ?>
			<div class="col-md-3">
				<div class="panel panel-info">
				  <div class="panel-heading">Process payment now</div>
					  <div class="panel-body">
					  	 <h5>Choose Freelancer to pay:</h5>
					  	 <p>
					  	 	<select class="form-control" id="payfreelancer" name="payfreelancer">
						  	 	<?php
						  	 	global $CFG;
						  	 	if(!empty($forbilling)){
						  	 		foreach($forbilling as $f){
						  	 			$rate = $this->get_var("select rate from company_user
						  	 										where 
						  	 										company_id ='".$data['request']['uri_data']['companyid']."' AND
						  	 										user_id ='".$f['freelancer']['id']."' AND
						  	 										isfixed='0'
						  	 									");
						  	 			echo'<option 
						  	 					value="'.$f['freelancer']['id'].'"
						  	 					data-totalhours ="'.$f['total_hours'].'"
						  	 					data-totalminutes ="'.((strlen($f['total_minutes'])==1)?'0'.$f['total_minutes']:$f['total_minutes']).'"
						  	 					data-rate="'.$rate.'"
						  	 					data-billdate = "'.$f['from'].' - '.$f['to'].'"
						  	 					data-lastid = "'.$f['last_id'].'"
						  	 				 >
						  	 				'.$f['freelancer']['firstname'].' '.$f['freelancer']['lastname'].'</option>';
						  	 		}
						  	 	}
						  	 	?>
						  	 </select>
					  	 </p>
					  	 <table class="table table-striped" style="width:300px;">
					  	 	<tr>
					  	 		<td>Rate:</td>
					  	 		<td><strong><span id="payablerate"></span></strong> <small>USD</small></td>
					  	 	</tr>
					  	 	<tr>
					  	 		<td>Payable Time:</td>
					  	 		<td><strong><span id="payabletime"></span></strong></td>
					  	 	</tr>
					  	 	<tr>
					  	 		<td>Payable Amount:</td>
					  	 		<td><strong><span id="payableamount"></span></strong> <small>USD</small></td>
					  	 	</tr>
					  	 	<tr>
					  	 		<td>Paypal Transaction Fee:</td>
					  	 		<td><strong><span id="paypaltransactionfee"></span></strong> <small>USD</small></td>
					  	 	</tr>
					  	 	<tr>
					  	 		<td>Demeter Commission:</td>
					  	 		<td><strong><span id="comissionamount"></span></strong> <small>USD</small></td>
					  	 	</tr>
					  	 	<tr>
					  	 		<td>Total Amount:</td>
					  	 		<td><strong><span id="totalgrossamount"></span></strong> <small>USD</small></td>
					  	 	</tr>
					  	 </table>
					  	 <form method="post"  action="<?php echo $CFG['paypal']['submit_url']; ?>">
				  			<input type="hidden" name="custom" id="custom" value="">
				  			<input type="hidden" name="on1" value="">
				  			<input type="hidden" name="business" value="<?php echo $CFG['paypal']['email']; ?>"> 
			                <input type="hidden" name="item_name" id="item_name" value=""> 
			                <input type="hidden" name="amount" id="amount" value=""> 
			                <input type="hidden" name="return" value="<?php echo BASE_URL.'company/paypal-success/redirect/thank-you/'; ?>">
			                <input type="hidden" name="cmd" value="_xclick">
			                <input type="hidden" name="quantity" value="1">
			                <input type="hidden" name="cancel_return" value="<?php echo BASE_URL.'company/view/id/'.$data['view']['id'].'/'; ?>" />
			                 <p><input type="submit" class="btn btn-primary" value="Pay now"/> </p>
				        </form>
					  	
					  </div>
				</div>

			</div>
		<?php } ?>
		<div class="clearfix"></div>
		<?php
	}

}
?>