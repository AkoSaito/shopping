<?php
	function moveToCart(){
		if(!isset($_SESSION)){
			session_start();
		}
		if($_SESSION['user_id']){
			$str = "<div align='right'>";
			$str .= "<form action='cart.php' method='POST'>";
			$str .= "<input type='submit' value='カートへ'>";
			$str .= "</form>";
			$str .= "</div>";
		}
		return $str;
	}
?>