<?php
if (!defined('IN_OAOOA')) {
    exit('Access Denied');
}
global $_G;

$themeid = isset($_G['setting']['pichometheme']) ? intval($_G['setting']['pichometheme']):1;
$pagename = isset($_GET['pagename']) ? trim($_GET['pagename']):'';
$allThemeData = isset($_G['setting']['pichomethemedata']) && is_array($_G['setting']['pichomethemedata']) ? $_G['setting']['pichomethemedata'] : array();
$themedata = isset($allThemeData[$themeid]) && is_array($allThemeData[$themeid]) ? $allThemeData[$themeid] : array();
if (!$themedata && $allThemeData) {
    $fallbackTheme = reset($allThemeData);
    if (is_array($fallbackTheme)) {
        $themedata = $fallbackTheme;
    }
}
$themebanner = isset($themedata['themebanner']) ? intval($themedata['themebanner']) : 0;
$themefolder = !empty($themedata['themefolder']) ? $themedata['themefolder'] : 'dzz/banner/template/fashion';
$singletpltagdata = isset($themedata['themetag']) ? dunserialize($themedata['themetag']) : array();
$singletpltagdata = is_array($singletpltagdata) ? $singletpltagdata : array();
if(isset($singletpltagdata[$pagename])){
    $setdata =  $singletpltagdata[$pagename];
    $setkey = array_keys($setdata);
    $tagdata = C::t('pichome_templatetag')->fetch_by_tagflag($themeid,$setkey);
	// print_r($tagdata);die;
    foreach($tagdata as $k=>$v){
        $$k = $v;
    }
}


//栏目
    $bannerdatas = [];
    foreach(DB::fetch_all("select * from %t where isshow = 1 and themeid=%d and (settype = %d or btype = 0) order by disp ",
        array('pichome_banner',$themeid,$themebanner)) as $v){
        $viewperm = unserialize($v['views']);
        if (!C::t('pichome_banner')->getpermbypermdata($viewperm)) {
            continue;
        }
        if($v['icon']){
            $v['iconpath'] = getglobal('siteurl').'index.php?mod=io&op=getfileStream&path='.dzzencode('attach::'.$v['icon']);
        }
        $appdata = [];
        if($v['appids'] != '1'){
            $appids = explode(',',$v['appids']);
            foreach (DB::fetch_all("select appid,path,appname from %t where isdelete = 0 and appid in(%n)", array('pichome_vapp',$appids)) as $appval) {
                if (!IO::checkfileexists($appval['path'],1)) {
                    continue;
                }
                $haschildern = DB::result_first("select count(fid) from %t where appid  = %s ",array('pichome_folder',$appval['appid']));
                $appdata[] = ['appid'=>$appval['appid'],'appname'=>$appval['appname'],'isLeaf'=>($haschildern ? false:true)];
            }

        }else{
            foreach (DB::fetch_all("select appid,path,appname from %t where isdelete = 0", array('pichome_vapp')) as $appval) {
                if (!IO::checkfileexists($appval['path'],1)) {
                    continue;
                }
                $haschildern = DB::result_first("select count(fid) from %t where appid  = %s ",array('pichome_folder',$appval['appid']));
                $appdata[] = ['appid'=>$appval['appid'],'appname'=>$appval['appname'],'isLeaf'=>($haschildern ? false:true)];
            }
        }
        if(count($appdata) < 1) $v['isLeaf'] = true;
        elseif(count($appdata) == 1){
            $v['isLeaf'] = $appdata[0]['isLeaf'];
            $v['appid'] = $appdata[0]['appid'];
        }else{
            $v['isLeaf'] = false;
        }
        $v['children'] = $appdata;
        $v['filters'] = json_encode(unserialize($v['filters']));
		$v['showtype'] = json_encode(unserialize($v['showtype']));
        $bannerdatas[] = $v;
    }
    $contenturl = outputurl($_G['siteurl'].'index.php?mod=pichome&op=filelist');
    $pageurl = outputurl($_G['siteurl'].'index.php?mod=pichome&op=common');
    $defaultLeftData = json_encode($bannerdatas);


include template($themefolder.'/pc/page/'.$pagename);
