<?php
namespace Admin\Controller;
use Think\Controller;
class SystemController extends CommonController {

	private $level1 = '项目管理';
	private $level2 = '';
	private $level3 = '';
    private $active = 'project';

    public function lists(){


    	$this->level2 = '系统列表';


    	

    	$this->assign('active',$this->active);

    	$system = D('SystemRelation');
        $keyword = '';
        $condition = '';
    	if(isset($_GET) && $_GET['keyword'] != '' ) {
            $condition['system_name']=array('like',I('keyword') . '%');
            $condition['system_desc']=array('like',I('keyword') . '%');
            $condition['_logic']='OR';
    		$keyword = I('keyword');
            $count = $system->relation(true)->where($condition)->count();

    		//$count = $system->where('system.system_name like "' . $keyword . '%" or system.systemname like "' . $keyword . '%"')->count();
    	} else {
    		//$count = $system->where(array('system_name' => array('like',$keyword .'%' )) or array('name' => array('like',$keyword .'%' )))->group('system_id')->count();
            $count = $system->relation(true)->count();
    	}
        
    	
    	$page = new \Lib\MyPage($count,5);

    	//$page->parameter=I('get.');
    	//$page->setConfig('header','条数据');
    	
 		

    	$show = $page->show();
    	
    	if($condition != '') {
            $list = $system->relation(true)->where($condition)->order('system_id')->limit($page->firstRow . ',' . $page->listRows)->select();
            
            
        }else{
             $list = $system->relation(true)->order('system_id')->limit($page->firstRow . ',' . $page->listRows)->select();
           
            
        }
        
      

    	//$list = $system->where('system_name like "' . $keyword . '%" or systemname like "' . $keyword . '%"')->order('system_id')->limit($page->firstRow . ',' . $page->listRows)->select();
    	
        // dump($list);die;
    	$this->assign('systemlist',$list);
    	$this->assign('page',$show);
    	$this->assign('keyword',$keyword);
    
        //print_r($list);die;
    	$this->assign('level1',$this->level1);
    	$this->assign('level2',$this->level2);
    	$this->assign('level3',$this->level3);
      	$this->display();
    }


    public function addSystem() {
        $this->level2 = '系统列表';
        $this->level3 = '添加系统';



        $this->assign('active',$this->active);

        $rule = array(
                array('system_name', 'require','系统名必须！'),
                array('system_name', '2,15','系统名为2-15个字符！',0,'length'),
                array('system_name', 'require','系统名重复！',0,'unique',1),
                array('project_id','0','所属项目未选择！',1,'notequal'),
                array('owner_id','0','系统owner未选择！',1,'notequal'),
                array('deploy_rule_id','0','部署规则未选择！',1,'notequal'),
                array('backup_path','require','备份路径必须！'),
                array('deploy_path','require','部署路径必须！'),
                array('depend_service_id','0','依赖服务未选择！',1,'notequal'),
                array('status', 'require','系统状态必须设置！',1)
            );

        $log = array(
                    'login_user_id' => session('uid'),
                    'source_ip' => session('login_ip'),
                    'oper_time' => time()
                    
                );

        if(IS_POST) {
            $system_data = array(
                    'system_name' => I('system_name'),
                    'project_id' => I('project_id'),
                    'owner_id' => I('owner_id'),
                    'deploy_rule_id' => I('deploy_rule_id'),
                    'pkg_name' => I('pkg_name'),
                    'backup_path' => I('backup_path'),
                    'deploy_path' => I('deploy_path'),
                    'depend_service_id' => I('depend_service_id'),
                    'system_desc' => I('system_desc'),
                    'current_version' => I('current_version'),
                    'status' => I('status')
                );
            $system = M('system');

            if($system->validate($rule)->create()) {
                
                $system->startTrans();
                if($system_id = $system->add($system_data)) {
                    $log['oper'] =  $system_data['system_name'] . '系统添加成功';
                    M('oper_log')->add($log);
                    $system->commit();
                    $this->success('系统添加成功！',U('Admin/System/lists'));
                    exit;
                }else {
                    $system->rollback();
                    $log['oper'] =  $system_data['system_name'] . '系统添加失败';
                    M('oper_log')->add($log);
                    $this->error('系统添加失败！',U('Admin/System/addSystem'));
                    exit;
                }

            } else {
                $log['oper'] =  $system_data['system_name'] . '系统添加失败';
                M('oper_log')->add($log);
                $this->error($system->getError(),U('Admin/System/addSystem'));
                exit;
            }
        }


        $this->user = M('user')->select();
        $this->deploy_rule = M('deploy_rule')->select();
        $this->service = M('service')->select();
        $this->project = M('project')->select();
        

        $this->assign('level1',$this->level1);
        $this->assign('level2',$this->level2);
        $this->assign('level3',$this->level3);
        $this->display();

    }


