<?php
namespace Admin\Controller;
use Think\Controller;
class OperLogController extends CommonController {

	private $level1 = '日志审计';
	private $level2 = '';
	private $level3 = '';
    //private $active = 'host';

    public function lists(){


    	//$this->level2 = '环境配置';


    	

    	//$this->assign('active',$this->active);

    	$log = D('OperLogView');
        $keyword = '';
        $condition = '';
    	if(isset($_GET) && $_GET['keyword'] != '' ) {
            $condition['name']=array('like',I('keyword') . '%');
            $condition['source_ip']=array('like',I('keyword') . '%');
            $condition['_logic']='OR';
    		$keyword = I('keyword');
            $count = $log->where($condition)->count();

    		//$count = $env->where('env.env_name like "' . $keyword . '%" or env.envname like "' . $keyword . '%"')->count();
    	} else {
    		//$count = $env->where(array('env_name' => array('like',$keyword .'%' )) or array('name' => array('like',$keyword .'%' )))->group('env_id')->count();
            $count = $log->count();
    	}
        
    	
    	$page = new \Lib\MyPage($count,10);

    	//$page->parameter=I('get.');
    	//$page->setConfig('header','条数据');
    	
 		

    	$show = $page->show();
    	
    	if($condition != '') {
            $list = $log->where($condition)->order('oper_time desc')->limit($page->firstRow . ',' . $page->listRows)->select();
            
            
        }else{
             $list = $log->order('oper_time desc')->limit($page->firstRow . ',' . $page->listRows)->select();
           
            
        }
        
      

    	//$list = $env->where('env_name like "' . $keyword . '%" or envname like "' . $keyword . '%"')->order('env_id')->limit($page->firstRow . ',' . $page->listRows)->select();
    	
        // dump($list);die;
    	$this->assign('loglist',$list);
    	$this->assign('page',$show);
        if($keyword != '') {
            $this->assign('keyword',$keyword);
        }
    	
    
        //print_r($list);die;
    	$this->assign('level1',$this->level1);
    	$this->assign('level2',$this->level2);
    	$this->assign('level3',$this->level3);
      	$this->display();
    }


   


    
}