<?php
/* Smarty version 3.1.30, created on 2018-02-01 08:03:25
  from "C:\xampp\htdocs\sample\templates\item_list2.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5a72bbbdafefb6_24503890',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '2b59a273962e3e055bf240b70863510ae64d5971' => 
    array (
      0 => 'C:\\xampp\\htdocs\\sample\\templates\\item_list2.tpl',
      1 => 1517468603,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a72bbbdafefb6_24503890 (Smarty_Internal_Template $_smarty_tpl) {
?>
<html>
<head>
	<meta http-equiv ='Content-Type' content='text/html;charset=utf-8'/>
</head>
<body>
	<?php if ($_smarty_tpl->tpl_vars['isCategoryInfo']->value) {
echo var_dump($_smarty_tpl->tpl_vars['isCategoryInfo']->value);?>

		<p>商品を絞り込む<br></p>
		<p>商品カテゴリ</p>
		<form action='item_list2.php' method='POST'>
			<select name ='category_id'>
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
			<input type='submit' value='選択'>

			<p>商品名</p>
			<input type='text' name='item_name'>
			<input type='submit' name='検索'><br>
			
			<label><input type='radio' name='sort' value='sortCheap' checked>値段の安い順 </label>
			<label><input type='radio' name='sort' value='sortExpensive'>値段の高い順</label>
			<label><input type='radio' name='sort' value='sortItemName'>商品名順</label>
			<input type='submit' name='並び替え'>
	
	<?php } else { ?>
		カテゴリーデータがありません。<br>
	<?php }?>
	</form>
	<?php if ($_smarty_tpl->tpl_vars['isItemInfo']->value) {
echo var_dump($_smarty_tpl->tpl_vars['isItemInfo']->value);?>

		<ul>
			<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['itemInfo']->value, 'allItem');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['allItem']->value) {
?>
				<li><a href='http://localhost/item_detail.php'></li>
				<li><?php echo $_smarty_tpl->tpl_vars['allItem']->value['item_name'];?>
</li>
			<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

		</ul>
	
	<?php } else { ?>
		商品データがありません。<br>
<?php }?>
</body>
</html><?php }
}
