<?php
require 'flight/Flight.php';
require 'include/kan.php';

/**
*	Router list
*/

Flight::route('/', function(){
    echo 'This is MoeKancolle Backend.';
});

Flight::route('/kan/recipe/@id',function($id) {
	$kan = Flight::kan();
	$recipes = $kan->getRecipes((int)$id);
	echo Flight::json($recipes);
});

Flight::route('/kan/all',function() {
	$kan = Flight::kan();
	$all = $kan->getAllKan();
	header('Access-Control-Allow-Origin: *');
	echo Flight::json($all);
});

Flight::route('/kan/names',function() {
	$kan = Flight::kan();
	$all = $kan->getKanNames();
	header('Access-Control-Allow-Origin: *');
	echo Flight::json($all);
});

Flight::route('/profile',function() {
	$kan = Flight::kan();
	$profile = $kan->getProfile();
	header('Access-Control-Allow-Origin: *');
	echo Flight::json($profile);
});

Flight::register('db', 'PDO', array('mysql:host=localhost;dbname=kancolle_wiki','root','nishixian'), function($db){
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->exec("SET NAMES 'UTF8'");
});

Flight::register('kan','Kan');

// App start
Flight::start();
