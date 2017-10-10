<?php

define('BP', __DIR__ . '/');
define('DS', DIRECTORY_SEPARATOR);
define('PS', PATH_SEPARATOR);
define('DEVELOP', true);

// Reset include paths
set_include_path(implode(PS, [
    BP . 'lib/',
    BP . 'src/app/',
    BP . 'src/core/'
]));

// Setup autoloader
spl_autoload_register(function($class) {
    include str_replace('\\', DS, $class) . '.php';
});

// PHP setting for application behaviour
if (DEVELOP) {
    error_reporting(-1);
    ini_set('display_errors', 1);
    ini_set('log_errors', 0);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
    ini_set('log_errors', 1);
    ini_set('error_log', BP . 'var/log/php-error.log');
}

///////////////////////////////

$timeStart = microtime(true);

/** @var Db\Connection $db */
$connection = \Db\Connection::getInstance([
    'host'  => 'localhost',
    'user'  => 'keh',
    'pass'  => 'keh',
    'name'  => 'keh'
]);

/** @var PDO $db */
$db = $connection->getDb();

/** @var PDOStatement $sql */
$sql = $db->prepare('SELECT * FROM `catalog_product_entity_varchar`');
$sql->execute();



// Method 1
//$results = $sql->fetchAll();
//foreach ($results as $result) {
//    echo $result['value'] . PHP_EOL;
//}

// Method 2
while ($result = $sql->fetch()) {
    echo $result['value'] . PHP_EOL;
}








echo PHP_EOL . PHP_EOL . '-------' . PHP_EOL;

$timeEnd = microtime(true);
$total = $timeEnd - $timeStart;

echo 'Executed in ' . sprintf("%01.2f", $total) . ' sec' . PHP_EOL;

$mem = (memory_get_peak_usage(true) / 1024 / 1024);
echo "Memory usage: {$mem} MB" . PHP_EOL;
