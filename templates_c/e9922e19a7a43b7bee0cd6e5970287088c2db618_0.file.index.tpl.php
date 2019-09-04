<?php
/* Smarty version 3.1.30, created on 2018-01-22 01:45:55
  from "C:\xampp\htdocs\sample\templates\index.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5a6534433e6382_91805034',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'e9922e19a7a43b7bee0cd6e5970287088c2db618' => 
    array (
      0 => 'C:\\xampp\\htdocs\\sample\\templates\\index.tpl',
      1 => 1516581266,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a6534433e6382_91805034 (Smarty_Internal_Template $_smarty_tpl) {
?>
<html>
<head>
	<meta charset="UTF-8">
	<title>Smartyテスト</title>
</head>
<body>
	私の名前は<br/>
	<?php echo $_smarty_tpl->tpl_vars['name']->value;?>
<br/>
	です。
</body>
</html><?php }
}
