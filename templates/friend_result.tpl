<html>
<head>
	<meta http-equiv='Content-Type' content='text/html;charset=utf-8'/>
</head>
<body>

{* $isFriendsDataが取得できていれば *}
{if $isFriendsData}

	<table>
		<tr>
			<th>ユーザ名</th><th>住所</th><th>電話番号</th><th>友達レベル</th>
		</tr>

		{* $friendsDataを$infoに代入して全員分表示するまで繰り返す *}
		{foreach from=$friendsData item=$info}

			{* 連想配列はドットで記載 *}
			<tr>
				<td>{$info.user_name}</td>
				<td>{$info.address}</td>
				<td>{$info.phone}</td><td>{$info.friend_level}</td>
			</tr>

		{* foreachの閉じかっこ *}
		{/foreach}

	</table>

{else}
	{* $isFriendsDataが取得できていなければ *}
	友達がいません<br>

{*ifの閉じかっこ*}
{/if}

</body>
</html>