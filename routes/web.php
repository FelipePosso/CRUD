<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

use App\Http\Controllers\UserController;
use App\User;



$router->get('/', function () use ($router) {
    return $router->app->version();
}); 

$router->get('/users', ['uses' =>'UserController@index']);
$router->post('/users/crear', 'UserController@CreateUser');
$router->post('/users/{id}', 'UserController@ConsultId');
$router->delete('/users/{id}', 'UserController@DeleteUser');
$router->put('/users/{id}', 'UserController@ActualizarUser');
$router->post('/users/LOGIN', ['uses' => 'UserController@login']);

$router->group(['middleware' => 'auth'], function() use ($router){
  
    // aqui van todas las rutas que se necesitar estar autenticado para el acceso
    $router->post('/users/logout', 'LoginController@logout');
  
  });


