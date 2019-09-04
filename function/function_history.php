<?php
	function moveToHistory(){
		if(!isset($_SESSION)){
			session_start();
		}
		if($_SESSION['user_id']){
			$str = "<div align='right'>";
			$str .= "<form action='buy_history.php' method='POST'>";
			$str .= "<input type='submit' value='購入履歴へ'>";
			$str .= "</form>";
			$str .= "</div>";
		}
		return $str;
	}
?>