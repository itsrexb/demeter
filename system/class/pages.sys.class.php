<?php
 /*
package: Centraleffects Framework
Author: Rex Bengil
Website: Centraleffects.com
Company: Centraleffects BPO
*/

class Pages extends SKgeneral
{

	public function display_message($res)
	{

        if($res['status']==false)
					{
						 ?>
						 <div class="minimizespace">
							<div class="alert-message"><span class="icon-exclamation-sign"></span> <?php echo $res['message']; ?></div>
							<div class="clear"></div>
						</div>
						 <?php
					}else
					{
						$data["session"]["currentLogin"] = $res['data'];
						 ?>
						 <div class="minimizespace">
							<div class="alert-message"><span class="icon-info-sign"></span> <?php echo $res['message']; ?></div>
						</div>
							<div class="clear"></div>
						<?php
					}
   
	}
	
}


?>