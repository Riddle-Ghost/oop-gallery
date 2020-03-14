<?php

  return [
    'views_path' => '../app/views',
    'uploadsFolder' => 'uploads/',
    'smtp' => [
        'host' => 'smtp.yandex.ru',
        'port' => 465,
        'crypt' => 'ssl',
        'login' => "info@f96803k4.beget.tech",
        'password' => "123698741",
        'from' => ['info@f96803k4.beget.tech' => 'beget.tech']
    ],
    'db' => [
        'host' => 'localhost',
        'dbname' => 'oop-gallery',
        'user' => 'root',
        'password' => '',
        'charset' => 'utf8',
        'opt' => [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ]
    ],
  ];