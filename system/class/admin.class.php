<?php
 /*
package: Centraleffects Framework
Author: Marc and rex
Website: Centraleffects.com
Company: Centraleffects BPO
*/
class admin extends Pages
{
	public function admin()
	{
		$this->set('title',' Admin - '.SYS_NAME);
		$this->render('admin');

		#payment of Company starten
		$PCS = $this->fetch("SELECT p.payment_date, p.payment_gross, u.firstname
							from  paypal_transaction as p left join user_tb as u on p.user_id = u.id
							where transaction_type = '_paycompany_' order by p.id desc ");
		$this->set('PCS', $PCS);

		#payment of Company starten
		if($_POST['datepickerfrom']<>"" and $_POST['datepickerto']<>""){
			$comission = $this->fetch("SELECT c.*, 
									(select CONCAT(firstname,' ',lastname) from user_tb where id=c.paidby_userid) as paidby,
									(select CONCAT(firstname,' ',lastname) from user_tb where id=c.paidto_userid) as paidto 
									from  demeter_commission as c 
									where date_added between '".$_POST['datepickerfrom']."' and '".$_POST['datepickerto']."'
									order by c.id desc ");
		}else{
			$comission = $this->fetch("SELECT c.*, 
									(select CONCAT(firstname,' ',lastname) from user_tb where id=c.paidby_userid) as paidby,
									(select CONCAT(firstname,' ',lastname) from user_tb where id=c.paidto_userid) as paidto 
									from  demeter_commission as c 

									order by c.id desc ");
		}
		
		$this->set('comm', $comission);


		#paypal IPN CALL BACK of Company starten
		$paypal = $this->fetch("SELECT p.*, 
									(select CONCAT(firstname,' ',lastname) from user_tb where id=p.user_id) as name											
									from paypal_transaction as p order by p.id desc ");
		$this->set('paypal', $paypal);

	}

	public function adminlogin(){
	global $CFG;
		if(empty($_SESSION)){ session_start();}

		/*if(!(empty($_POST['login']) and empty($_POST['pwd']) and empty($_SESSION["currentLogin"])){
			$this->set('msg','<div class="alert alert-danger"><strong>Oh Snap!</strong> Username and Password is incorrect.</div>');

		}else{*/
		if($_POST['btnlog-in']<>""){	
			if($CFG['admin']['username'] == $_POST['login'] and $CFG['admin']['password'] == $_POST['pwd']){
				if(empty($_SESSION)){ session_start();}
				$_SESSION["currentLogin"]=$CFG['admin']['username'];

				$this->set('title',' Admin Setting - '.SYS_NAME);
				$this->render('admin_setting');

				//$this->redirect(BASE_URL.'admin/view/');


			}else{
				$this->set('msg','<div class="alert alert-danger"><strong>Oh Snap!</strong> Username and Password is incorrect.</div>');
		}
		}

		if($_SESSION["currentLogin"]<>""){

				$this->set('title',' Admin Setting - '.SYS_NAME);
				$this->render('admin_setting');
		}
	
	}

	function view(){

		$this->set('title',' Admin Setting - '.SYS_NAME);
		$this->render('json');

	}
	
	
}
?>