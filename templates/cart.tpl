<html>
<head>
	<meta http-equiv='Content-Type' content='text/html;charset=utf-8'/>
</head>
<body>

{$login}
{$history}

{if $cartDetail}
	<table>
		<tr>
			<th>商品名</th>
			<th>価格</th>
			<th>個数</th>
			<th>在庫</th>
		</tr>
		{foreach from=$cartDetail item=$cart}
			<tr>
				<td>{$cart.item_name}</td>
				<td>{$cart.price}円</td>
				<td>{$cart.item_number}個</td>
				<td>{$cart.stock}個</td>

				{* 削除ボタン *}
				<form action='cart.php' method='POST'>
					<td><input type='hidden' name='item_id' value={$cart.item_id}></td>
					<td><input type='submit' name='btnDel' value='削除'></td>
				</form>

				{* 個数変更ボタン *}
				<form action='cart.php' method='POST'>
					<td><input type='text' name='item_number'>個</td>
					<td><input type='submit' name='btnUpd' value='変更'></td>
				</form>
			</tr>
		{/foreach}
	</table>

	{* 購入ボタン *}
	<form action='cart.php' method='POST'>
		<input type='submit' name='btnBuy' value='カート内のアイテムを購入する'><br>
	</form>

{else}
	{$errMsg}
{/if}

{if $cartDetail}
	<table>
		<tr>
			<th>商品名</th>
			<th>価格</th>
			<th>個数</th>
		</tr>
		<tr>
			{foreach from=$cartDetail item=$cart}
				<td>{$cart.item_name}</td>
				<td>{$cart.price}円</td>
				<td>{$cart.item_number}個</td>
			{/foreach}
		</tr>
	</table>
	<p>{$msg}</p>
	<p>{$errMsg}</p>

	{if $isComplete}
		商品購入が正常に行われました。<br>
	{/if}

{/if}
</body>
</html>