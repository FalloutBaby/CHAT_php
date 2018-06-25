<?php
session_start();

define(DOCUMENT_ROOT, $_SERVER['DOCUMENT_ROOT'] . '/');
define(ROOT_DIR, DOCUMENT_ROOT . '../');

require_once "../vendor/autoload.php";

use MyApp\App;

$app = new App();
?>
