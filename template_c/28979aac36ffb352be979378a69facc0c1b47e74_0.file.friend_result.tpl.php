<?php
/* Smarty version 3.1.30, created on 2018-01-23 09:31:56
  from "C:\xampp\htdocs\sample\templates\friend_result.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5a66f2fc5572b7_65378860',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '28979aac36ffb352be979378a69facc0c1b47e74' => 
    array (
      0 => 'C:\\xampp\\htdocs\\sample\\templates\\friend_result.tpl',
      1 => 1516693595,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a66f2fc5572b7_65378860 (Smarty_Internal_Template $_smarty_tpl) {
?>
<html>
<head>
	<meta http-equiv='Content-Type' content='text/html;charset=utf-8'/>
</head>
<body>


<?php if ($_smarty_tpl->tpl_vars['isFriendsData']->value) {?>

	<table>
		<tr>
			<th>ユーザ名</th><th>住所</th><th>電話番号</th><th>友達レベル</th>
		</tr>

		
		<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['friendsData']->value, 'info');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['info']->value) {
?>

			
			<tr>
				<td><?php echo $_smarty_tpl->tpl_vars['info']->value['user_name'];?>
</td>
				<td><?php echo $_smarty_tpl->tpl_vars['info']->value['address'];?>
</td>
				<td><?php echo $_smarty_tpl->tpl_vars['info']->value['phone'];?>
</td><td><?php echo $_smarty_tpl->tpl_vars['info']->value['friend_level'];?>
</td>
			</tr>

		
		<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>


	</table>

<?php } else { ?>
	
	友達がいません<br>


<?php }?>

</body>
</html><?php }
}
