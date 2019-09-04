<?php
	require_once('smarty/Smarty.class.php');
	require('databaseinfo/db_init.php');
	require('function/function_login.php');
	require('function/function_cart.php');
	require('function/function_history.php');

	$smarty = new Smarty();
	$smarty->template_dir = './templates/';
	$smarty->compile_dir = './template_c/';

	//自作関数を読み込む。
	$login = getLoginSession();
	$cart = moveToCart();
	$history = moveToHistory();

	//$itemNameと$itemIdと$stockを初期化する。
	$itemName = "";
	$itemId = "";
	$stock = "";
	//GETで受け取った値があるか(商品名を押されたか）確認。
	if(isset($_GET['item_id']) && !empty($_GET['item_id'])){

		//$itemNamesにGETの値を代入。
		$itemId = $_GET['item_id'];
		$db = new PDO('mysql:host=localhost;dbname=db;charset=utf8','root','');

		//表示するカラムを指定し、２つのテーブルから値を取りたいのでJOIN。
		//$itemNameの値（押された商品名）が含まれるitem_idを取得するSQLをセット。

		$sql = "
				SELECT
				    mst_item.item_name,
				    mst_item_category.category_name,
				    mst_item.category_id,
				    mst_item.stock,
				    mst_item.price
				FROM
				    mst_item
				    INNER JOIN
				        mst_item_category
				    ON  mst_item.category_id = mst_item_category.category_id
				WHERE
				    mst_item.item_id = '" . $itemId . "' 
		";
		$ps = $db->prepare($sql);
		$ps->execute();

		//$itemDetailに実行結果を代入。
		$itemDetail = $ps->fetch();

		//$stockにSQLで受け取った在庫数を代入
		$stock = $itemDetail['stock'];
	}else{

		//GETの値が受け取れていなかったら
		echo "不正な遷移です。<br>";
	}

	//assignでSmarty側にデータを送る。
	$smarty->assign('login', $login);
	$smarty->assign('itemDetail', $itemDetail);
	$smarty->assign('itemId', $itemId);
	$smarty->assign('stock', $stock);
	$smarty->assign('cart', $cart);
	$smarty->assign('history', $history);
	$smarty->display('item_detail.tpl');
?>
