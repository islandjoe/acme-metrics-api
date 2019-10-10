<?php

/**
 * Dopmn - a lightweight Docker+PHP+MySQL+nginx dev framework
 *
 * @package dopmn
 * @author Arthur Kho
 * @link https://github.com/islandjoe/dopmn
 * @license http://opensource.org/licenses/MIT MIT License
 */

// Example: /var/www/html/
define('ROOT', dirname(__DIR__) . DIRECTORY_SEPARATOR);

// Example: /var/www/html/app/
define('APP', ROOT . 'app' . DIRECTORY_SEPARATOR);

require APP . 'vendor/autoload.php';
require APP  . 'src/config.php';

// Start the app
$app = new Dopmn\Core\Application();
