<html>
<head>
	<meta http-equiv='Content-Type' content='text/html;charset=utf-8'/>
</head>
<body>

{$login}
{$cart}
{$history}

{* $itemDetailの値が受け取れているか確認 *}
{if $itemDetail}

	{* tableタグで表示 *}
	<table>
		<tr>
			<th>商品名</th>
			<th>商品カテゴリ名</th>
			<th>在庫数</th>
			<th>値段</th>
		</tr>
		<tr>

			{* $itemDetailの値を表示 *}
			<td>{$itemDetail.item_name}</td>
			<td>{$itemDetail.category_name}</td>
			<td>{$itemDetail.stock}</td>
			<td>{$itemDetail.price}</td>
		</tr>
	</table>

	{* $stockが0より多いなら *}
	{if $stock > 0}
		<form action='item_buy.php' method='POST'>

			{* hiddenでitem_buy.phpに$itemIdを渡す *}
			<input type='hidden' name='item_id' value={$itemId}>

			<input type='submit' value='カートに入れる'>
		</form>
	{else}
		申し訳ありません。<br>
		ただいま在庫切れです。<br>
	{/if}
{else}
	{* itemDetailの値がなければ *}
	商品の詳細データがありません。<br>
{/if}

<body>
</html>
