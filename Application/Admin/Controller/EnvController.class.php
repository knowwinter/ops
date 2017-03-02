<?php
namespace Admin\Controller;
use Think\Controller;
class EnvController extends CommonController {

	private $level1 = '主机管理';
	private $level2 = '';
	private $level3 = '';
    private $active = 'host';

    public function lists(){


    	$this->level2 = '环境配置';


    	

    	$this->assign('active',$this->active);

    	$env = M('env');
        $keyword = '';
        $condition = '';
    	if(isset($_GET) && $_GET['keyword'] != '' ) {
            $condition['env_name']=array('like',I('keyword') . '%');
            $condition['env_desc']=array('like',I('keyword') . '%');
            $condition['_logic']='OR';
    		$keyword = I('keyword');
            $count = $env->where($condition)->count();

    		//$count = $env->where('env.env_name like "' . $keyword . '%" or env.envname like "' . $keyword . '%"')->count();
    	} else {
    		//$count = $env->where(array('env_name' => array('like',$keyword .'%' )) or array('name' => array('like',$keyword .'%' )))->group('env_id')->count();
            $count = $env->count();
    	}
        
    	
    	$page = new \Lib\MyPage($count,5);

    	//$page->parameter=I('get.');
    	//$page->setConfig('header','条数据');
    	
 		

    	$show = $page->show();
    	
    	if($condition != '') {
            $list = $env->where($condition)->order('env_id')->limit($page->firstRow . ',' . $page->listRows)->select();
            
            
        }else{
             $list = $env->order('env_id')->limit($page->firstRow . ',' . $page->listRows)->select();
           
            
        }
        
      

    	//$list = $env->where('env_name like "' . $keyword . '%" or envname like "' . $keyword . '%"')->order('env_id')->limit($page->firstRow . ',' . $page->listRows)->select();
    	
        // dump($list);die;
    	$this->assign('envlist',$list);
    	$this->assign('page',$show);
    	$this->assign('keyword',$keyword);
    
        //print_r($list);die;
    	$this->assign('level1',$this->level1);
    	$this->assign('level2',$this->level2);
    	$this->assign('level3',$this->level3);
      	$this->display();
    }


    public function addEnv() {
        $this->level2 = '环境配置';
        $this->level3 = '添加环境';



        $this->assign('active',$this->active);

        $rule = array(
                array('env_name', 'require','环境名必须！'),
                array('env_name', '2,20','环境名为2-20个字符！',0,'length'),
                array('env_name', 'require','环境名重复！',0,'unique',1)
            );

        $log = array(
                    'login_user_id' => session('uid'),
                    'source_ip' => session('login_ip'),
                    'oper_time' => time()
                    
                );

        if(IS_POST) {
            $env_data = array(
                    'env_name' => I('env_name'),
                    'env_desc' => I('env_desc')
                );
            $env = M('env');

            if($env->validate($rule)->create()) {
                $env->startTrans();
                if($env_id = $env->add($env_data)) {
                    $log['oper'] =  $env_data['env_name'] . '环境添加成功';
                    M('oper_log')->add($log);
                    $env->commit();
                    $this->success('环境添加成功！',U('Admin/Env/lists'));
                    exit;
                }else {
                    $env->rollback();
                    $log['oper'] =  $env_data['env_name'] . '环境添加失败';
                    M('oper_log')->add($log);
                    $this->error('环境添加失败！',U('Admin/Env/addEnv'));
                    exit;
                }

            } else {
                $log['oper'] =  $env_data['env_name'] . '环境添加失败';
                M('oper_log')->add($log);
                $this->error($env->getError(),U('Admin/Env/addEnv'));
                exit;
            }
        }

        $this->assign('level1',$this->level1);
        $this->assign('level2',$this->level2);
        $this->assign('level3',$this->level3);
        $this->display();

    }


