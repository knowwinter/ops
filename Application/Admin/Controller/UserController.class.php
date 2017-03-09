<?php
namespace Admin\Controller;
use Think\Controller;
class UserController extends CommonController {

	private $level1 = '用户管理';
	private $level2 = '';
	private $level3 = '';

    public function lists(){


    	$this->level2 = '用户列表';


    	$active = 'user';

    	$this->assign('active',$active);

    	$user = D('UserRelation');
        $keyword = '';
        $condition = '';
    	// if(isset($_POST) && $_POST['keyword'] != '' ) {
     //        $condition['login_name']=array('like',I('keyword') . '%');
     //        $condition['name']=array('like',I('keyword') . '%');
     //        $condition['_logic']='OR';
    	// 	$keyword = I('keyword');
     //        $count = $user->relation(true)->where($condition)->count();

    	// 	//$count = $user->where('user.login_name like "' . $keyword . '%" or user.username like "' . $keyword . '%"')->count();
    	// } else {
    	// 	//$count = $user->where(array('login_name' => array('like',$keyword .'%' )) or array('name' => array('like',$keyword .'%' )))->group('user_id')->count();
     //        $count = $user->relation(true)->count();
    	// }
        
        if(I('keyword') != '' ) {
            $condition['login_name']=array('like',I('keyword') . '%');
            $condition['name']=array('like',I('keyword') . '%');
            $condition['_logic']='OR';
            $keyword = I('keyword');
            $count = $user->relation(true)->where($condition)->count();

            //$count = $user->where('user.login_name like "' . $keyword . '%" or user.username like "' . $keyword . '%"')->count();
        } else {
            //$count = $user->where(array('login_name' => array('like',$keyword .'%' )) or array('name' => array('like',$keyword .'%' )))->group('user_id')->count();
            $count = $user->relation(true)->count();
        }         
        $user_data['user_id'] = session(C('USER_AUTH_KEY'));
        
        $user_data['page'] = $_POST['page'] != '' ? $_POST['page'] : session('page');
        if($user->save($user_data) !== false) {
            session('page',$user_data['page']);
        }    	
    	$page = new \Lib\MyPage($count,session('page'));

    	//$page->parameter=I('get.');
    	//$page->setConfig('header','条数据');
    	
 		

    	$show = $page->show();
    	
    	if($condition != '') {
            $list = $user->relation(true)->where($condition)->order('user_id')->limit($page->firstRow . ',' . $page->listRows)->select();
            
            
        }else{
             $list = $user->relation(true)->order('user_id')->limit($page->firstRow . ',' . $page->listRows)->select();
           
            
        }
        // $sessconf = C('SESSION_OPTIONS');
        // $sesspath = $sessconf['path'] . '/sess_';
       
       $sess = M('session')->select();

       foreach ($list as $k => $v) {
             $v['is_online'] = 0;
             foreach ($sess as $j => $l) {
                $sess_data = explode(';',$l['session_data']);
                $mark = $sess_data[0];
                $tmp = explode('"',$mark);
                if($v['sess_id'] == $l['session_id'] && $tmp[1] == $v['user_id']) {
                    $v['is_online'] = 1;
                    
                }
            }
            $list[$k] = $v;
        }
        

    	//$list = $user->where('login_name like "' . $keyword . '%" or username like "' . $keyword . '%"')->order('user_id')->limit($page->firstRow . ',' . $page->listRows)->select();
    	
        // dump($list);die;
    	$this->assign('userlist',$list);
    	$this->assign('page',$show);
    	$this->assign('keyword',$keyword);
        $this->assign('count',$count);
        $this->assign('userPage',session('page'));
    
        //print_r($list);die;
    	$this->assign('level1',$this->level1);
    	$this->assign('level2',$this->level2);
    	$this->assign('level3',$this->level3);
      	$this->display();
    }


