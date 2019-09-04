<?php
	//自作関数getUserInfoを作成
	function getUserInfo(){
		$db = new PDO('mysql:host=localhost;dbname=db','root','');
		$db->exec('set names utf8');
		$sql = "
				SELECT
				    *
				FROM
				    mst_user_control
				ORDER BY
				    user_id
		";
		$ps = $db->prepare($sql);
		$ps->execute();
		$userInfo = $ps->fetchAll();

		//$userInfoを返す
		return $userInfo;
	}
?>
