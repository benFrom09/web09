<?php

use App\Models\User;
use Framework\Mail\Mail;
use Slim\App;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;


return function (App $app) {

    //ROUTES 
    
    //basic hello world route 
    $app->get('/', function (Request $request, Response $response, $args) {
        $response->getBody()->write('Hello slim');
        return $response;
    });

    //basic view exemple route
    $app->get('/example', function (Request $request, Response $response, $args) {
        return view($response,'pages.example',['name' => 'Twig']);
    });

    $app->get('/users',function(Request $request,Response $response,$args) {
        $users = User::all();
        $response->getbody()->write('Test db: username from user table  is ->' .  $users[0]->name);
        return $response;
    });

    $app->get('/mail',function(Request $request,Response $response,$args) {
       $mail = new Mail();
       $data = [
           'to' => 'ben09.dev@gmail.com',
           'subject' => 'Welcome to slim_starter_project',
           'view' => 'email_test',
           'name' => 'jhon doe',
           'body' => 'testing email template'
       ];
       
       if($mail->send($data)) {
           $response->getBody()->write('Email sent succesfully') ;
       } else {
        $response->getBody()->write('Email sending failed!') ;
       }
       
        return $response;
    });
};