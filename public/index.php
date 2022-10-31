<?php

declare(strict_types=1);

/* (c) Copyright Frontify Ltd., all rights reserved. */

require '../src/Controller/ColorController.php';
require '../src/Db/Repository/ColorRepository.php';
require '../config/Database.php';
require '../config/Headers.php';
require '../src/Db/Entity/Color.php';
require_once __DIR__ . '/../vendor/autoload.php';

use Controller\ColorController;
use Sunrise\Http\ServerRequest\ServerRequestFactory;
use Repository\ColorRepository;
use Entity\Color;

$request = ServerRequestFactory::fromGlobals();
$database = new Database();
$repository = new ColorRepository($database->connect(), new Color());
$controller = new ColorController($repository);

$controller->handleRequest($request);
//do it here 3la hasab el route a call files mo3yana
//create php router
//test repo method
