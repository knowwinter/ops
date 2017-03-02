<?php
namespace Admin\Controller;
use Think\Controller;
class NodeController extends CommonController {

	private $level1 = '用户管理';
	private $level2 = '';
	private $level3 = '';

    public function lists(){
    	
        $this->level2 = '节点列表';

    	$active = 'user';

    	$this->assign('active',$active);

    	$node = M('node')->order('sort')->select();

        $this->node = node_merge($node);
    
    	$this->assign('level1',$this->level1);
    	$this->assign('level2',$this->level2);
    	$this->assign('level3',$this->level3);
      	$this->display();
    }


     public function addNode(){
       $this->level2 = '节点列表';

       

       $this->assign('level1',$this->level1);
        $this->assign('level2',$this->level2);
        


        $active = 'user';

        $this->assign('active',$active);

       

        $this->pid = I('pid', 0, intval);
        $this->level = I('level', 1, intval);

        switch ($this->level) {
            case '1':
                $this->type = '应用';
                break;
            case '2':
                $this->type = '控制器';
                break;
            case '3':
                $this->type = '方法';
                break;
        }

        $this->level3 = '添加' .  $this->type;
        $this->assign('level3',$this->level3);

         $rule = array(
                array('name', 'require',$this->type . '名必须！'),
                array('title', 'require',$this->type . '描述必须！'),
                array('title', 'require',$this->type . '描述重复！',0,'unique',1),
                array('status', 'require','开启状态必须设置！',1)
            );

         $log = array(
                    'login_user_id' => session('uid'),
                    'source_ip' => session('login_ip'),
                    'oper_time' => time()
                    
                );

        if(IS_POST) {
            $node = M('node');


            if(!$node->validate($rule)->create()) {
             
                
                $this->error($node->getError(),U('Admin/Node/addNode'));
                exit;
                
            } else {

                if($node->add()) {
                    $log['oper'] = I('name') . '添加成功';
                    M('oper_log')->add($log);
                    $this->success($this->type . '添加成功！',U('Admin/Node/lists'));
                    exit;
                } else {
                    $log['oper'] = I('name')  . '添加失败';
                    M('oper_log')->add($log);
                    $this->error($node->getError(),U('Admin/Node/addNode'));
                    exit;
                }
            }

        }
        
        $this->display();
    }


    

    public function editNode(){
       $this->level2 = '节点列表';

       

       $this->assign('level1',$this->level1);
        $this->assign('level2',$this->level2);
       


        $active = 'user';

        $this->assign('active',$active);

       


        if(IS_GET) {
            $node = M('node')->where('id = ' . I('id'))->find();

            $this->assign('node',$node);

            $this->pid = $this->node['pid'];
            
            $this->level = $this->node['level'];

            switch ($this->level) {
                case '1':
                    $this->type = '应用';
                    break;
                case '2':
                    $this->type = '控制器';
                    break;
                case '3':
                    $this->type = '方法';
                    break;
            }
        }

        $this->level3 = '编辑' . $this->type;
         $this->assign('level3',$this->level3);

           $rule = array(
                array('name', 'require',$this->type . '名必须！'),
                array('title', 'require',$this->type . '描述必须！'),
                array('title', 'require',$this->type . '描述重复！',0,'unique',2),
                array('status', 'require','开启状态必须设置！',1)
            );


           $log = array(
                    'login_user_id' => session('uid'),
                    'source_ip' => session('login_ip'),
                    'oper_time' => time()
                    
                );

        if(IS_POST) {
            $node = M('node');


            if(!$node->validate($rule)->create()) {
                
                
                $this->error($node->getError(),U('Admin/Node/editNode'));
                exit;
                
            } else {

                if($node->save() !== false) {
                    $log['oper'] = $this->type . I('name')  . '修改成功';
                    M('oper_log')->add($log);
                    $this->success($this->type . '修改成功！',U('Admin/Node/lists'));
                    exit;
                } else {
                    $log['oper'] = $this->type .  I('name')  . '修改失败';
                    M('oper_log')->add($log);
                    $this->error($node->getError(),U('Admin/Node/editNode'));
                    exit;
                }
            }

        }
        
        $this->display();
    }


    public function delNode() {

        if(IS_GET) {
            $node = M('node')->where('id = ' . I('id'))->find();

            $this->assign('node',$node);

            $this->pid = $this->node['pid'];
            
            $this->level = $this->node['level'];

            switch ($this->level) {
                case '1':
                    $this->type = '应用';
                    break;
                case '2':
                    $this->type = '控制器';
                    break;
                case '3':
                    $this->type = '方法';
                    break;
            }
        }

         $log = array(
                    'login_user_id' => session('uid'),
                    'source_ip' => session('login_ip'),
                    'oper_time' => time()
                    
                );

        

        if(($id = I('id')) !=null) {
            $node = M('node');
            $access = M('access');
            $node->startTrans();
            $node_name = $node->field('name')->where(array('id' => $id))->find();

           if($this->del($id,$node,$access)) {
               
                $node->commit();
                $this->success($this->type . '删除成功！',U('Admin/Node/lists'));
                exit;
           }else{
                $node->rollback();
                $log['oper'] =  $node_name['name'] . '删除失败';
                M('oper_log')->add($log);
                $this->error($this->type . '删除失败！',U('Admin/Node/lists'));
                exit;
           }
        }
    }

    private function del($id,$node,$access) {
       
        $log = array(
                    'login_user_id' => session('uid'),
                    'source_ip' => session('login_ip'),
                    'oper_time' => time()
                    
                );

        $node_name = $node->field('name')->where(array('id' => $id))->find();

        $children = $node->field('id')->where(array('pid' => $id))->select();
        if(empty($children)) {
            if($node->where(array('id' => $id))->delete() === false ) {
                
                return false;
            }

            if($access->where(array('node_id' => $id))->delete() === false) {
               
                return false;
            }
            $log['oper'] =  $node_name['name'] . '删除成功';
            M('oper_log')->add($log);
        }else{
            foreach ($children as $v) {
                $this->del($v['id'],$node,$access);
            }

            if($node->where(array('id' => $id))->delete() === false) {
                return false;
            }

            if($access->where(array('node_id' => $id))->delete() === false) {
                return false;
            }

            $log['oper'] =  $node_name['name'] . '删除成功';
            M('oper_log')->add($log);
        }

        return true;
    }

    
}