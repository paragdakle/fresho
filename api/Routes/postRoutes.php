<?php

$app->post('/register/:username/:password', function($username, $password) {
    //1. Decrypt password
    $ori_password = base64_decode($password);
    
	//2. Add user to database

	//return 200 Ok
});

$app->post('/register', function() {

    print_r($_REQUEST);
});
