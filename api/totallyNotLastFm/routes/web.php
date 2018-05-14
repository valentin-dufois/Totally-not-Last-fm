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

$router->get('/', function () use ($router) {
    return $router->app->version();
});


$router->get('/user/{name}', function ($name) {
    return $name;
});

/*******Albums*******/
/*Return all the albums*/
$router->get('/albums', 'AlbumController@index');

/* Add an album 
 Datas : 
 'album_title_album' => 'string'
 'album_nb_tracks' => 'integer'
 */
//$router->post('/albums', 'AlbumController@')