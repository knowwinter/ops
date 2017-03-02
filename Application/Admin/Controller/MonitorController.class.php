<?php
namespace Admin\Controller;
use Think\Controller;
class MonitorController extends Controller {

    public function monitor() {
        $host = D('HostRelation');
        $list = $host->relation(true)->select();

        foreach ($list as $k => $v) {
            $command2 = '/usr/local/bin/ansible ' . $v['ipaddr'] . ' -m ping';
            $output2 = array();
            exec($command2,$output2,$ret2);
            if(strpos($output2[2],'pong')){
                $condition2['host_id'] = $v['host_id'];
                $data2['status'] = 1;
                M('host')->where($condition2)->save($data2);
                foreach ($v['service'] as $j => $l) {
                    $condition['service_id'] = $l['service_id'];
                    $condition['host_id'] = $v['host_id'];
                    $condition['_logic']='AND';
                    $command = '/usr/local/bin/ansible ' . $v['ipaddr'] . ' -m shell -a "/sbin/service ' . $l['service_name'] . ' status"';
                    $output = array();
                    exec($command,$output,$ret);
                    if(strpos($output[1],'is running')) {
                        $data['service_status'] = 1;
                        M('service_host')->where($condition)->save($data);
                    }else{
                        $data['service_status'] = 0;
                        M('service_host')->where($condition)->save($data);
                    }

                }
            }else{
                $condition2['host_id'] = $v['host_id'];
                $data2['status'] = 0;
                M('host')->where($condition2)->save($data2);
                foreach ($v['service'] as $j => $l) {
                    $condition['service_id'] = $l['service_id'];
                    $condition['host_id'] = $v['host_id'];
                    $condition['_logic']='AND';
                    $data['service_status'] = 0;
                    M('service_host')->where($condition)->save($data);
                }
            }

            
        }
    }
    
}