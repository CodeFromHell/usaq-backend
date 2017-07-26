<?php

$app->group('/api', function () {
    $this->group('/user', function () {
        $this->post('/register', [\USaq\Controller\AuthenticationController::class, 'register']);
        $this->post('/login', [\USaq\Controller\AuthenticationController::class, 'login']);
        $this->post('/logout', [\USaq\Controller\AuthenticationController::class, 'logout'])
            ->add(\USaq\Middleware\AuthenticationMiddleware::class);
    });

    $this->group('/user', function () {
        $this->get('/{identifier:[0-9]+}/all', [\USaq\Controller\UserController::class, 'showAllUsers']);
        $this->get('/{identifier:[0-9]+}/friends', [\USaq\Controller\UserController::class, 'showUserFriends']);
        $this->post('/{identifier:[0-9]+}/friends', [\USaq\Controller\UserController::class, 'addUserFriend']);
        $this->delete('/{identifier:[0-9]+}/friends', [\USaq\Controller\UserController::class, 'removeUserFriend']);
    })->add(\USaq\Middleware\PermissionMiddleware::class)
      ->add(\USaq\Middleware\AuthenticationMiddleware::class);

    $this->get('/error[/{identifier:[0-9]+}]', ['USaq\Controller\UtilsController', 'showErrors']);
});
