
<ul class="nav nav-stack">

  <li>
  	<a href="<?php echo BASE_URL;?>messages/newmessages/"><button class="btn btn-success">New Message</button></a>
  </li>
  <li class="active">
  	<a href="<?php echo BASE_URL;?>messages/inbox/">
  		<span class=" glyphicon glyphicon-folder-close">&nbsp;Inbox</span>
  		
  			
  			<?php 
  			if($data['unreads'] > 0){
  				echo "<span class='badge alert-success pull-right'>".$data['unreads']."</span>";
  			}else{
  				echo "<span class='badge pull-right'>".$data['countreadsmsg']."</span>";
  			} ?>
  			
  		
  	</a>
  </li>
    <li>
  	<a href="<?php echo BASE_URL;?>messages/messagestrash/"><span class=" glyphicon glyphicon-folder-close">&nbsp;Archive</span>
  		<span class="badge pull-right"><?php echo $data['trash']; ?></span>
  	</a>
  </li>
  <li>
  	<a href="<?php echo BASE_URL;?>messages/messagesent/"><span class=" glyphicon glyphicon-folder-close">&nbsp;Sent</span>
  		<span class="badge pull-right"><?php echo $data['msgsent']; ?></span>
  	</a>
  </li>

</ul>
