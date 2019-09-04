<?php
	function getLoginSession(){

		if(!isset($_SESSION)){

			//sessionを開始
			session_start();
		}

		//$_SESSION['user_name']が受け取れていれば
		if(isset($_SESSION['user_name'])){

			//alignで右寄せにしてユーザー名表示
			$str = "<div align='right'>";
			$str .= "ログイン済みです<br>";
			$str .= $_SESSION['user_name'] . "さん";
			$str .= "</div>";
		}else{

			//受け取れていなければログインボタンを表示
			$str = "<div align='right'>";
			$str .= "ログインしてください<br>";
			$str .= "<form action='login.php' method='POST'>";
			$str .= "<input type='submit' value='ログイン'>";
			$str .= "</form>";
			$str .= "</div>";
		}
		return $str;
	}
?>