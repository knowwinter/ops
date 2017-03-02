<?php
namespace Admin\Controller;
use Think\Controller;
class HostController extends CommonController {

	private $level1 = '主机管理';
	private $level2 = '';
	private $level3 = '';
    private $active = 'host';

    public function lists(){


    	$this->level2 = '主机列表';


    	

    	$this->assign('active',$this->active);

    	$host = D('HostRelation');
        $keyword = '';
        $condition = '';
    	if(isset($_GET) && $_GET['keyword'] != '' ) {
            $condition['host_name']=array('like',I('keyword') . '%');
            $condition['host_desc']=array('like',I('keyword') . '%');
            $condition['_logic']='OR';
    		$keyword = I('keyword');
            $count = $host->relation(true)->where($condition)->count();

    		//$count = $host->where('host.host_name like "' . $keyword . '%" or host.hostname like "' . $keyword . '%"')->count();
    	} else {
    		//$count = $host->where(array('host_name' => array('like',$keyword .'%' )) or array('name' => array('like',$keyword .'%' )))->group('host_id')->count();
            $count = $host->relation(true)->count();
    	}
        
    	
    	$page = new \Lib\MyPage($count,5);

    	//$page->parameter=I('get.');
    	//$page->setConfig('header','条数据');
    	
 		

    	$show = $page->show();
    	
    	if($condition != '') {
            $list = $host->relation(true)->where($condition)->order('host_id')->limit($page->firstRow . ',' . $page->listRows)->select();
            
            
        }else{
             $list = $host->relation(true)->order('host_id')->limit($page->firstRow . ',' . $page->listRows)->select();
           
            
        }

        // foreach ($list as $k => $v) {
        //     foreach ($v['service'] as $j => $l) {
        //         $command = '/usr/local/bin/ansible ' . $v['ipaddr'] . ' -m shell -a "/sbin/service ' . $l['service_name'] . ' status"';
        //         $output = array();
        //         exec($command,$output,$ret);
        //         if(strpos($output[1],'is running')) {
        //             $l['status'] = 1;
        //             $v['service'][$j] = $l;
                    
        //         }else{
        //             $l['status'] = 0;
        //             $v['service'][$j] = $l;
                    
        //         }

        //     }
        //     $list[$k] = $v;
            
            
        // }
        // 
        
        foreach ($list as $k => $v) {
            foreach ($v['service'] as $j => $l) {
                $condition['service_id'] = $l['service_id'];
                $condition['host_id'] = $v['host_id'];
                $condition['_logic']='AND';
                $status = M('service_host')->where($condition)->getField('service_status');
                // $command = '/usr/local/bin/ansible ' . $v['ipaddr'] . ' -m shell -a "/sbin/service ' . $l['service_name'] . ' status"';
                // $output = array();
                // exec($command,$output,$ret);
                // if(strpos($output[1],'is running')) {
                //     $l['status'] = 1;
                //     $v['service'][$j] = $l;
                    
                // }else{
                //     $l['status'] = 0;
                //     $v['service'][$j] = $l;
                    
                // }
                $l['status'] = $status;
                $v['service'][$j] = $l;

            }
            $list[$k] = $v;
            
            
        }
       

    	//$list = $host->where('host_name like "' . $keyword . '%" or hostname like "' . $keyword . '%"')->order('host_id')->limit($page->firstRow . ',' . $page->listRows)->select();
    	
        // dump($list);die;
    	$this->assign('hostlist',$list);
    	$this->assign('page',$show);
    	$this->assign('keyword',$keyword);
    
        //print_r($list);die;
    	$this->assign('level1',$this->level1);
    	$this->assign('level2',$this->level2);
    	$this->assign('level3',$this->level3);
      	$this->display();
    }


