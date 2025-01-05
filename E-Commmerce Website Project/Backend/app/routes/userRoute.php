<?php

use Api\Controllers\UserController;

$router->addRoute('POST', '/api/users/register', [UserController::class, 'register']);