    public function editSystem() {
        $this->level2 = '系统列表';
        $this->level3 = '编辑系统';



        $this->assign('active',$this->active);

         $rule = array(
                array('project_id','0','所属项目未选择！',1,'notequal'),
                array('owner_id','0','系统owner未选择！',1,'notequal'),
                array('deploy_rule_id','0','部署规则未选择！',1,'notequal'),
                array('backup_path','require','备份路径必须！'),
                array('deploy_path','require','部署路径必须！'),
                array('depend_service_id','0','依赖服务未选择！',1,'notequal'),
                array('status', 'require','系统状态必须设置！',1)
            );


        $log = array(
                    'login_user_id' => session('uid'),
                    'source_ip' => session('login_ip'),
                    'oper_time' => time()
                    
                );

        if(IS_POST) {
           
                $system_data = array(
                    'system_id' => I('system_id'),
                    'system_name' => I('system_name'),
                    'project_id' => I('project_id'),
                    'owner_id' => I('owner_id'),
                    'deploy_rule_id' => I('deploy_rule_id'),
                    'pkg_name' => I('pkg_name'),
                    'backup_path' => I('backup_path'),
                    'deploy_path' => I('deploy_path'),
                    'depend_service_id' => I('depend_service_id'),
                    'system_desc' => I('system_desc'),
                    'current_version' => I('current_version'),
                    'status' => I('status')
                );
            
            
            $system = M('system');
            if($system->validate($rule)->create()) {
                $system->startTrans();
                
                if($system->save($system_data) !== false) {
                    $log['oper'] =  $system_data['system_name'] . '系统修改成功';
                    M('oper_log')->add($log);
                    $system->commit();
                    $this->success('系统修改成功！',U('Admin/System/lists'));
                    exit;
                    
                }else {
                    $system->rollback();
                    $log['oper'] =  $system_data['system_name'] . '系统修改失败';
                    M('oper_log')->add($log);
                    $this->error('系统修改保存失败！',U('Admin/System/editSystem',array('system_id' => $system_data['system_id'])));
                    exit;
                }

            } else {
                $log['oper'] =  $system_data['system_name'] . '系统修改失败';
                M('oper_log')->add($log);
                $this->error($system->getError(),U('Admin/System/editSystem',array('system_id' => $system_data['system_id'])));
                exit;
            }
        }

        $this->system = M('system')->where(array('system_id' => I('system_id')))->find();
       


        $this->user = M('user')->select();
        $this->deploy_rule = M('deploy_rule')->select();
        $this->service = M('service')->select();
        $this->project = M('project')->select();

        $this->assign('level1',$this->level1);
        $this->assign('level2',$this->level2);
        $this->assign('level3',$this->level3);
        $this->display();

    }


    public function delSystem() {
        $this->level2 = '系统列表';
        $this->level3 = '删除系统';


        $this->assign('active',$this->active);

        $system_id = I('system_id');

        $log = array(
                    'login_user_id' => session('uid'),
                    'source_ip' => session('login_ip'),
                    'oper_time' => time()
                    
                );

        if($system_id != null) {
            $system = M('system');
            $system_data = $system->field('system_name')->where(array('system_id' => $system_id))->find();
            $host = M('system_host');
            $user = M('user');
            $system_default_id = $system->where(array('system_name' => '默认系统'))->getField('system_id');
            $user->system_id = $system_default_id;
            $hosts = $host->where(array('system_id' => $system_id))->field('host_id')->select();
            $host_ids = array();
            foreach ($hosts as $v) {
                $host_ids[] = $v['host_id'];
            }
            if(empty($host_ids)) {
                $condition['host_id'] = 0;
            }else{
                $condition['host_id'] = array('in',$host_ids);
            }
            
            $service_host = M('service_host');
            $system->startTrans();
            if($service_host->where($condition)->delete() !== false) {
                if($host->where(array('system_id' => $system_id))->delete() !== false) {
                    if($user->where(array('system_id' => $system_id))->save() !== false) {
                        if($system->where(array('system_id' => $system_id))->delete() !==false) {
                            $log['oper'] =  $system_data['system_name'] . '系统删除成功';
                            M('oper_log')->add($log);
                            $system->commit();
                            $this->success('系统删除成功！',U('Admin/System/lists'));
                            exit;
                        }else{
                            $system->rollback();
                            $log['oper'] =  $system_data['system_name'] . '系统删除失败';
                            M('oper_log')->add($log);
                            $this->error('系统删除失败！',U('Admin/System/lists'));
                            exit;
                        }
                    }else{
                            $system->rollback();
                            $log['oper'] =  $system_data['system_name'] . '系统删除失败,人员所属系统重置失败';
                            M('oper_log')->add($log);
                            $this->error('系统删除失败，人员所属系统重置失败',U('Admin/System/lists'));
                            exit;
                    }
                
                }else{
                    $system->rollback();
                    $log['oper'] =  $system_data['system_name'] . '系统删除失败，系统下主机删除失败';
                    M('oper_log')->add($log);
                    $this->error('系统删除失败，系统下主机删除失败',U('Admin/System/lists'));
                    exit;
                }
            }else{
                 $system->rollback();
                $log['oper'] =  $system_data['system_name'] . '系统删除失败，主机关联服务清除失败';
                M('oper_log')->add($log);
                $this->error('系统删除失败，主机关联服务清除失败',U('Admin/System/lists'));
                exit;
            }
            
        }else{
            $this->error('没有选择要删除的系统！',U('Admin/System/lists'));
        }
    }