    public function addHost() {
        $this->level2 = '主机列表';
        $this->level3 = '添加主机';



        $this->assign('active',$this->active);

        $rule = array(
                array('host_name', 'require','主机名必须！'),
                array('host_name', '2,20','主机名为2-20个字符！',0,'length'),
                //array('host_name', 'require','主机名重复！',0,'unique',1),
                array('system_id','chkrole','所属系统选择不正确！',1,'function'),
                array('env_id','0','所属环境未选择！',1,'notequal'),
                array('service_id','chkrole','运行服务选择不正确！',1,'function'),
                array('ipaddr','require','IP地址不能为空！'),
                array('ipaddr','chkip','IP地址非法！',1,'function'),
                array('status', 'require','主机状态必须设置！',1)
            );

        $log = array(
                    'login_user_id' => session('uid'),
                    'source_ip' => session('login_ip'),
                    'oper_time' => time()
                    
                );

        if(IS_POST) {
            $host_data = array(
                    'host_name' => I('host_name'),
                    'host_desc' => I('host_desc'),
                    'ipaddr' => I('ipaddr'),
                    'dns' => I('dns'),
                    'env_id' => I('env_id'),
                    'system_id' => I('system_id'),
                    'status' => I('status')
                );
            $host = M('host');

            if($host->validate($rule)->create()) {
                $service = array();
                $system_host = array();
                $host->startTrans();
                if($host_id = $host->add($host_data)) {
                   foreach ($_POST['service_id'] as $v) {
                        $service[] = array(
                            'service_id' => $v,
                            'host_id' => $host_id
                            );
                    }

                    foreach ($_POST['system_id'] as $v) {
                        $system_host[] = array(
                            'system_id' => $v,
                            'host_id' => $host_id
                            );
                    }

                    if(M('service_host')->addAll($service) && M('system_host')->addAll($system_host)) {
                        $log['oper'] =  $host_data['host_name'] . '主机添加成功';
                        M('oper_log')->add($log);
                        $host->commit();
                        $this->success('主机添加成功！',U('Admin/Host/lists'));
                        exit;
                    }else {
                        $host->rollback();
                        $log['oper'] =  $host_data['login_name'] . '主机添加失败';
                        M('oper_log')->add($log);
                        $this->error('主机添加失败！',U('Admin/Host/addHost'));
                        exit;
                    }
                }else {
                    $host->rollback();
                    $log['oper'] =  $host_data['host_name'] . '主机添加失败2';
                    M('oper_log')->add($log);
                    $this->error('主机添加失败！',U('Admin/Host/addHost'));
                    exit;
                }

            } else {
                $log['oper'] =  $host_data['host_name'] . '主机添加失败';
                M('oper_log')->add($log);
                $this->error($host->getError(),U('Admin/Host/addHost'));
                exit;
            }
        }


        $this->env = M('env')->select();
        $this->system = M('system')->select();
        $this->service = M('service')->select();
        
        

        $this->assign('level1',$this->level1);
        $this->assign('level2',$this->level2);
        $this->assign('level3',$this->level3);
        $this->display();

    }


    public function editHost() {
        $this->level2 = '主机列表';
        $this->level3 = '编辑主机';



        $this->assign('active',$this->active);

         $rule = array(
                array('host_name', 'require','主机名必须！'),
                array('host_name', '2,20','主机名为2-20个字符！',0,'length'),
                array('system_id','0','所属系统未选择！',1,'notequal'),
                array('env_id','0','所属环境未选择！',1,'notequal'),
                array('system_id','chkrole','所属系统选择不正确！',1,'function'),
                array('service_id','chkrole','运行服务选择不正确！',1,'function'),
                array('ipaddr','require','IP地址不能为空！'),
                array('ipaddr','chkip','IP地址非法！',1,'function'),
                array('status', 'require','主机状态必须设置！',1)
            );

        $log = array(
                    'login_user_id' => session('uid'),
                    'source_ip' => session('login_ip'),
                    'oper_time' => time()
                    
                );

        if(IS_POST) {
           
               $host_data = array(
                    'host_id' => I('host_id'),
                    'host_name' => I('host_name'),
                    'host_desc' => I('host_desc'),
                    'ipaddr' => I('ipaddr'),
                    'dns' => I('dns'),
                    'env_id' => I('env_id'),
                    'system_id' => I('system_id'),
                    'status' => I('status')
                );

            if(I('host_name') != I('old_host_name')){
                $rule = array(
                    array('host_name', 'require','主机名必须！'),
                    array('host_name', '2,20','主机名为2-20个字符！',0,'length'),
                    array('host_name', 'require','主机名重复！',0,'unique',2),
                    array('system_id','0','所属系统未选择！',1,'notequal'),
                    array('env_id','0','所属环境未选择！',1,'notequal'),
                    array('service_id','chkrole','运行服务选择不正确！',1,'function'),
                    array('ipaddr','require','IP地址不能为空！'),
                    array('ipaddr','chkip','IP地址非法！',1,'function'),
                    array('status', 'require','主机状态必须设置！',1)
                );
            }
            
            
            $host = M('host');
            if($host->validate($rule)->create()) {
                $host->startTrans();
                $service = array();
                $system_host = array();
                if($host->save($host_data) !== false) {
                   foreach ($_POST['service_id'] as $v) {
                        $service[] = array(
                            'service_id' => $v,
                            'host_id' => $host_data['host_id']
                            );
                    }

                    foreach ($_POST['system_id'] as $v) {
                        $system_host[] = array(
                            'system_id' => $v,
                            'host_id' => $host_data['host_id']
                            );
                    }

                   if(M('service_host')->where(array('host_id' => $host_data['host_id']))->delete() !== false && M('system_host')->where(array('host_id' => $host_data['host_id']))->delete() !== false) {
                        if(M('service_host')->addAll($service) && M('system_host')->addAll($system_host)) {
                            $log['oper'] =  $host_data['host_name'] . '主机修改成功';
                            M('oper_log')->add($log);
                            $host->commit();
                            $this->success('主机修改成功！',U('Admin/Host/lists'));
                            exit;
                        }else {
                            $host->rollback();
                            $log['oper'] =  $host_data['host_name'] . '主机修改失败';
                            M('oper_log')->add($log);
                            $this->error('主机修改失败，服务或所属系统添加失败！',U('Admin/Host/editHost',array('host_id' => $host_data['host_id'])));
                            exit;
                        }  
                   }else{
                        $host->rollback();
                        $log['oper'] =  $host_data['host_name'] . '主机修改失败';
                        M('oper_log')->add($log);
                        $this->error('主机修改失败，原有服务或所属系统清除失败！',U('Admin/Host/editHost',array('host_id' => $host_data['host_id'])));
                        exit;
                   }
                    
                }else {
                    $host->rollback();
                    $log['oper'] =  $host_data['host_name'] . '主机修改失败';
                    M('oper_log')->add($log);
                    $this->error('主机修改保存失败！',U('Admin/Host/editHost',array('host_id' => $host_data['host_id'])));
                    exit;
                }

            } else {
                $log['oper'] =  $host_data['host_name'] . '主机修改失败';
                M('oper_log')->add($log);
                $this->error($host->getError(),U('Admin/Host/editHost',array('host_id' => $host_data['host_id'])));
                exit;
            }
        }

        $this->host = M('host')->where(array('host_id' => I('host_id')))->find();
        $this->service_host = M('service_host')->where(array('host_id' => I('host_id')))->select();
        $this->system_host = M('system_host')->where(array('host_id' => I('host_id')))->select();

        
        $this->env = M('env')->select();
        $this->system = M('system')->select();
        $this->service = M('service')->select();


        $this->assign('level1',$this->level1);
        $this->assign('level2',$this->level2);
        $this->assign('level3',$this->level3);
        $this->display();

    }


