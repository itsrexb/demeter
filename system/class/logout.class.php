<?php
 /*
package: Centraleffects Framework
Author: Rex Bengil
Website: Centraleffects.com
Company: Centraleffects BPO
*/


class logout extends SKgeneral
{
	public function logout()
	{
		session_destroy();
		unset($_SESSION);
		$this->redirect('login/');
	}
}