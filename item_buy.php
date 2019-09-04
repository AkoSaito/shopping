<?php
	require_once('smarty/Smarty.class.php');
	require('databaseinfo/db_init.php');
	require('function/function_login.php');
	require('function/function_cart.php');
	require('function/function_history.php');

	$smarty = new Smarty();
	$smarty->template_dir = './templates/';
	$smarty->compile_dir = './template_c/';

	session_start();

	//SESSIONを受け取れていなければログイン画面に遷移。
	if(!isset($_SESSION['user_name']) || empty($_SESSION['user_name'])){
		header("Location: login.php");
		exit();
	}

	//自作関数を読み込む。
	$login = getLoginSession();
	$cart = moveToCart();
	$history = moveToHistory();

	//elseの先まで通らないように各処理ごとに制御するためフラグを立てるため初期化。
	$isError = false;
	$itemIdErrMsg = "";
	$itemDetail = array();
	$isCartDetail = false;
	$stock = 0;
	$cartDetail = array();
	$cartMsg = "";
	$cartErrMsg = "";
	$itemNumberErrMsg = "";
	$inputItemId = "";

	//$isCompleteを初期化し、INSERT or UPDATEの処理が最後まで送れたか
	//確認するフラグを立てるため初期化
	$isComplete = false;

	if(!isset($_POST['item_id']) || empty($_POST['item_id'])){
		$isError = true;
		$itemIdErrMsg = "不正な遷移です。<br>";
	}else{

		//smarty側にitem_idを送る。
		$inputItemId = $_POST['item_id'];

		$sql = "
				SELECT
				    item_id
				FROM
				    mst_item
				WHERE item_Id = '" . $_POST['item_id'] . "'
		";
		$ps = $db->prepare($sql);
		$ps->execute();
		$itemId = $ps->fetch();

		//mst_idのデータがmst_itemにあるものなら
		if($itemId){
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
					    mst_item.item_id = ". $_POST['item_id'] . "
			";

			$ps = $db->prepare($sql);
			$ps->execute();
			$itemDetail = $ps->fetch();

			//$itemDetailがあれば
			if($itemDetail){

				//$stockにSQLで受け取った在庫数を代入。
				$stock = $itemDetail['stock'];

			}else{
				$isError = true;
				$itemIdErrMsg = "商品データがありません。<br>";
			}
		}
	}

	//購入個数送信ボタンが押されてエラーじゃなければ
	//（カート更新後の商品表示までくくれば、
	//個数を受け取って(ボタンを押して）から２回目という流れになる）

	if(!$isError){
		if(isset($_POST['btnSubmit']) && !empty($_POST['btnSubmit'])){

			if(!isset($_POST['item_number']) || empty($_POST['item_number'])){

				//購入個数が受けていなければ
				$isError = true;
				$itemNumberErrMsg = "購入個数を入力してください。<br>";

			}else{

				//item_numberが受け取れたら
				if(preg_match("/[^0-9]/", $_POST['item_number'])){

					//数字以外が含まれていたら
					$isError = true;
					$itemNumberErrMsg = "個数は半角数字で入力してください。<br>";

				}else{

					//数字が受け取れたら
					if($_POST['item_number'] > $stock){

						//在庫以上なら
						$isError = true;
						$itemNumberErrMsg = "在庫は残り" . $stock . "個のみです。<br>" .
											"再度入力してください。<br>";
					}else{

						//在庫より購入個数が少なければ

						$sql = "
								SELECT
								    *
								FROM
								    dt_cart
								WHERE
								    item_id = " . $_POST['item_id'] . "
								AND
								    user_id = " . $_SESSION['user_id'] . "
						";

						$ps = $db->prepare($sql);
						$ps->execute();
						$itemIdInCart = $ps->fetch();

						if($itemIdInCart){
							$sql = "
									UPDATE
									    dt_cart
									SET
									    item_number = " . $_POST['item_number'] . "
									WHERE
									    item_id = " . $_POST['item_id'] . "
									AND user_id = " . $_SESSION['user_id'] . "
							";
							$ps = $db->prepare($sql);
							$resultUpd = $ps->execute();

							//executeの値が取れたか確認
							if($resultUpd){
								$isComplete = true;
								$cartMsg = "カートを更新しました。<br>";
							}else{
								$isError = true;
								$cartErrMsg = "カートを更新できませんでした。br>";
							}
						}else{

							//もしもカートにそのIDがなければINSERTで追加
							$sql = "
									INSERT INTO dt_cart(
									    user_id,
									    item_id,
									    item_number
									)
									VALUES(
									    " . $_SESSION['user_id'] . ",
									    " . $_POST['item_id'] . ",
									   " . $_POST['item_number'] . "
									)
							";
							$ps = $db->prepare($sql);
							$resultInsert = $ps->execute();

							if($resultInsert){
								$isComplete = true;
								$cartMsg = "カートを追加しました。<br>";
							}else{
								$isError = true;
								$cartErrMsg = "カートを追加できませんでした。<br>";
							}
						}

						//カートに追加した商品の中身を表示
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
								    dt_cart.item_id = " . $_POST['item_id'] . "
								AND dt_cart.user_id = " . $_SESSION['user_id'] . "
								AND dt_cart.item_number = " . $_POST['item_number'] . "
						";
						$ps = $db->prepare($sql);
						$ps->execute();
						$cartDetail = $ps->fetch();

						//$cartDetailがあればtrue
						if($cartDetail){
							$isCartDetail = true;
						}
					}
				}
			}
		}
	}

	$smarty->assign('login', $login);
	$smarty->assign('isError', $isError);
	$smarty->assign('itemId', $itemId);
	$smarty->assign('itemIdErrMsg', $itemIdErrMsg);
	$smarty->assign('itemNumberErrMsg', $itemNumberErrMsg);
	$smarty->assign('cartMsg', $cartMsg);
	$smarty->assign('cartErrMsg', $cartErrMsg);
	$smarty->assign('inputItemId', $inputItemId);
	$smarty->assign('itemDetail', $itemDetail);
	$smarty->assign('cartDetail', $cartDetail);
	$smarty->assign('isCartDetail', $isCartDetail);
	$smarty->assign('isComplete', $isComplete);
	$smarty->assign('cart', $cart);
	$smarty->assign('history', $history);
	$smarty->display('item_buy.tpl');
?>