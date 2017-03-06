<?php
namespace Admin\Controller;
use Think\Controller;
class DeployController extends CommonController {

	private $level1 = '生产系统部署';
	private $level2 = '';
	private $level3 = '';

    public function index(){

        //$this->level2 = '生产系统部署';

         if(!empty($_GET)) {
            
         }else{
            $map['project_name'] = array('NEQ','默认项目');
            $this->project = M('project')->where($map)->select();
           
           
        }
        // if(IS_AJAX) {
        //     print_r($_POST);die;
        // }
        
         // $data = array('3');
         //    $map['host_id'] = array('in',$data);
         //    // $condition['env_name'] = '生产环境';
         //    // $env = M('env')->field('env_id')->where($condition)->find();
         //    $host = D('HostRelation')->relation(true)->where($map)->group('system_id')->select();
         //    $system_id = array();
         //   foreach ($host as $v) {
         //       $system_id[] = $v['system']['system_id'];
         //   }
         //   $condition['system_id'] = array('in',$system_id);
         //   $system = D('SystemRelation')->relation(true)->where($condition)->select();
         //   print_r($system);die;
         //    $this->ajaxReturn($system);
	
	//$svn = I('svn');
        //$system_id = I('system_id');
        //$condition['system_id'] = $system_id;
        //$system_name = M('system')->where($condition)->getField('system_name');

    	$this->assign('level1',$this->level1);
    	$this->assign('level2',$this->level2);
    	$this->assign('level3',$this->level3);
      	$this->display();
    }


     public function system(){

        
        if(IS_AJAX) {
            $data = I('project_ids');
            $map['project_id'] = array('in',$data);
            $condition['env_name'] = '生产环境';
            $env = M('env')->field('env_id')->where($condition)->find();
            $system = D('SystemRelation')->relation(true)->where($map)->select();
            $tmp = array();
            foreach ($system as $k => $v) {
                $host = array();
                foreach ($v['host'] as $j) {
                    if($j['env_id'] == $env['env_id']) {
                        $host[] = $j;
                    }
                }
                $v['host'] = $host;
                $tmp[] = $v;
            }
            $system = $tmp;
            $this->ajaxReturn($system);
        }
        


        // $this->assign('level1',$this->level1);
        // $this->assign('level2',$this->level2);
        // $this->assign('level3',$this->level3);
        // $this->display();
    }

     public function host(){

        
        if(IS_AJAX) {
            $data = I('ids');
            //$data = array_unique($data);

            $system_ids = array();

            foreach ($data as $k => $v) {
                $tmp = explode('_',$v);
                $system_ids[] = $tmp[0];
            }
            $system_ids = array_unique($system_ids);
            // $condition['env_name'] = '生产环境';
            // $env = M('env')->field('env_id')->where($condition)->find();
            //$host = D('HostRelation')->relation(true)->where($map)->group('system_id')->select();
            //$system_id = M('system_host')->where($map)->getField('system_id',true);
           //  $system_id = array();
           // foreach ($host as $v) {
           //     $system_id[] = $v['system']['system_id'];
           // }
           $condition['system_id'] = array('in',$system_ids);
           $system = D('SystemRelation')->relation(true)->where($condition)->select();
           
            $this->ajaxReturn($system);
        }
        


        // $this->assign('level1',$this->level1);
        // $this->assign('level2',$this->level2);
        // $this->assign('level3',$this->level3);
        // $this->display();
    }

