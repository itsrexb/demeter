<table  class="table table-striped contentwrapper">
	<?php for($x=0; $x<=23; $x++){ $y= (($x<10)?'0'.$x:$x); ?>
				<tr>
					<td style="width:200px;">
						<div class="mtitlehldr">
							<div class="mtitledayhldr" id="mtitledayhldr">
								<span><?php echo $y;?></span>
							</div>
						</div>
					</td>
					<td>
						<div class="scrnshthldr"></div>
						<div class="chkbxbtn"><input type="checkbox"> <?php echo $y;?>:10</div>
					</td>
					<td>
						<div class="scrnshthldr"></div>
						<div class="chkbxbtn"><input type="checkbox"> <?php echo $y;?>:20</div>
					</td>
					<td>
						<div class="scrnshthldr"></div>
						<div class="chkbxbtn"><input type="checkbox"> <?php echo $y;?>:30</div>
					</td>
					<td>
						<div class="scrnshthldr"></div>
						<div class="chkbxbtn"><input type="checkbox"> <?php echo $y;?>:40</div>
					</td>
					<td>
						<div class="scrnshthldr"></div>
						<div class="chkbxbtn"><input type="checkbox"> <?php echo $y;?>:50</div>
					</td>
					<td>
						<div class="scrnshthldr"></div>
						<div class="chkbxbtn"><input type="checkbox"> <?php echo $y;?>:60</div>
					</td>
				</tr>
	<?php } ?>
</table>