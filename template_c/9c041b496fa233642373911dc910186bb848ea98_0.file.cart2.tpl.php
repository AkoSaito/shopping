<?php
/* Smarty version 3.1.30, created on 2018-02-21 09:00:27
  from "C:\xampp\htdocs\sample\templates\cart2.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5a8d271b3337c0_15630600',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '9c041b496fa233642373911dc910186bb848ea98' => 
    array (
      0 => 'C:\\xampp\\htdocs\\sample\\templates\\cart2.tpl',
      1 => 1519200024,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a8d271b3337c0_15630600 (Smarty_Internal_Template $_smarty_tpl) {
?>
<html>
<head>
	<meta http-equiv='Content-Type' content='text/html;charset=utf-8'/>
</head>
<body>
<p><?php echo $_smarty_tpl->tpl_vars['login']->value;?>
</p>
<?php if ($_smarty_tpl->tpl_vars['cartDetail']->value && !$_smarty_tpl->tpl_vars['cartDetail']->value) {?>

		<table>
			<tr>
				<th>商品名</th>
				<th>価格</th>
				<th>個数</th>
				<th>在庫</th>
			</tr>
			<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['cartDetail']->value, 'cart');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['cart']->value) {
?>
				<tr>
					<td><?php echo $_smarty_tpl->tpl_vars['cart']->value['item_name'];?>
</td>
					<td><?php echo $_smarty_tpl->tpl_vars['cart']->value['price'];?>
円</td>
					<td><?php echo $_smarty_tpl->tpl_vars['cart']->value['item_number'];?>
個</td>
					<td><?php echo $_smarty_tpl->tpl_vars['cart']->value['stock'];?>
個</td>
					<form action='cart2.php' method='POST'>
						<td><input type='hidden' name='item_id' value=<?php echo $_smarty_tpl->tpl_vars['cart']->value['item_id'];?>
></td>
						<td><input type='hidden' name='stock' value=<?php echo $_smarty_tpl->tpl_vars['cart']->value['stock'];?>
</td>
						<td><input type='submit' name='btnDel' value='削除'></td>
					</form>
					<form action='cart2.php' method='POST'>
						<td><input type='hidden' name='item_id' value=<?php echo $_smarty_tpl->tpl_vars['cart']->value['item_id'];?>
></td>
						<td><input type='hidden' name='stock' value=<?php echo $_smarty_tpl->tpl_vars['cart']->value['stock'];?>
</td>
						<td><input type='text' name='item_number'>個</td>
						<td><input type='submit' name='btnUpd' value='変更'></td>
					</form>
				</tr>
			<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

		</table>
		
		<form action='cart2.php' method='POST'>
		<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['cartDetail']->value, 'cart');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['cart']->value) {
?>
			<input type='hidden' name='item_id' value=<?php echo $_smarty_tpl->tpl_vars['cart']->value['item_id'];?>
>
			<input type='hidden' name='item_number' value=<?php echo $_smarty_tpl->tpl_vars['cart']->value['item_number'];?>
>
		<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

		<input type='submit' name='btnBuy' value='カート内のアイテムを購入する'><br>
		</form>
	<?php if ($_smarty_tpl->tpl_vars['updDeposit']->value) {?>
		<p><?php echo $_smarty_tpl->tpl_vars['msg']->value;?>
</p>
	<?php }?>

	<?php if ($_smarty_tpl->tpl_vars['ret']->value) {?>
		<p><?php echo $_smarty_tpl->tpl_vars['msg']->value;?>
</p>
	<?php }?>

	<?php if ($_smarty_tpl->tpl_vars['del']->value) {?>
		<p><?php echo $_smarty_tpl->tpl_vars['msg']->value;?>
</p>
	<?php }?>

	<?php if ($_smarty_tpl->tpl_vars['upd']->value) {?>
		<p><?php echo $_smarty_tpl->tpl_vars['msg']->value;?>
</p>
	<?php }?>

<?php } else { ?>
	<?php echo $_smarty_tpl->tpl_vars['errMsg']->value;?>

<?php }
if (!$_smarty_tpl->tpl_vars['cartDetail']->value && $_smarty_tpl->tpl_vars['newCartDetail']->value) {?>
	<table>
			<tr>
				<th>商品名</th>
				<th>価格</th>
				<th>個数</th>
				<th>在庫</th>
			</tr>
			<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['newCartDetail']->value, 'cart');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['cart']->value) {
?>
				<tr>
					<td><?php echo $_smarty_tpl->tpl_vars['cart']->value['item_name'];?>
</td>
					<td><?php echo $_smarty_tpl->tpl_vars['cart']->value['price'];?>
円</td>
					<td><?php echo $_smarty_tpl->tpl_vars['cart']->value['item_number'];?>
個</td>
					<td><?php echo $_smarty_tpl->tpl_vars['cart']->value['stock'];?>
個</td>
				</tr>
			<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

	</table>
	<p><?php echo $_smarty_tpl->tpl_vars['msg']->value;?>
</p>
	<p><?php echo $_smarty_tpl->tpl_vars['errMsg']->value;?>
</p>

<?php }?>
</body>
</html><?php }
}
