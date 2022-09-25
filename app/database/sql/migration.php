<?php

define('DB_HOST', '127.0.0.1');
define('DB_USER', 'artem');
define('DB_PASSWORD', 'password');
define('DB_NAME', 'project');

function connectDB() {
    $errorMessage = 'Cant connect to DB';
    $db = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASSWORD);
    if (!$db)
        throw new Exception($errorMessage);
    else {
        $query = $db->query('set names utf8');
        if (!$query)
            throw new Exception($errorMessage);
        else
            return $db;
    }
}

// return files to mirgate
function getMigrationFiles($db) {
    $sqlDir = str_replace('\\', '/', realpath(dirname(__FILE__)). '/');
    $sqlFiles = glob($sqlDir . '*.sql');

    $sql = sprintf('SHOW TABLES FROM `%s` LIKE "versions"', DB_NAME);
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
        array_push($versions, $sqlDir.$row['name']);
    }

    return array_diff($sqlFiles, $versions);
}

// add files to db
function migrate($db, $file) {
    $shell = sprintf('mysql -u%s -p%s -h %s -D %s < %s', DB_USER, DB_PASSWORD, DB_HOST, DB_NAME, $file);
    shell_exec($shell);

    $baseName = basename($file);
    $sql = "INSERT INTO `versions`(`name`) VALUES('$baseName')";
    $db->query($sql);
}

$db = connectDB();
$files = getMigrationFiles($db);

if (empty($files)) {
    echo 'Data base does not need an update';
} else {
    foreach($files as $file) {
        migrate($db, $file);
        echo basename($file). ' ';
    }

    echo '---Mirgation done.';
}

