<?php
	require_once('smarty/Smarty.class.php');
	require('dataBaseInfo/db_init.php');

	//自作関数ファイルfunction.phpを読み込む
	require('/function/function.php');

	$smarty = new Smarty();
	$smarty->template_dir = './templates/';
	$smarty->compile_dir = './template_c/';

	//$userInfoを初期化
	$userInfo = array();

	//自作関数getUserInfoの値を$userInfoに代入
	$userInfo = getUserInfo();

	//$isDataを初期化
	$isData = false;
	if(!empty($userInfo)){
		$isData = true;
	}

	$smarty->assign('isData', $isData);
	$smarty->assign('userInfo', $userInfo);
	$smarty->display('user_select.tpl');
?>