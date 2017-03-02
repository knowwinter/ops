<?php
namespace Admin\Controller;
use Think\Controller;
class RoleController extends CommonController {

	private $level1 = '用户管理';
	private $level2 = '';
	private $level3 = '';

    public function lists(){
    	
        $this->level2 = '角色列表';

    	$active = 'user';

    	$this->assign('active',$active);

    	$role = M('role');
    	if(isset($_GET) && $_GET['keyword'] != '' ) {
    		$keyword = I('keyword');
    		$count = $role->where('name like "' . $keyword . '%" or remark like "' . $keyword . '%"')->count();
    	} else {
    		$count = $role->count();
    	}

    	
    	$page = new \Lib\MyPage($count,5);

    	//$page->parameter=I('get.');
    	//$page->setConfig('header','条数据');
    	
 		

    	$show = $page->show();
    	
    	

        if($keyword != '') {
            $list = $role->where('name like "' . $keyword . '%" or remark like "' . $keyword . '%"')->order('id')->limit($page->firstRow . ',' . $page->listRows)->select();
        }else {
            $list = $role->limit($page->firstRow . ',' . $page->listRows)->select();
        }
    	
    	

    	$this->assign('rolelist',$list);
    	$this->assign('page',$show);
    	$this->assign('keyword',$keyword);
    
    	$this->assign('level1',$this->level1);
    	$this->assign('level2',$this->level2);
    	$this->assign('level3',$this->level3);
      	$this->display();
    }


     public function addRole(){
       $this->level2 = '角色列表';

       $this->level3 = '添加角色';

       $this->assign('level1',$this->level1);
        $this->assign('level2',$this->level2);
        $this->assign('level3',$this->level3);


        $active = 'user';

        $this->assign('active',$active);

        $rule = array(
                array('name', 'require','角色名必须'),
                array('name', 'require','角色名重复！',0,'unique',1),
                array('status', 'require','开启状态必须设置',1)
            );


        $log = array(
                    'login_user_id' => session('uid'),
                    'source_ip' => session('login_ip'),
                    'oper_time' => time()
                    
                );

        if(IS_POST) {
            $role = M('role');


            if(!$role->validate($rule)->create()) {
                
                
                $this->error($role->getError(),U('Admin/Role/addRole'));
                exit;
                
            } else {

                if($role->add()) {
                    $log['oper'] = I('name')  . '角色添加成功';
                    M('oper_log')->add($log);
                    $this->success('角色添加成功！',U('Admin/Role/lists'));
                    exit;
                } else {
                    $this->error($role->getError(),U('Admin/Role/addRole'));
                    $log['oper'] = I('name')  . '角色添加失败';
                    M('oper_log')->add($log);
                    exit;
                }
            }

        }
        
        $this->display();
    }


