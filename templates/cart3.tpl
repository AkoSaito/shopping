<html>
<head>
	<meta http-equiv='Content-Type' content='text/html;charset=utf-8'/>
</head>
<body>
{$arrBinder['login']}
{$arrBinder['history']}
{if $arrBinder['cartDetail']}
	
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
					<td>{$cart.item_id}個</td>
					<td>{$cart.stock}個</td>
					<form action='cart.php' method='POST'>
						<td><input type='submit' name='btnDel' value='削除'></td>
						<td><input type='hidden' name='item_id' value={$cart.item_id}></td>
						<td><input type='hidden' name='stock' value={$cart.stock}</td>
					</form>
					<form action='cart.php' method='POST'>
						<td><input type='hidden' name='item_id' value={$updItemId}></td>
						<td><input type='text' name='item_number'>個</td>
						<td><input type='submit' name='btnUpd' value='変更'></td>
					</form>
				</tr>
			{/foreach}
		</table>
		
		<form action='cart.php' method='POST'>
			{foreach from=$arrBinder['cartDetail'] item=$cart}
				<input type='hidden' name='item_id' value={$cart.item_id}>
				<input type='hidden' name='item_number' value={$cart.item_number}>
			{/foreach}
			<input type='submit' name='btnBuy' value='カート内のアイテムを購入する'><br>
		</form>

{else}
	{$arrBinder['errMsg']}
{/if}
{if $arrBinder['cartDetail']}
	<table>
			<tr>
				<th>商品名</th>
				<th>価格</th>
				<th>個数</th>
				<th>在庫</th>
			</tr>
			{foreach from=$arrBinder['cartDetail'] item=$cart}
				<tr>
					<td>{$cart.item_name}</td>
					<td>{$cart.price}円</td>
					<td>{$cart.item_number}個</td>
					<td>{$cart.stock}個</td>
				</tr>
			{/foreach}
	</table>
	<p>{$arrBinder['msg']}</p>
	<p>{$arrBinder['errMsg']}</p>
{/if}
</body>
</html>