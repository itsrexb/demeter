<?php $this->headers(); //if(!empty($_SESSION["session"]["currentLogin"])){ $this->redirect('dashboard'); } ?>
<div class="row-fluid contentwrap">
	<div class="col-md-12">
		
			<div style="overflow:hidden">
				<ul class="nav nav-tabs" style="background-color:#D9EDF7">
				  <li><a href="#pcf" data-toggle="tab" class="fontStyle">Payment of Company Started</a></li>
				  <li><a href="#commission" data-toggle="tab" class="fontStyle">Comission</a></li>
				  <li><a href="#paypal" data-toggle="tab" class="fontStyle">Paypal IPN Callback</a></li>
				</ul>
			</div>


			<div class="tab-content">
				<div class="tab-pane active" id="pcf">
						<div class="panel panel-info">
							 <div class="panel-body">
									<div style="margin-left:40px">
											<table class="table table-striped">
				                              <tr>
				                              <th style="width:120px;">Name</th>
				                                <th style="width:120px;">Paid</th>
				                                <th style="width:120px;">Amount</th>                                                                
                             				 </tr>	

                             				 <?php foreach ($data['PCS'] as $p) {?>
                             				 	<tr>
                             				 			<td><?php echo $p['firstname'];?></td>
                             				 			<td><?php echo urldecode($p['payment_date']);?></td>
                             				 			<td><?php echo $p['payment_gross'];?><small> USD</small></td>



                             				 	</tr>
                             				 <?php } ?>

                             				</table>
									</div>
							</div> <!-- panelbody -->
						</div> <!-- panel -->
				</div> <!-- tabpane -->


					<div class="tab-pane active" id="commission">
						<div class="panel panel-info">
							 <div class="panel-body">
									<div style="margin-left:40px">
										  <script>
											  $(function() {
											    $( "#datepickerfrom" ).datepicker();
											    $( "#datepickerto" ).datepicker();

											  });
										  </script>
										  <form method="post" action="">
										  <table style="margin-bottom:10px">
										  	<tr>
										  		<td style="vertical-align: middle">From :</td>
										  		<td><input type="text" id="datepickerfrom" name="datepickerfrom" style="width:100px"></td>
										  		<td style="vertical-align: middle">To : </td>
										  		<td><input type="text" id="datepickerto" name="datepickerto" style="width:100px"></td>
										  		<td style="vertical-align: middle"><button type="submit" class="btn btn-success">Show</button></td>
										  	</tr>

										  </table>
										</form>
											<table class="table table-striped">
				                              <tr>
				                              
				                                <th style="width:120px;">Paid by</th>
				                                <th style="width:120px;">Paid bill to</th>  
				                                <!-- <th style="width:50px;">Rate</th> -->
				                                <th style="width:100px;">Total time</th>
				                                <th style="width:50px;">Amount</th>
				                                <th style="width:50px;">Commission Total</th>
				                                <th style="width:140px;">Payment date</th>                                                                 
                             				 </tr>	

                             				 <?php 
                             				 $totalcom = 0;
                             				 foreach ($data['comm'] as $c) {?>
                             				 <?php if($c['paidby']<>""){ ?>
                             				 	<tr>
                             				 			<td><?php if($c['paidby']<>""){ echo $c['paidby']; }else{ echo SYS_NAME; }?></td>
                             				 			<td><?php echo $c['paidto'];?></td>
                             				 			<!-- <td><?php 
                             				 				if($c['rate_per_hour'] > 1){
                             				 				echo $c['rate_per_hour'];
                             				 				}else{
                             				 				echo 'Fixed';
                             				 				} ?>
                             				 			</td> -->
                             				 			<td><?php echo $c['total_hours'];?></td>
                             				 			<td><?php echo $c['payment_gross'];?></td>
                             				 			<td><?php echo $c['demeter_commision_amount'];
                             				 				$totalcom +=$c['demeter_commision_amount'];
                             				 			?></td>
                             				 			
                             				 			<td><?php echo $c['payment_date'];?></td>

                             				 	</tr>
                             				 	<?php } ?>
                             				 <?php } ?>

                             				</table>
                             				<h5>Total Commission: <?php echo number_format($totalcom,2); ?> <small>USD</small></h5>
									</div>
							</div> <!-- panelbody -->
						</div> <!-- panel -->
				</div> <!-- tabpane -->


					<div class="tab-pane active" id="paypal">
						<div class="panel panel-info">
							 <div class="panel-body">
									<div style="margin-left:5px">

											<table class="table table-striped" style="width:100%">
				                              <tr>
				                              
				                                <th>Name</th>
				                                <th>Trasaction ID</th>
				                                 <th>Trasaction Subject</th>
				                                <th>Payer email</th>  
				                                <th>Recepient email</th>               
				                               
				                                
				                                <th>Payment Fee</th>
				                                <th>Payment gross</th>
				                                <th style="">Payment date</th>
				                                 <th>IPN raw data</th>

				                                                                                                 
                             				 </tr>	

                             				 <?php foreach ($data['paypal'] as $p) {?>
                             				 	<tr>
                             				 			<td><?php echo $p['name'];?></td>
                             				 			<td><?php echo $p['txn_id'];?></td>
                             				 			<td><?php echo $p['transaction_subject']; ?></td>
                             				 			<td><?php echo $p['payer_email'];?></td>
                             				 			<td><?php echo $p['receiver_email'];?></td>
                             				 			<td><?php echo $p['payment_fee'];?></td>
                             				 			<td><?php echo $p['payment_gross'];?></td>
                             				 			<td><?php echo trim(urldecode($p['payment_date']));?></td>

                             				 			<td><textarea style="width:150px"><?php echo $p['ipn_raw'];?> </textarea></td>

                             				 	</tr>
                             				 <?php } ?>

                             				</table>
									</div>
							</div> <!-- panelbody -->
						</div> <!-- panel -->
				</div> <!-- tabpane -->




			</div> <!-- tabcontent -->

			
			

	</div> <!-- /colmd8 offset2 -->
</div> <!-- /row -->

</div><!-- /container -->
<div class="clearfix"></div>
<?php $this->footers();  ?>