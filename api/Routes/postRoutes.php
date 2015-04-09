<?php

$app->post('/register/:username/:password', function($username, $password) {

    $ret = [];
    $ret["status"] = 400;

    //1. Decrypt password
    $ori_password = base64_decode($password);

    //Connect to db
    $db = new MongoWrapperClass("fresho", "user");

    $user = $db->getOne(array("username" => $username));
    if($user !== null) {
        $ret["error"] = "User already exists!";
    }
    else {
        $user = array("username" => $username, "name" => "", "password" => $password, "mobile_number" => "", "email" => "", "address" => "", "area" => "", "city" => "", "state" => "", "country" => "", "previous_orders" => "", "last_login" => "", "registration_date" => time(), "total_order_count" => 0, "total_order_cost" => 0, "role" => "user");

        $status = $db->insertOne($user);
        
        // send appropritate validation code
        $ret["status"] = 200;
        $ret["message"] = "Registration successful!";
    }

    echo json_encode($ret);

    //See if user is already present  
	//2. Add user to database

	//return 200 Ok
});

$app->post('/register', function() {

    print_r($_REQUEST);
});
