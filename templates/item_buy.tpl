<html>
<head>
	<meta http-equiv='Content-Type' content='text/html;charset=utf-8'/>
</head>
<body>

{$login}
{$cart}
{$history}

{if $itemIdErrMsg}
	<p>{$itemIdErrMsg}<p>
{/if}

{if $itemDetail}

	{* tableタグで一覧を表示 *}
	<table>
		<tr>
			<th>商品名</th>
			<th>カテゴリー名</th>
			<th>在庫</th>
			<th>値段</th>
		</tr>
		<tr>
			<td>{$itemDetail.item_name}</td>
			<td>{$itemDetail.category_name}</td>
			<td>{$itemDetail.stock}</td>
			<td>{$itemDetail.price}</td>
		</tr>
	</table>
	<form action='item_buy.php' method='POST'>

		{* 個数を送る際に$itemIdもitem_buy.phpに送る *}
		<input type='hidden' name='item_id' value={$inputItemId}>
		カートに入れる個数を入力してください。<br>
		<input type='text' name='item_number'>個
		<input type='submit' name='btnSubmit' value='送信'>
	</form>
	
	{if $isCartDetail}
		カートに追加されました。<br>
	{else}
		カート処理確認中。<br>
	{/if}

{else}
	カートに商品がありません。<br>
{/if}
{if $itemNumberErrMsg}
	<p>{$itemNumberErrMsg}</p>
{/if}
{if $cartDetail}

	{* cartに入れた商品の詳細を表示 *}
	<table>
		<tr>
			<th>商品名</th>
			<th>購入個数</th>
			<th>価格</th>
		</tr>
		<tr>
			<td>{$cartDetail.item_name}</td>
			<td>{$cartDetail.item_number}</td>
			<td>{$cartDetail.price}</td>
		</tr>
	</table>
	
{/if}
{if $cartMsg}
		<p>{$cartMsg}</p>
{/if}

{if $cartErrMsg}
	<p>{$cartErrMsg}</p>
{/if}

{if $isComplete}
	<p>カート処理が正常に行われました。<br>
{/if}

</body>
</html>