    public function delHost() {
        $this->level2 = '主机列表';
        $this->level3 = '删除主机';


        $this->assign('active',$this->active);

        $host_id = I('host_id');

        $log = array(
                    'login_user_id' => session('uid'),
                    'source_ip' => session('login_ip'),
                    'oper_time' => time()
                    
                );

        if($host_id != null) {
            $host = M('host');
            $condition['host_id'] = $host_id;
            $host_data = $host->where($condition)->find();
            $service_host = M('service_host');
            $system_host = M('system_host');
            $host->startTrans();
            if($service_host->where($condition)->delete() !== false && $system_host->where($condition)->delete() !== false) {
                if($host->where($condition)->delete() !== false) {
                    $log['oper'] = $host_data['host_name'] . '-' . $host_data['ipaddr'] . '主机删除成功';
                    M('oper_log')->add($log);
                    $host->commit();
                    $this->success('主机删除成功！',U('Admin/Host/lists'));
                }else{
                    $host->rollback();
                    $log['oper'] = $host_data['host_name'] . '-' . $host_data['ipaddr'] . '主机删除失败';
                    M('oper_log')->add($log);
                    $this->error('主机删除失败！',U('Admin/Host/lists'));
                }
            }else{
                $host->rollback();
                $log['oper'] = $host_data['host_name'] . '-' . $host_data['ipaddr'] . '主机删除失败，关联服务或关联系统清除失败';
                M('oper_log')->add($log);
                $this->error('主机删除失败，关联服务或关联系统清除失败',U('Admin/Host/lists'));
            }
            
        }else{
            $this->error('没有选择要删除的主机！',U('Admin/Host/lists'));
        }
    }

