<?php 


function node_merge($node,$access = null,$pid = 0) {

	$arr = array();
	foreach ($node as $v) {
		if(is_array($access)) {
			$v['access'] = in_array($v['id'],$access) ? 1 : 0;
		}
		if($v['pid'] == $pid) {
			$v['child'] = node_merge($node, $access,$v['id']);
			$arr[] = $v;
		}
	}

	return $arr;
}

// function user_role_merge($list) {
// 	dump($list);die;
// 	$arr = array();
// 	foreach ($list as $k => $v) {
// 		if(empty($arr)) {
// 			$role_name[] = $v['role_name'];
// 			$remark[] = $v['remark'];
// 			$v['role_name'] = $role_name;
// 			$v['remark'] = $remark;
// 			$arr[] = $v;
// 		}else {
// 			$tmp =array();
// 			foreach ($arr as $j => $w) {
// 				if($v['user_id'] == $w['user_id']){
// 					$role_name = $w['role_name'];
// 					$role_name[] = $v['role_name'];
// 					$remark = $w['remark'];
// 					$remark[] = $v['remark'];
// 					$w['role_name'] = $role_name;

// 					$w['remark'] = $remark;
// 					$arr[$j] = $w;
// 				}else{
// 					$r[] = $v['role_name'];
// 					$re[] = $v['remark'];
// 					$v['role_name'] = $r;
// 					$v['remark'] = $re;
// 					$tmp[] = $v;
// 					echo 1,dump($tmp),'</br>';
// 				}
// 			}
// 			$arr = array_merge($arr,$tmp);
// 		}
		
			
			
// 	}

// 	die;
// 	return $arr;

// }


function chkrole($role=array()) {
	if(empty($role)) {
		return false;
	}

	if(count($role) != count(array_unique($role))) {
		return false;
	}

	foreach ($role as $v) {
		if($v == 0) {
			return false;
		}
	}

	return true;
}

function chkip($ipaddr) {

	if(filter_var($ipaddr, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
		return true;
	}else{
		return false;
	}
}


function getRandChar($length){
   $str = null;
   $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
   $max = strlen($strPol)-1;

   for($i=0;$i<$length;$i++){
    $str.=$strPol[rand(0,$max)];//rand($min,$max)生成介于min和max两个数之间的一个随机整数
   }

   return $str;
  }

 ?>