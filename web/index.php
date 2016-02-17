<?php

use SimpleForm\Controller\BasicController;

require_once('../src/bootstrap.php');

require_once(ROOT . '/vendor/autoload.php');

$templateEngine = new \SimpleForm\Template\TemplateEngine();
$personRepo = new \SimpleForm\Entity\PersonRepo();
$controller = new BasicController($templateEngine, $personRepo);
$controller->formAction($_SERVER['REQUEST_METHOD'], $_POST);