    public function editEnv() {
        $this->level2 = '环境列表';
        $this->level3 = '编辑环境';


        $this->assign('active',$this->active);


        $log = array(
                    'login_user_id' => session('uid'),
                    'source_ip' => session('login_ip'),
                    'oper_time' => time()
                    
                );

        if(IS_POST) {
            
            $env_data = array(
                'env_id' => I('env_id'),
                'env_name' => I('env_name'),
                'env_desc' => I('env_desc')
                );
            
            
            $env = M('env');
           
                $env->startTrans();
               
                if($env->save($env_data) !== false) {
                   
                    $log['oper'] =  $env_data['env_name'] . '环境修改成功';
                    M('oper_log')->add($log);
                    $env->commit();
                    $this->success('环境修改成功！',U('Admin/Env/lists'));
                    exit;
                    
                }else {
                    $env->rollback();
                    $log['oper'] =  $env_data['env_name'] . '环境修改失败';
                    M('oper_log')->add($log);
                    $this->error('环境修改失败！',U('Admin/Env/editEnv',array('env_id' => $env_data['env_id'])));
                    exit;
                }

        }

        $this->env = M('env')->where(array('env_id' => I('env_id')))->find();


        
        $this->user = M('user')->field('user_id,name')->select();
        $this->assign('level1',$this->level1);
        $this->assign('level2',$this->level2);
        $this->assign('level3',$this->level3);
        $this->display();

    }


    public function delEnv() {
        $this->level2 = '环境列表';
        $this->level3 = '删除环境';


        $this->assign('active',$this->active);

        $env_id = I('env_id');

        $log = array(
                    'login_env_id' => session('uid'),
                    'source_ip' => session('login_ip'),
                    'oper_time' => time()
                    
                );

        if($env_id != null) {
            $env = M('env');
            $env_data = $env->field('env_name')->where(array('env_id' => $env_id))->find();
            $host = M('host');
            $env->startTrans();
            if($host->where(array('env_id' => $env_id))->delete() !== false) {
                if($env->where(array('env_id' => $env_id))->delete() !==false) {
                    $log['oper'] =  $env_data['env_name'] . '环境删除成功';
                    M('oper_log')->add($log);
                    $env->commit();
                    $this->success('环境删除成功！',U('Admin/Env/lists'));
                    exit;
                }else{
                    $env->rollback();
                    $log['oper'] =  $env_data['env_name'] . '环境删除失败';
                    M('oper_log')->add($log);
                    $this->error('环境删除失败！',U('Admin/Env/lists'));
                    exit;
                }
            }else{
                $env->rollback();
                $log['oper'] =  $env_data['env_name'] . '环境删除失败,主机清除失败';
                M('oper_log')->add($log);
                $this->error('环境删除失败，主机清除失败！',U('Admin/Env/lists'));
                exit;
            }
        }else{
            $this->error('没有选择要删除的环境！',U('Admin/Env/lists'));
        }
    }

    public function delEnvs() {
        $this->level2 = '环境列表';
        $this->level3 = '删除环境';

        $active = 'env';

        $this->assign('active',$this->active);

         $log = array(
                    'login_env_id' => session('uid'),
                    'source_ip' => session('login_ip'),
                    'oper_time' => time()
                    
                );
        

        if(IS_POST) {
            $env_ids = I('checked');

            if(!empty($env_ids)) {
                $env = M('env');
                $host = M('host');
                $env->startTrans();
                foreach ($env_ids as $v) {
                    $env_data = $env->field('env_name')->where(array('env_id' => $v))->find();

                    if($host->where(array('env_id' => $v))->delete() !== false) {
                        if($env->where(array('env_id' => $v))->delete() === false) {
                            $env->rollback();
                            $log['oper'] =  $env_data['env_name'] . '环境删除失败';
                            M('oper_log')->add($log);
                            $this->error('环境删除失败！',U('Admin/Env/lists'));
                            exit;
                        }
                        $log['oper'] =  $env_data['env_name'] . '环境删除成功';
                        M('oper_log')->add($log);
                    }else{
                        $env->rollback();
                        $log['oper'] =  $env_data['env_name'] . '环境删除失败,主机清除失败';
                        M('oper_log')->add($log);
                        $this->error('环境删除失败，主机清除失败！',U('Admin/Env/lists'));
                        exit;
                    }
                }
                $env->commit();
                $this->success('环境删除成功！',U('Admin/Env/lists'));
                exit;
            }else{
                $log['oper'] =  '环境删除失败,没有选择要删除的环境';
                M('oper_log')->add($log);
                $this->error('环境删除失败，没有选择要删除的环境!',U('Admin/Env/lists'));
                exit;
            }
        }else{
            $log['oper'] =  '环境删除失败,非法操作';
            M('oper_log')->add($log);
            $this->error('环境删除失败，非法操作!',U('Admin/Env/lists'));
            exit;
        }
    }


    
}