     public function summary(){

        
        if(IS_AJAX) {
            $ids = I('ids');
            $system_ids = array();
            $host_ids = array();
            foreach ($ids as $k => $v) {
              $s_h_ids = explode('_',$v);
              $system_ids[] = $s_h_ids[0];
              $host_ids[] = $s_h_ids[1];
            }

            $system_ids = array_unique($system_ids);
            $host_ids = array_unique($host_ids);

            // $data = $host_ids;
            // $map['host_id'] = array('in',$data);
            // $condition['env_name'] = '生产环境';
            // $env = M('env')->field('env_id')->where($condition)->find();
           //  $host = D('HostRelation')->relation(true)->where($map)->group('system_id')->select();
           //  $system_id = array();
           // foreach ($host as $v) {
           //     $system_id[] = $v['system']['system_id'];
           // }
           $condition['system_id'] = array('in',$system_ids);
           $system = D('SystemRelation')->relation(true)->where($condition)->select();
           $tmp = array();
           // foreach ($data as $k) {
           //     foreach ($system as $v) {
           //          $host = array();
           //         foreach ($v['host'] as $j) {
           //             if($j['host_id'] == $k) {
           //                  $host[] = $j;
           //             }
           //         }
           //         $v['host'] = $host;
           //         $tmp[] = $v;
           //     }
           // }
           // 
           
           foreach ($system as $k => $v) {
                $host = array();
                foreach ($v['host'] as $m) {
                   foreach ($host_ids as $j => $l) {
                       if($l == $m['host_id']) {
                            $host[] = $m;
                       }
                   }
                }
            $v['host'] = $host;
            $tmp[] = $v;
           }

           $system = $tmp;

           $svn = I('svn');
           $deployinfo = array();
           $key = array();
           $value = array();
           $i = 1;
           foreach ($svn as $v) {
              if($i%2 != 0) {
                $key[] = $v;
              }else if($i%2 == 0) {
                $value[] = $v;
              }
              $i++;
           }

           foreach ($key as $k => $v) {
                if(substr($value[$k],0,4) == 'http') {
                    $deployinfo[$v]['svn'] = $value[$k];
                }else{
                    $deployinfo[$v]['pkg'] = $value[$k];
                }
               
           }

           $extfile = I('extfile');
           $key = array();
           $value = array();
           $i = 1;
           foreach ($extfile as  $v) {
               if($i%2 != 0) {
                    if(!in_array($v,$key)) {
                        $key[] = $v;
                    }
               }else if($i%2 == 0) {
                    $value[] = $v;
               }
               $i++;
           }

           foreach ($key as $k => $v) {
               if(array_key_exists($v,$deployinfo)) {
                    $deployinfo[$v]['extpath'] = $value[$k*2];
                    $deployinfo[$v]['extfile'] = $value[$k*2 + 1];
               }
           }

           $order = I('order');

           $key = array();
           $value = array();
           $i = 1;
           foreach ($order as $v) {
               if($i%2 != 0) {
                $key[] = $v;
              }else if($i%2 == 0) {
                $value[] = $v;
              }
              $i++;
           }
            foreach ($key as $k => $v) {
               if(array_key_exists($v,$deployinfo)) {
                    $deployinfo[$v]['order'] = $value[$k];
               }
           }

           foreach ($deployinfo as $k => $v) {
               foreach ($system as $j => $l) {
                   if($l['system_id'] == $k) {
                        $system[$j]['deployinfo'] = $v;
                   }
               }
           }

           foreach ($system as $k => $v) {
               $v['order'] = $v['deployinfo']['order'];
               $system[$k] = $v;
           }

           $flag = array();
           foreach ($system as $v) {
               $flag[] = $v['order'];
           }

           array_multisort($flag,SORT_ASC,$system);

            $this->ajaxReturn($system);
            //$this->ajaxReturn($data);
        }
        


        // $this->assign('level1',$this->level1);
        // $this->assign('level2',$this->level2);
        // $this->assign('level3',$this->level3);
        // $this->display();
    }



