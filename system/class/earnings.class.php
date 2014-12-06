<?php
 /*
package: Centraleffects Framework
Author:  Marc Comia
Website: Centraleffects.com
Company: Centraleffects BPO
*/


class earnings extends Pages
{
	function earnings(){
		$this->set('title','Earnings - '.SYS_NAME);
		$this->render('earnings');
	}
}