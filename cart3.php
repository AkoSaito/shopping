<?php
	require_once('smarty/Smarty.class.php');
	require('databaseinfo/db_init.php');
	require('function/function_login.php');
	require('function/function_cart.php');
	require('function/function_history.php');
echo "c1<br>";

	//************************
	//変数を初期化
	//************************
	$arrBinder = array();
	$arrBinder['isError'] = false;
	$arrBinder['errMsg'] = "";
	$arrBinder['msg'] = "";
	$arrBinder['isComplete'] = false;
	$arrBinder['login'] = "";
	$arrBinder['cartDetail'] = "";
	$arrBinder['deposit'] = 0;
	$arrBinder['ret'] = "";
	$arrBinder['totalPrice'] = "";
	$arrBinder['history'] = "";
	
echo "c2<br>";

	//************************
	//バリデーションチェック
	//************************

	session_start();
	if(!isset($_SESSION['user_name']) || empty($_SESSION['user_name'])){

echo "c3<br>";
		header("Location: login.php");
		exit();
	}
	if(isset($_POST['btnUpd']) && !empty($_POST['btnUpd'])){
echo "c3b<br>";
		if(!isset($_POST['item_number']) || empty($_POST['item_number'])){
var_dump($_POST);
			setError($arrBinder, "個数を入力してください。<br>");
		}else{
			if(preg_match("/[^0-9]/", $_POST['item_number'])){
				setError($arrBinder, "個数は半角数字で入力して下さい。<br>");
			}
		}
	}
	//ログインへのリンクを作成
	$arrBinder['login'] = getLoginSession();
	$arrBinder['history'] = moveToHistory();

echo "c4<br>";
	//***********************
	//メイン処理
	//***********************

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
	$arrBinder['cartDetail'] = $ps->fetchAll();

