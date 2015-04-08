<?php

$app->post('/register/:username/:password', function($username, $password) {
	
    echo "Username: " . $username . " Password: " . $password; 
	//1. Decrypt password

	//2. Add user to database

	//return 200 Ok
});

$app->post('/register', function() {

    print_r($_REQUEST);
});
