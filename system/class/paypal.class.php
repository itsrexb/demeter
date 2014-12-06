<?php
 /*
package: Centraleffects Framework
Author: Rex Bengil
Website: Centraleffects.com
Company: Centraleffects BPO
*/

class paypal extends Pages
{

	public function paypal(){
		$this->set('json','');
		$this->render('json');
	}
	public function callback(){
		//$this->pr($_REQUEST);
		
		global $CFG;

		$raw = "";


		if(!empty($_REQUEST))
		{

				foreach($_REQUEST as $r=>$v){
					if(!empty($r)){
						//$arr[$r] = $v;
						if(!is_array($v)){
							$raw .= $r.'='.urldecode($v).'&';
						}
					}
				}

			
		
				

				//parse_str($_REQUEST, $data);
				$data = $_REQUEST;
				//echo $this->pr($_REQUEST);
				//echo $this->pr($data);
				$custom = explode("$",urldecode($data['transaction_subject']));

				if($this->get_var("select count(*) from paypal_transaction where txn_id='".urldecode($data['txn_id'])."'")<1){
					$this->insert("paypal_transaction",array(
							"user_id"	=> $custom[1],
							"transaction_type"	=> $custom[0],
							"payment_date"	=> urldecode($data['payment_date']),
							"payer_email"	=> urldecode($data['payer_email']),
							"receiver_email"	=> urldecode($data['receiver_email']),
							"payment_gross"	=> urldecode($data['payment_gross']),
							"payment_fee"	=> urldecode($data['payment_fee']),
							"txn_id"	=> urldecode($data['txn_id']),
							"transaction_subject"	=> urldecode($data['transaction_subject']),
							"ipn_raw"	=> $raw
						));
				}

				//this for payment in starting a company 
				if($custom[0]=="_paycompany_"){
					$this->insert_user_meta($custom[1],$custom[0],$data['payment_gross']);
				}

				//payment for project billing a fixed project
				if($custom[0]=="_paybilling_"){
					//start sending payment to freelancer after demeter successfully received money from company owner
					

					//get commission
					 $netamount = floatval($data['payment_gross']) - floatval($data['payment_fee']);
					
					 $commission = floatval($netamount) * floatval($CFG['paypal']['commission']);
					
					 $payable = floatval($netamount) - floatval($commission);
					

					$receiver = $this->get_var("select paypal_email from user_tb where id='".$custom[3]."'");
			        // set url

					/* Add to funds */
					$funds = $this->fetch("select * from fund_tb where user_id='".$custom[3]."'",true);
					if(empty($funds)){
						$this->insert("fund_tb",array(
									"user_id"=>$custom[3],
									"outstanding_amount"=>$custom[4]
									));
						$fundsid = $this->last_inserted_id();
					}else{
						//update outstanding amount
						$this->query("update fund_tb set outstanding_amount = outstanding_amount + ".$custom[4]." where id='".$funds['id']."'");
						$fundsid = $funds['id'];
					}

					$this->insert("add_fund_logs_tb",array(
							"funds_id"	=>$fundsid,
							"type"	=>'credit',
							"sender_user_id"	=>$custom[1],
							"total_amount"	=> $custom[4],
							"widthrawal_email"	=> "",
							"date_added"	=> strtotime($data['payment_date']),
							"gross_amount"	=>$data['payment_gross'],
							"transaction_fee"	=> $data['payment_fee'],
							"paypal_transaction_id"	=>$data['txn_id'],
							"notes"	=>urldecode($data['item_name'])
						));


					$notify = $this->fetch("select * from user_tb where id='".$custom[3]."'",true);
					$mail = new Skmail();
					 $r=$mail->send_mail(array(
					 		'subject' =>'Congratulations! You have new fund received in your account',
					 		'to'=> array(array('name'=>$notify['firstname']. ' '.$notify['lastname'],'email'=> $notify['email'])),
					 		'content'=>'<p>Hello '.$notify['firstname'].',</p>
					 					<p>The fundings your received is fruit of your hardwork from '.urldecode($data['item_name']).',
					 						a total of '.$custom[4].' USD.
					 					</p>
					 					<p>To widthraw to your bank, Login with your '.SYS_NAME.' account at '.BASE_URL.'.</p>
					 					' 
					 	));
					 if(!$r){
					 	$msg = $r;
					 }

					/*
			       // $this->pr($datas);
					$url=trim($CFG['paypal']['masspay_url']).'?USER='.trim($CFG['paypal']['username']).'&PWD='.trim($CFG['paypal']['password']).'&SIGNATURE='.trim($CFG['paypal']['signature']).'&VERSION=2.3&METHOD=MassPay&RECEIVERTYPE=EmailAddress&L_EMAIL0='.trim($receiver).'&L_AMT0='.number_format(trim($payable), 2, '.', '').'&CURRENCYCODE=USD';



			        $ch = curl_init();
			        curl_setopt($ch, CURLOPT_URL,$url); 
			        //curl_setopt($ch, CURLOPT_POSTFIELDS, $datas);
			        curl_setopt($ch, CURLOPT_FAILONERROR, true);
					curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
					curl_setopt($ch, CURLOPT_AUTOREFERER, true);
					curl_setopt($ch, CURLOPT_TIMEOUT, 10);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
					 curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
					curl_setopt($ch, CURLOPT_TIMEOUT, 60);
					curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows NT 6.2; WOW64; rv:17.0) Gecko/20100101 Firefox/17.0');
					curl_setopt($ch, CURLOPT_REFERER, BASE_URL);
					$result = curl_exec($ch);
					$curl_errno = curl_errno($ch);
       				$curl_error = curl_error($ch);
					curl_close($ch);
					echo'<br>';
					echo urldecode($result);
					echo'<br>';

			        //echo $raw;

					$mail = new SKmail();
					$mail->send_mail(
							array(
							'subject'=>"Callback from paypal",
							'content'=>$raw.'************url-'.$url.'*********result-'.$result.'*********error='.$curl_errno.':'.$curl_error,
							'to'=>array(

								array(
										'name'=>'rexx',
										'email'=>'centraleffects@yahoo.com'
									)
								)
							)

						);
					*/

					//save commission to table
					if($this->get_var("select count(*)  from demeter_commission where paypal_transaction_id='".$data['txn_id']."'")<1){
						$this->insert("demeter_commission",
								array(
									"paidby_userid"	=>$custom[2],
									"paidto_userid"	=>$custom[3],
									"payment_gross"	=>$data['payment_gross'],
									"payment_fee"	=>$data['payment_fee'],
									"demeter_commision_amount"	=>$commission,
									"demeter_commision_rate"	=>$CFG['paypal']['commission'],
									"payment_date"	=>$data['payment_date'],
									"paypal_transaction_id"	=>$data['txn_id'],
									"request_url"	=>$url,
									"response"	=>$result
									)
							);
					}

					//update fixed project payables
					$this->query("update project_tb 
									set total_payable_price = total_payable_price-".$data['payment_gross']." 
									where id='".$custom[2]."'"
								);

				}/*end _paybilling_*/

				if($custom[0]=="_paybillinghourly_"){

					//get commission
					 $netamount = floatval($data['payment_gross']) - floatval($data['payment_fee']);
					
					 $commission = floatval($netamount) * floatval($CFG['paypal']['commission']);
					
					 $payable = floatval($netamount) - floatval($commission);
					

					$receiver = $this->get_var("select paypal_email from user_tb where id='".$custom[3]."'");
			        // set url


			       // $this->pr($datas);
					/*
					echo $url=trim($CFG['paypal']['masspay_url']).'?USER='.trim($CFG['paypal']['username']).'&PWD='.trim($CFG['paypal']['password']).'&SIGNATURE='.trim($CFG['paypal']['signature']).'&VERSION=2.3&METHOD=MassPay&RECEIVERTYPE=EmailAddress&L_EMAIL0='.trim($receiver).'&L_AMT0='.number_format(trim($payable), 2, '.', '').'&CURRENCYCODE=USD';


			        $ch = curl_init();
			        curl_setopt($ch, CURLOPT_URL,$url); 
			        //curl_setopt($ch, CURLOPT_POSTFIELDS, $datas);
			        curl_setopt($ch, CURLOPT_FAILONERROR, true);
					curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
					curl_setopt($ch, CURLOPT_AUTOREFERER, true);
					curl_setopt($ch, CURLOPT_TIMEOUT, 10);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
					 curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
					curl_setopt($ch, CURLOPT_TIMEOUT, 60);
					curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows NT 6.2; WOW64; rv:17.0) Gecko/20100101 Firefox/17.0');
					curl_setopt($ch, CURLOPT_REFERER, BASE_URL);
					$result = curl_exec($ch);
					$curl_errno = curl_errno($ch);
       				$curl_error = curl_error($ch);
					curl_close($ch);
					echo'<br>';
					echo urldecode($result);
					echo'<br>';

			        //echo $raw;

					$mail = new SKmail();
					$mail->send_mail(
							array(
							'subject'=>"Callback from paypal",
							'content'=>$raw.'************url-'.$url.'*********result-'.$result.'*********error='.$curl_errno.':'.$curl_error,
							'to'=>array(

								array(
										'name'=>'rexx',
										'email'=>'centraleffects@yahoo.com'
									)
								)
							)

						);
					*/
					
					/* Add to funds */
					$funds = $this->fetch("select * from fund_tb where user_id='".$custom[3]."'",true);
					if(empty($funds)){
						$this->insert("fund_tb",array(
									"user_id"=>$custom[3],
									"outstanding_amount"=>$custom[5]
									));
						$fundsid = $this->last_inserted_id();
					}else{
						//update outstanding amount
						$this->query("update fund_tb set outstanding_amount = outstanding_amount + ".$custom[5]." where id='".$funds['id']."'");
						$fundsid = $funds['id'];
					}

					$this->insert("add_fund_logs_tb",array(
							"funds_id"	=>$fundsid,
							"type"	=>'credit',
							"sender_user_id"	=>$custom[1],
							"total_amount"	=> $custom[5],
							"widthrawal_email"	=> "",
							"date_added"	=> strtotime($data['payment_date']),
							"gross_amount"	=>$data['payment_gross'],
							"transaction_fee"	=> $data['payment_fee'],
							"paypal_transaction_id"	=>$data['txn_id'],
							"notes"	=>urldecode($data['item_name'])
						));

					$notify = $this->fetch("select * from user_tb where id='".$custom[3]."'",true);
					$mail = new Skmail();
					 $r=$mail->send_mail(array(
					 		'subject' =>'Congratulations! You have new fund received in your account',
					 		'to'=> array(array('name'=>$notify['firstname']. ' '.$notify['lastname'],'email'=> $notify['email'])),
					 		'content'=>'<p>Hello '.$notify['firstname'].',</p>
					 					<p>The fundings your received is fruit of your hardwork from '.urldecode($data['item_name']).',
					 						a total of '.$custom[5].' USD.
					 					</p>
					 					<p>To widthraw to your bank, Login with your '.SYS_NAME.' account at '.BASE_URL.'.</p>
					 					' 
					 	));
					 if(!$r){
					 	$msg = $r;
					 }

					//get total hours
					$totalminutes = $this->get_var("select count(*) from  timelogs_tb

												WHERE is_billed = 0
												AND id <='".(int)$custom[4]."'
												AND user_id ='".(int)$custom[3]."'");

					$time = explode('.',number_format((((int)$totalminutes*10)/60),2));
					$hr  = $time[0];
					$min = number_format(60 * ((int)$time[1]/100));

		
					$total_time = $hr.' hrs '.$min.' mins'; 

					//get company rate of a freelancer
					echo $rate = $this->get_var("SELECT
										(select rate from company_user where company_id=a.company_id and user_id='".$custom[3]."' LIMIT 1) as rate
										FROM project_tb a where id='".$custom[2]."'
										");
					
					//save commission to table
					if($this->get_var("select count(*)  from demeter_commission where paypal_transaction_id='".$data['txn_id']."'")<1){
						$this->insert("demeter_commission",
								array(
									"paidby_userid"	=>$custom[1],
									"paidto_userid"	=>$custom[3],
									"payment_gross"	=>$data['payment_gross'],
									"payment_fee"	=>$data['payment_fee'],
									"demeter_commision_amount"	=>$commission,
									"demeter_commision_rate"	=>$CFG['paypal']['commission'],
									"payment_date"	=>$data['payment_date'],
									"paypal_transaction_id"	=>$data['txn_id'],
									"request_url"	=>$url,
									"response"	=>$result,
									"total_hours"=>$total_time,
									"rate_per_hour" => $rate
									)
							);
					}

					




					//update timelogs to billed
					$this->fetch("update timelogs_tb
												SET 
												is_billed=1
												WHERE is_billed = 0
												AND id <='".(int)$custom[4]."'
												AND user_id ='".(int)$custom[3]."'");


				}/*end for hourly billing*/
		}
		$this->set('json','');
		$this->render('json');
	}

	function widthraw(){


		global $CFG;
		$msg="failed";
		$receiver=$this->fetch("select * from user_tb where id='".(int)$_POST['user_id']."'",true);
		$funds = $this->fetch("select *  from fund_tb where user_id='".(int)$_POST['user_id']."'",true);
		if(number_format($funds['outstanding_amount'],2)< number_format($_POST['amount'],2))
		{
			$msg = "Error: You cannot widthraw more than your total earnings.";
		}else{

			/*demeter wil shoulder paypal transaction fee for freelancer */
			$gross = number_format($_POST['amount'],2);// + ((number_format($_POST['amount'],2) * 0.029) + 0.30);

			$url=trim($CFG['paypal']['masspay_url']).'?USER='.trim($CFG['paypal']['username']).
					'&PWD='.trim($CFG['paypal']['password']).'&SIGNATURE='.trim($CFG['paypal']['signature']).
					'&VERSION=2.3&METHOD=MassPay&RECEIVERTYPE=EmailAddress&L_EMAIL0='.trim($receiver['paypal_email']).
					'&L_AMT0='.number_format($gross, 2, '.', '').'&CURRENCYCODE=USD';


	        $ch = curl_init();
	        curl_setopt($ch, CURLOPT_URL,$url); 
	        //curl_setopt($ch, CURLOPT_POSTFIELDS, $datas);
	        curl_setopt($ch, CURLOPT_FAILONERROR, true);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
			curl_setopt($ch, CURLOPT_AUTOREFERER, true);
			curl_setopt($ch, CURLOPT_TIMEOUT, 10);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			 curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
			curl_setopt($ch, CURLOPT_TIMEOUT, 60);
			curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows NT 6.2; WOW64; rv:17.0) Gecko/20100101 Firefox/17.0');
			curl_setopt($ch, CURLOPT_REFERER, BASE_URL);
			$result = curl_exec($ch);
			$curl_errno = curl_errno($ch);
			$curl_error = curl_error($ch);
			curl_close($ch);

			if($result<>""){
				parse_str($result,$data);
				if($data['ACK']=="Success"){

					//deduct from outstanding balance
					$this->query("update fund_tb set outstanding_amount = outstanding_amount - ".$_POST['amount']." where id=".$funds['id']);

					//add to transaction log
					$this->insert("add_fund_logs_tb",array(
									"funds_id"	=>$funds['id'],
									"type"	=>'debit',
									"sender_user_id"	=>"",
									"total_amount"	=> $_POST['amount'],
									"widthrawal_email"	=> $receiver['paypal_email'],
									"date_added"	=> strtotime(date('Y-m-d h:i:s e')),
									"gross_amount"	=>$gross,
									"transaction_fee"	=> "",
									"paypal_transaction_id"	=>$data['CORRELATIONID'],
									"notes"	=>'Widthrawal to '.$receiver['paypal_email'].' paypal account'
								));

					$notify = $this->fetch("select * from user_tb where id='".(int)$_POST['user_id']."'",true);
					$mail = new Skmail();
					 $r=$mail->send_mail(array(
					 		'subject' =>'Congratulations! You have transferred funds to your paypal account',
					 		'to'=> array(array('name'=>$notify['firstname']. ' '.$notify['lastname'],'email'=> $notify['email'])),
					 		'content'=>'<p>Hello '.$notify['firstname'].',</p>
					 					<p>You have transferred funds to your paypal account  a total of '.$_POST['amount'].' USD.
					 					</p>
					 					<p>It may take a while to display in your paypal account.</p>
					 					<p>Login with your '.SYS_NAME.' account at '.BASE_URL.'.</p>
					 					' 
					 	));
					 

					$msg = "success";

				}else{
					$msg = "failed";
				}
			}

			

		}//end checking 
		$this->set('json',$msg);
		$this->render('json');
	}
}