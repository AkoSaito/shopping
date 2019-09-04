<?php
/* Smarty version 3.1.30, created on 2018-02-22 04:02:54
  from "C:\xampp\htdocs\sample\templates\item_detail.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5a8e32debb9b44_92668495',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '31122e8b56a3d2d237f004179cba0a01408eb1b9' => 
    array (
      0 => 'C:\\xampp\\htdocs\\sample\\templates\\item_detail.tpl',
      1 => 1519268488,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a8e32debb9b44_92668495 (Smarty_Internal_Template $_smarty_tpl) {
?>
<html>
<head>
	<meta http-equiv='Content-Type' content='text/html;charset=utf-8'/>
</head>
<body>

<?php echo $_smarty_tpl->tpl_vars['login']->value;?>

<?php echo $_smarty_tpl->tpl_vars['cart']->value;?>

<?php echo $_smarty_tpl->tpl_vars['history']->value;?>



<?php if ($_smarty_tpl->tpl_vars['itemDetail']->value) {?>

	
	<table>
		<tr>
			<th>商品名</th>
			<th>商品カテゴリ名</th>
			<th>在庫数</th>
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

	
	<?php if ($_smarty_tpl->tpl_vars['stock']->value > 0) {?>
		<form action='item_buy.php' method='POST'>

			
			<input type='hidden' name='item_id' value=<?php echo $_smarty_tpl->tpl_vars['itemId']->value;?>
>

			<input type='submit' value='カートに入れる'>
		</form>
	<?php } else { ?>
		申し訳ありません。<br>
		ただいま在庫切れです。<br>
	<?php }
} else { ?>
	
	商品の詳細データがありません。<br>
<?php }?>

<body>
</html>
<?php }
}
