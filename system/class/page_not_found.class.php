<?php
/*
package: Centraleffects Framework
Author: Rex Bengil
Website: Centraleffects.com
Company: Centraleffects BPO
*/

class page_not_found extends SKgeneral
{
	public function page_not_found()
	{
		$this->set('title','PAGE NOT FOUND');
		$this->render('page_not_found');
	}
}
?>