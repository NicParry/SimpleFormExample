<?php

use SimpleForm\Controller\BasicController;

require_once('../src/bootstrap.php');

require_once(ROOT . '/vendor/autoload.php');

function stripSlashesDeep($value) {
    $value = is_array($value) ? array_map('stripSlashesDeep', $value) : stripslashes($value);
    return $value;
}

function removeMagicQuotes() {
    if ( get_magic_quotes_gpc() ) {
        $_GET    = stripSlashesDeep($_GET   );
        $_POST   = stripSlashesDeep($_POST  );
        $_COOKIE = stripSlashesDeep($_COOKIE);
    }
}

function unregisterGlobals() {
    if (ini_get('register_globals')) {
        $array = array('_SESSION', '_POST', '_GET', '_COOKIE', '_REQUEST', '_SERVER', '_ENV', '_FILES');
        foreach ($array as $value) {
            foreach ($GLOBALS[$value] as $key => $var) {
                if ($var === $GLOBALS[$key]) {
                    unset($GLOBALS[$key]);
                }
            }
        }
    }
}

removeMagicQuotes();
unregisterGlobals();

$templateEngine = new \SimpleForm\Template\TemplateEngine();
$personRepo = new \SimpleForm\Entity\PersonRepo();
$controller = new BasicController($templateEngine, $personRepo);
$controller->formAction($_SERVER['REQUEST_METHOD'], $_POST);