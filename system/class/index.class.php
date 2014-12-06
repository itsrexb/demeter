<?php
 /*
package: Centraleffects Framework
Author: Rex Bengil
Website: Centraleffects.com
Company: Centraleffects BPO
*/

class index extends Pages
{
	public function index()
	{
		$this->set('title','Welcome - '.SYS_NAME);
		$this->render('index');
	}
	
	
}
?>