    public function deploy() {
        $log = array(
                    'login_user_id' => session('uid'),
                    'source_ip' => session('login_ip'),
                    'oper_time' => time(),
                    
                );
        //$system = I('system');
        //$host = I('host');
        //$ip = $host['ipaddr'];
        $condition['system_id'] = I('system_id');
        //$version = M('system')->field('current_version,current_release_time,previous_version,previous_release_time,tmp_version')->where($condition)->find();
        $version['current_version'] = I('current_version');
        $version['current_release_time'] = I('current_release_time');
        $version['previous_version'] = I('previous_version');
        $version['previous_release_time'] = I('previous_release_time');
        $version['tmp_version'] = I('tmp_version');
        $ip = I('ip');
        $user = 'admin';
        $gather = false;
        //$deploy_rule = $system['deploy_rule']['rule_name'];
        $deploy_rule = I('deploy_rule');
        $backuppath = I('backup_path');
        $output = '';
        $res = '';
        $ret = '';
        $webroot = $_SERVER['DOCUMENT_ROOT'];
        $ansiblePlayBook = C('ANSIBLE-PLAYBOOK');
        if(strpos($ansiblePlayBook,'ansible-playbook') != 0) {
            $log['oper'] = '未找到ansible-playbook，请确认ansible安装是否正确！';
            M('oper_log')->add($log);
           
            
            $host['ret'] = 'ansible-failure';
            $this->ajaxReturn($host);
        }        
        /*$ansiblePlayBook = exec('/usr/bin/whereis ansible-playbook',$output2,$ret2);
        $ansiblePlayBook = explode(' ',$ansiblePlayBook);
        $ansiblePlayBook = $ansiblePlayBook[1];
        if(strpos($ansiblePlayBook,'ansible-playbook') === false) {
            $log['oper'] = '未找到ansible-playbook，请确认ansible安装是否正确！';
            M('oper_log')->add($log);
           
            
            $host['ret'] = 'ansible-failure';
            $this->ajaxReturn($host);
        }*/
        if($deploy_rule == 'Java-已打包' || $deploy_rule == 'Java-SVN') {
            $service = I('service');
            $service_home = I('service_home');
            $old_warFile = I('deploy_path') . '/' . I('pkg_name');
            $backup = I('backup_path') . '/' . I('pkg_name') . date('YmdHis');
            $old_path = substr($old_warFile,0,strpos($old_warFile,'.war'));
            $src = I('tmp_pkg');
            $dest = $old_warFile;
            $playbook = $webroot . '/playbook/java-deploy.yml';
            $command = $ansiblePlayBook . ' ' . $playbook . ' --extra-vars "host=' . $ip . ' user=' . $user . ' gather=' . $gather . ' service=' . $service . ' service_home=' . $service_home . ' old_warFile=' . $old_warFile . ' backup=' . $backup . ' backuppath=' . $backuppath . ' old_path=' . $old_path . ' src=' . $src . ' dest=' . $dest . '"';
            
        }else if($deploy_rule == '静态文件-已打包' || $deploy_rule == '静态文件-SVN'){
            $dest = I('deploy_path');
            $tmpzip = explode('/',$dest);

            $backupfile = I('backup_path') . '/' . end($tmpzip) . '_' . date('YmdHis') . '.zip';
            $oldfile = $dest;
            $src = I('tmp_pkg');
            $group = 'admin';
            $owner = 'admin';
            $playbook = $webroot . '/playbook/sf-deploy.yml';
            $command = $ansiblePlayBook . ' ' . $playbook . ' --extra-vars "host=' . $ip . ' user=' . $user . ' gather=' . $gather . ' backupfile=' . $backupfile . ' backuppath=' . $backuppath . ' oldfile=' . $oldfile . ' src=' . $src . ' dest=' . $dest . ' group=' . $group . ' owner=' . $owner . '"';
            
        }else if($deploy_rule == 'PHP-已打包' || $deploy_rule == 'PHP-SVN') {
            $dest = I('deploy_path');
            $tmpzip = explode('/',$dest);
            $backupfile = I('backup_path') . '/' . end($tmpzip) . '_' . date('YmdHis') . '.tar.gz';
            $oldfile = $dest;
            $src = I('tmp_pkg');
            $group = 'www';
            $owner = 'www';
            $exclude = '';
            $system_name = I('system_name');
            if($system_name == 'ecstore') {
                $exclude = '--exclude=' . $dest . '/public/' . ' --exclude=' . $dest . '/data/' . ' --exclude=' . $dest . '/wap_themes/' . ' --exclude=' . $dest . '/themes/';
            }
            
            $playbook = $webroot . '/playbook/php-deploy.yml';
            $command = $ansiblePlayBook . ' ' . $playbook . ' --extra-vars "host=' . $ip . ' user=' . $user . ' gather=' . $gather . ' backupfile=' . $backupfile . ' backuppath=' . $backuppath . ' exclude=' . $exclude . ' oldfile=' . $oldfile . ' src=' . $src . ' dest=' . $dest . ' group=' . $group . ' owner=' . $owner . '"';
            
        }else {
            $this->ajaxReturn(false);
        }

        exec($command,$output,$ret);
        $res = $output[count($output) - 2];

         if($ret != 0) {
            $msg = '';
            foreach ($output as $v) {
                $msg .= $v . '| |';
            }
            $log['oper'] = I('system_name') . '部署失败：' . I('host_name') . '-' . $ip . ','  . $msg;
            M('oper_log')->add($log);
            $host['ip'] = $ip;
            $host['host_name'] = I('host_name');
            $host['ret'] = 'sys-failure';
            $host['command'] = $command;

            
            $this->ajaxReturn($host);

        }else {

            if(strpos($res,'unreachable=0') && strpos($res,'failed=0')) {

                if(I('extfile',0) != '') {
                    $dest = I('extpath');
                    $tmpzip = explode('/',$dest);

                    $backupfile = I('backup_path') . '/' . end($tmpzip) . '_' . date('YmdHis') . '.zip';
                    $oldfile = $dest;
                    $src = I('tmp_ef');
                    $group = 'admin';
                    $owner = 'admin';
                    $playbook = $webroot . '/playbook/ef-deploy.yml';
                    $command = $ansiblePlayBook . ' ' . $playbook . ' --extra-vars "host=' . $ip . ' user=' . $user . ' gather=' . $gather . ' backupfile=' . $backupfile . ' backuppath=' . $backuppath . ' oldfile=' . $oldfile . ' src=' . $src . ' dest=' . $dest . ' group=' . $group . ' owner=' . $owner . '"';
                    $efres = exec($command,$efoutput,$efret);
                    $efres = $efoutput[count($efoutput) - 2];
                    if($efret != 0) {
                        $msg = '';
                        foreach ($efoutput as $v) {
                            $msg .= $v . '| |';
                        }

                        $log['oper'] = I('system_name') . '外部文件部署失败：' . I('host_name') . '-' . $ip . ','  . $msg;
                        M('oper_log')->add($log);
                        $host['ip'] = $ip;
                        $host['host_name'] = I('host_name');
                        $host['ret'] = 'ef-failure';
                        
                        $this->ajaxReturn($host);
                    }else {
                        if(strpos($efres,'unreachable=0') && strpos($efres,'failed=0')) {
                            $msg = '';
                            foreach ($output as $v) {
                                $msg .= $v . '| |';
                            }
                            $release['previous_version'] = $version['current_version'];
                            $release['current_version'] = $version['tmp_version'];
                            $release['previous_release_time'] = $version['current_release_time'];
                            $release['current_release_time'] = time();
                            $version_his['system_id'] = $condition['system_id'];
                            $version_his['version_no'] = $release['current_version'];
                            $version_his['release_time'] = $release['current_release_time'];
                            M('version_his')->add($version_his);
                            M('system')->where($condition)->save($release);
                            $log['oper'] = I('system_name') . '部署成功：' . I('host_name') . '-' . $ip . ','  . $msg;
                            M('oper_log')->add($log);

                            $msg = '';
                            foreach ($efoutput as $v) {
                                $msg .= $v . '| |';
                            }
                            $log['oper'] = I('system_name') . '外部文件部署成功：' . I('host_name') . '-' . $ip . ','  . $msg;
                            M('oper_log')->add($log);
                            $host['ip'] = $ip;
                            $host['host_name'] = I('host_name');
                            $host['ret'] = 'success';
                            $host['mask'] = '3';
                            $this->ajaxReturn($host);
                        }else {
                            $msg = '';
                            foreach ($output as $v) {
                                $msg .= $v . '| |';
                            }
                            $release['previous_version'] = $version['current_version'];
                            $release['current_version'] = $version['tmp_version'];
                            $release['previous_release_time'] = $version['current_release_time'];
                            $release['current_release_time'] = time();
                            $version_his['system_id'] = $condition['system_id'];
                            $version_his['version_no'] = $release['current_version'];
                            $version_his['release_time'] = $release['current_release_time'];
                            M('version_his')->add($version_his);
                            M('system')->where($condition)->save($release);
                            $log['oper'] = I('system_name') . '部署成功：' . I('host_name') . '-' . $ip . ','  . $msg;
                            M('oper_log')->add($log);

                            $msg = '';
                            foreach ($efoutput as $v) {
                                $msg .= $v . '| |';
                            }
                            $log['oper'] = I('system_name') . '外部文件部署失败：' . I('host_name') . '-' . $ip . ','  . $msg;
                            M('oper_log')->add($log);
                             $host['ip'] = $ip;
                            $host['host_name'] = I('host_name');
                            $host['ret'] = 'ef-failure';
                            $host['mask'] = '4';
                            $this->ajaxReturn($host);
                        }
                    }
                }

                $msg = '';
                foreach ($output as $v) {
                    $msg .= $v . '| |';
                }
                $release['previous_version'] = $version['current_version'];
                $release['current_version'] = $version['tmp_version'];
                $release['previous_release_time'] = $version['current_release_time'];
                $release['current_release_time'] = time();
                $version_his['system_id'] = $condition['system_id'];
                $version_his['version_no'] = $release['current_version'];
                $version_his['release_time'] = $release['current_release_time'];
                M('version_his')->add($version_his);
                M('system')->where($condition)->save($release);
                $log['oper'] = I('system_name') . '部署成功：' . I('host_name') . '-' . $ip . ','  . $msg;
                M('oper_log')->add($log);
                $host['ip'] = $ip;
                $host['host_name'] = I('host_name');
                $host['ret'] = 'success';
                $this->ajaxReturn($host);

            }else {
                $msg = '';

                foreach ($output as $v) {
                    $msg .= $v . '| |';
                }

                $log['oper'] = I('system_name') . '部署失败：' . I('host_name') . '-' . $ip . ','  . $msg;
                M('oper_log')->add($log);
                $host['ip'] = $ip;
                $host['host_name'] = I('host_name');
                $host['ret'] = 'sys-failure';
                $host['mask'] = '5';
                $host['res'] = $res;
                $this->ajaxReturn($host);
            }
        }     
    }
    

