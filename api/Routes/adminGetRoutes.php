<?php

$app->get("/render/getUsers", function() use ($app){
	$app->render("showUsers.php");
});

$app->get("/settings/getUsers", function() {
	$ret = [];
	$ret["status"] = 200;
	
	$db = new MongoWrapperClass("fresho", "user");

    $users = $db->get();
    if($users !== null) {
        $ret["users"] = iterator_to_array($users);
    }
    else {
		$ret["users"] = "No users found";
	}
	echo json_encode($ret);
});