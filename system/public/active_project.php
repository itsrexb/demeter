<div class="contentwrap">
	<?php
	if(!empty($data["projects"])){
		echo'<ul class="list-group">';
		foreach($data["projects"] as $p)
		{
			?>
			<li class="list-group-item">
				<h5><a href="<?php echo BASE_URL;?>projects/view/companyid/<?php echo $data['request']['uri_data']['companyid'];?>/projectview/<?php echo $p['id']; ?>/"><?php echo $p['name'];?></a></h5>
				<?php if($p['isfixed']=="1"){ ?>
					<p><label class="label label-success"><span class="glyphicon glyphicon-usd"></span> Fixed Price: <?php echo $p['total_price']; ?></label></p>
					<p><?php echo $this->get_var("select CONCAT(firstname,' ',lastname) from user_tb where id='".$p['assignedto_userid']."'"); ?> <em>is responsible.</em></p>
				<?php } ?>
				<p class="mdescrptn"><?php echo nl2br($p['description']);?></p>
			</li>
			<?php
		}
		echo'</ul>';
	}
	?>
</div>