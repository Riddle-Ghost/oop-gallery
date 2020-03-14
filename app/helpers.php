<?php

function config($field) {
    $config = require __DIR__ . '/config.php';
    return $config[$field];
}