echo "c5<br>";
	if(empty($arrBinder['cartDetail'])){
echo "c6<br>";
		setError($arrBinder, "カートに商品がありません。<br>");
	}else{
echo "c7<br>";
		foreach($arrBinder['cartDetail'] as $value){
			$stock = $value['stock'];
			$itemNumber = $value['item_number'];
			$itemName = $value['item_name'];
		}
echo "c8<br>";
		//購入ボタンが押されていた場合
		if(isset($_POST['btnBuy']) && !empty($_POST['btnBuy'])){
echo "c9<br>";
	
echo "c10<br>";
			$sql = "
					SELECT
					    mst_item.price * dt_cart.item_number AS total_price
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
			$totalPrice = $ps->fetchAll();

			if(empty($totalPrice)){
				setError($arrBinder, "合計金額が受け取れていません。<br>");
			}else{
				if($stock < $itemNumber){
					setError($arrBiner, "申し訳ございません。" . $itemName . "は在庫切れです。<br>");
				}else{
echo "c11<br>";
					foreach($totalPrice as $sum){
						$buyTotalPrice += $sum['total_price'];
					}

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
					$arrBinder['deposit'] = $ps->fetch();
				
echo "c12<br>";
					if($arrBinder['deposit'] <= $buyTotalPrice){
echo "c13<br>";
						setError($arrBinder, "デポジットが足りません。<br>]
											  源氏アのデポジットは" . $deposit['deposit'] . "円です。<br>");
					}else{
						
						$sql = "
								UPDATE
								    mst_user
								SET
								    deposit = " . $arrBinder['deposit']['deposit'] . " - " . $buyTotalPrice . "
								WHERE
									user_id = " . $_SESSION['user_id'] . "
						";
						$ps = $db->prepare($sql);
						$updDeposit = $ps->execute();
echo "c14<br>";
						if(empty($updDeposit)){
echo "c15<br>";
							serError($arrBinder, "購入処理エラー：デポジットが減算されていません。<br>");
						}else{
echo "c16<br>";

						//dt_cartのstockの個数を、購入した個数分減算するSQLを取得
				
echo "c17<br>";
						$sql = "
								UPDATE
								    mst_item
								SET
								    stock = ". $stock . " - ". $itemNumber . "
								WHERE
								    item_id = " . $_POST['item_id'] . "
						";
						$ps = $db->prepare($sql);
						$updCart = $db = $ps->execute();

						if($updCart){
							$arrBinder['msg'] = "個数が減算されました。<br>";
						}else{
							setError($arrBinder, "個数の減算に失敗しました。<br>");
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
								    " . $_SESSION['user_id'] . ",
								    " . $_POST['item_id'] . ",
								    " . $_POST['item_number'] . ",
									" . $buyTotalPrice . ",
									'" . date('Y年m月d日') . "'
								)

						";
						$ps = $db->prepare($sql);
						$arrBinder['ret'] = $ps->execute();
echo "c18<br>";

						if(empty($arrBinder['ret'])){
echo "c19<br>";
							setError($arrBinder, "購入に失敗しました。<br>");
						}else{
echo "c20<br>";
							$arrBinder['msg'] = "購入完了しました<br>
												 現在のデポジットは" . $deposit['deposit'] . "です。<br>";
						}

						//購入完了たら、カートから購入商品を削除
		
						$sql = "
								DELETE
								FROM
								    dt_cart
								WHERE
								    user_id = " . $_SESSION['user_id'] ."
						";
						$ps = $db->prepare($sql);
						$arrBinder['del'] = $ps->execute();
						$ps->rollback();
echo "c21<br>";
						if(empty($arrBinder['ret'])){
echo "c22<br>";
							setError($arrBinder, "商品のカート内削除に失敗しました。<br>");
						}
					}
				}
				//購入処理完了フラグ
				$arrBinder['isComplete'] = true;
				}
			}
		}
echo "c23<br>";

echo "c24<br>";
		//削除ボタンが押された場合
		if(isset($_POST['btnDel']) && !empty($_POST['btnDel'])){
echo "c25<br>";
			if(isset($_POST['item_id']) && !empty($_POST['item_id'])){
				$sql = "
						DELETE
						FROM
						    dt_cart
						WHERE
						    user_id = " . $_SESSION['user_id'] ."
						AND item_id = " . $_POST['item_id'] . "
				";
				$ps = $db->prepare($sql);
echo $sql;
				$arrBinder['ret'] = $ps->execute();
var_dump($_POST['item_id']);
		}
echo "c26<br>";
				if(empty($arrBinder['ret'])){
echo "c27<br>";
					setError($arrBinder, "商品のカート内削除に失敗しました。<br>");
				}else{
echo "c28<br>";
					$arrBinder['msg'] = "カートから商品を削除しました。<br>";
				}
			}
		}
echo "c29<br>";
var_dump($_POST);
		
		//購入個数変更ボタンが押された場合
		if(isset($_POST['btnUpd']) && !empty($_POST['btnUpd'])){
echo "c30<br>";

echo "c31<br>";
			if(isset($_POST['stock']) && !empty($_POST['stock'])){

				//個数変更後の在庫が足りているか確認
				if($stock < $_POST['item_number']){
echo "c32a<br>";
					setError($arrBinder, "在庫が不足しています。<br>現在の在庫は" . $arrBinder['cartDetail']['stock'] . "個のみです。<br>
										  再度入力してください<br>");
				}else{
echo "c32b<br>";
					$sql = "
							UPDATE
							    dt_cart
							SET
							    item_number = " . $_POST['item_number'] . "
							WHERE
							    item_id = " . $_POST['item_id'] . " 
							AND user_id = ". $_SESSION['user_id'] . "
					";
echo $sql;
var_dump($_POST);
					$ps = $db->prepare($sql);
					$arrBinder['ret'] = $ps->execute();
echo "c33<br>";
					if($arrBinder['ret']){
echo "c34<br>";
						$arrBinder['msg'] = "購入個数を変更しました。<br>";
					}
					//カート内の最新の商品情報を取得
					$sql = "
						SELECT
						    *
						FROM
						    mst_item
						    INNER JOIN
						        dt_cart
						    ON  mst_item.item_id = dt_cart.item_id
						    INNER JOIN
						        mst_user
						    ON  mst_user.user_id = dt_cart.user_id
						WHERE
							dt_cart.item_id = " . $_POST['item_id'] . "
						AND dt_cart.user_id = " . $_SESSION['user_id'] . "
					";
					$ps = $db->prepare($sql);
					$ps->execute();
					$arrBinder['cartDetail'] = $ps->fetchAll();
				}
			}
echo "c35<br>";
		}
echo "c36<br>";

	//テンプレート読み込み
	loadTemplate($arrBinder);
var_dump($arrBinder);
echo "c37<br>";
	//******************************
	// ローカル関数
	//******************************

	/**
	 * テンプレート読み込み用関数
	 *
	 * @param array $arrBinder テンプレートへ引き渡す値をまとめた配列
	 *
	 * @return None exit()で終了
	 */
	function loadTemplate($arrBinder = Null){
echo "c38<br>";
		$smarty = new Smarty();
		$smarty->template_dir = './templates/';
		$smarty->compile_dir = './template_c/';

		$smarty->assign('arrBinder', $arrBinder);
		if(isset($arrBinder['isError']) && !empty($arrBinder['isError'])){
			$isError = $arrBinder['isError'];
			$smarty->assign('isError', $isError);
		}
		if(isset($arrBinder['errMsg']) && !empty($arrBinder['errMsg'])){
			$errMsg = $arrBinder['errMsg'];
			$smarty->assign('errMsg', $errMsg);
		}
		if(isset($arrBinder['msg']) && !empty($arrBinder['msg'])){
			$msg = $arrBinder['msg'];
			$smarty->assign('msg', $msg);
		}
		if(isset($arrBinder['isComplete']) && !empty($arrBinder['isComplete'])){
			$isComplete = $arrBinder['isComplete'];
			$smarty->assign('isComplete', $isComplete);
		}
		if(isset($arrBinder['login']) && !empty($arrBinder['login'])){
			$login = $arrBinder['login'];
			$smarty->assign('login', $login);
		}
		if(isset($arrBinder['cartDetail']) && !empty($arrBinder['cartDetail'])){
			$cartDetail = $arrBinder['cartDetail'];
			$smarty->assign('cartDetail', $cartDetail);
		}
		if(isset($arrBinder['ret']) && !empty($arrBinder['ret'])){
			$ret = $arrBinder['ret'];
			$smarty->assign('ret', $ret);
		}
		if(isset($arrBinder['deposit']) && !empty($arrBinder['deposit'])){
			$deposit = $arrBinder['deposit'];
			$smarty->assign('deposit', $deposit);
		}
		if(isset($arrBinder['history']) && !empty($arrBinder['history'])){
			$history = $arrBinder['history'];
			$smarty->assign('history', $history);
		}
		$smarty->display('cart.tpl');
		exit();
	}
	/**
	 * エラー設定関数
	 *
	 * @param array $arrBinder テンプレートへ引き渡す値をまとめた配列
	 * @param string $errMsg エラーメッセージ格納用
	 *
	 * @return None loadTemplate()を呼び出し、exit()で終了
	 */
	function setError($arrBinder = Null, $errMsg = ""){
echo "c39<br>";
		$arrBinder['isError'] = true;
		$arrBinder['errMsg'] = $errMsg;
		loadTemplate($arrBinder);
	}
echo "c40<br>";
?>