<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends CommonController {

	private $level1 = '仪表盘';
	private $level2 = '';
	private $level3 = '';

    public function index(){

        $this->usernum = M('user')->count();
        $this->projectnum = M('project')->count();
        $this->systemnum = M('system')->count();
        $this->hostnum = M('host')->count();
        $this->rolenum = M('role')->count();
        $this->rulenum = M('deploy_rule')->count();
        $this->servicenum = M('service')->count();
        $this->name = session('name');

        $this->oper = M('oper_log')->where(array('login_user_id' => session('uid')))->order('oper_time desc')->limit(5)->select();



    	$this->assign('level1',$this->level1);
    	$this->assign('level2',$this->level2);
    	$this->assign('level3',$this->level3);
      	$this->display();
    }

    public function logout() {
    	$data = array(
    			'user_id' => session('uid'),
    			'is_online' => 0
    		);

    	$log = array(
    				'login_user_id' => session('uid'),
    				'source_ip' => session('login_ip'),
    				'oper_time' => time(),
    				'oper' => '用户登出'
    			);
        $sessid = session_id();
    	M('user')->save($data);
    	M('oper_log')->add($log);
        //unset($_SESSION[C('USER_AUTH_KEY')]);
        //session_start();
    	
        session('[destroy]');
        
    	$this->redirect('Admin/Login/index');
    }

   
}