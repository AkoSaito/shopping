<?php
/* Smarty version 3.1.30, created on 2018-01-24 06:24:59
  from "C:\xampp\htdocs\sample\templates\user_select.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5a6818ab453215_53128373',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '7b6697fdaf0246626ef0f6631e1bbf60b60261a8' => 
    array (
      0 => 'C:\\xampp\\htdocs\\sample\\templates\\user_select.tpl',
      1 => 1516771466,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a6818ab453215_53128373 (Smarty_Internal_Template $_smarty_tpl) {
?>
<html>
<head>
	<mata http-equiv='Content-Type' content='text/html;charset=utf-8'/>
</head>
<body>

<?php if ($_smarty_tpl->tpl_vars['isData']->value) {?>

	<form action='friend_result.php' method='POST'>
		<select name='user_id'>
			<option value=''>ユーザ名を選択してください</option>

	
	<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['userInfo']->value, 'user');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['user']->value) {
?>

			<option value=<?php echo $_smarty_tpl->tpl_vars['user']->value['user_id'];?>
><?php echo $_smarty_tpl->tpl_vars['user']->value['user_id'];?>
</option>
		
	
	<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>


		</select>
	<input type='submit' value='選択'>
	</form>

<?php } else { ?>

	
	データがありません<br>


<?php }?>

</body>
</html><?php }
}