    public function addUser() {
        $this->level2 = '用户列表';
        $this->level3 = '添加用户';


        $active = 'user';

        $this->assign('active',$active);

        $rule = array(
                array('login_name', 'require','登录名必须！'),
                array('login_name', '4,10','登录名为4-10个字符！',0,'length'),
                array('login_name', 'require','登录名重复！',0,'unique',1),
                array('name', 'require','用户别名必须！'),
                array('name', '1,30','用户别名为1-30个字符！',0,'length'),
                array('password', 'require','密码不能为空！'),
                array('password', '6,20','密码为6-20个字符！',0,'length'),
                array('repassword', 'password','确认密码不正确！',0,'confirm'),
                array('email', 'email','非法的email！'),
                array('mobile', 'number','手机号码需为数字！',2),
                array('mobile', '11','手机号码长度不对，需要11个数字！',2,'length'),
                array('project_id','0','所属项目未选择！',1,'notequal'),
                array('system_id','0','所属系统未选择！',1,'notequal'),
                array('role_id','chkrole','角色选择不正确！',1,'function'),
                array('status', 'require','开启状态必须设置！',1)
            );

        $log = array(
                    'login_user_id' => session('uid'),
                    'source_ip' => session('login_ip'),
                    'oper_time' => time()
                    
                );

        if(IS_POST) {
            $user_data = array(
                    'login_name' => I('login_name'),
                    'name' => I('name'),
                    'password' => I('password','','md5'),
                    'email' => I('email'),
                    'mobile' => I('mobile'),
                    'gender' => I('gender'),
                    'project_id' => I('project_id'),
                    'system_id' => I('system_id'),
                    'user_desc' => I('user_desc'),
                    'status' => I('status'),
                    'login_ip' => get_client_ip()
                );
            $user = M('user');

            if($user->validate($rule)->create()) {
                $role = array();
                $user->startTrans();
                if($user_id = $user->add($user_data)) {
                    foreach ($_POST['role_id'] as $v) {
                        $role[] = array(
                            'role_id' => $v,
                            'user_id' => $user_id
                            );
                    }

                    if(M('role_user')->addAll($role)) {
                        $log['oper'] =  $user_data['login_name'] . '用户添加成功';
                        M('oper_log')->add($log);
                        $user->commit();
                        $this->success('用户添加成功！',U('Admin/User/lists'));
                        exit;
                    }else {
                        $user->rollback();
                        $log['oper'] =  $user_data['login_name'] . '用户添加失败';
                        M('oper_log')->add($log);
                        $this->error('用户添加失败！',U('Admin/User/addUser'));
                        exit;
                    }
                }else {
                    $user->rollback();
                    $log['oper'] =  $user_data['login_name'] . '用户添加失败';
                    M('oper_log')->add($log);
                    $this->error('用户添加失败！',U('Admin/User/addUser'));
                    exit;
                }

            } else {
                $log['oper'] =  $user_data['login_name'] . '用户添加失败';
                M('oper_log')->add($log);
                $this->error($user->getError(),U('Admin/User/addUser'));
                exit;
            }
        }


        $this->role = M('role')->select();
        $this->project = M('project')->select();
        $this->system = M('system')->select();

        $this->assign('level1',$this->level1);
        $this->assign('level2',$this->level2);
        $this->assign('level3',$this->level3);
        $this->display();

    }