     public function delRole($id){

       $this->level2 = '角色列表';

       $this->level3 = '删除角色';

       $this->assign('level1',$this->level1);
        $this->assign('level2',$this->level2);
        $this->assign('level3',$this->level3);


        $active = 'user';

        $this->assign('active',$active);

        $log = array(
                    'login_user_id' => session('uid'),
                    'source_ip' => session('login_ip'),
                    'oper_time' => time()
                    
                );


       if(isset($id)) {
            $role = M('role');
            $role_name= $role->field('name')->where(array('id' => $id))->delete();
            $access = M('access');
            $role_user = M('role_user');
            $role->startTrans();

            $acc = $access->where(array('role_id' => $id))->count();
            $r_u = $role_user->where(array('role_id' => $id))->count();

            if($acc > 0 && $r_u > 0) {
                if($role->where(array('id' => $id))->delete() && $access->where(array('role_id' => $id))->delete() && $role_user->where(array('role_id' => $id))->delete()) {
                    $log['oper'] = $role_name . '角色删除成功';
                    M('oper_log')->add($log);
                    $role->commit();
                    $this->success('角色删除成功！',U('Admin/Role/lists'));
                    exit;
                }else {
                    $role->rollback();
                    $log['oper'] = $role_name . '角色删除失败';
                    M('oper_log')->add($log);
                    $this->error('角色删除失败！',U('Admin/Role/lists'));
                    exit;
                }
            }else if($acc > 0) {
                if($role->where(array('id' => $id))->delete() && $access->where(array('role_id' => $id))->delete()) {
                    $log['oper'] = $role_name . '角色删除成功';
                    M('oper_log')->add($log);
                    $role->commit();
                    $this->success('角色删除成功！',U('Admin/Role/lists'));
                    exit;
                }else {
                    $role->rollback();
                    $log['oper'] = $role_name . '角色删除失败';
                    M('oper_log')->add($log);
                    $this->error('角色删除失败！',U('Admin/Role/lists'));
                    exit;
                }
            }else {
                if($role->where(array('id' => $id))->delete() && $role_user->where(array('role_id' => $id))->delete()) {
                    $log['oper'] = $role_name . '角色删除成功';
                    M('oper_log')->add($log);
                    $role->commit();
                    $this->success('角色删除成功！',U('Admin/Role/lists'));
                    exit;
                }else {
                    $role->rollback();
                    $log['oper'] = $role_name . '角色删除失败';
                    M('oper_log')->add($log);
                    $this->error('角色删除失败！',U('Admin/Role/lists'));
                    exit;
                }
            }
       } else {
            $log['oper'] = '角色删除失败，没有选定删除的角色';
            M('oper_log')->add($log);
            $this->error('角色删除失败,没有选定删除的角色！',U('Admin/Role/lists'));
            exit;
       }
        
        
    }

    public function delRoles(){
       
       $this->level2 = '角色列表';

       $this->level3 = '删除角色';

       $this->assign('level1',$this->level1);
        $this->assign('level2',$this->level2);
        $this->assign('level3',$this->level3);


        $active = 'user';

        $this->assign('active',$active);

        $log = array(
                    'login_user_id' => session('uid'),
                    'source_ip' => session('login_ip'),
                    'oper_time' => time()
                    
                );


       if(isset($_POST)) {
            $ids = I('checked');
            $role = M('role');
            $access = M('access');
            $role_user = M('role_user');
            $role->startTrans();
            
            foreach ($ids as $k => $v) {
                $acc = $access->where(array('role_id' => $v))->count();
                $r_u = $role_user->where(array('role_id' => $v))->count();
                $role_name = $role->field('name')->where(array('id' => $v))->find();

                if($acc > 0 && $r_u > 0) {
                    if(!$role->where(array('id' => $v))->delete() || !$access->where(array('role_id' => $v))->delete() || !$role_user->where(array('role_id' => $v))->delete()) {
                        $role->rollback();
                        $log['oper'] =  $role_name['name'] . '删除失败';
                        M('oper_log')->add($log);
                        $this->error('角色删除失败！',U('Admin/Role/lists'));
                        exit;
                    }
                    $log['oper'] =  $role_name['name'] . '删除成功';
                    M('oper_log')->add($log);
                }else if($acc > 0) {
                    if(!$role->where(array('id' => $v))->delete() || !$access->where(array('role_id' => $v))->delete()) {
                        $role->rollback();
                        $log['oper'] =  $role_name['name'] . '删除失败';
                        M('oper_log')->add($log);
                        $this->error('角色删除失败！',U('Admin/Role/lists'));
                        exit;
                    }
                    $log['oper'] =  $role_name['name'] . '删除成功';
                    M('oper_log')->add($log);
                }else {
                    if(!$role->where(array('id' => $v))->delete() || !$role_user->where(array('role_id' => $v))->delete()) {
                        $role->rollback();
                        $log['oper'] =  $role_name['name'] . '删除失败';
                        M('oper_log')->add($log);
                        $this->error('角色删除失败！',U('Admin/Role/lists'));
                        exit;
                    }
                    $log['oper'] =  $role_name['name'] . '删除成功';
                    M('oper_log')->add($log);
                }
            }
            $role->commit();
            $this->success('角色删除成功！',U('Admin/Role/lists'));
            exit;
        } else {
             $log['oper'] =  '角色删除失败，没有选定删除的角色！';
             M('oper_log')->add($log);
             $this->error('角色删除失败，没有选定删除的角色！',U('Admin/Role/lists'));
             exit;
         }
        
        
    }

