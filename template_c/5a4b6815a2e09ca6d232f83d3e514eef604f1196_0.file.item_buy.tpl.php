<?php
/* Smarty version 3.1.30, created on 2018-02-22 04:05:41
  from "C:\xampp\htdocs\sample\templates\item_buy.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5a8e33851fb1f6_08290409',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '5a4b6815a2e09ca6d232f83d3e514eef604f1196' => 
    array (
      0 => 'C:\\xampp\\htdocs\\sample\\templates\\item_buy.tpl',
      1 => 1519268643,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a8e33851fb1f6_08290409 (Smarty_Internal_Template $_smarty_tpl) {
?>
<html>
<head>
	<meta http-equiv='Content-Type' content='text/html;charset=utf-8'/>
</head>
<body>

<?php echo $_smarty_tpl->tpl_vars['login']->value;?>

<?php echo $_smarty_tpl->tpl_vars['cart']->value;?>

<?php echo $_smarty_tpl->tpl_vars['history']->value;?>


<?php if ($_smarty_tpl->tpl_vars['itemIdErrMsg']->value) {?>
	<p><?php echo $_smarty_tpl->tpl_vars['itemIdErrMsg']->value;?>
<p>
<?php }?>

<?php if ($_smarty_tpl->tpl_vars['itemDetail']->value) {?>

	
	<table>
		<tr>
			<th>商品名</th>
			<th>カテゴリー名</th>
			<th>在庫</th>
			<th>値段</th>
		</tr>
		<tr>
			<td><?php echo $_smarty_tpl->tpl_vars['itemDetail']->value['item_name'];?>
</td>
			<td><?php echo $_smarty_tpl->tpl_vars['itemDetail']->value['category_name'];?>
</td>
			<td><?php echo $_smarty_tpl->tpl_vars['itemDetail']->value['stock'];?>
</td>
			<td><?php echo $_smarty_tpl->tpl_vars['itemDetail']->value['price'];?>
</td>
		</tr>
	</table>
	<form action='item_buy.php' method='POST'>

		
		<input type='hidden' name='item_id' value=<?php echo $_smarty_tpl->tpl_vars['inputItemId']->value;?>
>
		カートに入れる個数を入力してください。<br>
		<input type='text' name='item_number'>個
		<input type='submit' name='btnSubmit' value='送信'>
	</form>
	
	<?php if ($_smarty_tpl->tpl_vars['isCartDetail']->value) {?>
		カートに追加されました。<br>
	<?php } else { ?>
		カート処理確認中。<br>
	<?php }?>

<?php } else { ?>
	カートに商品がありません。<br>
<?php }
if ($_smarty_tpl->tpl_vars['itemNumberErrMsg']->value) {?>
	<p><?php echo $_smarty_tpl->tpl_vars['itemNumberErrMsg']->value;?>
</p>
<?php }
if ($_smarty_tpl->tpl_vars['cartDetail']->value) {?>

	
	<table>
		<tr>
			<th>商品名</th>
			<th>購入個数</th>
			<th>価格</th>
		</tr>
		<tr>
			<td><?php echo $_smarty_tpl->tpl_vars['cartDetail']->value['item_name'];?>
</td>
			<td><?php echo $_smarty_tpl->tpl_vars['cartDetail']->value['item_number'];?>
</td>
			<td><?php echo $_smarty_tpl->tpl_vars['cartDetail']->value['price'];?>
</td>
		</tr>
	</table>
	
<?php }
if ($_smarty_tpl->tpl_vars['cartMsg']->value) {?>
		<p><?php echo $_smarty_tpl->tpl_vars['cartMsg']->value;?>
</p>
<?php }?>

<?php if ($_smarty_tpl->tpl_vars['cartErrMsg']->value) {?>
	<p><?php echo $_smarty_tpl->tpl_vars['cartErrMsg']->value;?>
</p>
<?php }?>

<?php if ($_smarty_tpl->tpl_vars['isComplete']->value) {?>
	<p>カート処理が正常に行われました。<br>
<?php }?>

</body>
</html><?php }
}
