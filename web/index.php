<?php

use SimpleForm\Controller\BasicController;

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(dirname(__FILE__)));

require_once(ROOT . DS . 'vendor' . DS . 'autoload.php');

$templateEngine = new \SimpleForm\Template\TemplateEngine();
$personRepo = new \SimpleForm\Entity\PersonRepo();
$controller = new BasicController($templateEngine, $personRepo);
$controller->formAction($_SERVER['REQUEST_METHOD'], $_POST);