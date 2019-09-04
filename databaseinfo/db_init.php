<?php
$SERV = "localhost";
$USER = "test";
$PASS = "test";
$DBNM = "db";
$dsn = "mysql:host=$SERV;dbname=$DBNM;charset=utf8";
$db = new PDO(
	$dsn,
	$USER,
	$PASS,
	[
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
	]);
$db->exec('SET NAMES utf8');
$db->setAttribute(PDO::ATTR_AUTOCOMMIT,true);
$db->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
$db->setAttribute(PDO::ATTR_STRINGIFY_FETCHES,false);
?>
