<?php
 /*
package: Centraleffects Framework
Author: Rex Bengil
Website: Centraleffects.com
Company: Centraleffects BPO
*/
class ajaxmessage extends SKgeneral{

	function ajaxmessage(){
		$this->set('title','List Messages for Project');
		$this->render('ajaxmessages');
	}

	public function listmessage(){
		//display list of messages
		
		$this->set("messages",$this->fetch("select a.*,b.firstname,b.lastname,b.image_filename,b.id as user_id 
											from messages_tb a
											left join user_tb b on b.id = createdby_user_id
											where 
												project_id='".(int)$_REQUEST['uri_data']['projectid']."'	AND
												(select count(*) from message_user_tb where message_id=a.id and added_user_id='".$this->current_userid()."') >0
											ORDER BY a.id DESC
											"));

				
	}
	public function viewmessage()
	{
		$this->set("viewmessage",$this->fetch("select a.*,b.firstname,b.lastname,b.image_filename,b.id as user_id 
											from messages_tb a
											left join user_tb b on b.id = createdby_user_id
											where 
											a.id='".(int)$_REQUEST['uri_data']['id']."'
											",true));


	}
	public function savecomment()
	{
		//add new message to our project
		if($_POST['msg']<>""){
			//prevent message from duplicates
			if($this->get_var("select count(*) from messages_tb where 
							content='".$this->clean($_POST['msg'])."' AND
							createdby_user_id='".$this->current_userid()."' AND
							parent_message_id = '".(int)$_POST['id']."'
						")>0){
			}else{

				if($this->insert('messages_tb',array(
						'content'		=>$this->clean($_POST['msg']),
						'parent_message_id'		=>(int)$this->clean($_POST['id']),
						'createdby_user_id' => $this->current_userid(),
						'date_added'	=> strtotime(date('Y-m-d h:i:s e'))
					))){

				}
			}
		}//end if comment is not empty

		//display list of reply
		$this->getreply((int)$this->clean($_POST['id']));
	}

	//display list of comments here
	public function getreply($getreply=""){
		$id = ($getreply<>"")?$getreply:$_REQUEST['uri_data']['id'];
		$this->set("commentlist",$this->fetch("select a.*,b.firstname,b.lastname,b.image_filename,b.id as user_id 
											from messages_tb a
											left join user_tb b on b.id = createdby_user_id
											where 
											a.parent_message_id='".$id."'
											order by a.id ASC
											"));
		$this->set('title','List Messages for Project');
	}

}

?>