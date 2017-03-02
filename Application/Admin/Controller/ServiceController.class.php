<?php
namespace Admin\Controller;
use Think\Controller;
class ServiceController extends CommonController {

	private $level1 = '服务管理';
	private $level2 = '';
	private $level3 = '';
    private $active = 'service';

    public function lists(){


    	$this->level2 = '服务列表';


    	

    	$this->assign('active',$this->active);

    	$service = M('service');
        $keyword = '';
        $condition = '';
    	if(isset($_GET) && $_GET['keyword'] != '' ) {
            $condition['service_name']=array('like',I('keyword') . '%');
            $condition['service_desc']=array('like',I('keyword') . '%');
            $condition['_logic']='OR';
    		$keyword = I('keyword');
            $count = $service->where($condition)->count();

    		//$count = $service->where('service.service_name like "' . $keyword . '%" or service.servicename like "' . $keyword . '%"')->count();
    	} else {
    		//$count = $service->where(array('service_name' => array('like',$keyword .'%' )) or array('name' => array('like',$keyword .'%' )))->group('service_id')->count();
            $count = $service->count();
    	}
        
    	
    	$page = new \Lib\MyPage($count,5);

    	//$page->parameter=I('get.');
    	//$page->setConfig('header','条数据');
    	
 		

    	$show = $page->show();
    	
    	if($condition != '') {
            $list = $service->where($condition)->order('service_id')->limit($page->firstRow . ',' . $page->listRows)->select();
            
            
        }else{
             $list = $service->order('service_id')->limit($page->firstRow . ',' . $page->listRows)->select();
           
            
        }
        
      

    	//$list = $service->where('service_name like "' . $keyword . '%" or servicename like "' . $keyword . '%"')->order('service_id')->limit($page->firstRow . ',' . $page->listRows)->select();
    	
        // dump($list);die;
    	$this->assign('servicelist',$list);
    	$this->assign('page',$show);
    	$this->assign('keyword',$keyword);
    
        //print_r($list);die;
    	$this->assign('level1',$this->level1);
    	$this->assign('level2',$this->level2);
    	$this->assign('level3',$this->level3);
      	$this->display();
    }


    public function addService() {
        $this->level2 = '服务列表';
        $this->level3 = '添加服务';



        $this->assign('active',$this->active);

        $rule = array(
                array('service_name', 'require','服务名必须！'),
                array('service_name', '2,20','服务名为2-20个字符！',0,'length'),
                array('service_name', 'require','服务名重复！',0,'unique',1),
                array('service_home', 'require','服务安装目录必须！'),
                array('service_conf', 'require','服务配置文件必须！'),
                array('service_port', 'require','服务端口必须！'),
                array('service_port', 'number','服务端口非法！'),
                array('status', 'require','服务状态非法！',1),
                array('service_log', 'require','服务日志必须'),
                array('service_version', 'require','服务版本必须')
            );

        $log = array(
                    'login_user_id' => session('uid'),
                    'source_ip' => session('login_ip'),
                    'oper_time' => time()
                    
                );

        if(IS_POST) {
            $service_data = array(
                    'service_name' => I('service_name'),
                    'service_home' => I('service_home'),
                    'service_conf' => I('service_conf'),
                    'service_port' => I('service_port'),
                    'service_log' => I('service_log'),
                    'service_version' => I('service_version'),
                    'service_desc' => I('service_desc'),
                    'status' => I('status')
                );
            $service = M('service');

            if($service->validate($rule)->create()) {
                $service->startTrans();
                if($service_id = $service->add($service_data)) {
                    $log['oper'] =  $service_data['service_name'] . '服务添加成功';
                    M('oper_log')->add($log);
                    $service->commit();
                    $this->success('服务添加成功！',U('Admin/Service/lists'));
                    exit;
                }else {
                    $service->rollback();
                    $log['oper'] =  $service_data['service_name'] . '服务添加失败';
                    M('oper_log')->add($log);
                    $this->error('服务添加失败！',U('Admin/Service/addService'));
                    exit;
                }

            } else {
                $log['oper'] =  $service_data['service_name'] . '服务添加失败';
                M('oper_log')->add($log);
                $this->error($service->getError(),U('Admin/Service/addService'));
                exit;
            }
        }

        $this->assign('level1',$this->level1);
        $this->assign('level2',$this->level2);
        $this->assign('level3',$this->level3);
        $this->display();

    }


    public function editService() {
        $this->level2 = '服务列表';
        $this->level3 = '编辑服务';


        $this->assign('active',$this->active);


        $log = array(
                    'login_user_id' => session('uid'),
                    'source_ip' => session('login_ip'),
                    'oper_time' => time()
                    
                );

        $rule = array(
                array('service_home', 'require','服务安装目录必须！'),
                array('service_conf', 'require','服务配置文件必须！'),
                array('service_port', 'require','服务端口必须！'),
                array('service_port', 'number','服务端口非法！'),
                array('status', 'require','服务状态非法！',1),
                array('service_log', 'require','服务日志必须'),
                array('service_version', 'require','服务版本必须')
            );

        if(IS_POST) {
            
            $service_data = array(
                'service_name' => I('service_name'),
                'service_id' => I('service_id'),
                'service_home' => I('service_home'),
                'service_conf' => I('service_conf'),
                'service_port' => I('service_port'),
                'service_log' => I('service_log'),
                'service_version' => I('service_version'),
                'service_desc' => I('service_desc'),
                'status' => I('status')
                );
            
            
            $service = M('service');
            if($service->validate($rule)->create()) {
                $service->startTrans();
               
                if($service->save($service_data) !== false) {
                   
                    $log['oper'] =  $service_data['service_name'] . '服务修改成功';
                    M('oper_log')->add($log);
                    $service->commit();
                    $this->success('服务修改成功！',U('Admin/Service/lists'));
                    exit;
                    
                }else {
                    $service->rollback();
                    $log['oper'] =  $service_data['service_name'] . '服务修改失败';
                    M('oper_log')->add($log);
                    $this->error('服务修改失败！',U('Admin/Service/editService',array('service_id' => $service_data['service_id'])));
                    exit;
                }

            } else {
                $log['oper'] =  $service_data['service_name'] . '服务修改失败';
                M('oper_log')->add($log);
                $this->error($service->getError(),U('Admin/Service/editService',array('service_id' => $service_data['service_id'])));
                exit;
            }

        }

        $this->service = M('service')->where(array('service_id' => I('service_id')))->find();


        
        $this->user = M('user')->field('user_id,name')->select();
        $this->assign('level1',$this->level1);
        $this->assign('level2',$this->level2);
        $this->assign('level3',$this->level3);
        $this->display();

    }


