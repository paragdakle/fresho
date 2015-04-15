<?php

//Users
$app->get("/render/getUsers", function() use ($app){
	$app->render("showUsers.php");
});

$app->get("/settings/getUsers", function() {
	$ret = [];
	$ret["status"] = 200;
	
	$db = new MongoWrapperClass("fresho", "user");

    $users = $db->get(array("password" => 0, "_id" => 0));
    if($users !== null) {
        $ret["users"] = iterator_to_array($users);
    }
    else {
		$ret["users"] = "No users found";
	}
	echo json_encode($ret);
});

//Orders
$app->get("/render/getOrders", function() use ($app){
	$app->render("showOrders.php");
});

$app->get("/settings/getOrders", function() {
	$ret = [];
	$ret["status"] = 200;
	
	$db = new MongoWrapperClass("fresho", "order");

    $orders = $db->get(array("_id" => 0));
    if($orders !== null) {
        $ret["orders"] = iterator_to_array($orders);
    }
    else {
		$ret["orders"] = "No Orders found";
	}
	echo json_encode($ret);
});

//Vendors
$app->get("/render/getVendors", function() use ($app){
	$app->render("showVendors.php");
});

$app->get("/settings/getVendors", function() {
	$ret = [];
	$ret["status"] = 200;
	
	$db = new MongoWrapperClass("fresho", "vendor");

    $vendors = $db->get(array("_id" => 0));
    if($vendors !== null) {
        $ret["vendors"] = iterator_to_array($vendors);
    }
    else {
		$ret["vendors"] = "No vendors found";
	}
	echo json_encode($ret);
});

//Fruits
$app->get("/render/getFruits", function() use ($app){
	$app->render("showFruits.php");
});

$app->get("/settings/getFruits", function() {
	$ret = [];
	$ret["status"] = 200;
	
	$db = new MongoWrapperClass("fresho", "fruit");

    $fruits = $db->get(array("_id" => 0));
    if($fruits !== null) {
        $ret["fruits"] = iterator_to_array($fruits);
    }
    else {
		$ret["fruits"] = "No fruits found";
	}
	echo json_encode($ret);
});

//Juices
$app->get("/render/getJuices", function() use ($app){
	$app->render("showJuices.php");
});

$app->get("/settings/getJuices", function() {
	$ret = [];
	$ret["status"] = 200;
	
	$db = new MongoWrapperClass("fresho", "juice");

    $juices = $db->get(array("_id" => 0));
    if($juices !== null) {
        $ret["juices"] = iterator_to_array($juices);
    }
    else {
		$ret["juices"] = "No juices found";
	}
	echo json_encode($ret);
});

//Salads
$app->get("/render/getSalads", function() use ($app){
	$app->render("showSalads.php");
});

$app->get("/settings/getSalads", function() {
	$ret = [];
	$ret["status"] = 200;
	
	$db = new MongoWrapperClass("fresho", "salad");

    $salads = $db->get(array("_id" => 0));
    if($salads !== null) {
        $ret["salads"] = iterator_to_array($salads);
    }
    else {
		$ret["salads"] = "No salads found";
	}
	echo json_encode($ret);
});

//Nutrients
$app->get("/render/getNutrients", function() use ($app){
	$app->render("showNutrients.php");
});

$app->get("/settings/getNutrients", function() {
	$ret = [];
	$ret["status"] = 200;
	
	$db = new MongoWrapperClass("fresho", "nutrient");

    $nutrients = $db->get(array("_id" => 0));
    if($nutrients !== null) {
        $ret["nutrients"] = iterator_to_array($nutrients);
    }
    else {
		$ret["nutrients"] = "No nutrients found";
	}
	echo json_encode($ret);
});

//Statistics
$app->get("/render/getStatistics", function() use ($app){
	$app->render("showStatistics.php");
});

$app->get("/settings/getStatistics", function() {
	$ret = [];
	$ret["status"] = 200;
	
	$db = new MongoWrapperClass("fresho", "user");

    $users = $db->get(array("password" => 0, "_id" => 0));
    if($users !== null) {
        $ret["users"] = iterator_to_array($users);
    }
    else {
		$ret["users"] = "No users found";
	}
	echo json_encode($ret);
});