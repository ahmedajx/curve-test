<?php

$router->group(['prefix' => 'api'], function () use ($router) {
    $router->get('exchange',  ['uses' => 'ForeignExchangeController@show']);
});