    public function delService() {
        $this->level2 = '服务列表';
        $this->level3 = '删除服务';


        $this->assign('active',$this->active);

        $service_id = I('service_id');

        $log = array(
                    'login_service_id' => session('uid'),
                    'source_ip' => session('login_ip'),
                    'oper_time' => time()
                    
                );

        if($service_id != null) {
            $service = M('service');
            $service_data = $service->field('service_name')->where(array('service_id' => $service_id))->find();
            $service_default_id = $service->where(array('service_name' => '无服务'))->getField('service_id');
            $service_host = M('service_host');
            $service_host->service_id = $service_default_id;
            $system = M('system');
            $system->depend_service_id = $service_default_id;
            $service->startTrans();
            if($system->where(array('depend_service_id'))->save() !== false) {
                if($service_host->where(array('service_id' => $service_id))->save() !== false) {
                    if($service->where(array('service_id' => $service_id))->delete() !==false) {
                        $log['oper'] =  $service_data['service_name'] . '服务删除成功';
                        M('oper_log')->add($log);
                        $service->commit();
                        $this->success('服务删除成功！',U('Admin/Service/lists'));
                        exit;
                    }else{
                        $service->rollback();
                        $log['oper'] =  $service_data['service_name'] . '服务删除失败';
                        M('oper_log')->add($log);
                        $this->error('服务删除失败！',U('Admin/Service/lists'));
                        exit;
                    }
                }else{
                    $service->rollback();
                    $log['oper'] =  $service_data['service_name'] . '服务删除失败，相关主机关联服务重置失败';
                    M('oper_log')->add($log);
                    $this->error('服务删除失败，相关主机关联服务重置失败',U('Admin/Service/lists'));
                    exit;
                }
            }else{
                $service->rollback();
                $log['oper'] =  $service_data['service_name'] . '服务删除失败，相关系统关联服务重置失败';
                M('oper_log')->add($log);
                $this->error('服务删除失败，相关系统关联服务重置失败',U('Admin/Service/lists'));
                exit;
            }
            
        }else{
             $this->error('没有选择要删除的服务',U('Admin/Service/lists'));
        }
    }

    public function delServices() {
        $this->level2 = '服务列表';
        $this->level3 = '删除服务';

        $active = 'service';

        $this->assign('active',$this->active);

         $log = array(
                    'login_service_id' => session('uid'),
                    'source_ip' => session('login_ip'),
                    'oper_time' => time()
                    
                );
        

        if(IS_POST) {
            $service_ids = I('checked');

            if(!empty($service_ids)) {
                $service = M('service');
                $service_default_id = $service->where(array('service_name' => '无服务'))->getField('service_id');
                $service_host = M('service_host');
                $service_host->service_id = $service_default_id;
                $system = M('system');
                $system->depend_service_id = $service_default_id;
                $service->startTrans();
                foreach ($service_ids as $v) {
                    $service_data = $service->field('service_name')->where(array('service_id' => $v))->find();
                    if($system->where(array('depend_service_id' => $v))->save() !== false) {
                        if($service_host->where(array('service_id' => $v))->save() !== false) {
                            if($service->where(array('service_id' => $v))->delete() === false) {
                                $service->rollback();
                                $log['oper'] =  $service_data['service_name'] . '服务删除失败';
                                M('oper_log')->add($log);
                                $this->error('服务删除失败！',U('Admin/Service/lists'));
                                exit;
                            }
                            $log['oper'] =  $service_data['service_name'] . '服务删除成功';
                            M('oper_log')->add($log);
                        }else{
                            $service->rollback();
                            $log['oper'] =  $service_data['service_name'] . '服务删除失败，主机关联服务重置失败';
                            M('oper_log')->add($log);
                            $this->error('服务删除失败，主机关联服务重置失败',U('Admin/Service/lists'));
                            exit;
                        }
                    }else{
                        $service->rollback();
                        $log['oper'] =  $service_data['service_name'] . '服务删除失败，系统关联服务重置失败';
                        M('oper_log')->add($log);
                        $this->error('服务删除失败，系统关联服务重置失败',U('Admin/Service/lists'));
                        exit;
                    }
                    
                }
                $service->commit();
                $this->success('服务删除成功！',U('Admin/Service/lists'));
                exit;
            }else{
                $log['oper'] =  '服务删除失败,没有选择要删除的服务';
                M('oper_log')->add($log);
                $this->error('服务删除失败，没有选择要删除的服务!',U('Admin/Service/lists'));
                exit;
            }
        }else{
            $log['oper'] =  '服务删除失败,非法操作';
            M('oper_log')->add($log);
            $this->error('服务删除失败，非法操作!',U('Admin/Service/lists'));
            exit;
        }
    }


    
}