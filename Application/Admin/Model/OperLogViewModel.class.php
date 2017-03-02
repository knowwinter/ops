<?php
namespace Admin\Model;
use Think\Model\ViewModel;
class OperLogViewModel extends ViewModel {
	

	 public $viewFields = array(
	    'oper_log'=>array('login_user_id','source_ip','oper','oper_time','_type'=>'LEFT'),
	    'user'=>array('name','_on'=>'user.user_id=oper_log.login_user_id')
	   );
}