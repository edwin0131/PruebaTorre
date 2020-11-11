<?php

require_once("cors.php");
$method = $_SERVER['REQUEST_METHOD'];


if ($method == 'GET')
{
	$path = $_GET['path'];
	switch ($path){
		case 'USER':
			$usu = $_GET['username'];
			$url = "https://bio.torre.co/api/bios/".$usu;
		break;
		case 'JOB':
			$job = $_GET['job'];
			$url = "https://torre.co/api/opportunities/".$job;
		break;
	}

	$data = file_get_contents($url);
	$json = json_encode($data);
	echo $json;
}
if ($method == 'POST')
{
	$data = json_decode(file_get_contents("php://input"), true);
	
	$postData = array(
		'offset' => $data["offset"],
		'size' => $data["size"],
		'aggregate' => $data["aggregate"]
	);
	echo $data["offset"];
	
	// Create the context for the request
	$context = stream_context_create(array(
		'http' => array(
			'method' => 'POST',
			'header' => "Authorization: application/json\r\n".
				"Content-Type: application/json\r\n",
			'content' => json_encode($postData)
		)
	));
	
	$response = file_get_contents('https://search.torre.co/opportunities/_search/', FALSE, $context);
	
	if($response === FALSE){
		die('Error');
	}
	
	$json = json_encode($response);
	echo $json;
}	
?>