    public function editUser() {
        $this->level2 = '用户列表';
        $this->level3 = '编辑用户';


        $active = 'user';

        $this->assign('active',$active);

        $rule = array(
                array('name', 'require','用户别名必须！'),
                array('name', '1,30','用户别名为4-10个字符！',0,'length'),
                array('password', '6,20','密码为6-20个字符！',2,'length'),
                array('repassword', 'password','确认密码不正确！',0,'confirm'),
                array('email', 'email','非法的email！'),
                array('mobile', 'number','手机号码需为数字！',2),
                array('mobile', '11','手机号码长度不对，需要11个数字！',2,'length'),
                array('project_id','0','所属项目未选择！',1,'notequal'),
                array('system_id','0','所属系统未选择！',1,'notequal'),
                array('role_id','chkrole','角色选择不正确！',1,'function'),
                array('status', 'require','开启状态必须设置！',1)
            );


        $log = array(
                    'login_user_id' => session('uid'),
                    'source_ip' => session('login_ip'),
                    'oper_time' => time()
                    
                );

        if(IS_POST) {
            if(I('password') == '') {
                $user_data = array(
                    'user_id' => I('user_id'),
                    'name' => I('name'),
                    'login_name' => I('login_name'),
                    'email' => I('email'),
                    'mobile' => I('mobile'),
                    'gender' => I('gender'),
                    'project_id' => I('project_id'),
                    'system_id' => I('system_id'),
                    'user_desc' => I('user_desc'),
                    'status' => I('status'),
                    'login_ip' => get_client_ip()
                );
            }else {
                $user_data = array(
                    'user_id' => I('user_id'),
                    'login_name' => I('login_name'),
                    'name' => I('name'),
                    'password' => I('password','','md5'),
                    'email' => I('email'),
                    'mobile' => I('mobile'),
                    'gender' => I('gender'),
                    'project_id' => I('project_id'),
                    'system_id' => I('system_id'),
                    'user_desc' => I('user_desc'),
                    'status' => I('status'),
                    'login_ip' => get_client_ip()
                );
            }
            
            $user = M('user');
            if($user->validate($rule)->create()) {
                $user->startTrans();
                $role = array();
                if($user->save($user_data) !== false) {
                    foreach ($_POST['role_id'] as $v) {
                        $role[] = array(
                            'role_id' => $v,
                            'user_id' => $user_data['user_id']
                            );
                    }

                   if(M('role_user')->where(array('user_id' => $user_data['user_id']))->delete() !== false) {
                        if(M('role_user')->addAll($role)) {
                            $log['oper'] =  $user_data['login_name'] . '用户修改成功';
                            M('oper_log')->add($log);
                            $user->commit();
                            $this->success('用户修改成功！',U('Admin/User/lists'));
                            exit;
                        }else {
                            $user->rollback();
                            $log['oper'] =  $user_data['login_name'] . '用户修改失败';
                            M('oper_log')->add($log);
                            $this->error('用户修改失败，角色添加失败！',U('Admin/User/editUser',array('user_id' => $user_data['user_id'])));
                            exit;
                        }  
                   }else{
                        $user->rollback();
                        $log['oper'] =  $user_data['login_name'] . '用户修改失败';
                        M('oper_log')->add($log);
                        $this->error('用户修改失败，原有角色清除失败！',U('Admin/User/editUser',array('user_id' => $user_data['user_id'])));
                        exit;
                   }

                    
                }else {
                    $user->rollback();
                    $log['oper'] =  $user_data['login_name'] . '用户修改失败';
                    M('oper_log')->add($log);
                    $this->error('用户修改保存失败！',U('Admin/User/editUser',array('user_id' => $user_data['user_id'])));
                    exit;
                }

            } else {
                $log['oper'] =  $user_data['login_name'] . '用户修改失败';
                M('oper_log')->add($log);
                $this->error($user->getError(),U('Admin/User/editUser',array('user_id' => $user_data['user_id'])));
                exit;
            }
        }

        $this->user = M('user')->where(array('user_id' => I('user_id')))->find();
        $this->user_role = M('role_user')->where(array('user_id' => I('user_id')))->select();


        $this->role = M('role')->select();
        $this->project = M('project')->select();
        $this->system = M('system')->select();

        $this->assign('level1',$this->level1);
        $this->assign('level2',$this->level2);
        $this->assign('level3',$this->level3);
        $this->display();

    }


    public function delUser() {
        $this->level2 = '用户列表';
        $this->level3 = '删除用户';

        $active = 'user';

        $this->assign('active',$active);

        $user_id = I('user_id');

        $log = array(
                    'login_user_id' => session('uid'),
                    'source_ip' => session('login_ip'),
                    'oper_time' => time()
                    
                );

        if($user_id != null) {
            $user = M('user');
            $user_data = $user->field('login_name')->where(array('user_id' => $user_id))->find();
            $user_default_id = $user->where(array('login_name' => 'superadmin'))->getField('user_id');
            $project = M('project');
            $project->architect_id = $user_default_id;
            $system = M('system');
            $system->owner_id = $user_default_id;

            $role_user = M('role_user');
            $user->startTrans();
            if($role_user->where(array('user_id' => $user_id))->delete() !== false) {
                if($project->where(array('architect_id' => $user_id))->save() !== false) {
                    if($system->where(array('owner_id' => $user_id))->save() !== false) {
                        if($user->where(array('user_id' => $user_id))->delete() !==false) {
                            $log['oper'] =  $user_data['login_name'] . '用户删除成功';
                            M('oper_log')->add($log);
                            $user->commit();
                            $this->success('用户删除成功！',U('Admin/User/lists'));
                            exit;
                        }else{
                            $user->rollback();
                            $log['oper'] =  $user_data['login_name'] . '用户删除失败';
                            M('oper_log')->add($log);
                            $this->error('用户删除失败！',U('Admin/User/lists'));
                            exit;
                        }
                    }else{
                        $user->rollback();
                        $log['oper'] =  $user_data['login_name'] . '用户删除失败，相关系统owner重置失败';
                        M('oper_log')->add($log);
                        $this->error('用户删除失败，相关系统owner重置失败',U('Admin/User/lists'));
                        exit;
                    }
                }else{
                    $user->rollback();
                    $log['oper'] =  $user_data['login_name'] . '用户删除失败，相关项目架构师重置失败';
                    M('oper_log')->add($log);
                    $this->error('用户删除失败，相关项目架构师重置失败',U('Admin/User/lists'));
                    exit;
                }
                
            }else{
                $user->rollback();
                $log['oper'] =  $user_data['login_name'] . '用户删除失败，用户角色清除失败！';
                M('oper_log')->add($log);
                $this->error('用户删除失败，用户角色清除失败！',U('Admin/User/lists'));
                exit;
            }
        }else{
            $this->error('没有选择要删除的用户',U('Admin/User/lists'));
        }
    }

