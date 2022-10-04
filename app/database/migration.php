<?php

use App\Models\DB;

require 'vendor/autoload.php';

(Dotenv\Dotenv::createImmutable(__DIR__ . '\..\..'))->load();

$db = DB::getInstance();
$files = getMigrationFiles($db);

if (empty($files)) {
    echo 'Data base does not need an update';
} else {
    foreach($files as $file) {
        migrate($db, $file);
        echo basename($file) . ' ';
    }

    echo '---Mirgation done.';
}

function getMigrationFiles($db) {
    $sqlDir = str_replace('\\', '/', realpath(dirname(__FILE__)) . '/');
    $sqlFiles = glob($sqlDir . 'sql/*.sql');

    $sql = sprintf('SHOW TABLES FROM `%s` LIKE "versions"', $_ENV['DB_NAME']);
    $query = $db->query($sql);
    $user = $query->fetch(PDO::FETCH_ASSOC);
    $migration = !$user;

    if($migration) {
        return $sqlFiles;
    }

    $versions = array();
    $sql = 'SELECT `name` FROM `versions`';
    $query = $db->query($sql);
    $data= $query->fetchAll(PDO::FETCH_ASSOC);

    foreach($data as $row) {
        array_push($versions, $sqlDir . 'sql/' . $row['name']);
    }

    return array_diff($sqlFiles, $versions);
}

function migrate($db, $file) {
    $sqlFile = file_get_contents($file);
    $sql = "$sqlFile";
    $db->query($sql);

    $baseName = basename($file);
    $sql = "INSERT INTO `versions`(`name`) VALUES('$baseName')";
    $db->query($sql);
}