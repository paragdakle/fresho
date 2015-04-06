<?php

$app->get('/', function(){
    echo 'This is a simple starting page';
});

//The following handles any request to the /hello route

$app->get('/hello', function() use ($app){
    // the following statement invokes and displays the hello.php View
    echo 'Hello World';
});

$app->get('/hello/:name', function($name) use ($app){
    // the following statement invokes and displays the hello.php View
    echo 'Hello World ' . $name . '!';
});
