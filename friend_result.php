<?php
	require_once('smarty/Smarty.class.php');
	require('databaseinfo/db_init.php');
	
	//関数のファイル(function_user_id.php)を読み込む
	require('function/function_user_id.php');

	$smarty = new Smarty();
	$smarty->template_dir = './templates/';
	$smarty->compile_dir = './template_c/';

	if(isset($_POST['user_id']) && !empty($_POST['user_id'])){
		
		//$userIdと$friendsDataを初期化
		$userId = array();
		$friendsData = array();

		//自作関数getUserId($userId)を読み込み$friendDataに代入
		$friendsData = getUserId($_POST['user_id']);

		//isfriendsDataを初期化
		$isfriendsData = false;
		if(!empty($friendsData)){
			$isFriendsData = true;
		}

		$smarty->assign('isFriendsData', $isFriendsData);
		$smarty->assign('friendsData', $friendsData);
		$smarty->display('friend_result.tpl');
	}else{
		echo "不正な遷移です<br>";
		exit();
	}
?>