<html>
<head>
	<meta http-equiv='Content-Type' content='text/html;charset=utf-8'/>
</head>
<body>
{* $userInfoが取得できているか確認。 *}
{if $isData}

	<form action='friend_result.php' method='POST'>
		<select name='user_id'>
			<option value=''>ユーザ名を選択してください</option>

	{* $useInfoを$userに代入しuser_idを全員分表示するまで繰り返す。 *}
	{foreach from=$userInfo item=$user}

			<option value={$user.user_id}>{$user.user_id}</option>
		
	{* foreachの閉じかっこ *}
	{/foreach}

		</select>
	<input type='submit' value='選択'>
	</form>

{else}

	{* userInfoが取得できていなければ *}
	データがありません<br>

{* ifの閉じかっこ *}
{/if}

</body>
</html>