    public function delSystems() {
        $this->level2 = '系统列表';
        $this->level3 = '删除系统';



        $this->assign('active',$this->active);

         $log = array(
                    'login_user_id' => session('uid'),
                    'source_ip' => session('login_ip'),
                    'oper_time' => time()
                    
                );
        

        if(IS_POST) {
            $system_ids = I('checked');

            if(!empty($system_ids)) {
                $system = M('system');
                $host = M('system_host');
                $user = M('user');
                $system_default_id = $system->where(array('system_name' => '默认系统'))->getField('system_id');
               
                $service_host = M('service_host');
                $system->startTrans();
                foreach ($system_ids as $v) {
                     $user->system_id = $system_default_id;
                    $hosts = $host->where(array('system_id' => $v))->field('host_id')->select();
                    $host_ids = array();
                    foreach ($hosts as $j) {
                        $host_ids[] = $j['host_id'];
                    }
                    if(empty($host_ids)) {
                        $condition['host_id'] = 0;
                    }else{
                        $condition['host_id'] = array('in',$host_ids);
                    }
                   
                    

                    $system_data = $system->field('system_name')->where(array('system_id' => $v))->find();
                    if($service_host->where($condition)->delete() !== false) {
                        if($host->where(array('system_id' => $v))->delete() !== false) {
                             if($user->where(array('system_id' => $v))->save() !== false) {
                                if($system->where(array('system_id' => $v))->delete() === false) {
                                    $system->rollback();
                                    $log['oper'] =  $system_data['system_name'] . '系统删除失败';
                                    M('oper_log')->add($log);
                                    $this->error('系统删除失败！',U('Admin/System/lists'));
                                    exit;
                                }
                                $log['oper'] =  $system_data['system_name'] . '系统删除成功';
                                M('oper_log')->add($log);
                             }else{
                                $system->rollback();
                                $log['oper'] =  $system_data['system_name'] . '系统删除失败，相关用户所属系统重置失败';
                                M('oper_log')->add($log);
                                $this->error('系统删除失败，相关用户所属系统重置失败',U('Admin/System/lists'));
                                exit;
                             }
                            
                        }else{
                            $system->rollback();
                            $log['oper'] =  $system_data['system_name'] . '系统删除失败,相关主机删除失败';
                            M('oper_log')->add($log);
                            $this->error('系统删除失败，相关主机删除失败！',U('Admin/System/lists'));
                            exit;
                        }
                    }else{
                        $system->rollback();
                        $log['oper'] =  $system_data['system_name'] . '系统删除失败，相关主机关联服务删除失败';
                        M('oper_log')->add($log);
                        $this->error('系统删除失败，相关主机关联服务删除失败',U('Admin/System/lists'));
                        exit;
                    }
                    
                }
                $system->commit();
                $this->success('系统删除成功！',U('Admin/System/lists'));
                exit;
            }else{
                $log['oper'] =  '系统删除失败,没有选择要删除的系统';
                M('oper_log')->add($log);
                $this->error('系统删除失败，没有选择要删除的系统!',U('Admin/System/lists'));
                exit;
            }
        }else{
            $log['oper'] =  '系统删除失败,非法操作';
            M('oper_log')->add($log);
            $this->error('系统删除失败，非法操作!',U('Admin/System/lists'));
            exit;
        }
    }


    
}