<?php
/* Smarty version 3.1.30, created on 2018-02-13 05:30:59
  from "C:\xampp\htdocs\sample\templates\login.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5a826a03a8a950_57220503',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '2454690f00712089d8ce30f6a0fb63db96ea730c' => 
    array (
      0 => 'C:\\xampp\\htdocs\\sample\\templates\\login.tpl',
      1 => 1518491857,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a826a03a8a950_57220503 (Smarty_Internal_Template $_smarty_tpl) {
?>
<html>
<head>
	<meta http-equiv='Content-Type' content='text/html;charset=utf-8'/>
</head>
<body>

<form action='login.php' method='POST'>
 	<p>ログインして下さい<p>

	
	ログインID<input type='text' name='login_id' autocomplete='off' value=<?php echo $_smarty_tpl->tpl_vars['inputId']->value;?>
><br>
	パスワード<input type='text' name='login_pass' autocomplete='off' value=<?php echo $_smarty_tpl->tpl_vars['inputPw']->value;?>
><br>
	<input type='submit' name='btnSubmit' value='ログイン'>
</form>
</body>
</html>
<?php }
}
