<?php

$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
    
    $r->addRoute(['GET'], '/[{page:\d+}]', ['App\controllers\HomeController', 'main']);

    //Здесь форма регистрации и сама регистрация, после которой надо подтвердить эмейл
    $r->addRoute(['GET', 'POST'], '/register', ['App\controllers\AuthController', 'register']);
    //Здесь подтверждение эмейла
    $r->addRoute(['GET'], '/register/confirm/{selector}/{token}', ['App\controllers\AuthController', 'confirmEmail']);
    //Здесь форма для повторной отправки подтверждения на эмейл и сама отправка
    $r->addRoute(['GET', 'POST'], '/register/resend-confirm', ['App\controllers\AuthController', 'resendConfirmEmail']);
    //Здесь форма с эмейлом (забыл пароль), и отправка на эмейл сообщения, после которого надо подтвердить смену пароля на введенном эмейле
    $r->addRoute(['GET', 'POST'], '/password-reset', ['App\controllers\AuthController', 'passwordReset']);
    //Здесь форма для ввода нового пароля и сама смена пароля
    $r->addRoute(['GET', 'POST'], '/password-reset/{selector}/{token}', ['App\controllers\AuthController', 'confirmPasswordReset']);
    //Здесь форма для логина и само залогинивание
    $r->addRoute(['GET', 'POST'], '/login', ['App\controllers\AuthController', 'login']);
    $r->addRoute(['GET'], '/logout', ['App\controllers\AuthController', 'logOut']);
    

    $r->addRoute(['GET'], '/profile[/{page:\d+}]', ['App\controllers\ProfileController', 'profilePhotos']);
    //Здесь форма смены имени и эмейла и сама смена(эмейл меняется с подтверждением пароля и ссобщением на новый ящик)
    $r->addRoute(['GET', 'POST'], '/profile-info', ['App\controllers\ProfileController', 'profileInfo']);
    //Здесь форма смены пароля и сама смена
    $r->addRoute(['GET', 'POST'], '/profile-security', ['App\controllers\ProfileController', 'profileSecurity']);

    $r->addRoute(['GET'], '/user/{id:\d+}', ['App\controllers\UserController', 'main']);

    $r->addRoute(['GET'], '/category', ['App\controllers\CategoryController', 'main']);
    $r->addRoute(['GET'], '/category/{id:\d+}[/{page:\d+}]', ['App\controllers\CategoryController', 'oneCategory']);

    $r->addRoute(['GET'], '/photo/{id:\d+}', ['App\controllers\PhotosController', 'showPhoto']);
    $r->addRoute(['GET', 'POST'], '/edit-photo/{id:\d+}', ['App\controllers\PhotosController', 'editPhoto']);
    $r->addRoute(['GET'], '/delete-photo/{id:\d+}', ['App\controllers\PhotosController', 'deletePhoto']);

    $r->addRoute(['GET', 'POST'], '/upload', ['App\controllers\UploadController', 'main']);

    $r->addRoute(['GET', 'POST'], '/photos', ['App\controllers\PhotosController', 'photos']);


    $r->addRoute(['GET', 'POST'], '/admin', ['App\controllers\AdminController', 'main']);

    $r->addRoute(['GET'], '/admin/photos', ['App\controllers\AdminController', 'photosMain']);
    $r->addRoute(['GET', 'POST'], '/admin/photos/create', ['App\controllers\AdminController', 'photosCreate']);
    $r->addRoute(['GET', 'POST'], '/admin/photos/edit/{id:\d+}', ['App\controllers\AdminController', 'photosEdit']);
    $r->addRoute(['GET'], '/admin/photos/delete/{id:\d+}', ['App\controllers\AdminController', 'photosDelete']);

    $r->addRoute(['GET'], '/admin/categories', ['App\controllers\AdminController', 'categoriesMain']);
    $r->addRoute(['GET', 'POST'], '/admin/categories/create', ['App\controllers\AdminController', 'categoriesCreate']);
    $r->addRoute(['GET', 'POST'], '/admin/categories/edit/{id:\d+}', ['App\controllers\AdminController', 'categoriesEdit']);
    $r->addRoute(['GET', 'POST'], '/admin/categories/delete/{id:\d+}', ['App\controllers\AdminController', 'categoriesDelete']);
    
    $r->addRoute(['GET'], '/admin/users', ['App\controllers\AdminController', 'usersMain']);
    $r->addRoute(['GET', 'POST'], '/admin/users/create', ['App\controllers\AdminController', 'usersCreate']);
    $r->addRoute(['GET', 'POST'], '/admin/users/edit/{id:\d+}', ['App\controllers\AdminController', 'usersEdit']);
    $r->addRoute(['GET'], '/admin/users/ban/{id:\d+}/{status:\d+}', ['App\controllers\AdminController', 'usersBan']);
    $r->addRoute(['GET'], '/admin/users/role/{id:\d+}/{role:\d+}', ['App\controllers\AdminController', 'usersRole']);
    $r->addRoute(['GET'], '/admin/users/delete/{id:\d+}', ['App\controllers\AdminController', 'usersDelete']);

  });
  
  // Fetch method and URI from somewhere
  $httpMethod = $_SERVER['REQUEST_METHOD'];
  $uri = $_SERVER['REQUEST_URI'];
  
  // Strip query string (?foo=bar) and decode URI
  if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
  }
  $uri = rawurldecode($uri);
  
  $routeInfo = $dispatcher->dispatch($httpMethod, $uri);
  switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        echo '404';exit;
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        echo '405 Method Not Allowed';exit;
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        
        $container->call($handler, $vars);
  
        break;
  }