<?php
/* Smarty version 3.1.30, created on 2018-02-23 09:29:33
  from "C:\xampp\htdocs\sample\templates\cart.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5a8fd0ed5f1513_21306662',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '8307c55e50e4facd47617638a6e3901859345f07' => 
    array (
      0 => 'C:\\xampp\\htdocs\\sample\\templates\\cart.tpl',
      1 => 1519374293,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a8fd0ed5f1513_21306662 (Smarty_Internal_Template $_smarty_tpl) {
?>
<html>
<head>
	<meta http-equiv='Content-Type' content='text/html;charset=utf-8'/>
</head>
<body>

<?php echo $_smarty_tpl->tpl_vars['login']->value;?>

<?php echo $_smarty_tpl->tpl_vars['history']->value;?>


<?php if ($_smarty_tpl->tpl_vars['cartDetail']->value) {?>
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

				
				<form action='cart.php' method='POST'>
					<td><input type='hidden' name='item_id' value=<?php echo $_smarty_tpl->tpl_vars['cart']->value['item_id'];?>
></td>
					<td><input type='submit' name='btnDel' value='削除'></td>
				</form>

				
				<form action='cart.php' method='POST'>
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

	
	<form action='cart.php' method='POST'>
		<input type='submit' name='btnBuy' value='カート内のアイテムを購入する'><br>
	</form>

<?php } else { ?>
	<?php echo $_smarty_tpl->tpl_vars['errMsg']->value;?>

<?php }?>

<?php if ($_smarty_tpl->tpl_vars['cartDetail']->value) {?>
	<table>
		<tr>
			<th>商品名</th>
			<th>価格</th>
			<th>個数</th>
		</tr>
		<tr>
			<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['cartDetail']->value, 'cart');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['cart']->value) {
?>
				<td><?php echo $_smarty_tpl->tpl_vars['cart']->value['item_name'];?>
</td>
				<td><?php echo $_smarty_tpl->tpl_vars['cart']->value['price'];?>
円</td>
				<td><?php echo $_smarty_tpl->tpl_vars['cart']->value['item_number'];?>
個</td>
			<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

		</tr>
	</table>
	<p><?php echo $_smarty_tpl->tpl_vars['msg']->value;?>
</p>
	<p><?php echo $_smarty_tpl->tpl_vars['errMsg']->value;?>
</p>

	<?php if ($_smarty_tpl->tpl_vars['isComplete']->value) {?>
		商品購入が正常に行われました。<br>
	<?php }?>

<?php }?>
</body>
</html><?php }
}
