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

	//セレクトボックス用に、categor_nameとcategory_idの入ったテーブルからデータを持ってきて
	//$categoryInfoに入れる。
	$sql = "
			 SELECT
			     *
			 FROM
			     mst_item_category 
	";
	$ps = $db->prepare($sql);
	$ps->execute();
	$categoryInfo = $ps->fetchAll();

	//$categoryIdと$sql_categoryと$sql_whereと$isItemInfoを初期化する。

	$categoryId = "";
	$sql_where = "";
	$isItemInfo = false;

	//商品一覧用にitem_nameの入ったテーブルからデータを持っきて$itemInfoに入れる。
	$sql = "
			 SELECT
			     *
			 FROM
			     mst_item 
	";

	//POSTでcategory_idが受け取れたか（カテゴリー絞込検索が押されたか)確認。
	if(isset($_POST['category_id']) && !empty($_POST['category_id'])){

		//$categoryIdにpostで受け取った値を代入。
		$categoryId = $_POST['category_id'];

		if(empty($sql_where)){

			/* sql文を分割して後で結合して実行する。
			   押された押されたカテゴリ名が含まれるcategory_idを表示するSQLをセット。 */
			$sql_where = " WHERE ";

		}else{

			/*連結するSQLを追加した、もしくは商品名検索と場所を入れ替えた場合でも動くように
			  $sql_whereの値とANDを連結して作っておく。 */
			$sql_where = $sql_where . " AND ";
		}
		$sql_where = $sql_where . " category_id = '" . $categoryId . "' ";
	}

	//$itemNameを初期化する。
	$itemName = "";

	//POSTでitem_nameが受け取れたか（商品名絞込検索が押されたか)確認。
	if(isset($_POST['item_name']) && !empty($_POST['item_name'])){

		//$itemNameにpostで受け取った値を代入
		$itemName = $_POST['item_name'];
		
		if(empty($sql_where)){

			//押されたカテゴリ名を含むitem_nameを表示するSQLをセット。
			$sql_where = " WHERE ";
		}else{

			//$sql_whereで連結して、カテゴリー名が入った$sql_whereとANDを連結する。
			$sql_where = $sql_where . " AND ";
		}
		$sql_where = $sql_where . " item_name LIKE '" . $itemName . "' ";
	}

	//$sql_orderと$sortTypeを初期化する。
	$sql_order = "";
	$sortType = "";

	//postからsortを受け取ったか（並び替え検索が押されたか)確認。
	if(isset($_POST['sort']) && !empty($_POST['sort'])){

		//$sortTypeにpostの値を代入。
		$sortType = $_POST['sort'];

		//$sortTypeにsortCheapが入っていれば(価格の安い順が押されたら)
		if($sortType === 'sortCheap'){

			//昇順（安い順）のSQLをセット。
			$sql_order = " ORDER BY price ASC ";

		//$sortTypeにsortExpensiveが入っていれば(価格の高い順が押されたら)
		}elseif($sortType === 'sortExpensive'){

			//降順（高い順）のSQLをセット。
			$sql_order = " ORDER BY price DESC ";

		//$sortTypeにsortItemNameが入っていれば（商品名順が押されたら)
		}elseif($sortType === 'sortItemName'){

			//昇順（あ～スタート）のSQLをセット。
			$sql_order = " ORDER BY item_name ASC ";
		}
	}

	//SQL文を結合し、実行し、$itemInfoに入れる。
	$sql = $sql . $sql_where . $sql_order;
	$ps = $db->prepare($sql);
	$ps->execute();
	$itemInfo = $ps->fetchAll();

	if($itemInfo){
		$isItemInfo = true;
	}

	//assignしてSmarty側に送る。
	$smarty->assign('login', $login);
	$smarty->assign('categoryInfo', $categoryInfo);
	$smarty->assign('itemInfo', $itemInfo);
	$smarty->assign('isItemInfo', $isItemInfo);
	$smarty->assign('cart', $cart);
	$smarty->assign('history', $history);
	$smarty->display('item_list.tpl');
?>
