<?php
// CORS（Cross-Origin Resource Sharing）ヘッダー設定
// "https://lgqqi65169.rakkoserver.net"からのアクセスを許可
header('Access-Control-Allow-Origin: https://lgqqi65169.rakkoserver.net');
// json形式でデータ送信
header('Content-Type: application/json');

// echo $_SERVER['DOCUMENT_ROOT'];
$directory = $_SERVER['DOCUMENT_ROOT'] . '/work-product/';
$files = scandir($directory);
// var_dump($files);

?>