    public function delUsers() {
        $this->level2 = '用户列表';
        $this->level3 = '删除用户';

        $active = 'user';

        $this->assign('active',$active);

         $log = array(
                    'login_user_id' => session('uid'),
                    'source_ip' => session('login_ip'),
                    'oper_time' => time()
                    
                );
        

        if(IS_POST) {
            $user_ids = I('checked');

            if(!empty($user_ids)) {
                $user = M('user');
                $user_default_id = $user->where(array('login_name' => 'superadmin'))->getField('user_id');
                $project = M('project');
                
                $system = M('system');
                
                $role_user = M('role_user');
                $user->startTrans();
                foreach ($user_ids as $v) {
                    $user_data = $user->field('login_name')->where(array('user_id' => $v))->find();
                    $project->architect_id = $user_default_id;
                    $system->owner_id = $user_default_id;
                    if($role_user->where(array('user_id' => $v))->delete() !== false) {
                        if($project->where(array('architect_id' => $v))->save() !== false){
                            if($system->where(array('owner_id' => $v))->save() !== false) {
                                if($user->where(array('user_id' => $v))->delete() === false) {
                                    $user->rollback();
                                    $log['oper'] =  $user_data['login_name'] . '用户删除失败';
                                    M('oper_log')->add($log);
                                    $this->error('用户删除失败！',U('Admin/User/lists'));
                                    exit;
                                }
                                $log['oper'] =  $user_data['login_name'] . '用户删除成功';
                                M('oper_log')->add($log);
                            }else{
                                $user->rollback();
                                $log['oper'] =  $user_data['login_name'] . '用户删除失败，相关系统owner重置失败';
                                M('oper_log')->add($log);
                                $this->error('用户删除失败，相关系统owner重置失败',U('Admin/User/lists'));
                                exit;
                            }
                        }else{
                            $user->rollback();
                            $log['oper'] =  $user_data['login_name'] . '用户删除失败，相关项目架构师重置失败';
                            M('oper_log')->add($log);
                            $this->error('用户删除失败，相关项目架构师重置失败',U('Admin/User/lists'));
                            exit;
                        }         
                    }else{
                        $user->rollback();
                        $log['oper'] =  $user_data['login_name'] . '用户删除失败,用户角色清除失败';
                        M('oper_log')->add($log);
                        $this->error('用户删除失败，用户角色清除失败！',U('Admin/User/lists'));
                        exit;
                    }
                }
                $user->commit();
                $this->success('用户删除成功！',U('Admin/User/lists'));
                exit;
            }else{
                $log['oper'] =  '用户删除失败,没有选择要删除的用户';
                M('oper_log')->add($log);
                $this->error('用户删除失败，没有选择要删除的用户!',U('Admin/User/lists'));
                exit;
            }
        }else{
            $log['oper'] =  '用户删除失败,非法操作';
            M('oper_log')->add($log);
            $this->error('用户删除失败，非法操作!',U('Admin/User/lists'));
            exit;
        }
    }


    public function profile() {
        $this->level1 = '用户简介';


        //$active = 'user';

        //$this->assign('active',$active);
        
        $user = D('UserRelation');
        $uid = session('uid');
        $condition['user_id'] = $uid;
       
        $u = $user->relation(true)->where($condition)->find();
        
      

      
        $this->assign('data',$u);
        
    
        //print_r($list);die;
        $this->assign('level1',$this->level1);
        $this->assign('level2',$this->level2);
        $this->assign('level3',$this->level3);
        $this->display();
    }


