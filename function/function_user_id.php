<?php
	//自作関数getUserIdを作成し、$userIdを引数に指定
	function getUserId($userId){
		$db = new PDO('mysql:host=localhost;dbname=db','root','');
		$db->exec('set names utf8');
		$sql = "
				SELECT
				    mst_user_control.user_name,
				    mst_user_control.address,
				    mst_user_control.phone,
				    dt_friend_control.friend_level
				FROM
				    mst_user_control
				    INNER JOIN
				        dt_friend_control
				    ON  mst_user_control.user_id = dt_friend_control.user_id
				WHERE
				    dt_friend_control.friend_id = '" . $userId . "'
				ORDER BY
				    dt_friend_control.friend_level DESC
		";
		$ps = $db->prepare($sql);
		$ps->execute();
		$friendsData = $ps->fetchAll();

		//$friendsDataを返す
		return $friendsData;
	}
?>