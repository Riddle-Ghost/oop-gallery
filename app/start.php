<?php
session_start();

require_once '../vendor/autoload.php';
require_once __DIR__ . '/helpers.php';

use DI\ContainerBuilder;
use League\Plates\Engine;
use Aura\SqlQuery\QueryFactory;
use Intervention\Image\ImageManager;

$containerBuilder = new containerBuilder;

// Настройка, чтобы созлдавался объект класса ЭНДЖИН с нужным путем в аргументах для коснтруктора
$containerBuilder->addDefinitions([

    Engine::class => function() {

      return new Engine( config('views_path') );
    },
    QueryFactory::class => function() {

      return new QueryFactory('mysql');
    },
    ImageManager::class => function() {

      return new ImageManager( array('driver' => 'gd') );
    }
]);

$container = $containerBuilder->build();

require_once __DIR__ . '/routes.php';