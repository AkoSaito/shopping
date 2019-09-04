<html>
<head>
	<meta http-equiv='Content-Type' content='text/html;charset=utf-8'/>
</head>
<body>
{$login}
{$cart}

{if $historyDetail}
	<table>
		<tr>
			<th>商品名</th>
			<th>カテゴリー名</th>
			<th>購入個数</th>
			<th>合計金額</th>
			<th>購入日</th>
		</tr>
		{foreach from=$historyDetail item=$display}
			<tr>
				<td>{$display.item_name}</td>
				<td>{$display.category_name}</td>
				<td>{$display.item_number}</td>
				<td>{$display.total_price}</td>
				<td>{$display.purchase_date}</td>
			</tr>
		{/foreach}
	</table>
{else}
	{$errMsg}
{/if}
</body>
</html>