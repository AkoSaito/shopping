<html>
<head>
	<meta http-equiv='Content-Type' content='text/html;charset=utf-8'/>
</head>
<body>

{$login}
{$cart}
{$history}

{if $categoryInfo}
	<p>商品を絞り込む<br></p>
	<p>商品カテゴリ</p>

	{* セレクトボックスを作成し、全てのカテゴリーIDとカテゴリー名を表示するまで繰り返す。 *}
	{* その値をPOSTで送信 *}

	<form action='item_list.php' method='POST'>
		<select name='category_id'>
			<option value=''>選択してください</option>
			{foreach from=$categoryInfo item=$item}
				<option value={$item.category_id}>{$item.category_name}</option>
			{/foreach}
		</select>
		<p>商品名</p>

		{* 商品名入力用のテキストボックスを作成し、POSTで送信 *}
		<input type='text' name='item_name'><br>

		{* 並び替え用のラジオボタン作成。labelで一つだけ選べるようにしてPOSTで送信 *}
		<label><input type='radio' name='sort' value='sortCheap'>値段の安い順 </label>
		<label><input type='radio' name='sort' value='sortExpensive'>値段の高い順</label>
		<label><input type='radio' name='sort' value='sortItemName'>商品名順</label><br>
		<input type='submit' value='検索'>
	</form>
{else}
	{* $categoryInfoが受け取れていなかったら *}
	カテゴリーデータがありません。<br>
{/if}

{* $itemInfoの値が受け取れていたら *}
{if $isItemInfo}
	<table border="1">
		<tr>
			<th>商品名</th>
		</tr>
		{* item_detail.phpにリンクを作成し、押されたら商品名を渡す。全商品表示するまで繰り返す。*}
		{foreach from=$itemInfo item=$allItem}
			<tr>
				<td><a href='http://localhost/sample/item_detail.php?item_id={$allItem.item_id}'>{$allItem.item_name}</a></td>
			</tr>
		{/foreach}
	</table>
{else}

	{* $itemInfoのデータがなかったら *}
	商品データがありません。<br>
{/if}

</body>
</html>