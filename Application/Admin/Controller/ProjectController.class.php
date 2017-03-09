<?php
namespace Admin\Controller;
use Think\Controller;
class ProjectController extends CommonController {

	private $level1 = '项目管理';
	private $level2 = '';
	private $level3 = '';
    private $active = 'project';

    public function lists(){


    	$this->level2 = '项目列表';


    	

    	$this->assign('active',$this->active);

    	$project = D('ProjectRelation');
        $user = D('UserRelation');
        $keyword = '';
        $condition = '';
    	if(I('keyword') != '') {
            $condition['project_name']=array('like',I('keyword') . '%');
            $condition['project_desc']=array('like',I('keyword') . '%');
            $condition['_logic']='OR';
    		$keyword = I('keyword');
            $count = $project->relation(true)->where($condition)->count();

    		//$count = $project->where('project.project_name like "' . $keyword . '%" or project.projectname like "' . $keyword . '%"')->count();
    	} else {
    		//$count = $project->where(array('project_name' => array('like',$keyword .'%' )) or array('name' => array('like',$keyword .'%' )))->group('project_id')->count();
            $count = $project->relation(true)->count();
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
            $list = $project->relation(true)->where($condition)->order('project_id')->limit($page->firstRow . ',' . $page->listRows)->select();
            
            
        }else{
             $list = $project->relation(true)->order('project_id')->limit($page->firstRow . ',' . $page->listRows)->select();
           
            
        }
        
      

    	//$list = $project->where('project_name like "' . $keyword . '%" or projectname like "' . $keyword . '%"')->order('project_id')->limit($page->firstRow . ',' . $page->listRows)->select();
    	
        // dump($list);die;
    	$this->assign('projectlist',$list);
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


    public function addProject() {
        $this->level2 = '项目列表';
        $this->level3 = '添加项目';



        $this->assign('active',$this->active);

        $rule = array(
                array('project_name', 'require','项目名必须！'),
                array('project_name', '2,20','项目名为2-20个字符！',0,'length'),
                array('project_name', 'require','项目名重复！',0,'unique',1),
                array('architect_id','0','架构师未选择！',1,'notequal'),
                array('status', 'require','项目状态必须设置！',1)
            );

        $log = array(
                    'login_user_id' => session('uid'),
                    'source_ip' => session('login_ip'),
                    'oper_time' => time()
                    
                );

        if(IS_POST) {
            $project_data = array(
                    'project_name' => I('project_name'),
                    'project_desc' => I('project_desc'),
                    'architect_id' => I('architect_id'),
                    'status' => I('status')
                );
            $project = M('project');

            if($project->validate($rule)->create()) {
                $project->startTrans();
                if($project_id = $project->add($project_data)) {
                    $log['oper'] =  $project_data['project_name'] . '项目添加成功';
                    M('oper_log')->add($log);
                    $project->commit();
                    $this->success('项目添加成功！',U('Admin/Project/lists'));
                    exit;
                }else {
                    $project->rollback();
                    $log['oper'] =  $project_data['project_name'] . '项目添加失败';
                    M('oper_log')->add($log);
                    $this->error('项目添加失败！',U('Admin/Project/addProject'));
                    exit;
                }

            } else {
                $log['oper'] =  $project_data['project_name'] . '项目添加失败';
                M('oper_log')->add($log);
                $this->error($project->getError(),U('Admin/Project/addProject'));
                exit;
            }
        }


        $this->user = M('user')->field('user_id,name')->select();

        $this->assign('level1',$this->level1);
        $this->assign('level2',$this->level2);
        $this->assign('level3',$this->level3);
        $this->display();

    }


    public function editProject() {
        $this->level2 = '项目列表';
        $this->level3 = '编辑项目';


        $this->assign('active',$this->active);

        $rule = array(
                array('architect_id','0','架构师未选择！',1,'notequal'),
                array('status', 'require','项目状态必须设置！',1)
            );


        $log = array(
                    'login_user_id' => session('uid'),
                    'source_ip' => session('login_ip'),
                    'oper_time' => time()
                    
                );

        if(IS_POST) {
            
            $project_data = array(
                'project_id' => I('project_id'),
                'project_name' => I('project_name'),
                'project_desc' => I('project_desc'),
                'architect_id' => I('architect_id'),
                'status' => I('status')
            );
            
            
            $project = M('project');
            if($project->validate($rule)->create()) {
                $project->startTrans();
               
                if($project->save($project_data) !== false) {
                   
                    $log['oper'] =  $project_data['project_name'] . '项目修改成功';
                    M('oper_log')->add($log);
                    $project->commit();
                    $this->success('项目修改成功！',U('Admin/Project/lists'));
                    exit;
                    
                }else {
                    $project->rollback();
                    $log['oper'] =  $project_data['project_name'] . '项目修改失败';
                    M('oper_log')->add($log);
                    $this->error('项目修改失败！',U('Admin/Project/editProject',array('project_id' => $project_data['project_id'])));
                    exit;
                }

            } else {
                $log['oper'] =  $project_data['project_name'] . '项目修改失败';
                M('oper_log')->add($log);
                $this->error($project->getError(),U('Admin/Project/editProject',array('project_id' => $project_data['project_id'])));
                exit;
            }
        }

        $this->project = M('project')->where(array('project_id' => I('project_id')))->find();


        
        $this->user = M('user')->field('user_id,name')->select();
        $this->assign('level1',$this->level1);
        $this->assign('level2',$this->level2);
        $this->assign('level3',$this->level3);
        $this->display();

    }


    public function delProject() {
        $this->level2 = '项目列表';
        $this->level3 = '删除项目';


        $this->assign('active',$this->active);

        $project_id = I('project_id');

        $log = array(
                    'login_user_id' => session('uid'),
                    'source_ip' => session('login_ip'),
                    'oper_time' => time()
                    
                );

        if($project_id != null) {
            $project = M('project');
            $project_data = $project->field('project_name')->where(array('project_id' => $project_id))->find();
            $host = M('system_host');
            $user = M('user');
            $system = M('system');
            $system_default_id = $system->where(array('system_name' => '默认系统'))->getField('system_id');
            $user->system_id = $system_default_id;
            $project_default_id = $project->where(array('project_name' => '默认项目'))->getField('project_id');
            $user->project_id = $project_default_id;
            $systems = $system->field('system_id')->where(array('project_id' => $project_id))->select();
            $system_ids = array();
            foreach ($systems as $v) {
                $system_ids[] = $v['system_id'];
            }
            $condition['system_id'] = array('in',$system_ids);
            $service_host = M('service_host');
            $host_ids = $host->where($condition)->getField('host_id',true);
            if(empty($host_ids)) {
                $s_h_condition['host_id'] = 0;
            }else{
                $s_h_condition['host_id'] = array('in',$host_ids);
            }
            
            $project->startTrans();
            if($user->where(array('project_id' => $project_id))->save() !== false) {
                if($service_host->where($s_h_condition)->delete() !== false) {
                    if($host->where($condition)->delete() !== false) {
                        if($system->where($condition)->delete() !== false) {
                            if($project->where(array('project_id' => $project_id))->delete() !==false) {
                                $log['oper'] =  $project_data['project_name'] . '项目删除成功';
                                M('oper_log')->add($log);
                                $project->commit();
                                $this->success('项目删除成功！',U('Admin/Project/lists'));
                                exit;
                            }else{
                                $project->rollback();
                                $log['oper'] =  $project_data['project_name'] . '项目删除失败';
                                M('oper_log')->add($log);
                                $this->error('项目删除失败！',U('Admin/Project/lists'));
                                exit;
                            }
                        }else{
                            $project->rollback();
                            $log['oper'] =  $project_data['project_name'] . '项目删除失败，相关系统删除失败';
                            M('oper_log')->add($log);
                            $this->error('项目删除失败，相关系统删除失败',U('Admin/Project/lists'));
                            exit;
                        }
                    }else{
                        $project->rollback();
                        $log['oper'] =  $project_data['project_name'] . '项目删除失败，相关主机删除失败';
                        M('oper_log')->add($log);
                        $this->error('项目删除失败，相关主机删除失败',U('Admin/Project/lists'));
                        exit;
                    }
                }else{
                    $project->rollback();
                    $log['oper'] =  $project_data['project_name'] . '项目删除失败，相关主机关联服务删除失败';
                    M('oper_log')->add($log);
                    $this->error('项目删除失败，相关主机关联服务删除失败',U('Admin/Project/lists'));
                    exit;
                }
                
                
            }else{
                $project->rollback();
                $log['oper'] =  $project_data['project_name'] . '项目删除失败，相关用户所属项目、系统重置失败';
                M('oper_log')->add($log);
                $this->error('项目删除失败，相关用户所属项目、系统重置失败',U('Admin/Project/lists'));
                exit;
            }
        }else{
             $this->error('没有选择要删除的项目！',U('Admin/Project/lists'));
        }
    }

    public function delProjects() {
        $this->level2 = '项目列表';
        $this->level3 = '删除项目';

        $active = 'project';

        $this->assign('active',$this->active);

         $log = array(
                    'login_user_id' => session('uid'),
                    'source_ip' => session('login_ip'),
                    'oper_time' => time()
                    
                );
        

        if(IS_POST) {
            $project_ids = I('checked');

            if(!empty($project_ids)) {
                $project = M('project');
                $host = M('system_host');
                $user = M('user');
                $system = M('system');
                $system_default_id = $system->where(array('system_name' => '默认系统'))->getField('system_id');
               
                $project_default_id = $project->where(array('project_name' => '默认项目'))->getField('project_id');
                
                $service_host = M('service_host');
               
                $project->startTrans();
                foreach ($project_ids as $v) {
                     $user->system_id = $system_default_id;
                     $user->project_id = $project_default_id;
                    $project_data = $project->field('project_name')->where(array('project_id' => $v))->find();
                    $systems = $system->field('system_id')->where(array('project_id' => $v))->select();
                    $system_ids = array();
                    foreach ($systems as $j) {
                        $system_ids[] = $j['system_id'];
                    }
                    $condition['system_id'] = array('in',$system_ids);
                     $host_ids = $host->where($condition)->getField('host_id',true);

                      if(empty($host_ids)) {
                            $s_h_condition['host_id'] = 0;
                        }else{
                            $s_h_condition['host_id'] = array('in',$host_ids);
                        }
                   

                    if($user->where(array('project_id' => $v))->save() !== false) {
                        if($service_host->where($s_h_condition)->delete() !== false) {
                            if($host->where($condition)->delete() !== false){
                                if($system->where($condition)->delete() !== false) {
                                    if($project->where(array('project_id' => $v))->delete() === false) {
                                        $project->rollback();
                                        $log['oper'] =  $project_data['project_name'] . '项目删除失败';
                                        M('oper_log')->add($log);
                                        $this->error('项目删除失败！',U('Admin/Project/lists'));
                                        exit;
                                    }
                                    $log['oper'] =  $project_data['project_name'] . '项目删除成功';
                                    M('oper_log')->add($log);
                                }else {
                                    $project->rollback();
                                    $log['oper'] =  $project_data['project_name'] . '项目删除失败，相关系统删除失败';
                                    M('oper_log')->add($log);
                                    $this->error('项目删除失败，相关系统删除失败',U('Admin/Project/lists'));
                                    exit;
                                }
                            }else{
                                $project->rollback();
                                $log['oper'] =  $project_data['project_name'] . '项目删除失败，相关主机删除失败';
                                M('oper_log')->add($log);
                                $this->error('项目删除失败，相关主机删除失败',U('Admin/Project/lists'));
                                exit;
                            }
                        }else{
                            $project->rollback();
                            $log['oper'] =  $project_data['project_name'] . '项目删除失败，相关主机关联服务删除失败';
                            M('oper_log')->add($log);
                            $this->error('项目删除失败，相关主机关联服务删除失败',U('Admin/Project/lists'));
                            exit;
                        }
                         
                    }else{
                        $project->rollback();
                        $log['oper'] =  $project_data['project_name'] . '项目删除失败，相关用户所属项目、系统重置失败';
                        M('oper_log')->add($log);
                        $this->error('项目删除失败，相关用户所属项目、系统重置失败',U('Admin/Project/lists'));
                        exit;
                    }
                        
                }
                $project->commit();
                $this->success('项目删除成功！',U('Admin/Project/lists'));
                exit;
            }else{
                $log['oper'] =  '项目删除失败,没有选择要删除的项目';
                M('oper_log')->add($log);
                $this->error('项目删除失败，没有选择要删除的项目!',U('Admin/Project/lists'));
                exit;
            }
        }else{
            $log['oper'] =  '项目删除失败,非法操作';
            M('oper_log')->add($log);
            $this->error('项目删除失败，非法操作!',U('Admin/Project/lists'));
            exit;
        }
    }


    
}