     public function UserSetting() {
        $this->level1 = '用户设置';
        


        //$active = 'user';

      //  $this->assign('active',$active);

        $rule = array(
                array('name', 'require','用户别名必须！'),
                array('name', '1,30','用户别名为4-10个字符！',0,'length'),
                array('password', '6,20','密码为6-20个字符！',2,'length'),
                array('repassword', 'password','确认密码不正确！',0,'confirm'),
                array('email', 'email','非法的email！'),
                array('mobile', 'number','手机号码需为数字！',2),
                array('mobile', '11','手机号码长度不对，需要11个数字！',2,'length'),
                array('project_id','0','所属项目未选择！',1,'notequal'),
                array('system_id','0','所属系统未选择！',1,'notequal'),
                array('role_id','chkrole','角色选择不正确！',1,'function'),
                array('status', 'require','开启状态必须设置！',1)
            );


        $log = array(
                    'login_user_id' => session('uid'),
                    'source_ip' => session('login_ip'),
                    'oper_time' => time()
                    
                );

        if(IS_POST) {
            if(I('password') == '') {
                $user_data = array(
                    'user_id' => I('user_id'),
                    'name' => I('name'),
                    'login_name' => I('login_name'),
                    'email' => I('email'),
                    'mobile' => I('mobile'),
                    'gender' => I('gender'),
                    'project_id' => I('project_id'),
                    'system_id' => I('system_id'),
                    'user_desc' => I('user_desc'),
                    'status' => I('status'),
                    'login_ip' => get_client_ip()
                );
            }else {
                $user_data = array(
                    'user_id' => I('user_id'),
                    'login_name' => I('login_name'),
                    'name' => I('name'),
                    'password' => I('password','','md5'),
                    'email' => I('email'),
                    'mobile' => I('mobile'),
                    'gender' => I('gender'),
                    'project_id' => I('project_id'),
                    'system_id' => I('system_id'),
                    'user_desc' => I('user_desc'),
                    'status' => I('status'),
                    'login_ip' => get_client_ip()
                );
            }
            
            $user = M('user');
            if($user->validate($rule)->create()) {
                $user->startTrans();
                $role = array();
                if($user->save($user_data) !== false) {
                    foreach ($_POST['role_id'] as $v) {
                        $role[] = array(
                            'role_id' => $v,
                            'user_id' => $user_data['user_id']
                            );
                    }

                   if(M('role_user')->where(array('user_id' => $user_data['user_id']))->delete() !== false) {
                        if(M('role_user')->addAll($role)) {
                            $log['oper'] =  $user_data['login_name'] . '用户修改成功';
                            M('oper_log')->add($log);
                            $user->commit();
                            $this->success('用户修改成功！',U('Admin/User/lists'));
                            exit;
                        }else {
                            $user->rollback();
                            $log['oper'] =  $user_data['login_name'] . '用户修改失败';
                            M('oper_log')->add($log);
                            $this->error('用户修改失败，角色添加失败！',U('Admin/User/editUser',array('user_id' => $user_data['user_id'])));
                            exit;
                        }  
                   }else{
                        $user->rollback();
                        $log['oper'] =  $user_data['login_name'] . '用户修改失败';
                        M('oper_log')->add($log);
                        $this->error('用户修改失败，原有角色清除失败！',U('Admin/User/editUser',array('user_id' => $user_data['user_id'])));
                        exit;
                   }

                    
                }else {
                    $user->rollback();
                    $log['oper'] =  $user_data['login_name'] . '用户修改失败';
                    M('oper_log')->add($log);
                    $this->error('用户修改保存失败！',U('Admin/User/editUser',array('user_id' => $user_data['user_id'])));
                    exit;
                }

            } else {
                $log['oper'] =  $user_data['login_name'] . '用户修改失败';
                M('oper_log')->add($log);
                $this->error($user->getError(),U('Admin/User/editUser',array('user_id' => $user_data['user_id'])));
                exit;
            }
        }

        $this->user = M('user')->where(array('user_id' => session('uid')))->find();
        $this->user_role = M('role_user')->where(array('user_id' => session('uid')))->select();


        $this->role = M('role')->select();
        $this->project = M('project')->select();
        $this->system = M('system')->select();

        $this->assign('level1',$this->level1);
        $this->assign('level2',$this->level2);
        $this->assign('level3',$this->level3);
        $this->display();

    }
    
}