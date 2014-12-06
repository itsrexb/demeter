<?php
 /*
package: Centraleffects Framework
Author: Rex Bengil
Website: Centraleffects.com
Company: Centraleffects BPO
*/

class dashboard extends Pages
{
	public function dashboard()
	{
		$this->set('title','Dashboard - '.SYS_NAME);
		$this->render('dashboard');

		/*$mail = new Skmail();

		$r = $mail->send_mail(array(
				'subject'=>'testing email',
				'content'=>'<h2>This is html content</h2>',
				'to'=> array(
						array('name'=>'rex','email'=>'centraleffects@yahoo.com')
					),
				'from' => array('name'=>'rexx','email'=>'centraleffects@hotmail.com')
			));
		if(!$r){
			echo'Error: '.$r;
		}else{
			echo'Single mail sent!';
		}

		$r = $mail->send_mail(array(
				'subject'=>'testing multiple email',
				'content'=>'<h2>This is html content</h2>',
				'to'=> array(
						array('name'=>'rex', 'email'=>'centraleffects@yahoo.com'),
						array('name'=>'rexii','email'=>'rex@centraleffects.com')
					)
			));
		echo'<br>';
		if(!$r){
			echo'Error: '.$r;
		}else{
			echo'Multiple mail sent!';
		}*/
	}
	
	
}
?>