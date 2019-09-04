<?php  
	require_once("smarty/Smarty.class.php");
	$smarty = new Smarty;
	$smarty->template_dir = "templates";
	$smarty->compile_dir = "templates_c";
	$smarty->assign("name","MISHIMA");
	//ディスプレイ表示
	$smarty->display("index.tpl");
	?>