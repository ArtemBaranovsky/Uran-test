<?php

declare(strict_types=1);
error_reporting(-1);
ini_set('display-errors', '1');

require('Image.php');
require('UploadException.php');
//die('resize');
//var_dump($_GET);
//var_dump($_POST);
//var_dump(ini_get('upload_tmp_dir'));
//var_dump($_FILES['userfile']['name']);
$filePath = ini_get('upload_tmp_dir').DIRECTORY_SEPARATOR.$_FILES['userfile']['name'][0];
//move_uploaded_file($filePath,/*'uploads/'.*/$_FILES['userfile']['name'][0]);
echo("<pre>" . var_dump($_FILES) . "</pre><br/>");
//echo("<pre>" . var_dump($_SERVER) . "</pre>");
//die;

if ($_FILES['userfile']['error'] === UPLOAD_ERR_OK) {
//uploading successfully done
} else {
    throw new Exception($_FILES['userfile']['error']);
//    throw new UploadException($_FILES['file']['error']);
}

try {
    $image = new Image($filePath, $_GET['x-res'],  $_GET['y-res']);
} catch (\Exception $e) {
    $exceptions = [
        'type' => 'danger',
        'message' => $e->getMessage()." at line ".$e->getLine()." of ".$e->getFile(). ", код исключения: " . $e->getCode()
    ];
}

if ($_FILES['file']['error'] === UPLOAD_ERR_OK) {
//uploading successfully done
} else {
    throw new UploadException($_FILES['file']['error']);
}

$response = json_encode(['message' => 'success']);