    public function editRole(){
       $this->level2 = '角色列表';

       $this->level3 = '编辑角色';

       $this->assign('level1',$this->level1);
        $this->assign('level2',$this->level2);
        $this->assign('level3',$this->level3);


        $active = 'user';

        $this->assign('active',$active);

        $rule = array(
                
                array('status', 'require','开启状态必须设置',1)
            );

        $log = array(
                    'login_user_id' => session('uid'),
                    'source_ip' => session('login_ip'),
                    'oper_time' => time()
                    
                );



        if(IS_GET) {
            $role = M('role')->where('id = ' . I('id'))->find();
            $this->assign('role',$role);
        }

        if(IS_POST) {
            $role = M('role');


            if(!$role->validate($rule)->create()) {
                
                
                $this->error($role->getError(),U('Admin/Role/addRole'));
                exit;
                
            } else {

                if($role->save() !== false) {
                    $log['oper'] =  I('name') . '角色修改成功';
                    M('oper_log')->add($log);
                    $this->success('角色修改成功！',U('Admin/Role/lists'));
                    exit;
                } else {
                    $log['oper'] =  I('name') . '角色修改失败';
                    M('oper_log')->add($log);
                    $this->error($role->getError(),U('Admin/Role/addRole'));
                    exit;
                }
            }

        }
        
        $this->display();
    }


    public function access() {
        $this->level2 = '角色列表';
        $this->level3 = '配置权限';

        $active = 'user';

        $this->assign('active',$active);

        $role_id = I('role_id', 0, intval);

        $access = M('access')->where(array('role_id' => $role_id))->getField('node_id',true);

        $node = M('node')->order('sort')->select();

        $this->node = node_merge($node,$access);

        
        

        $this->role_id = $role_id;

        

    
        
        


    
    
        $this->assign('level1',$this->level1);
        $this->assign('level2',$this->level2);
        $this->assign('level3',$this->level3);
        $this->display();
    }

     public function setAccess() {
        $this->level2 = '角色列表';
        $this->level3 = '设置权限';

        $active = 'user';

        $this->assign('active',$active);

        $access = M('access');

        
        $role_id = I('role_id', 0, intval);

        $role_name = M('role')->field('name')->where(array('id' => $role_id))->find();
        $log = array(
                    'login_user_id' => session('uid'),
                    'source_ip' => session('login_ip'),
                    'oper_time' => time()
                    
                );

        $access->startTrans();

        $access->where(array('role_id' => $role_id))->delete();

        $data = array();
        foreach ($_POST['access'] as $v) {
            $tmp = explode('_',$v);
            $data[] = array(
                    'role_id' => $role_id,
                    'node_id' => $tmp[0],
                    'level' => $tmp[1]
                );
        }

        if($access->addAll($data)) {
            $log['oper'] =  $role_name['name'] . '角色权限配置成功';
            M('oper_log')->add($log);
            $access->commit();
            $this->success('权限配置成功！',U('Admin/Role/lists'));
            exit;
        } else {
            $access->rollback();
            $log['oper'] =  $role_name['name'] . '角色权限配置失败';
            M('oper_log')->add($log);
            $this->error('权限配置失败！',U('Admin/Role/lists'));
            exit;
        }



    
        
        


    
    
        // $this->assign('level1',$this->level1);
        // $this->assign('level2',$this->level2);
        // $this->assign('level3',$this->level3);
        // $this->display();
    }



    
}