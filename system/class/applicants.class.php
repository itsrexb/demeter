<?php
 /*
package: Centraleffects Framework
Author:  Marc Comia
Website: Centraleffects.com
Company: Centraleffects BPO
*/


class applicants extends Pages
{
	function applicants(){
		$this->set('title','Applicants - '.SYS_NAME);
		$this->render('applicants');
	}
}