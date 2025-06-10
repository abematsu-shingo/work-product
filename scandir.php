<?php
// CORS（Cross-Origin Resource Sharing）ヘッダー設定
// "https://lgqqi65169.rakkoserver.net"からのアクセスを許可
header('Access-Control-Allow-Origin: https://lgqqi65169.rakkoserver.net');
// json形式でデータ送信
header('Content-Type: application/json');

// echo $_SERVER['DOCUMENT_ROOT'];
$directory = $_SERVER['DOCUMENT_ROOT'] . '/work-product/';
// WEB上のルートURL。「$base_url」+「ファイル名」でURLの生成。
$base_url = 'https://lgqqi65169.rakkoserver.net/work-product/';

// ファイルリストを格納する配列
$file_list = [];

$files = scandir($directory);
// var_dump($files);

foreach($files as $file) {
    // var_dump($file);

    $file_url = $base_url . $file;
    // var_dump($file_url);

    // 取得したファイルを配列に格納
    $file_list[] = $file_url;
}
// var_dump($file_url);
var_dump($file_list);

?>