    public function delHosts() {
        $this->level2 = '主机列表';
        $this->level3 = '删除主机';



        $this->assign('active',$this->active);

         $log = array(
                    'login_user_id' => session('uid'),
                    'source_ip' => session('login_ip'),
                    'oper_time' => time()
                    
                );
        

        if(IS_POST) {
            $host_ids = I('checked');

            if(!empty($host_ids)) {
                $host = M('host');
                $service_host = M('service_host');
                $system_host = M('system_host');
                $host->startTrans();
                foreach ($host_ids as $v) {
                    $host_data = $host->where(array('host_id' => $v))->find();

                    if($service_host->where(array('host_id' => $v))->delete() !== false && $system_host->where(array('host_id' => $v))->delete() !== false) {
                        if($host->where(array('host_id' => $v))->delete() !== false) {
                               
                                $log['oper'] =  $host_data['host_name'] . '-' . $host_data['ipaddr'] . '主机删除成功';
                                M('oper_log')->add($log);
                           
                        }else{
                            $host->rollback();
                            $log['oper'] =  $host_data['host_name'] . '-' . $host_data['ipaddr'] . '主机删除失败';
                            M('oper_log')->add($log);
                           
                            $this->error('主机删除失败',U('Admin/Host/lists'));
                            exit;
                        }
                    }else{
                        $host->rollback();
                        $log['oper'] =  $host_data['host_name'] . '-' . $host_data['ipaddr'] . '主机删除失败，关联服务或关联系统清除失败';
                        M('oper_log')->add($log);
                       
                        $this->error('主机删除失败，关联服务清除失败',U('Admin/Host/lists'));
                        exit;
                    }
                    
                }
                $host->commit();
                $this->success('主机删除成功！',U('Admin/Host/lists'));
                exit;
            }else{
                $log['oper'] =  '主机删除失败,没有选择要删除的主机';
                M('oper_log')->add($log);
                $this->error('主机删除失败，没有选择要删除的主机!',U('Admin/Host/lists'));
                exit;
            }
        }else{
            $log['oper'] =  '主机删除失败,非法操作';
            M('oper_log')->add($log);
            $this->error('主机删除失败，非法操作!',U('Admin/Host/lists'));
            exit;
        }
    }

    public function serviceMgr() {
        $log = array(
                    'login_user_id' => session('uid'),
                    'source_ip' => session('login_ip'),
                    'oper_time' => time(),
                    
                );
        $action = I('action');
        $service = I('service');
        $service_home = I('service_home');
        $ip = I('ip');
        $service_id = I('service_id');
        $host_id = I('host_id');
        $user = 'admin';
        $gather = 'false';
        $status = $action == 'stopped' ? 0 : 1;
        $webroot = $_SERVER['DOCUMENT_ROOT'];
        $ansiblePlayBook = exec('/usr/bin/whereis ansible-playbook',$output2,$ret2);
        $ansiblePlayBook = explode(' ',$ansiblePlayBook);
        $ansiblePlayBook = $ansiblePlayBook[1];
        if(strpos($ansiblePlayBook,'ansible-playbook') === false) {
            $log['oper'] = '未找到ansible-playbook，请确认ansible安装是否正确！';
            M('oper_log')->add($log);
           
            
            $host['ret'] = 'ansible-failure';
            $this->ajaxReturn($host);
        }
        $playbook = $webroot . '/playbook/service.yml';
        $command = $ansiblePlayBook . ' ' . $playbook . ' --extra-vars "host=' . $ip . ' user=' . $user . ' gather=' . $gather . ' service=' . $service . ' service_home=' . $service_home . ' action=' . $action . '"';
        exec($command,$output,$ret);
        $res = $output[count($output) - 2];
        if($ret != 0) {
            $msg = '';
            foreach ($output as $v) {
                $msg .= $v . '| |';
            }
            $log['oper'] = '主机-' . $ip . ' 上的服务：' . $service . ' ' . $action . '失败' . ','  . $msg;
            M('oper_log')->add($log);
            $host['ip'] = $ip;
            $host['service'] = $service;
            $host['action'] = $action;
            $host['ret'] = 'failure';
            $host['command'] = $command;
            $this->ajaxReturn($host);

        }else if(strpos($res,'unreachable=0') && strpos($res,'failed=0')){
            $msg = '';
            foreach ($output as $v) {
                $msg .= $v . '| |';
            }
            $log['oper'] = '主机-' . $ip . ' 上的服务：' . $service . ' ' . $action . '成功' . ','  . $msg;
            M('oper_log')->add($log);
            $condition['service_id'] = $service_id;
            $condition['host_id'] = $host_id;
            $condition['_logic']='AND';
            $data['service_status'] = $status;
            M('service_host')->where($condition)->save($data);
            $host['ip'] = $ip;
            $host['service'] = $service;
            $host['action'] = $action;
            $host['ret'] = 'success';
            $host['command'] = $command;
            $this->ajaxReturn($host);
        }else{
            $msg = '';
            foreach ($output as $v) {
                $msg .= $v . '| |';
            }
            $log['oper'] = '主机-' . $ip . ' 上的服务：' . $service . ' ' . $action . '失败' . ','  . $msg;
            M('oper_log')->add($log);
            $host['ip'] = $ip;
            $host['service'] = $service;
            $host['action'] = $action;
            $host['ret'] = 'failure';
            $host['command'] = $command;
            $this->ajaxReturn($host);
        }


    }

    
}
