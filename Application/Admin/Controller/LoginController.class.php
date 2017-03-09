<?php
namespace Admin\Controller;
use Think\Controller;
use Org\Util\Rbac;
class LoginController extends Controller {

    // private $sessionpath = '/ops/Application/Runtime/Session';
    // private $expire = 3600;

	public function _initialize() {
		if(isset($_SESSION['USER_AUTH_KEY'])) {
			$this->redirect('Admin/Index/index');
		}
		
	}

    public function index(){

      	$this->display();
    }

    public function login()	{
    	if(!IS_POST) {
    		$this->error('页面不存在',U('Admin/Login/index'));
    		exit;
    	}

    	if(!$this->check_verify(I('verify'))) {
    		$this->error('验证码错误',U('Admin/Login/index'));
    		exit;
    	}

    	$login_name = I('login_name');
    	$pwd = I('password','','md5');

    	//$user = M('user')->where(array('login_name' => $login_name))->find();
        $user = M('user')->where(array('login_name' => $login_name))->find();
    	if(!$user || $user['password'] != $pwd) {
    		$this->error('用户名或密码错误',U('Admin/Login/index'));
    		exit;
    	}

    	if($user['status'] == 0) {
    		$this->error('账户被锁定',U('Admin/Login/index'));
    		exit;
    	}

    	$data = array(
    			'user_id' => $user['user_id'],
    			'last_login' => time(),
    			'login_ip'	=>	get_client_ip(),
    			'is_online' => 1,
                'sess_id' => session_id()
    		);
    	$log = array(
    				'login_user_id' => $data['user_id'],
    				'source_ip' => $data['login_ip'],
    				'oper_time' => $data['last_login']
    			);

    	if(M('user')->save($data)) {
    		$log['oper'] = '用户登录后台成功';
    		M('oper_log')->add($log);
            //session(array('path'=>$this->sessionpath,'expire'=>$this->expire));
    		session(C('USER_AUTH_KEY'),$user['user_id']);
    		session('login_name',$user['login_name']);
    		session('name',$user['name']);
    		session('avatar',$user['avatar']);
    		session('last_login',date('Y-m-d H:i:s',$data['last_login']));
    		session('login_ip',$data['login_ip']);
            session('page',$user['page']);

    		if($user['login_name'] == C('RBAC_SUPERADMIN')) {
    			session(C('ADMIN_AUTH_KEY'),true);
    		}

    		
    		RBAC::saveAccessList();

    		$this->redirect('Admin/Index/index');
    	}else {
    		$log['oper'] = '用户登录后台失败';
    		M('oper_log')->add($log);
    		$this->error('用户登录失败',U('Admin/Login/index'));
    		exit;
    	}
    }

  	public function verify() {
  		$verify = new \Think\Verify();
    	$verify->entry();
  	}

  	public function check_verify($code,$id = '') {
  		$verify = new \Think\Verify();
  		return $verify->check($code,$id);
  	}


   
}