    public function upload() {
        $log = array(
                    'login_user_id' => session('uid'),
                    'source_ip' => session('login_ip'),
                    'oper_time' => time(),
                    
                );

        $file = $_FILES;
        $key = array_keys($file);

        $today = date('Ymd');
        //print_r($key);die;
        $sys = substr($key[0],strpos($key[0],'_') + 1);
        $pkgoref = substr($key[0], 0,strpos($key[0],'_'));
        $rootPath = $_SERVER['DOCUMENT_ROOT'] . '/Uploads' . '/' . $today . '/' . $pkgoref . '/' . $sys . '/';
        if(!is_dir($rootPath)) {
            $res=mkdir($rootPath,0755,true);
        }
        //print_r($rootPath);die;
        $config = array(
            'maxSize'    =>    202400000,
            'rootPath'   =>    $rootPath,
            'savePath'   =>    '',
            'saveName'   =>    array('uniqid',$sys . '_'),
            'exts'       =>    array('jpg', 'gif', 'png', 'jpeg','pdf','war','zip'),
            'autoSub'    =>    false,
           // 'subName'    =>    array('date','Ymd'),
        );
        //print_r($_FILES);
        $upload = new \Think\Upload($config);
        $info = $upload->upload();
        if(!$info) {
             $log['oper'] =  '上传文件失败：' . $upload->getError();
             M('oper_log')->add($log);
            $this->ajaxReturn($upload->getError());
        }else{
            $condition['system_name']=$sys;
            if($pkgoref == 'pkg') {
                $tmp = $file[$key[0]]['name'];
                $tmpfile = substr($tmp,0,-4);
                $version = end(explode('_',$tmpfile));
                $data['tmp_version'] = $version;
            }
            $data['tmp_' . $pkgoref] = $rootPath.$info[$key[0]]['savepath'].$info[$key[0]]['savename'];
            M('system')->where($condition)->save($data);
            $log['oper'] = '上传文件成功：' . $rootPath.$info[$key[0]]['savepath'].$info[$key[0]]['savename'];
             M('oper_log')->add($log);
            // foreach($info as $file){
            //     echo $file['savepath'].$file['savename'];
            // }
            $this->ajaxReturn('success');
        }
    }

