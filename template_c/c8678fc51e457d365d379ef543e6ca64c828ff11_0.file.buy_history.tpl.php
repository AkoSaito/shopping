<?php
/* Smarty version 3.1.30, created on 2018-02-23 09:22:27
  from "C:\xampp\htdocs\sample\templates\buy_history.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5a8fcf432d2557_55647402',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c8678fc51e457d365d379ef543e6ca64c828ff11' => 
    array (
      0 => 'C:\\xampp\\htdocs\\sample\\templates\\buy_history.tpl',
      1 => 1519374144,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a8fcf432d2557_55647402 (Smarty_Internal_Template $_smarty_tpl) {
?>
<html>
<head>
	<meta http-equiv='Content-Type' content='text/html;charset=utf-8'/>
</head>
<body>
<?php echo $_smarty_tpl->tpl_vars['login']->value;?>

<?php echo $_smarty_tpl->tpl_vars['cart']->value;?>

<?php if ($_smarty_tpl->tpl_vars['historyDetail']->value) {?>
	<table>
		<tr>
			<th>商品名</th>
			<th>カテゴリー名</th>
			<th>購入個数</th>
			<th>合計金額</th>
			<th>購入日</th>
		</tr>
		<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['historyDetail']->value, 'display');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['display']->value) {
?>
			<tr>
				<td><?php echo $_smarty_tpl->tpl_vars['display']->value['item_name'];?>
</td>
				<td><?php echo $_smarty_tpl->tpl_vars['display']->value['category_name'];?>
</td>
				<td><?php echo $_smarty_tpl->tpl_vars['display']->value['item_number'];?>
</td>
				<td><?php echo $_smarty_tpl->tpl_vars['display']->value['total_price'];?>
</td>
				<td><?php echo $_smarty_tpl->tpl_vars['display']->value['purchase_date'];?>
</td>
			</tr>
		<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

	</table>
<?php } else { ?>
	<?php echo $_smarty_tpl->tpl_vars['errMsg']->value;?>

<?php }?>
</body>
</html><?php }
}
