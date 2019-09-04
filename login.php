<?php
	require_once('smarty/Smarty.class.php');
	require('databaseinfo/db_init.php');

	$smarty = new Smarty();
	$smarty->template_dir = './templates/';
	$smarty->compile_dir = './template_c/';

	$isError = false;
	//「ログインボタンが押されたか確認
	if(isset($_POST['btnSubmit']) && !empty($_POST['btnSubmit'])){

		//ログインIDが空なら
		if(!isset($_POST['login_id']) || empty($_POST['login_id'])){

			echo "ログインIDを入力してください。<br>";
			$isError = true;
		}elseif(!isset($_POST['login_id']) || empty($_POST['login_pass'])){

			//パスワードが空なら
			echo "パスワードを入力してください<br>";
			$isError = true;
		}
	}
	$loginId = "";
	$pass = "";
	if(!$isError){

		//ログインIDとパスワードがセットされて空じゃなければ
		if(isset($_POST['login_id']) && !empty($_POST['login_id']) && 
		   isset($_POST['login_pass']) && !empty($_POST['login_pass'])){

		//ログインIDとパスワードのタグを無効化
		$loginId = htmlspecialchars($_POST['login_id'], ENT_QUOTES);
		$pass = htmlspecialchars($_POST['login_pass'], ENT_QUOTES);

		$sql = "
				SELECT
				    *
				FROM
				    mst_user
				WHERE
				    login_id = '" . $loginId . "'
		";

		$ps = $db->prepare($sql);
		$ps->execute();
		$loginInfo = $ps->fetch();

		//もし$loginInfoが空じゃなければ
		if(!empty($loginInfo)){

			//$loginInfo['login_pass']が暗号化したパスワードと同じなら
			if($loginInfo['login_pass'] == md5($pass)){

				//ログインできる状態になったらsession_start();をする。
				session_start();

				//セッションにSQLで受け取ったuser_nameとuser_idを代入
				$_SESSION['user_name'] = $loginInfo['user_name'];
				$_SESSION['user_id'] = $loginInfo['user_id'];

				//item_list.phpに遷移し終了
				header('Location: item_list.php');
				exit();
			}else{

				//暗号化したパスワードと同じじゃなければ
				echo "パスワードが違います。<br>";
			}
		}else{

			//$loginInfoが空だったら
			echo "このログインIDは存在しません。<br>";
		}
		}
	}

	$inputId = "";
	$inputPw = "";

	//login_idとlogin_passをsmarty側に送り、エラーになった際も
	//入力したものが画面残るようにする。

	if(isset($_POST['login_id']) && !empty($_POST['login_id'])){
	   $inputId = $_POST['login_id'];
	}
	if(isset($_POST['login_pass']) && !empty($_POST['login_pass'])){
	   $inputPw = $_POST['login_pass'];
	}

	$smarty->assign('inputId', $inputId);
	$smarty->assign('inputPw', $inputPw);
	$smarty->display('login.tpl');
?>
