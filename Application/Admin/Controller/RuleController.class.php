<?php
namespace Admin\Controller;
use Think\Controller;
class RuleController extends CommonController {

	private $level1 = '项目管理';
	private $level2 = '';
	private $level3 = '';
    private $active = 'project';

    public function lists(){


    	$this->level2 = '规则列表';


    	

    	$this->assign('active',$this->active);

    	$rule = M('deploy_rule');
        $user = D('UserRelation');
        $keyword = '';
        $condition = '';
    	if(I('keyword') != '') {
            $condition['rule_name']=array('like',I('keyword') . '%');
            $condition['rule_desc']=array('like',I('keyword') . '%');
            $condition['_logic']='OR';
    		$keyword = I('keyword');
            $count = $rule->where($condition)->count();

    		//$count = $rule->where('rule.rule_name like "' . $keyword . '%" or rule.rulename like "' . $keyword . '%"')->count();
    	} else {
    		//$count = $rule->where(array('rule_name' => array('like',$keyword .'%' )) or array('name' => array('like',$keyword .'%' )))->group('rule_id')->count();
            $count = $rule->count();
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
            $list = $rule->where($condition)->order('rule_id')->limit($page->firstRow . ',' . $page->listRows)->select();
            
            
        }else{
             $list = $rule->order('rule_id')->limit($page->firstRow . ',' . $page->listRows)->select();
           
            
        }
        
      

    	//$list = $rule->where('rule_name like "' . $keyword . '%" or rulename like "' . $keyword . '%"')->order('rule_id')->limit($page->firstRow . ',' . $page->listRows)->select();
    	
        // dump($list);die;
    	$this->assign('rulelist',$list);
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


    public function addRule() {
        $this->level2 = '规则列表';
        $this->level3 = '添加规则';



        $this->assign('active',$this->active);

        $rule = array(
                array('rule_name', 'require','规则名必须！'),
                array('rule_name', '2,20','规则名为2-20个字符！',0,'length'),
                array('rule_name', 'require','规则名重复！',0,'unique',1),
            );

        $log = array(
                    'login_user_id' => session('uid'),
                    'source_ip' => session('login_ip'),
                    'oper_time' => time()
                    
                );

        if(IS_POST) {
            $rule_data = array(
                    'rule_name' => I('rule_name'),
                    'rule_desc' => I('rule_desc')
                );
            $deploy_rule = M('deploy_rule');

            if($deploy_rule->validate($rule)->create()) {

                $deploy_rule->startTrans();

                if($rule_id = $deploy_rule->add($rule_data)) {
                    $log['oper'] =  $rule_data['rule_name'] . '规则添加成功';
                    M('oper_log')->add($log);
                    $deploy_rule->commit();
                    $this->success('规则添加成功！',U('Admin/Rule/lists'));
                    exit;
                }else {
                    $deploy_rule->rollback();
                    $log['oper'] =  $rule_data['rule_name'] . '规则添加失败';
                    M('oper_log')->add($log);
                    $this->error('规则添加失败！',U('Admin/Rule/addRule'));
                    exit;
                }

            } else {
                $log['oper'] =  $rule_data['rule_name'] . '规则添加失败';
                M('oper_log')->add($log);
                $this->error($rule->getError(),U('Admin/Rule/addRule'));
                exit;
            }
        }



        $this->assign('level1',$this->level1);
        $this->assign('level2',$this->level2);
        $this->assign('level3',$this->level3);
        $this->display();

    }


    public function editRule() {
        $this->level2 = '规则列表';
        $this->level3 = '编辑规则';


        $this->assign('active',$this->active);

       


        $log = array(
                    'login_user_id' => session('uid'),
                    'source_ip' => session('login_ip'),
                    'oper_time' => time()
                    
                );

        if(IS_POST) {
            
            $rule_data = array(
                'rule_id' => I('rule_id'),
                'rule_name' => I('rule_name'),
                'rule_desc' => I('rule_desc')
            );
            
            
            $deploy_rule = M('deploy_rule');
            
                $deploy_rule->startTrans();
               
                if($deploy_rule->save($rule_data) !== false) {
                   
                    $log['oper'] =  $rule_data['rule_name'] . '规则修改成功';
                    M('oper_log')->add($log);
                    $deploy_rule->commit();
                    $this->success('规则修改成功！',U('Admin/Rule/lists'));
                    exit;
                    
                }else {
                    $deploy_rule->rollback();
                    $log['oper'] =  $rule_data['rule_name'] . '规则修改失败';
                    M('oper_log')->add($log);
                    $this->error('规则修改失败！',U('Admin/Rule/editRule',array('rule_id' => $rule_data['rule_id'])));
                    exit;
                }

        }

        $this->rule = M('deploy_rule')->where(array('rule_id' => I('rule_id')))->find();


        
        
        $this->assign('level1',$this->level1);
        $this->assign('level2',$this->level2);
        $this->assign('level3',$this->level3);
        $this->display();

    }


    public function delRule() {
        $this->level2 = '规则列表';
        $this->level3 = '删除规则';


        $this->assign('active',$this->active);

        $rule_id = I('rule_id');

        $log = array(
                    'login_rule_id' => session('uid'),
                    'source_ip' => session('login_ip'),
                    'oper_time' => time()
                    
                );

        if($rule_id != null) {
            $rule = M('deploy_rule');
            $rule_data = $rule->field('rule_name')->where(array('rule_id' => $rule_id))->find();
            $system = M('system');
            $default_rule_id = $rule->where(array('rule_name' => '无规则'))->getField('rule_id');
            $system->deploy_rule_id = $default_rule_id;
            $rule->startTrans();
            if($system->where(array('rule_id' => $rule_id))->save() !== false) {
                if($rule->where(array('rule_id' => $rule_id))->delete() !==false) {
                    $log['oper'] =  $rule_data['rule_name'] . '规则删除成功';
                    M('oper_log')->add($log);
                    $rule->commit();
                    $this->success('规则删除成功！',U('Admin/Rule/lists'));
                    exit;
                }else{
                    $rule->rollback();
                    $log['oper'] =  $rule_data['rule_name'] . '规则删除失败';
                    M('oper_log')->add($log);
                    $this->error('规则删除失败！',U('Admin/Rule/lists'));
                    exit;
                }
            }else{
                $rule->rollback();
                $log['oper'] =  $rule_data['rule_name'] . '规则删除失败，相关系统规则重置失败';
                M('oper_log')->add($log);
                $this->error('规则删除失败，相关系统规则重置失败',U('Admin/Rule/lists'));
                exit;
            }
        }else{
            $this->error('没有选择要删除的规则！',U('Admin/Rule/lists'));
        }
    }

    public function delRules() {
        $this->level2 = '规则列表';
        $this->level3 = '删除规则';

        $active = 'rule';

        $this->assign('active',$this->active);

         $log = array(
                    'login_rule_id' => session('uid'),
                    'source_ip' => session('login_ip'),
                    'oper_time' => time()
                    
                );
        

        if(IS_POST) {
            $rule_ids = I('checked');

            if(!empty($rule_ids)) {
                $rule = M('deploy_rule');
                 $system = M('system');
                 $default_rule_id = $rule->where(array('rule_name' => '无规则'))->getField('rule_id');
                
                $rule->startTrans();
                foreach ($rule_ids as $v) {
                    $rule_data = $rule->field('rule_name')->where(array('rule_id' => $v))->find();
                     $system->deploy_rule_id = $default_rule_id;
                    if($system->where(array('rule_id' => $v))->save() !== false) {
                        if($rule->where(array('rule_id' => $v))->delete() === false) {
                            $rule->rollback();
                            $log['oper'] =  $rule_data['rule_name'] . '规则删除失败';
                            M('oper_log')->add($log);
                            $this->error('规则删除失败！',U('Admin/Rule/lists'));
                            exit;
                        }
                        $log['oper'] =  $rule_data['rule_name'] . '规则删除成功';
                        M('oper_log')->add($log);
                    }else{
                        $rule->rollback();
                        $log['oper'] =  $rule_data['rule_name'] . '规则删除失败,相关系统规则重置失败';
                        M('oper_log')->add($log);
                        $this->error('规则删除失败，相关系统规则重置失败',U('Admin/Rule/lists'));
                        exit;
                    }
                }
                $rule->commit();
                $this->success('规则删除成功！',U('Admin/Rule/lists'));
                exit;
            }else{
                $log['oper'] =  '规则删除失败,没有选择要删除的规则';
                M('oper_log')->add($log);
                $this->error('规则删除失败，没有选择要删除的规则!',U('Admin/Rule/lists'));
                exit;
            }
        }else{
            $log['oper'] =  '规则删除失败,非法操作';
            M('oper_log')->add($log);
            $this->error('规则删除失败，非法操作!',U('Admin/Rule/lists'));
            exit;
        }
    }


    
}