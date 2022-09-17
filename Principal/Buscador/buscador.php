<?php
	header('Content-Type: text/html; charset=utf-8');
	include("Config/config.php");
	$area = $_POST['data']['area'];
	$busca = $_POST['data']['buscar'];
	if(isset($area) and $area == "mercado_livre"){
		ml();
	}
	else{
		amazon();
	}

	function ml(){
		global $python, $busca;
		$busca = str_replace(" ", "-", $busca);
		$res = exec("$python Principal/Buscador/Python/WebScraping.py $busca mercado_livre");
		print($res);
		sleep(1);
	}

	function amazon(){
		global $python, $busca;
		$res = exec("$python Principal/Buscador/Python/WebScraping.py $busca amazon");
		print($res);
		sleep(1);
	}
?>
