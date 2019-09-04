<?php
	require_once('smarty/Smarty.class.php');
	require('databaseinfo/db_init.php');
	require('function/function_login.php');
	require('function/function_cart.php');
	require('function/function_history.php');

	$smarty = new Smarty();
	$smarty->template_dir = './templates/';
	$smarty->compile_dir = './template_c/';

	///**********************
	// 変数初期化
	//***********************

	$errMsg = "";
	$cart = "";
	$history = "";
	$historyDetail = "";

	///**********************
	// バリデーションチェック
	//***********************

	session_start();
	if(!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])){
		header('Location: login.php');
		exit();
	}

	//ヘッダー部のリンクを作成
	$login = getLoginSession();
	$cart = moveToCart();
	$history = moveToHistory();

	///**********************
	// メイン処理
	///**********************
	$sql = "
			SELECT
			    *
			FROM
			    mst_item
			    INNER JOIN
			    	dt_buy_history
			    ON
			    	dt_buy_history.item_id = mst_item.item_id
			    INNER JOIN
			    	mst_item_category
			    ON
			    	mst_item.category_id = mst_item_category.category_id
			WHERE
			    user_id = ". $_SESSION['user_id'] . "
			ORDER BY
			    dt_buy_history.purchase_date DESC
	";
	$ps = $db->prepare($sql);
	$ps->execute();
	$historyDetail = $ps->fetchAll();

	if(empty($historyDetail)){
		$errMsg = "購入した商品はありません。<br>";
	}

	$smarty->assign('historyDetail', $historyDetail);
	$smarty->assign('errMsg', $errMsg);
	$smarty->assign('login', $login);
	$smarty->assign('cart', $cart);
	$smarty->display('buy_history.tpl');
?>