    public function code2pkg() {
        $log = array(
                    'login_user_id' => session('uid'),
                    'source_ip' => session('login_ip'),
                    'oper_time' => time(),
                    
                );
        $webroot = $_SERVER['DOCUMENT_ROOT'];
        $svn = trim(I('svn'));
        $tmp = explode('/',$svn);
        $randstr = getRandChar(20);
        $rootPath = '/tmp/' . $randstr;
        $version = '';
        $system_id = I('system_id');
        $condition['system_id'] = $system_id; 
        $system_name = M('system')->where($condition)->getField('system_name');
        $system = D('SystemRelation')->relation(true)->where($condition)->find();
        $deploy_rule = $system['deploy_rule']['rule_name'];
        $command = '';
        if($deploy_rule == 'Java-SVN') {
            $env = 'prd';
            $version = end($tmp);
            $command = $webroot . '/bin/scb.sh ' . $system_name . ' ' . $svn . ' ' . $env . ' ' . $rootPath; 
        }else if($deploy_rule == 'PHP-SVN') {
            $version = end($tmp);
            $command = $webroot . '/bin/svnco.sh ' . $system_name . ' ' . $svn . ' ' . $version . ' ' . $rootPath;
        }else if($deploy_rule == '静态文件-SVN') {
            $version = $tmp[count($tmp) - 2];
            $command = $webroot . '/bin/svnco.sh ' . $system_name . ' ' . $svn . ' ' . $version . ' ' . $rootPath;
        }
        
        $res = exec($command,$output,$ret);
        if($ret == 0) {
            $tmp_pkg['tmp_pkg'] = $res;
            $tmp_pkg['tmp_version'] = $version;
            M('system')->where($condition)->save($tmp_pkg);
            $log['oper'] = '打包成功：' . $res;
            M('oper_log')->add($log);
        }else{
            $log['oper'] = '打包失败：' . $res;
            M('oper_log')->add($log);
        }
    	$data['last_line'] = $res;
    	$data['ret_code'] = $ret;
    	$data['output'] = $output;
        $this->ajaxReturn($data);
    }
   
}
