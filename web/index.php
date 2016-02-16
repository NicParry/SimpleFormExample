<?php

use SimpleForm\Controller\BasicController;

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(dirname(__FILE__)));

require_once(ROOT . DS . 'vendor' . DS . 'autoload.php');

$controller = new BasicController();
$controller->formAction($_SERVER['REQUEST_METHOD']);