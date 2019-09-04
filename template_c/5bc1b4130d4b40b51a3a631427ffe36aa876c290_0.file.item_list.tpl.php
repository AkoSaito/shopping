<?php
/* Smarty version 3.1.30, created on 2018-03-07 07:48:51
  from "C:\xampp\htdocs\sample\templates\item_list.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5a9f8b532d2133_14539056',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '5bc1b4130d4b40b51a3a631427ffe36aa876c290' => 
    array (
      0 => 'C:\\xampp\\htdocs\\sample\\templates\\item_list.tpl',
      1 => 1520390798,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a9f8b532d2133_14539056 (Smarty_Internal_Template $_smarty_tpl) {
?>
<html>
<head>
	<meta http-equiv='Content-Type' content='text/html;charset=utf-8'/>
</head>
<body>

<?php echo $_smarty_tpl->tpl_vars['login']->value;?>

<?php echo $_smarty_tpl->tpl_vars['cart']->value;?>

<?php echo $_smarty_tpl->tpl_vars['history']->value;?>


<?php if ($_smarty_tpl->tpl_vars['categoryInfo']->value) {?>
	<p>商品を絞り込む<br></p>
	<p>商品カテゴリ</p>

	
	

	<form action='item_list.php' method='POST'>
		<select name='category_id'>
			<option value=''>選択してください</option>
			<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['categoryInfo']->value, 'item');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
?>
				<option value=<?php echo $_smarty_tpl->tpl_vars['item']->value['category_id'];?>
><?php echo $_smarty_tpl->tpl_vars['item']->value['category_name'];?>
</option>
			<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

		</select>
		<p>商品名</p>

		
		<input type='text' name='item_name'><br>

		
		<label><input type='radio' name='sort' value='sortCheap'>値段の安い順 </label>
		<label><input type='radio' name='sort' value='sortExpensive'>値段の高い順</label>
		<label><input type='radio' name='sort' value='sortItemName'>商品名順</label><br>
		<input type='submit' value='検索'>
	</form>
<?php } else { ?>
	
	カテゴリーデータがありません。<br>
<?php }?>


<?php if ($_smarty_tpl->tpl_vars['isItemInfo']->value) {?>
	<table border="1">
		<tr>
			<th>商品名</th>
		</tr>
		
		<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['itemInfo']->value, 'allItem');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['allItem']->value) {
?>
			<tr>
				<td><a href='http://localhost/sample/item_detail.php?item_id=<?php echo $_smarty_tpl->tpl_vars['allItem']->value['item_id'];?>
'><?php echo $_smarty_tpl->tpl_vars['allItem']->value['item_name'];?>
</a></td>
			</tr>
		<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

	</table>
<?php } else { ?>

	
	商品データがありません。<br>
<?php }?>

</body>
</html><?php }
}
