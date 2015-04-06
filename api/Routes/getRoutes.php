<?php

$app->get('/', function(){
    echo 'This is a simple starting page';
});

//The following handles any request to the /hello route

$app->get('/hello', function() use ($app){
    // the following statement invokes and displays the hello.php View
    $app->render('hello.php');
});
