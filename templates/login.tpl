<html>
<head>
	<meta http-equiv='Content-Type' content='text/html;charset=utf-8'/>
</head>
<body>

<form action='login.php' method='POST'>
 	<p>ログインして下さい<p>

	{* オートコンプリートをOFFにして候補を出さないようにする *}
	ログインID<input type='text' name='login_id' autocomplete='off' value={$inputId}><br>
	パスワード<input type='text' name='login_pass' autocomplete='off' value={$inputPw}><br>
	<input type='submit' name='btnSubmit' value='ログイン'>
</form>
</body>
</html>
