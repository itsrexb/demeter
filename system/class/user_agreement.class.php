<?php
 /*
package: Centraleffects Framework
Author: Rex Bengil
Website: Centraleffects.com
Company: Centraleffects BPO
*/

class user_agreement extends Pages
{
	public function user_agreement()
	{
		$this->set('title','User Agreement - '.SYS_NAME);
		$this->render('user_agreement');
	}
	
	
}
?>