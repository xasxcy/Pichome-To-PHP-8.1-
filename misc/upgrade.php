<?php

if(!defined('IN_OAOOA')) {
	exit('Access Denied');
}
include_once DZZ_ROOT.'./core/core_version.php';

 global $_G;
$action = isset($_GET['action']) ? trim($_GET['action']) : '';
if($action == 'checkupgrade') {
	header('Content-Type: text/javascript');
	try {
		if(!empty($_G['uid']) && class_exists('dzz_upgrade')) {
			$dzz_upgrade = new dzz_upgrade();
			$dzz_upgrade->check_authlic();
			dsetcookie('checkauthlic', 1, 60*60*24);
		}
		if(!empty($_G['uid']) && isset($_G['member']['adminid']) && intval($_G['member']['adminid']) === 1 && class_exists('dzz_upgrade')) {
			$dzz_upgrade = new dzz_upgrade();
			$dzz_upgrade->check_upgrade();
			dsetcookie('checkupgrade', 1, 60*60*24);
		}
	} catch (Throwable $e) {
		// Keep this polling endpoint script-safe for frontend.
	}
	exit; 
}elseif($action == 'checkappupgrade') {
	header('Content-Type: text/javascript'); 
	try {
		if(!empty($_G['uid']) && isset($_G['member']['adminid']) && intval($_G['member']['adminid']) === 1 && class_exists('dzz_upgrade_app')) { 
			$dzz_upgrade_app = new dzz_upgrade_app(); 
			$dzz_upgrade_app->check_upgrade();
			dsetcookie('checkappupgrade', 1, 60*60*24);
		}
	} catch (Throwable $e) {
		// Keep this polling endpoint script-safe for frontend.
	}
	exit; 
}elseif($action == 'checkauthlic'){
	header('Content-Type: text/javascript');
	try {
		if(!empty($_G['uid']) && class_exists('dzz_upgrade')) {
			$dzz_upgrade = new dzz_upgrade();
			$dzz_upgrade->check_authlic();
			dsetcookie('checkauthlic', 1, 60*60*24);
		}
	} catch (Throwable $e) {
		// Keep this polling endpoint script-safe for frontend.
	}
	exit;
}elseif($action == 'upgradenotice') {
	$html='';
	$list = array();
	$isajax = isset($_GET['isajax']) ? intval($_GET['isajax']) : 0;
		if(isset($_G['member']['adminid']) && $_G['member']['adminid'] == 1) {
			$notelist='';
			$dbversion = helper_dbtool::dbversion();
			//系统升级信息
			$upgradeList = (isset($_G['setting']['upgrade']) && is_array($_G['setting']['upgrade'])) ? $_G['setting']['upgrade'] : array();
			foreach($upgradeList as $type => $upgrade) {
                if(!is_array($upgrade)) {
                    continue;
                }
                $phpver = isset($upgrade['phpversion']) ? $upgrade['phpversion'] : PHP_VERSION;
                $mysqlver = isset($upgrade['mysqlversion']) ? $upgrade['mysqlversion'] : $dbversion;
                $latestversion = isset($upgrade['latestversion']) ? $upgrade['latestversion'] : '';
				if(version_compare($phpver, PHP_VERSION) > 0 || version_compare($mysqlver, $dbversion) > 0) {
					$list[$type]['note']= lang('require_allocation_attain').' php v'.PHP_VERSION.'MYSQL v'.$dbversion;
				}
				$list[$type]['icon']='dzz/images/default/notice_system.png';
				$list[$type]['official']='admin.php?mod=system#/systemupgrade';
				$list[$type]['title']='oaooa &nbsp;<b>'.$latestversion.'</b>';
				$list[$type]['appurl']= 'admin.php?mod=system&op=systemupgrade';
			//&operation='.$type.'&version='.$upgrade['latestversion'].'&locale='.$locale.'&charset='.$charset.'&release='.$upgrade['latestrelease'];
		}
		if($isajax){
			exit(json_encode(array('data' => $list)));
		}
		//查询所有待更新的应用
		// $app_need_upgrade_list = DB::fetch_all("SELECT * FROM " . DB::table('app_market') . " WHERE 1 and upgrade_version!='' and available>0 ");
		// foreach($app_need_upgrade_list as $type => $upgrade) {
		// 	$upgrade['upgrade_version']=unserialize($upgrade['upgrade_version']);
		// 	$list[$type]['icon']=$_G['setting']['attachurl'].$upgrade['appico'];
		// 	$list[$type]['official']='admin.php?mod=system#/systemupgrade';
		// 	$list[$type]['title']=$upgrade['appname'].'&nbsp;<b>'.$upgrade['upgrade_version']['version'].'</b>';
		// 	$list[$type]['appurl']= replace_canshu($upgrade['appurl']);
		// }
		if($list){
			$html=' <div class="panel panel-warning" style="margin:0;min-width:300px;">';
			$html.=' <div class="panel-heading" style="border-radius:0">';
			$html.=     lang('upgrade_notice_title');
			$html.='     <button type="button" class="close" onclick="jQuery(\'#systemNotice\').hide();setcookie(\'upgradenotice\',1,3600);"><span aria-hidden="true">×</span></button>';
			$html.=' </div>';
			$html.=' <div class="panel-body" style="padding:0;max-height:500px;overflow-y:auto">';
			$html.='  <table class="table table-hover" style="margin:0">';
			foreach($list as $type =>$value){
				$html.=  '<tr><td><div style="line-height:30px;"><img src="'.$value['icon'].'" style="max-height:30px;" /><a href="'.$value['official'].'" title="'.lang('examine_details').'">'.$value['title'].'</a></div>';
				if($value['note']){
					$html.= '<div class="text-muted" style="font-size:12px;margin-left:40px;">'.$value['note'].'</div>';
				}
				$html.=  '</td></tr>';
			}
			$html.=' </table>';
			$html.=' </div>';
			$html.='</div>';
		}
	}
	//include template('common/header_ajax');
	echo $html;
	//include template('common/footer_ajax');
	exit;

	} elseif($action == 'appnotice') {
		
	} else {
        // Keep the endpoint response predictable for frontend polling callers.
        $isajax = isset($_GET['isajax']) ? intval($_GET['isajax']) : 0;
        if($isajax) {
            header('Content-Type: application/json; charset=utf-8');
            exit(json_encode(array('data' => array())));
        }
        exit;
    }
	?>
