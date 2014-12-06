<?php $this->headers(); ?>
<div class="contentwrap">
	<div class="page-header">
		<h1>Review Earnings<small> and paid off the hard works.</small></h1>
	</div>
	<div class="row contentwrap">
		<?php 
		if($data['request']['uri_data']['success']<>""){
	        	?>
        		<div class="alert alert-success contentwrap">
        			<strong>Congratulations!</strong> Your widthrawal request has been completed. It might take a few moments to display in your paypal account. 
        		</div>
        		<?php

	        }
	    if($data['request']['uri_data']['failed']<>""){
	        	?>
        		<div class="alert alert-success contentwrap">
        			<strong>Oh Snap!</strong> Your widthrawal request has been failed. Please try again. 
        		</div>
        		<?php
	        }
		?>
		<div class="col-md-3">
			<?php 
				$funds = $this->fetch("select * from fund_tb where user_id ='".$this->current_userid()."'",true);
			?>
			<script type="text/javascript">
				jQuery(function($){
					$('#widthraw').click(function(){
						$('#return').html('');
						if($('#amountowidthraw').val().length==0){ return false; }
					$('#widthraw').html('processing...');
						if(parseFloat($('#amountowidthraw').val())>parseFloat($('#outstandingbalance').html())){
							alert('Error: You cannot widthraw more than your total earnings.');$('#amountowidthraw').focus();
						}else{
							$.post('<?php echo BASE_URL; ?>paypal/widthraw/',{amount:$('#amountowidthraw').val(),user_id:<?php echo $_SESSION['currentLogin']['id']; ?>},function(data){
								location.href="<?php echo BASE_URL; ?>earnings/request/"+data+"/<?php echo time(); ?>/";
							});

						}
					});
				});
			</script>
			<div style="font-size:15px;">Total Earnings</div>
			<div style="font-size:40px;"><span id="outstandingbalance"><?php echo number_format($funds['outstanding_amount'],2); ?></span> <small style="font-size: 18px;margin-left: -8px;;">USD</small></div>
			<div style="margin-top:20px;">
				<div>Enter Amount to Widthraw <small>in USD</small></div>
				<div><input id="amountowidthraw" type="text" style="border: 1px solid #CCCCCC;height: 32px; margin-bottom: 11px; margin-top: 7px; outline: medium none;width: 186px;"></div>
				<div class="styled-notes">The amount will go to <?php echo $_SESSION['currentLogin']['paypal_email']; ?> paypal account.</div>
				<div id="return"></div>
				<div style="margin-top:10px;"><button id="widthraw" class="btn btn-primary btn-sm">Widthraw Now</button></div>
			</div>
		</div>
		<div class="col-md-9">
			<?php
				$trans = $this->fetch("select * from add_fund_logs_tb where funds_id='".$funds['id']."' order by id DESC");
			?>
			<table class="table table-striped">
				<thead>
					<tr>
						<th>Date</th>
						<th>Amount</th>
						<th>Type</th>
						<th>Notes</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					if(!empty($trans)){
						foreach($trans as $t){
							if($t['type']=="credit"){
							?>
							<tr>
								<td><?php echo date('F j, Y h:i:s',(int)$t['date_added']); ?></td>
								<td><?php echo $t['total_amount']; ?></td>
								<td><?php echo ucwords($t['type']); ?></td>
								<td><?php echo $t['notes']; ?></td>
							</tr>
							<?php
							}else{
							?>
							<tr>
								<td style="color:#5B0505"><?php echo date('F j, Y h:i:s',(int)$t['date_added']); ?></td>
								<td style="color:#5B0505"><?php echo $t['total_amount']; ?></td>
								<td style="color:#5B0505"><?php echo ucwords($t['type']); ?></td>
								<td style="color:#5B0505"><?php echo $t['notes']; ?></td>
							</tr>
							<?php
							}
						}
					}
					?>
				</tbody>
			</table>
		</div>
		<div class="clearfix"></div>
	</div>
</div>

<?php $this->footers(); ?>