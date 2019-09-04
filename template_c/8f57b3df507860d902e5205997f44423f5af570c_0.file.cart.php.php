<?php
/* Smarty version 3.1.30, created on 2018-02-19 08:35:35
  from "C:\xampp\htdocs\sample\cart.php" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5a8a7e472d10f8_18595099',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '8f57b3df507860d902e5205997f44423f5af570c' => 
    array (
      0 => 'C:\\xampp\\htdocs\\sample\\cart.php',
      1 => 1519025732,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a8a7e472d10f8_18595099 (Smarty_Internal_Template $_smarty_tpl) {
echo '<?php
	';?>require_once('smarty/Smarty.class.php');
	require('databaseinfo/db_init.php');
	require('function/function_login.php');
	require('function/function_cart.php');
echo "c1";
	$smarty = new Smarty();
	$smarty->template_dir = './templates/';
	$smarty->compile_dir = './template_c/';

	//************************
	//変数を初期化
	//************************

	$isError = false;
	$errMsg = "";
	$msg ="";
	$isComplete = false;
	$login = "";
	$cartDetail = "";
	$deposit = 0;
	$ret = "";
	$del = "";
	$upd = "";
echo "c2";
	//************************
	//バリデーションチェック
	//************************

	session_start();
	if(!isset($_SESSION['user_name']) || empty($_SESSION['user_name'])){
echo "c3";
		header("Location: login.php");
		$isError = true;
		exit();
	}

	//ログインへのリンクを作成
	$login = getLoginSession();

echo "c4";
	//***********************
	//メイン処理
	//***********************
	if(!$isError){
		//カート内の商品情報を取得
		$sql = "
				SELECT
				    *
				FROM
				    mst_item
				    INNER JOIN
				        dt_cart
				    ON  mst_item.item_id = dt_cart.item_id
				WHERE
				    dt_cart.user_id = " . $_SESSION['user_id'] . "
		";
echo $sql;
		$ps = $db->prepare($sql);
		$ps->execute();
		$cartDetail = $ps->fetchAll();

var_dump($cartDetail);
echo "c5";
		if(empty($cartDetail)){
echo "c6";
			$isError = true;
			$errMsg  = "カートに商品がありません。<br>";
		}else{
			if($cartDetail['stock'] > $cartDetail['item_number']){
echo "c7";
			$isError = true;
			$errMsg = "申し訳ございません。在庫切れです。<br>";
			}
		}
	}
echo "c8";
	if(!$isError){
		//購入ボタンが押されていた場合
		if(isset($_POST['btnBuy']) && empty($_POST['btnBuy'])){
echo "c9";
			if(!isset($_POST['item_number']) || empty($_POST['item_number'])){
echo "c10";
				$isError = true;
				$errMsg = "購入個数を入力してください。<br>";
			}
			if(!preg_match("/[^0-9]/", $_POST['item_number'])){
echo "c11";
				$isError = true;
				$errMsg = "個数は半角数字で入力して下さい。<br>";
			}
	
echo "c12";
			$totalPrice = $cartDetail['price'] * $cartDetail['item_number'];

			//購入者のdepositを取得
			$sql = "
					SELECT
					    deposit
					FROM
					    mst_user
					WHERE
					    user_id = " . $_SESSION['user_id'] . "
			";
			$ps = $db->prepare($sql);
			$ps->execute();
			$deposit = $ps->fetch();
echo "c13";
			if($deposit <= $totalPrice){
echo "c14";
				$isError = true;
				$errMsg = "デポジットが足りません。<br>";
			}
			//デポジットから購入した金額を減算する
			$latestDeposit = $deposit - $totalPrice;

echo "c15";
			if(!$latestDeposit){
echo "c16";
				$isError = true;
				$errMsg = "購入処理エラー：デポジットが減算されていません。<br>";
			}else{
echo "c17";
				$msg = "デポジットが" . $totalPrice . "円マイナスされました。<br>
						現在のデポジットは" . $deposit . "円です。<br>";
			}

			//dt_cartのstockの個数を、購入した個数分減算する
			$latestStock = $cartDetail['stock'] - $cartDetail['item_number'];
echo "c18";
			if(!$latestStock){
echo "c19";
				$isError = true;
				$errMsg = "購入処理エラー：在庫の個数が減算されていません。<br>";
			}

			//購入商品を買い物履歴テーブルに挿入

			$sql = "
					INSERT INTO dt_buy_history(
					    user_id,
					    item_id,
					    item_number,
					    total_price,
					    purchase_date
					)
					VALUES(
					    " . SESSION['user_id'] . ",
					    " . $arrBinder['cartDetail']['item_id'] . ",
					    " . $totalPrice . ",
					     now()
					)
			";
			$ps = $db->prepare($sql);
			$ret = $ps->execute();
			$ps->rollback();
echo "c20";

			if(empty($ret)){
echo "c21";
				$isError = true;
				$errMsg = "購入に失敗しました。<br>";
			}else{
echo "c22";
				$msg = "購入完了しました<br>";
			}

			//購入完了たら、カートから購入商品を削除

			$sql = "
					DELETE
					FROM
				    dt_buy_history
					WHERE
					    user_id = " . $SESSION['user_id'] ."
					AND item_id = " . $arrBinder['cartDetail']['item_id'] . "
			";
			$ps = $db->prepare($sql);
			$del = $ps->execute();
			$ps->rollback();
echo "c23";
			if(empty($del)){
echo "c24";
				$isError = true;
				$errMsg = "商品のカート内削除に失敗しました。<br>";
			}

			//購入処理完了フラグ
			$isComplete = true;
		}
echo "c25";
	}

echo "c26a";
	if(!$isError){
		//削除ボタンが押された場合
		if(isset($_POST['btnDel']) && !empty($_POST['btnDel'])){
echo "c26b";
			$sql = "
					DELETE
					FROM
					    dt_buy_history
					WHERE
					    user_id = " . $SESSION['user_id'] ."
					AND item_id = " . $arrBinder['cartDetail']['item_id'] . "
			";
			$ps = $db->prepare($sql);
			$del = $ps->execute();
echo "c27";
			if(empty($del)){
echo "c28";
				$isError = true;
				$errMsg = "商品のカート内削除に失敗しました。<br>";
			}else{
echo "c29a";
				$msg = "カートから商品を削除しました。<br>";
			}
		}
	}
echo "c29b";
	if(!$isError){
		//購入個数変更ボタンが押された場合
		if(isset($_POST['btnUpd']) && !empty($_POST['btnUpd'])){
echo "c30";
			//個数がカート時と変更されているか確認
			if($cartDetail['item_number'] = $_POST['item_number']){
echo "c40";
				$isError = true;
				$errMsg = "購入個数が変更されていません。<br>
										  現在のカート内数量は" . $arrBinder['cartDetail']['item_number'] . "です。<br>
										  再度入力して下さい。<br>";
			}else{
echo "c41";
				//個数変更後の在庫が足りているか確認
				if($cartDetail['stock'] < $cartDetail['item_number']){
echo "c42";
					$isError = true;
					$errMsg = "在庫が不足しています。<br>現在の在庫は" . $cartDetail['stock'] . "個のみです。<br>
											  再度入力してください<br>";
				}
			}
			$sql = "
					UPDATE
					    dt_cart
					SET
					    item_number = " . $_POST['item_number'] . "
					WHERE
					    item_id = " . $_POST [ 'item_id' ]. " 
					AND user_id = ".$_SESSION [ 'user_id' ] . "
			";
			$ps = $db->prepare($sql);
			$upd = $ps->execute();
echo "c43";
			if($upd){
echo "c44";
				$msg = "購入個数を変更しました。<br>";
			}

			//カート内の最新の商品情報を取得
			$sql = "
					SELECT
					    mst_item.item_name,
					    mst_item.price,
					    dt_cart.item_number
					FROM
					    mst_item
					    INNER JOIN
					        dt_cart
					    ON  mst_item.item_id = dt_cart.item_id
					    INNER JOIN
					        mst_user
					    ON  mst_user.user_id = dt_cart.user_id
					WHERE
					AND dt_cart.user_id = " . $_SESSION['user_id'] . "
			";
			$ps = $db->prepare($sql);
			$ps->execute();
			$cartDetail = $ps->fetchAll();
echo "c45";
		}
	}

echo "c46";

echo "c47";

echo "c48";

	$smarty->assign('isError', $isError);
	$smarty->assign('errMsg', $errMsg);
	$smarty->assign('msg', $msg);
	$smarty->assign('isComplete', $isComplete);
	$smarty->assign('login', $login);
	$smarty->assign('cartDetail', $cartDetail);
	$smarty->assign('deposit', $deposit);
	$smarty->assign('del', $del);
	$smarty->assign('upd', $upd);
	$smarty->display('cart.php');

echo "c50";
<?php echo '?>';
}
}
