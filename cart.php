<?php
	require_once('smarty/Smarty.class.php');
	require('databaseinfo/db_init.php');
	require('function/function_login.php');
	require('function/function_cart.php');
	require('function/function_history.php');

	$smarty = new Smarty();
	$smarty->template_dir = './templates/';
	$smarty->compile_dir = './template_c/';

	//************************
	//変数を初期化
	//************************

	$isError = false;
	$errMsg = "";
	$msg = "";
	$isComplete = false;
	$cartDetail = "";
	$deposit = 0;
	$ret = "";
	$history = "";
	$resultDeposit = 0;
	$resultTotalPrice = 0;


	//************************
	//バリデーションチェック
	//************************

	session_start();
	if(!isset($_SESSION['user_name']) || empty($_SESSION['user_name'])){
		header("Location: login.php");
		exit();
	}
	if(isset($_POST['btnUpd']) && !empty($_POST['btnUpd'])){

		if(!isset($_POST['item_number']) || empty($_POST['item_number'])){
			$isError = true;
			$errMsg = "個数を入力してください。<br>";
		}else{
			if(preg_match("/[^0-9]/", $_POST['item_number'])){
				$isError = true;
				$errMsg = "個数は半角数字で入力して下さい。<br>";
			}
		}
	}

	//ヘッダー部のリンクを作成
	$login = getLoginSession();
	$history = moveToHistory();

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
	$ps = $db->prepare($sql);
	$ps->execute();
	$cartDetail = $ps->fetchAll();

	if(empty($cartDetail)){
		$isError = true;
		$errMsg = "カートに商品がありません。<br>";
	}
	if(!$isError){

		//*********************
		// 購入処理
		//*********************

		//購入ボタンが押されていた場合
		if(isset($_POST['btnBuy']) && !empty($_POST['btnBuy'])){

			foreach($cartDetail as $each){
				if($each['stock'] < $each['item_number']){
					$isError = true;
					$errMsg = "申し訳ございません。" . $each['item_name'] . "は在庫切れです。<br>";
				}else{

					//購入商品を買い物履歴テーブルに挿入
					try{

						$eachItemPrice = $each['price'] * $each['item_number'];
						$db->beginTransaction();
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
								    " . $each['item_id'] . ",
								    ". $each['item_number'] .",
								    " . $eachItemPrice . ",
								    '" . date(' Y年m月d日') . "'
								)
						";
						$ps = $db->prepare($sql);
						$ret = $ps->execute();

						$resultTotalPrice += $eachItemPrice;

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

						if($deposit){
							if($deposit['deposit'] <= $resultTotalPrice){
								$isError = true;
								$errMsg = "デポジットが足りません。<br>
										   現在のデポジットは" . $deposit['deposit'] . "円です。<br>";
							}else{
								$sql = "
										UPDATE
										    mst_user
										SET
										    deposit = " . $deposit['deposit'] . " - " . $resultTotalPrice . "
										WHERE
											user_id = " . $_SESSION['user_id'] . "
								";
								$ps = $db->prepare($sql);
								$updDeposit = $ps->execute();

								if(empty($updDeposit)){
									$isError = true;
									$errMsg = "購入処理エラー：デポジットが減算されていません。<br>";
								}else{

									//dt_cartのstockの個数を、購入した個数分減算するSQLを取得
									$sql = "
											UPDATE
											    mst_item
											SET
											    stock = ". $each['stock'] . " - ". $each['item_number'] . "
											WHERE
											    item_id = ". $each['item_id'] . "
									";
									$ps = $db->prepare($sql);
									$updCart = $ps->execute();

									if($updCart){
										$isComplete = true;
										$msg = "個数が減算されました。<br>";
									}else{
										$isError = true;
										$errMsg = "個数の減算に失敗しました。<br>";
									}
								}

								if(empty($ret)){
									$isError = true;
									$errMsg = "購入に失敗しました。<br>";
								}else{
									$isComplete = true;
									$resultDeposit = $deposit['deposit'] - $resultTotalPrice ;
									$msg = "購入完了しました。<br>デポジットが" . $resultTotalPrice . "円マイナスされました。<br>
										    現在のデポジットは" . $resultDeposit . "円です。<br>";
								}

								//購入完了したら、カートから購入商品を削除
								$sql = "
										DELETE
										FROM
										    dt_cart
										WHERE
										    user_id = " . $_SESSION['user_id'] ."
								";
								$ps = $db->prepare($sql);
								$ret = $ps->execute();
								$db->commit();
							}
						}
					}catch(Exception $e){
						$db->rollback();
						if(empty($ret)){
							$isError = true;
							$errMsg = "商品のカート内削除に失敗しました。<br>";
						}else{
							$isComplete = true;
						}
					}
				}

			}

		}
	}
	//********************
	// カート商品削除処理
	//********************
	if(!$isError){

		//削除ボタンが押された場合
		if(isset($_POST['btnDel']) && !empty($_POST['btnDel'])){

			$sql = "
					DELETE
					FROM
					    dt_cart
					WHERE
					    user_id = " . $_SESSION['user_id'] ."
					AND item_id = " . $_POST['item_id'] . "
			";
			$ps = $db->prepare($sql);
			$ret = $ps->execute();

			if(empty($ret)){
				$isError = true;
				$errMsg = "商品のカート内削除に失敗しました。<br>";
			}else{
				$msg = "カートから商品を削除しました。<br>";
			}
		}
	}
	if(!$isError){

		//**********************
		// 購入個数変更処理
		//**********************

		//購入個数変更ボタンが押された場合
		if(isset($_POST['btnUpd']) && !empty($_POST['btnUpd'])){

			foreach($cartDetail as $each){

				//個数変更後の在庫が足りているか確認
				if($each['stock'] < $_POST['item_number']){

					$isError = true;
					$errMsg = "在庫が不足しています。<br>現在の在庫は" . $each['stock'] . "個のみです。<br>
								   再度入力してください。<br>";
				}else{
					$sql = "
							UPDATE
							    dt_cart
							SET
							    item_number = " . $_POST['item_number'] . "
							WHERE
							    item_id = " . $each['item_id'] . " 
							AND user_id = ". $_SESSION['user_id'] . "
					";

					$ps = $db->prepare($sql);
					$ret = $ps->execute();

					if($ret){
						$msg = "購入個数を変更しました。<br>";
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
							    dt_cart.user_id = " . $_SESSION['user_id'] . "
					";
					$ps = $db->prepare($sql);
					$ps->execute();
					$cartDetail = $ps->fetchAll();
				}
			}
		}
	}

	$smarty->assign('isError', $isError);
	$smarty->assign('errMsg', $errMsg);
	$smarty->assign('msg', $msg);
	$smarty->assign('isComplete', $isComplete);
	$smarty->assign('login', $login);
	$smarty->assign('cartDetail', $cartDetail);
	$smarty->assign('ret', $ret);
	$smarty->assign('deposit', $deposit);
	$smarty->assign('history', $history);
	$smarty->display('cart.tpl');
?>